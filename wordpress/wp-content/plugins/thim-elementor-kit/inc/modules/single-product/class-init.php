<?php
namespace Thim_EL_Kit\Modules\SingleProduct;

use Thim_EL_Kit\Custom_Post_Type;
use Thim_EL_Kit\Modules\Modules;
use Thim_EL_Kit\SingletonTrait;

class Init extends Modules {
	use SingletonTrait;

	public function __construct() {
		$this->tab      = 'single-product';
		$this->tab_name = esc_html__( 'Single Product', 'thim-elementor-kit' );
		$this->option   = 'thim_ekits_single_product';

		parent::__construct();

		add_action( 'thim-ekit/modules/single-product/before-preview-query', array( $this, 'before_preview_query' ) );
		add_action( 'thim-ekit/modules/single-product/after-preview-query', array( $this, 'after_preview_query' ) );
		add_action( 'elementor/frontend/before_get_builder_content', array( $this, 'before_get_content' ) );
		add_action( 'elementor/frontend/get_builder_content', array( $this, 'after_get_content' ) );
	}

	public function template_include( $template ) {
		$this->template_include = is_product();

		return parent::template_include( $template );
	}

	public function get_preview_id() {
		global $post;

		$output = false;

		if ( $post ) {
			$document = \Elementor\Plugin::$instance->documents->get( $post->ID );

			if ( $document ) {
				$preview_id = $document->get_settings( 'thim_ekits_preview_id' );

				$output = ! empty( $preview_id ) ? absint( $preview_id ) : false;
			}
		}

		return $output;
	}

	public function before_preview_query() {
		if ( $this->is_editor_preview() || $this->is_modules_view() ) {

			$this->after_preview_query();

			$preview_id = $this->get_preview_id();

			if ( $preview_id ) {
				$query = array(
					'p'         => absint( $preview_id ),
					'post_type' => 'product',
				);
			} else {
				$query_vars = array(
					'post_type'      => 'product',
					'posts_per_page' => 1,
				);

				$posts = get_posts( $query_vars );

				if ( ! empty( $posts ) ) {
					$query = array(
						'p'         => $posts[0]->ID,
						'post_type' => 'product',
					);
				}
			}

			if ( ! empty( $query ) ) {
				\Elementor\Plugin::instance()->db->switch_to_query( $query, true );
			}
		}
	}

	public function after_preview_query() {
		if ( $this->is_editor_preview() || $this->is_modules_view() ) {
			\Elementor\Plugin::instance()->db->restore_current_query();
		}
	}

	public function before_get_content() {
		if ( ! get_the_ID() ) {
			return;
		}

		$type   = get_post_meta( get_the_ID(), Custom_Post_Type::TYPE, true );
		$option = get_option( $this->option, false );

		if ( $type === $this->tab || ! empty( $option ) && is_product() ) {
			global $product;

			if ( ! is_object( $product ) ) {
				$product = wc_get_product( get_the_ID() );
			}

			do_action( 'woocommerce_before_single_product' );
		}
	}

	public function after_get_content() {
		if ( ! get_the_ID() ) {
			return;
		}

		$type   = get_post_meta( get_the_ID(), Custom_Post_Type::TYPE, true );
		$option = get_option( $this->option, false );

		if ( $type === $this->tab || ! empty( $option ) && is_product() ) {
			wp_reset_postdata();

			do_action( 'woocommerce_after_single_product' );
		}
	}
}

Init::instance();

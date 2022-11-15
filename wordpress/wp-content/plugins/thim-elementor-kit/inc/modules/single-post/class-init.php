<?php
namespace Thim_EL_Kit\Modules\SinglePost;

use Thim_EL_Kit\Modules\Modules;
use Thim_EL_Kit\SingletonTrait;

class Init extends Modules {
	use SingletonTrait;

	public function __construct() {
		$this->tab      = 'single-post';
		$this->tab_name = esc_html__( 'Single Post', 'thim-elementor-kit' );
		$this->option   = 'thim_ekits_single_post';

		parent::__construct();

		add_action( 'thim-ekit/modules/single-post/before-preview-query', array( $this, 'before_preview_query' ) );
		add_action( 'thim-ekit/modules/single-post/after-preview-query', array( $this, 'after_preview_query' ) );
	}

	public function template_include( $template ) {
		$this->template_include = is_singular( 'post' );

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
					'post_type' => 'post',
				);
			} else {
				$query_vars = array(
					'post_type'      => 'post',
					'posts_per_page' => 1,
				);

				$posts = get_posts( $query_vars );

				if ( ! empty( $posts ) ) {
					$query = array(
						'p'         => $posts[0]->ID,
						'post_type' => 'post',
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
}

Init::instance();

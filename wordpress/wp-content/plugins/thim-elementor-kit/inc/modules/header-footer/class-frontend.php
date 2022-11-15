<?php
namespace Thim_EL_Kit\Modules\HeaderFooter;

use Thim_EL_Kit\SingletonTrait;
use Thim_EL_Kit\Custom_Post_Type;
use Thim_EL_Kit\Settings;

class FrontEnd {
	use SingletonTrait;

	public $header;

	public $footer;

	public function __construct() {
		add_action( 'wp', array( $this, 'hooks' ) );

		add_action( 'thim_ekit/modules/header_footer/template/header', array( $this, 'render_header' ) );
		add_action( 'thim_ekit/modules/header_footer/template/footer', array( $this, 'render_footer' ) );
		add_action( 'thim_ekit/modules/header_footer/template/attributes', array( $this, 'render_attributes' ) );
	}

	public function override_header() {
		require THIM_EKIT_PLUGIN_PATH . 'inc/modules/header-footer/templates/header.php';

		$templates   = array();
		$templates[] = 'header.php';

		remove_all_actions( 'wp_head' );

		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	public function override_footer() {
		require THIM_EKIT_PLUGIN_PATH . 'inc/modules/header-footer/templates/footer.php';

		$templates   = array();
		$templates[] = 'footer.php';

		// Avoid running wp_footer hooks again.
		remove_all_actions( 'wp_footer' );

		ob_start();
		locate_template( $templates, true );
		ob_get_clean();
	}

	public function render_attributes( string $type = 'header' ) {
		$attributes = array(
			'class' => 'thim-ekit__' . esc_attr( $type ) . '__inner',
		);

		$id = $type === 'header' ? $this->header : $this->footer;

		if ( ! empty( $id ) ) {
			$sticky = get_post_meta( $id, 'thim_elementor_sticky', true );

			if ( $sticky ) {
				$attributes['class'] .= ' thim-ekits__sticky';
			}
		}

		$attributes = apply_filters( 'thim_ekit/modules/header_footer/attributes', $attributes );

		$attributes = array_map( 'esc_attr', $attributes );

		echo \Elementor\Utils::print_html_attributes( $attributes );
	}

	public function render_header() {
		if ( $this->header ) {
			echo \Thim_EL_Kit\Utilities\Elementor::instance()->render_content( $this->header );
		}
	}

	public function render_footer() {
		if ( $this->footer ) {
			echo \Thim_EL_Kit\Utilities\Elementor::instance()->render_content( $this->footer );
		}
	}

	public function hooks() {
		$current_template = basename( get_page_template_slug() );

		if ( $current_template === 'elementor_canvas' ) {
			return;
		}

		$current_theme = get_template();

		// Support for theme-support.

		$header_footer = $this->get_posts();

		if ( ! empty( $header_footer ) ) {
			if ( ! empty( $header_footer['header'] ) && Settings::instance()->get_enable_modules( 'header' ) ) {
				$this->header = absint( $header_footer['header'] );
				\Thim_EL_Kit\Utilities\Elementor::instance()->render_content_css( $this->header );
				add_action( 'get_header', array( $this, 'override_header' ) );
			}

			if ( ! empty( $header_footer['footer'] ) && Settings::instance()->get_enable_modules( 'footer' ) ) {
				$this->footer = absint( $header_footer['footer'] );
				\Thim_EL_Kit\Utilities\Elementor::instance()->render_content_css( $this->footer );
				add_action( 'get_footer', array( $this, 'override_footer' ) );
			}
		}
	}

	protected function get_posts() {
		$arg = array(
			'posts_per_page' => -1,
			'orderby'        => 'id',
			'order'          => 'ASC',
			'post_status'    => 'publish',
			'post_type'      => Custom_Post_Type::CPT,
			'meta_query'     => array(
				array(
					'key'     => 'thim_elementor_type',
					'value'   => array( 'header', 'footer' ),
					'compare' => 'IN',
				),
			),
		);

		$condition = false;

		if ( ( is_archive() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type() ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_archive',
					'value' => true,
				),
				array(
					'relation' => 'AND',
					array(
						'key'     => 'thim_ekits_cond_archiveList',
						'value'   => 'post',
						'compare' => 'LIKE',
					),
				),
			);

			$condition = true;
		} elseif ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_taxonomy() ) ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_archive',
					'value' => true,
				),
				array(
					'relation' => 'AND',
					array(
						'key'     => 'thim_ekits_cond_archiveList',
						'value'   => 'product',
						'compare' => 'LIKE',
					),
				),
			);

			$condition = true;
		} elseif ( class_exists( 'LearnPress' ) && \LP_Page_Controller::page_current() === LP_PAGE_COURSES ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_archive',
					'value' => true,
				),
				array(
					'relation' => 'AND',
					array(
						'key'     => 'thim_ekits_cond_archiveList',
						'value'   => 'lp_course',
						'compare' => 'LIKE',
					),
				),
			);

			$condition = true;
		} elseif ( class_exists( 'RealPress\RealPress' ) && ( is_post_type_archive( 'realpress-property' ) || is_tax( get_object_taxonomies( REALPRESS_PROPERTY_CPT ) ) || is_page( \RealPress\Helpers\Settings::get_page_id( 'agent_list_page' ) ) ) ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_archive',
					'value' => true,
				),
				array(
					'relation' => 'AND',
					array(
						'key'     => 'thim_ekits_cond_archiveList',
						'value'   => REALPRESS_PROPERTY_CPT,
						'compare' => 'LIKE',
					),
				),
			);

			$condition = true;
		} elseif ( is_singular( array( 'post', 'product', 'lp_course', 'realpress-property' ) ) ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_singular',
					'value' => true,
				),
				array(
					'relation' => 'AND',
					array(
						'key'     => 'thim_ekits_cond_singularList',
						'value'   => is_singular( 'post' ) ? 'post' : ( is_singular( 'product' ) ? 'product' : ( is_singular( 'realpress-property' ) ? 'realpress-property' : 'lp_course' ) ),
						'compare' => 'LIKE',
					),
				),
			);

			$condition = true;
		} elseif ( is_404() ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_404',
					'value' => true,
				),
			);

			$condition = true;
		} elseif ( class_exists( 'RealPress\RealPress' ) && \RealPress\Helpers\Page::is_agent_detail_page() ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_realpress-agent',
					'value' => true,
				),
			);

			$condition = true;
		} elseif ( is_page() ) {
			$arg['meta_query'][] = array(
				'relation' => 'AND',
				array(
					'key'   => 'thim_ekits_cond_page',
					'value' => true,
				),
			);

			$condition = true;
		}

		$output = array();

		// Entire page.
		$entire_posts = get_posts(
			array(
				'posts_per_page' => -1,
				'orderby'        => 'id',
				'order'          => 'ASC',
				'post_status'    => 'publish',
				'post_type'      => Custom_Post_Type::CPT,
				'meta_query'     => array(
					array(
						'key'     => 'thim_elementor_type',
						'value'   => array( 'header', 'footer' ),
						'compare' => 'IN',
					),
					array(
						'key'   => 'thim_ekits_cond_entire',
						'value' => true,
					),
				),
			)
		);

		if ( ! empty( $entire_posts ) ) {
			foreach ( $entire_posts as $post ) {
				$type = get_post_meta( $post->ID, 'thim_elementor_type', true );

				if ( $type === 'header' ) {
					$output['header'] = $post->ID;
					continue;
				}

				if ( $type === 'footer' ) {
					$output['footer'] = $post->ID;
					continue;
				}
			}
		}

		if ( ! $condition ) {
			return $output;
		}

		$posts = get_posts( $arg );

		if ( ! empty( $posts ) ) {
			foreach ( $posts as $post ) {
				$type = get_post_meta( $post->ID, 'thim_elementor_type', true );

				if ( is_page() ) {
					$pages = get_post_meta( $post->ID, 'thim_ekits_cond_pageList', true );

					if ( ! empty( $pages ) ) {
						$get_page_id = get_the_ID();

						if ( ! empty( $get_page_id ) ) {
							$get_page = get_post( $get_page_id );

							if ( ! in_array( $get_page->post_name, $pages ) ) {
								continue;
							}
						}
					}
				}

				if ( $type === 'header' ) {
					$output['header'] = $post->ID;
					continue;
				}

				if ( $type === 'footer' ) {
					$output['footer'] = $post->ID;
					continue;
				}
			}
		}

		return $output;
	}
}

FrontEnd::instance();

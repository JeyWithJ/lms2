<?php
namespace Thim_EL_Kit\Modules\HeaderFooter;

use Thim_EL_Kit\SingletonTrait;
use Thim_EL_Kit\Custom_Post_Type;
use Thim_EL_Kit\Rest_API;
use Thim_EL_Kit\Settings;

class Init {
	use SingletonTrait;

	public function __construct() {
		$this->includes();

		add_filter( 'thim_ekit/post_type/register_tabs', array( $this, 'add_admin_tabs' ) );
		add_filter( 'thim_ekit/admin/enqueue/localize', array( $this, 'add_localization' ) );
		add_filter( 'thim_ekit/post_type/admin_columns_headers', array( $this, 'admin_columns_headers' ), 10 );
		add_action( 'manage_' . Custom_Post_Type::CPT . '_posts_custom_column', array( $this, 'admin_columns_content' ), 10, 2 );
		add_filter( 'get_edit_post_link', array( $this, 'change_edit_post_link' ), 10, 3 );
	}

	public function includes() {
		if ( ! is_admin() ) {
			require_once THIM_EKIT_PLUGIN_PATH . 'inc/modules/header-footer/class-frontend.php';
		}
	}

	public function add_admin_tabs( $tabs ) {
		if ( Settings::instance()->get_enable_modules( 'header' ) ) {
			$tabs['header'] = array(
				'name' => esc_html__( 'Header', 'thim-elementor-kit' ),
				'url'  => add_query_arg(
					array(
						'post_type'            => Custom_Post_Type::CPT,
						Custom_Post_Type::TYPE => 'header',
					),
					admin_url( 'edit.php' )
				),
			);
		}

		if ( Settings::instance()->get_enable_modules( 'footer' ) ) {
			$tabs['footer'] = array(
				'name' => esc_html__( 'Footer', 'thim-elementor-kit' ),
				'url'  => add_query_arg(
					array(
						'post_type'            => Custom_Post_Type::CPT,
						Custom_Post_Type::TYPE => 'footer',
					),
					admin_url( 'edit.php' )
				),
			);
		}

		return $tabs;
	}

	public function is_current_screen() {
		return isset( $_GET[ Custom_Post_Type::TYPE ] ) && in_array( sanitize_text_field( wp_unslash( $_GET[ Custom_Post_Type::TYPE ] ) ), array( 'header', 'footer' ) );
	}

	public function admin_columns_headers( array $columns ) : array {
		if ( ! $this->is_current_screen() ) {
			return $columns;
		}

		$column      = $columns['shortcode'];
		$date_column = $columns['date'];

		unset( $columns['shortcode'] );

		unset( $columns['date'] );

		$columns['conditions'] = esc_html__( 'Conditions', 'thim-elementor-kit' );
		$columns['shortcode']  = $column;
		$columns['date']       = $date_column;

		return $columns;
	}

	public function admin_columns_content( string $column_name, int $post_id ) {
		if ( ! $this->is_current_screen() ) {
			return;
		}

		switch ( $column_name ) {
			case 'conditions':
				$conditions = Rest_API::instance()->get_condition_meta( $post_id );
				$output     = $this->admin_columns_content_html( $conditions );

				echo '<ul class="ul-disc" style="margin: 0">' . wp_kses_post( implode( ' ', $output ) ) . '</ul>';
				break;
		}
	}

	public function admin_columns_content_html( $conditions ) {
		$output = array();
		if ( ! empty( $conditions ) ) {
			if ( is_array( $conditions ) ) {
				foreach ( $conditions as $key => $condition ) {
					$condi = $this->add_localization( array() );

					if ( ! is_array( $condition ) ) {
						$keys           = array_search( $key, array_column( $condi['conditions'], 'value' ) );
						$output[ $key ] = '<li>' . esc_html( $condi['conditions'][ $keys ]['label'] ) . '</li>';
					} elseif ( in_array( $key, array( 'archiveList', 'singularList' ) ) ) {
						$output[ $key ] = '';
						foreach ( $condition as $post_type ) {
							$keys            = array_search( $post_type, array_column( $condi['condition']['post_type'], 'value' ) );
							$output[ $key ] .= '<li style="margin-left: 1.8em">' . esc_html( $condi['condition']['post_type'][ $keys ]['label'] ) . '</li>';
						}
					} elseif ( $key === 'pageList' ) {
						$output[ $key ] = '';
						foreach ( $condition as $slug ) {
							$page = get_page_by_path( $slug );

							if ( ! $page ) {
								continue;
							}

							$output[ $key ] .= '<li style="margin-left: 1.8em"><a href="' . get_the_permalink( $page->ID ) . '">' . esc_html( $page->post_title ) . '</a></li>';
						}
					}
				}
			}
		}

		return $output;
	}

	public function change_edit_post_link( $url, $id, $context ) {
		$post = get_post( $id );

		if ( ! $post ) {
			return;
		}

		if ( $post->post_type !== Custom_Post_Type::CPT ) {
			return $url;
		}

		$type = get_post_meta( $id, 'thim_elementor_type', true );

		if ( ! in_array( $type, array( 'header', 'footer' ) ) ) {
			return $url;
		}

		$args = array(
			'post_type'    => Custom_Post_Type::CPT,
			'thim_post_id' => $id,
		);

		if ( isset( $_GET[ Custom_Post_Type::TYPE ] ) ) {
			$args[ Custom_Post_Type::TYPE ] = sanitize_text_field( wp_unslash( $_GET[ Custom_Post_Type::TYPE ] ) );
		}
		$url = add_query_arg( $args, admin_url( 'edit.php' ) );

		return $url . '#edit_header_footer';
	}

	public function add_localization( $data ) {
		$data['conditions'] = array(
			array(
				'key'   => 'entire',
				'value' => 'entire',
				'label' => esc_html__( 'Entire Site', 'thim-elementor-kit' ),
			),
			array(
				'key'   => 'archive',
				'value' => 'archive',
				'label' => esc_html__( 'Archive', 'thim-elementor-kit' ),
			),
			array(
				'key'   => 'singular',
				'value' => 'singular',
				'label' => esc_html__( 'Singular', 'thim-elementor-kit' ),
			),
			array(
				'key'   => 'page',
				'value' => 'page',
				'label' => esc_html__( 'Select Page', 'thim-elementor-kit' ),
			),
			array(
				'key'   => '404',
				'value' => '404',
				'label' => esc_html__( '404 Page', 'thim-elementor-kit' ),
			),
		);

		$data['condition']['post_type'] = array(
			array(
				'key'   => 'post',
				'value' => 'post',
				'label' => esc_html__( 'Post', 'thim-elementor-kit' ),
			),
		);

		if ( class_exists( 'WooCommerce' ) ) {
			$data['condition']['post_type'][] = array(
				'key'   => 'product',
				'value' => 'product',
				'label' => esc_html__( 'Product', 'thim-elementor-kit' ),
			);
		}

		if ( class_exists( 'LearnPress' ) ) {
			$data['condition']['post_type'][] = array(
				'key'   => 'lp_course',
				'value' => 'lp_course',
				'label' => esc_html__( 'LearnPress Course', 'thim-elementor-kit' ),
			);
		}

		if ( class_exists( 'RealPress\RealPress' ) ) {
			$data['condition']['post_type'][] = array(
				'key'   => REALPRESS_PROPERTY_CPT,
				'value' => REALPRESS_PROPERTY_CPT,
				'label' => esc_html__( 'RealPress Property', 'thim-elementor-kit' ),
			);

			$data['conditions'][] = array(
				'key'   => 'realpress-agent',
				'value' => 'realpress-agent',
				'label' => esc_html__( 'RealPress Agent', 'thim-elementor-kit' ),
			);
		}

		return $data;
	}
}

Init::instance();

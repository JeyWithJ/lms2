<?php
namespace Thim_EL_Kit\Modules;

use Thim_EL_Kit\Custom_Post_Type;

abstract class Modules {
	public $tab = '';

	public $tab_name = '';

	public $option = '';

	public $template_include = '';

	public function __construct() {
		add_filter( 'thim_ekit/post_type/register_tabs', array( $this, 'add_admin_tabs' ) );
		add_filter( 'post_row_actions', array( $this, 'filter_post_row_actions' ), 12, 2 );
		add_filter( 'thim_ekit/modules/show_label_active', array( $this, 'show_label_active' ), 10, 2 );
		add_action( 'manage_posts_extra_tablenav', array( $this, 'manage_posts_extra_tablenav' ), 10 );
		add_action( 'parse_query', array( $this, 'admin_post_filter' ) );
		add_filter( 'thim_ekit/post_type/single_template/override', array( $this, 'override_single_template' ), 10, 2 );
		add_filter( 'template_include', array( $this, 'template_include' ), 12 ); // after Elementor and WooCommerce.
	}

	public function add_admin_tabs( $tabs ) {
		if ( ! empty( $this->tab ) ) {
			$tabs[ $this->tab ] = array(
				'name' => $this->tab_name,
				'url'  => add_query_arg(
					array(
						'post_type'            => Custom_Post_Type::CPT,
						Custom_Post_Type::TYPE => $this->tab,
					),
					admin_url( 'edit.php' )
				),
			);
		}

		return $tabs;
	}

	public function show_label_active( $active, $post_id ) {
		if ( empty( $post_id ) || empty( $this->option ) ) {
			return $active;
		}

		$option = get_option( $this->option, false );

		if ( ! empty( $option ) && absint( $option ) === absint( $post_id ) ) {
			$active = true;
		}

		return $active;
	}

	public function filter_post_row_actions( $actions, $post ) {
		if ( ! $this->is_current_screen() || empty( $this->option ) ) {
			return $actions;
		}

		$option     = get_option( $this->option, false );
		$is_options = ! empty( $option ) && absint( $option ) === absint( $post->ID ) ? true : false;

		$url = add_query_arg(
			array(
				'thim_set_templatekits' => $is_options ? 'delete' : 'add',
				'thim_post_id'          => $post->ID,
			),
			Custom_Post_Type::instance()->tabs[ $this->tab ]['url']
		);

		$actions['thim_set_template_kits'] = sprintf(
			'<a href="%1$s">%2$s%3$s</a>',
			esc_url( $url ),
			$is_options ? esc_html__( 'Remove ', 'thim-elementor-kit' ) : esc_html__( 'Set ', 'thim-elementor-kit' ),
			$this->tab_name
		);

		return $actions;
	}


	public function manage_posts_extra_tablenav( $which ) {
		if ( ! $this->is_current_screen() ) {
			return;
		}

		$id = get_option( $this->option, false );

		if ( $which === 'top' && $id ) {
			$title  = get_the_title( $id );
			$edit   = '<a href="' . add_query_arg(
				array(
					'post'   => $id,
					'action' => 'elementor',
				),
				admin_url( 'post.php' )
			) . '">' . esc_html__( 'Edit with Elementor', 'thim-elementor-kit' ) . '</a>';
			$remove = '<a href="' . add_query_arg(
				array(
					'thim_set_templatekits' => 'delete',
				),
				Custom_Post_Type::instance()->tabs[ $this->tab ]['url']
			) . '">' . esc_html__( 'Disable', 'thim-elementor-kit' ) . '</a>';

			echo '<span class="thim-ekit__tablenav-active">' . sprintf( '<strong>%1$s</strong>: %2$s - %3$s | %4$s', esc_html__( 'Active', 'thim-elementor-kit' ), esc_html( $title ), $edit, $remove ) . '</span>';
		}
	}

	public function admin_post_filter( $query ) {
		if ( ! $this->is_current_screen() ) {
			return;
		}

		$archive_post = ! empty( $_REQUEST['thim_set_templatekits'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['thim_set_templatekits'] ) ) : false;
		$post_id      = ! empty( $_REQUEST['thim_post_id'] ) ? absint( wp_unslash( $_REQUEST['thim_post_id'] ) ) : false;

		if ( ! $archive_post ) {
			return;
		}

		$archive = get_option( $this->option, false );

		if ( $archive_post === 'delete' ) {
			update_option( $this->option, false );
			// change options in customizer
			set_theme_mod( $this->option . '_tpl', '' );
		}

		if ( $archive_post === 'add' && $post_id ) {
			update_option( $this->option, $post_id );
			// change options in customizer
			set_theme_mod( $this->option . '_tpl', 'ekits_tpl' );
		}

		$url = add_query_arg(
			array(
				'post_type'            => Custom_Post_Type::CPT,
				Custom_Post_Type::TYPE => $this->tab,
			),
			admin_url( 'edit.php' )
		);

		wp_redirect( $url );
		exit;
	}

	public function elementor_template() {
		$elementor_modules = \Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' );
		$template          = $elementor_modules->get_template_path( $elementor_modules::TEMPLATE_HEADER_FOOTER );

		return apply_filters( 'thim_ekit/modules/elementor_template', $template, $this->tab );
	}

	/** Override for Elementor Editor */
	public function override_single_template( $template, $post ) {
		if ( apply_filters( 'thim_ekit/modules/override_single_template', false, $this->tab ) ) {
			return $template;
		}

		$type = get_post_meta( $post->ID, Custom_Post_Type::TYPE, true );

		if ( $post->post_type === Custom_Post_Type::CPT && $type === $this->tab ) {
			$template = $this->elementor_template();

			if ( file_exists( $template ) ) {
				return $template;
			}
		}

		return $template;
	}

	public function is_current_screen() {
		if ( ! empty( $this->tab ) ) {
			$type = ! empty( $_REQUEST[ Custom_Post_Type::TYPE ] ) ? sanitize_text_field( wp_unslash( $_REQUEST[ Custom_Post_Type::TYPE ] ) ) : false;

			return Custom_Post_Type::instance()->is_current_screen() && $type && $type === $this->tab;
		}

		return true;
	}

	public function template_include( $template ) {
		if ( apply_filters( 'thim_ekit/modules/template_include', false, $this->tab ) ) {
			return $template;
		}

		if ( ! empty( $this->template_include ) && $this->template_include ) {
			$post_id = get_option( $this->option, false );

			if ( ! empty( $post_id ) ) {
				$elementor_modules = \Elementor\Plugin::$instance->modules_manager->get_modules( 'page-templates' );

				$template = $this->elementor_template();

				$elementor_modules->set_print_callback(
					function() use ( $post_id ) {
						echo \Elementor\Plugin::instance()->frontend->get_builder_content( absint( $post_id ), false );
						return true;
					}
				);
			}

			return $template;
		}

		return $template;
	}

	public function is_modules_view() {
		return isset( $_GET['thim_elementor_kit'] );
	}

	public function is_editor_preview() {
		return \Elementor\Plugin::$instance->editor->is_edit_mode() || \Elementor\Plugin::$instance->preview->is_preview_mode() || is_preview();
	}
}

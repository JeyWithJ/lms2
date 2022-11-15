<?php
require THIM_DIR . 'inc/admin/thim-core-installer/installer.php';

if ( class_exists( 'TP' ) ) {
	require THIM_DIR . 'inc/admin/plugins-require.php';
	require THIM_DIR . 'inc/admin/customizer-options.php';
 	require_once( THIM_DIR . 'inc/widgets/login-popup/login-popup.php' );
}

require_once THIM_DIR . 'inc/widgets/shortcodes.php';
require_once THIM_DIR . 'inc/widgets/class-el-extend.php';

require THIM_DIR . 'inc/libs/Tax-meta-class/Tax-meta-class.php';

require THIM_DIR . 'inc/tax-meta.php';

//Filter meta-box
add_filter( 'thim_metabox_display_settings', 'thim_add_metabox_settings', 100, 2 );
if ( ! function_exists( 'thim_add_metabox_settings' ) ) {

	function thim_add_metabox_settings( $meta_box, $prefix ) {
		if ( defined( 'THIM_CORE_VERSION' ) && version_compare( THIM_CORE_VERSION, '1.0.3', '>' ) ) {
			if ( isset( $_GET['post'] ) ) {
				if ( $_GET['post'] == get_option( 'page_on_front' ) || $_GET['post'] == get_option( 'page_for_posts' ) ) {
					return false;
				}
			}
		}

		$meta_box['post_types'] = array( 'page', 'post', 'lp_course', 'our_team', 'testimonials', 'product', 'tp_event', 'portfolio' );


		$prefix                      = 'thim_mtb_';
		$meta_box['tabs']['related'] = array(
			'label' => __( 'Related posts', 'eduma' ),
		);
		$meta_box['tabs']            = array(
			'title'  => array(
				'label' => __( 'Featured Title Area', 'eduma' ),
				'icon'  => 'dashicons-admin-appearance',
			),
			'layout' => array(
				'label' => __( 'Layout', 'eduma' ),
				'icon'  => 'dashicons-align-left',
			),
		);

		$meta_box['fields'] = array(
			/**
			 * Custom Title and Subtitle.
			 */
			array(
				'name' => __( 'Custom Title and Subtitle', 'thim-core' ),
				'id'   => $prefix . 'using_custom_heading',
				'type' => 'checkbox',
				'std'  => false,
				'tab'  => 'title',
			),
			array(
				'name'   => __( 'Hide Title and Subtitle', 'thim-core' ),
				'id'     => $prefix . 'hide_title_and_subtitle',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Custom Title', 'thim-core' ),
				'id'     => $prefix . 'custom_title',
				'type'   => 'text',
				'desc'   => __( 'Leave empty to use post title', 'thim-core' ),
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Color Title', 'thim-core' ),
				'id'     => $prefix . 'text_color',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Subtitle', 'thim-core' ),
				'id'     => 'thim_subtitle',
				'type'   => 'text',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Color Subtitle', 'thim-core' ),
				'id'     => $prefix . 'color_sub_title',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Hide Breadcrumbs', 'thim-core' ),
				'id'     => $prefix . 'hide_breadcrumbs',
				'type'   => 'checkbox',
				'std'    => false,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),

			array(
				'name'             => __( 'Background Image', 'thim-core' ),
				'id'               => $prefix . 'top_image',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'tab'              => 'title',
				'hidden'           => array( $prefix . 'using_custom_heading', '!=', true ),
			),
			array(
				'name'   => __( 'Background color', 'thim-core' ),
				'id'     => $prefix . 'bg_color',
				'type'   => 'color',
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),
			array(
				'name'   => __( 'Background color opacity', 'thim-core' ),
				'id'     => $prefix . 'bg_opacity',
				'type'   => 'number',
				'desc'	=> __( 'input color opacity: Ex: 0.1 ', 'thim-core' ),
				'std'    => 1,
				'step'   => '0.1',
				'min'    => 0,
				'max'    => 1,
				'hidden' => array( $prefix . 'using_custom_heading', '!=', true ),
				'tab'    => 'title',
			),

			/**
			 * Custom layout
			 */
			array(
				'name' => __( 'Use Custom Layout', 'thim-core' ),
				'id'   => $prefix . 'custom_layout',
				'type' => 'checkbox',
				'tab'  => 'layout',
				'std'  => false,
			),
			array(
				'name'    => __( 'Select Layout', 'thim-core' ),
				'id'      => $prefix . 'layout',
				'type'    => 'image_select',
				'options' => array(
					'sidebar-left'  => THIM_URI . 'images/layout/sidebar-left.jpg',
					'full-content'  => THIM_URI . 'images/layout/body-full.jpg',
					'sidebar-right' => THIM_URI . 'images/layout/sidebar-right.jpg',
					'full-width'    => THIM_URI . 'images/layout/content-full.jpg',
				),
				'default' => 'sidebar-right',
				'tab'     => 'layout',
				'hidden'  => array( $prefix . 'custom_layout', '=', false ),
			),
			array(
				'name' => __( 'No Padding Content', 'thim-core' ),
				'id'   => $prefix . 'no_padding',
				'type' => 'checkbox',
				'std'  => false,
				'tab'  => 'layout',
			),
		);

		return $meta_box;
	}
}


/**
 * List child themes.
 *
 * @return array
 */
function thim_eduma_list_child_themes() {
	return array(
		'eduma-child'              => array(
			'name'       => 'Eduma Child',
			'slug'       => 'eduma-child',
			'screenshot' => 'https://plugins.thimpress.com/downloads/images/eduma-child.png',
			'source'     => 'https://github.com/ThimPressWP/demo-data/raw/master/eduma/child-themes/eduma-child/eduma-child.zip',
			'version'    => '1.0.0'
		),
 	);
}

add_filter( 'thim_core_list_child_themes', 'thim_eduma_list_child_themes' );

/**
 * @param $settings
 *
 * @return array
 */
if ( ! function_exists( 'thim_import_add_basic_settings' ) ) {
	function thim_import_add_basic_settings( $settings ) {
		$settings[] = 'learn_press_archive_course_limit';
		// $settings[] = 'siteorigin_panels_settings';
		$settings[] = 'thim_enable_mega_menu';
		//$settings[] = 'wpb_js_margin';
		//$settings[] = 'users_can_register';
		//$settings[] = 'permalink_structure';
		//$settings[] = 'wpb_js_use_custom';

		// Elementor global settings
		// $settings[] = 'elementor_container_width';
		// $settings[] = 'elementor_space_between_widgets';
		$settings[] = 'learn_press_course_thumbnail_dimensions';
		$settings[] = 'thim_ekits_widget_settings';
		$settings[] = 'elementor_css_print_method';
		$settings[] = 'elementor_experiment-e_font_icon_svg';
		return $settings;
	}
}
add_filter( 'thim_importer_basic_settings', 'thim_import_add_basic_settings' );
add_filter( 'thim_importer_thim_enable_mega_menu', '__return_true' );

/**
 * @param $settings
 *
 * @return array
 */
if ( ! function_exists( 'thim_import_add_page_id_settings' ) ) {
	function thim_import_add_page_id_settings( $settings ) {
		$settings[] = 'learn_press_courses_page_id';
		$settings[] = 'learn_press_profile_page_id';
		$settings[] = 'elementor_active_kit';
		return $settings;
	}
}
add_filter( 'thim_importer_page_id_settings', 'thim_import_add_page_id_settings' );

//Add info for Dashboard Admin
if ( ! function_exists( 'thim_eduma_links_guide_user' ) ) {
	function thim_eduma_links_guide_user() {
		return array(
			'docs'      => 'http://docspress.thimpress.com/eduma/',
			'support'   => 'https://thimpress.com/forums/forum/eduma/',
			'knowledge' => 'https://thimpress.com/knowledge-base/',
		);
	}
}
add_filter( 'thim_theme_links_guide_user', 'thim_eduma_links_guide_user' );

/**
 * Link purchase theme.
 */
if ( ! function_exists( 'thim_eduma_link_purchase' ) ) {
	function thim_eduma_link_purchase() {
		return 'https://1.envato.market/G5Ook';
	}
}
add_filter( 'thim_envato_link_purchase', 'thim_eduma_link_purchase' );

/**
 * Envato id.
 */
if ( ! function_exists( 'thim_eduma_envato_item_id' ) ) {
	function thim_eduma_envato_item_id() {
		return '14058034';
	}
}
add_filter( 'thim_envato_item_id', 'thim_eduma_envato_item_id' );

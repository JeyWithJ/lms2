<?php

namespace Elementor;

use Elementor\Group_Control_Image_Size;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'THIM_ELEMENTOR_TESTIMONIAL_STYLE_PATH', THIM_EKIT_PLUGIN_PATH . 'inc/elementor/widgets/global/testimonial/' );

class Thim_Ekit_Widget_Testimonial extends Widget_Base {

	public function get_name() {
		return 'thim-ekits-testimonial';
	}

	public function get_title() {
		return esc_html__( 'Thim Testimonial', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-testimonial';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY );
	}

	public function get_base() {
		return basename( __FILE__, '.php' );
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section',
			array(
				'label' => esc_html__( 'Testimonial', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Choose layout', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default'        => esc_html__( 'Default', 'thim-elementor-kit' ),
					'thumbs-gallery' => esc_html__( 'Thumbs Gallery', 'thim-elementor-kit' ),
				),
			)
		);

		$this->add_control(
			'quote_icon_enable',
			array(
				'label'        => esc_html__( 'Enable Quote Icon', 'thim-elementor-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'    => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'quote_icon',
			array(
				'label'       => esc_html__( 'Quote Icon', 'thim-elementor-kit' ),
				'label_block' => false,
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'condition'   => array(
					'quote_icon_enable' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'quote_icon_position_offset_x',
			array(
				'label'      => esc_html__( 'Left', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => - 1600,
						'max'  => 1600,
						'step' => 1,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon' => 'left: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'quote_icon_enable' => 'yes',
				),
			)
		);

		$this->add_responsive_control(
			'quote_icon_position_offset_y',
			array(
				'label'      => esc_html__( 'Top', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => - 1600,
						'max'  => 1600,
						'step' => 1,
					),
					'%'  => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon' => 'top: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'quote_icon_enable' => 'yes',
				),
			)
		);

		$this->add_control(
			'separetor',
			array(
				'label'     => esc_html__( 'Show Separator', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off' => esc_html__( 'No', 'thim-elementor-kit' ),
				'default'   => 'no',
				'condition' => array(
					'layout' => array( 'thumbs-gallery' ),
				),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'client_name',
			array(
				'label'       => esc_html__( 'Client Name', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Tony Chester', 'thim-elementor-kit' ),
				'label_block' => true,
			)
		);

		$repeater->add_control(
			'client_position',
			array(
				'label'       => esc_html__( 'Position', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'Front-end Developer',
			)
		);

		$repeater->add_control(
			'client_content',
			array(
				'label'       => esc_html__( 'Testimonial Review', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::WYSIWYG,
				'label_block' => true,
				'default'     => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
			)
		);

		$repeater->add_control(
			'link',
			array(
				'label'       => esc_html__( 'Link', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::URL,
				'placeholder' => esc_url( 'https://thimpress.com', 'thim-elementor-kit' ),
			)
		);

		$repeater->add_control(
			'client_avatar',
			array(
				'label'     => esc_html__( 'Client Avatar', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::MEDIA,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'data',
			array(
				'label'       => esc_html__( 'Testimonial', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'default'     => array(
					array( 'client_name' => esc_html__( 'Tony Chester', 'thim-elementor-kit' ) ),
					array( 'client_name' => esc_html__( 'Jay Adams', 'thim-elementor-kit' ) ),
					array( 'client_name' => esc_html__( 'Jay Johnson ', 'thim-elementor-kit' ) ),
				),

				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ client_name }}}',
			)
		);

		$this->end_controls_section();

		$this->register_style_layout();

		$this->register_style_wrapper_content();

		$this->register_style_client_info();

		$this->_register_style_thumb_gallery();

		$this->register_style_quote_icon();

		$this->register_style_separetor();

		$this->_register_settings_slider();

		$this->_register_setting_slider_dot_style();

		$this->_register_setting_slider_nav_style();
	}

	protected function _register_settings_slider() {
		// setting slider section

		$this->start_controls_section(
			'skin_slider_settings',
			array(
				'label' => esc_html__( 'Settings Slider', 'thim-elementor-kit' ),
			)
		);
		$this->add_responsive_control(
			'slidesPerView',
			array(
				'label'              => esc_html__( 'Item Show', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 20,
				'step'               => 1,
				'default'            => 3,
				'frontend_available' => true,
				'devices'            => array( 'widescreen', 'desktop', 'tablet', 'mobile' ),
				'selectors'          => array(
					'{{WRAPPER}} .thim-ekits-testimonial__avatars .thim-ekits-testimonial__avatar' => 'width: calc(100%/{{VALUE}} - {{spaceBetween.VALUE}}px);',
					'{{WRAPPER}}' => '--thim-ekits-slider-show: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'slidesPerGroup',
			array(
				'label'              => esc_html__( 'Item Scroll', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 20,
				'step'               => 1,
				'default'            => 3,
				'devices'            => array( 'widescreen', 'desktop', 'tablet', 'mobile' ),
				'condition'          => array(
					'layout' => 'default',
				),
				'frontend_available' => true,
			)
		);
		$this->add_responsive_control(
			'spaceBetween',
			array(
				'label'              => esc_html__( 'Item Space', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => - 50,
				'max'                => 100,
				'step'               => 1,
				'default'            => 30,
				'frontend_available' => true,
				'devices'            => array( 'widescreen', 'desktop', 'tablet', 'mobile' ),
				'selectors'          => array(
					'{{WRAPPER}}' => '--thim-ekits-slider-space: {{VALUE}}px',
				),
			)
		);
		$this->add_control(
			'slider_speed',
			array(
				'label'              => esc_html__( 'Speed', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 1,
				'max'                => 10000,
				'step'               => 1,
				'default'            => 1000,
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'slider_autoplay',
			array(
				'label'              => esc_html__( 'Autoplay', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'pause_on_interaction',
			array(
				'label'              => esc_html__( 'Pause on Interaction', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'default'            => 'yes',
				'frontend_available' => true,
				'condition'          => array(
					'slider_autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'              => esc_html__( 'Pause on Hover', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'default'            => 'yes',
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'frontend_available' => true,
				'condition'          => array(
					'slider_autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'centered_slides',
			array(
				'label'              => esc_html__( 'Centered Slides', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'default'            => 'no',
				'frontend_available' => true,
			)
		);

		$this->add_control(
			'slider_show_arrow',
			array(
				'label'              => esc_html__( 'Show Arrow', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			)
		);
		$this->add_control(
			'slider_show_pagination',
			array(
				'label'              => esc_html__( 'Pagination Options', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SELECT,
				'default'            => 'none',
				'options'            => array(
					'none'     => esc_html__( 'Hide', 'thim-elementor-kit' ),
					'bullets'  => esc_html__( 'Bullets', 'thim-elementor-kit' ),
					'number'   => esc_html__( 'Number', 'thim-elementor-kit' ),
					// 'progressbar' => esc_html__( 'Progress', 'thim-elementor-kit' ),
					// 'scrollbar'   => esc_html__( 'Scrollbar', 'thim-elementor-kit' ),
					'fraction' => esc_html__( 'Fraction', 'thim-elementor-kit' ),
				),
				'frontend_available' => true,
				'condition'          => array(
					'layout' => 'default',
				),
			)
		);

		$this->add_control(
			'slider_loop',
			array(
				'label'              => esc_html__( 'Enable Loop?', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SWITCHER,
				'label_on'           => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'          => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value'       => 'yes',
				'default'            => '',
				'frontend_available' => true,
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_layout() {
		$this->start_controls_section(
			'layout_section',
			array(
				'label' => esc_html__( 'Layout', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'layout_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1600,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__inner' => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'layout_spacing',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'layout_border',
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__inner',
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'layout_background',
				'label'    => esc_html__( 'Background', 'thim-elementor-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__inner',
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_wrapper_content() {
		$this->start_controls_section(
			'wrapper_content_section',
			array(
				'label' => esc_html__( 'Wrapper content', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'wrapper_content_align',
			array(
				'label'     => esc_html__( 'Alignment', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'thim-elementor-kit' ),
						'icon'  => 'eicon-text-align-center',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article,{{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article,{{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'wrapper_content_spacing',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article,{{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'wrapper_content_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article,{{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'wrapper_content_background',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article, {{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'angular',
			array(
				'label'        => esc_html__( 'Show Angular', 'thim-elementor-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off'    => esc_html__( 'No', 'thim-elementor-kit' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => array(
					'layout' => 'default',
				),
				'selectors'    => array(
					'{{WRAPPER}}' => '--thim-ekits-show-angular: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'angular_position_offset_x',
			array(
				'label'      => esc_html__( 'Left', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1000,
						'step' => 1,
					),
					'%'  => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'condition'  => array(
					'layout'  => 'default',
					'angular' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-angular-left: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'angular_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 85,
				),
				'condition'  => array(
					'layout'  => 'default',
					'angular' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-angular-width: {{SIZE}}{{UNIT}};',
				),

			)
		);

		$this->add_responsive_control(
			'angular_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 45,
				),
				'condition'  => array(
					'layout'  => 'default',
					'angular' => 'yes',
				),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-angular-height: {{SIZE}}{{UNIT}};',
				),

			)
		);

		$this->add_control(
			'angular_background',
			array(
				'label'     => esc_html__( 'Background Angular', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'layout'  => 'default',
					'angular' => 'yes',
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-angular-show: block;--thim-ekits-angular-background: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'wrapper_content_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__article,{{WRAPPER}} .thim-ekits-testimonial__article-avatar-left_client_name .thim-ekits-testimonial__client-content',
			)
		);
		$this->end_controls_section();
	}

	protected function register_style_client_info() {
		// client style
		$this->start_controls_section(
			'client_content_section',
			array(
				'label' => esc_html__( 'Client Info', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'client_avatar_heading',
			array(
				'label' => esc_html__( 'Client Avatar', 'thim-elementor-kit' ),
				'type'  => Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'avatar_layout',
			array(
				'label'     => esc_html__( 'Avatar Position', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'default',
				'condition' => array(
					'layout' => 'default',
				),
				'options'   => array(
					'default'                 => esc_html__( 'Default', 'thim-elementor-kit' ),
					'avatar_left_content'     => esc_html__( 'Left Content', 'thim-elementor-kit' ),
					'avatar_left_client_name' => esc_html__( 'Left Client Name ', 'thim-elementor-kit' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'    => 'client_avatar_size',
				'default' => 'medium',
			)
		);

		$this->add_control(
			'client_avatar_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-testimonial__image-border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'client_client_avatar_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__image'        => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .thim-ekits-testimonial__image:before' => 'top: {{TOP}}{{UNIT}}; right: {{RIGHT}}{{UNIT}} ; bottom: {{BOTTOM}}{{UNIT}} ; left: {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'client_avatar_margin_bottom',
			array(
				'label'     => esc_html__( 'Margin Bottom', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => - 200,
						'max' => 200,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__avatar ' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'client_avatar_item_background',
				'label'    => esc_html__( 'Background', 'thim-elementor-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__image:before',
			)
		);

		$this->add_control(
			'client_name_heading',
			array(
				'label'     => esc_html__( 'Client Name', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'client_name_display',
			array(
				'label'     => esc_html__( 'Display', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'block'        => array(
						'title' => esc_html__( 'Default', 'thim-elementor-kit' ),
						'icon'  => 'eicon-editor-list-ul',
					),
					'inline-block' => array(
						'title' => esc_html__( 'Inline', 'thim-elementor-kit' ),
						'icon'  => 'eicon-ellipsis-h',
					),
				),
				'default'   => 'block',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__name' => 'display: {{VALUE}};',
				),
			)
		);

		$this->start_controls_tabs(
			'client_name_color_tabs'
		);

		$this->start_controls_tab(
			'client_name_color_tab',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'client_name_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__name' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'client_name_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__name',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'client_name_color_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'client_name_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__name:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'client_name_typography_hover',
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__name:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'client_name_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'client_name_transform',
			array(
				'label'     => esc_html__( 'Transform Y', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__name' => 'transform: translateY( {{SIZE}}{{UNIT}} )',
				),
				'condition' => array(
					'layout'              => 'default',
					'client_name_display' => 'inline-block',
				),
			)
		);

		$this->add_control(
			'client_position_heading',
			array(
				'label'     => esc_html__( 'Client Position', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'client_position_display',
			array(
				'label'     => esc_html__( 'Display', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'block'        => array(
						'title' => esc_html__( 'Default', 'thim-elementor-kit' ),
						'icon'  => 'eicon-editor-list-ul',
					),
					'inline-block' => array(
						'title' => esc_html__( 'Inline', 'thim-elementor-kit' ),
						'icon'  => 'eicon-ellipsis-h',
					),
				),
				'default'   => 'block',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__position' => 'display: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'position_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__position' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'position_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__position',
			)
		);

		$this->add_responsive_control(
			'position_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__position' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'position_margin_transform',
			array(
				'label'     => esc_html__( 'Transform Y', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min' => - 100,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__position' => 'transform: translateY( {{SIZE}}{{UNIT}} )',
				),
				'condition' => array(
					'layout'                  => 'default',
					'client_position_display' => 'inline-block',
				),
			)
		);

		$this->add_control(
			'client_title_heading',
			array(
				'label'     => esc_html__( 'Client Title', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'client_content_heading',
			array(
				'label'     => esc_html__( 'Client Description', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'client_content_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__client-content' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'client_content_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__client-content',
			)
		);

		$this->add_control(
			'client_content_position',
			array(
				'label'   => esc_html__( 'Position', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::CHOOSE,
				'default' => 'bottom',
				'options' => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
			)
		);

		$this->add_responsive_control(
			'client_content_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__client-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function _register_style_thumb_gallery() {
		$this->start_controls_section(
			'gallery_section',
			array(
				'label'     => esc_html__( 'Gallery Setting', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'layout' => 'thumbs-gallery',
				),
			)
		);

		$this->add_responsive_control(
			'gallery_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 1600,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__avatars' => 'max-width: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'gallery_position',
			array(
				'label'     => esc_html__( 'Gallery Position', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::CHOOSE,
				'default'   => 'column',
				'options'   => array(
					'column'         => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'column-reverse' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-avatar-position: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'client_gallery_spacing',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__avatars' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'client_gallery_item_setting_tab'
		);

		$this->start_controls_tab(
			'client_gallery_item_style',
			array(
				'label' => esc_html__( 'Default', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'client_gallery_item_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__image' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'client_gallery_item_border',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__image',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'client_gallery_item_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-ekits-testimonial__image',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'client_gallery_item_active_style',
			array(
				'label' => esc_html__( 'Active', 'thim-elementor-kit' ),
			)
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'client_gallery_item_active_bg',
				'label'    => esc_html__( 'Background', 'thim-elementor-kit' ),
				'types'    => array( 'classic', 'gradient' ),
				'exclude'  => array( 'image' ),
				'selector' => '{{WRAPPER}} .swiper-slide-active .thim-ekits-testimonial__image:before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'client_gallery_item_active_border',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .swiper-slide-active .thim-ekits-testimonial__image',
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'client_gallery_item_active_box_shadow',
				'label'    => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .swiper-slide-active .thim-ekits-testimonial__image',
			)
		);

		$this->add_responsive_control(
			'client_gallery_item_active_opacity',
			array(
				'label'     => esc_html__( 'Opacity', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 1,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .swiper-slide-active .thim-ekits-testimonial__image' => 'opacity: {{SIZE}};',
				),
			)
		);

		$this->add_responsive_control(
			'client_gallery_item_scale',
			array(
				'label'     => esc_html__( 'Scale', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 2,
						'step' => 0.1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .swiper-slide-active .thim-ekits-testimonial__image' => 'transition: all 0.2s; z-index: 1; transform: scale({{SIZE}});',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_quote_icon() {
		$this->start_controls_section(
			'section_icon_style',
			array(
				'label'     => esc_html__( 'Quote Icon', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'quote_icon_enable' => 'yes',
				),
			)
		);

		$this->start_controls_tabs(
			'client_icon_color_tabs'
		);

		$this->start_controls_tab(
			'client_icon_normal_color_tab',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);
		$this->add_responsive_control(
			'section_icon_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'section_icon_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-quote-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'client_icon_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'section_bg_icon_hover_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article:hover .thim-ekits-testimonial__quote-icon' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'section_icon_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-quote-hover-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_responsive_control(
			'icon_quoc_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);
		$this->add_responsive_control(
			'section_icon_quoc_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'section_icon_typography',
			array(
				'label'      => esc_html__( 'Icon Size', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon > i'   => 'font-size: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .thim-ekits-testimonial__quote-icon > svg' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_separetor() {
		$this->start_controls_section(
			'separetor_tab',
			array(
				'label'     => esc_html__( 'Separetor', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'separetor' => 'yes',
					'layout'    => array( 'thumbs-gallery' ),
				),
			)
		);

		$this->start_controls_tabs(
			'_separetor_color_tabs'
		);

		$this->start_controls_tab(
			'separetor_normal_color_tab',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'separator_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2ec4b6',
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__separetor:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'separetor_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'separator_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#2ec4b6',
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-testimonial__article:hover .thim-ekits-testimonial__separetor:before' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'separator_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 300,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 2,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__separetor:before' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'separator_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 20,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__separetor:before' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'separator_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-testimonial__separetor:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function _register_setting_slider_dot_style() {
		// dot style
		$this->start_controls_section(
			'slider_dot_tab',
			array(
				'label'     => esc_html__( 'Pagination', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'slider_show_pagination!' => 'none',
				),
			)
		);
		$this->add_control(
			'slider_dot_offset_orientation',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'center',
				'options'     => array(
					'start'  => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-center',
					),
					'end'    => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-pagination' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_pagination_vertical_offset',
			array(
				'label'       => esc_html__( 'Vertical align', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'max'         => 500,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-pagination' => '-webkit-transform: translateY({{VALUE}}px); -ms-transform: translateY({{SIZE}}px); transform: translateY({{SIZE}}px);',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 12,
				),
				'condition'  => array(
					'slider_show_pagination' => array( 'bullets', 'number' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-pagination' => '--thim-pagination-space: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'pagination_number_typography',
				'condition' => array(
					'slider_show_pagination' => 'number',
				),
				'selector'  => '{{WRAPPER}} .thim-number .swiper-pagination-bullet',
			)
		);

		$this->add_responsive_control(
			'pagination_number_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'condition'  => array(
					'slider_show_pagination' => 'number',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);

		$this->add_responsive_control(
			'slider_dot_border_radius',
			array(
				'label'      => esc_html__( 'Border radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'condition'  => array(
					'slider_show_pagination' => 'bullets',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_border',
			array(
				'label'     => esc_html_x( 'Border Type', 'Border Control', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'none'   => esc_html__( 'None', 'thim-elementor-kit' ),
					'solid'  => esc_html_x( 'Solid', 'Border Control', 'thim-elementor-kit' ),
					'double' => esc_html_x( 'Double', 'Border Control', 'thim-elementor-kit' ),
					'dotted' => esc_html_x( 'Dotted', 'Border Control', 'thim-elementor-kit' ),
					'dashed' => esc_html_x( 'Dashed', 'Border Control', 'thim-elementor-kit' ),
					'groove' => esc_html_x( 'Groove', 'Border Control', 'thim-elementor-kit' ),
				),
				'condition' => array(
					'slider_show_pagination' => array( 'bullets', 'number' ),
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => array(
					'slider_dot_active_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'dot_setting_tab',
			array(
				'condition' => array(
					'slider_show_pagination' => array( 'bullets', 'number' ),
				),
			)
		);

		$this->start_controls_tab(
			'dot_slider_style',
			array(
				'label' => esc_html__( 'Default', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'slider_dot_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 6,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet' => 'width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'slider_show_pagination' => 'bullets',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 6,
				),
				'condition'  => array(
					'slider_show_pagination' => 'bullets',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet' => 'height: {{SIZE}}{{UNIT}};',
					// '{{WRAPPER}} .thim-progressbar,{{WRAPPER}} .thim-scrollbar' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_background',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'background-color: {{VALUE}}; opacity: 1;',
					// '{{WRAPPER}} .swiper-pagination-progressbar,{{WRAPPER}} .thim-scrollbar' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_pagination_number',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'slider_show_pagination' => 'number',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'slider_pagination_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'slider_dot_active_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'dot_slider_active_style',
			array(
				'label' => esc_html__( 'Active', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 8,
				),
				'condition'  => array(
					'slider_show_pagination' => 'bullets',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_dot_active_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 8,
				),
				'condition'  => array(
					'slider_show_pagination' => 'bullets',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_active_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'background-color: {{VALUE}};',
					// '{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,{{WRAPPER}} .thim-scrollbar .swiper-scrollbar-drag'                                 => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'slider_pagination_number_active',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'slider_show_pagination' => 'number',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-number .swiper-pagination-bullet:hover,{{WRAPPER}} .thim-number .swiper-pagination-bullet.swiper-pagination-bullet-active' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'slider_dot_active_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'slider_dot_active_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	protected function _register_setting_slider_nav_style() {
		$this->start_controls_section(
			'slider_nav_style_tab',
			array(
				'label'     => esc_html__( 'Nav', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'slider_show_arrow' => 'yes',
				),
			)
		);

		$this->start_controls_tabs(
			'slider_nav_group_tabs'
		);

		$this->start_controls_tab(
			'slider_nav_prev_tab',
			array(
				'label' => esc_html__( 'Prev', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'slider_arrows_left',
			array(
				'label'       => esc_html__( 'Prev Arrow Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => array(
					'value'   => 'fas fa-arrow-left',
					'library' => 'Font Awesome 5 Free',
				),
			)
		);

		$this->add_control(
			'prev_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'left',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
			)
		);
		$this->add_responsive_control(
			'prev_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav-prev' => '{{prev_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'slider_nav_next_tab',
			array(
				'label' => esc_html__( 'Next', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'slider_arrows_right',
			array(
				'label'       => esc_html__( 'Next Arrow Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'default'     => array(
					'value'   => 'fas fa-arrow-right',
					'library' => 'Font Awesome 5 Free',
				),
			)
		);

		$this->add_control(
			'next_offset_orientation_h',
			array(
				'label'       => esc_html__( 'Horizontal Orientation', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'right',
				'options'     => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'next_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav-next' => '{{next_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'slider_nav_offset_position_v',
			array(
				'label'       => esc_html__( 'Vertical Position', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => '50',
				'options'     => array(
					'0'   => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'50'  => array(
						'title' => esc_html__( 'Middle', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-middle',
					),
					'100' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav' => 'top:{{VALUE}}%;',
				),
			)
		);
		$this->add_responsive_control(
			'slider_nav_vertical_offset',
			array(
				'label'       => esc_html__( 'Vertical align', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 500,
				'max'         => 500,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-nav' => '-webkit-transform: translateY({{VALUE}}px); -ms-transform: translateY({{SIZE}}px); transform: translateY({{SIZE}}px);',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_font_size',
			array(
				'label'      => esc_html__( 'Font Size', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 36,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-nav' => 'font-size: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-nav' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-nav' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slider_nav_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 50,
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-slider-nav' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'slider_nav_hover_normal_tabs'
		);

		$this->start_controls_tab(
			'slider_nav_normal_tab',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'slider_nav_color_normal',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#fff',
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-nav' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_normal',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-nav' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow_normal',
				'label'    => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border_normal',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'slider_nav_hover_tab',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_responsive_control(
			'slider_nav_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-nav:hover' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_responsive_control(
			'slider_nav_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-nav:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'slider_nav_box_shadow_hover',
				'label'    => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav:hover',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'slider_nav_border_hover',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-slider-nav:hover',
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		if ( $settings['slider_show_pagination'] != 'none' ) : ?>
			<div class="thim-slider-pagination <?php echo 'thim-' . esc_attr( $settings['slider_show_pagination'] ); ?>"></div>
			<?php
		endif;

		if ( $settings['slider_show_arrow'] ) :
			?>
			<div class="thim-slider-nav thim-slider-nav-prev">
				<?php Icons_Manager::render_icon( $settings['slider_arrows_left'], array( 'aria-hidden' => 'true' ) ); ?>
			</div>

			<div class="thim-slider-nav thim-slider-nav-next">
				<?php Icons_Manager::render_icon( $settings['slider_arrows_right'], array( 'aria-hidden' => 'true' ) ); ?>
			</div>
			<?php
		endif;

		if ( $settings['layout'] == 'thumbs-gallery' ) {
			$this->render_content_gallery( $settings );
		} else {
			$this->render_content_default( $settings );
		}
	}

	public function render_content_default( $settings ) {
		$testimonials = $settings['data'];

		if ( ! is_array( $testimonials ) && empty( $testimonials ) ) {
			return;
		}

		$class_article = ( $settings['avatar_layout'] == 'avatar_left_client_name' ) ? '-avatar-left_client_name' : '';
		$class_wrapper = ( $settings['avatar_layout'] == 'avatar_left_content' ) ? ' thim-ekits-testimonial__avatar-left-content' : '';
		?>
		<div
			class="thim-ekits-testimonial__inner thim-ekits-sliders swiper-container<?php echo esc_attr( $class_wrapper ); ?>">
			<div class="thim-ekits-testimonial__content swiper-wrapper">
				<?php foreach ( $testimonials as $key => $testimonial ) : ?>
					<div class="thim-ekits-testimonial__article<?php echo esc_attr( $class_article ); ?> swiper-slide">
						<?php
						$show_avatar = true;
						if ( $settings['avatar_layout'] == 'avatar_left_content' ) {
							$this->render_client_avatar( $settings, $testimonial );
							$show_avatar = false;
						}
						?>
						<div class="thim-ekits-testimonial__inner_client">
							<?php
							if ( $settings['client_content_position'] == 'top' ) {
								$this->render_client_content( $testimonial );
							}
							?>

							<?php if ( $show_avatar ) : ?>
								<div class="wrapper-client-info">
								<?php $this->render_client_avatar( $settings, $testimonial ); ?>
							<?php endif; ?>
								<div class="thim-ekits-testimonial__client-info">
									<?php $this->render_client_name( $key, $testimonial ); ?>
									<?php $this->render_client_position( $testimonial ); ?>
								</div>
							<?php if ( $show_avatar ) : ?>
								</div>
							<?php endif; ?>

							<?php
							if ( $settings['client_content_position'] == 'bottom' || $settings['client_content_position'] == '' ) {
								$this->render_client_content( $testimonial );
							}
							?>
						</div>
						<?php $this->render_client_quote_icon( $settings ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

		<?php
	}

	public function render_content_gallery( $settings ) {
		$testimonials = $settings['data'];
		if ( ! is_array( $testimonials ) && empty( $testimonials ) ) {
			return;
		}
		?>
		<div class="thim-ekits-testimonial__inner thim-ekits-thumb-gallery">
			<div class="thim-ekits-testimonial__avatars thim-ekits-sliders swiper-container">
				<div class="thim-ekits-testimonial__avatars-swapper swiper-wrapper">
					<?php
					foreach ( $testimonials as $testimonial ) {
						$this->render_client_avatar( $settings, $testimonial, 'swiper-slide' );
					}
					?>
				</div>
			</div>

			<?php if ( $settings['separetor'] == 'yes' ) : ?>
				<div class="thim-ekits-testimonial__separetor"></div>
			<?php endif; ?>

			<div class="thim-ekits-testimonial__content thim-ekits-gallery-thumbs swiper-container">
				<div class="thim-ekits-testimonial__content-swapper swiper-wrapper">
					<?php foreach ( $testimonials as $key => $testimonial ) { ?>
						<div class="thim-ekits-testimonial__article swiper-slide">
							<?php
							if ( $settings['client_content_position'] == 'top' ) {
								$this->render_client_content( $testimonial );
							}
							?>

							<div class="thim-ekits-testimonial__client-info">
								<?php
								$this->render_client_name( $key, $testimonial );

								$this->render_client_position( $testimonial );
								?>
							</div>

							<?php
							if ( $settings['client_content_position'] == 'bottom' || $settings['client_content_position'] == '' ) {
								$this->render_client_content( $testimonial );
							}
							?>

						</div>
					<?php } ?>
				</div>
			</div>

			<?php $this->render_client_quote_icon( $settings ); ?>
		</div>

		<?php
	}

	protected function render_client_avatar( $settings, $item, $class = '' ) {
		if ( ! empty( $item['client_avatar'] ) ) {
			$settings['client_avatar'] = $item['client_avatar'];
			?>
			<div class="thim-ekits-testimonial__avatar <?php echo esc_attr( $class ); ?>">
				<div class="thim-ekits-testimonial__image">
					<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $settings, 'client_avatar_size', 'client_avatar' ) ); ?>
				</div>
			</div>
			<?php
		}
	}

	protected function render_client_content( $settings ) {
		if ( ! empty( $settings['client_content'] ) ) :
			?>
			<div class="thim-ekits-testimonial__client-content">
				<?php echo wp_kses_post( $settings['client_content'] ); ?>
			</div>
		<?php endif; ?>
		<?php
	}

	protected function render_client_name( $key, $settings ) {
		if ( ! empty( $settings['client_name'] ) ) {
			if ( ! empty( $settings['link']['url'] ) ) {
				$this->add_link_attributes( 'client_name-url-' . esc_attr( $key ), $settings['link'] );
				$before_client_name = '<a ' . Utils::print_unescaped_internal_string( $this->get_render_attribute_string( 'client_name-url-' . esc_attr( $key ) ) ) . ' class="thim-ekits-testimonial__name">';
				$after_client_name  = '</a>';
			} else {
				$before_client_name = '<p class="thim-ekits-testimonial__name">';
				$after_client_name  = '</p>';
			}
			echo wp_kses_post( $before_client_name ) . esc_html( $settings['client_name'] ) . wp_kses_post( $after_client_name );
		}
	}

	protected function render_client_position( $settings ) {
		if ( ! empty( $settings['client_position'] ) ) {
			echo '<div class="thim-ekits-testimonial__position" >' . esc_html( $settings['client_position'] ) . '</div>';
		}
	}

	protected function render_client_quote_icon( $settings ) {
		if ( $settings['quote_icon_enable'] != 'yes' ) {
			return;
		}
		?>
		<div class="thim-ekits-testimonial__quote-icon">
			<?php \Elementor\Icons_Manager::render_icon( $settings['quote_icon'], array( 'aria-hidden' => 'true' ) ); ?>
		</div>
		<?php
	}
}

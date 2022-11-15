<?php

namespace Elementor;

// use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;

class Thim_Ekit_Widget_List_Course extends Thim_Ekits_Course_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}
	public function get_name() {
		return 'thim-ekits-list-course';
	}

	public function get_title() {
		return esc_html__( 'Thim Course', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-archive-posts';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY );
	}

	public function get_help_url() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Options', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'course_skin',
			array(
				'label'   => esc_html__( 'Skin', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'thim-elementor-kit' ),
					'tab'     => esc_html__( 'Tab', 'thim-elementor-kit' ),
					'slider'  => esc_html__( 'Slider', 'thim-elementor-kit' ),
				),
			)
		);

		$this->add_control(
			'cat_id',
			array(
				'label'    => esc_html__( 'Select Category', 'thim-elementor-kit' ),
				'type'     => Controls_Manager::SELECT2,
				'multiple' => true,
				'options'  => \Thim_EL_Kit\Elementor::get_cat_taxonomy( 'course_category' ),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order by', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'recent' => esc_html__( 'Date', 'thim-elementor-kit' ),
					'title'  => esc_html__( 'Title', 'thim-elementor-kit' ),
					'random' => esc_html__( 'Random', 'thim-elementor-kit' ),
				),
				'default' => 'recent',
			)
		);

		$this->add_control(
			'order',
			array(
				'label'   => esc_html__( 'Order by', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'asc'  => esc_html__( 'ASC', 'thim-elementor-kit' ),
					'desc' => esc_html__( 'DESC', 'thim-elementor-kit' ),
				),
				'default' => 'asc',
			)
		);

		$this->add_control(
			'number_posts',
			array(
				'label'   => esc_html__( 'Number Post', 'thim-elementor-kit' ),
				'default' => '4',
				'type'    => Controls_Manager::NUMBER,
			)
		);

		$this->add_responsive_control(
			'columns',
			array(
				'label'          => esc_html__( 'Columns', 'thim-elementor-kit' ),
				'type'           => Controls_Manager::SELECT,
				'default'        => '3',
				'tablet_default' => '2',
				'mobile_default' => '1',
				'options'        => array(
					'1' => '1',
					'2' => '2',
					'3' => '3',
					'4' => '4',
					'5' => '5',
					'6' => '6',
				),
				'selectors'      => array(
					'{{WRAPPER}}' => '--thim-ekits-course-columns: repeat({{VALUE}}, 1fr)',
				),
				'condition'      => array(
					'course_skin' => array( 'default', 'tab' ),
				),
			)
		);

		$this->end_controls_section();

		parent::register_controls();
		$this->_register_style_layout();

		$this->_register_setting_slider();
		$this->_register_style_course_tab();
		$this->_register_setting_slider_dot_style();
		$this->_register_setting_slider_nav_style();

	}

	protected function _register_style_layout() {
		$this->start_controls_section(
			'section_design_layout',
			array(
				'label'     => esc_html__( 'Layout', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'course_skin!' => 'slider',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'              => esc_html__( 'Columns Gap', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::SLIDER,
				'default'            => array(
					'size' => 30,
				),
				'range'              => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'frontend_available' => true,
				'selectors'          => array(
					'{{WRAPPER}}' => '--thim-ekits-course-column-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'row_gap',
			array(
				'label'     => esc_html__( 'Rows Gap', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 35,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-course-row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}
	protected function _register_style_course_tab() {
		$this->start_controls_section(
			'section_style_course_tab',
			array(
				'label'     => esc_html__( 'Course Tab', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'course_skin' => 'tab',
				),
			)
		);

		$this->add_responsive_control(
			'course_tab_align',
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
				'default'   => 'right',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'course_tab_item_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 120,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs' => 'margin: 0 0 {{SIZE}}{{UNIT}} 0',
				),
				'default'   => array(
					'size' => 80,
				),
			)
		);

		$this->add_responsive_control(
			'course_tab_item_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 0,
					'left'   => 50,
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'course_tab_item_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'top'    => 0,
					'right'  => 0,
					'bottom' => 10,
					'left'   => 0,
					'unit'   => 'px',
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		// start tab for content
		$this->start_controls_tabs(
			'course_style_tabs_item'
		);

		// start normal tab
		$this->start_controls_tab(
			'tab_item_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'tab_item_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_bg',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tab_item_border',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-course-tabs .nav-tabs li a',
			)
		);

		$this->end_controls_tab();
		// end normal tab

		// start active tab
		$this->start_controls_tab(
			'tab_item_style_active',
			array(
				'label' => esc_html__( 'Active', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'tab_item_text_color_active',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a:hover,{{WRAPPER}} .thim-course-tabs .nav-tabs li.active a' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'tab_item_bg_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a:hover,{{WRAPPER}} .thim-course-tabs .nav-tabs li.active a' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'tab_item_border_active',
				'label'    => esc_html__( 'Border', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-course-tabs .nav-tabs li a:hover,{{WRAPPER}} .thim-course-tabs .nav-tabs li.active a',
			)
		);

		$this->end_controls_tab();
		// end hover tab

		$this->end_controls_tabs();

		$this->add_control(
			'tab_item_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-course-tabs .nav-tabs li a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_item_typography',
				'label'    => esc_html__( 'Typography', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-course-tabs .nav-tabs li a',
			)
		);

		$this->end_controls_section();
	}

	protected function _register_setting_slider() {
		// setting slider section

		$this->start_controls_section(
			'skin_slider_settings',
			array(
				'label'     => esc_html__( 'Settings Slider', 'thim-elementor-kit' ),
				'condition' => array(
					'course_skin' => 'slider',
				),
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
					'{{WRAPPER}}' => '--thim-ekits-slider-show: {{VALUE}}',
				),
				'mobile_default'     => '2',
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
				'frontend_available' => true,
			)
		);

		$this->add_responsive_control(
			'spaceBetween',
			array(
				'label'              => esc_html__( 'Item Space', 'thim-elementor-kit' ),
				'type'               => Controls_Manager::NUMBER,
				'min'                => 0,
				'max'                => 100,
				'step'               => 1,
				'default'            => 30,
				'frontend_available' => true,
				'mobile_default'     => '15',
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
				'default'            => 'no',
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

		$this->add_responsive_control(
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
					'none'        => esc_html__( 'Hide', 'thim-elementor-kit' ),
					'bullets'     => esc_html__( 'Bullets', 'thim-elementor-kit' ),
					'number'      => esc_html__( 'Number', 'thim-elementor-kit' ),
					'progressbar' => esc_html__( 'Progress', 'thim-elementor-kit' ),
					'scrollbar'   => esc_html__( 'Scrollbar', 'thim-elementor-kit' ),
					'fraction'    => esc_html__( 'Fraction', 'thim-elementor-kit' ),
				),
				'frontend_available' => true,
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

	protected function _register_setting_slider_dot_style() {
		// dot style
		$this->start_controls_section(
			'slider_dot_tab',
			array(
				'label'     => esc_html__( 'Pagination', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'course_skin'             => 'slider',
					'slider_show_pagination!' => 'none',
				),
			)
		);

		$this->add_control(
			'slider_pagination_offset_position_v',
			array(
				'label'       => esc_html__( 'Vertical Position', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => '100',
				'options'     => array(
					'0'   => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'100' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}} .thim-slider-pagination' => 'top:{{VALUE}}%;',
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
					'slider_show_pagination' => array( 'bullets', 'number' ),
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
					'slider_show_pagination' => array( 'bullets', 'number', 'progressbar', 'scrollbar' ),
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
					'slider_show_pagination' => array( 'bullets', 'progressbar', 'scrollbar' ),
				),
				'selectors'  => array(
					'{{WRAPPER}} .thim-bullets .swiper-pagination-bullet'       => 'height: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}} .thim-progressbar,{{WRAPPER}} .thim-scrollbar' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'slider_dot_background',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet'          => 'background-color: {{VALUE}}; opacity: 1;',
					'{{WRAPPER}} .swiper-pagination-progressbar,{{WRAPPER}} .thim-scrollbar' => 'background-color: {{VALUE}};',
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
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'slider_dot_border_radius_box_shadow_normal',
				'label'     => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet',
				'condition' => array(
					'slider_show_pagination' => array( 'bullets', 'number' ),
				),
			)
		);
		// $this->add_group_control(
		// Group_Control_Border::get_type(),
		// [
		// 'name'      => 'slider_dot_border',
		// 'label'     => esc_html__( 'Border', 'thim-elementor-kit' ),
		// 'condition'  => [
		// 'slider_show_pagination' => [ 'bullets', 'number' ]
		// ],
		// 'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet',
		// ]
		// );

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
					'{{WRAPPER}} .swiper-pagination-progressbar .swiper-pagination-progressbar-fill,{{WRAPPER}} .thim-scrollbar .swiper-scrollbar-drag'                                 => 'background: {{VALUE}};',
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
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'      => 'slider_dot_border_radius_box_shadow_active',
				'label'     => esc_html__( 'Box Shadow', 'thim-elementor-kit' ),
				'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover',
				'condition' => array(
					'slider_show_pagination' => array( 'bullets', 'number' ),
				),
			)
		);
		// $this->add_group_control(
		// Group_Control_Border::get_type(),
		// [
		// 'name'      => 'slider_dot_active_border',
		// 'label'     => esc_html__( 'Border', 'thim-elementor-kit' ),
		// 'condition' => [
		// 'slider_show_pagination' => [ 'bullets', 'number' ]
		// ],
		// 'selector'  => '{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet.swiper-pagination-bullet-active,{{WRAPPER}} .thim-slider-pagination .swiper-pagination-bullet:hover',
		// ]
		// );

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
					'course_skin'       => 'slider',
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

	public function render() {
		$settings   = $this->get_settings_for_display();
		$query_args = array(
			'post_type'           => 'lp_course',
			'posts_per_page'      => $settings['number_posts'],
			'order'               => ( 'asc' == $settings['order'] ) ? 'asc' : 'desc',
			'ignore_sticky_posts' => true,
		);

		switch ( $settings['orderby'] ) {
			case 'recent':
				$query_args['orderby'] = 'post_date';
				break;
			case 'title':
				$query_args['orderby'] = 'post_title';
				break;
			default: // random
				$query_args['orderby'] = 'rand';
		}

		if ( $settings['course_skin'] == 'tab' ) {
			$this->render_course_tab( $settings, $query_args );
		} else {
			if ( $settings['cat_id'] ) {
				$query_args['tax_query'] = array(
					array(
						'taxonomy' => 'course_category',
						'field'    => 'term_id',
						'terms'    => $settings['cat_id'],
					),
				);
			}

			$the_query        = new \WP_Query( $query_args );
			$class            = 'thim-ekits-course';
			$class_inner      = 'thim-ekits-course__inner';
			$class_item       = 'thim-ekits-course__item';
			$hiden_nav_mobile = '';

			if ( $the_query->have_posts() ) {
				if ( isset( $settings['course_skin'] ) && $settings['course_skin'] == 'slider' ) {
					$class      .= ' thim-ekits-sliders swiper-container';
					$class_inner = 'swiper-wrapper';
					$class_item .= ' swiper-slide';

					if ( $settings['slider_show_pagination'] != 'none' ) :
						$hiden_nav_mobile = ' hidden-nav-mobile';
						?>

						<div class="thim-slider-pagination <?php echo esc_attr( 'thim-' . $settings['slider_show_pagination'] ); ?>"></div>
					<?php endif; ?>

					<?php if ( $settings['slider_show_arrow'] ) : ?>
						<div class="thim-slider-nav thim-slider-nav-prev<?php echo esc_attr( $hiden_nav_mobile ); ?>">
							<?php Icons_Manager::render_icon( $settings['slider_arrows_left'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
						<div class="thim-slider-nav thim-slider-nav-next<?php echo esc_attr( $hiden_nav_mobile ); ?>">
							<?php Icons_Manager::render_icon( $settings['slider_arrows_right'], array( 'aria-hidden' => 'true' ) ); ?>
						</div>
						<?php
					endif;
				}
				?>
				<div class="<?php echo esc_attr( $class ); ?>">
					<div class="<?php echo esc_attr( $class_inner ); ?>">
						<?php
						while ( $the_query->have_posts() ) {
							$the_query->the_post();
							parent::render_course( $settings, $class_item );
						}
						?>
					</div>
				</div>
				<?php
			} else {
				echo '<div class="message-info">' . __( 'No data were found matching your selection, you need to create Post or select Category of Widget.', 'thim-elementor-kit' ) . '</div>';
			}

			wp_reset_postdata();
		}

	}


	public function render_course_tab( $settings, $query_args ) {
		$random   = $this->get_id();
		$list_tab = $content_tab = '';

		if ( $settings['cat_id'] ) {
			$cat_ids = $settings['cat_id'];
		} else {
			$cat_ids        = array();
			$all_course_cat = get_terms(
				'course_category',
				array(
					'hide_empty' => false,
					'number'     => 4,
				)
			);
			if ( ! is_wp_error( $all_course_cat ) ) {
				foreach ( $all_course_cat as $cat_id_df ) {
					$cat_ids[] = esc_attr( $cat_id_df->term_id );
				}
			}
		}

		if ( $cat_ids ) {
			foreach ( $cat_ids as $k => $tab ) {
				$term = get_term_by( 'id', $tab, 'course_category' );

				if ( $term ) {
					$query_args['tax_query'] = array(
						array(
							'taxonomy' => 'course_category',
							'field'    => 'term_id',
							'terms'    => $tab,
						),
					);

					$tab_class = $content_class = '';

					if ( $k == 0 ) {
						$tab_class     = ' class="active"';
						$content_class = ' in active';
					}

					$list_tab    .= '<li' . esc_attr( $tab_class ) . '><a href="#tab-course-' . esc_attr( $random ) . '-' . esc_attr( $tab ) . '" data-toggle="tab">' . esc_html( $term->name ) . '</a></li>';
					$content_tab .= '<div role="tabpanel" class="tab-pane fade' . esc_attr( $content_class ) . '" id="tab-course-' . esc_attr( $random ) . '-' . esc_attr( $tab ) . '">';

					ob_start();
					$this->render_course_one_cat( $settings, $query_args );
					$content_tab .= ob_get_contents();
					ob_end_clean();

					$content_tab .= '</div>';
				}
			}
		}
		?>
		<div class="thim-course-tabs">
			<ul class="nav nav-tabs">
				<?php echo wp_kses_post( ent2ncr( $list_tab ) ); ?>
			</ul>
			<div class="tab-content">
				<?php echo wp_kses_post( ent2ncr( $content_tab ) ); ?>
			</div>
		</div>
		<?php
	}

	public function render_course_one_cat( $settings, $query_args ) {
		$the_query = new \WP_Query( $query_args );

		if ( $the_query->have_posts() ) {
			?>
			<div class="thim-ekits-course">
				<div class="thim-ekits-course__inner">
					<?php
					while ( $the_query->have_posts() ) {
						$the_query->the_post();
						parent::render_course( $settings, 'thim-ekits-course__item' );
					}
					?>
				</div>
			</div>
			<?php
		} else {
			echo '<div class="message-info">' . esc_html__( 'No data were found matching your selection, you need to create Post or select Category of Widget.', 'thim-elementor-kit' ) . '</div>';
		}

		wp_reset_postdata();
	}
}

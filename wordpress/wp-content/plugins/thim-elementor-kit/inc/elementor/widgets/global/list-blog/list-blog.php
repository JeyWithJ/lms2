<?php

namespace Elementor;

use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Core\Kits\Controls\Repeater as Global_Style_Repeater;
use Elementor\Utils;

class Thim_Ekit_Widget_List_Blog extends Widget_Base {

	protected $current_permalink;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-ekits-list-blog';
	}

	public function get_title() {
		return esc_html__( 'Thim List Blog', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-post-list';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY );
	}

	public function get_help_url() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'List Blog Settings', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'blog_layout',
			array(
				'label'   => esc_html__( 'Select Layout', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => array(
					'default' => esc_html__( 'Default', 'thim-elementor-kit' ),
					'slider'  => esc_html__( 'Slider', 'thim-elementor-kit' ),
				),
			)
		);

		$this->add_control(
			'cat_id',
			array(
				'label'   => esc_html__( 'Select Category', 'thim-elementor-kit' ),
				'default' => 'all',
				'type'    => Controls_Manager::SELECT,
				'options' => \Thim_EL_Kit\Elementor::get_cat_taxonomy( 'category', array( 'all' => esc_html__( 'All', 'thim-elementor-kit' ) ) ),
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
				),
				'selectors'      => array(
					'{{WRAPPER}}' => '--thim-ekits-post-columns: repeat({{VALUE}}, 1fr)',
				),
				'condition'      => array(
					'blog_layout!' => 'slider',
				),
			)
		);

		$this->add_control(
			'orderby',
			array(
				'label'   => esc_html__( 'Order by', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'popular' => esc_html__( 'Popular', 'thim-elementor-kit' ),
					'recent'  => esc_html__( 'Date', 'thim-elementor-kit' ),
					'title'   => esc_html__( 'Title', 'thim-elementor-kit' ),
					'random'  => esc_html__( 'Random', 'thim-elementor-kit' ),
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
			'thumbnail_enable',
			array(
				'label'        => esc_html__( 'Image', 'thim-elementor-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'default'      => 'top',
				'options'      => array(
					'none'  => array(
						'title' => esc_html__( 'none', 'thim-elementor-kit' ),
						'icon'  => 'eicon-ban',
					),
					'top'   => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'left'  => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'render_type'  => 'ui',
				'prefix_class' => 'thim-ekits-post__thumbnail-position-',
			)
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'thumbnail_size',
				'default'   => 'medium',
				'condition' => array(
					'thumbnail_enable!' => 'none',
				),
			)
		);
		$this->add_control(
			'meta_data_inner_image',
			array(
				'label'       => esc_html__( 'Meta Overlay', 'thim-elementor-kit' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => '',
				'multiple'    => true,
				'options'     => array(
					'date'     => esc_html__( 'Date', 'thim-elementor-kit' ),
					'category' => esc_html__( 'Category', 'thim-elementor-kit' ),
				),
				'condition'   => array(
					'thumbnail_enable!' => 'none',
				),
			)
		);

		$this->add_control(
			'icon_hover_inner_image',
			array(
				'label'                  => esc_html__( 'Icon Hover', 'thim-elementor-kit' ),
				'type'                   => Controls_Manager::ICONS,

				'skin'                   => 'inline',
				'label_block'            => false,
				'exclude_inline_options' => array( 'svg' ),
				'condition'              => array(
					'thumbnail_enable!' => 'none',
				),
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'key',
			array(
				'label'   => esc_html__( 'Type', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'title',
				'options' => array(
					'title'     => 'Title',
					'meta_data' => 'Meta Data',
					'content'   => 'Content',
					'read_more' => 'Read more',
				),
			)
		);

		$repeater->add_control(
			'title_tag',
			array(
				'label'     => __( 'Title HTML Tag', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'h1'   => 'H1',
					'h2'   => 'H2',
					'h3'   => 'H3',
					'h4'   => 'H4',
					'h5'   => 'H5',
					'h6'   => 'H6',
					'div'  => 'div',
					'span' => 'span',
					'p'    => 'p',
				),
				'default'   => 'h3',
				'condition' => array(
					'key' => 'title',
				),
			)
		);

		$repeater->add_control(
			'meta_data',
			array(
				'label'       => esc_html__( 'Meta Data', 'thim-elementor-kit' ),
				'label_block' => true,
				'type'        => Controls_Manager::SELECT2,
				'default'     => array( 'date', 'comments' ),
				'multiple'    => true,
				'options'     => array(
					'author'    => esc_html__( 'Author', 'thim-elementor-kit' ),
					'date'      => esc_html__( 'Date', 'thim-elementor-kit' ),
					'comments'  => esc_html__( 'Comments', 'thim-elementor-kit' ),
					'read_more' => esc_html__( 'Read More', 'thim-elementor-kit' ),
					'category'  => esc_html__( 'Category', 'thim-elementor-kit' ),
				),
				'condition'   => array(
					'key' => 'meta_data',
				),
			)
		);

		$repeater->add_control(
			'meta_data_display',
			array(
				'label'       => esc_html__( 'Display Item', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'default'     => 'start',
				'options'     => array(

					'flex-start'    => array(
						'title' => esc_html__( 'Start', 'thim-elementor-kit' ),
						'icon'  => 'eicon-justify-start-h',
					),
					'space-around'  => array(
						'title' => esc_html__( 'Center', 'thim-elementor-kit' ),
						'icon'  => 'eicon-justify-space-around-h',
					),
					'space-between' => array(
						'title' => esc_html__( 'Spaced between items', 'thim-elementor-kit' ),
						'icon'  => 'eicon-justify-space-evenly-h',
					),
					'flex-end'      => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-justify-end-h',
					),
					'start_end'     => array(
						'title' => esc_html__( 'Left, 1 Item Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-justify-space-between-h',
					),
					'inline_block'  => array(
						'title' => esc_html__( 'Inline Block', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-middle',
					),
				),
				'condition'   => array(
					'key' => 'meta_data',
				),
				'render_type' => 'ui',
				'selectors'   => array(
					'{{WRAPPER}}  .thim-ekits-post__article {{CURRENT_ITEM}}' => '--thim-item-meta-data-display: {{VALUE}};',
				),
			)
		);

		$repeater->add_control(
			'show_icon_meta_data',
			array(
				'label'     => esc_html__( 'Icon Meta Data', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off' => esc_html__( 'No', 'thim-elementor-kit' ),
				'default'   => 'no',
				'condition' => array(
					'key' => 'meta_data',
				),
			)
		);

		$repeater->add_control(
			'separator',
			array(
				'label'     => esc_html__( 'Separator Between', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '|',
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__meta span + span:before' => 'content: "{{VALUE}}"',
				),
				'condition' => array(
					'key'                  => 'meta_data',
					'show_icon_meta_data!' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'author_icon_meta_data',
			array(
				'label'       => esc_html__( 'Author Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'meta_data'           => 'author',
					'show_icon_meta_data' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'date_icon_meta_data',
			array(
				'label'       => esc_html__( 'Date Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'meta_data'           => 'date',
					'show_icon_meta_data' => 'yes',
				),
			)
		);

		$repeater->add_control(
			'comments_icon_meta_data',
			array(
				'label'       => esc_html__( 'Comments Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'meta_data'           => 'comments',
					'show_icon_meta_data' => 'yes',
				),
			)
		);
		$repeater->add_control(
			'category_icon_meta_data',
			array(
				'label'       => esc_html__( 'Category Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'show_icon_meta_data' => 'yes',
					'meta_data'           => 'category',
				),
			)
		);
		$repeater->add_control(
			'read_more_icon_meta_data',
			array(
				'label'       => esc_html__( 'Read More Icon', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::ICONS,
				'skin'        => 'inline',
				'label_block' => false,
				'condition'   => array(
					'meta_data' => 'read_more',
				),
			)
		);

		$repeater->add_control(
			'excerpt_lenght',
			array(
				'label'     => esc_html__( 'Excerpt Lenght', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 25,
				'condition' => array(
					'key' => 'content',
				),
			)
		);

		$repeater->add_control(
			'excerpt_more',
			array(
				'label'     => esc_html__( 'Excerpt More', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '...',
				'condition' => array(
					'key' => 'content',
				),
			)
		);

		$repeater->add_control(
			'read_more_text',
			array(
				'label'     => esc_html__( 'Read More Text', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => esc_html__( 'Read More »', 'thim-elementor-kit' ),
				'condition' => array(
					'key' => array( 'read_more', 'meta_data' ),
				),
			)
		);
		$repeater->add_control(
			'meta_data-toggle',
			array(
				'type'         => \Elementor\Controls_Manager::POPOVER_TOGGLE,
				'label'        => esc_html__( 'Options Meta data', 'thim-elementor-kit' ),
				'label_off'    => esc_html__( 'Default', 'thim-elementor-kit' ),
				'label_on'     => esc_html__( 'Custom', 'thim-elementor-kit' ),
				'return_value' => 'yes',
			)
		);

		$repeater->start_popover();

		$repeater->add_control(
			'meta_data_item_spacing',
			array(
				'label'       => esc_html__( 'Item Spacing', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 7,
				'condition'   => array(
					'key'              => 'meta_data',
					'meta_data-toggle' => 'yes',
				),
				'selectors'   => array(
					'{{WRAPPER}}  .thim-ekits-post__article {{CURRENT_ITEM}}' => '--thim-item-meta-data-spacing: {{VALUE}}px;',
				),
			)
		);
		$repeater->add_responsive_control(
			'meta_data_border',
			array(
				'label'     => esc_html__( 'Border Top Type', 'thim-elementor-kit' ),
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
					'key'              => 'meta_data',
					'meta_data-toggle' => 'yes',
				),
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article {{CURRENT_ITEM}}' => 'border-top-style: {{VALUE}};',
				),
			)
		);
		$repeater->add_responsive_control(
			'meta_data_border_dimensions',
			array(
				'label'       => esc_html_x( 'Width', 'Border Control', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'condition'   => array(
					'key'               => 'meta_data',
					'meta_data_border!' => 'none',
				),
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article {{CURRENT_ITEM}}' => 'border-top-width: {{VALUE}}px;',
				),
			)
		);
		$repeater->add_control(
			'meta_data_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'key'               => 'meta_data',
					'meta_data_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article {{CURRENT_ITEM}}' => 'border-top-color: {{VALUE}};',
				),
			)
		);
		$repeater->add_control(
			'meta_data_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color Hover', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'condition' => array(
					'key'               => 'meta_data',
					'meta_data_border!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article:hover {{CURRENT_ITEM}}' => 'border-top-color: {{VALUE}};',
				),
			)
		);
		$repeater->add_control(
			'meta_data_padding_top',
			array(
				'label'       => esc_html__( 'Padding Top', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article {{CURRENT_ITEM}}' => 'padding-top: {{VALUE}}px;',
				),
				'condition'   => array(
					'key'               => 'meta_data',
					'meta_data_border!' => 'none',
				),
			)
		);
		$repeater->end_popover();

		$this->add_control(
			'repeater',
			array(
				'label'       => esc_html__( 'Post Data', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'key' => 'title',
					),
					array(
						'key' => 'meta_data',
					),
					array(
						'key' => 'content',
					),
					array(
						'key' => 'read_more',
					),
				),
				'title_field' => '<span style="text-transform: capitalize;">{{{ key.replace("_", " ") }}}</span>',
			)
		);

		$this->add_control(
			'open_new_tab',
			array(
				'label'     => esc_html__( 'Open in new window', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => esc_html__( 'Yes', 'thim-elementor-kit' ),
				'label_off' => esc_html__( 'No', 'thim-elementor-kit' ),
				'default'   => 'no',
			)
		);

		$this->end_controls_section();

		$this->_register_setting_slider();

		$this->_register_style_layout();

		$this->_register_style_blog();

		$this->_register_style_image();

		$this->_register_style_content();

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
					'blog_layout!' => 'slider',
				),
			)
		);

		$this->add_responsive_control(
			'column_gap',
			array(
				'label'     => esc_html__( 'Columns Gap', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 30,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-post-column-gap: {{SIZE}}{{UNIT}}',
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
					'{{WRAPPER}}' => '--thim-ekits-post-row-gap: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function _register_style_blog() {
		$this->start_controls_section(
			'section_style_post',
			array(
				'label' => esc_html__( 'Post', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		$this->add_responsive_control(
			'wrapper_post_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'post_border',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article',
				'exclude'  => array( 'color' ),
			)
		);

		$this->start_controls_tabs( 'post_style_tabs' );

		$this->start_controls_tab(
			'post_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'post_shadow',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article',
			)
		);

		$this->add_control(
			'post_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'post_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'post_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'post_shadow_hover',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article:hover',
			)
		);

		$this->add_control(
			'post_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'post_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_control(
			'post_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}; overflow: hidden;',
				),
			)
		);
		$this->end_controls_section();
	}

	protected function _register_style_image() {
		$this->start_controls_section(
			'section_style_image',
			array(
				'label'     => esc_html__( 'Image', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'thumbnail_enable!' => 'none',
				),
			)
		);

		$this->add_control(
			'img_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__thumbnail .post-thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_spacing',
			array(
				'label'     => esc_html__( 'Content Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 30,
				),
				'range'     => array(
					'px' => array(
						'min' => 0,
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-ekits-image-spacing: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_image_overlay_style',
			array(
				'label'     => esc_html__( 'OverLay', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'bg_image_overlay',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-bg-image-overlay-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'icon_color_overlay',
			array(
				'label'     => esc_html__( 'Icon Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-bg-image-overlay-icon-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_size',
			array(
				'label'       => esc_html__( 'Icon Size', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 18,
				'selectors'   => array(
					'{{WRAPPER}}' => '--thim-bg-image-overlay-icon-font-size:{{VALUE}}px',
				),
			)
		);

		$this->start_controls_tabs(
			'offset_setting_overlay'
		);

		$this->start_controls_tab(
			'category_offset_style',
			array(
				'label' => esc_html__( 'Category', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'cate_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'cate_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'cate_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'cate_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'cate_overlay_font_size',
			array(
				'label'       => esc_html__( 'Font Size', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 18,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => 'font-size:{{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'category_offset_orientation_h',
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
			'category_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => '{{category_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'category_offset_orientation_v',
			array(
				'label'       => esc_html__( 'Vertical Orientation', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'bottom',
				'options'     => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'category_indicator_offset_v',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-blog__categories' => '{{category_offset_orientation_v.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'date_offset_style',
			array(
				'label' => esc_html__( 'Date', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'date_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-bg-date-overlay-bg-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'date_text_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-bg-date-overlay-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'date_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-bg-date-overlay-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'date_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-post__date' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'date_overlay_font_size',
			array(
				'label'       => esc_html__( 'Font Size', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 18,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-post__date' => 'font-size:{{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'date_offset_orientation_h',
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
			'date_indicator_offset_h',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-post__date' => '{{date_offset_orientation_h.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->add_control(
			'date_offset_orientation_v',
			array(
				'label'       => esc_html__( 'Vertical Orientation', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::CHOOSE,
				'toggle'      => false,
				'default'     => 'top',
				'options'     => array(
					'top'    => array(
						'title' => esc_html__( 'Top', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-top',
					),
					'bottom' => array(
						'title' => esc_html__( 'Bottom', 'thim-elementor-kit' ),
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'render_type' => 'ui',
			)
		);

		$this->add_responsive_control(
			'date_indicator_offset_v',
			array(
				'label'       => esc_html__( 'Offset', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => - 100,
				'step'        => 1,
				'default'     => 10,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__thumbnail .thim-ekits-post__date' => '{{date_offset_orientation_v.VALUE}}:{{VALUE}}px',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function _register_style_content() {
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'content_align',
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
				'default'   => 'left',
				'toggle'    => true,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__content' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'content_post_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}}' => '--thim-ekits-post-content-padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'content_post_margin',
			array(
				'label'      => esc_html__( 'Margin', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_title_style',
			array(
				'label'     => esc_html__( 'Title', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__title a' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'title_color_hover',
			array(
				'label'     => esc_html__( 'Color Hover', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__title a:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__title a',
			)
		);

		$this->add_control(
			'title_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_excerpt_style',
			array(
				'label'     => esc_html__( 'Excerpt', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'excerpt_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__excerpt' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'excerpt_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__excerpt',
			)
		);
		$this->add_responsive_control(
			'excerpt_max_line',
			array(
				'label'       => esc_html__( 'Max Line', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'selectors'   => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__excerpt' => 'display: -webkit-box; text-overflow: ellipsis; -webkit-line-clamp: {{VALUE}};-webkit-box-orient:vertical; overflow: hidden;',
				),
			)
		);
		$this->add_control(
			'excerpt_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__excerpt' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->_register_style_meta_data();
		$this->_register_style_read_more();

		$this->end_controls_section();

	}

	protected function _register_style_meta_data() {
		$this->add_control(
			'heading_meta_data_style',
			array(
				'label'     => esc_html__( 'Meta Data', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'meta_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta',
			)
		);
		$this->start_controls_tabs(
			'meta_data_text_config'
		);

		$this->start_controls_tab(
			'meta_data_text_base_style',
			array(
				'label' => esc_html__( 'Base', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'meta_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-meta-data-item-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'meta_link_color',
			array(
				'label'     => esc_html__( 'Link Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-meta-data-item-link-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'meta_data_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--thim-meta-data-margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);
		$this->end_controls_tab();
		$this->start_controls_tab(
			'meta_data_text_extra_style',
			array(
				'label' => esc_html__( 'Extra', 'thim-elementor-kit' ),
			)
		);
		$this->add_control(
			'meta_data_wrapper_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'meta_data_wrapper_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);
		$this->add_responsive_control(
			'meta_data_wrapper_padding_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();
		$this->end_controls_tabs();

		$this->add_control(
			'heading_meta_separator_meta_style',
			array(
				'label'     => esc_html__( 'Separator, Icon', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'meta_separator_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta span:before, {{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__meta i' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'meta_icon_spacing',
			array(
				'label'       => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 7,
				'selectors'   => array(
					'{{WRAPPER}}' => '--thim-meta-icon-spacing: {{VALUE}}px;',
				),
			)
		);
		$this->add_responsive_control(
			'meta_icon_font_size',
			array(
				'label'       => esc_html__( 'Size', 'thim-elementor-kit' ),
				'type'        => Controls_Manager::NUMBER,
				'label_block' => false,
				'min'         => 0,
				'step'        => 1,
				'default'     => 16,
				'selectors'   => array(
					'{{WRAPPER}}' => '--thim-meta-icon-font-size: {{VALUE}}px;',
				),
			)
		);

	}

	protected function _register_style_read_more() {
		$this->add_control(
			'heading_readmore_style',
			array(
				'label'     => esc_html__( 'Read More', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'read_more_typography',
				'selector' => '{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more',
			)
		);

		$this->add_control(
			'read_more_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'range'     => array(
					'px' => array(
						'max' => 100,
					),
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'read_more_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),

			)
		);
		$this->add_responsive_control(
			'read_more_border_style',
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
				'default'   => 'none',
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'border-style: {{VALUE}};',
				),
			)
		);
		$this->add_responsive_control(
			'read_more_border_dimensions',
			array(
				'label'     => esc_html_x( 'Width', 'Border Control', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::DIMENSIONS,
				'condition' => array(
					'read_more_border_style!' => 'none',
				),
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs(
			'read_more_text_colors'
		);

		$this->start_controls_tab(
			'read_more_normal_style',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'read_more_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'read_more_icon_color',
			array(
				'label'     => esc_html__( 'Icon Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more i' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'read_more_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'background-color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'read_more_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'read_more_border_style!' => 'none',
				),
			)
		);

		$this->end_controls_tab();
		$this->start_controls_tab(
			'read_more_hover_style',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'read_more_color_hover',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more:hover' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'read_more_icon_color_hover',
			array(
				'label'     => esc_html__( 'Icon Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more:hover i' => 'color: {{VALUE}};',
				),
			)
		);
		$this->add_control(
			'read_more_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'read_more_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more:hover' => 'border-color: {{VALUE}};',
				),
				'condition' => array(
					'read_more_border_style!' => 'none',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		$this->add_responsive_control(
			'read_more_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .thim-ekits-post__article .thim-ekits-post__read-more' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
	}

	protected function _register_setting_slider() {
		// setting slider section

		$this->start_controls_section(
			'skin_slider_settings',
			array(
				'label'     => esc_html__( 'Settings Slider', 'thim-elementor-kit' ),
				'condition' => array(
					'blog_layout' => 'slider',
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
				'mobile_default'     => '2',
				'selectors'          => array(
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
				'devices'            => array( 'widescreen', 'desktop', 'tablet', 'mobile' ),
				'mobile_default'     => '15',
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
					'blog_layout'             => 'slider',
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
					'slider_show_pagination' => array( 'number' ),
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
					'slider_show_pagination' => array( 'number' ),
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
					'slider_show_pagination' => array( 'bullets' ),
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
					'blog_layout'       => 'slider',
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
		$settings = $this->get_settings_for_display();

		$query_args = array(
			'post_type'           => 'post',
			'posts_per_page'      => absint( $settings['number_posts'] ),
			'order'               => ( 'asc' == $settings['order'] ) ? 'asc' : 'desc',
			'ignore_sticky_posts' => true,
		);

		if ( $settings['cat_id'] && $settings['cat_id'] != 'all' ) {
			$query_args['cat'] = absint( $settings['cat_id'] );
		}

		switch ( $settings['orderby'] ) {
			case 'recent':
				$query_args['orderby'] = 'post_date';
				break;
			case 'title':
				$query_args['orderby'] = 'post_title';
				break;
			case 'popular':
				$query_args['orderby'] = 'comment_count';
				break;
			default: // random
				$query_args['orderby'] = 'rand';
		}
		$query_vars = new \WP_Query( $query_args );

		$class            = 'thim-ekits-post';
		$class_inner      = 'thim-ekits-post__inner';
		$class_item       = 'thim-ekits-post__article';
		$hiden_nav_mobile = '';

		if ( $query_vars->have_posts() ) { // It's the global `wp_query` it self. and the loop was started from the theme.
			if ( isset( $settings['blog_layout'] ) && $settings['blog_layout'] == 'slider' ) {
				$class      .= ' thim-ekits-sliders swiper-container';
				$class_inner = 'swiper-wrapper';
				$class_item .= ' swiper-slide';

				if ( $settings['slider_show_pagination'] != 'none' ) :
					$hiden_nav_mobile = ' hidden-nav-mobile';
					?>
					<div class="thim-slider-pagination <?php echo 'thim-' . esc_attr( $settings['slider_show_pagination'] ); ?>"></div>
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
					while ( $query_vars->have_posts() ) {
						$query_vars->the_post();
						$this->current_permalink = get_permalink();
						$this->render_post( $settings, $class_item );
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

	public function render_post( $settings, $class_item ) {
		?>
		<div <?php post_class( array( $class_item ) ); ?>>

			<?php $this->render_thumbnail( $settings ); ?>

			<?php
			$this->render_text_header();

			if ( $settings['repeater'] ) {
				foreach ( $settings['repeater'] as $item ) {
					switch ( $item['key'] ) {
						case 'title':
							$this->render_title( $settings, $item );
							break;
						case 'content':
							$this->render_excerpt( $settings, $item );
							break;
						case 'meta_data':
							$this->render_meta_data( $settings, $item );
							break;
						case 'read_more':
							$this->render_read_more( $settings, $item );
							break;
					}
				}
			}

			$this->render_text_footer();
			?>

		</div>
		<?php
	}

	protected function render_text_header() {
		?>
		<div class="thim-ekits-post__content">
		<?php
	}

	protected function render_text_footer() {
		?>
		</div>
		<?php
	}

	protected function render_thumbnail( $settings ) {
		if ( $settings['thumbnail_enable'] == 'none' ) {
			return;
		}

		$settings['thumbnail_size'] = array(
			'id' => get_post_thumbnail_id(),
		);

		$thumbnail_html = Group_Control_Image_Size::get_attachment_image_html( $settings, 'thumbnail_size' );

		if ( empty( $thumbnail_html ) ) {
			return;
		}

		$attributes_html = $this->get_optional_link_attributes_html( $settings );
		?>
		<div class="thim-ekits-post__thumbnail">
			<a class="post-thumbnail" href="<?php echo esc_url( $this->current_permalink ); ?>" <?php Utils::print_unescaped_internal_string( $attributes_html ); ?>>
				<?php
				echo wp_kses_post( $thumbnail_html );
				Icons_Manager::render_icon( $settings['icon_hover_inner_image'], array( 'aria-hidden' => 'true' ) );
				?>
			</a>
			<?php $this->render_meta_data_inner_image( $settings ); ?>
		</div>
		<?php
	}

	protected function render_title( $settings, $item ) {
		$attributes_html = $this->get_optional_link_attributes_html( $settings );
		?>
		<<?php Utils::print_validated_html_tag( $item['title_tag'] ); ?> class="thim-ekits-post__title">
			<a href="<?php echo esc_url( $this->current_permalink ); ?>" <?php Utils::print_unescaped_internal_string( $attributes_html ); ?>>
				<?php the_title(); ?>
			</a>
		</<?php Utils::print_validated_html_tag( $item['title_tag'] ); ?>>
		<?php
	}

	protected function get_optional_link_attributes_html( $settings ) {
		$attributes_html = 'yes' === $settings['open_new_tab'] ? 'target="_blank" rel="noopener noreferrer"' : '';

		return $attributes_html;
	}

	protected function render_excerpt( $settings, $item ) {
		?>

		<div class="thim-ekits-post__excerpt">
			<?php echo wp_kses_post( wp_trim_words( get_the_excerpt(), absint( $item['excerpt_lenght'] ), esc_html( $item['excerpt_more'] ) ) ); ?>
		</div>

		<?php
	}

	protected function render_meta_data( $settings, $item ) {
		$meta_data = $item['meta_data'];
		?>

		<div class="thim-ekits-post__meta elementor-repeater-item-<?php echo esc_attr( $item['_id'] ); ?><?php echo ' m-psi-' . esc_attr( $item['meta_data_display'] ); ?>">
			<?php
			if ( in_array( 'author', $meta_data ) ) {
				$this->render_author( $item['author_icon_meta_data'] );
			}
			if ( in_array( 'date', $meta_data ) ) {
				$this->render_date_by_type( $item['date_icon_meta_data'] );
			}
			if ( in_array( 'comments', $meta_data ) ) {
				$this->render_comments( $item['comments_icon_meta_data'] );
			}
			if ( in_array( 'read_more', $meta_data ) ) {
				$this->render_read_more( $settings, $item );
			}
			if ( in_array( 'category', $meta_data ) ) {
				$this->render_categories( $item['category_icon_meta_data'] );
			}
			?>
		</div>

		<?php
	}

	protected function render_meta_data_inner_image( $settings ) {
		if ( ! $settings['meta_data_inner_image'] ) {
			return;
		}
		$meta_data_inner_image = $settings['meta_data_inner_image'];

		if ( in_array( 'category', $meta_data_inner_image ) ) {
			$this->render_categories();
		}

		if ( in_array( 'date', $meta_data_inner_image ) ) {
			?>
			<span class="thim-ekits-post__date">
				<span class="day"><?php echo esc_html( get_the_date( 'd' ) ); ?></span>
				<span class="month"><?php echo esc_html( get_the_date( 'M' ) ); ?></span>
			</span>
			<?php
		}

	}

	protected function render_author( $icon ) {
		?>
		<span class="thim-ekits-post__author">
			<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
			<?php the_author(); ?>
		</span>
		<?php
	}

	protected function render_date_by_type( $icon ) {
		$date = get_the_date();
		?>

		<span class="thim-ekits-post__date">
			<?php
			if ( $icon ) {
				Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) );
			}
			?>
			<?php echo esc_html( apply_filters( 'the_date', $date, get_option( 'date_format' ), '', '' ) ); ?>
		</span>

		<?php
	}

	protected function render_comments( $icon ) {
		?>
		<span class="thim-ekits-post__comments">
			<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
			<?php comments_number(); ?>
		</span>
		<?php
	}

	protected function render_categories( $icon = '' ) {
		$categories = get_the_category();
		if ( empty( $categories ) ) {
			return;
		}
		?>
		<span class="thim-ekits-blog__categories">
			<?php Icons_Manager::render_icon( $icon, array( 'aria-hidden' => 'true' ) ); ?>
			<a class="<?php echo esc_attr( $categories[0]->slug ); ?>" href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>" title="<?php echo esc_attr( $categories[0]->cat_name ); ?>">
				<?php echo esc_html( $categories[0]->cat_name ); ?>
			</a>
		</span>
		<?php
	}

	protected function render_read_more( $settings, $item ) {
		$attributes_html = $this->get_optional_link_attributes_html( $settings );
		?>
		<a class="thim-ekits-post__read-more" href="<?php echo esc_url( $this->current_permalink ); ?>" <?php Utils::print_unescaped_internal_string( $attributes_html ); ?>>
			<?php echo esc_html( $item['read_more_text'] ); ?>
		</a>
		<?php
	}
}

<?php
namespace Elementor;

abstract class Thim_Ekit_Products_Base extends Widget_Base {

	protected function register_controls() {
		$this->register_style_products_controls();
		$this->register_style_product_controls();
		$this->register_style_pagination_controls();
		$this->register_style_sale_controls();
	}

	protected function register_style_products_controls() {
		$this->start_controls_section(
			'section_style_archive_product',
			array(
				'label' => esc_html__( 'Products', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'columns_gap',
			array(
				'label'     => esc_html__( 'Columns Gap', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid' => 'column-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'rows_gap',
			array(
				'label'     => esc_html__( 'Rows Gap', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid' => 'row-gap: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'align',
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
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product' => 'text-align: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'heading_image_style',
			array(
				'label'     => esc_html__( 'Image', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'image_border',
				'selector' => 'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .attachment-woocommerce_thumbnail',
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .attachment-woocommerce_thumbnail' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'image_box_shadow',
				'exclude'  => array(
					'box_shadow_position',
				),
				'selector' => 'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .attachment-woocommerce_thumbnail',
			)
		);

		$this->add_responsive_control(
			'image_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .attachment-woocommerce_thumbnail' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_title_style',
			array(
				'label'     => esc_html__( 'Product Title', 'thim-elementor-kit' ),
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
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .woocommerce-loop-product__title' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => 'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .woocommerce-loop-product__title',
			)
		);

		$this->add_responsive_control(
			'title_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .woocommerce-loop-product__title' => 'margin-bottom: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'heading_rating_style',
			array(
				'label'     => esc_html__( 'Rating', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'star_color',
			array(
				'label'     => esc_html__( 'Star Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .star-rating' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'empty_star_color',
			array(
				'label'     => esc_html__( 'Empty Star Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .star-rating::before' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'star_size',
			array(
				'label'      => esc_html__( 'Star Size', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'default'    => array(
					'unit' => 'em',
				),
				'range'      => array(
					'em' => array(
						'min'  => 0,
						'max'  => 4,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .star-rating' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'rating_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'em' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid .star-rating' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'heading_price_style',
			array(
				'label'     => esc_html__( 'Price', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'price_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price' => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price ins' => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price ins .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'price_typography',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price',
			)
		);

		$this->add_control(
			'heading_regular_price_style',
			array(
				'label'     => esc_html__( 'Regular Price', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'regular_price_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price del' => 'color: {{VALUE}}',
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price del .amount' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'regular_price_typography',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price del .amount ',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .price del',
			)
		);

		$this->add_control(
			'heading_button_style',
			array(
				'label'     => esc_html__( 'Button', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->start_controls_tabs( 'tabs_button_style' );

		$this->start_controls_tab(
			'tab_button_normal',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'button_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					 {{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'button_typography',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
							   {{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart',
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_button_hover',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'button_hover_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button:hover,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button:hover,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart:hover' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'button_hover_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button:hover,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart:hover' => 'border-color: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control(
			'button_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'separator'  => 'before',
				'selectors'  => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'button_border',
				'exclude'  => array( 'color' ),
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
				{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart',
			)
		);

		$this->add_control(
			'button_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'button_spacing',
			array(
				'label'      => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'em' => array(
						'min'  => 0,
						'max'  => 5,
						'step' => 0.1,
					),
				),
				'selectors'  => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .button,
					{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product .added_to_cart' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_product_controls() {
		$this->start_controls_section(
			'section_style_product',
			array(
				'label' => esc_html__( 'Product', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'product_border',
				'exclude'  => array( 'color' ),
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product',
			)
		);

		$this->add_control(
			'product_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'product_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->start_controls_tabs( 'product_style_tabs' );

		$this->start_controls_tab(
			'product_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'product_shadow',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product',
			)
		);

		$this->add_control(
			'product_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'product_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'product_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			array(
				'name'     => 'product_shadow_hover',
				'selector' => '{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product:hover',
			)
		);

		$this->add_control(
			'product_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'product_border_color_hover',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products.thim-ekit-archive-product__grid li.product:hover' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_pagination_controls() {
		$this->start_controls_section(
			'section_pagination_style',
			array(
				'label'     => esc_html__( 'Pagination', 'thim-elementor-kit' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'paginate' => 'yes',
				),
			)
		);

		$this->add_control(
			'logo_align',
			array(
				'label'        => esc_html__( 'Alignment', 'thim-elementor-kit' ),
				'type'         => Controls_Manager::CHOOSE,
				'options'      => array(
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
				'prefix_class' => 'thim-ekit-archive-product--pagination--align--',
				'selectors'    => array(
					'{{WRAPPER}} nav.woocommerce-pagination' => 'text-align: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_gap',
			array(
				'label'          => esc_html__( 'Columns Gap', 'thim-elementor-kit' ),
				'type'           => Controls_Manager::SLIDER,
				'default'        => array(
					'unit' => 'px',
				),
				'tablet_default' => array(
					'unit' => 'px',
				),
				'mobile_default' => array(
					'unit' => 'px',
				),
				'size_units'     => array( 'px', 'em' ),
				'range'          => array(
					'px' => array(
						'min' => 1,
						'max' => 100,
					),
					'em' => array(
						'min' => 1,
						'max' => 10,
					),
				),
				'selectors'      => array(
					'{{WRAPPER}}.thim-ekit-archive-product--pagination--align--left nav.woocommerce-pagination ul li' => 'margin-right: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.thim-ekit-archive-product--pagination--align--right nav.woocommerce-pagination ul li' => 'margin-left: {{SIZE}}{{UNIT}};',
					'{{WRAPPER}}.thim-ekit-archive-product--pagination--align--center nav.woocommerce-pagination ul li' => 'margin-left: calc( {{SIZE}}{{UNIT}} / 2 ); margin-right: calc( {{SIZE}}{{UNIT}} / 2 );',
				),
			)
		);

		$this->add_control(
			'pagination_spacing',
			array(
				'label'     => esc_html__( 'Spacing', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'     => 'pagination_border',
				'exclude'  => array( 'color' ),
				'selector' => '{{WRAPPER}} nav.woocommerce-pagination ul li a, {{WRAPPER}} nav.woocommerce-pagination ul li span',
			)
		);

		$this->add_responsive_control(
			'pagination_padding',
			array(
				'label'      => esc_html__( 'Padding', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li a, {{WRAPPER}} nav.woocommerce-pagination ul li span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'pagination_typography',
				'selector' => '{{WRAPPER}} nav.woocommerce-pagination',
			)
		);

		$this->start_controls_tabs( 'pagination_style_tabs' );

		$this->start_controls_tab(
			'pagination_style_normal',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'pagination_link_color',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_link_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li a' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_style_hover',
			array(
				'label' => esc_html__( 'Hover', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'pagination_link_color_hover',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li a:hover' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_link_bg_color_hover',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li a:hover' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'pagination_style_active',
			array(
				'label' => esc_html__( 'Active', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'pagination_link_color_active',
			array(
				'label'     => esc_html__( 'Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'pagination_link_bg_color_active',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} nav.woocommerce-pagination ul li span.current' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();
	}

	protected function register_style_sale_controls() {
		$this->start_controls_section(
			'section_sale_style',
			array(
				'label' => esc_html__( 'Sale Badge', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'show_onsale_flash',
			array(
				'label'        => esc_html__( 'Sale Flash', 'thim-elementor-kit' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_off'    => esc_html__( 'Hide', 'thim-elementor-kit' ),
				'label_on'     => esc_html__( 'Show', 'thim-elementor-kit' ),
				'default'      => 'yes',
				'return_value' => 'yes',
				'selectors'    => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'display: inline-flex',
				),
			)
		);

		$this->add_control(
			'onsale_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'color: {{VALUE}}',
				),
				'condition' => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_text_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'background-color: {{VALUE}}',
				),
				'condition' => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'      => 'onsale_typography',
				'selector'  => '{{WRAPPER}} ul.products li.product span.onsale',
				'condition' => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'border-radius: {{SIZE}}{{UNIT}}',
				),
				'condition'  => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_width',
			array(
				'label'      => esc_html__( 'Width', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'min-width: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_height',
			array(
				'label'      => esc_html__( 'Height', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'selectors'  => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_horizontal_position',
			array(
				'label'                => esc_html__( 'Position', 'thim-elementor-kit' ),
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'thim-elementor-kit' ),
						'icon'  => 'eicon-h-align-right',
					),
				),
				'selectors'            => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => '{{VALUE}}',
				),
				'selectors_dictionary' => array(
					'left'  => 'right: auto; left: 0',
					'right' => 'left: auto; right: 0',
				),
				'condition'            => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->add_control(
			'onsale_distance',
			array(
				'label'      => esc_html__( 'Distance', 'thim-elementor-kit' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'em' ),
				'range'      => array(
					'px' => array(
						'min' => -20,
						'max' => 20,
					),
					'em' => array(
						'min' => -2,
						'max' => 2,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} ul.products li.product span.onsale' => 'margin: {{SIZE}}{{UNIT}};',
				),
				'condition'  => array(
					'show_onsale_flash' => 'yes',
				),
			)
		);

		$this->end_controls_section();
	}
}

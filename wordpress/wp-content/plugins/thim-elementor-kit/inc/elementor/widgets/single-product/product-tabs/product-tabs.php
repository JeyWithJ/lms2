<?php
namespace Elementor;

use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

class Thim_Ekit_Widget_Product_Tabs extends Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-ekits-product-tabs';
	}

	public function get_title() {
		return esc_html__( 'Thim Product Tabs', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-product-tabs';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY_SINGLE_PRODUCT );
	}

	public function get_help_url() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_product_tabs_style',
			array(
				'label' => esc_html__( 'Tabs', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'tabs_style' );

		$this->start_controls_tab(
			'normal_tabs_style',
			array(
				'label' => esc_html__( 'Normal', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'tab_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'tab_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'tabs_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a' => 'border-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'active_tabs_style',
			array(
				'label' => esc_html__( 'Active', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'active_tab_text_color',
			array(
				'label'     => esc_html__( 'Text Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'active_tab_bg_color',
			array(
				'label'     => esc_html__( 'Background Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'alpha'     => false,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs' => 'border-bottom-color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'active_tabs_border_color',
			array(
				'label'     => esc_html__( 'Border Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs .woocommerce-Tabs-panel' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li.active a' => 'border-color: {{VALUE}} {{VALUE}} {{active_tab_bg_color.VALUE}} {{VALUE}}',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'separator_tabs_style',
			array(
				'type' => Controls_Manager::DIVIDER,
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_typography',
				'label'    => esc_html__( 'Typography', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li a',
			)
		);

		$this->add_control(
			'tab_border_radius',
			array(
				'label'     => esc_html__( 'Border Radius', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::SLIDER,
				'selectors' => array(
					'{{WRAPPER}} .woocommerce-tabs ul.wc-tabs li' => 'border-radius: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
				),
			)
		);

		$this->end_controls_section();
	}

	public function render() {
		do_action( 'thim-ekit/modules/single-product/before-preview-query' );

		$product = wc_get_product( false );

		if ( ! $product ) {
			return;
		}

		$settings = $this->get_settings_for_display();
		?>

		<div class="thim-ekit-single-product__tabs">
			<?php wc_get_template( 'single-product/tabs/tabs.php' ); ?>
		</div>

		<?php
		if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
			?>
			<script>
				jQuery( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
			</script>
			<?php
		}

		do_action( 'thim-ekit/modules/single-product/after-preview-query' );
	}
}

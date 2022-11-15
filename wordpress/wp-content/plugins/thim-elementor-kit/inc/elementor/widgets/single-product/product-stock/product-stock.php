<?php
namespace Elementor;

use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

class Thim_Ekit_Widget_Product_Stock extends Widget_Base {

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-ekits-product-stock';
	}

	public function get_title() {
		return esc_html__( 'Thim Product Stock', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-product-stock';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY_SINGLE_PRODUCT );
	}

	public function get_help_url() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_product_stock_style',
			array(
				'label' => esc_html__( 'Style', 'thim-elementor-kit' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'     => esc_html__( 'Stock Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekit-single-product__stock .stock' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'out_of_stock_color',
			array(
				'label'     => esc_html__( 'Out of stock Color', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .thim-ekit-single-product__stock .stock.out-of-stock' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'text_typography',
				'label'    => esc_html__( 'Typography', 'thim-elementor-kit' ),
				'selector' => '{{WRAPPER}} .thim-ekit-single-product__stock .stock',
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

		<div class="thim-ekit-single-product__stock">
			<?php echo wc_get_stock_html( $product ); ?>
		</div>

		<?php
		do_action( 'thim-ekit/modules/single-product/after-preview-query' );
	}
}

<?php
namespace Elementor;

use Elementor\Plugin;
use Elementor\Group_Control_Image_Size;
use Elementor\Utils;

class Thim_Ekit_Widget_Archive_Product extends Thim_Ekit_Products_Base {

	protected $current_permalink;

	public function __construct( $data = array(), $args = null ) {
		parent::__construct( $data, $args );
	}

	public function get_name() {
		return 'thim-ekits-archive-product';
	}

	public function get_title() {
		return esc_html__( 'Thim Archive Product', 'thim-elementor-kit' );
	}

	public function get_icon() {
		return 'eicon-archive-posts';
	}

	public function get_categories() {
		return array( \Thim_EL_Kit\Elementor::CATEGORY_ARCHIVE_PRODUCT );
	}

	public function get_help_url() {
		return '';
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_content',
			array(
				'label' => esc_html__( 'Content', 'thim-elementor-kit' ),
			)
		);

		$this->add_control(
			'columns',
			array(
				'label'     => esc_html__( 'Columns', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => 4,
				'selectors' => array(
					'body {{WRAPPER}} ul.products.thim-ekit-archive-product__grid' => 'grid-template-columns: repeat({{VALUE}}, 1fr);',
				),
			)
		);

		$this->add_control(
			'rows',
			array(
				'label'   => esc_html__( 'Rows', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => '',
			)
		);

		$this->add_control(
			'limit',
			array(
				'label'     => esc_html__( 'Limit', 'thim-elementor-kit' ),
				'type'      => Controls_Manager::NUMBER,
				'default'   => '-1',
				'condition' => array(
					'rows' => '',
				),
			)
		);

		$this->add_control(
			'paginate',
			array(
				'label'   => esc_html__( 'Paginate', 'thim-elementor-kit' ),
				'type'    => Controls_Manager::SWITCHER,
				'default' => 'yes',
			)
		);

		$this->end_controls_section();

		parent::register_controls();
	}

	protected function render() {
		if ( WC()->session ) {
			wc_print_notices();
		}

		$settings = $this->get_settings_for_display();

		$shortcode = $this->get_shortcode_object( $settings );
		$content   = $shortcode->get_content();
		?>

		<div class="thim-ekit-archive-product">
			<?php
			if ( $content ) {
				$content = str_replace( '<ul class="products', '<ul class="products thim-ekit-archive-product__grid', $content );

				Utils::print_unescaped_internal_string( $content );
			}
			?>
		</div>

		<?php
	}

	protected function get_shortcode_object( $settings ) {
		return new \WC_Shortcode_Products(
			array(
				'columns'  => absint( $settings['columns'] ),
				'rows'     => absint( $settings['rows'] ),
				'paginate' => $settings['paginate'] === 'yes',
				'limit'    => floatval( $settings['limit'] ),
				'cache'    => false,
			),
			'products'
		);
	}
}

<?php
namespace Thim_EL_Kit\Modules\ArchiveProduct;

use Thim_EL_Kit\Modules\Modules;
use Thim_EL_Kit\Custom_Post_Type;
use Thim_EL_Kit\SingletonTrait;

class Init extends Modules {
	use SingletonTrait;

	public function __construct() {
		$this->tab      = 'archive-product';
		$this->tab_name = esc_html__( 'Archive Product', 'thim-elementor-kit' );
		$this->option   = 'thim_ekits_archive_product';

		parent::__construct();
	}

	public function template_include( $template ) {
		$this->template_include = is_shop() || is_product_taxonomy();

		return parent::template_include( $template );
	}
}

Init::instance();

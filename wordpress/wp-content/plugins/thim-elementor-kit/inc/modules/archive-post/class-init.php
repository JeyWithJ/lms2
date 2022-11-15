<?php
namespace Thim_EL_Kit\Modules\ArchivePost;

use Thim_EL_Kit\Modules\Modules;
use Thim_EL_Kit\Custom_Post_Type;
use Thim_EL_Kit\SingletonTrait;

class Init extends Modules {
	use SingletonTrait;

	public function __construct() {
		$this->tab      = 'archive-post';
		$this->tab_name = esc_html__( 'Archive Post', 'thim-elementor-kit' );
		$this->option   = 'thim_ekits_archive_post';

		parent::__construct();

		add_filter( 'thim_ekit/elementor/archive_post/query_posts/query_vars', array( $this, 'query_args' ) );
	}

	public function template_include( $template ) {
		$this->template_include = ( is_archive() || is_search() || is_author() || is_category() || is_home() || is_tag() ) && 'post' == get_post_type();

		return parent::template_include( $template );
	}

	public function query_args( $query_args ) {
		$id   = get_the_ID();
		$type = get_post_meta( $id, Custom_Post_Type::TYPE, true );

		if ( $id && $type && $type === $this->tab && ( $this->is_editor_preview() || $this->is_modules_view() ) ) {
			$query_args = array(
				'post_type' => 'post',
			);
		}

		return $query_args;
	}
}

Init::instance();

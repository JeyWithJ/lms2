<?php
/**
 * Class LP_Submenu_Tools
 */
class LP_Submenu_Tools extends LP_Abstract_Submenu {

	/**
	 * LP_Submenu_Tools constructor.
	 */
	public function __construct() {
		$this->id         = 'learn-press-tools';
		$this->menu_title = __( 'Tools', 'learnpress' );
		$this->page_title = __( 'LearnPress Tools', 'learnpress' );
		$this->priority   = 40;
		$this->callback   = [ $this, 'display' ];

		$this->tabs = apply_filters(
			'learn-press/admin/tools-tabs',
			array(
				'course'   => __( 'Course Data', 'learnpress' ),
				'database' => __( 'Database', 'learnpress' ),
				'template' => __( 'Templates', 'learnpress' ),
			)
		);

		parent::__construct();
		//$this->_process_actions();
	}

	/**
	 * @deprecated 4.1.7.3
	 */
	protected function _process_actions() {
		_deprecated_function( __METHOD__, '4.1.7.3' );
		/*$has_action = true;
		switch ( LP_Request::get( 'page' ) ) {
			default:
				$has_action = false;
		}

		$nonce = LP_Request::get( '_wpnonce' );

		if ( LP_Request::get( 'generate-cron-url' ) && $nonce ) {
			if ( wp_verify_nonce( $nonce ) ) {
				delete_option( 'learnpress_cron_url_nonce' );

				wp_redirect( esc_url_raw( remove_query_arg( array( 'generate-cron-url', '_wpnonce' ) ) ) );
				die();
			}
		}

		if ( $has_action ) {
			die();
		}*/
	}

	public function page_content_database() {
		learn_press_admin_view( 'tools/html-database' );
	}

	public function page_content_template() {
		learn_press_admin_view( 'tools/html-template' );
	}

	public function page_content_course() {
		learn_press_admin_view( 'tools/html-course' );
	}

	/**
	 * Display page
	 */
	public function page_content() {
		parent::page_content();
	}
}

return new LP_Submenu_Tools();

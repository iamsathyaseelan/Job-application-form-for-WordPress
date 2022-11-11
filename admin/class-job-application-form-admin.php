<?php
/**
 * This file will handle all the functionalities of admin.
 *
 * @package Job_Application_Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'Job_Application_Form_Admin' ) ) {
	/**
	 * Class Job_Application_Form_Admin to handle all plugin initialization.
	 */
	class Job_Application_Form_Admin {

		/**
		 * Register all the hooks required by the admin.
		 */
		public function __construct() {
			if ( is_admin() ) {
				add_action( 'admin_menu', array( $this, 'admin_menu' ) );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_styles_and_scripts' ) );
			}
		}

		/**
		 * Add menu page for the admin.
		 *
		 * @return void
		 */
		public function admin_menu() {
			add_menu_page(
				__( 'Job Applications', 'job-application-form' ),
				__( 'Job Applications', 'job-application-form' ),
				'manage_options',
				JOB_APPLICATION_FORM_SLUG,
				array( $this, 'display_page' ),
				'dashicons-schedule',
				3
			);
		}

		/**
		 * Display applications in the page.
		 *
		 * @return void
		 */
		public function display_page() {
			require_once JOB_APPLICATION_FORM_ABSPATH . 'admin/partials/job-application-form-admin-list-table.php';
		}

		/**
		 * Load admin specific scripts.
		 *
		 * @param string $hook The current admin page.
		 *
		 * @return void
		 */
		public function enqueue_styles_and_scripts( $hook ) {
			if ( strpos( $hook, TEST_PROJECT_SLUG ) === false ) {
				return;
			}
			// include files if requires.
		}
	}
}

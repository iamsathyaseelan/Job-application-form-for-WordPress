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
				add_action( 'wp_dashboard_setup', array( $this, 'show_latest_applications' ) );
			}
		}

		/**
		 * Show the latest applications.
		 *
		 * @return void
		 */
		public function show_latest_applications() {
			wp_add_dashboard_widget(
				JOB_APPLICATION_FORM_SLUG . '-widget',
				esc_html__( 'Latest Job Applications', 'job-application-form' ),
				array(
					$this,
					'render_latest_applications_widget',
				)
			);
		}

		/**
		 * Show the latest applications in the widget.
		 *
		 * @return void
		 */
		public function render_latest_applications_widget() {
			global $wpdb;
			$applications = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}applicant_submissions` ORDER BY created_at DESC LIMIT 5 OFFSET 0", ARRAY_A );
			require_once JOB_APPLICATION_FORM_ABSPATH . 'admin/partials/latest-job-applications-widget.php';
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
			if ( strpos( $hook, JOB_APPLICATION_FORM_SLUG ) === false ) {
				return;
			}
			wp_enqueue_script( JOB_APPLICATION_FORM_SLUG . '-admin', plugin_dir_url( __FILE__ ) . 'js/job-application-form.js', array( 'jquery' ), JOB_APPLICATION_FORM_VERSION );
			wp_localize_script(
				JOB_APPLICATION_FORM_SLUG . '-admin',
				'job_application_form_localize_script',
				array(
					'i18n' => array(
						'alert_bulk_delete' => __( 'Are you sure you want to delete multiple applications? This action cannot be undone later.', 'job-application-form' ),
						'alert_delete'      => __( 'Are you sure you want to delete workflow? This action cannot be undone later.', 'job-application-form' ),
					),
				)
			);
		}
	}
}

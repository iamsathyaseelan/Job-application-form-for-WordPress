<?php
/**
 * The core plugin class.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Job_Application_Form' ) ) {
	/**
	 * Job application form main class. It will handle all the file inclusion and initialization process.
	 */
	class Job_Application_Form {
		/**
		 * Property holds the instance of the class after it initialized.
		 *
		 * @var Job_Application_Form $instance Holds the instance of the class.
		 */
		protected static $instance;

		/**
		 * Class constructor.
		 */
		public function __construct() {
			$this->load_dependencies();
			$this->init_public();

		}//end __construct()


		/**
		 * Load the required dependencies for this plugin.
		 *
		 * @return void
		 */
		private function load_dependencies() {
			/*
			 * Include public related files.
			 */
			require_once JOB_APPLICATION_FORM_ABSPATH . 'public/class-job-application-form-public.php';
		}

		/**
		 * Register all the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @return void
		 */
		private function init_public() {
			new Job_Application_Form_Public();
		}

		/**
		 * Run the loader to execute all the hooks with WordPress.
		 *
		 * @return self
		 */
		public static function run() {
			if ( is_null( self::$instance ) || ! self::$instance instanceof Job_Application_Form ) {
				self::$instance = new self();
			}

			return self::$instance;
		}
	}
}
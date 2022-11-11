<?php
/**
 * This file will handle all the functionalities of frontend.
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Job_Application_Form_Public' ) ) {
	/**
	 * This class is responsible for showing application form and collecting applications.
	 */
	class Job_Application_Form_Public {

		/**
		 * Class constructor.
		 */
		public function __construct() {
			if ( ! is_admin() ) {
				add_shortcode( 'applicant_form', array( $this, 'show_application_form' ) );
			}
		}

		public function show_application_form( $attributes ) {
			$default_attributes = array(
				'fields' => '*',//* => show all fields. Later we can extend with more.
			);
			$all_attributes     = shortcode_atts( $default_attributes, $attributes );

			ob_start();
			require_once JOB_APPLICATION_FORM_ABSPATH . 'public/partials/template-application-form.php';

			return ob_get_clean();
		}
	}
}
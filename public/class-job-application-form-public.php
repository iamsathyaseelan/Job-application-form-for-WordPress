<?php
/**
 * This file will handle all the functionalities of frontend.
 * @package Job_Application_Form
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
			add_shortcode( 'applicant_form', array( $this, 'show_application_form' ) );
			add_action(
				'wp_ajax_submit_job_application_form',
				array(
					$this,
					'handle_job_application_form_submission',
				)
			);
			add_action(
				'wp_ajax_nopriv_submit_job_application_form',
				array(
					$this,
					'handle_job_application_form_submission',
				)
			);
			add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Register the JavaScript for the public-facing side of the site.
		 *
		 * @return void
		 */
		public function enqueue_scripts() {
			wp_enqueue_script( JOB_APPLICATION_FORM_SLUG, plugin_dir_url( __FILE__ ) . 'js/job-application-form.js', array( 'jquery' ), JOB_APPLICATION_FORM_VERSION, true );
		}

		/**
		 * Validate and save the applications.
		 *
		 * @return void
		 */
		public function handle_job_application_form_submission() {
			global $wpdb;
			check_ajax_referer( 'job_application_form' );
			$first_name = sanitize_text_field( wp_unslash( ! empty( $_POST['first_name'] ) ? $_POST['first_name'] : '' ) );
			// Validate first name.
			if ( empty( $first_name ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'First name is required', 'job-application-form' ),
					)
				);
			}
			$last_name = sanitize_text_field( wp_unslash( ! empty( $_POST['last_name'] ) ? $_POST['last_name'] : '' ) );
			// Validate last name.
			if ( empty( $last_name ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Last name is required', 'job-application-form' ),
					)
				);
			}
			$address = sanitize_textarea_field( wp_unslash( ! empty( $_POST['address'] ) ? $_POST['address'] : '' ) );
			// Validate address.
			if ( empty( $address ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Present address is required', 'job-application-form' ),
					)
				);
			}
			$email = sanitize_email( wp_unslash( ! empty( $_POST['email'] ) ? $_POST['email'] : '' ) );
			// Validate email address.
			if ( empty( $email ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Email is required', 'job-application-form' ),
					)
				);
			}
			$mobile_number = sanitize_text_field( wp_unslash( ! empty( $_POST['mobile_number'] ) ? $_POST['mobile_number'] : '' ) );
			// Validate mobile number.
			if ( empty( $mobile_number ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Mobile number is required', 'job-application-form' ),
					)
				);
			}
			$post_name = sanitize_text_field( wp_unslash( ! empty( $_POST['post_name'] ) ? $_POST['post_name'] : '' ) );
			// Validate post name.
			if ( empty( $post_name ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Post name is required', 'job-application-form' ),
					)
				);
			}
			// Validate CV.
			if ( empty( $_FILES['cv'] ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'CV is required', 'job-application-form' ),
					)
				);
			}
			// Validate CV size.
			if ( ! empty( $_FILES['cv']['size'] ) && 5000000 < $_FILES['cv']['size'] ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'CV should be less than 5MB', 'job-application-form' ),
					)
				);
			}
			$cv_details = wp_unslash( $_FILES );
			// Upload the CV.
			$cv_upload = wp_handle_upload( $cv_details['cv'], array( 'action' => 'submit_job_application_form' ) );
			if ( ! empty( $cv_upload['error'] ) ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Error in uploading your CV', 'job-application-form' ),
					)
				);
			}
			// Save CV details into media.
			$cv_id = wp_insert_attachment(
				array(
					'guid'           => $cv_upload['url'],
					'post_mime_type' => $cv_upload['type'],
					'post_title'     => basename( $cv_upload['file'] ),
					'post_content'   => '',
					'post_status'    => 'inherit',
				),
				$cv_upload['file']
			);
			// Validate that the CV is properly saved or not.
			if ( is_wp_error( $cv_id ) || ! $cv_id ) {
				wp_send_json(
					array(
						'success' => false,
						'message' => __( 'Error in saving your CV', 'job-application-form' ),
					)
				);
			}
			$time          = current_time( 'mysql', true );
			$insert_status = $wpdb->insert(
				"{$wpdb->prefix}applicant_submissions",
				array(
					'first_name'      => $first_name,
					'last_name'       => $last_name,
					'email_address'   => $email,
					'mobile_number'   => $mobile_number,
					'post_name'       => $post_name,
					'present_address' => $address,
					'cv'              => $cv_id,
					'created_at'      => $time,
					'updated_at'      => $time,
				),
				array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s' )
			);
			if ( $insert_status ) {
				// Get the email content.
				ob_start();
				require_once JOB_APPLICATION_FORM_ABSPATH . 'public/partials/template-application-form-conformation-email.php';
				$mail_content = ob_get_clean();

				// Send email the applicant.
				wp_mail( $email, __( 'Thank you for your application ', 'job-application-form' ), $mail_content );
				wp_send_json(
					array(
						'success' => true,
						'message' => __( 'We have received your application. Shortly you will receive our email.', 'job-application-form' ),
					)
				);
			}
			// Fallback response.
			wp_send_json(
				array(
					'success' => false,
					'message' => __( 'There is some problem in getting your application. Can you please try again later.', 'job-application-form' ),
				)
			);
		}

		/**
		 * Replace the shortcode with the application form.
		 *
		 * @param array $attributes Shortcode attributes.
		 *
		 * @return string
		 */
		public function show_application_form( $attributes ) {
			$default_attributes = array(
				'fields' => '*', // * => show all fields. Later we can extend with more.
			);
			$all_attributes     = shortcode_atts( $default_attributes, $attributes );

			ob_start();
			require_once JOB_APPLICATION_FORM_ABSPATH . 'public/partials/template-application-form.php';

			return ob_get_clean();
		}
	}
}

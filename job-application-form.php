<?php
/**
 * Plugin Name:       Job application form
 * Plugin URI:        https://github.com/iamsathyaseelan/Job-application-form-for-WordPress.git
 * Description:       Create simple form to collect job applications.
 * Version:           1.0.0
 * Author:            Sathyaseelan
 * Author URI:        https://github.com/iamsathyaseelan
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       job-application-form
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

defined( 'JOB_APPLICATION_FORM_VERSION' ) || define( 'JOB_APPLICATION_FORM_VERSION', '1.0.0' );
defined( 'JOB_APPLICATION_FORM_SLUG' ) || define( 'JOB_APPLICATION_FORM_SLUG', 'job-application-form' );
defined( 'JOB_APPLICATION_FORM_PLUGIN_FILE' ) || define( 'JOB_APPLICATION_FORM_PLUGIN_FILE', __FILE__ );
defined( 'JOB_APPLICATION_FORM_ABSPATH' ) || define( 'JOB_APPLICATION_FORM_ABSPATH', rtrim( dirname( JOB_APPLICATION_FORM_PLUGIN_FILE ), '/' ) . '/' );

/**
 * Create required tables on plugin activation.
 *
 * @return void
 */
function activate_job_application_form() {
	require_once JOB_APPLICATION_FORM_ABSPATH . 'includes/class-job-application-form-activator.php';
	Job_Application_Form_Activator::activate();
}//end activate_discount_deals()

register_activation_hook( __FILE__, 'activate_job_application_form' );
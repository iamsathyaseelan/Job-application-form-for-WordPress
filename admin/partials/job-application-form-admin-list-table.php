<?php
/**
 * Provide interface for listing the applications
 *
 * @package    Discount_Deals
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Variable declaration
 *
 * @var Job_Application_Form_Admin $this Class variable.
 */

require_once JOB_APPLICATION_FORM_ABSPATH . 'admin/class-job-application-form-admin-list-table.php';
$application_listing_table = new Job_Application_Form_Admin_List_Table();
$application_listing_table->prepare_items();
?>
	<div class="wrap">
		<div class="job-application-form-fp-loader job-application-form-hidden">
			<div class="job-application-form-lds-ripple">
				<div></div>
				<div></div>
			</div>
		</div>
		<h1 class="wp-heading-inline"><?php esc_html_e( 'Applications', 'job-application-form' ); ?></h1>
		<form method="post">
			<input type="hidden" name="page"
				   value="<?php esc_attr( ! empty( $_REQUEST['page'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['page'] ) ) : '' ); ?>">
			<?php
			$application_listing_table->search_box( 'search', 'search_id' );
			$application_listing_table->display();
			?>
	</div>
<?php

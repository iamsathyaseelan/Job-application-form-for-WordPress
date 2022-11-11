<?php
/**
 * Template to show the form.
 *
 * @package Job_Application_Form
 */

$first_name = '';
$last_name  = '';
$email      = '';
if ( is_user_logged_in() ) {
	$current_user_details = wp_get_current_user();
	$first_name           = $current_user_details->first_name;
	$last_name            = $current_user_details->last_name;
	$email                = $current_user_details->user_email;
}

?>

<form class="job-application-form" enctype="multipart/form-data"
	  action="<?php echo esc_url_raw( admin_url( 'admin-ajax.php' ) ); ?>" method="post">
	<?php
	wp_nonce_field( 'job_application_form' )
	?>
	<div>
		<label for="job_apply_first_name">
			<?php esc_html_e( 'First Name', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="text" name="first_name" id="job_apply_first_name"
			   placeholder="<?php _x( 'Ex: John', 'job-application-form' ); ?>"
			   value="<?php echo esc_attr( $first_name ); ?>"
			   required/>
	</div>
	<div>
		<label for="job_apply_last_name">
			<?php esc_html_e( 'Last Name', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="text" name="last_name" id="job_apply_last_name"
			   placeholder="<?php esc_attr_e( 'Ex: Miller', 'job-application-form' ); ?>"
			   value="<?php echo esc_attr( $last_name ); ?>"
			   required/>
	</div>
	<div>
		<label for="job_apply_address">
			<?php esc_html_e( 'Present Address', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<textarea name="address" id="job_apply_address" required></textarea>
	</div>
	<div>
		<label for="job_apply_email">
			<?php esc_html_e( 'Email Address', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="email" name="email" id="job_apply_email" value="<?php echo esc_attr( $email ); ?>" required/>
	</div>
	<div>
		<label for="job_apply_mobile_number">
			<?php esc_html_e( 'Mobile Number', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="tel" name="mobile_number" id="job_apply_mobile_number"
			   placeholder="<?php _x( 'Ex: +91876543210', 'job-application-form' ); ?>" value="" required/>
	</div>
	<div>
		<label for="job_apply_post_name">
			<?php esc_html_e( 'Post Name', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="text" name="post_name" id="job_apply_post_name" value="" required/>
	</div>
	<div>
		<label>
			<?php esc_html_e( 'CV', 'job-application-form' ); ?> <span class="required">*</span>
		</label>
		<input type="file" name="cv" accept=".doc,.docx,.pdf" required/>
		<p><?php _x( 'The file should be less that 5MB and it\'s format should be docx, doc or pdf.', 'job-application-form' ); ?></p>
	</div>
	<div>
		<input type="hidden" name="action" value="submit_job_application_form"/>
		<button><?php esc_html_e( 'Apply', 'job-application-form' ); ?></button>
	</div>
</form>

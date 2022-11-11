<?php
/**
 * Show the latest applications in the template area.
 *
 * @var array $applications Latest applications.
 *
 * @package Job_Application_Form
 */

if ( ! empty( $applications ) ) {
	foreach ( $applications as $application ) {
		$attachment = wp_get_attachment_url( $application['cv'] );
		?>
		<p><?php echo esc_html( $application['first_name'] ) . ' ' . esc_html( $application['last_name'] ); ?> <?php esc_html_e( 'was applied to the position ', 'job-application-form' ); ?>
			<b><?php echo esc_html( $application['post_name'] ); ?></b>(<a href="<?php echo esc_url_raw( $attachment ); ?>"
																		target="_blank"><?php esc_html_e( 'View CV', 'job-application-form' ); ?></a>).
		</p>
		<?php
	}
}

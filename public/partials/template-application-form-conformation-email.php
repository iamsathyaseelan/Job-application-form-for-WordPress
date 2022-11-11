<?php
/**
 * Variable declaration.
 *
 * @var string $first_name First name.
 * @var string $post_name Post name.
 *
 * @package Job_Application_Form
 */

?>
<html>
<head>
	<title><?php esc_html_e( 'Job application conformation', 'job-application-form' ); ?></title>
</head>
<body>
<p><?php esc_html_e( 'Hi ', 'job-application-form' ); ?> <?php echo esc_html( $first_name ); ?>,</p>
<p>
<?php
	/* translators: %s: Post name */
	echo sprintf( esc_html__( 'Thank you for applying for the post %s.  ', 'job-application-form' ), esc_html( $post_name ) );
?>
	. <?php esc_html_e( 'We will email you the further instructions on the next step. ', 'job-application-form' ); ?></p>
<p><?php esc_html_e( 'Note if you have any other comments or questions for me, feel free to respond to this email as well. ', 'job-application-form' ); ?></p>
<p><?php esc_html_e( 'Thanks, ', 'job-application-form' ); ?></p>
</body>
</html>

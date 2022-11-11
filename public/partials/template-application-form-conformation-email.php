<?php
/**
 * Variable declaration.
 *
 * @var string $first_name First name.
 * @var string $post_name Post name.
 */
?>
<html>
<head>
    <title><?php _e( 'Job application conformation', 'job-application-form' ); ?></title>
</head>
<body>
<p><?php _e( 'Hi ', 'job-application-form' ); ?> <?php echo $first_name; ?>,</p>
<p><?php echo sprintf( __( 'Thank you for applying for the post %s.  ', 'job-application-form' ), $post_name ); ?>
    . <?php _e( 'We will email you the further instructions on the next step. ', 'job-application-form' ); ?></p>
<p><?php _e( 'Note if you have any other comments or questions for me, feel free to respond to this email as well. ', 'job-application-form' ); ?></p>
<p><?php _e( 'Thanks, ', 'job-application-form' ); ?></p>
</body>
</html>
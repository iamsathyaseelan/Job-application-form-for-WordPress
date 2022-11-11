<form class="job-application-form" action="" method="post">
    <div>
        <label>
			<?php _e( 'First Name', 'job-application-form' ); ?>
            <input type="text" name="first_name" required>
        </label>
    </div>
    <div>
        <label>
			<?php _e( 'Last Name', 'job-application-form' ); ?>
            <input type="text" name="last_name" required>
        </label>
    </div>
    <div>
        <label>
			<?php _e( 'Present Address', 'job-application-form' ); ?>
            <textarea name="address" required></textarea>
        </label>
    </div>
    <div>
        <label>
			<?php _e( 'Email Address', 'job-application-form' ); ?>
            <input type="email" name="email" required>
        </label>
    </div>
    <div>
        <label>
			<?php _e( 'Mobile Number', 'job-application-form' ); ?>
            <input type="tel" name="mobile_number" required>
        </label></div>
    <div>
        <label>
			<?php _e( 'Post Name', 'job-application-form' ); ?>
            <input type="text" name="post_name" required>
        </label>
    </div>
    <div>
        <label>
			<?php _e( 'CV', 'job-application-form' ); ?>
            <input type="file" name="cv" required>
        </label>
    </div>
    <div>
        <button><?php _e( 'Apply', 'job-application-form' ); ?></button>
    </div>
</form>
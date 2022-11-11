<?php
/**
 * Fired during plugin activation.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Job_Application_Form_Activator' ) ) {
	/**
	 * Class to handle activation of the plugin
	 */
	class Job_Application_Form_Activator {
		/**
		 * Create required tables during the activation of the plugin.
		 *
		 * @return void
		 */
		public static function activate() {
			global $wpdb, $blog_id;

			// For multisite table prefix.
			if ( is_multisite() ) {
				$blog_ids = $wpdb->get_col( "SELECT blog_id FROM {$wpdb->blogs}" );
			} else {
				$blog_ids = array( $blog_id );
			}
			foreach ( $blog_ids as $id ) {
				if ( is_multisite() ) {
					switch_to_blog( $id );
				}

				self::create_tables();

				if ( is_multisite() ) {
					restore_current_blog();
				}
			}
		}


		/**
		 * Method to create tables.
		 *
		 * @return void
		 */
		public static function create_tables() {
			global $wpdb;

			$collate = '';

			if ( $wpdb->has_cap( 'collation' ) ) {
				$collate = $wpdb->get_charset_collate();
				if ( ! empty( $wpdb->collate ) ) {
					$collate .= " COLLATE $wpdb->collate";
				}
			}

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';

			$applicants_table = "
				CREATE TABLE IF NOT EXISTS {$wpdb->prefix}applicant_submissions (
				    id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
					first_name varchar(255) NOT NULL,
					last_name varchar(255) NOT NULL,
					email_address varchar(255) NOT NULL,
					mobile_number varchar(255) NOT NULL,
					applied_post varchar(255) NOT NULL,
					address text DEFAULT NULL,
				    cv bigint(20) UNSIGNED NOT NULL,
					dd_created_at datetime NOT NULL,
					dd_updated_at datetime NOT NULL, 
					PRIMARY KEY  ( id )
					) $collate;
			";

			dbDelta( $applicants_table );
		}
	}
}
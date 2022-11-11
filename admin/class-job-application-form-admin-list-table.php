<?php
/**
 * The applications listing functionality in admin area.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
}

if ( ! class_exists( 'Job_Application_Form_Admin_List_Table' ) ) {
	/**
	 * Class Job_Application_Form_Admin_List_Table to show applications.
	 */
	class Job_Application_Form_Admin_List_Table extends WP_List_Table {
		/**
		 * Class constructor
		 *
		 * @return void
		 */
		public function __construct() {
			parent::__construct(
				array(
					'singular' => __( 'application', 'job-application-form' ),
					'plural'   => __( 'applications', 'job-application-form' ),
					'ajax'     => false,
				)
			);
		}

		/**
		 * If there is no applications then print the message to the user
		 *
		 * @return void
		 */
		public function no_items() {
			esc_html_e( 'No applications found.' );
		}

		/**
		 * Prepare items to display
		 *
		 * @return void
		 */
		public function prepare_items() {
			global $wpdb;
			$columns  = $this->get_columns();
			$hidden   = get_hidden_columns( $this->screen );
			$sortable = $this->get_sortable_columns();

			$this->process_bulk_action();
			$this->_column_headers = array( $columns, $hidden, $sortable );

			// Add search keyword in where query.
			$search_keyword = ! empty( $_REQUEST['s'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['s'] ) ) : '';
			if ( ! empty( $search_keyword ) ) {
				$search_keyword = "%{$wpdb->esc_like($search_keyword)}%";
			}

			// Set order by query in where.
			$order = ! empty( $_REQUEST['orderby'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['order'] ) ) : 'desc';

			$per_page     = 50;
			$current_page = $this->get_pagenum();
			$offset       = ( $current_page - 1 ) * $per_page;

			// Get total rows in DB.
			$total_items = $wpdb->get_var( "SELECT count(*) FROM `{$wpdb->prefix}applicant_submissions`" );

			if ( empty( $search_keyword ) ) {
				$items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `{$wpdb->prefix}applicant_submissions` ORDER BY created_at $order LIMIT %d OFFSET %d", $per_page, $offset ), ARRAY_A );
			} else {
				$items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM `{$wpdb->prefix}applicant_submissions` WHERE 1 = 1 AND (first_name like %s OR last_name like %s OR email_address like %s OR post_name like %s OR present_address like %s)  ORDER BY created_at $order LIMIT %d OFFSET %d", $search_keyword, $search_keyword, $search_keyword, $search_keyword, $search_keyword, $per_page, $offset ), ARRAY_A );
			}

			$this->set_pagination_args(
				array(
					'total_items' => $total_items,
					'per_page'    => $per_page,
				)
			);

			$this->items = $items;
		}

		/**
		 * Get columns of the table
		 *
		 * @return string[]
		 */
		public function get_columns() {
			return array(
				'cb'              => '<input type="checkbox" />',
				'name'            => __( 'Name', 'job-application-form' ),
				'email_address'   => __( 'Email Address', 'job-application-form' ),
				'mobile_number'   => __( 'Mobile Number', 'job-application-form' ),
				'post_name'       => __( 'Post Name', 'job-application-form' ),
				'present_address' => __( 'Address', 'job-application-form' ),
				'created_at'      => __( 'Applied on', 'job-application-form' ),
				'cv'              => __( 'CV', 'job-application-form' ),
			);
		}

		/**
		 * Columns that can be sortable
		 *
		 * @return array[]
		 */
		public function get_sortable_columns() {
			return array(
				'created_at' => array( 'created_at', false ),
			);
		}

		/**
		 * Do bulk option
		 *
		 * @return void
		 */
		public function process_bulk_action() {
			global $wpdb;
			$current_action = $this->current_action();
			if ( in_array( $current_action, array_keys( $this->get_bulk_actions() ) ) ) {
				$application_ids = sanitize_key( wp_unslash( ! empty( $_REQUEST['application'] ) ? $_REQUEST['application'] : array() ) );
				if ( ! is_array( $application_ids ) ) {
					$application_ids = array( $application_ids );
				}
				if ( ! empty( $application_ids ) ) {
					foreach ( $application_ids as $application_id ) {
						$application_id = intval( $application_id );
						switch ( $current_action ) {
							case 'delete':
								$wpdb->query( $wpdb->prepare( "DELETE FROM `{$wpdb->prefix}applicant_submissions` WHERE id = %d", $application_id ) );
								break;
							default:
								break;
						}
					}
				}
			}
		}

		/**
		 * Bulk actions of the applications
		 *
		 * @return array
		 */
		public function get_bulk_actions() {
			return array(
				'delete' => __( 'Delete', 'job-application-form' ),
			);
		}

		/**
		 * Return default value for the application
		 *
		 * @param array|object $item Application details.
		 * @param string $column_name Column name.
		 *
		 * @return boolean|mixed|string|void
		 */
		public function column_default( $item, $column_name ) {
			return $item[ $column_name ];
		}

		/**
		 * Return CV details.
		 *
		 * @param array|object $item Application details.
		 *
		 * @return string
		 */
		public function column_cv( $item ) {
			$attachment = wp_get_attachment_url( $item['cv'] );
			if ( empty( $attachment ) ) {
				return __( "Attachment not found!", 'job-application-form' );
			}

			return sprintf( '<a href="%s" target="_blank">%s</a>', $attachment, __( 'View CV', 'job-application-form' ) );
		}

		/**
		 * Format created at time to site's time format
		 *
		 * @param array $item Application details.
		 *
		 * @return string
		 */
		public function column_created_at( $item ) {
			return get_date_from_gmt( $item['created_at'], get_option( 'date_format' ) . ' ' . get_option( 'time_format' ) );
		}

		/**
		 * Display Edit & Delete option for WorkFlow
		 *
		 * @param array $item Application details.
		 *
		 * @return string
		 */
		public function column_name( $item ) {
			$page    = esc_attr( ! empty( $_REQUEST['page'] ) ? $_REQUEST['page'] : '' );
			$actions = array(
				'delete' => sprintf( '<a href="?page=%s&action=%s&application=%s">%s</a>', $page, 'delete', $item['id'], __( 'Delete', 'job-application-form' ) ),
			);

			return sprintf( '%1$s %2$s', sprintf( '<p>%s</p>', $item['first_name'] . " " . $item['last_name'] ), $this->row_actions( $actions ) );
		}

		/**
		 * Multi select checkbox
		 *
		 * @param array|object $item Application details.
		 *
		 * @return string
		 */
		public function column_cb( $item ) {
			return sprintf( '<input type="checkbox" name="application[]" value="%s" />', $item['id'] );
		}

	}

}
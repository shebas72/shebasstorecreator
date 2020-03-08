<?php

namespace wpbuddy\plugins\CommentRating;

class Backend {

	/**
	 * Admin CSS styles
	 *
	 * @since  1.4.1
	 * @since  1.6.1 moved to seprate class.
	 * @access public
	 *
	 * @return void
	 */
	public static function admin_head() {

		?>
		<style type="text/css">
			#toplevel_page_wpcommentrating img {
				width: 22px;
				height: 22px;
				margin-top: -3px;
			}
		</style>
		<?php

	}


	/**
	 * Deletes the error log
	 *
	 * @since  1.4.1
	 * @since  1.6.1 moved to separate class.
	 * @access public
	 *
	 * @return void
	 */
	public static function delete_error_log() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		$wpb_comment_rating->set_setting( 'log', array() );
		add_settings_error( 'log_deletion', 0, __( 'Log was deleted', 'comment-rating' ), 'updated' );
	}


	/**
	 * Adds new columns to the overview of posts, pages and custom post types
	 *
	 * @since  1.0
	 * @since  1.6.1 moved to separate class.
	 *
	 * @param array $columns
	 *
	 * @return array
	 */
	public static function manage_posts_columns( $columns ) {

		//array_splice( $columns, 2, count($columns), array( 'wpbph_rating' => __( 'Rating', $this->get_textdomain() ) ) );
		$columns['wpbcr_rating'] = __( 'Rating/Votes', 'comment-rating' );

		return $columns;
	}


	/**
	 * Fills the columns of the edit-comments screen.
	 *
	 * @since  1.0
	 * @since  1.6.1 moved to separate class.
	 *
	 * @param array $column
	 * @param int   $comment_id
	 */
	public static function manage_comments_custom_column( $column, $comment_id ) {

		if ( 'wpbcr_rating' == $column ) {
			$rating = Frontend::get_comment_rating( $comment_id, 'all' );

			printf( '%d/%u', $rating['rating'], $rating['total'] );
		}
	}


	/**
	 * Truncates the IP table
	 *
	 * @since  1.4.1
	 * @since  1.6.1 moved to separate class.
	 * @access public
	 *
	 * @return void
	 */
	public static function truncate_ip_table() {

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		$no_deleted = $wpdb->query( 'TRUNCATE ' . $wpdb->prefix . 'cr_ips' );

		if ( empty( $no_deleted ) ) {
			add_settings_error(
				'wpbcr_truncate_table',
				0,
				__( 'Nothing has been deleted from the IP table.', 'comment-rating' )
			);
		} else {
			add_settings_error(
				'wpbcr_truncate_table',
				0,
				sprintf( __( '%u entries have been deleted from the IP table.', 'comment-rating' ), $no_deleted ),
				'updated'
			);
		}
	}


	/**
	 * @param int    $comment_id
	 * @param string $status "delete" | "approve" | "spam" | "hold"
	 *
	 * @since 1.0.0
	 */
	public static function wp_set_comment_status( $comment_id, $status ) {

		// remove comment karma from parents
		if ( 'hold' == $status OR 'spam' == $status ) {

			// get the parents
			$parents = explode( ',', Tools::get_parent_comments( $comment_id ) );

			// stop if there are no parents
			if ( ! is_array( $parents ) ) {
				return;
			}

			if ( empty( $parents ) ) {
				return;
			}

			$rating = Frontend::get_comment_rating( $comment_id, 'rating' );

			if ( empty( $rating ) ) {
				return;
			}

			// update parents karma
			foreach ( $parents as $parent ) {
				Ajax_Rate::subtract_comment_rating( $parent, 'karma', $rating );
			}

		} // add comment karma to parents
		elseif ( 'approve' == $status ) {

			// get the parents
			$parents = explode( ',', Tools::get_parent_comments( $comment_id ) );

			// stop if there are no parents
			if ( ! is_array( $parents ) ) {
				return;
			}

			if ( empty( $parents ) ) {
				return;
			}

			$rating = Frontend::get_comment_rating( $comment_id, 'rating' );

			if ( empty( $rating ) ) {
				return;
			}

			// update parents karma
			foreach ( $parents as $parent ) {
				Ajax_Rate::add_comment_rating( $parent, 'karma', $rating );
			}

		}

	}


	/**
	 * Prepares the deletion of a comment rating
	 *
	 * @param int $comment_id
	 *
	 * @since 1.0.0
	 */
	public static function prepare_delete_comment_ratings( $comment_id ) {

		$GLOBALS['wpbcr_deleted_parents']        = Tools::get_parent_comments( $comment_id );
		$GLOBALS['wpbcr_deleted_comment_rating'] = intval( get_comment_meta( $comment_id, 'wpbcr_rating', true ) );
	}


	/**
	 * Updates comment_karma fields for parents.
	 *
	 * At this point of time the comment with $comment_id does no longer exist.
	 * Also the commentmeta-fields for this comment have been deleted.
	 *
	 * @since  1.6.1 Moved to a separate class.
	 *
	 * @param int $comment_id
	 */
	public static function delete_comment_ratings( $comment_id ) {

		if ( ! isset( $GLOBALS['wpbcr_deleted_parents'] ) ) {
			return;
		}

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		$wpdb->query( $wpdb->prepare(
			'UPDATE ' . $wpdb->commentmeta . ' SET meta_value = IFNULL( meta_value, 0 ) - (%d) WHERE meta_key = "wpbcr_karma" AND comment_id IN(' . $GLOBALS['wpbcr_deleted_parents'] . ')',
			$GLOBALS['wpbcr_deleted_comment_rating']
		) );

	}


	/**
	 * Fixes a problem with Simple Comment Editing (get HTML sourcecode of the rating)
	 *
	 * @since  1.4.2
	 * @since  1.6.1 Moved to a separate class.
	 * @access public
	 *
	 * @param string $raw_content
	 *
	 * @return string
	 */
	public static function sce_fix( $raw_content ) {

		if ( class_exists( 'Simple_Comment_Editing' ) && false !== strpos( $raw_content, 'class=&quot;wpb-comment-rating' ) ) {
			return preg_replace( '#&lt;div class=&quot;wpb-comment-rating(.*?)&lt;/div&gt;#', '', $raw_content );
		}

		return $raw_content;
	}


	public static function upgrade_161() {

		add_action( 'admin_enqueue_scripts', function () {

			$plugin_file = str_replace( 'classes/', '', __FILE__ );

			wp_enqueue_script( 'wpbcr-upgrade', plugins_url( 'assets/js/upgrade.js', $plugin_file ), 'jquery' );
			wp_enqueue_style( 'wpbcr-upgrade', plugins_url( 'assets/css/upgrade.css', $plugin_file ) );
		} );

		add_action( 'wp_ajax_wpcr_ajax_upgrade', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'upgrade_161_ajax',
		) );
	}


	/**
	 * AJAX call for upgrading to version 1.6.1
	 */
	public static function upgrade_161_ajax() {

		if ( ! check_ajax_referer( 'wbcr_upgrade', '_wpnonce', false ) ) {
			wp_send_json_error( array(
				'message' => 'It seems that you are not allowed to do this.',
			) );
		}

		/**
		 * Fetch karma and save it to the new database.
		 */
		$karma = call_user_func( function () {

			global $wpdb;

			$total = $wpdb->get_var( "SELECT COUNT(meta_value) as ctn FROM {$wpdb->commentmeta} WHERE meta_key = 'wpbcr_karma'" );

			$rows = $wpdb->get_results( "SELECT cm1.comment_id, "
			                            . " ("
			                            . " SELECT cm2.meta_value FROM {$wpdb->commentmeta} as cm2 "
			                            . " WHERE cm2.meta_key = 'wpbcr_karma' AND cm2.comment_id=cm1.comment_id "
			                            . " ORDER BY cm2.meta_id DESC LIMIT 1 "
			                            . " ) as karma "
			                            . " FROM {$wpdb->commentmeta} as cm1 "
			                            . " WHERE cm1.meta_key = 'wpbcr_karma' GROUP BY cm1.comment_id LIMIT 5" );

			$done = 0;

			foreach ( $rows as $row ) {
				$wpdb->insert(
					$wpdb->prefix . 'cr_rating',
					array(
						'comment_id' => $row->comment_id,
						'key'        => 'karma',
						'value'      => $row->karma,
					)
				);

				delete_comment_meta( $row->comment_id, 'wpbcr_karma' );

				$done ++;
			}

			return array(
				'total' => $total,
				'done'  => $done,
			);
		} );

		$rating = call_user_func( function () {

			global $wpdb;

			$total = $wpdb->get_var( "SELECT COUNT(meta_value) as ctn FROM {$wpdb->commentmeta} WHERE meta_key = 'wpbcr_rating'" );

			$rows = $wpdb->get_results( "SELECT cm1.comment_id, "
			                            . " ("
			                            . " SELECT cm2.meta_value FROM {$wpdb->commentmeta} as cm2 "
			                            . " WHERE cm2.meta_key = 'wpbcr_rating' AND cm2.comment_id=cm1.comment_id "
			                            . " ORDER BY cm2.meta_id DESC LIMIT 1 "
			                            . " ) as rating "
			                            . " FROM {$wpdb->commentmeta} as cm1 "
			                            . " WHERE cm1.meta_key = 'wpbcr_rating' GROUP BY cm1.comment_id LIMIT 5" );

			$done = 0;

			foreach ( $rows as $row ) {
				$wpdb->insert(
					$wpdb->prefix . 'cr_rating',
					array(
						'comment_id' => $row->comment_id,
						'key'        => 'rating',
						'value'      => $row->rating,
					)
				);

				delete_comment_meta( $row->comment_id, 'wpbcr_rating' );

				$done ++;
			}

			return array(
				'total' => $total,
				'done'  => $done,
			);
		} );

		$total_rating = call_user_func( function () {

			global $wpdb;

			$total = $wpdb->get_var( "SELECT COUNT(meta_value) as ctn FROM {$wpdb->commentmeta} WHERE meta_key = 'wpbcr_ratings_total'" );

			$rows = $wpdb->get_results( "SELECT cm1.comment_id, "
			                            . " ("
			                            . " SELECT cm2.meta_value FROM {$wpdb->commentmeta} as cm2 "
			                            . " WHERE cm2.meta_key = 'wpbcr_ratings_total' AND cm2.comment_id=cm1.comment_id "
			                            . " ORDER BY cm2.meta_id DESC LIMIT 1 "
			                            . " ) as total "
			                            . " FROM {$wpdb->commentmeta} as cm1 "
			                            . " WHERE cm1.meta_key = 'wpbcr_ratings_total' GROUP BY cm1.comment_id LIMIT 5" );

			$done = 0;

			foreach ( $rows as $row ) {
				$wpdb->insert(
					$wpdb->prefix . 'cr_rating',
					array(
						'comment_id' => $row->comment_id,
						'key'        => 'total',
						'value'      => $row->total,
					)
				);

				delete_comment_meta( $row->comment_id, 'wpbcr_ratings_total' );

				$done ++;
			}

			return array(
				'total' => $total,
				'done'  => $done,
			);
		} );

		$total = $karma['total'] + $rating['total'] + $total_rating['total'];
		$done  = $karma['done'] + $rating['done'] + $total_rating['done'];

		if ( $total <= 0 ) {
			update_option( 'wpbcr_user_should_import', false );
		}

		wp_send_json_success( array(
			'total' => $total,
			'done'  => $done,
		) );
	}

}

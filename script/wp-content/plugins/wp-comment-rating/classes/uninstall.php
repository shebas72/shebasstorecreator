<?php

namespace wpbuddy\plugins\CommentRating;

class Uninstall {

	/**
	 * Shows an error if the user really wants to uninstall the plugin
	 *
	 * @since  1.4.1
	 * @since  1.6.1 moved to separate class.
	 * @access public
	 *
	 * @return void
	 */
	public static function step_1() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		add_settings_error(
			'wpbcr_uninstall',
			0,
			__( 'Really want to uninstall this plugin? Note that every setting and every rating will be lost forever! After the uninstall the plugin will be deactivate itself.', $wpb_comment_rating->get_textdomain() )
			. '<br /><a href="' . esc_url( add_query_arg( array( 'wpb_plugin_page_action' => 'wpbcr_uninstall_step2' ) ) ) . '" class="button wpbcr-button-deletion">' . __( 'Yes', $wpb_comment_rating->get_textdomain() ) . '</a> '
			. '<a href="' . esc_url( add_query_arg( array( 'wpb_plugin_page_action' => '0' ) ) ) . '" class="button button-primary">' . __( 'No', $wpb_comment_rating->get_textdomain() ) . '</a>'
		);
	}


	/**
	 * Uninstalls the plugin and deactivates it.
	 *
	 * @since  1.0.0
	 * @since  1.1.0 added $deactivate parameter
	 * @since  1.6.1 moved to separate class.
	 *
	 * @param bool $deactivate
	 */
	public static function step_2( $deactivate = true ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 * @var \wpdb              $wpdb ;
		 */
		global $wpb_comment_rating, $wpdb;

		// remove all data from the commentmeta table
		$wpdb->query( 'DELETE FROM ' . $wpdb->commentmeta . ' WHERE meta_key LIKE "wpbcr_%"' );

		// remove all data from the usermeta table
		$wpdb->query( 'DELETE FROM ' . $wpdb->usermeta . ' WHERE meta_key LIKE "wpbcr_%"' );

		// remove the IP table
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'cr_ips' );

		// remove rating table
		$wpdb->query( 'DROP TABLE IF EXISTS ' . $wpdb->prefix . 'cr_rating' );

		delete_option( 'wpbcr_user_should_import' );

		if ( $deactivate ) {
			// deactivate this plugin
			deactivate_plugins( $wpb_comment_rating->get_plugin_file() );

			wp_redirect( admin_url( 'plugins.php' ) );

			// do not add this message in __() because the plugin is no longer active
			die( 'Plugin has been uninstalled and deactivated. <a href="' . esc_url( admin_url( 'plugins.php' ) ) . '">Back to administration panel</a>' );
		}
	}
}

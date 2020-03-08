<?php
/*
Plugin Name: Comment Rating by WP-Buddy
Plugin URI: http://wp-buddy.com/products/plugins/wordpress-comment-rating-plugin/
Description: Allows to rate and resort comments
Version: 1.6.6
Author: WPBuddy
Author URI: http://wp-buddy.com
Text Domain: comment-rating
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
	$plugin_data = get_plugin_data( __FILE__ );
	wp_die( sprintf( __( 'You are using PHP in version %1$s. This version is outdated and cannot be used with the %2$s plugin. Please update to the latest PHP version in order to use this plugin. You can ask your provider on how to do this.' ), PHP_VERSION, '<strong>' . $plugin_data['Name'] . '</strong>' ) );
}

$wpb_cr_config = array(
	'plugin_file'         => __FILE__,
	'update_post_url'     => 'http://wp-buddy.com/wp-admin/admin-ajax.php',
	'tracking_url'        => 'http://wp-buddy.com/wp-admin/admin-ajax.php',
	'plugin_action_links' => array(
		array(
			'name'    => 'settings',
			'content' => __( 'Settings' ),
			'href'    => admin_url( 'edit-comments.php?page=wpcommentrating' )
		),
		array(
			'name'    => 'delete',
			'content' => __( 'Uninstall' ),
			'href'    => admin_url( 'edit-comments.php?page=wpcommentrating&tab=settings&wpb_plugin_page_action=wpbcr_uninstall' ),
			'classes' => array( 'delete' )
		),
		array(
			'name'    => 'more',
			'content' => __( 'More plugins by WP-Buddy' ),
			'href'    => 'http://wp-buddy.com',
			'target'  => '_blank'
		),
	),
);

// starting up
require_once( __DIR__ . '/bootstrap.php' );

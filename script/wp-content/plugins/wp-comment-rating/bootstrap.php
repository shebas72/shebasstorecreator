<?php

namespace wpbuddy\plugins\CommentRating;


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The autoloader class
 *
 * @param string $class_name
 *
 * @return bool
 * @since 1.6.1
 */
function wpbcr_autoloader( $class_name ) {

	if ( false === stripos( $class_name, 'wpbuddy\plugins\CommentRating' ) ) {
		return false;
	}

	$class_name = str_replace( 'wpbuddy\plugins\CommentRating\\', '', $class_name );

	$file = trailingslashit( dirname( __FILE__ ) ) . 'classes/' . strtolower( $class_name ) . '.php';

	if ( is_file( $file ) ) {
		require_once( $file );

		return true;
	} else {
		$file = str_replace( 'classes/', 'classes/wpb_plugin/', $file );

		if ( is_file( $file ) ) {
			require_once( $file );

			return true;
		}
	}

	return false;
}


// registering the autoloader function
try {
	spl_autoload_register( '\wpbuddy\plugins\CommentRating\wpbcr_autoloader', true );
} catch ( \Exception $e ) {
	function __autoload( $class_name ) {

		wpbcr_autoloader( $class_name );
	}
}

global $wpb_comment_rating;

if ( ! isset( $wpb_comment_rating ) ) {
	$wpb_comment_rating = new WPB_Comment_Rating( $wpb_cr_config );
}
<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit();
}

if ( ! WP_UNINSTALL_PLUGIN ) {
	exit();
}

require_once( 'wp-comment-rating.php' );

/**
 * @var \wpbuddy\plugins\CommentRating\WPB_Comment_Rating $wpb_comment_rating
 */
global $wpb_comment_rating;

if ( isset( $wpb_comment_rating ) ) {
	$wpb_comment_rating->set_constants();
	$wpb_comment_rating->uninstall( false );
}

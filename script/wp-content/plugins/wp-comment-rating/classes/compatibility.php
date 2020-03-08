<?php


namespace wpbuddy\plugins\CommentRating;

class Compatibility {

	/**
	 * Deletes the object cache for the get_comment call after adding a new comment to prevent adding HTML codes while
	 * sending emails via wp_notifiy_postauthor()
	 *
	 * @param $comment_id
	 * @param $comment_approved
	 *
	 * @return void
	 * @since  1.0
	 * @since  1.6.1 Moved to a separate class.
	 */
	public static function delete_get_comment_cache( $comment_id, $comment_approved ) {

		wp_cache_delete( $comment_id, 'comment' );
		self::deactivate_comment_rating_during_notify();
	}


	/**
	 * This function removes the get_comment filter just before WordPress wants to notify the author of a new comment
	 *
	 * @todo   Important: To remove a hook, the $function_to_remove and $priority arguments must match when the hook was
	 *     added. This goes for both filters and actions. No warning will be given on removal failure.
	 *
	 * @param bool $false always false
	 *
	 * @return bool always false
	 * @since  1.0
	 * @since  1.6.1 Moved to a separate class.
	 */
	public static function deactivate_comment_rating_during_notify( $false = false ) {

		remove_filter( 'get_comment', array( '\wpbuddy\plugins\CommentRating\Frontend', 'get_comment_filter' ), 100 );

		return false; // must always return false
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
}

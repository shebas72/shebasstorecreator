<?php


namespace wpbuddy\plugins\CommentRating;

class Tools {
	/**
	 * Gets the IP address of the user and anonymizes it
	 *
	 * @param bool $hashed Set to true if the IP should be returned by using MD5
	 *
	 * @return string
	 * @since 1.0
	 */
	public static function get_user_ip_addr( $hashed = true ) {

		$REMOTE_ADDR = $_SERVER['REMOTE_ADDR'];
		if ( ! empty( $_SERVER['X_FORWARDED_FOR'] ) ) {
			$X_FORWARDED_FOR = explode( ',', $_SERVER['X_FORWARDED_FOR'] );
			if ( ! empty( $X_FORWARDED_FOR ) ) {
				$REMOTE_ADDR = trim( $X_FORWARDED_FOR[0] );
			}
		} /*
		* Some php environments will use the $_SERVER['HTTP_X_FORWARDED_FOR']
		* variable to capture visitor address information.
		*/
		elseif ( ! empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {
			$HTTP_X_FORWARDED_FOR = explode( ',', $_SERVER['HTTP_X_FORWARDED_FOR'] );
			if ( ! empty( $HTTP_X_FORWARDED_FOR ) ) {
				$REMOTE_ADDR = trim( $HTTP_X_FORWARDED_FOR[0] );
			}
		}
		$ip = preg_replace( '/[^0-9a-f:\., ]/si', '', $REMOTE_ADDR );

		if ( $hashed ) {
			return apply_filters( 'wpbcr_user_ip_addr_hashed', wp_hash( $ip ) );
		}

		return apply_filters( 'wpbcr_user_ip_addr', $ip );
	}


	/**
	 * Returns the parents ids of a comment with $comment_id in a comma separated format
	 *
	 * @since 1.0.0
	 *
	 * @param int $comment_id
	 *
	 * @return string output like 1,2,3,4,5
	 */
	public static function get_parent_comments( $comment_id ) {

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		return $wpdb->get_var(
			$wpdb->prepare(
				'SELECT GROUP_CONCAT( T2.comment_ID SEPARATOR "," )
							FROM (
									SELECT
											@r AS _id,
											(SELECT @r := comment_parent FROM ' . $wpdb->comments . ' WHERE comment_ID = _id) AS comment_parent,
									@l := @l + 1 AS lvl
							FROM
									(SELECT @r := %d, @l := 0) vars,
									' . $wpdb->comments . ' h
							WHERE @r <> 0) T1
					JOIN ' . $wpdb->comments . ' T2
					ON T1._id = T2.comment_ID
					WHERE T2.comment_ID != %d
					ORDER BY T1.lvl DESC',
				$comment_id,
				$comment_id
			)
		);
	}
}

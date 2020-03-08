<?php

namespace wpbuddy\plugins\CommentRating;

class Ajax_Rate {


	/**
	 * Checks if a user can rate the current comment based on the different settings.
	 *
	 * @since 1.6.1
	 *
	 * @param int $comment_id
	 */
	public static function check_if_user_can_rate( $comment_id ) {

		/**
		 * @var \wpbuddy\plugins\CommentRating\WPB_Comment_Rating $wpb_comment_rating
		 * @var \wpdb                                             $wpdb
		 */
		global $wpb_comment_rating, $wpdb;

		// if "only logged-in users are allowed to rate" is active: check if the user is logged in
		if ( (bool) $wpb_comment_rating->get_setting( 'only_logged_in', 0 ) && ! is_user_logged_in() ) {
			if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
				wp_send_json_error( array( 'message' => __( 'You must be logged-in to rate this comment.', $wpb_comment_rating->get_textdomain() ) ) );
			}
			wp_die( __( 'You must be logged-in to rate this comment.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}

		//  if "only logged-in users are allowed to rate" is active: check if user has rated already
		if ( (bool) $wpb_comment_rating->get_setting( 'only_logged_in', 0 ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$rated   = (array) get_user_meta( $user_id, 'wpbcr_rated', true );
			if ( in_array( $comment_id, $rated ) ) {
				if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
					wp_send_json_error( array( 'message' => __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ) ) );
				}
				wp_die( __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
			}
		} else if ( (bool) $wpb_comment_rating->get_setting( 'set_cookies', 0 ) || (bool) $wpb_comment_rating->get_setting( 'log_ips', 1 ) ) {
			if ( (bool) $wpb_comment_rating->get_setting( 'set_cookies', 0 ) ) {

				$rated = array();
				if ( isset( $_COOKIE[ 'wpbcr_rated_' . COOKIEHASH ] ) ) {
					$rated = maybe_unserialize( $_COOKIE[ 'wpbcr_rated_' . COOKIEHASH ] );
				}

				if ( ! is_array( $rated ) ) {
					$rated = array();
				}

				if ( in_array( $comment_id, $rated ) ) {
					if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
						wp_send_json_error( array( 'message' => __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ) ) );
					}
					wp_die( __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
				}
			}

			// check if IP logging is ON: If so check if the current IP address is in the database already
			if ( (bool) $wpb_comment_rating->get_setting( 'log_ips', 1 ) ) {
				$user_ip = Tools::get_user_ip_addr( (bool) $wpb_comment_rating->get_setting( 'hash_ips', 1 ) );

				// remove old entries
				$hours = intval( $wpb_comment_rating->get_setting( 'log_ips', 24 ) );
				$wpdb->query( $wpdb->prepare( 'DELETE FROM ' . $wpdb->prefix . 'cr_ips WHERE ADDDATE( cr_time, INTERVAL %d HOUR ) < NOW()', $hours ) );
				unset( $hours );

				$res = $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'cr_ips WHERE cr_ip = %s AND cr_comment_id = %d', $user_ip, $comment_id ) );

				if ( ! is_int( $res ) && $res > 0 ) {
					if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
						wp_send_json_error( array( 'message' => __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ) ) );
					}
					wp_die( __( 'You have already rated this comment.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
				}
				unset( $res );
			}
		}
	}


	/**
	 * Check if the vote direction is allowed.
	 *
	 * @since 1.6.1
	 *
	 * @param string $vote_direction 'up' or 'down'
	 * @param int    $comment_id
	 */
	public static function check_vote_direction( $vote_direction, $comment_id ) {

		/**
		 * @var \wpbuddy\plugins\CommentRating\WPB_Comment_Rating $wpb_comment_rating
		 * @var \wpdb                                             $wpdb
		 */
		global $wpb_comment_rating, $wpdb;

		if ( 'up' == $vote_direction && ! (bool) $wpb_comment_rating->get_setting( 'is_vote_up', 1 ) ) {
			wp_die( __( 'Voting up has been disabled.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}

		if ( 'down' == $vote_direction && ! (bool) $wpb_comment_rating->get_setting( 'is_vote_down', 1 ) ) {
			wp_die( __( 'Voting down has been disabled.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}

		// Check if the comment exists.
		if ( 1 != (int) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . $wpdb->comments . ' WHERE comment_id=%d', $comment_id ) ) ) {
			wp_die( __( 'There is no comment with this comment ID.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}
	}


	/**
	 * Rates a comment.
	 *
	 * @param int    $comment_id
	 * @param string $vote_direction
	 */
	public static function rate( $comment_id, $vote_direction ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( 'up' === $vote_direction ) {
			$updated = self::add_comment_rating( $comment_id, 'rating' );
		} else {
			$updated = self::subtract_comment_rating( $comment_id, 'rating' );
		}

		if ( $updated <= 0 ) {
			wp_die( __( 'Comment rating could not be updated', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}
	}


	/**
	 * Updates the karma of a comment and its parents.
	 *
	 * @param int    $comment_id
	 * @param string $vote_direction 'up' | 'down'
	 */
	public static function update_karma( $comment_id, $vote_direction ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( 'up' === $vote_direction ) {
			$updated = self::add_comment_rating( $comment_id, 'karma' );
		} else {
			$updated = self::subtract_comment_rating( $comment_id, 'karma' );
		}

		if ( $updated <= 0 ) {
			wp_die( __( 'Comment karma could not be updated', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}

		/**
		 * Update parents
		 */
		$parent_comment_ids = explode( ',', Tools::get_parent_comments( $comment_id ) );
		$parent_comment_ids = array_filter( $parent_comment_ids );

		foreach ( $parent_comment_ids as $parent_comment_id ) {

			if ( 'up' === $vote_direction ) {
				$updated = self::add_comment_rating( $parent_comment_id, 'karma' );
			} else {
				$updated = self::subtract_comment_rating( $parent_comment_id, 'karma' );
			}

			if ( false === $updated ) {
				$wpb_comment_rating->log(
					sprintf(
						__( 'Could not update parent comment with ID %1$s from child comment with ID %2$s. If this errors persists, please inform the author of this plugin. Thanks!', $wpb_comment_rating->get_textdomain() ),
						'<a target="_blank" href="' . get_comment_link( $parent_comment_id ) . '">' . $parent_comment_id . '</a>',
						'<a target="_blank" href="' . get_comment_link( $comment_id ) . '">' . $comment_id . '</a>'
					)
				);
			}
		}
	}


	/**
	 * Update user rating.
	 *
	 * @param int $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function update_user_rating( $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		// update user ratings if the user is logged in
		if ( (bool) $wpb_comment_rating->get_setting( 'only_logged_in', 0 ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();
			$rated   = (array) get_user_meta( $user_id, 'wpbcr_rated', true );
			$rated[] = $comment_id;
			$rated   = array_unique( $rated );
			update_user_meta( $user_id, 'wpbcr_rated', $rated );
		}
	}


	/**
	 * Sets cookies, if active.
	 *
	 * @param $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function set_cookies( $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( (bool) $wpb_comment_rating->get_setting( 'set_cookies', 0 ) ) {
			$rated = array();

			if ( isset( $_COOKIE[ 'wpbcr_rated_' . COOKIEHASH ] ) ) {
				$rated = maybe_unserialize( $_COOKIE[ 'wpbcr_rated_' . COOKIEHASH ] );
			}

			if ( ! is_array( $rated ) ) {
				$rated = array();
			}

			$rated[]     = $comment_id;

			$cookie_time = intval( $wpb_comment_rating->get_setting( 'cookie_time', 48 ) );
			$cookie_time = intval( sprintf( '%u', $cookie_time ) ); // makes an unsigned int

			$expire      = time() + ( $cookie_time * HOUR_IN_SECONDS );

			setcookie( 'wpbcr_rated_' . COOKIEHASH, serialize( $rated ), $expire, COOKIEPATH, COOKIE_DOMAIN, ( 'https' === parse_url( home_url(), PHP_URL_SCHEME ) ) );
		}

	}


	/**
	 * Logs IP addresses to database.
	 *
	 * @param int $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function log_ips( $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 * @var \wpdb              $wpdb
		 */
		global $wpb_comment_rating, $wpdb;

		// insert the IP address of the users but first delete all old entries
		if ( (bool) $wpb_comment_rating->get_setting( 'log_ips', 1 ) ) {
			$user_ip = Tools::get_user_ip_addr( (bool) $wpb_comment_rating->get_setting( 'hash_ips', 1 ) );

			$wpdb->query( $wpdb->prepare(
				'INSERT INTO ' . $wpdb->prefix . 'cr_ips (cr_ip, cr_comment_id) '
				. ' VALUES (%s, %d) '
				. ' ON DUPLICATE KEY UPDATE cr_time = CURRENT_TIMESTAMP ',
				$user_ip, $comment_id )
			);
		}

	}


	/**
	 * Updates the total number of ratings.
	 *
	 * @param int $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function update_rating_count( $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		$updated = self::add_comment_rating( $comment_id, 'total' );

		if ( $updated <= 0 ) {
			wp_die( __( 'Total number of ratings could not be updated', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}
	}


	/**
	 * Rate a comment via AJAX.
	 *
	 * @since 1.6.1
	 *
	 * @global \wpdb $wpdb
	 */
	public static function fetch_request() {

		/**
		 * @var \wpbuddy\plugins\CommentRating\WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( ! is_a( $wpb_comment_rating, '\wpbuddy\plugins\CommentRating\WPB_Comment_Rating' ) ) {
			wp_die( __( 'An error occurred.', $wpb_comment_rating->get_textdomain() ) );
		}

		// check nonces, if used
		if ( (bool) $wpb_comment_rating->get_setting( 'use_nonces', true ) ) {
			check_ajax_referer( 'wpbcr_ajax_comment', 'wpbcr_nonce' );
		}

		/**
		 * Fetch input vars.
		 */
		$comment_id     = filter_input( INPUT_GET, 'wpbcr_id', FILTER_VALIDATE_INT );
		$vote_direction = isset( $_GET['whereto'] ) ? strtolower( sanitize_text_field( $_GET['whereto'] ) ) : 'up';

		/**
		 * Check input vars.
		 */
		if ( empty( $comment_id ) ) {
			wp_die( __( 'No comment ID was found.', $wpb_comment_rating->get_textdomain() ), __( 'Comment Rating Plugin Error', $wpb_comment_rating->get_textdomain() ) );
		}

		self::check_if_user_can_rate( $comment_id );

		self::check_vote_direction( $vote_direction, $comment_id );

		self::rate( $comment_id, $vote_direction );

		self::update_karma( $comment_id, $vote_direction );

		self::update_user_rating( $comment_id );

		self::update_rating_count( $comment_id );

		self::set_cookies( $comment_id );

		self::log_ips( $comment_id );

		# Check if the request comes from a jQuery request. If so, return json data. Otherwise redirect the user back to the post.
		if ( isset( $_SERVER['HTTP_X_REQUESTED_WITH'] ) && 'xmlhttprequest' == strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) {
			wp_send_json_success( array(
				'message' => __( 'Thanks for rating!', $wpb_comment_rating->get_textdomain() ),
			) );
		}

		wp_redirect( get_comment_link( $comment_id ) );

	}


	/**
	 * @param int    $comment_id
	 * @param string $key
	 * @param int    $x The value that gets add.
	 *
	 * @return int
	 */
	public static function add_comment_rating( $comment_id, $key, $x = 1 ) {

		global $wpdb;

		$sql = "INSERT INTO {$wpdb->prefix}cr_rating "
		       . ' ( comment_id, `key`, `value` ) VALUES ( %d, %s, %d ) '
		       . ' ON DUPLICATE KEY UPDATE `value` = `value` + %d';

		return $wpdb->query( $wpdb->prepare( $sql, $comment_id, $key, $x, $x ) );
	}


	/**
	 * @param int    $comment_id
	 * @param string $key
	 * @param int    $x The value for subtracting
	 *
	 * @return int
	 */
	public static function subtract_comment_rating( $comment_id, $key, $x = 1 ) {

		global $wpdb;

		$sql = "INSERT INTO {$wpdb->prefix}cr_rating "
		       . ' ( comment_id, `key`, `value` ) VALUES ( %d, %s, - %d ) '
		       . ' ON DUPLICATE KEY UPDATE `value` = `value` - %d';

		return $wpdb->query( $wpdb->prepare( $sql, $comment_id, $key, $x, $x ) );
	}


	/**
	 * @param int    $comment_id
	 * @param string $key
	 *
	 * @return int
	 */
	public static function get_comment_rating( $comment_id, $key = 'karma' ) {

		global $wpdb;

		return (int) $wpdb->get_var( $wpdb->prepare(
			"SELECT `value` FROM {$wpdb->prefix}cr_rating WHERE `key` = %s and comment_id = %d",
			$key,
			$comment_id
		) );
	}

}

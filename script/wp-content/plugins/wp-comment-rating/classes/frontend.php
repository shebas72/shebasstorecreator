<?php

namespace wpbuddy\plugins\CommentRating;

class Frontend {

	/**
	 * WHERE clause for the comments query.
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public static function sort_comments_query( $args ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( ! (bool) $wpb_comment_rating->get_setting( 'is_resorting', 1 ) ) {
			return $args;
		}

		$args['orderby'] = 'cr.value';
		$args['order']   = 'ASC';

		return $args;
	}


	/**
	 * SQL clauses for the comments query.
	 *
	 * @param array             $pieces
	 * @param \WP_Comment_Query $comment_query
	 *
	 * @return array
	 */
	public static function comments_clauses( $pieces, $comment_query ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( ! (bool) $wpb_comment_rating->get_setting( 'is_resorting', 1 ) ) {
			return $pieces;
		}

		global $wpdb;

		$pieces['fields'] .= ', IFNULL( cr.value, 0 ) as karma ';

		$pieces['orderby'] = sprintf(
			' karma+0 DESC%s %s',
			empty( $pieces['orderby'] ) ? '' : ',',
			$pieces['orderby']
		);

		$pieces['join'] .= " LEFT JOIN {$wpdb->prefix}cr_rating cr "
		                   . " ON ( {$wpdb->comments}.comment_ID = cr.comment_id "
		                   . " AND cr.key = 'karma' )";

		return $pieces;
	}


	/**
	 * @param \WP_Comment $comment
	 *
	 * @return \WP_Comment
	 */
	public static function get_comment_filter( $comment ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( is_feed() ) {
			return $comment;
		}

		// stop here if the comment_id is not available
		if ( ! is_object( $comment ) ) {
			return $comment;
		}

		// do not allow rating for other comment types then standard comments
		if ( ! empty( $comment->comment_type ) ) {
			return $comment;
		}

		// only do all this once per comment. So break here if the function has been executed already.
		if ( isset( $comment->wpb_cr_karma_added ) && $comment->wpb_cr_karma_added ) {
			return $comment;
		}

		if ( ! self::is_current_post_type_allowed() ) {
			return $comment;
		}

		$rating = self::get_comment_rating( $comment->comment_ID, 'all' );

		$elements = array();
		self::fetch_down_voting_html( $elements, $comment->comment_ID );
		self::fetch_up_voting_html( $elements, $comment->comment_ID );
		self::fetch_total_rating_html( $elements, $rating['rating'] );

		ksort( $elements );

		// Hide threshold
		$hide_threshold         = intval( $wpb_comment_rating->get_setting( 'hide_threshold', 0 ) );
		$comment->wpbcr_display = apply_filters(
			'wpbcr_comment_display',
			! ( 0 != $hide_threshold && $hide_threshold >= $rating['rating'] ),
			$comment
		);

		$elements = apply_filters( 'wpbcr_output_elements', $elements, $comment );

		# save for a later use (maybe for theme authors)
		$comment->comment_wpbcr_elements = $elements;

		$classes = apply_filters( 'wpbcr_rating_classes', array( 'wpb-comment-rating' ), $comment );

		$content = '<div class="' . implode( ' ', $classes ) . '">';

		foreach ( $elements as $element ) {
			$content .= $element;
		}

		$content .= ' <span style="display:none;" class="wpbcr-loader wpbcr-icon wpbcr-icon-cog wpbcr-icon-spin"></span></div>';

		$comment->comment_content .= apply_filters( 'wpbcr_output_html', $content, $comment );

		$comment->wpb_cr_karma_added = true;

		return $comment;
	}


	/**
	 * Returns ratings for a comment.
	 *
	 * @param int    $comment_id
	 * @param string $type all|total|rating|karma
	 *
	 * @since 1.6.1
	 *
	 * @return array
	 */
	public static function get_comment_rating( $comment_id, $type = 'all' ) {

		global $wpdb;

		$ratings_results = $wpdb->get_results( $wpdb->prepare(
			"SELECT `key`, `value` FROM {$wpdb->prefix}cr_rating WHERE comment_id = %d", $comment_id
		) );

		$ratings = array();

		if ( is_array( $ratings_results ) ) {
			foreach ( $ratings_results as $ratings_result ) {
				$ratings[ $ratings_result->key ] = $ratings_result->value;
			}
		}

		$ratings = wp_parse_args( $ratings, array(
			'total'  => 0,
			'rating' => 0,
			'karma'  => 0,
		) );

		$ratings = array_map( 'intval', $ratings );

		if ( isset( $ratings[ $type ] ) ) {
			return $ratings[ $type ];
		}

		return $ratings;
	}


	/**
	 * Checks if the current post type allows rating.
	 *
	 * @return bool
	 */
	public static function is_current_post_type_allowed() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating, $post;

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return false;
		}

		$allowed_post_types = array_filter( (array) $wpb_comment_rating->get_setting( 'post_types' ) );

		if ( count( $allowed_post_types ) > 0 ) {
			$post_type = get_post_type( $post );
			if ( is_string( $post_type ) && ! in_array( $post_type, $allowed_post_types ) ) {
				return false;
			}
		}

		return true;
	}


	/**
	 * Adds down-rating HTML to $elements.
	 *
	 * @param array $elements
	 * @param int   $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function fetch_down_voting_html( &$elements, $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		// Down voting
		if ( ! (bool) $wpb_comment_rating->get_setting( 'is_vote_down', 1 ) ) {
			return;
		}

		$icon      = $wpb_comment_rating->get_setting( 'vote_down_icon', 'arrow-circle-down' );
		$html_icon = $wpb_comment_rating->get_setting( 'vote_down_html_icon' );

		$text = '';

		if ( ! empty( $html_icon ) ) {
			$text  = $html_icon;
			$class = '';
		} elseif ( empty( $icon ) ) {
			$class = 'arrow-circle-down';
		} else {
			$class = $icon;
		}

		$order = self::_find_element_order(
			$elements,
			(int) $wpb_comment_rating->get_setting( 'vote_down_position', 3 )
		);

		$elements[ $order ] = sprintf(
			'<a title="%s" class="wpbcr-rate-down wpbcr-icon wpbcr-icon-%s" rel="nofollow" href="#" data-wpbcr_whereto="down" data-wpbcr_id="%d">%s</a>',
			esc_attr__( 'Vote down', 'comment-rating' ),
			esc_attr( $class ),
			esc_attr( $comment_id ),
			$text
		);

	}


	/**
	 * Adds up-rating HTML to $elements.
	 *
	 * @param array $elements
	 * @param int   $comment_id
	 *
	 * @since 1.6.1
	 */
	public static function fetch_up_voting_html( &$elements, $comment_id ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( ! (bool) $wpb_comment_rating->get_setting( 'is_vote_up', 1 ) ) {
			return;
		}
		$icon      = $wpb_comment_rating->get_setting( 'vote_up_icon', 'arrow-circle-up' );
		$html_icon = $wpb_comment_rating->get_setting( 'vote_up_html_icon' );

		$text = '';

		if ( ! empty( $html_icon ) ) {
			$text  = $html_icon;
			$class = '';
		} elseif ( empty( $icon ) ) {
			$class = 'arrow-circle-up';
		} else {
			$class = $icon;
		}

		$order = self::_find_element_order(
			$elements,
			(int) $wpb_comment_rating->get_setting( 'vote_up_position', 1 )
		);

		$elements[ $order ] = sprintf(
			'<a title="%s" class="wpbcr-rate-up wpbcr-icon wpbcr-icon-%s" rel="nofollow" href="#" data-wpbcr_whereto="up" data-wpbcr_id="%d">%s</a>',
			esc_attr__( 'Vote dup', 'comment-rating' ),
			esc_attr( $class ),
			esc_attr( $comment_id ),
			$text
		);

	}


	/**
	 * Adds the number of total ratings as HTML.
	 *
	 * @param array $elements
	 * @param int   $rating
	 *
	 * @since 1.6.1
	 */
	public static function fetch_total_rating_html( &$elements, $rating ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		if ( ! (bool) $wpb_comment_rating->get_setting( 'is_total_rating', 1 ) ) {
			return;
		}

		$str = $wpb_comment_rating->get_setting( 'total_rating_string', '(%d)' );
		if ( false === strpos( $str, '%d' ) ) {
			$str = '(%d)';
		}

		$str = str_replace( '%d', '<span class="wpbcr-r">%d</span>', $str );

		$order = self::_find_element_order(
			$elements,
			(int) $wpb_comment_rating->get_setting( 'total_rating_position', 2 )
		);

		$rating = sprintf( $str, $rating );

		$elements[ $order ] = sprintf( '<span class="wpbcr-rating">%s</span>', $rating );

	}


	/**
	 * @param array $elements
	 * @param int   $i
	 *
	 * @return int
	 */
	public static function _find_element_order( &$elements, $i = 1 ) {

		if ( ! is_int( $i ) ) {
			$i = 1;
		}
		while ( true ) {
			if ( ! isset( $elements[ $i ] ) ) {
				return $i;
			}
			$i ++;
		}

		return 0;
	}


	/**
	 * Enqueues the scripts and styles on the frontend side.
	 *
	 * @since 1.0
	 * @since 1.6.1 moved to separate file.
	 */
	public static function enqueue_scripts() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		wp_enqueue_script( 'wpbcr_frontend_js', $wpb_comment_rating->plugins_url( 'assets/js/wpb-cr-frontend.js' ), array( 'jquery' ) );

		wp_enqueue_style( 'wpbcr_frontend_css', $wpb_comment_rating->plugins_url( 'assets/css/wpb-cr-frontend.css' ) );

		$html_vote_up_icon   = $wpb_comment_rating->get_setting( 'vote_up_html_icon' );
		$html_vote_down_icon = $wpb_comment_rating->get_setting( 'vote_down_html_icon' );

		if ( ( (bool) $wpb_comment_rating->get_setting( 'is_vote_up', 1 ) && empty( $html_vote_up_icon ) ) OR ( (bool) $wpb_comment_rating->get_setting( 'is_vote_down', 1 ) && empty( $html_vote_down_icon ) ) ) {
			wp_enqueue_style( 'wpbcr_frontend_css_awesome', $wpb_comment_rating->plugins_url( 'assets/css/wpb-cr-frontend-awesome.css' ) );
		}

		wp_localize_script( 'wpbcr_frontend_js', 'WPBAjaxCommentRating', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'a'       => 'wpbcr_ajax_comment',
				'nonce'   => self::_get_ajax_nonce(),
			)
		);

	}


	/**
	 * Setting up the nonce that is used in the voting links.
	 *
	 * @since 1.6.1
	 */
	public static function _get_ajax_nonce() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating, $post;

		if ( ! is_a( $post, 'WP_Post' ) ) {
			return '';
		}

		if ( (bool) ! $wpb_comment_rating->get_setting( 'use_nonces', true ) ) {
			return '';
		}

		return wp_create_nonce( 'wpbcr_ajax_comment' );
	}


	/**
	 * Echos out the custom styles.
	 *
	 * @since 1.0.0
	 */
	public static function custom_css() {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		// Vote up
		$vote_up_color = $wpb_comment_rating->get_setting( 'vote_up_color', '' );
		if ( ! empty( $vote_up_color ) ) {
			$vote_up_color = 'color:' . $vote_up_color . ';';
		}

		$vote_up_font_size = intval( $wpb_comment_rating->get_setting( 'vote_up_font_size', 14 ) );
		if ( empty( $vote_up_font_size ) OR $vote_up_font_size <= 0 ) {
			$vote_up_font_size = 14;
		}
		$vote_up_font_size = 'font-size:' . sprintf( '%u', $vote_up_font_size ) . 'px;';


		// Vote down
		$vote_down_color = $wpb_comment_rating->get_setting( 'vote_down_color', '' );
		if ( ! empty( $vote_down_color ) ) {
			$vote_down_color = 'color:' . $vote_down_color . ';';
		}

		$vote_down_font_size = intval( $wpb_comment_rating->get_setting( 'vote_down_font_size', 14 ) );
		if ( empty( $vote_down_font_size ) OR $vote_down_font_size <= 0 ) {
			$vote_down_font_size = 14;
		}
		$vote_down_font_size = 'font-size:' . sprintf( '%u', $vote_down_font_size ) . 'px;';


		// Total rating
		$total_rating_color = $wpb_comment_rating->get_setting( 'total_rating_color', '' );
		if ( ! empty( $total_rating_color ) ) {
			$total_rating_color = 'color:' . $total_rating_color . ';';
		}

		$total_rating_font_size = intval( $wpb_comment_rating->get_setting( 'total_rating_font_size', 14 ) );
		if ( empty( $total_rating_font_size ) OR $total_rating_font_size <= 0 ) {
			$total_rating_font_size = 14;
		}
		$total_rating_font_size = 'font-size:' . sprintf( '%u', $total_rating_font_size ) . 'px;';


		// Custom css
		$css = $wpb_comment_rating->get_setting( 'custom_css', '' );
		$css = apply_filters( 'wpbcr_custom_css', $css );

		echo "<style type=\"text/css\">.wpbcr-rate-up { $vote_up_font_size $vote_up_color } .wpbcr-rate-down{ $vote_down_font_size $vote_down_color } .wpbcr-rating, .wpbcr-already-rated{ $total_rating_font_size $total_rating_color } {$css}</style>";
	}


	/**
	 * Adds the "Already rated" text if activated
	 *
	 * @param string $content
	 * @param object $comment
	 *
	 * @return string
	 *
	 * @since 1.4.0
	 */
	public static function already_rated_text( $content, $comment ) {

		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		// show the "You already rated this comment" text, if activated
		if ( ! (bool) $wpb_comment_rating->get_setting( 'show_already_rated', 0 ) ) {
			return $content;
		}

		$already_rated_text = '<div class="wpbcr-already-rated" >' . $wpb_comment_rating->get_setting( 'already_rated_text', __( 'Already rated!', 'comment-rating' ) ) . '</div>';

		// check if only logged in users can rate this
		if ( (bool) $wpb_comment_rating->get_setting( 'only_logged_in', 0 ) && is_user_logged_in() ) {
			$user_id = get_current_user_id();

			$rated = (array) get_user_meta( $user_id, 'wpbcr_rated', true );

			if ( in_array( $comment->comment_ID, $rated ) ) {
				return $already_rated_text;
			}
		} else {
			if ( (bool) $wpb_comment_rating->get_setting( 'set_cookies', 0 ) ) {

				if ( ! isset( $_COOKIE['wpbcr_rated'] ) ) {
					$rated = array();
				} else {
					$rated = maybe_unserialize( $_COOKIE['wpbcr_rated'] );
				}

				if ( in_array( $comment->comment_ID, $rated ) ) {
					return $already_rated_text;
				}
			}

			// check if IP logging is ON: If so check if the current IP address is in the database already
			if ( (bool) $wpb_comment_rating->get_setting( 'log_ips', 1 ) ) {

				$user_ip = Tools::get_user_ip_addr( (bool) $wpb_comment_rating->get_setting( 'hash_ips', 1 ) );

				global $wpdb;

				$res = (bool) $wpdb->get_var( $wpdb->prepare( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'cr_ips WHERE cr_ip = %s AND cr_comment_id = %d', $user_ip, $comment->comment_ID ) );

				if ( $res ) {
					return $already_rated_text;
				}
				unset( $res );
			}

		}

		return $content;
	}


	/**
	 * Adds CSS classes to a comment.
	 *
	 * @since 1.0.0
	 * @since 1.6.1 Moved to separate class.
	 *
	 * @param array       $classes
	 * @param string      $class
	 * @param int         $comment_ID
	 * @param \WP_Comment $comment
	 * @param int         $post_id
	 *
	 * @return mixed
	 */
	public static function comment_classes( $classes, $class, $comment_ID, $comment, $post_id ) {

		if ( isset( $comment->wpbcr_display ) && ! $comment->wpbcr_display ) {
			array_push( $classes, 'wpbcr-hidden' );
		}

		return $classes;
	}


	/**
	 * Replaces a comment text.
	 *
	 * @param string      $html
	 * @param \WP_Comment $comment
	 *
	 * @since 1.6.1 Moved to separate class.
	 *
	 * @return string
	 */
	public static function comment_hide_html( $html, $comment ) {

		if ( isset( $comment->wpbcr_display ) && ! $comment->wpbcr_display ) {
			return apply_filters(
				'wpbcr_comment_hidden_text',
				__( 'This comment has been removed due to low ratings.', 'comment-rating' ),
				$comment
			);
		}

		return $html;

	}
}

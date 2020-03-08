<?php

namespace wpbuddy\plugins\CommentRating;

class Ranking_Shortcode {

	/**
	 * Prints the shortcode.
	 *
	 * @since 1.1.0
	 * @since 1.6.1 moved to separate file (class)
	 *
	 * @param array       $atts
	 * @param string      $content
	 * @param null|string $return What should be returned
	 *
	 * @global \wpdb      $wpdb
	 *
	 * @return string
	 */
	public static function do_shortcode( $atts, $content = '', $return = null ) {
		/**
		 * @var WPB_Comment_Rating $wpb_comment_rating
		 */
		global $wpb_comment_rating;

		$atts = shortcode_atts( array(
			'post_id' => '',
			'do'      => 'best-rated',
			'limit'   => 5,
		), $atts );

		$atts['do'] = filter_var( $atts['do'], FILTER_SANITIZE_STRING );

		$get_best_comments_of_blog = false;

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		if ( is_null( $atts['post_id'] ) OR 'null' == strtolower( $atts['post_id'] ) ) {
			$get_best_comments_of_blog = true;
		}

		$atts['post_id'] = absint( $atts['post_id'] );

		if ( empty( $atts['post_id'] ) ) {
			$atts['post_id'] = null;

			// try to fetch the global $post
			global $post;
			if ( is_a( $post, 'WP_Post' ) ) {
				$atts['post_id'] = $post->ID;
			}
		}

		/**
		 * What comments?
		 */
		$where = '1=1';
		if ( false === $get_best_comments_of_blog ) {
			$where = $wpdb->prepare( 'c.comment_post_ID = %d', $atts['post_id'] );
		}

		switch ( strtolower( $atts['do'] ) ) {
			case 'highest-rating-count-and-best-rated':
				$where .= ' AND cm.meta_value > 0 ';
				break;
			case 'best-rated-and-highest-rating-count':
				$where .= ' AND cm.meta_value > 0 ';
				break;
		}

		/**
		 * DO
		 */
		switch ( strtolower( $atts['do'] ) ) {
			case 'highest-rating-count':
				$sort_by = array(
					1 => 'CAST( wpbcr_ratings_total AS SIGNED ) DESC ',
					2 => 'CAST( wpbcr_rating AS SIGNED ) DESC ',
				);
				break;
			case 'lowest-rating-count':
				$sort_by = array(
					1 => 'CAST( wpbcr_ratings_total AS SIGNED ) ASC ',
					2 => 'CAST( wpbcr_rating AS SIGNED ) DESC ',
				);
				break;
			case 'worst-rated':
				$sort_by = array(
					1 => 'CAST( wpbcr_rating AS SIGNED ) ASC ',
					2 => 'CAST( wpbcr_ratings_total AS SIGNED ) DESC ',
				);
				break;
			case 'highest-rating-count-and-best-rated':
				$sort_by = array(
					1 => 'CAST( wpbcr_ratings_total AS SIGNED ) DESC ',
					2 => 'CAST( wpbcr_rating AS SIGNED ) DESC ',
				);
				break;
			default:
				$sort_by = array(
					1 => 'CAST( wpbcr_rating AS SIGNED ) DESC ',
					2 => 'CAST( wpbcr_ratings_total AS SIGNED ) DESC ',
				);
				break;
		}

		do_action_ref_array( 'wpbcr_shortcode_best_comments_sql_sort_by', array( &$sort_by, $atts['do'] ) );

		$sort_by = implode( ', ', $sort_by );

		/**
		 * LIMIT
		 */
		$limit = abs( intval( $atts['limit'] ) );

		$sql = self::get_sql_query( $where, $sort_by, $limit, $atts['post_id'], $atts['do'] );

		if ( 'sql' == $return ) {
			return $sql;
		}

		$rows = $wpdb->get_results( $sql );

		if ( 'pre_rows' == $return ) {
			return $rows;
		}

		$rows = apply_filters( 'wpbcr_shortcode_best_comments_rows', $rows );

		if ( 'rows' == $return ) {
			return $rows;
		}

		/**
		 * LI structure
		 */

		if ( false === $get_best_comments_of_blog ) {
			$li = __( '<li><a href="%2$s">%1$s</a> <span class="wpbcr-icon wpbcr-icon-thumbs-o-up"></span> (%4$d/%5$d)</li>', $wpb_comment_rating->get_textdomain() );
		} else {
			$li = __( '<li>%1$s on <a href="%2$s">%3$s</a> <span class="wpbcr-icon wpbcr-icon-thumbs-o-up"></span> (%4$d/%5$d)</li>', $wpb_comment_rating->get_textdomain() );
		}

		$li = apply_filters( 'wpbcr_shortcode_best_comments_li', $li, $get_best_comments_of_blog );

		$output = '';
		foreach ( $rows as $row ) {
			$comment = get_comment( $row->comment_ID );
			$output  .= sprintf(
				$li,
				get_comment_author( $comment ),
				esc_url( get_comment_link( $comment ) ),
				get_the_title( $row->comment_post_ID ),
				$row->wpbcr_rating,
				$row->wpbcr_ratings_total
			);
		}

		$html_type = apply_filters( 'wpbcr_shortcode_best_comments_html_type', 'ol' );

		return '<' . $html_type . ' class="wpbcr_comment_ranking_shortcode wpbcr_comment_ranking_shortcode-' . esc_attr( $atts['do'] ) . '">' . $output . '</' . $html_type . '>';
	}


	/**
	 * Returns the SQL Query for the shortcode.
	 *
	 * @since 1.3.0
	 *
	 * @param string $where
	 * @param string $sort_by
	 * @param string $limit
	 * @param null   $post_id
	 * @param string $do
	 *
	 * @return string
	 */
	public static function get_sql_query( $where, $sort_by, $limit, $post_id = null, $do = '' ) {

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		/**
		 * SQL
		 */
		$sql = 'SELECT '
		       . ' c.comment_ID, '
		       . ' c.comment_post_ID, '
		       . ' IFNULL( cm.meta_value, 0 ) as wpbcr_rating, '
		       . ' IFNULL( cm2.meta_value, 0 ) as wpbcr_ratings_total '
		       . ' FROM ' . $wpdb->comments . ' as c '
		       . ' LEFT JOIN ' . $wpdb->commentmeta . ' as cm'
		       . ' ON ( c.comment_ID = cm.comment_id AND cm.meta_key = "wpbcr_rating" ) '
		       . ' LEFT JOIN ' . $wpdb->commentmeta . ' as cm2 '
		       . ' ON ( c.comment_ID = cm2.comment_id AND cm2.meta_key = "wpbcr_ratings_total" ) '
		       . ' WHERE ' . $where
		       . ' GROUP BY c.comment_ID '
		       . ' ORDER BY ' . $sort_by
		       . ' LIMIT ' . $limit;

		return apply_filters( 'wpbcr_shortcode_best_comments_sql', $sql, $where, $sort_by, $limit, $post_id, $do );
	}

}

<?php

namespace wpbuddy\plugins\CommentRating;

use wpbuddy\plugins\CommentRating\WPB_Plugin;
use wpbuddy\plugins\CommentRating\WPB_Plugin_Admin_Page;
use wpbuddy\plugins\CommentRating\WPB_Plugin_Settings_Tab;
use wpbuddy\plugins\CommentRating\WPB_Plugin_Metabox;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPB_Push_Notification_Service
 *
 * @package wpbuddy\plugins\WPB_Comment_Rating
 * @since   1.0
 * @version 1.6.1
 */
class WPB_Comment_Rating extends WPB_Plugin {


	/**
	 * Constructor.
	 *
	 * @since 1.0
	 *
	 * @param array $options
	 *
	 */
	public function __construct( $options = array() ) {

		$should_start_import = get_option( 'wpbcr_user_should_import' );

		if ( 1 === intval( $should_start_import ) ) {

			Backend::upgrade_161();

			return;
		}

		parent::__construct( $options );

		// removes the get_comment filter when post author gets notified
		add_filter( 'pre_option_comments_notify', array(
			'\wpbuddy\plugins\CommentRating\Compatibility',
			'deactivate_comment_rating_during_notify',
		), 10, 1 );

		// removes the get_comment_filter when moderators get notified
		add_filter( 'pre_option_moderation_notify', array(
			'\wpbuddy\plugins\CommentRating\Compatibility',
			'deactivate_comment_rating_during_notify',
		), 10, 1 );

		// removes the filter after a comment has been added to the database
		// this is to make sure that third party plugins do get the right comment object
		add_action( 'comment_post', array(
			'\wpbuddy\plugins\CommentRating\Compatibility',
			'delete_get_comment_cache',
		), 10, 2 );

		add_filter( 'esc_textarea', array( '\wpbuddy\plugins\CommentRating\Compatibility', 'sce_fix' ) );

		add_action( '\wpbuddy\plugins\CommentRating\Backend', array( $this, 'prepare_delete_comment_ratings' ) );
		add_action( '\wpbuddy\plugins\CommentRating\Backend', array( $this, 'delete_comment_ratings' ) );

		add_action( 'wp_set_comment_status', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'wp_set_comment_status',
		), 10, 2 );
	}


	/**
	 * Does some administrational stuff
	 *
	 * @since 1.0
	 */
	public function do_admin() {

		/*************************************
		 * deletes the log
		 *************************************/
		add_action( __NAMESPACE__ . '\wpb_plugin_page_action_wpbcr_delete_log', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'delete_error_log',
		) );

		add_action( 'admin_head', array( '\wpbuddy\plugins\CommentRating\Backend', 'admin_head' ) );

		add_action( 'wp_ajax_wpbcr_ajax_comment', array(
			'\wpbuddy\plugins\CommentRating\Ajax_Rate',
			'fetch_request',
		) );

		add_action( 'wp_ajax_nopriv_wpbcr_ajax_comment', array(
			'\wpbuddy\plugins\CommentRating\Ajax_Rate',
			'fetch_request',
		) );

		add_action( __NAMESPACE__ . '\wpb_plugin_page_action_wpbcr_uninstall', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'uninstall_1',
		) );

		add_action( __NAMESPACE__ . '\wpb_plugin_page_action_wpbcr_uninstall_step2', array(
			$this,
			'uninstall',
		) );

		add_filter( 'manage_edit-comments_columns', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'manage_posts_columns',
		) );

		add_filter( 'manage_comments_custom_column', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'manage_comments_custom_column',
		), 10, 2 );

		add_action( __NAMESPACE__ . '\wpb_plugin_page_action_wpbcr_truncate_ip_table', array(
			'\wpbuddy\plugins\CommentRating\Backend',
			'truncate_ip_table',
		) );
	}


	/**
	 * do the init for this plugin
	 *
	 * @since 1.0
	 */
	public function do_non_admin() {

		if ( ! has_filter( 'widget_text', 'do_shortcode' ) ) {
			add_filter( 'widget_text', 'do_shortcode' );
		}

		/**
		 * @todo This filter gets removed in the comment_post() function. Important: To remove a hook, the $function_to_remove and $priority arguments must match when the hook was added. This goes for both filters and actions. No warning will be given on removal failure.
		 */
		add_filter( 'get_comment', array( '\wpbuddy\plugins\CommentRating\Frontend', 'get_comment_filter' ), 100 );

		add_filter( 'comments_template_query_args', array(
			'\wpbuddy\plugins\CommentRating\Frontend',
			'sort_comments_query',
		) );

		add_filter( 'comments_clauses', array( '\wpbuddy\plugins\CommentRating\Frontend', 'comments_clauses' ), 10, 2 );

		add_action( 'wp_enqueue_scripts', array( '\wpbuddy\plugins\CommentRating\Frontend', 'enqueue_scripts' ), 50 );

		add_action( 'wp_head', array( '\wpbuddy\plugins\CommentRating\Frontend', 'custom_css' ), 50 );

		add_shortcode( 'wpbcr_comment_ranking', array(
			'\wpbuddy\plugins\CommentRating\Ranking_Shortcode',
			'do_shortcode',
		) );

		add_filter( 'wpbcr_output_html', array(
			'\wpbuddy\plugins\CommentRating\Frontend',
			'already_rated_text',
		), 10, 2 );

		add_filter( 'comment_class', array( '\wpbuddy\plugins\CommentRating\Frontend', 'comment_classes' ), 10, 5 );

		add_filter( 'comment_text', array( '\wpbuddy\plugins\CommentRating\Frontend', 'comment_hide_html' ), 10, 2 );

	}


	/**
	 * Creates the admin pages
	 *
	 * @return array
	 * @since 1.0
	 */
	public function init_admin_pages() {

		$settings_pages = array();

		// create a new page with the title "Push Notices"
		$settings_pages['comment_rating'] = new WPB_Plugin_Admin_Subpage( __( 'Rating', $this->text_domain ), 'edit-comments.php', 'wpcommentrating' );

		$settings_pages['comment_rating']->add_script( 'wp-color-picker' );
		$settings_pages['comment_rating']->add_script( 'wpb-cr-backend' );

		$settings_pages['comment_rating']->add_style( 'wp-color-picker' );
		$settings_pages['comment_rating']->add_style( 'wpb-cr-frontend' );
		$settings_pages['comment_rating']->add_style( 'wpb-cr-frontend-awesome' );
		$settings_pages['comment_rating']->add_style( 'wpb-cr-backend' );

		$settings_pages['comment_rating']->set_page_icon_url( $this->plugins_url( 'assets/img/comment-rating-icon.svg' ) );

		// create a new menu for this page with the same title
		$settings_pages['comment_rating']->create_menu_entry( 'manage_options', $this->plugins_url( 'assets/img/comment-rating-icon.svg' ) );

		// declare where the settings come from on this particular page
		$settings_pages['comment_rating']->set_settings_filter_func( array( &$this, 'main_page_settings' ) );

		$settings_pages['comment_rating']->display_submit_button = false;


		return $settings_pages;
	}


	/**
	 * A filter which hooks into the main page settings
	 *
	 * @param array                 $settings
	 * @param WPB_Plugin_Admin_Page $page
	 *
	 * @return array
	 * @since 1.0
	 */
	public function main_page_settings( $settings, $page ) {

		// Set up a new section
		$settings['layout'] = new WPB_Plugin_Settings_Tab( 'layout', __( 'Layout', $this->get_textdomain() ) );

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_layout_vote_up = $settings['layout']->add_subsection( 'vote-up', __( 'Vote up', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_layout_vote_up->add_settings( array(
			'is_vote_up'            => array(
				'label'         => __( 'Activate up-voting', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'related_items' => array( 1, 2, 3, 4, 5 ),
			),
			'vote_down_icons'       => array(
				'label'        => __( 'Icons', $this->get_textdomain() ),
				'type'         => 'info',
				'classes'      => array( 'wpbcr-list-icons' ),
				'help_message' => implode( ' ', array_map( function ( $v ) {

					return '<span data-icon_name="' . $v . '" class="wpbcr-icon wpbcr-icon-' . $v . '"></span>';
				}, $this->get_up_icons() ) ),
			),
			'vote_up_icon'          => array(
				'label'         => __( 'Icon', $this->get_textdomain() ),
				'type'          => 'text',
				'classes'       => array( 'wpbcr-list-icon' ),
				'default_value' => 'arrow-circle-up',
				'description'   => sprintf( __( 'You can use every single Font Awesome icon (but without the "fa-" prefix). View %s.', $this->get_textdomain() ), '<a target="_blank" href="http://fontawesome.io/icons/">Font Awesome Icons</a>' ),
			),
			'vote_up_html_icon'     => array(
				'label'         => __( 'ASCII/HTML Text', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '',
				'placeholder'   => '&#10138;',
				'classes'       => array( 'small-text' ),
				'description'   => sprintf( __( 'If you want to use an ASCII- or HTML-Icon instead, please enter it here. If you have entered an ASCII- or HTML-Icon on the Vote-down section OR if the vote-down section is disabled, the Font Awesome will not be loaded. See %s for more HTML-codes.', $this->get_textdomain() ), '<a href="http://character-code.com" target="_blank">character-code.com</a>' ),
			),
			'vote_up_font_size'     => array(
				'label'         => __( 'Icon size', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 14,
				'classes'       => array( 'small-text' ),
				'after'         => 'px',
				'attributes'    => array(
					'min'   => 1,
					'max'   => 200,
					'steps' => 1,
				),
			),
			'vote_up_position'      => array(
				'label'         => __( 'Order', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 1,
				'classes'       => array( 'small-text' ),
				'description'   => __( 'The position', $this->get_textdomain() ),
				'attributes'    => array(
					'min'   => 1,
					'max'   => 3,
					'steps' => 1,
				),
			),
			'vote_up_color'         => array(
				'label'         => __( 'Color', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '',
				'classes'       => array( 'wpb-color-picker' ),
			),
			'updates_submit_button' => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_layout_vote_down = $settings['layout']->add_subsection( 'vote-down', __( 'Vote down', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_layout_vote_down->add_settings( array(
			'is_vote_down'          => array(
				'label'         => __( 'Activate down-voting', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'related_items' => array( 1, 2, 3, 4, 5 ),
			),
			'vote_down_icons'       => array(
				'label'        => __( 'Icons', $this->get_textdomain() ),
				'type'         => 'info',
				'classes'      => array( 'wpbcr-list-icons' ),
				'help_message' => implode( ' ', array_map( function ( $v ) {

					return '<span data-icon_name="' . $v . '" class="wpbcr-icon wpbcr-icon-' . $v . '"></span>';
				}, $this->get_down_icons() ) ),
			),
			'vote_down_icon'        => array(
				'label'         => __( 'Icon', $this->get_textdomain() ),
				'type'          => 'text',
				'classes'       => array( 'wpbcr-list-icon' ),
				'default_value' => 'arrow-circle-down',
				'description'   => sprintf( __( 'You can use every single Font Awesome icon (but without the "fa-" prefix). View %s.', $this->get_textdomain() ), '<a target="_blank" href="http://fontawesome.io/icons/">Font Awesome Icons</a>' ),
			),
			'vote_down_html_icon'   => array(
				'label'         => __( 'ASCII/HTML Text', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '',
				'placeholder'   => '&#10136;',
				'classes'       => array( 'small-text' ),
				'description'   => sprintf( __( 'If you want to use an ASCII- or HTML-Icon instead, please enter it here. If you have entered an ASCII- or HTML-Icon on the vote-up section OR if the vote-up section is disabled, the Font Awesome will not be loaded. See %s for more HTML-codes.', $this->get_textdomain() ), '<a href="http://character-code.com" target="_blank">character-code.com</a>' ),
			),
			'vote_down_font_size'   => array(
				'label'         => __( 'Icon size', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 14,
				'classes'       => array( 'small-text' ),
				'after'         => 'px',
				'attributes'    => array(
					'min'   => 1,
					'max'   => 200,
					'steps' => 1,
				),
			),
			'vote_down_position'    => array(
				'label'         => __( 'Order', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 3,
				'classes'       => array( 'small-text' ),
				'description'   => __( 'The position', $this->get_textdomain() ),
				'attributes'    => array(
					'min'   => 1,
					'max'   => 3,
					'steps' => 1,
				),
			),
			'vote_down_color'       => array(
				'label'         => __( 'Color', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '',
				'classes'       => array( 'wpb-color-picker' ),
			),
			'updates_submit_button' => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		$section_layout_vote_rating = $settings['layout']->add_subsection( 'total-rating', __( 'Rating', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_layout_vote_rating->add_settings( array(
			'hide_threshold'         => array(
				'label'         => __( 'Hide threshold', $this->get_textdomain() ),
				'type'          => 'number',
				'classes'       => array( 'small-text' ),
				'description'   => __( 'Want to hide comments that have a very low rating? Enter the threshold here. Leave 0 to deactivate.', $this->get_textdomain() ),
				'default_value' => 0,
				'attributes'    => array(
					'steps' => 1,
				),
			),
			'is_total_rating'        => array(
				'label'         => __( 'Display total rating', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'related_items' => array( 2, 3, 4, 5 ),
			),
			'total_rating_string'    => array(
				'label'         => __( 'String', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '(%d)',
				'description'   => __( '%d is the placeholder for the total number of rating a comment has got.', $this->get_textdomain() ),
			),
			'total_rating_font_size' => array(
				'label'         => __( 'Font size', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 14,
				'classes'       => array( 'small-text' ),
				'after'         => 'px',
				'attributes'    => array(
					'min'   => 1,
					'max'   => 200,
					'steps' => 1,
				),
			),
			'total_rating_position'  => array(
				'label'         => __( 'Order', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 2,
				'classes'       => array( 'small-text' ),
				'description'   => __( 'The position', $this->get_textdomain() ),
				'attributes'    => array(
					'min'   => 1,
					'max'   => 3,
					'steps' => 1,
				),
			),
			'total_rating_color'     => array(
				'label'         => __( 'Color', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => '',
				'classes'       => array( 'wpb-color-picker' ),
			),
			'updates_submit_button'  => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		$section_layout_css = $settings['layout']->add_subsection( 'css', __( 'Custom CSS', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_layout_css->add_settings( array(
			'custom_css'            => array(
				'label'           => __( 'Custom CSS', $this->get_textdomain() ),
				'type'            => 'textarea',
				'is_codemirror'   => true,
				'codemirror_mode' => 'less',
			),
			'updates_submit_button' => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		$section_layout_wpbuddy_about = $settings['layout']->add_subsection( 'wpbuddy_about', __( 'About', $this->get_textdomain() ), 'in_metabox', null, 'side' );

		$section_layout_wpbuddy_about->add_settings( array(
			'wpbuddy_about' => array(
				'label'        => '',
				'type'         => 'info',
				'help_message' => call_user_func( function ( $cl ) {

					$cl = $cl[0];
					/**
					 * @var WPB_Comment_Rating $cl
					 * @var \WP_User           $user
					 */
					$user = wp_get_current_user();
					ob_start();
					?>
					<a href="https://wp-buddy.com?source=fixed-social-share-backend" target="_blank">
						<img class="wpbcr-about-logo"
						     src="<?php echo esc_url( plugins_url( '/assets/img/wp-buddy-plugin-row-image.png', $cl->plugin_file ) ); ?>"
						     alt="WP-Buddy"/>
					</a>

					<h4><?php printf( __( 'Hey %s!', $cl->get_textdomain() ), esc_html( $user->display_name ) ); ?></h4>

					<p class="wpbcr-about-text"><?php
						_e( 'Your support helps me making this plugin even better and keep it up-to-date. Awesome! Thank you.', $cl->get_textdomain() );
						?>
					</p>
					<hr/>

					<h4><?php _e( 'WordPress News on Twitter', $cl->get_textdomain() ); ?></h4>

					<p>
						<?php
						printf(
							__( 'I\' very active on Twitter when it comes to WordPress news. Don\'t hesitate to follow the me there.', $cl->get_textdomain() ),
							esc_html( $user->display_name )
						)
						?>
						<br/>
						<a target="_blank" href="https://twitter.com/floriansimeth" class="twitter-follow-button"
						   data-show-count="false">Follow
							@floriansimeth</a>
						<script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
					</p>

					<?php if ( false !== stripos( get_locale(), 'de_' ) ): ?>
						<hr/>
						<h4><?php _e( 'German WordPress Newsletter', $cl->get_textdomain() ); ?></h4>
						<p>
							<?php
							_e( 'Time to enter! Once a month I publish what happened in the WordPress world. If you want to stay in touch please subscribe to my newsletter.', $cl->get_textdomain() );
							?>
							<br/>
							<a target="_blank" href="https://florian-simeth.de/newsletter/?ref=cap-backend"
							   class="button button-primary button-small"><?php _e( 'Subscribe to the WordPress Newsletter', $cl->get_textdomain() ); ?></a>
						</p>
					<?php endif;

					return ob_get_clean();
				}, array( &$this ) ),
				'print_label'  => false,
			),
		) );


		$section_layout_wpbuddy_links = $settings['layout']->add_subsection( 'wpbuddy_links', __( 'Help & Links', $this->get_textdomain() ), 'in_metabox', null, 'side' );

		$section_layout_wpbuddy_links->add_settings( array(
			'wpbuddy_links' => array(
				'label'        => '',
				'type'         => 'info',
				'help_message' => '<ul>'
				                  . '<li><a href="http://wp-buddy.com/documentation/plugins/wordpress-comment-rating-plugin/faq/" target="_blank">' . __( 'Frequently Asked Questions', $this->get_textdomain() ) . '</a></li>'
				                  . '<li><a href="http://wp-buddy.com/documentation/plugins/wordpress-comment-rating-plugin/" target="_blank">' . __( 'Version History', $this->get_textdomain() ) . '</a></li>'
				                  . '<li><a href="http://wp-buddy.com/support/" target="_blank">' . __( 'Report a bug', $this->get_textdomain() ) . '</a></li>'
				                  . '<li><a href="http://wp-buddy.com/documentation/plugins/wordpress-comment-rating-plugin/request-function/" target="_blank">' . __( 'Request a function', $this->get_textdomain() ) . '</a></li>'
				                  . '<li><a href="http://wp-buddy.com/documentation/plugins/wordpress-comment-rating-plugin/submit-translation/" target="_blank">' . __( 'Submit a translation', $this->get_textdomain() ) . '</a></li>'
				                  . '<li><a href="http://wp-buddy.com" target="_blank">' . __( 'More cool stuff by WPBuddy', $this->get_textdomain() ) . '</a></li>'
				                  . '</ul>',
				'print_label'  => false,
			),
		) );


		/***********************
		 *
		 * SETTINGS
		 *
		 ***********************/
		$settings['settings'] = new WPB_Plugin_Settings_Tab( 'settings', __( 'Settings', $this->get_textdomain() ) );

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_settings_settings = $settings['settings']->add_subsection( 'settings', __( 'Settings', $this->get_textdomain() ), 'in_metabox', null, 'normal' );


		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		$ip_table_entries = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->prefix . 'cr_ips' );

		$section_settings_settings->add_settings( array(
			'use_nonces'            => array(
				'label'         => __( 'Use nonces', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'description'   => sprintf( __( 'The plugin uses so called %1$s"nonces"%2$s for security reasons. On this WordPress installation nonces will have a lifetime of %3$s seconds. If a caching plugin is used please make sure that your cache will invalidate earlier. Otherwise the rating will not work. If it is not possible to configure the cache you can deactivate this functionality at your own risk.', TEXTDOMAIN ), '<a target="_blank" href="http://codex.wordpress.org/WordPress_Nonces">', '</a>', ceil( time() * 2 / wp_nonce_tick() ) ),
			),
			'is_resorting'          => array(
				'label'         => __( 'Resort comments', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'description'   => __( 'Whether to resort comments according to their ratings. Note that nested comments are summed up to their parents.', TEXTDOMAIN ),
			),
			'only_logged_in'        => array(
				'label'         => __( 'Logged-in users only', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 0,
				'description'   => __( 'Allow rating for logged in users only.', TEXTDOMAIN ),
			),
			'set_cookies'           => array(
				'label'         => __( 'Set cookies', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 0,
				'description'   => __( 'Set cookies in the users browser to identify him. This makes sure that s/he cannot double-vote to comments. Please note that some users have disabled cookies.', TEXTDOMAIN ),
				'related_items' => array( 4 ),
			),
			'cookie_time'           => array(
				'label'         => __( 'Cookie save time', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 48,
				'after'         => ' ' . __( 'hours', TEXTDOMAIN ),
				'classes'       => array( 'small-text' ),
				'description'   => __( 'How long should the cookie be valid? (in hours)', TEXTDOMAIN ),
				'attributes'    => array(
					'min'   => 1,
					'steps' => 1,
				),
			),
			'log_ips'               => array(
				'label'         => __( 'Log IPs', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'description'   => __( 'If you want to log the users IP addresses. This makes sure that s/he cannot double-vote to comments. Please note that not every user has a fixed IP address. This means that users can handle this by requesting a new IP address.', TEXTDOMAIN ),
				'related_items' => array( 6, 7, 8 ),
			),
			'hash_ips'              => array(
				'label'         => __( 'Encrypt IPs', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 1,
				'description'   => __( 'In some countries of the European Union it is not allowed to log and save IP addresses of users. In this case all IP addresses will be encrypted.', TEXTDOMAIN ),
			),
			'ip_time'               => array(
				'label'         => __( 'IP save time', $this->get_textdomain() ),
				'type'          => 'number',
				'default_value' => 24,
				'after'         => ' ' . __( 'hours', TEXTDOMAIN ),
				'classes'       => array( 'small-text' ),
				'description'   => __( 'How long should IP addresses be valid? (in hours)', TEXTDOMAIN ),
				'attributes'    => array(
					'min'   => 1,
					'steps' => 1,
				),
			),
			'flush_ips'             => array(
				'label'        => __( 'Flush IPs', $this->get_textdomain() ),
				'type'         => 'info',
				'help_message' => sprintf( _n( 'At current there are one entry in the IP-Database. Want to flush the table now?', 'At current there are %u entries in the IP-Database. Want to flush the table now?', $ip_table_entries, TEXTDOMAIN ), $ip_table_entries )
				                  . '<br /><br /><a class="button" href="' . esc_url( add_query_arg( array( 'wpb_plugin_page_action' => 'wpbcr_truncate_ip_table' ) ) ) . '"><span class="wpbcr-icon wpbcr-icon-trash-o"></span> ' . __( 'Yes, truncate IP table', TEXTDOMAIN ) . '</a>',
			),
			'post_types'            => array(
				'label'           => __( 'Post Types', $this->get_textdomain() ),
				'type'            => 'select',
				'select_options'  => array_flip( wp_list_pluck( get_post_types( array(
					'public'  => true,
					'show_ui' => true,
				), 'objects' ), 'label' ) ),
				'select_multiple' => true,
				'description'     => __( 'Select on which post types you want to show the comment rating. Leave the field empty if you want to show it on all public post types.', TEXTDOMAIN ),
			),
			'show_already_rated'    => array(
				'label'         => __( 'Show "Already rated" text', $this->get_textdomain() ),
				'type'          => 'onoff',
				'default_value' => 0,
				'description'   => __( 'If you want to show a "You already rated this comment" text, activate this. Note that this could slow down your page load (especially if you have a lot of comments on one page). This is because the plugin needs to check if a users has rated a comment for every single comment. This also won\'nt work for sites that are using a caching plugin like WP Super Cache.', TEXTDOMAIN ),
				'related_items' => array( 11 ),
			),
			'already_rated_text'    => array(
				'label'         => __( '"Already rated" text', $this->get_textdomain() ),
				'type'          => 'text',
				'default_value' => __( 'Already rated!', $this->get_textdomain() ),
			),
			'updates_submit_button' => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_settings_updates = $settings['settings']->add_subsection( 'updates', __( 'Updates', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_settings_updates->add_settings( array(
			'purchase_code'         => array(
				'label'       => __( 'Purchase Code', $this->get_textdomain() ),
				'type'        => 'text',
				'description' => __( 'Please enter your purchase code here if you want to get updates automatically.', TEXTDOMAIN ) . ' <a href="http://wp-buddy.com/wiki/where-to-find-your-purchase-code/" taret="_blank">' . __( 'Click here if you do not know where to find your purchase code.', TEXTDOMAIN ) . '</a>',
			),
			'updates_submit_button' => array(
				'type'               => 'submit_button',
				'submit_button_args' => array(
					'type' => 'secondary',
					'wrap' => false,
				),
			),
		) );

		$section_settings_updates = $settings['settings']->add_subsection( 'uninstall', __( 'Uninstalling', $this->get_textdomain() ), 'in_metabox', null, 'normal' );

		$section_settings_updates->add_settings( array(

			'uninstall_button' => array(
				'type'         => 'info',
				'classes'      => array( 'wpbcr-uninstall' ),
				'help_message' => '<a href="' . esc_url( add_query_arg( array( 'wpb_plugin_page_action' => 'wpbcr_uninstall' ) ) ) . '" class="button wpbcr-button-deletion"><span class="wpbcr-icon wpbcr-icon-trash-o"></span> ' . __( 'Uninstall the plugin', TEXTDOMAIN ) . '</a>',
			),
		) );


		/***********************
		 *
		 * LOG
		 *
		 ***********************/
		$settings['log'] = new WPB_Plugin_Settings_Tab( 'log', __( 'Log', $this->get_textdomain() ) );

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_layout_info_settings = $settings['log']->add_subsection( 'info-settings', __( 'Info settings', $this->get_textdomain() ) );

		$section_layout_info_settings->add_settings( array(
				'log_max_no' => array(
					'label'         => __( 'Max. number of log items', $this->get_textdomain() ),
					'type'          => 'text',
					'classes'       => array( 'small-text' ),
					'description'   => __( 'When set to "0" the plugin will never save anything into the log.', $this->get_textdomain() ),
					'default_value' => 50,
				),
			)
		);

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_layout_log = $settings['log']->add_subsection( 'log', __( 'Log', $this->get_textdomain() ) );

		$section_layout_log->add_setting( 'log_info_delete_top', array(
			'label'               => '',
			'type'                => 'button',
			'external_link_label' => __( 'Delete log', $this->get_textdomain() ),
			'external_link'       => esc_url( add_query_arg( array( 'wpb_plugin_page_action' => 'wpbcr_delete_log' ) ) ),
		) );

		if ( 'log' == $page->current_tab ) {
			$i    = 0;
			$logs = $this->get_log();
			krsort( $logs, SORT_NUMERIC );

			foreach ( $logs as $log ) {
				$i ++;
				$section_layout_log->add_setting( 'log_info_' . $i, array(
					'label'        => date_i18n( get_option( 'date_format' ) . ' ' . get_option( 'time_format' ), $log['timestamp'] ),
					'type'         => 'info',
					'help_message' => $log['message'],
				) );
			}
		}

		$section_layout_log->add_setting( 'log_info_delete_bottom', array(
			'label'               => '',
			'type'                => 'button',
			'external_link_label' => __( 'Delete log', $this->get_textdomain() ),
			'external_link'       => esc_url( add_query_arg( array( 'wpb_plugin_page_action' => 'wpbcr_delete_log' ) ) ),
		) );

		// shows the "system" tab
		$page->display_system_status = true;

		return $settings;
	}


	/**
	 * Logs a message into the database
	 *
	 * @param string $message
	 *
	 * @param int    $time
	 *
	 * @return bool
	 *
	 * @since 1.0
	 */
	public static function log( $message, $time = null ) {

		$log = self::get_setting( 'log' );
		if ( ! is_array( $log ) ) {
			$log = array();
		}

		if ( is_null( $time ) ) {
			$time = current_time( 'timestamp' );
		}

		$log[] = array(
			'timestamp' => $time,
			'message'   => $message,
		);

		$max_no = self::get_setting( 'log_max_no', 50 );

		$log = array_slice( $log, ( - 1 * abs( $max_no ) ), abs( $max_no ) );

		return self::set_setting( 'log', $log );
	}


	/**
	 * Returns the log array as follows
	 * array(
	 *  time    => $timestamp
	 *  message => $message
	 * )
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function get_log() {

		$log = $this->get_setting( 'log', array() );
		if ( ! is_array( $log ) ) {
			$log = array();
		}

		return $log;
	}


	/**
	 * @since 1.0.0
	 * @return array
	 */
	private function get_up_icons() {

		$icons = array(
			'check',
			'sort-desc',
			'star',
			'thumbs-up',
			'check-circle',
			'heart',
			'plus-circle',
			'caret-square-o-up',
			'check-circle-o',
			'plus-square',
			'plus-square-o',
			'thumbs-o-up',
			'smile-o',
			'arrow-circle-up',
			'arrow-circle-o-up',
			'arrow-up',
			'chevron-circle-up',
			'hand-o-up',
			'angle-double-up',
		);

		return apply_filters( 'wpbcr_up_icons', $icons );
	}


	/**
	 * @since 1.0.0
	 * @return array
	 */
	private function get_down_icons() {

		$icons = array(
			'check',
			'sort-asc',
			'star-o',
			'thumbs-down',
			'minus-circle',
			'heart-o',
			'caret-square-o-down',
			'minus-square',
			'minus-square-o',
			'thumbs-o-down',
			'meh-o',
			'frown-o',
			'arrow-circle-down',
			'arrow-circle-o-down',
			'arrow-down',
			'chevron-circle-up',
			'hand-o-down',
			'angle-double-down',
		);

		return apply_filters( 'wpbcr_down_icons', $icons );
	}


	/**
	 * @since 1.0
	 * @global \wpdb $wpdb
	 */
	public function on_activation() {

		$this->install_ips_table();
		$this->install_rating_table();
	}


	/**
	 * Installs the IP table.
	 *
	 * @since 1.6.1
	 */
	private function install_ips_table() {

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		dbDelta( "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}cr_ips` (
            `cr_id` SERIAL,
            `cr_comment_id` bigint(20) unsigned NOT NULL,
            `cr_ip` varchar(64) NOT NULL,
            `cr_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
            UNIQUE KEY `cr_comment_id` (`cr_comment_id`,`cr_ip`)
            ) {$charset_collate} ;" );
	}


	/**
	 * Installs the rating table.
	 *
	 * @since 1.6.1
	 */
	private function install_rating_table() {

		if ( ! function_exists( 'dbDelta' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		}

		global $wpdb;

		$charset_collate = $wpdb->get_charset_collate();

		dbDelta( "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}cr_rating` (
            `rating_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
            `comment_id` bigint(11) DEFAULT NULL,
            `key` varchar(6) DEFAULT '',
            `value` int(11) DEFAULT NULL,
            PRIMARY KEY (`rating_id`),
            UNIQUE KEY `rating_id` (`rating_id`),
            UNIQUE KEY `u` (`comment_id`,`key`)
            ) {$charset_collate} ;" );
	}


	/**
	 * Uninstalls the plugin and deactivates it.
	 *
	 * @since 1.0.0
	 * @since 1.1.0 added $deactivate parameter
	 *
	 * @param bool $deactivate
	 */
	public function uninstall( $deactivate = true ) {

		// call the parents uninstall routine
		parent::uninstall();

		Uninstall::step_2( $deactivate );
	}


	/**
	 * Returns the purchase code.
	 *
	 * @since 1.0.0
	 * @return string
	 */
	public function get_purchase_code() {

		return $this->get_setting( 'purchase_code' );
	}


	/**
	 * Do an upgrade.
	 *
	 * @param string $old_version
	 */
	public function on_upgrade( $old_version ) {

		if ( version_compare( $old_version, '1.6.1', '<' ) ) {
			# this will install the new rating table
			$this->install_rating_table();

			# set a flag for the user to force him to start the importer
			update_option( 'wpbcr_user_should_import', true );
		}
	}

}

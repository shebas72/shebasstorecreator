<?php
/**
 * Copyright 2013 WP-Buddy.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 *
 * @package    WPBuddy Plugin
 * @subpackage CommentRating
 */

namespace wpbuddy\plugins\CommentRating;

use stdClass;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


require_once( __DIR__ . '/wpb_plugin_abstract.php' );
require_once( __DIR__ . '/wpb_plugin_admin_page.php' );
require_once( __DIR__ . '/wpb_plugin_metabox.php' );
require_once( __DIR__ . '/wpb_plugin_settings_tab.php' );
require_once( __DIR__ . '/wpb_plugin_settings_section.php' );

/**
 * Provides some general Plugin functions
 * Use the on_activation and on_deactivation function in child classes
 *
 * @version 3.1.1
 */
class WPB_Plugin extends WPB_Plugin_Abstract {

	public $wp_filter_id = 1;

	/**
	 * The plugin path with filename
	 *
	 * @var mixed
	 * @since  3.0
	 */
	protected $plugin_file;

	/**
	 * How to include the plugin
	 * can be "in_theme" as well
	 *
	 * (default value: 'plugin')
	 *
	 * @var string
	 * @since  1.0
	 */
	protected $inclusion;


	/**
	 * Whether to check for updates on the plugins author server
	 *
	 * @since 2.6
	 * @var bool
	 */
	protected $auto_update;


	/**
	 * The plugin path
	 *
	 * @var mixed
	 * @since  2.0
	 */
	protected $path;


	/**
	 * The text domain used for this plugin
	 *
	 * @var string
	 * @since  2.0
	 */
	protected $text_domain;


	/**
	 * The URL to the settings page where the purchase code can be entered
	 *
	 * @since 2.8
	 * @var string
	 */
	protected $purchase_code_settings_page_url;


	/**
	 * The URL where to check for updates
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $update_post_url;


	/**
	 * The post url that gets used to track a users behaviour
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $tracking_post_url;


	/**
	 * Plugin action links
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $plugin_action_links;


	/**
	 * The name of the plugin
	 *
	 * @var string
	 * @since  2.0
	 */
	protected $name;


	/**
	 * The plugin title as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $title;


	/**
	 * The plugin description as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $description;


	/**
	 * Plugin author as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $author;


	/**
	 * The plugin author URL as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $author_uri;


	/**
	 * The plugin version as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $version;


	/**
	 * The plugin URL as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $plugin_uri;


	/**
	 * The plugin path as defined in the plugin header
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $domain_path;


	/**
	 * Internally use only, inherits the page hooks
	 *
	 * @since 3.0
	 * @var array
	 */
	private $_page_hooks = array();


	/**
	 * The plugin network as defined in the plugin header
	 *
	 * @var bool
	 */
	protected $network;


	/**
	 * A list of WPB_Plugin_Admin_Page objects with settings in it
	 *
	 * @var array
	 */
	protected $admin_pages = array();


	/**
	 * A list of WPB_Plugin_Admin_Page objects with settings in it
	 *
	 * @var array
	 */
	protected $user_admin_pages = array();


	/**
	 * A list of WPB_Plugin_Admin_Page objects with settings in it
	 *
	 * @var array
	 */
	protected $init_network_admin_pages = array();


	/**
	 * __construct function.
	 *
	 * @access public
	 *
	 * @param array $options
	 *
	 * @since  1.0
	 *
	 * @return \wpbuddy\plugins\CommentRating\WPB_Plugin
	 */
	public function __construct( $options = array() ) {

		$default_options = array(
			'plugin_file'         => null,
			'inclusion'           => 'plugin',
			'auto_update'         => true,
			'update_post_url'     => '',
			'tracking_post_url'   => '',
			'plugin_textdomain'   => '',
			'plugin_action_links' => array(),
		);

		$default_options = apply_filters( __NAMESPACE__ . '\wpb_plugin_default_options', $default_options );

		$options = wp_parse_args( $options, $default_options );

		$options = apply_filters( __NAMESPACE__ . '\wpb_plugin_options', $options );

		foreach ( $options as $option_key => $option_value ) {
			$this->{$option_key} = $option_value;
		}

		// set the path to the plugin
		$this->path = dirname( $options['plugin_file'] );

		// stop here if there is no file given
		if ( is_null( $options['plugin_file'] ) ) {
			return new \WP_Error( 'wpb_plugin', 'There is no plugin-file!' );
		}

		// reads all data from the plugin header and stores it into their variables
		add_action( 'plugins_loaded', array( &$this, 'set_plugin_data' ), - 10 );

		add_action( 'plugins_loaded', array( &$this, 'set_constants' ), - 5 );

		// load the translation
		add_action( 'init', array( &$this, 'load_translation' ) );

		// set update filters
		$this->update_filters();

		// set activation hooks
		$this->activation_hooks();

		// set de-activation hooks
		$this->deactivation_hooks();

		// is fired when upgrading a plugin
		add_action( 'admin_init', array( $this, 'upgrade' ) );

		// brings up a notice to enter the purchase code
		add_action( 'admin_notices', array( &$this, 'purchase_code_warning' ) );

		if ( 'plugin' == $this->inclusion ) {
			add_filter( 'plugin_action_links_' . plugin_basename( $this->plugin_file ), array(
				&$this,
				'plugin_action_links',
			) );
		}

		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'user_admin_menu', array( &$this, 'user_admin_menu' ) );
		add_action( 'network_admin_menu', array( &$this, 'network_admin_menu' ) );

		add_filter( __NAMESPACE__ . '\wpb_plugin_add_script', array( &$this, 'add_script_path' ) );
		add_filter( __NAMESPACE__ . '\wpb_plugin_add_style', array( &$this, 'add_script_path' ) );

		add_action( 'wp_ajax_wpb_plugin_download_report_file', array( &$this, 'ajax_download_report_file' ) );

		// starting the plugin wrote by the user
		if ( method_exists( $this, 'init' ) ) {
			$this->init();
		}

		if ( method_exists( $this, 'do_admin' ) && is_admin() ) {
			$this->do_admin();
		}

		if ( method_exists( $this, 'do_non_admin' ) && ! is_admin() ) {
			$this->do_non_admin();
		}

		// some standard ajax calls
		add_action( 'wp_ajax_wpbplugin_ajax_postlist', array( &$this, 'ajax_postlist' ) );
		add_action( 'wp_ajax_wpbplugin_ajax_taglist', array( &$this, 'ajax_taglist' ) );
		add_action( 'wp_ajax_wpbplugin_ajax_categorylist', array( &$this, 'ajax_categorylist' ) );
		add_action( 'wp_ajax_wpbplugin_ajax_userlist', array( &$this, 'ajax_userlist' ) );

		/**
		 * add metaboxes
		 * for this, we have to create the WPB_Plugin_Metabox classes first
		 * then we add the metaboxes in the add_meta_boxes action hook
		 */
		add_action( 'init', array( &$this, 'init_meta_boxes' ) );
		add_action( 'add_meta_boxes', array( &$this, 'add_meta_boxes' ) );

	}


	/**
	 * loads the translation file
	 *
	 * @access public
	 * @return void
	 * @since  1.0 using load_textdomain
	 * @since  2.7.3 using load_plugin_textdomain
	 */
	public function load_translation() {

		$plugin_folder_name = trailingslashit( dirname( plugin_basename( $this->plugin_file ) ) );

		// framework textdomain
		load_plugin_textdomain( 'wpbplugin', false, $plugin_folder_name . 'assets/langs/' );

		// plugin textdomain
		load_plugin_textdomain( $this->get_textdomain(), false, $plugin_folder_name . 'assets/langs/' );
	}


	/**
	 * update check function.
	 *
	 * @access public
	 *
	 * @param $trans
	 *
	 * @return mixed
	 * @since  1.0
	 */
	public function site_transient_update_plugins( $trans ) {

		// never do this if it's not an admin page
		if ( ! is_admin() ) {
			return false;
		}

		// read the plugins we have received from the webserver
		$remote_plugins = $this->get_client_upgrade_data();

		// stop here if there are no plugins to check
		if ( ! $remote_plugins ) {
			return $trans;
		}

		// run through all plugins and do a version_compare
		// here the $plugin_slug is something like "rich-snippets-wordpress-plugin/rich-snippets-wordpress-plugin.php"
		foreach ( get_plugins() as $plugin_slug => $plugin ) {

			// if the plugin is not in our list, go to the next one
			if ( ! isset( $remote_plugins[ $plugin_slug ] ) ) {
				continue;
			}

			// the actual version compare
			// if the version is lower we will add the plugin information to the $trans array
			if ( version_compare( $plugin['Version'], $remote_plugins[ $plugin_slug ]->version, '<' ) ) {
				$trans->response[ $plugin_slug ]      = new \stdClass();
				$trans->response[ $plugin_slug ]->url = $remote_plugins[ $plugin_slug ]->homepage;

				// here the slug-name is something like "rich-snippets-wordpress-plugin"
				// extracted from the filename
				// this only works if the plugin is inside of a folder
				$trans->response[ $plugin_slug ]->slug        = str_replace( array(
					'/',
					'.php',
				), '', strstr( $plugin_slug, '/' ) );
				$trans->response[ $plugin_slug ]->package     = $remote_plugins[ $plugin_slug ]->download_url;
				$trans->response[ $plugin_slug ]->new_version = $remote_plugins[ $plugin_slug ]->version;
				$trans->response[ $plugin_slug ]->id          = '0';
			} else {
				if ( isset( $trans->response[ $plugin_slug ] ) ) {
					unset( $trans->response[ $plugin_slug ] );
				}
			}
		}

		return $trans;
	}


	/**
	 * plugins_api function.
	 * Will return the plugin information or false. If it returns false WordPress will look after some plugin
	 * information in the wordpress.org plugin database
	 *
	 * @access   public
	 *
	 * @param boolean      $api
	 * @param string       $action
	 * @param array|object $args
	 *
	 * @internal param mixed $def
	 * @return stdClass | boolean
	 * @since    1.0
	 */
	public function plugins_api( $api, $action, $args ) {

		$slug = $this->get_plugin_name_sanitized();

		if ( false !== $api || ! isset( $args->slug ) || $slug != $args->slug && $args->slug != $slug ) {
			return false;
		}

		if ( 'plugin_information' == $action ) {

			$plugins = $this->get_client_upgrade_data();

			if ( ! $plugins ) {
				return false;
			}

			$extended_slug = str_replace( WP_PLUGIN_DIR . '/', '', $this->plugin_file );

			if ( ! isset( $plugins[ $extended_slug ] ) ) {
				return false;
			}

			return $plugins[ $extended_slug ]; // stdClass object
		}

		return false;
	}


	/**
	 * get_client_upgrade_data function.
	 *
	 * @access public
	 * @return array | false
	 * @since  1.0
	 * @global $wp_version
	 * @global $wpb_has_plugin_remote_sent
	 */
	public function get_client_upgrade_data() {

		global $wpb_has_plugin_remote_sent;

		// if yes, than just return the results
		if ( isset( $wpb_has_plugin_remote_sent[ $this->get_plugin_name_sanitized() ] ) ) {
			return $wpb_has_plugin_remote_sent[ $this->get_plugin_name_sanitized() ];
		}

		/**
		 * The database can only have 64 characters for the name
		 *
		 * @todo when changing the transient name, do also change it in the @see WPB_Plugin::uninstall() function in this class.
		 */
		$transient_name = substr( 'wpbp_u_' . $this->get_plugin_name_sanitized(), 0, 64 );

		// if a plugin-check was already done, return the results
		$transient_plugins = $this->get_transient( $transient_name );

		if ( false === $transient_plugins ) {
			// the transient is no longer valid because it returned 'false'. => we have to do a request
			$do_request = true;
		} else {
			// the transient is valid and returned anything else than 'false'. => we have NOT to do a request
			$do_request = false;

			// but first we have to check if we are on the update-core.php page. if so we HAVE to do the request
			global $pagenow;
			if ( isset( $pagenow ) && 'update-core.php' == $pagenow ) {
				$do_request = true;
			}
		}

		if ( ! $do_request ) {
			return $transient_plugins;
		}

		if ( ! function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugins         = get_plugins();
		$plugin_basename = plugin_basename( $this->plugin_file );

		if ( ! isset( $plugins[ $plugin_basename ] ) ) {
			return false;
		}

		$plugins = array( $plugin_basename => $plugins[ $plugin_basename ] );

		// what wp-version do we have here?
		global $wp_version;

		$purchase_code = ( ( method_exists( $this, 'get_purchase_code' ) ) ? $this->get_purchase_code() : '' );

		// prepare the elements for the POST-call
		$post_elements = array(
			'action'        => 'wpbcb_ajax_plugin_update',
			'plugins'       => $plugins,
			'wp_version'    => $wp_version,
			'purchase_code' => $purchase_code,
			'blog_url'      => home_url(),
		);

		// some more options for the POST-call
		$options = array(
			'timeout'    => 5,
			'body'       => $post_elements,
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
		);

		$remote_plugins = array();

		$data = wp_remote_post( $this->update_post_url, $options );

		if ( ! is_wp_error( $data ) && 200 == wp_remote_retrieve_response_code( $data ) ) {
			$body = json_decode( wp_remote_retrieve_body( $data ), true );
			if ( $body && is_array( $body ) && isset( $body['plugins'] ) && is_serialized( $body['plugins'] ) ) {
				$remote_plugins = unserialize( $body['plugins'] );
			}
		}

		// set transient for a later usage. set transient to 24 hours
		$this->set_transient( $transient_name, $remote_plugins, 60 * 60 * 24 * 7 );

		$GLOBALS['wpb_has_plugin_remote_sent'][ $this->get_plugin_name_sanitized() ] = $remote_plugins;

		return $remote_plugins;

	}


	/**
	 * replaces the WordPress' built in plugins_url function
	 *
	 * @param      $path
	 * @param null $plugin
	 *
	 * @since      3.0 use plugins_url instead
	 *
	 * @return string
	 */
	public function plugins_url( $path, $plugin = null ) {

		if ( is_null( $plugin ) ) {
			$plugin = $this->plugin_file;
		}

		if ( 'plugin' == $this->inclusion ) {
			return plugins_url( $path, $plugin );
		}

		return get_template_directory_uri() . '/' . $path;

	}


	/**
	 * Does updates for the current plugin. But only when it's not included in a theme
	 *
	 * @since 2.0
	 */
	public function update_filters() {

		if ( 'plugin' == $this->inclusion && (bool) $this->auto_update ) {

			// Plugin update hooks
			// Automatically plugin update check
			add_filter( 'site_transient_update_plugins', array( &$this, 'site_transient_update_plugins' ) );

			// plugin api info screen
			add_filter( 'plugins_api', array( &$this, 'plugins_api' ), - 100, 3 );

		}
	}


	/**
	 * creates the activation hooks.
	 * if it is used as a plugin the register_activation_hook will be used
	 * if it is used within a theme the load-themes.php action is used
	 *
	 * @return void
	 * @since 2.0
	 */
	public function activation_hooks() {

		// for themes
		if ( 'in_theme' == $this->inclusion ) {
			add_action( 'load-themes.php', array( &$this, 'theme_on_activation' ) );
		} // for plugins
		elseif ( 'plugin' == $this->inclusion && isset( $this->plugin_file ) ) {
			register_activation_hook( $this->plugin_file, array( &$this, 'activate' ) );
		}
	}


	/**
	 * creates the deactivation_hooks
	 * if it is used as a plugin the register_deactivation_hook is used
	 * if it is used within a theme the switch-theme action is used
	 *
	 * @since 2.0
	 */
	public function deactivation_hooks() {

		// for themes
		if ( 'in_theme' == $this->inclusion ) {
			add_action( 'switch_theme', array( &$this, 'deactivate' ) );
		} // and for plugins
		elseif ( 'plugin' == $this->inclusion && isset( $this->plugin_file ) ) {
			register_deactivation_hook( $this->plugin_file, array( &$this, 'deactivate' ) );
		}
	}


	/**
	 * If the plugin is called within a theme this is the pre_activation hook
	 * Please use the action [plugin_name]_on_activation to hook into the activation
	 *
	 * @since 1.0
	 * @return void
	 */
	public function theme_on_activation() {

		global $pagenow;

		if ( $pagenow == 'themes.php' && isset( $_REQUEST['activated'] ) ) {

			if ( method_exists( $this, 'on_activation' ) ) {
				$this->activate();
			}

		}
	}


	/**
	 * activates the plugin
	 *
	 * @since 3.0
	 */
	public function activate() {

		if ( isset( $_GET['plugin'] ) && function_exists( 'get_plugin_data' ) ) {
			$plugin_data = get_plugin_data( trailingslashit( WP_PLUGIN_DIR ) . sanitize_text_field( $_GET['plugin'] ), false );
		} else {
			$plugin_data['Name'] = sanitize_text_field( $_GET['plugin'] );
		}

		if ( version_compare( PHP_VERSION, '5.6', '<' ) ) {
			wp_die(
				sprintf( __( 'The %s plugin needs at least PHP 5.6 in order to work correctly. Please contact your website-provider to solve this issue.', 'wpbplugin' ), $plugin_data['Name'] )
				. '<br /><br />'
				. '<a href="' . admin_url( 'plugins.php?deactivate=true' ) . '">' . _x( 'Go back to the plugins section', 'displayed when activating the plugin went wrong', 'wpbplugin' ) . '</a>'
			);
		}

		$this->update_plugin_data();

		if ( method_exists( $this, 'on_activation' ) ) {
			$this->on_activation();
		}
	}


	/**
	 * deactivates the plugin
	 *
	 * @since 3.0
	 */
	public function deactivate() {

		if ( method_exists( $this, 'on_deactivation' ) ) {
			$this->on_deactivation();
		}
	}

	/**
	 * Returns the text domain name
	 *
	 * @return string
	 * @since 1.0
	 */
	public function get_textdomain() {

		if ( isset( $this->text_domain ) ) {
			return $this->text_domain;
		}

		return '';
	}


	/**
	 * Returns the sanitized name of the current plugin
	 *
	 * @return string
	 * @since 2.0
	 */
	public function get_plugin_name_sanitized() {

		return sanitize_key( $this->name );
	}


	/**
	 * WARNING: This function is deprecated. Use get_plugin_name_sanitized() instead
	 * This returns the plugin slug name which seems not to be defined within WordPress
	 * So my understanding of a plugins slug name is the filename without the .php in the end
	 * but the get_plugins function returns the full name (with folder and .php). for ex:
	 * schema-corporate/schema-corporate.php But this function just returns "schema-corporate". The slug will be
	 * stripped out of the Class name
	 *
	 * @access     protected
	 * @return string
	 * @since      1.0
	 * @deprecated use get_plugin_name_sanitized instead
	 */
	public function get_plugin_slug_name() {

		return $this->get_plugin_name_sanitized();
	}


	/**
	 * Returns the plugins file
	 *
	 * @since 2.3
	 * @return mixed|null
	 */
	public function get_plugin_file() {

		return $this->plugin_file;
	}


	/**
	 * Returns the plugins root-path
	 *
	 * @since 2.3
	 * @return string
	 */
	public function get_path() {

		return trailingslashit( dirname( $this->plugin_file ) );
	}


	/**
	 * Track the current task
	 *
	 * @param array $tasks
	 *
	 * @since 2.5
	 *
	 * @return void
	 *
	 */
	public function track( $tasks ) {

		// assume that tracking is not allowed when the method 'is_tracking' does not exist
		if ( ! method_exists( $this, 'is_tracking' ) ) {
			return;
		}

		// stop here if tracking is not allowed
		if ( ! $this->is_tracking() ) {
			return;
		}

		// what wp-version do we have here?
		global $wp_version;

		// prepare the elements for the POST-call
		$post_elements = array(
			'action'        => 'wpb_track',
			'wp_version'    => $wp_version,
			'purchase_code' => ( ( method_exists( $this, 'get_purchase_code' ) ) ? $this->get_purchase_code() : '' ),
			'blog_url'      => home_url(),
			'tasks'         => $tasks,
			'plugin_name'   => $this->get_plugin_name_sanitized(),
		);

		// some more options for the POST-call
		$options = array(
			'timeout'    => 30,
			'body'       => $post_elements,
			'user-agent' => 'WordPress/' . $wp_version . '; ' . home_url(),
		);

		try {
			wp_remote_post( $this->tracking_post_url, $options );
		} catch ( \Exception $e ) {
		}

	}


	/**
	 * This function fires the on_upgrade function
	 *
	 * @since 2.7
	 */
	public function upgrade() {

		// this is for testing only
		//update_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_version', '1.1.2' );

		// update the version (this comes later then the following lines)
		// this is to make sure to only upgrade once each version
		add_action( 'init', array( $this, 'set_new_version' ), 10 );

		// update the plugin data
		$this->update_plugin_data();

		$old_version = get_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_version', 0 );

		// only do the upgrade if the current version is higher than the version before
		if ( version_compare( $old_version, $this->version, '>=' ) ) {
			return;
		}

		if ( method_exists( $this, 'on_upgrade' ) ) {
			$this->on_upgrade( $old_version );
		}

		update_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_version', $this->version );

	}

	/**
	 * Sets the new version after upgrading
	 *
	 * @since 2.7.2
	 * @todo  Do you want to change the name of the option here? Don't forget to also change it in the
	 *     WPB_Plugin::uninstall() function in this class, too!
	 */
	public function set_new_version() {

		update_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_version', $this->version );
	}


	/**
	 * Shows a purchase code warning
	 *
	 * @since 2.8
	 */
	public function purchase_code_warning() {

		if ( ! isset( $_GET['page'] ) ) {
			return;
		}
		global $hook_suffix;
		if ( ! isset( $hook_suffix ) ) {
			return;
		}

		$in_page = false;

		/**
		 * @var WPB_Plugin_Admin_Page $admin_page
		 */
		foreach ( $this->admin_pages as $admin_page ) {
			if ( $admin_page->page_hook == $hook_suffix ) {
				$in_page = true;
				break;
			}
		};

		if ( ! $in_page ) {
			return;
		}
		if ( ! method_exists( $this, 'get_purchase_code' ) ) {
			return;
		}

		$purchase_code = $this->get_purchase_code();

		if ( ! empty( $purchase_code ) ) {
			return;
		}

		add_settings_error( 'wpbgsp-purchase-code', 0, sprintf( _x( 'You should consider entering you purchase code for the %s plugin because you get every update immediately delivered to your WordPress installation.', 'displayed on the plugins settings page', 'wpbplugin' ), '<a href="' . $this->purchase_code_settings_page_url . '">' . $this->name . '</a>' ) );

	}


	/**
	 * Set the plugin data out of the database entry
	 *
	 * @since 3.0
	 */
	public function set_plugin_data() {

		$plugin_headers = get_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_headers', array() );
		foreach ( $plugin_headers as $plugin_header_key => $plugin_header_value ) {
			$this->{$plugin_header_key} = $plugin_header_value;
		}
	}

	/**
	 * Sets the plugin name out from the plugin data (retrieved by get_plugin_data)
	 *
	 * @see   get_plugin_data
	 * @since 3.0
	 */
	public function update_plugin_data() {

		$default_plugin_headers = array(
			'Name'        => 'WP-Buddy Plugin',
			'PluginURI'   => 'http://wp-buddy.com',
			'Version'     => '1.0',
			'Description' => 'This is just a standard description and should be replaced',
			'Author'      => 'WP-Buddy',
			'AuthorURI'   => 'http://wp-buddy.com',
			'TextDomain'  => 'wpb_plugin',
			'DomainPath'  => '',
			'Network'     => false,
		);

		if ( ! function_exists( 'get_plugin_data' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$plugin_headers = get_plugin_data( $this->plugin_file, false, true );

		$plugin_headers = wp_parse_args( $plugin_headers, $default_plugin_headers );

		$pre_saved_plugin_headers = array();

		foreach ( $plugin_headers as $plugin_header_key => $plugin_header_value ) {

			switch ( $plugin_header_key ) {
				case 'PluginURI':
					$key_name = 'plugin_uri';
					break;
				case 'AuthorURI':
					$key_name = 'author_uri';
					break;
				case 'TextDomain':
					$key_name = 'text_domain';
					break;
				case 'DomainPath':
					$key_name = 'domain_path';
					break;
				default:
					$key_name = strtolower( $plugin_header_key );
			}

			$pre_saved_plugin_headers[ $key_name ] = $plugin_header_value;
		}

		/**
		 * @todo  changing the name of the option here? do also change it in the WPB_Plugin::uninstall() function in this class, too!
		 */
		update_option( sanitize_key( plugin_basename( $this->plugin_file ) ) . '_headers', $pre_saved_plugin_headers );
	}


	/**
	 * Adds some more links to the plugins-overview
	 *
	 * @param array $links
	 *
	 * @since 3.0
	 *
	 * @return array
	 *
	 */
	public function plugin_action_links( $links ) {

		$action_link_defaults = array(
			'href'    => '',
			'target'  => '',
			'title'   => '',
			'content' => '',
			'classes' => array(),
		);

		$action_link_defaults = apply_filters( __NAMESPACE__ . '\wpb_plugin_action_links_defaults', $action_link_defaults );

		foreach ( $this->plugin_action_links as $action_link ) {

			$action_link_options = wp_parse_args( $action_link, $action_link_defaults );

			$links[ strtolower( sanitize_key( $action_link_options['name'] ) ) ] = '<a href="' . $action_link_options['href'] . '" target="' . $action_link_options['target'] . '" class="' . implode( ' ', $action_link_options['classes'] ) . '">' . $action_link_options['content'] . '</a>';
		}

		return $links;
	}


	/**
	 * prepares the admin menu pages
	 *
	 * @since 3.0
	 */
	public function admin_menu() {

		if ( method_exists( $this, 'init_admin_pages' ) ) {
			$this->admin_pages = $this->init_admin_pages();
		}
	}


	/**
	 * Prepares the user admin pages
	 *
	 * @since 3.0
	 */
	public function user_admin_menu() {

		if ( method_exists( $this, 'init_user_admin_pages' ) ) {
			$this->user_admin_pages = $this->init_user_admin_pages();
		}
	}


	/**
	 * Prepares the network admin pages
	 *
	 * @since 3.0
	 */
	public function network_admin_menu() {

		if ( method_exists( $this, 'init_network_admin_pages' ) ) {
			$this->init_network_admin_pages = $this->init_network_admin_pages();
		}
	}


	/**
	 * Sets some constants
	 *
	 * @todo  make sure the plugin SAVENAME is short enough
	 * @since 3.0
	 */
	public function set_constants() {

		define( __NAMESPACE__ . '\TEXTDOMAIN', $this->get_textdomain() );

		/*
		 * The SAVENAME can only be a max of 64 characters long (due to a limitation in the database)
		 * In fact we have to make sure that it is short enough
		 */
		define( 'SAVENAME', sanitize_key( dirname( plugin_basename( $this->plugin_file ) ) ) );
		$GLOBALS['wpb_current_plugin'] = &$this;
	}


	/**
	 * Adds the absolute URI to scripts and styles
	 *
	 * @since 3.0
	 */
	public function add_script_path( $options ) {

		if ( ! empty( $options['src'] ) ) {
			return $options;
		}
		if ( ! isset( $options['handle'] ) ) {
			return $options;
		}

		$folder   = isset( $options['media'] ) ? 'css' : 'js';
		$filename = str_replace( __NAMESPACE__ . '\\', '', $options['handle'] );
		$filename = str_replace( '_', '-', $filename );
		$min      = ( ! WP_DEBUG && is_file( $this->get_path() . 'assets/' . $folder . '/' . $filename . '.min.' . $folder ) ) ? '.min' : '';

		$options['src'] = $this->plugins_url( 'assets/' . $folder . '/' . $filename . $min . '.' . $folder );;

		return $options;
	}


	/**
	 * Returns a setting
	 *
	 * @param string $id
	 * @param mixed  $default
	 *
	 * @return mixed
	 *
	 * @since 3.0
	 */
	public static function get_setting( $id, $default = '' ) {

		return get_option( SAVENAME . '_' . $id, $default );
	}


	/**
	 * Saves a setting into the database
	 *
	 * @param string $id
	 * @param mixed  $value
	 *
	 * @return bool
	 */
	public static function set_setting( $id, $value ) {

		return update_option( SAVENAME . '_' . $id, $value );
	}

	/**
	 * Returns a support-text file for download
	 *
	 * @since 3.0
	 */
	public function ajax_download_report_file() {

		$tab = WPB_Plugin_Admin_Page::system_status_tab();

		$file_content = '';

		/**
		 * @var WPB_Plugin_Settings_Section $section
		 */
		foreach ( $tab->get_subsections() as $section ) {

			$file_content .= '### ' . $section->get_title() . ' ###' . chr( 10 ) . chr( 10 );
			/**
			 * @var WPB_Plugin_Settings_Setting $setting
			 */
			foreach ( $section->get_settings() as $setting ) {
				if ( 'info' != $setting->type ) {
					continue;
				}
				$file_content .= $setting->label . ': ' . chr( 10 )
				                 . strip_tags( str_replace( '<br />', chr( 10 ), $setting->help_message ) ) . chr( 10 ) . chr( 10 );
			}

			$file_content .= chr( 10 ) . chr( 10 );
		}

		header( "Content-Disposition: attachment; filename=\"plugin_support_file.txt\"" );
		header( "Content-Type: application/force-download" );
		header( "Content-Length: " . strlen( $file_content ) );
		header( "Connection: close" );

		echo $file_content;

		exit();

	}


	/**
	 * Loads the posts for the select box on the settings page
	 *
	 * @since 1.8
	 * @global wpdb $wpdb
	 */
	public function ajax_postlist() {

		if ( ! isset( $_REQUEST['term'] ) ) {
			wp_send_json_error();
		}
		if ( ! isset( $_REQUEST['_wpbplugin_nonce_name'] ) ) {
			wp_send_json_error();
		}
		if ( ! wp_verify_nonce( $_REQUEST['_wpbplugin_nonce_name'], 'wpbplugin_ajax_postlist' ) ) {
			wp_send_json_error();
		}

		global $wpdb;

		if ( ! $wpdb instanceof \wpdb ) {
			wp_send_json_error();
		}

		$results = $wpdb->get_results( $wpdb->prepare( 'SELECT post_title, ID, post_type FROM `' . $wpdb->posts . '` WHERE post_title LIKE "%%%s%%" AND post_status="publish"', $_REQUEST['term'] ) );

		$postlist = array();

		$post_types = $this->get_posttypes();

		foreach ( $results as $post ) {
			$post_type = array_search( $post->post_type, $post_types );
			if ( false === $post_type ) {
				$post_type = $post->post_type;
			}
			$postlist[ $post->ID ] = $post->post_title . ' (' . $post_type . ' - ID: ' . $post->ID . ')';
		}

		wp_send_json_success( array( 'terms' => $postlist ) );
	}


	/**
	 * Loads the tags for the select box on the settings page
	 *
	 * @since 3.0
	 * @global wpdb $wpdb
	 */
	public function ajax_taglist() {

		if ( ! isset( $_REQUEST['term'] ) ) {
			wp_send_json_error();
		}
		if ( ! isset( $_REQUEST['_wpbplugin_nonce_name'] ) ) {
			wp_send_json_error();
		}
		if ( ! wp_verify_nonce( $_REQUEST['_wpbplugin_nonce_name'], 'wpbplugin_ajax_taglist' ) ) {
			wp_send_json_error();
		}

		global $wpdb;

		if ( ! $wpdb instanceof \wpdb ) {
			wp_send_json_error();
		}

		$taglist = array();

		$results = $wpdb->get_results( 'SELECT wpb_terms.term_id, wpb_terms.name, wpb_taxonomy.taxonomy FROM ' . $wpdb->terms . ' as wpb_terms, ' . $wpdb->term_taxonomy . ' as wpb_taxonomy WHERE wpb_taxonomy.term_taxonomy_id = wpb_terms.term_id AND wpb_terms.name LIKE "%' . $wpdb->escape( $_REQUEST['term'] ) . '%"' );

		foreach ( $results as $tag ) {
			if ( 'category' == $tag->taxonomy ) {
				continue;
			}
			$taglist[ $tag->term_id ] = $tag->name . ' (' . $tag->taxonomy . ')';
		}

		wp_send_json_success( array( 'terms' => $taglist ) );
	}


	/**
	 * Loads the categories for the select box on the settings page
	 *
	 * @since 3.0
	 */
	public function ajax_categorylist() {

		if ( ! isset( $_REQUEST['term'] ) ) {
			wp_send_json_error();
		}
		if ( ! isset( $_REQUEST['_wpbplugin_nonce_name'] ) ) {
			wp_send_json_error();
		}
		if ( ! wp_verify_nonce( $_REQUEST['_wpbplugin_nonce_name'], 'wpbplugin_ajax_categorylist' ) ) {
			wp_send_json_error();
		}

		$categorylist = array();

		/**
		 * @var $category
		 */
		foreach ( get_categories() as $category ) {
			if ( false === stripos( $category->name, $_REQUEST['term'] ) ) {
				continue;
			}
			$categorylist[ $category->cat_ID ] = $category->name;

		}

		wp_send_json_success( array( 'terms' => $categorylist ) );

	}

	/**
	 * Loads the users for the select box on the settings page
	 *
	 * @since 3.0
	 */
	public function ajax_userlist() {

		if ( ! isset( $_REQUEST['term'] ) ) {
			wp_send_json_error();
		}
		if ( ! isset( $_REQUEST['_wpbplugin_nonce_name'] ) ) {
			wp_send_json_error();
		}
		if ( ! wp_verify_nonce( $_REQUEST['_wpbplugin_nonce_name'], 'wpbplugin_ajax_userlist' ) ) {
			wp_send_json_error();
		}

		$userlist = array();

		$users = get_users();
		foreach ( $users as $user ) {

			if ( false !== stripos( $user->display_name, $_REQUEST['term'] )
			     OR false !== stripos( $user->user_nicename, $_REQUEST['term'] )
			     OR false !== stripos( $user->user_login, $_REQUEST['term'] )
			) {
				$userlist[ $user->ID ] = $user->display_name . ' (' . $user->user_login . ')';
			}
		}

		wp_send_json_success( array( 'terms' => $userlist ) );

	}


	/**
	 * get_posttypes function.
	 * Returns a array of post types which are public and shown in the backend-ui
	 * The key is the label-name (tarnslated into your language) and the value is the post-short-name
	 * The form will be:
	 * ARRAY (
	 *        'Post'    => 'post',
	 *        'Page'    => 'page',
	 *        'Movie'    => 'movie'
	 * )
	 *
	 * @access public
	 * @return array
	 * @since  3.0
	 */
	public static function get_posttypes() {

		// get all page types as objects
		$post_types_objects = get_post_types( array( 'public' => true, 'show_ui' => true ), 'objects' );

		// set new post-type array
		$post_types = array();

		// iterate through all objects
		foreach ( $post_types_objects as $post_short_name => $post_type ) {
			// do not include attachments
			if ( 'attachment' == $post_short_name ) {
				continue;
			}
			$post_types[ $post_type->labels->name ] = $post_short_name;
		}

		return $post_types;
	}


	/**
	 * Initialises the metaboxes
	 *
	 * @since 3.0
	 */
	public function init_meta_boxes() {

		if ( method_exists( $this, 'init_metaboxes' ) ) {
			$this->metaboxes = $this->init_metaboxes();
		}
	}

	/**
	 * Adds metabox functions
	 *
	 * @since 3.0
	 */
	public function add_meta_boxes() {

		if ( isset( $this->metaboxes ) && is_array( $this->metaboxes ) ) {
			/**
			 * @var WPB_Plugin_Metabox $metabox
			 */
			foreach ( $this->metaboxes as $metabox ) {
				$metabox->add_meta_boxes();
			}
		}
	}


	/**
	 * Uninstall routine.
	 *
	 * @since 3.1.0
	 * @since
	 */
	public function uninstall() {

		/**
		 * @var \wpdb $wpdb
		 */
		global $wpdb;

		$transient_name = substr( 'wpbp_u_' . $this->get_plugin_name_sanitized(), 0, 64 );
		delete_option( $transient_name );

		$version_option_name = sanitize_key( plugin_basename( $this->plugin_file ) ) . '_version';
		delete_option( $version_option_name );

		$headers_option_name = sanitize_key( plugin_basename( $this->plugin_file ) ) . '_headers';
		delete_option( $headers_option_name );

		// delete all other options from the options table
		$wpdb->query( 'DELETE FROM ' . $wpdb->options . ' WHERE option_name LIKE "' . SAVENAME . '%"' );
	}


	/***************************
	 * GETTERS
	 **************************/

	/**
	 * Returns the name of the plugin
	 *
	 * @return string
	 * @since 3.0
	 */
	public function get_name() {

		return $this->name;
	}


	/**
	 * returns the current plugins version
	 *
	 * @since      2.7
	 * @return int
	 * @deprecated since 3.0; use get_version instead
	 */
	public function get_plugin_version() {

		return $this->get_version();
	}


	/**
	 * Returns the plugins version
	 *
	 * @since 3.0
	 * @return int
	 */
	public function get_version() {

		return $this->version;
	}


	/**
	 * @param string $name
	 *
	 * @since 3.1
	 * @return mixed
	 */
	public function get_transient( $name ) {

		$transient = get_option( $name, null );
		if ( ! is_array( $transient ) ) {
			// transient is not valid because the option does not exist
			return false;
		}

		if ( ! isset( $transient['time'] ) ) {
			// transient is no longer valid because the time does not exist
			return false;
		}

		if ( current_time( 'timestamp' ) > $transient['time'] ) {
			// transient is no longer valid because we're over time
			return false;
		}

		if ( ! isset( $transient['value'] ) ) {
			// transient is no longer valid because the content does not exist
			return false;
		}

		return $transient['value'];

	}


	/***************************
	 * SETTERS
	 **************************/

	/**
	 * @param string $name
	 * @param mixed  $value
	 * @param int    $time timestamp
	 *
	 * @return bool
	 *
	 * @since 3.1
	 */
	public function set_transient( $name, $value, $time ) {

		$a = array(
			'time'  => current_time( 'timestamp' ) + $time,
			'value' => $value,
		);

		return update_option( $name, $a );
	}


}

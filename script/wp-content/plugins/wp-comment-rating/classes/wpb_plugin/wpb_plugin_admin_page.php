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

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( __DIR__ . '/wpb_plugin_admin_subpage.php' );
require_once( __DIR__ . '/wpb_plugin_settings.php' );

class WPB_Plugin_Admin_Page {

	/**
	 * Array of WPB_Plugin_Settings_Tab objects
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $tabs = array();


	/**
	 * The title of the current page
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $title;


	/**
	 * Declares if the page has a menu
	 *
	 * @var bool
	 * @since 3.0
	 */
	protected $has_menu = false;


	/**
	 * The page hook (if in a menu)
	 *
	 * @var string|null
	 * @since 3.0
	 */
	public $page_hook = null;


	/**
	 * A list of WPB_Plugin_Subpages objects
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $subpages = array();


	/**
	 * The slug which is the sanitized title
	 *
	 * @var string
	 */
	protected $slug;


	/**
	 * The URL to an icon to use for the menu
	 *
	 * @var string
	 */
	protected $icon_url;


	/**
	 * The capability to use for the page
	 *
	 * @var string
	 */
	protected $capability;


	/**
	 * The menu position of the current page
	 *
	 * @var int
	 */
	protected $position;


	/**
	 * The function to use for the current page
	 *
	 * @var mixed
	 */
	protected $func = null;


	/**
	 * The settings function that gets executed when we need the settings options
	 *
	 * @var mixed
	 */
	protected $settings_func = null;


	/**
	 * The icon for the current page
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $page_icon_str = 'icon-options-general';


	/**
	 * The icon URL for the current page
	 *
	 * @var string
	 * @since 3.0
	 */
	protected $page_icon_url = '';


	/**
	 * The array of scripts to register for that page
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $scripts = array();


	/**
	 * The array of styles to register for that page
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $styles = array();


	/**
	 * Whether to display the system status tab
	 *
	 * @var bool
	 * @since 3.0
	 */
	public $display_system_status = false;


	/**
	 * The current tab of a settings page
	 *
	 * @var string
	 * @since 3.0
	 */
	public $current_tab = '';


	/**
	 * If the submit button should be displayed on the current page
	 *
	 * @var bool
	 * @since 4.0
	 */
	public $display_submit_button = true;


	/**
	 * The parent object or the parent slug.
	 *
	 * @since  4.0
	 * @access public
	 *
	 * @var  WPB_Plugin_Admin_Page|null|string $parent WPB_Plugin_Admin_Subpage object or parent slug string
	 */
	public $parent = null;


	/**
	 * @param string      $title
	 * @param null|string $slug
	 *
	 * @since 3.0
	 */
	public function __construct( $title, $slug = null ) {

		$this->title = $title;

		$this->slug = is_null( $slug ) ? sanitize_key( $title ) : $slug;

		$this->current_tab = isset( $_GET['tab'] ) ? sanitize_text_field( $_GET['tab'] ) : '';

		// add options to wpb_plugin_page on theme options page
		add_filter( 'whitelist_options', array( &$this, 'whitelist_options' ) );

		if ( isset( $_GET['wpb_plugin_page_action'] ) ) {
			$action = sanitize_text_field( $_GET['wpb_plugin_page_action'] );
			do_action( __NAMESPACE__ . '\wpb_plugin_page_action_' . $action );
			do_action( __NAMESPACE__ . '\wpb_plugin_page_' . $this->slug . '_action_' . $action );
			do_action( __NAMESPACE__ . '\wpb_plugin_page_' . $this->slug . '_' . $this->current_tab . '_action_' . $action );
		}

		return $this;
	}

	/**
	 * Will add all options to the whitelist so that they get saved accordingly
	 *
	 * @param array $whitelist_settings
	 *
	 * @return mixed
	 * @since 3.0
	 */
	public function whitelist_options( $whitelist_settings ) {

		if ( ! isset( $_REQUEST[ $this->page_hook . '_saving' ] ) ) {
			return $whitelist_settings;
		}

		$settings = apply_filters( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_settings', array(), $this );


		/**
		 * Run through sections
		 *
		 * @var WPB_Plugin_Settings_Tab     $tab
		 * @var WPB_Plugin_Settings_Section $section
		 */
		foreach ( $settings as $tab => $section ) {
			$this->whitelist_options_helper( $whitelist_settings, $section, $tab );
		}

		do_action( __NAMESPACE__ . '\wpb_plugin_whitelist_options' );
		do_action( __NAMESPACE__ . '\wpb_plugin_whitelist_options_' . $this->page_hook );

		return $whitelist_settings;
	}


	/**
	 * Is a little helper that also gets the fields from the subsections
	 *
	 * @param array                       $settings
	 * @param WPB_Plugin_Settings_Section $section
	 * @param string                      $tab
	 *
	 * @return array
	 * @since 3.0
	 * @since 4.0 allowed to save user meta data here
	 */
	private function whitelist_options_helper( &$settings, $section, $tab ) {

		/**
		 * Run through all settings
		 *
		 * @var WPB_Plugin_Settings_Setting $option
		 */
		foreach ( $section->get_settings() as $option ) {

			if ( false === $option->save ) {
				continue;
			}

//			if ( 'file' == strtolower( $option->type ) && isset( $_FILES[ $option->field_name ] ) ) {
//				if ( ! is_null( $option->fcn_file_processing ) ) {
//					do_action( __NAMESPACE__ . '\wpb_plugin_settings_file_upload', $_FILES[ $option->field_name ], $option->field_name );
//					do_action( __NAMESPACE__ . '\wpb_plugin_settings_file_upload_' . $option->field_name, $_FILES[ $option->field_name ] );
//				}
//
//				continue;
//			}

//			if ( $option->is_user_meta && isset( $_REQUEST[ $option->field_name ] ) ) {
//				/**
//				 * Do not save user meta stuff into the options table
//				 * instead: save the user meta here
//				 * Rights have been checked already on options page
//				 */
//				$option->field_name = trim( $option->field_name );
//				$value              = null;
//				if ( isset( $_POST[ $option->field_name ] ) ) {
//					$value = $_POST[ $option->field_name ];
//					if ( ! is_array( $value ) ) {
//						$value = trim( $value );
//					}
//					$value = wp_unslash( $value );
//				}
//
//				$value = apply_filters( __NAMESPACE__ . '\wpb_plugin_settings_update_user_meta', $value, $option->user_id, $option->field_name );
//				$value = apply_filters( __NAMESPACE__ . '\wpb_plugin_settings_update_user_meta-' . $option->field_name, $value, $option->user_id );
//
//
//				update_user_meta( $option->user_id, $option->field_name, $value );
//
//				continue;
//			}

			$settings[ $this->page_hook . '_' . $tab ][] = $option->field_name;
		}

		$subsections = $section->get_subsections();

		if ( count( $subsections ) > 0 ) {

			/**
			 * Run through all subsections
			 *
			 * @var WPB_Plugin_Settings_Section $subsection
			 */
			foreach ( $subsections as $subsection ) {

				$this->whitelist_options_helper( $settings, $subsection, $tab );
			}
		}

		return $settings;
	}

	/**
	 * Checks if a page has a menu
	 *
	 * @return bool
	 * @since 3.0
	 */
	public function has_menu() {

		return (bool) $this->has_menu;
	}


	/**
	 * @param string $capability
	 * @param string $icon_url
	 * @param null   $position
	 * @param bool   $is_subpage
	 *
	 * @return $this
	 * @since 3.0
	 */
	public function create_menu_entry( $capability = 'manage_options', $icon_url = '', $position = null, $is_subpage = false ) {

		$this->icon_url   = $icon_url;
		$this->capability = $capability;
		$this->position   = $position;

		if ( is_null( $this->func ) ) {
			$function = array( &$this, 'render_page' );
		} else {
			$function = $this->func;
		}

		if ( $is_subpage ) {
			if ( ! is_object( $this->parent ) ) {
				$parent_slug = $this->parent;
			} else {
				$parent_slug = $this->parent->slug;
			}
			$this->page_hook = add_submenu_page( $parent_slug, $this->title, $this->title, $this->capability, $this->slug, $function );
		} else {
			$this->page_hook = add_menu_page( $this->title, $this->title, $this->capability, $this->slug, $function, $this->icon_url, $this->position );
		}

		if ( is_null( $this->func ) ) {
			// add styles and scripts to the standard rendered page
			$this->add_script( __NAMESPACE__ . '\wpb_plugin_backend', '', array( 'jquery' ) );
			$this->add_style( __NAMESPACE__ . '\wpb_plugin_backend' );

			$this->add_script( __NAMESPACE__ . '\tagsinput', '', array( __NAMESPACE__ . '\wpb_plugin_backend' ) );
			$this->add_style( __NAMESPACE__ . '\tagsinput' );

			$this->add_script( __NAMESPACE__ . '\codemirror' );
			$this->add_script( __NAMESPACE__ . '\codemirror_clike', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_htmlmixed', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_javascript', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_less', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_matchbrackets', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_php', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( __NAMESPACE__ . '\codemirror_xml', '', array( __NAMESPACE__ . '\codemirror' ) );
			$this->add_script( 'postbox' );

			$this->add_style( __NAMESPACE__ . '\codemirror' );
		}

		add_action( 'load-' . $this->page_hook, array( &$this, 'add_settings' ) );
		add_action( 'load-' . $this->page_hook, array( &$this, 'enqueue_scripts' ) );
		add_action( 'load-' . $this->page_hook, array( &$this, 'enqueue_styles' ) );

		$this->has_menu = true;

		return $this;

	}

	/**
	 * @param $title
	 *
	 * @return WPB_Plugin_Admin_Subpage
	 */
	public function add_subpage( $title ) {

		return new WPB_Plugin_Admin_Subpage( $title, $this );
	}


	/**
	 * defines the function which should be executed when the users visits it
	 *
	 * @param mixed $func
	 *
	 * @return $this
	 */
	public function func( $func ) {

		$this->func = $func;

		// create the menu again when this function is called after the menu was created
		if ( ! is_null( $this->page_hook ) ) {
			$this->remove_page();
			$this->create_menu_entry( $this->capability, $this->icon_url, $this->position );
		}

		return $this;
	}


	/**
	 * Removes a menu page
	 *
	 * @return $this
	 * @since 3.0
	 */
	public function remove_page() {

		remove_menu_page( $this->slug );

		return $this;
	}


	/**
	 * Set the settings function that gets executed when it's needed
	 *
	 * @param mixed $func
	 *
	 * @return $this
	 *
	 * @since 3.0
	 */
	public function set_settings_filter_func( $func ) {

		$this->settings_func = $func;
		add_filter( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_settings', $func, 10, 2 );

		return $this;
	}


	/**
	 * add all settings for the current page
	 *
	 * @since 3.0
	 */
	public function add_settings() {

		// room for self-promotion :-)
		do_action( __NAMESPACE__ . '\wpb_plugin_settings_footer' );

		$settings = apply_filters( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_settings', array(), $this );

		if ( (bool) $this->display_system_status ) {
			$settings['system-status'] = $this->system_status_tab();
		}

		$settings_class = apply_filters( __NAMESPACE__ . '\wpb_plugin_settings_class', __NAMESPACE__ . '\WPB_Plugin_Settings' );

		/**
		 * Run through the tabs
		 *
		 * @var $settings array
		 * @var $tab      WPB_Plugin_Settings_Tab
		 */
		foreach ( $settings as $tab ) {

			$this->tabs[] = $tab;

			/**
			 * Run through the tab sections
			 *
			 * @var $tab     WPB_Plugin_Settings_Tab
			 * @var $section WPB_Plugin_Settings_Section
			 */
			foreach ( $tab->get_subsections() as $section ) {

				$in_metabox = false;

				// if the settings should be in a metabox
				if ( $section->get_where() == 'in_metabox' ) {
					$in_metabox = true;
					add_meta_box(
						$this->page_hook . '_' . $section->get_id() . '_metabox',
						$section->get_title(),
						function ( $post, $args ) {

							echo $args['args']['content'];
							do_settings_sections( $args['args']['page_hook'] . '_' . $args['args']['tab_id'] . '_metabox_' . $args['args']['section_id'] );
						},
						$this->page_hook . '_' . $tab->get_id(),
						$section->get_metabox_position(),
						$section->get_metabox_priority(),
						array(
							'page_hook'  => $this->page_hook,
							'tab_id'     => $tab->get_id(),
							'section_id' => $section->get_id(),
							'content'    => $section->get_content(),
						)
					);
					//$this->metaboxes[] = $this->page_hook . '_' . $section->get_id() . '_' . $tab->get_id();
				}

				add_settings_section(
					$this->page_hook . '_' . $section->get_id(),
					'',
					array( &$section, 'render' ),
					$this->page_hook . '_' . $tab->get_id() . ( ( $in_metabox ) ? '_metabox_' . $section->get_id() : '' )
				);

				/**
				 * Adding all the fields to the sections
				 *
				 * @var $setting WPB_Plugin_Settings_Setting
				 */
				foreach ( $section->get_settings() as $setting ) {
					$setting_name         = $setting->field_name;
					$settings_fct_to_call = $setting->type;
					if ( ! method_exists( $settings_class, 'render_field_' . $settings_fct_to_call ) ) {
						$settings_fct_to_call = 'text';
					}
					add_settings_field(
						$setting_name,
						$setting->label,
						$settings_class . '::render_field_' . $settings_fct_to_call,
						$this->page_hook . '_' . $tab->get_id() . ( ( $in_metabox ) ? '_metabox_' . $section->get_id() : '' ),
						$this->page_hook . '_' . $section->get_id(),
						wp_parse_args( $setting->get_args(), array(
							'section' => $section->get_id(),
							'tab'     => $tab->get_id(),
						) )
					);

					register_setting(
						$this->page_hook . '_' . $tab->get_id() . ( ( $in_metabox ) ? '_metabox_' . $section->get_id() : '' ),
						$setting_name,
						$setting->sanitize_callback
					);
				}

			}
		}
	}


	/**
	 * renders a page using this function if no other function was set
	 *
	 * @since 3.0
	 */
	public function render_page() {

		$active_tab = $this->current_tab;
		$page       = sanitize_text_field( $_GET['page'] );

		/**
		 * @var WPB_Plugin_Settings_Tab $first_tab
		 */
		$active_tab = isset( $this->tabs[0] ) && empty( $active_tab ) ? $this->tabs[0]->get_id() : $active_tab;

		?>
		<div class="wrap wrap-<?php echo $this->page_hook . ' active-tab-' . $active_tab; ?>">

			<div <?php echo empty( $this->page_icon_url ) ? 'id="' . $this->page_icon_str . '"' : ''; ?>
				class="<?php echo empty( $this->page_icon_url ) ? 'icon32' : 'custom-icon'; ?>"><?php echo ! empty( $this->page_icon_url ) ? '<img style="float: left;" src="' . $this->page_icon_url . '" alt="" />' : ''; ?></div>

			<h1 class="nav-tab-wrapper">
				<?php
				printf( '<span style="margin: 5px 0 0 10px; display: inline-block;">%s&nbsp;</span>', $this->title );

				/**
				 * @var $tab WPB_Plugin_Settings_Tab
				 */
				foreach ( $this->tabs as $tab ) {
					printf(
						'<a href="?page=%s&tab=%s" class="nav-tab %s">%s</a>',
						esc_attr( $page ),
						esc_attr( $tab->get_id() ),
						( $active_tab == $tab->get_id() ? 'nav-tab-active' : '' ),
						esc_html( $tab->get_title() )
					);
				}
				?>
			</h1>

			<?php settings_errors(); ?>

			<div class="<?php echo $this->page_hook; ?>">
				<form method="post" action="<?php echo esc_url( admin_url( 'options.php' ) ); ?>"
				      enctype="multipart/form-data">
					<input type="hidden" name="<?php echo $this->page_hook . '_saving'; ?>" value="1"/>

					<?php
					settings_fields( $this->page_hook . '_' . $active_tab );

					// nonce filds for metaboxes
					wp_nonce_field( 'closedpostboxes', 'closedpostboxesnonce', false );
					wp_nonce_field( 'meta-box-order', 'meta-box-order-nonce', false );

					global $wp_meta_boxes;

					$has_right_sidebar = false;
					if ( isset( $wp_meta_boxes[ $this->page_hook . '_' . $active_tab ]['side'] ) && is_array( $wp_meta_boxes[ $this->page_hook . '_' . $active_tab ]['side'] ) ) {
						$has_right_sidebar = true;
					}

					if ( isset( $wp_meta_boxes[ $this->page_hook . '_' . $active_tab ] ) ):
						?>
						<div id="poststuff"
						     class="metabox-holder wpb_plugin_metaboxes <?php echo $has_right_sidebar ? 'has-right-sidebar' : ''; ?>">

							<?php if ( $has_right_sidebar ): ?>
								<div id="side-info-column" class="inner-sidebar">
									<?php do_meta_boxes( $this->page_hook . '_' . $active_tab, 'side', array() ); ?>
								</div>

							<?php endif; ?>

							<div id="post-body" class="has-sidebar">
								<div id="post-body-content" class="has-sidebar-content">
									<?php do_meta_boxes( $this->page_hook . '_' . $active_tab, 'normal', array() ); ?>
								</div>
							</div>

							<br class="clear"/>

							<script type="text/javascript">
								/* <![CDATA[ */
								jQuery( document ).ready( function ( $ ) {

									/* close postboxes that should be closed */
									jQuery( '.if-js-closed' ).removeClass( 'if-js-closed' ).addClass( 'closed' );

									/* postboxes setup */
									postboxes.add_postbox_toggles( '<?php echo $this->page_hook; ?>' );

								} );
								/* ]]> */
							</script>
						</div>
						<?php
					endif;

					do_settings_sections( $this->page_hook . '_' . $active_tab );

					if ( $this->display_submit_button ) {
						submit_button();
					}

					?>

				</form>
			</div>

		</div><!-- /.wrap -->
		<?php
	}


	/**
	 * Adds a script to the page
	 *
	 * @param string $handle
	 * @param string $src
	 * @param array  $deps
	 * @param bool   $ver
	 * @param bool   $in_footer
	 *
	 * @return $this
	 *
	 * @since 3.0
	 */
	public function add_script( $handle, $src = '', $deps = array(), $ver = false, $in_footer = false ) {

		$options = array(
			'handle'    => $handle,
			'src'       => $src,
			'deps'      => $deps,
			'ver'       => $ver,
			'in_footer' => $in_footer,
		);

		$options = apply_filters( __NAMESPACE__ . '\wpb_plugin_add_script', $options );

		$this->scripts[ $options['handle'] ] = $options;

		if ( wp_script_is( $options['handle'], 'registered' ) ) {
			return $this;
		}

		wp_register_script( $options['handle'], $options['src'], $options['deps'], $options['ver'], $options['in_footer'] );

		return $this;
	}


	/**
	 * Enqueues scripts
	 *
	 * @since 3.0
	 */
	public function enqueue_scripts() {

		foreach ( $this->scripts as $handle => $script_options ) {
			if ( wp_script_is( $handle, 'queue' ) ) {
				continue;
			}
			wp_enqueue_script( $handle );
		}
	}


	/**
	 * Adds a style to the page
	 *
	 * @param string $handle
	 * @param string $src
	 * @param array  $deps
	 * @param bool   $ver
	 * @param string $media
	 *
	 * @return $this
	 *
	 * @since 3.0
	 */
	public function add_style( $handle, $src = '', $deps = array(), $ver = false, $media = 'all' ) {

		$options = array( 'handle' => $handle, 'src' => $src, 'deps' => $deps, 'ver' => $ver, 'media' => $media );

		$options = apply_filters( __NAMESPACE__ . '\wpb_plugin_add_style', $options );

		$this->styles[ $options['handle'] ] = $options;

		if ( wp_style_is( $options['handle'], 'registered' ) ) {
			return $this;
		}

		wp_register_style( $options['handle'], $options['src'], $options['deps'], $options['ver'], $options['media'] );

		return $this;
	}


	/**
	 * Enqueues styles
	 *
	 * @since 3.0
	 */
	public function enqueue_styles() {

		foreach ( $this->styles as $handle => $stype_options ) {
			if ( wp_style_is( $handle, 'queue' ) ) {
				continue;
			}
			wp_enqueue_style( $handle );
		}
	}


	/**
	 * Generates the system status tab
	 *
	 * @return WPB_Plugin_Settings_Tab
	 * @since 3.0
	 */
	public static function system_status_tab() {

		global $wpdb;

		$tab = new WPB_Plugin_Settings_Tab( 'system-status', __( 'System', 'wpbplugin' ) );

		/**
		 * @var string           $wp_version
		 * @var WPB_Plugin|mixed $wpb_current_plugin
		 */
		global $wp_version, $wpb_current_plugin;

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_status_download = $tab->add_subsection( 'status-download', __( 'Download', 'wpbplugin' ) );

		$section_status_download->add_settings( array(
				'report_file_info' => array(
					'label'        => __( 'Report file', 'wpbplugin' ),
					'type'         => 'info',
					'help_message' => __( 'Please include this information when requesting support', 'wpbplugin' ),
				),

				'status_download' => array(
					'label'               => '',
					'type'                => 'button',
					'external_link_label' => __( 'Download Report File', 'wpbplugin' ),
					'external_link'       => admin_url( 'admin-ajax.php?action=wpb_plugin_download_report_file&nonce=' . wp_create_nonce( 'wpb_plugin_download_report_file' ) ),
				),
			)
		);

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_system_status = $tab->add_subsection( 'environment', __( 'Environment', 'wpbplugin' ) );

		$section_system_status->add_settings( array(
			'home_url' => array(
				'label'        => __( 'Home-URL', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => home_url(),
			),

			'site_url' => array(
				'label'        => __( 'Site-URL', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => home_url(),
			),

			'plugin_name' => array(
				'label'        => __( 'Plugin name', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => $wpb_current_plugin->get_name(),
			),

			'plugin_version' => array(
				'label'        => __( 'Plugin version', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => $wpb_current_plugin->get_version(),
			),

			'wp_version' => array(
				'label'        => __( 'WP version', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => $wp_version,
			),

			'webserver_info' => array(
				'label'        => __( 'Webserver info', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => esc_html( $_SERVER['SERVER_SOFTWARE'] ),
			),

			'php_version' => array(
				'label'        => __( 'PHP version', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => function_exists( 'phpversion' ) ? esc_html( phpversion() ) : '',
			),

			'mysql_version' => array(
				'label'        => __( 'MySQL version', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => isset( $wpdb ) ? esc_html( $wpdb->db_version() ) : '',
			),

			'wp_memory_limit' => array(
				'label'        => __( 'WP memory limit', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => WP_MEMORY_LIMIT,
			),

			'wp_debug_mode' => array(
				'label'        => __( 'WP debug mode', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => WP_DEBUG ? __( 'Yes', 'wpbplugin' ) : __( 'No', 'wpbplugin' ),
			),

			'wp_max_upload_size' => array(
				'label'        => __( 'WP max upload size', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => size_format( wp_max_upload_size() ),
			),

			'php_post_max_size' => array(
				'label'        => __( 'PHP post max size', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => function_exists( 'ini_get' ) ? ini_get( 'post_max_size' ) : '',
			),

			'php_time_limit' => array(
				'label'        => __( 'PHP post max size', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => function_exists( 'ini_get' ) ? ini_get( 'max_execution_time' ) : '',
			),

		) );

		$active_plugins = (array) get_option( 'active_plugins', array() );

		if ( is_multisite() ) {
			$active_plugins = array_merge( $active_plugins, get_site_option( 'active_sitewide_plugins', array() ) );
		}

		$plugins = array();

		foreach ( $active_plugins as $plugin ) {

			$plugin_data    = @get_plugin_data( WP_PLUGIN_DIR . '/' . $plugin );
			$dirname        = dirname( $plugin );
			$version_string = '';

			if ( empty( $plugin_data['Name'] ) ) {
				continue;
			}

			$plugins[] = $plugin_data['Name'] . ' ' . __( 'by', 'wpbplugin' ) . ' ' . $plugin_data['Author'] . ' ' . __( 'version', 'wpbplugin' ) . ' ' . $plugin_data['Version'] . $version_string;

		}

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_plugins = $tab->add_subsection( 'plugins', __( 'Plugins', 'wpbplugin' ) );

		$section_plugins->add_settings( array(
			'installed_plugins' => array(
				'label'        => __( 'Installed plugins', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => sizeof( $plugins ) == 0 ? '-' : implode( ', <br />', $plugins ),
			),
		) );

		/**
		 * @var WP_Theme $active_theme
		 */
		$active_theme = wp_get_theme();

		// set up a new subsection (which is a WPB_Plugin_Settings_Section class)
		$section_theme = $tab->add_subsection( 'theme', __( 'Theme', 'wpbplugin' ) );

		$section_theme->add_settings( array(
			'current_theme' => array(
				'label'        => __( 'Current theme', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => $active_theme->Name,
			),

			'theme_version' => array(
				'label'        => __( 'Theme version', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => $active_theme->Version,
			),

			'author_url' => array(
				'label'        => _x( 'Author URL', 'Theme Author URL', 'wpbplugin' ),
				'type'         => 'info',
				'help_message' => '<a href="' . $active_theme->{'Author URI'} . '" target="_blank">' . $active_theme->{'Author URI'} . '</a>',
			),
		) );

		return $tab;
	}

	/*************************
	 * SETTERS
	 ************************/

	/**
	 * @param string $page_icon_str
	 *
	 * @since 3.0
	 */
	public function set_page_icon_str( $page_icon_str ) {

		$this->page_icon_str = $page_icon_str;
	}


	/**
	 * @param string $page_icon_url
	 *
	 * @since 3.0
	 */
	public function set_page_icon_url( $page_icon_url ) {

		$this->page_icon_url = $page_icon_url;
	}


}
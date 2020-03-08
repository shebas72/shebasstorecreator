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


/**
 * Class WPB_Plugin_Metabox
 *
 * @package wpbuddy\plugins\CommentRating
 */
class WPB_Plugin_Metabox {

	/**
	 * Array of WPB_Plugin_Settings_Tab objects
	 *
	 * @var array
	 * @since 3.0
	 */
	protected $tabs = array();

	/**
	 * The slug name for the metabox
	 *
	 * @var string
	 */
	protected $slug;

	/**
	 * HTML 'id' attribute of the edit screen section
	 *
	 * @var string
	 */
	protected $id;


	/**
	 * Title of the edit screen section, visible to user
	 *
	 * @var string
	 */
	protected $title;


	/**
	 * Function that prints out the HTML for the edit screen section.
	 *
	 * @var mixed
	 */
	protected $callback;


	/**
	 *  The type of Write screen on which to show the edit screen section ('post', 'page', 'dashboard', 'link',
	 *  'attachment' or 'custom_post_type' where custom_post_type is the custom post type slug)
	 *
	 * @var array
	 */
	protected $post_types;


	/**
	 * The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side').
	 *
	 * @var string
	 */
	protected $context;

	/**
	 * The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
	 *
	 * @var string
	 */
	protected $priority;

	/**
	 * Arguments to pass into your callback function. The callback will receive the $post object and whatever
	 * parameters are passed through this variable.
	 *
	 * @var mixed
	 */
	protected $callback_args;

	/**
	 * The settings function that gets executed when we need the settings options
	 *
	 * @var mixed
	 */
	protected $settings_func = null;


	/**
	 * Registers a metabox
	 *
	 * @param string       $title
	 * @param string|array $post_types
	 * @param string       $context
	 * @param string       $priority
	 * @param mixed        $callback
	 * @param mixed        $callback_args
	 *
	 * @return \wpbuddy\plugins\CommentRating\WPB_Plugin_Metabox
	 */
	public function __construct( $title, $post_types = 'all', $context = 'advanced', $priority = 'default', $callback = null, $callback_args = null ) {

		$this->slug          = sanitize_key( $title );
		$this->id            = SAVENAME . '_meteabox_' . $this->slug;
		$this->title         = $title;
		$this->callback      = $callback;
		$this->post_types    = $post_types;
		$this->context       = $context;
		$this->priority      = $priority;
		$this->callback_args = $callback_args;

		if ( is_null( $this->callback ) ) {
			$this->callback = array( &$this, 'render_metabox' );
		}

		if ( is_string( $this->post_types ) && 'all' == strtolower( $this->post_types ) ) {
			$this->post_types = WPB_Plugin::get_posttypes();
		}

		if ( is_string( $this->post_types ) ) {
			$this->post_types = array( $this->post_types );
		}

		if ( ! is_array( $this->post_types ) ) {
			$this->post_types = array();
		}

		add_action( 'save_post', array( &$this, 'save_post' ) );

		return $this;
	}


	/**
	 * Creates the meta boxes
	 *
	 * @since 3.0
	 */
	public function add_meta_boxes() {
		foreach ( $this->post_types as $post_type ) {
			add_meta_box( $this->id, $this->title, $this->callback, $post_type, $this->context, $this->priority, $this->callback_args );
		}
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
		add_filter( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_metabox_settings', $func, 10, 3 );

		return $this;
	}


	/**
	 * Renders a metabox if no function was given on the add_meta_box function
	 *
	 * @param \WP_Post $post
	 *
	 * @since 3.0
	 *
	 * @return void
	 */
	public function render_metabox( $post ) {

		$settings = apply_filters( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_metabox_settings', array(), $this, $post );

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

				add_settings_section(
					$this->slug . '_metabox_' . $section->get_id(),
					$section->get_title(),
					array( &$section, 'render' ),
					$this->slug . '_metabox_' . $tab->get_id()
				);

				/**
				 * Adding all the fields to the sections
				 *
				 * @var $setting WPB_Plugin_Settings_Setting
				 */
				foreach ( $section->get_settings() as $setting ) {
					$setting_name = $setting->field_name;
					if ( ! method_exists( $settings_class, 'render_field_' . $setting->type ) ) {
						continue;
					}
					add_settings_field(
						$setting_name,
						$setting->label,
						$settings_class . '::render_field_' . $setting->type,
						$this->slug . '_metabox_' . $tab->get_id(),
						$this->slug . '_metabox_' . $section->get_id(),
						wp_parse_args( $setting->get_args(), array(
							'section' => $section->get_id(),
							'tab'     => $tab->get_id()
						) )
					);

					register_setting( $this->slug . '_metabox_' . $tab->get_id(), $setting_name );
				}

			}
		}

		do_settings_sections( $this->slug . '_metabox_' . $this->tabs[0]->get_id() );
	}


	/**
	 * Saves the custom fields of a post
	 *
	 * @param int $post_id
	 *
	 * @return int|void
	 *
	 * @since 3.0
	 */
	public function save_post( $post_id ) {
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		$settings = apply_filters( __NAMESPACE__ . '\wpb_plugin_' . $this->slug . '_metabox_settings', array(), $this, get_post( $post_id ) );

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

				/**
				 * Adding all the fields to the sections
				 *
				 * @var $setting WPB_Plugin_Settings_Setting
				 */
				foreach ( $section->get_settings() as $setting ) {
					if ( ! isset( $_REQUEST[ $setting->field_name ] ) ) {
						continue;
					}
					update_post_meta( $post_id, $setting->field_name, $_REQUEST[ $setting->field_name ] );
				}

			}
		}
	}

}
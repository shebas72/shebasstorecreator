<?php
/**
 * Copyright 2013 WP-Buddy.com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your setting) any later version.
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPB_Plugin_Settings_Setting
 * @package wpbuddy\plugins
 * @since   3.0
 * @version 4.0
 */
class WPB_Plugin_Settings_Setting {

	public $id;

	/**
	 * @param string
	 *
	 * @since  1.8
	 */
	public $name;

	/**
	 * @param string
	 *
	 * @since  1.8
	 */
	public $label;

	/**
	 * @param string
	 *
	 * @since  1.8
	 */
	public $type;

	/**
	 * @param mixed
	 *
	 * @since  1.8
	 */
	public $default_value;

	/**
	 * @param mixed
	 *
	 * @since  1.8
	 */
	public $value;

	/**
	 * @param string
	 *
	 * @since  1.8
	 */
	public $help_message;

	/**
	 * @param array
	 *
	 * @since  1.8
	 */
	public $classes;

	/**
	 * All args
	 *
	 * @param array
	 *
	 * @since 3.0
	 */
	public $args;

	/**
	 * Option name
	 * @var string
	 * @since 3.0
	 */
	public $field_name;

	/**
	 * Whether the setting-element is currently displayed (in_metabox or on_options_page)
	 * @var string
	 * @since 3.0
	 */
	public $where = 'in_options_page';

	/**
	 * The post object (only set if used in a metabox )
	 * @var null|\WP_Post
	 * @since 3.0
	 */
	public $post = null;

	/**
	 * If the label should be printed
	 * @var bool
	 * @since 3.0
	 */
	public $print_label = true;


	/**
	 * Arguments for a submit button
	 * @see   \WPB_Plugin_Settings::render_field_submit_button()
	 * @var array
	 * @since 3.0
	 */
	public $submit_button_args = array();


	/**
	 * If the element should be saved as a user meta
	 *
	 * @var bool
	 * @since 4.0
	 */
	public $is_user_meta = false;


	/**
	 * The user id (important to load the user meta
	 * @var int
	 * @since 4.0
	 */
	public $user_id = null;


	/**
	 * Checks if the current text field is a tag field
	 * @var bool
	 * @since 4.0
	 */
	public $is_tags_input = false;


	/**
	 * Adds a placeholder to certain HTML input fields
	 * @var string
	 * @since 4.0
	 */
	public $placeholder = '';


	/**
	 * If the field should be saved to database
	 * @var bool
	 * @since 4.0
	 */
	public $save = true;


	/**
	 * Text before the HTML element
	 * @var string
	 * @since 4.0
	 */
	public $pre = '';


	/**
	 * Text after the HTML element
	 * @var string
	 * @since 4.0
	 */
	public $after = '';


	/**
	 * The content of a field (used by the 'self' type)
	 * @var string
	 * @since 4.0
	 */
	public $content = '';

	/**
	 * An array of data attributes
	 * @var array
	 * @since 3.0
	 */
	public $data = array();


	/**
	 * The function to call to sanitize a field.
	 *
	 * @since  4.1
	 * @access public
	 *
	 * @var string
	 */
	public $sanitize_callback = '';


	/**
	 * An array of other attributes.
	 *
	 * @since  4.1
	 * @access public
	 *
	 * @var array ${DS}attributes Description.
	 */
	public $attributes = array();

	/**
	 * The construct of the settings class
	 *
	 * @since 1.8
	 *
	 * @param string        $id
	 * @param array         $args
	 * @param string        $where
	 *
	 * @param null|\WP_Post $post
	 *
	 * @return \wpbuddy\plugins\CommentRating\WPB_Plugin_Settings_Setting
	 */
	public function __construct( $id, $args, $where = 'in_options_page', $post ) {

		$args['submit_button_args'] = wp_parse_args( ( isset( $args['submit_button_args'] ) ? $args['submit_button_args'] : array() ), array(
				'text'             => null,
				'type'             => 'primary',
				'name'             => 'submit',
				'wrap'             => true,
				'other_attributes' => wp_parse_args( ( isset( $args['submit_button_args']['other_attributes'] ) ? $args['submit_button_args']['other_attributes'] : array() ), array(
						'id' => $id
					)
				),
			)
		);

		$args = wp_parse_args( $args, array(
				'where'                => $where,
				'post'                 => $post,
				'label'                => '',
				'type'                 => 'text',
				'default_value'        => '',
				'help_message'         => '',
				'label_for'            => $id,
				'classes'              => array(),
				'disabled'             => false,
				'other_setting'        => false,
				'is_ajax'              => false,
				'ajax_action'          => '',
				'select_options'       => array(),
				'select_multiple'      => false,
				'related_items'        => array(),
				'not_related_items'    => array(),
				'external_link'        => '',
				'external_link_label'  => '',
				'external_link_target' => '_self',
				'is_codemirror'        => false,
				'codemirror_mode'      => '',
				'description'          => '',
				'print_label'          => true,
				'is_user_meta'         => false,
				'user_id'              => null,
				'is_tags_input'        => false,
				'placeholder'          => '',
				'save'                 => true,
				'pre'                  => '',
				'after'                => '',
				'content'              => '',
				'data'                 => array(),
				'sanitize_callback'    => '',
				'attributes'           => array(),
			)
		);

		if ( false === $args['print_label'] ) {
			$args['label_for'] = '';
		}

		// set the id explicitly
		$this->name = $id;
		$this->id   = & $this->name;

		foreach ( $args as $arg_key => $arg_val ) {
			$this->{$arg_key} = $arg_val;
		}

		$this->field_name = $this->id;

		// add a prefix if this setting is inside a metabox AND when it's shown on a post settings page or custom post type settings page
		if ( 'in_metabox' == $this->where && $post instanceof \WP_Post ) {
			$this->field_name = '_' . SAVENAME . '_' . $this->id;
		}
		else {
			$this->field_name = SAVENAME . '_' . $this->id;
		}

		if ( $this->other_setting ) {
			$this->field_name = SAVENAME . '_' . $this->id;
		}

		if ( empty( $this->value ) ) {
			if ( 'in_metabox' == $this->where && $this->post instanceof \WP_Post ) {
				$this->value = get_post_meta( $post->ID, $this->field_name, true );
			}
			elseif ( $this->is_user_meta ) {
				if ( is_null( $this->user_id ) ) {
					$this->user_id = get_current_user_id();
				}
				$this->value = get_user_meta( $this->user_id, $this->field_name, true );
			}
			else {
				$this->value = get_option( $this->field_name, $this->default_value );
			}
		}

		return $this;

	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function __get( $name ) {
		if ( ! isset( $this->{$name} ) ) {
			return '';
		}

		if ( 'id' == $name ) {
			return sanitize_key( $this->name );
		}

		return $this->{$name};
	}


	/**
	 * @return mixed|void
	 */
	public function get_args() {
		return apply_filters( 'wpb_plugin_get_settings_args', get_object_vars( $this ) );
	}


}
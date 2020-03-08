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

require_once( __DIR__ . '/wpb_plugin_settings_setting.php' );

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPB_Plugin_Settings_Tab
 * @package wpbuddy\plugins
 * @since   3.0
 */
class WPB_Plugin_Settings_Tab {


	/**
	 * The sanitized name of the section
	 * @var string
	 * @since   3.0
	 */
	private $_name;


	/**
	 * The title of the section
	 * @var string
	 * @since   3.0
	 */
	private $_title;


	/**
	 * The settings
	 * @var array
	 * @since   3.0
	 */
	private $_settings = array();


	/**
	 * Array of sections
	 * @var array
	 * @since   3.0
	 */
	private $_subsections = array();


	/**
	 * Where the settings tab is currently in
	 * @var string
	 * @since   3.0
	 */
	private $_where = 'in_options_page';


	/**
	 * The WP_Post object where the current tab is in (only used on metabox-settings)
	 * @var null|\WP_Post
	 * @since   3.0
	 */
	private $_post = null;


	/**
	 * The position of the metabox
	 * @var string
	 * @since   3.0
	 */
	private $_metabox_position = 'normal';


	/**
	 * The priority of the metabox. In WP 3.6 this can be 'high', 'sorted', 'core', 'default', 'low'
	 * @var string
	 * @since 3.0
	 */
	private $_metabox_priority = 'default';


	/**
	 * The content of a page / metabox
	 * @var string
	 * @since 4.0
	 */
	private $_content = '';


	/**
	 * The constructor
	 *
	 * @param string        $name
	 * @param string        $title
	 * @param string        $where
	 * @param null|\WP_Post $post
	 * @param string        $metabox_position
	 * @param string        $metabox_priority
	 *
	 * @since 3.0
	 */
	public function __construct( $name, $title, $where = 'in_options_page', $post = null, $metabox_position = 'normal', $metabox_priority = 'default' ) {
		$this->set_name( $name );
		$this->set_title( $title );
		$this->set_where( $where );
		$this->set_post( $post );
		$this->set_metabox_position( $metabox_position );
		$this->set_metabox_priority( $metabox_priority );
	}

	/**
	 * Sets the title
	 *
	 * @param $title
	 *
	 * @since 3.0
	 */
	public function set_title( $title ) {
		$this->_title = $title;
	}


	/**
	 * returns the title
	 * @return string
	 * @since 3.0
	 */
	public function get_title() {
		return $this->_title;
	}


	/**
	 * sets the $where variable
	 * @since 3.0
	 *
	 * @param string $where
	 */
	public function set_where( $where ) {
		$this->_where = $where;
	}


	/**
	 * returns the where variable
	 * @since 3.0
	 * @return string
	 */
	public function get_where() {
		return $this->_where;
	}


	/**
	 * @param $name
	 *
	 * @since 3.0
	 */
	private function set_name( $name ) {
		$this->_name = $name;
	}


	/**
	 * @return string
	 * @since 3.0
	 */
	public function get_name() {
		return $this->_name;
	}


	/**
	 * @return string
	 * @since 3.0
	 */
	public function get_id() {
		return sanitize_key( $this->get_name() );
	}


	/**
	 * @return array
	 * @since 3.0
	 */
	public function get_settings() {
		return $this->_settings;
	}


	/**
	 * Sets the post object (only used when the tab is viewed inside a metabox)
	 *
	 * @param $post
	 *
	 * @since 3.0
	 */
	public function set_post( $post ) {
		$this->_post = $post;
	}


	/**
	 * Sets the metabox position
	 *
	 * @param string $position
	 *
	 * @since 3.0
	 */
	public function set_metabox_position( $position ) {
		$this->_metabox_position = $position;
	}


	/**
	 * Sets the content of a metabox or a page
	 *
	 * @param string $content
	 *
	 * @since 4.0
	 */
	public function set_content( $content = '' ) {
		$this->_content = $content;
	}

	/**
	 * Returns the post object  (only used when the tab is viewed inside a metabox)
	 * @return null|\WP_Post
	 * @since 3.0
	 */
	public function get_post() {
		return $this->_post;
	}


	/**
	 * Returns the position of the metabox
	 * @return string
	 * @since 3.0
	 */
	public function get_metabox_position() {
		return $this->_metabox_position;
	}


	/**
	 * sets the metabox priority
	 *
	 * @param string $metabox_priority
	 *
	 * @since 3.0
	 */
	public function set_metabox_priority( $metabox_priority ) {
		$this->_metabox_priority = $metabox_priority;
	}


	/**
	 * Returns the metabox priority
	 * @return string
	 * @since 3.0
	 */
	public function get_metabox_priority() {
		return $this->_metabox_priority;
	}


	/**
	 * Returns the content
	 * @return string
	 * @since 4.0
	 */
	public function get_content() {
		return $this->_content;
	}


	/**
	 * Adds an setting to a section
	 *
	 * @param string $id
	 * @param array  $args
	 *
	 * @return WPB_Plugin_Settings_Setting
	 * @since 3.0
	 */
	public function add_setting( $id, $args ) {
		return $this->_settings[$id] = new WPB_Plugin_Settings_Setting( $id, $args, $this->get_where(), $this->get_post() );
	}


	/**
	 * @param string    $name
	 * @param string    $title
	 * @param null|bool $where
	 * @param null      $post
	 * @param string    $metabox_position
	 * @param string    $metabox_priority
	 *
	 * @return WPB_Plugin_Settings_Tab
	 * @since 3.0
	 */
	public function add_subsection( $name, $title, $where = null, $post = null, $metabox_position = 'normal', $metabox_priority = 'default' ) {
		return $this->_subsections[$name] = new WPB_Plugin_Settings_Section(
			$name,
			$title,
			( ( is_null( $where ) ) ? $this->get_where() : $where ),
			( ( is_null( $post ) ) ? $this->get_post() : $post ),
			$metabox_position,
			$metabox_priority
		);
	}


	/**
	 * Adds settings as an array
	 *
	 * @param array $settings
	 *
	 * @return $this WPB_Plugin_Settings_Tab
	 * @since 3.0
	 */
	public function add_settings( $settings ) {
		foreach ( $settings as $id => $args ) {
			$this->add_setting( $id, $args );
		}

		return $this;
	}


	/**
	 * @return array
	 * @since 3.0
	 */
	public function get_subsections() {
		return $this->_subsections;
	}


	/**
	 * @param $name
	 *
	 * @since 3.0
	 *
	 * @return WPB_Plugin_Settings_Setting
	 */
	public function get_setting( $name ) {
		if ( ! isset( $this->_settings[$name] ) ) {
			return new WPB_Plugin_Settings_Setting( '', '', $this->get_where(), $this->get_post() );
		}

		if ( ! $this->_settings[$name] instanceof WPB_Plugin_Settings_Setting ) {
			return new WPB_Plugin_Settings_Setting( '', '', $this->get_where(), $this->get_post() );
		}

		return $this->_settings[$name];
	}


	/**
	 * Renders a section (not really needed and just a placeholder)
	 *
	 * @param array $elements
	 *
	 * @since 3.0
	 */
	public function render( $elements ) {

	}

}
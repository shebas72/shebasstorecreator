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

class WPB_Plugin_Admin_Subpage extends WPB_Plugin_Admin_Page {

	/**
	 * The parent page object
	 * @var WPB_Plugin_Admin_Page
	 * @since 3.0
	 */
	public $parent;


	/**
	 * @param string                          $title
	 * @param  WPB_Plugin_Admin_Page | string $parent Parent Object or parent slug
	 * @param string                          $slug
	 *
	 * @see WPB_Plugin_Admin_Subpage::__construct()
	 */
	public function __construct( $title, $parent, $slug = null ) {
		parent::__construct( $title, $slug );

		$this->parent = $parent;

		return $this;
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
	public function create_menu_entry( $capability = 'manage_options', $icon_url = '', $position = null, $is_subpage = true ) {

		return parent::create_menu_entry( $capability, $icon_url, $position, $is_subpage );

	}


	/**
	 * Removes a sub menu page
	 * @return $this|void
	 * @since 3.0
	 */
	public function remove_page() {
		remove_submenu_page( $this->parent->slug, $this->slug );
		return $this;
	}
}
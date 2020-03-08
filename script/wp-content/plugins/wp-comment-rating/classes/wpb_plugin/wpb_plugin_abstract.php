<?php
/**
 * Core functionality of plugins
 *
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class WPB_Plugin_Abstract
 * @package wpbuddy\plugins
 */
abstract class WPB_Plugin_Abstract {

	abstract public function load_translation();

	abstract public function site_transient_update_plugins( $trans );

	abstract public function plugins_api( $api, $action, $args );

	abstract public function get_client_upgrade_data();

	abstract public function plugins_url( $path, $plugin = null );

	abstract public function update_filters();

	abstract public function activation_hooks();

	abstract public function deactivation_hooks();

	abstract public function theme_on_activation();

	abstract public function get_textdomain();

	abstract public function get_plugin_name_sanitized();

	abstract public function get_plugin_slug_name();

	abstract public function track( $tasks );

	abstract public function upgrade();

	abstract public function set_new_version();

	abstract public function admin_menu();

	abstract public function set_constants();
}
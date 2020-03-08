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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once( __DIR__ . '/wpb_plugin_settings_setting.php' );

/**
 * Class WPB_Plugin_Settings_Section
 * @package wpbuddy\plugins
 * @since   3.0
 */
class WPB_Plugin_Settings_Section extends WPB_Plugin_Settings_Tab {

}
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
 * Class WPB_Plugin_Settings
 * @package wpbuddy\plugins
 */
class WPB_Plugin_Settings {

	/**
	 * Renders a text field
	 *
	 * @param array $args
	 *
	 * @since 3.0
	 * @since 4.0 added functionality to input tags input, added a filter for the classes
	 */
	public static function render_field_text( $args ) {

		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		$args['classes'][] = 'regular-text';

		if ( $args['is_tags_input'] ) {
			$args['classes'][] = 'tagsinput';
		}

		$attributes = '';
		foreach ( $args['attributes'] as $attr_name => $attr_value ) {
			$attributes .= $attr_name . '="' . $attr_value . '"';
		}

		$classes = apply_filters( __NAMESPACE__ . '\wpb_plugin_settings_field_text_classes', $args['classes'] );

		echo $args['pre'] . '<input'
				. ' type="' . $args['type'] . '"'
				. ' placeholder="' . $args['placeholder'] . '"'
				. ' value="' . $args['value'] . '" '
				. ' id="' . $args['id'] . '" '
				. ( ( $args['disabled'] ) ? '' : ' name="' . $args['field_name'] . '" ' )
				. ' class="' . implode( ' ', $classes ) . '"'
				. ( $args['disabled'] ? 'disabled="disabled"' : '' )
				. ' ' . $data
				. ' ' . $attributes
				. ' />' . $args['after'];

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}


	/**
	 * Renders a password field
	 *
	 * @param array $args
	 *
	 * @since 3.0
	 */
	public static function render_field_password( $args ) {

		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<input'
				. ' type="password"'
				. ' placeholder="' . $args['placeholder'] . '"'
				. ' value="" '
				. ' id="' . $args['id'] . '" '
				. ' name="' . $args['field_name'] . '" '
				. ' class="regular-text ' . implode( ' ', $args['classes'] ) . '"'
				. ( $args['disabled'] ? 'disabled="disabled"' : '' )
				. ' ' . $data
				. ' />';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}

	/**
	 * @since 3.0
	 *
	 * @param array $args
	 */
	public static function render_field_onoff( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<div class="onoffswitch" '
				. ' data-related_items="' . json_encode( $args['related_items'] ) . '" '
				. ' data-not_related_items="' . json_encode( $args['not_related_items'] ) . '" '
				. '>'
				. '<input '
				. ' type="checkbox" '
				. ' value="1" '
				. ' name="' . $args['field_name'] . '" '
				. ' class="onoffswitch-checkbox ' . implode( ' ', $args['classes'] ) . '" '
				. ' id="' . $args['id'] . '" ' . ( $args['value'] == 1 ? 'checked="checked"' : '' ) . ' '
				. ' ' . $data
				. ' />'
				. '<label class="onoffswitch-label" for="' . $args['id'] . '">'
				. '<div class="onoffswitch-inner"></div>'
				. '<div class="onoffswitch-switch"></div>'
				. '</label>'
				. '</div>';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}

	}


	/**
	 * @since 3.0
	 *
	 * @param array $args
	 */
	public static function render_field_mediaselect( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<input'
				. ' type="text"'
				. ' value="' . $args['value'] . '" '
				. ' id="' . $args['id'] . '" '
				. ' name="' . $args['field_name'] . '" '
				. ' class="regular-text ' . implode( ' ', $args['classes'] ) . '"'
				. ( $args['disabled'] ? 'disabled="disabled"' : '' )
				. ' ' . $data
				. ' /> ';

		$window_title = _x( 'Select image', 'displayed as the window title in the media library window when the user has to select a file from it', 'wpbplugin' );
		if ( isset( $args['window_title'] ) ) {
			$window_title = $args['window_title'];
		}

		$window_button_name = _x( 'Select', 'displayed on the button in the media library window when the user has to select a file from it', 'wpbplugin' );
		if ( isset( $args['window_button'] ) ) {
			$window_button_name = $args['window_tbutton'];
		}

		echo '<button '
				. 'class="wpb-mediaselect button" '
				. 'data-window_title="' . $window_title . '" '
				. 'data-window_button_name="' . $window_button_name . '" '
				. 'name="' . $args['id'] . '" '
				. 'type="button" value="1" '
				. '>'
				. _x( 'Choose from your Media library', 'displayed on the button when the user has to select a file from the media library', 'wpbplugin' ) . '</button>';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}


	/**
	 * @since 3.0
	 *
	 * @param array        $args
	 *
	 * @global WPB_Backend $wpbBackend
	 * @global wpdb        $wpdb
	 */
	public static function render_field_select( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<select '
				. ' data-related_items="' . htmlspecialchars( json_encode( $args['related_items'] ) ) . '" '
				. ' data-not_related_items="' . htmlspecialchars( json_encode( $args['not_related_items'] ) ) . '" '
				. ' data-ajax_action="wpbplugin_ajax_' . $args['ajax_action'] . '" '
				. ' data-ajax_nonce="' . wp_create_nonce( 'wpbplugin_ajax_' . $args['ajax_action'] ) . '" '
				. ' ' . $data
				. ' id="' . $args['id'] . '" '
				. ' name="' . $args['field_name'] . ( $args['select_multiple'] ? '[]' : '' ) . '" '
				. ' data-placeholder="' . ( $args['select_multiple'] ? _x( 'Please start typing to choose ...', 'displayed on interactive select-boxes to show that the user has to start typing anything so that the options get load via AJAX', 'wpbplugin' ) : _x( 'Please choose ...', 'displayed when the user has to choose between different options in a select box', 'wpbplugin' ) ) . '" '
				. ' class="' . implode( ' ', $args['classes'] ) . ' ' . ( $args['is_ajax'] ? 'chzn-select-ajax' : 'chzn-select' ) . '"'
				. ( $args['select_multiple'] ? ' multiple="multiple" ' : '' )
				. ' style="width:350px;"'
				. ' >';

		// The first option always has an empty option. This is needed for the jQuery Chosen plugin to render the deselect button
		echo '<option value="" ></option>';

		$selected_items = 0;

		foreach ( $args['select_options'] as $label => $option ) {
			$option_value = is_array( $option ) ? $option['value'] : $option;

			$selected = '';
			if ( is_array( $args['value'] ) ) {
				if ( in_array( $option_value, $args['value'] ) ) {
					$selected = 'selected="selected"';
					$selected_items ++;
				}

			}
			else {
				if ( $option_value == $args['value'] ) {
					$selected = 'selected="selected"';
					$selected_items ++;
				}
			}

			echo '<option value="' . $option_value . '" ' . $selected . '>' . $label . '</option>';
		}

		if ( $args['is_ajax'] ) {
			switch ( $args['ajax_action'] ) {
				case 'fontvariantlist':

					if ( ! is_array( $args['value'] ) ) {
						$args['value'] = array( $args['value'] );
					}

					foreach ( $args['value'] as $value ) {
						if ( empty( $value ) ) {
							continue;
						}
						echo '<option value="' . $value . '" selected="selected">' . urldecode( substr( $value, 0, strpos( $value, ':' ) ) ) . ' (Variant: ' . substr( $value, strpos( $value, ':' ) + 1 ) . ')</option>';
					}
					break;
				case 'fontlist':

					if ( ! empty( $args['value'] ) && 0 == $selected_items ) {
						echo '<option value="' . $args['value'] . '" selected="selected">' . substr( $args['value'], 0, strpos( $args['value'], ':' ) ) . '</option>';
					}
					break;
				case 'postlist':
					global $wpbBackend, $wpdb;

					if ( ! is_array( $args['value'] ) ) {
						$args['value'] = array( $args['value'] );
					}

					$post_types = WPB_Plugin::get_posttypes();

					$where_id_in = trim( implode( ',', $args['value'] ) );

					if ( empty( $where_id_in ) ) {
						break;
					}

					$results = $wpdb->get_results( 'SELECT ID, post_title, post_type FROM `' . $wpdb->posts . '` WHERE ID IN (' . $where_id_in . ')', OBJECT_K );

					foreach ( $args['value'] as $post_id ) {
						$post_type       = ! isset( $results[$post_id] ) ? 'Unknown Post type' : $results[$post_id]->post_type;
						$post_type_label = array_search( $post_type, $post_types );
						if ( false === $post_type_label ) {
							$post_type_label = $post_type;
						}

						echo '<option value="' . $post_id . '" selected="selected">' . $results[$post_id]->post_title . ' (' . $post_type_label . ' - ID: ' . $post_id . ')</option>';
					}
					break;
				case 'taglist':
					global $wpdb;

					if ( ! is_array( $args['value'] ) ) {
						$args['value'] = array( $args['value'] );
					}

					$where_term_id_in = implode( ',', $args['value'] );

					if ( empty( $where_term_id_in ) ) {
						break;
					}

					$results = $wpdb->get_results( 'SELECT wpb_terms.term_id, wpb_terms.name, wpb_taxonomy.taxonomy FROM ' . $wpdb->terms . ' as wpb_terms, ' . $wpdb->term_taxonomy . ' as wpb_taxonomy WHERE wpb_taxonomy.term_taxonomy_id = wpb_terms.term_id AND wpb_terms.term_id IN(' . $where_term_id_in . ')' );

					foreach ( $results as $tag ) {
						echo '<option value="' . $tag->term_id . '" selected="selected">' . $tag->name . ' (' . $tag->taxonomy . ')</option>';
					}

					break;
				case 'categorylist':
					if ( ! is_array( $args['value'] ) ) {
						$args['value'] = array( $args['value'] );
					}

					foreach ( $args['value'] as $category_id ) {
						$category_name = get_the_category_by_ID( $category_id );
						if ( is_wp_error( $category_name ) ) {
							continue;
						}
						echo '<option value="' . $category_id . '" selected="selected">' . $category_name . '</option>';
					}
					break;
				case 'userlist':

					if ( ! is_array( $args['value'] ) ) {
						$args['value'] = array( $args['value'] );
					}

					foreach ( $args['value'] as $user_id ) {
						/**
						 * the first value has to be lower case ('id' instead of 'ID')
						 * @var WP_User $user
						 */
						$user = get_user_by( 'id', $user_id );

						if ( ! $user instanceof WP_User ) {
							continue;
						}
						echo '<option value="' . $user_id . '" selected="selected">' . $user->get( 'display_name' ) . ' (' . $user->get( 'user_login' ) . ')</option>';
					}
					break;
			}

		}

		echo '</select>';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}

	}


	/**
	 * Displays an info section
	 * @since 3.0
	 *
	 * @param $args
	 */
	public static function render_field_info( $args ) {

		$classes = apply_filters( __NAMESPACE__ . '\wpb_plugin_settings_field_info_classes', $args['classes'] );

		echo '<p class="' . implode( ' ', $classes ) . '">' . $args['help_message'] . '</p>';
	}


	/**
	 * Displays a textarea field
	 * @since 3.0
	 *
	 * @param $args
	 */
	public static function render_field_textarea( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<textarea'
				. ' cols="30"'
				. ' rows="5"'
				. ' id="' . $args['id'] . '" '
				. ' name="' . $args['field_name'] . '" '
				. ' class="' . implode( ' ', $args['classes'] ) . '"'
				. ( $args['disabled'] ? 'disabled="disabled"' : '' )
				. ' ' . $data
				. ' >'
				. esc_textarea( $args['value'] )
				. '</textarea>';

		if ( $args['is_codemirror'] ) {
			echo '<script>var editor_' . $args['id'] . ' = CodeMirror.fromTextArea( document.getElementById( "' . $args['id'] . '" ), { "mode" : "' . $args['codemirror_mode'] . '", "lineNumbers": true, "indentUnit": 4, "indentWithTabs": true, "lineWrapping": true } );</script>';
		}

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}


	/**
	 * Renders a button for the settings page
	 *
	 * @param array $args
	 *
	 * @since 3.0
	 */
	public static function render_field_button( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			if ( ! is_string( $data_value ) ) {
				$data_value = json_encode( $data_value );
			}
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( $data_value ) . '" ';
		}

		$args['classes'][] = 'button';

		echo '<a ' . $data . ' href="' . $args['external_link'] . '" target="' . $args['external_link_target'] . '" class="' . implode( ' ', $args['classes'] ) . '" id="' . $args['id'] . '">' . $args['external_link_label'] . '</a>';
	}


	/**
	 * Renders a settings_button
	 *
	 * @param array $args
	 *
	 * @since 3.0
	 */
	public static function render_field_submit_button( $args ) {
		submit_button( $args['submit_button_args']['text'], $args['submit_button_args']['type'], $args['submit_button_args']['name'], $args['submit_button_args']['wrap'], $args['submit_button_args']['other_attributes'] );
	}

	/**
	 * Renders a settings_button
	 *
	 * @param array $args
	 *
	 * @since 4.0
	 */
	public static function render_field_file( $args ) {

		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		$data = '';
		foreach ( $args['data'] as $data_name => $data_value ) {
			$data .= 'data-' . $data_name . '="' . htmlspecialchars( json_encode( $data_value ) ) . '" ';
		}

		echo '<input'
				. ' type="file"'
				. ' value="' . $args['value'] . '" '
				. ' id="' . $args['id'] . '" '
				. ( ( $args['disabled'] ) ? '' : ' name="' . $args['field_name'] . '" ' )
				. ' class="regular-text ' . implode( ' ', $args['classes'] ) . '"'
				. ( $args['disabled'] ? 'disabled="disabled"' : '' )
				. ' ' . $data
				. ' />';

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}


	/**
	 * Renders a field specified by the content
	 *
	 * @param array $args
	 *
	 * @since 4.0
	 */
	public static function render_field_self( $args ) {
		if ( ! empty( $args['help_message'] ) ) {
			echo '<a data-field_name="' . $args['id'] . '" href="#" class="wpb-help">?<div class="wpb-help-message">' . $args['help_message'] . '</div></a>';
		}

		echo $args['content'];

		if ( ! empty( $args['description'] ) ) {
			echo '<p class="description">' . $args['description'] . '</p>';
		}
	}
}
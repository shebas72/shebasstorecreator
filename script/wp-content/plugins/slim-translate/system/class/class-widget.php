<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.4.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



class st_config_widget {



	/**
	 * Getting all Strings from database to be
	 * translated
	 * 
	 * @since 2.0.0
	 * 
	 * @return Array
	 */
	public static function get_widget_translations() {
		$array = array();
		foreach( $GLOBALS['wp_widget_factory']->widgets as $widget ) {
			$options = get_option( $widget->option_name );
			foreach( $options as $option ) {
				if( is_array($option) ) {
					foreach( $option as $key => $val ) {
						if( slimTranslate::is_empty($val) === false ) {
							$array[$val] = false;
						}
					}
				}
			}
		}
		return $array;
	}



	/**
	 * getting a string that already translated by slim
	 * translate.
	 * 
	 * @since 2.0.0
	 * 
	 * @param String  $string       string that need to get
	 * @param String  $lang         select language from the string
	 * @param Boolean $return_false if true, then it will return string. Default: false
	 * @return String||Boolean
	 */
	public static function get_widget_translate( $string, $lang, $return_false = false ) {
		/**
		 * getting the option.
		 */
		$get = get_option( slimTranslate::$option_translate );

		/**
		 * checking for the existential.
		 */
		if( !$get ) {
			return self::widget_string_false( $string, $return_false );
		}

		/**
		 * check is the string already translated
		 * or not.
		 */
		if( !isset($get[$string]) ) {
			return self::widget_string_false( $string, $return_false );
		}

		/**
		 * check is the string in the language the choosed
		 * already translated or not.
		 */
		if( !isset($get[$string][$lang]) ) {
			return self::widget_string_false( $string, $return_false );
		}

		/**
		 * check is string in the language that choosed
		 * empty or not.
		 */
		if( slimTranslate::is_empty($get[$string][$lang]) ) {
			return self::widget_string_false( $string, $return_false );
		}

		return $get[$string][$lang];
	}



	/**
	 * setting a string to has the translation
	 * 
	 * @since 2.0.0
	 * 
	 * @param String $string string that need to get
	 * @param String $value  value of translation
	 * @param String $lang   select language from the string
	 * @return Boolean
	 */
	public static function set_widget_translate( $string, $value, $lang ) {
		/**
		 * getting the option.
		 */
		$get = get_option( slimTranslate::$option_translate );

		/**
		 * if option doesn't exist, then it will
		 * add new option before continue.
		 */
		if( !$get ) {
			add_option( slimTranslate::$option_translate, array() );
			$get = array();
		}

		/**
		 * check if $string empty
		 */
		if( slimTranslate::is_empty($string) ) {
			return false;
		}

		/**
		 * check if $value empty
		 */
		if( slimTranslate::is_empty($value) ) {
			return false;
		}

		/**
		 * check if $lang empty
		 */
		if( slimTranslate::is_empty($lang) ) {
			return false;
		}

		/**
		 * setting string to have array, if it doesn't
		 * exist.
		 */
		if( !isset($get[$string]) || !is_array($get[$string]) ) {
			$get[$string] = array();
		}

		/**
		 * translate the string with the value
		 */
		$get[$string][$lang] = $value;

		/**
		 * updating the database
		 */
		update_option( slimTranslate::$option_translate, $get );

		return true;
	}



	/**
	 * Check is the return will be boolean or string
	 * 
	 * @since 2.0.0
	 * 
	 * @param String  $string       string will return
	 * @param Boolean $return_false if true, then it will return string. Default: false
	 * @return String||Boolean
	 */
	public static function widget_string_false( $string, $return_false = false ) {
		if( $return_false === false ) {
			return $string;
		} else {
			return false;
		}
	}



	/**
	 * Hook's action for translation button in widgets.php
	 * 
	 * @access private
	 * @since 2.0.0
	 */
	public static function widgets_admin_page() {
		echo '<div id="slimTranslate-widgets-button" class="slimTranslate-translate-button">';
			echo '<a data-transfer="admin-widgets" data-login="1" data-ver="' . slimTranslate::create_nonce(wp_get_current_user()->user_login) . '" class="st-menu-button st-modal-toggle">';
				esc_html_e( 'Translate Widgets', 'slim-translate' );
			echo '</a>';
		echo '</div>';
	}



	/**
	 * filter function for widget's backend form
	 * 
	 * @since 1.4.0
	 * 
	 * @param Array  $instance array of all instances
	 * @param Object $class    Class of WP_Widget
	 * @return Array
	 */
	public static function widget_form_callback( $instance, $class ) {
		// echo '<main class="slim-edit-tabs slim-edit-tabs-modal">';
		// 	foreach( slimTranslate::get_selected_languages() as $key => $val ) {
		// 		echo '<a href="#" title="' . esc_attr(slimTranslate::get_languages( $val )) . '" data-language="' . $val . '" class="slim-tab-item slim-tab-item-menu ' . ( $key == 0 ? 'active' : '' ) . '"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( $val, 'code' ) . '"></span></a>';
		// 	}
		// echo '</main>';

		//

		foreach( slimTranslate::get_selected_languages() as $lang ) {
			foreach( $instance as $field_name => $field_value ) {
				// echo self::get_widget_id( $class, $field_name, $lang ) . '<br/>';
				// echo '<textarea name=' . esc_attr(self::get_widget_name( $class, $field_name, $lang )) . '>' . esc_html( $field_value ) . '</textarea>' . '<br/>';
			}
			echo '<p/>';
		}
		return $instance;
	} // FUNCTION



	/**
	 * filter function for widget's backend, when saving
	 * the changes.
	 * 
	 * @since 1.4.0
	 * 
	 * @param Array  $instance     Array of all instances
	 * @param Array  $new_instance Array of new instances
	 * @param Array  $old_instance Array of old instances
	 * @param Object $class        Class of WP_Widget
	 * @return Array
	 */
	public static function widget_update_callback( $instance, $new_instance, $old_instance, $class ) {
		return $instance;
	} // FUNCTION



	/**
	 * filter function for widget's front-end.
	 * 
	 * @since 1.4.0
	 * 
	 * @param Array     $instance Array of all instances
	 * @param Object    $class    Class of WP_Widget
	 * @param Arguments $args     Object of the widgets
	 * @return Array
	 */
	public static function widget_display_callback( $instance, $class, $args ) {
		foreach( $instance as $key => $string ) {
			$instance[$key] = slimTranslate::get_widget_translate( $string, slimTranslate::$language );
		}
		return $instance;
	} // FUNCTION

} // CLASS
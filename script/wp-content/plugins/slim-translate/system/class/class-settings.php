<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * class for setting page and for set default setting
 * 
 * @since 1.0
 */
class st_config_settings extends st_config {



	/**
	 * INITIALIZING SETTING => installing theme options
	 * 
	 * @since 1.0
	 */
	public static function install_setting() {
		$languages = slimTranslate::$args->languages;
		$default_lang = slimTranslate::filter_us(get_option( 'WPLANG' ));
		$default = true;
		foreach( $languages as $val ) {
			if( $val == $default_lang ) {
				$default = false;
			}
		}
		if( $default ) {
			array_push( slimTranslate::$args->languages, $default_lang );
		}
		$args = array(
			'auto_language'		=> slimTranslate::$args->auto_language,
			'default_language'	=> $default_lang,
			'languages'			=> slimTranslate::$args->languages,
			/**
			 * @since 1.0
			 * @deprecated 1.1.0
			 */
			'no_translation_alert'	=> slimTranslate::$args->no_translation_alert,
			/**
			 * @since 2.0.0
			 */
			'no_translation_toggle'	=> slimTranslate::$args->no_translation_toggle,
			/**
			 * @since 1.1.0
			 */
			'no_translations'	=> array(
				$default_lang		=> slimTranslate::$args->no_translation_alert,
			),
			'corner_widget'		=> slimTranslate::$args->corner_widget,
			'custom_css'		=> slimTranslate::$args->custom_css,
		);
		add_option( slimTranslate::$args->option_name, json_encode($args) );
	}



	/**
	 * GET SETTING => execute page setting,
	 * 
	 * @since 1.0
	 */
	public static function execute_setting() {
		add_action( 'init', function() {
			require_once slimTranslate::$path . '/includes/settings.php';
		});
	}



	/**
	 * GET LANGUAGE => select user language,
	 * 
	 * @since 1.0
	 */
	public static function select_lang() {
		require_once slimTranslate::$path . '/includes/select-lang.php';
	}



	/**
	 * SAVE SETTING => general
	 * 
	 * @since 1.0
	 */
	public static function save_setting_general() {
		// if verification failed, then terminated
		if( !slimTranslate::verify_nonce($_POST['_st_setting-nonce'], 'general') ) {
			return false;
		}
		// sanitize text field
		$auto_language = isset($_POST['auto_language']) ? $_POST['auto_language'] : false;
		$auto_language = $auto_language ? sanitize_text_field( $auto_language ) : false;
		$no_translation_toggle = isset($_POST['no_translation_toggle']) ? $_POST['no_translation_toggle'] : false;
		$no_translation_toggle = $no_translation_toggle ? sanitize_text_field( $no_translation_toggle ) : false;
		$default_language = sanitize_text_field( $_POST['default_language'] );
		$no_translation_alert = wp_unslash(sanitize_text_field( $_POST['no_translations'][slimTranslate::get_wplang()] ));
		$corner_widget_active = isset($_POST['corner_widget']['active']) ? $_POST['corner_widget']['active'] : false;
		$corner_widget_active = $corner_widget_active ? sanitize_text_field( $_POST['corner_widget']['active'] ) : false;
		$corner_widget_valign = sanitize_text_field( $_POST['corner_widget']['vertical_align'] );
		$corner_widget_halign = sanitize_text_field( $_POST['corner_widget']['horizontal_align'] );
		slimTranslate::$setting->auto_language = $auto_language;
		slimTranslate::$setting->no_translation_toggle = $no_translation_toggle;
		slimTranslate::$setting->default_language = $default_language;
		slimTranslate::$setting->no_translation_alert = $no_translation_alert;
		slimTranslate::$setting->corner_widget->active = $corner_widget_active;
		slimTranslate::$setting->corner_widget->vertical_align = $corner_widget_valign;
		slimTranslate::$setting->corner_widget->horizontal_align = $corner_widget_halign;
		// languages
		$default_lang = true;
		foreach( slimTranslate::$setting->languages as $val ) {
			if( $val == slimTranslate::$language ) {
				$default_lang = false;
			}
		}



		/**
		 * save translation of blog description.
		 * 
		 * @since 1.0.2
		 */
		if( isset($_POST['blogdescription']) ) {
			
			/**
			 * sanistize every blog description
			 */
			foreach( $_POST['blogdescription'] as $desc_var => $desc_val ) {
				$_POST['blogdescription'][$desc_var] = sanitize_text_field($desc_val);
			}

			/**
			 * if blog description of slim translate isn't exists yet,
			 * then it will be added. If not blog description will be
			 * updated.
			 */
			slimTranslate::$setting->blogdescriptions = json_decode( json_encode( $_POST['blogdescription'] ) );

		} // IF



		/**
		 * save multi languages alert
		 * 
		 * @since 1.1.0
		 */
		if( isset($_POST['no_translations']) ) {
			
			/**
			 * sanistize every blog description
			 */
			foreach( $_POST['no_translations'] as $alert_var => $alert_val ) {
				$_POST['no_translations'][$alert_var] = wp_unslash(sanitize_text_field($alert_val));
			}

			/**
			 * if blog description of slim translate isn't exists yet,
			 * then it will be added. If not blog description will be
			 * updated.
			 */
			slimTranslate::$setting->no_translations = json_decode( json_encode( $_POST['no_translations'] ) );

		} // IF



		/**
		 * auto install language default package
		 * 
		 * @since 1.1.0
		 */
		slimTranslate::install_language( 'h'.'ttp'.'s:'.'/'.'/do'.'wnl'.'oa'.'ds.wo'.'rd'.'p'.'ress.or'.'g/trans'.'lation/co'.'re/' . slimTranslate::get_wpversion() . '/' . $default_language . '.z'.'ip', $default_language );



		if( $default_lang ) {
			array_unshift( slimTranslate::$setting->languages, slimTranslate::$language );
		}
		// update option
		update_option( slimTranslate::$args->option_name, json_encode(slimTranslate::$setting) );

		// setting cookies
		$notice = 'updated||' . wp_kses( __( '<strong>Success</strong>, update has been changed.', 'slim-translate' ), array( 'strong' => array() ) );
		setcookie( 'slim_translate_notice', false, time() - 3600 );
		setcookie( 'slim_translate_notice', false, time() - 3600, WT_ST_URIPATH, WT_ST_URIHOST );
		setcookie( 'slim_translate_notice', $notice, time() + 3, WT_ST_URIPATH, WT_ST_URIHOST );

		wp_safe_redirect( $_POST['_st_setting-continue'] );
		exit();
	}



	/**
	 * SAVE SETTING => languages
	 * 
	 * @since 1.0
	 */
	public static function save_setting_languages() {
		// if verification failed, then terminated
		if( !slimTranslate::verify_nonce($_POST['_st_setting-nonce'], 'languages') ) {
			return false;
		}
		// sanitize text field
		$languages = $_POST['st_languages'];
		$languages_ = $languages;
		$languages = json_encode($languages);
		$languages = json_decode($languages);
		slimTranslate::$setting->languages = $languages;
		// update option
		$save = update_option( slimTranslate::$args->option_name, json_encode(slimTranslate::$setting) );

		// copy language package
		if( count($languages_) > 0 ) {
			foreach( $languages_ as $key => $val ) {
				slimTranslate::install_language( 'h'.'ttp'.'s:'.'/'.'/do'.'wnl'.'oa'.'ds.wo'.'rd'.'p'.'ress.or'.'g/trans'.'lation/co'.'re/' . slimTranslate::get_wpversion() . '/' . $val . '.z'.'ip', $val );
			}
		}

		// setting cookies
		$notice = 'updated||' . wp_kses( __( '<strong>Success</strong>, update has been changed.', 'slim-translate' ), array( 'strong' => array() ) );
		setcookie( 'slim_translate_notice', false, time() - 3600 );
		setcookie( 'slim_translate_notice', false, time() - 3600, WT_ST_URIPATH, WT_ST_URIHOST );
		setcookie( 'slim_translate_notice', $notice, time() + 3, WT_ST_URIPATH, WT_ST_URIHOST );
		
		wp_safe_redirect( $_POST['_st_setting-continue'] );
		exit();
	}



	/**
	 * SAVE SETTING => custom css
	 * 
	 * @since 1.0
	 */
	public static function save_setting_custom_css() {
		// if verification failed, then terminated
		if( !slimTranslate::verify_nonce($_POST['_st_setting-nonce'], 'custom-css') ) {
			return false;
		}
		// sanitize text field
		$custom_css = $_POST['custom_css'];
		slimTranslate::$setting->custom_css = $custom_css;
		// update option
		update_option( slimTranslate::$args->option_name, json_encode(slimTranslate::$setting) );

		// setting cookies
		$notice = 'updated||' . wp_kses( __( '<strong>Success</strong>, update has been changed.', 'slim-translate' ), array( 'strong' => array() ) );
		setcookie( 'slim_translate_notice', false, time() - 3600 );
		setcookie( 'slim_translate_notice', false, time() - 3600, WT_ST_URIPATH, WT_ST_URIHOST );
		setcookie( 'slim_translate_notice', $notice, time() + 3, WT_ST_URIPATH, WT_ST_URIHOST );
		
		wp_safe_redirect( $_POST['_st_setting-continue'] );
		exit();
	}



	/**
	 * GET CUSTOM CSS
	 * 
	 * @since 1.0
	 */
	public static function get_custom_css() {
		if( isset($_GET['slim-translate-css']) && $_GET['slim-translate-css'] == 'true' ) {
			header("Content-type: text/css; charset: UTF-8");
			echo slimTranslate::$setting->custom_css;
			exit;
		}
	}



	/**
	 * set backend language
	 * 
	 * @since 1.4.0
	 * @param String $language select what language that want to install
	 * @return Bool
	 */
	public static function set_backend_language( $language ) {

		/**
		 * getting current user
		 */
		$user = wp_get_current_user();

		/**
		 * getting user meta data of language
		 */
		$get = get_user_meta( $user->ID, '_st_backend_language', true );

		/**
		 * if language that user choosed equals to
		 * language that already choosed before,
		 * then returning true.
		 */
		if( $language == $get ) {
			return true;
		}

		/**
		 * if it's already exists inside database, then system
		 * only need to update.
		 *
		 * But if it doesn't exist, then
		 * system need to add another user meta base on current
		 * user.
		 */
		if( $get ) {
			$return = update_user_meta( $user->ID, '_st_backend_language', $language, $get );
		} else {
			$return = add_user_meta( $user->ID, '_st_backend_language', $language, true );
		}

		/**
		 * return base on $return variable
		 */
		return $return ? true : false;

	}



	/**
	 * NOTICE ON SETTING
	 * 
	 * @since 1.0
	 */
	public static function setting_notice() {
		if( !isset($_COOKIE['slim_translate_notice']) ) {
			return false;
		}
	
		$notice_cookie = $_COOKIE['slim_translate_notice'];
		$notice = '<div id="message" class="' . substr( $notice_cookie, 0, strpos( $notice_cookie, '||' ) ) . '">';
			$notice .= '<p>' . substr( $notice_cookie, strpos( $notice_cookie, '||' )+2 ) . '</p>';
		$notice .= '</div>';
		echo $notice;
	}



	/**
	 * INSTALL LANGUAGE
	 * 
	 * @since 1.0
	 */
	public static function install_language( $url, $name = 'translate' ) {

		/**
		 * if directory doesn't exists, then this will create
		 * the directory.
		 */
		if( !file_exists(slimTranslate::languages_dir()) ) {
			mkdir( slimTranslate::languages_dir(), 0777, true );
		}

		/**
		 * if language package is installed, then progress
		 * will be terminated
		 */
		if( file_exists( slimTranslate::languages_dir() . '/' . $name . '.m'.'o' ) ) {
			return false;
		}

		/**
		 * if file isn't exists, then progress will be terminated
		 */
		$url_trim = slimTranslate::get_contents($url);
		if( strpos( ' ' . $url_trim, '404' ) > 0 ) {
			return false;
		}

		/**
		 * copy language zip inside wordpress languages directory.
		 * if progress failed, then progress will be terminated
		 */
		$zip_file = slimTranslate::languages_dir() . '/' . $name . '.z'.'ip';
		$copy = copy( $url, $zip_file );
		if( !$copy ) {
			return false;
		}

		/**
		 * extracting zip file
		 */
		$zip = new ZipArchive;
		if( @$zip->open($zip_file) === TRUE ) {
			$zip->extractTo( slimTranslate::languages_dir() );
			$zip->close();
			unlink( $zip_file );
			return true;
		}

		/**
		 * if extraction progress failed, then
		 * return false
		 */
		else {
			if( file_exists($zip_file) ) {
				unlink( $zip_file );
			}
			return false;
		}

	} // FUNCTION

}
<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



class st_config_post extends st_config_settings {



	/**
	 * Header title for column
	 * 
	 * @since 1.0
	 */
	public static function col_head($defaults) {
		wp_enqueue_style( 'slim-translate-css', slimTranslate::$path_url . '/assets/css/style.css' );
		if( isset($_GET['post_type']) && $_GET['post_type'] == 'product' ) {
			$defaults['st-translations-col-wc'] = slimTranslate::$args->column_head;
		} else {
			$defaults['st-translations-col'] = slimTranslate::$args->column_head;
		}
		return $defaults;
	}



	/**
	 * Value for translation column
	 * 
	 * @since 1.0
	 */
	public static function col_body($column_name, $post_ID) {
		if( isset($_GET['post_type']) && $_GET['post_type'] == 'product' ) {
			$equals = 'st-translations-col-wc';
		} else {
			$equals = 'st-translations-col';
		}
		if( $column_name == $equals ) {
			$no_translate = ' class="no-translate" ';
			echo '<div class="slim-post-list">';
				foreach( slimTranslate::$setting->languages as $key ) {
					// get key from system
					$title_key = '_st_title_' . $key;
					$meta_key = '_st_content_' . $key;
					// meta value
					$title_val = get_post_meta( $post_ID, $title_key, true );
					$meta_val = get_post_meta( $post_ID, $meta_key, true );
					echo '<a href="#"' . ( (!$title_val && !$meta_val && slimTranslate::get_wplang() !== $key ) ? $no_translate : false ) . 'data-title="' . slimTranslate::get_languages($key) . '">';
						echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $key, 'code' ) . '"></span>';
					echo '</a>';
				}
			echo '</div>';
		}
	}



	/**
	 * POST LIST COLUMN => add filter and action for post list column
	 * 
	 * @since 1.0
	 */
	public static function column_post_list() {
		add_filter('manage_post_posts_columns', array( 'st_config_post', 'col_head' ) );
		add_action('manage_post_posts_custom_column', array( 'st_config_post', 'col_body' ), 10, 2);
		add_filter('manage_page_posts_columns', array( 'st_config_post', 'col_head' ) );
		add_action('manage_page_posts_custom_column', array( 'st_config_post', 'col_body' ), 10, 2);
		add_filter('manage_product_posts_columns', array( 'st_config_post', 'col_head' ) );
		add_action('manage_product_posts_custom_column', array( 'st_config_post', 'col_body' ), 10, 2);
		st_config_term::column_term_list();
	}



	/**
	 * POST TRANSLATION => add metabox / tabs for translation add
	 * corner widget.
	 * 
	 * @since 1.0
	 */
	public static function execute_post_edit() {
		add_action( 'slimTranslate/function/after', function() {
			require_once slimTranslate::$path . '/includes/post-edit.php';
			st_config_term::execute_term_edit();
			require_once slimTranslate::$path . '/includes/corner-widget.php';
		});
	}



	/**
	 * DOING SAVE => save translate from post or page
	 * 
	 * @since 1.0
	 * @deprecated 1.0.1
	 */
	public static function hidden_form() {
		add_action( 'edit_form_after_title', function() {
			global $post;
			if( get_post_type() == slimTranslate::$args->post_type ) {
				if( slimTranslate::$pagenow == 'post-new.php' ) {
					echo '<input name="st_translate_new" value="' . slimTranslate::create_nonce( slimTranslate::$args->meta_prefix ) . '" type="hidden" style="display: none;" required />';
					echo '<input name="st_lang" value="' . ( isset($_GET['st_lang']) ? $_GET['st_lang'] : '' ) . '" type="hidden" style="display: none;" required />';
					echo '<input name="st_id" value="' . ( isset($_GET['st_id']) ? $_GET['st_id'] : '' ) . '" type="hidden" style="display: none;" required />';
				} else if( slimTranslate::$pagenow == 'post.php' ) {
					echo '<input name="st_translate_edit" value="' . slimTranslate::create_nonce( slimTranslate::$args->meta_prefix . $post->ID ) . '" type="hidden" style="display: none;" required />';
					echo '<input name="st_lang" value="' . ( isset($_GET['st_lang']) ? $_GET['st_lang'] : '' ) . '" type="hidden" style="display: none;" required />';
					echo '<input name="st_id" value="' . ( isset($_GET['st_id']) ? $_GET['st_id'] : '' ) . '" type="hidden" style="display: none;" required />';
				}
			}
		});
		self::doing_save();
	}



	/**
	 * DOING SAVE => save translate from post or page
	 * 
	 * @since 1.0
	 * @deprecated 1.0.1
	 */
	public static function doing_save() {
		add_action( 'save_post', function( $post_id, $post, $update ) {
			if( $post->post_type == slimTranslate::$args->post_type ) {
				// new translation
				if( !slimTranslate::verify_nonce( $_POST['st_translate_new'], slimTranslate::$args->meta_prefix ) ) {} else {
					if( isset($_POST['st_id']) && isset($_POST['st_lang']) && !empty($_POST['st_id']) && !empty($_POST['st_lang']) ) {
						$st_id = sanitize_text_field($_POST['st_id']);
						$st_lang = sanitize_text_field($_POST['st_lang']);
						add_post_meta( $st_id, slimTranslate::$args->meta_prefix . $st_lang, $post_id, true );
						$header = 'post.php?post=' . $post_id . '&action=edit&st_type=' . slimTranslate::$args->post_type . '&st_lang=' . $st_lang . '&st_id=' . $st_id;
						wp_safe_redirect( admin_url($header) );
						exit;
					} else {
						wp_safe_redirect( admin_url() );
						exit;
					}
				}
				// edit translation
				if( !slimTranslate::verify_nonce( $_POST['st_translate_edit'], slimTranslate::$args->meta_prefix . $post_id ) ) {} else {
					if( isset($_POST['st_id']) && isset($_POST['st_lang']) && !empty($_POST['st_id']) && !empty($_POST['st_lang']) ) {
						$st_id = sanitize_text_field($_POST['st_id']);
						$st_lang = sanitize_text_field($_POST['st_lang']);
						$header = 'post.php?post=' . $post_id . '&action=edit&st_type=' . slimTranslate::$args->post_type . '&st_lang=' . $st_lang . '&st_id=' . $st_id;
						wp_safe_redirect( admin_url($header) );
						exit;
					} else {
						wp_safe_redirect( admin_url() );
						exit;
					}
				}
			}
		}, 10, 3);
	} // FUNCTION



	/**
	 * GET THE ALERT => get the alert base on language
	 * 
	 * @access public
	 * @since 1.1.0
	 * @param string $language language that wan tto choose
	 * @return string || boolean
	 */
	public static function get_the_alert( $language = false ) {
		
		/**
		 * storing default language
		 */
		$default_language = slimTranslate::get_wplang();

		/**
		 * if language is empty, then default language will take it
		 */
		if( $language === false ) {
			$language = slimTranslate::$language;
		}
		
		/**
		 * check if no_translations variable and no_translation_alert
		 * don't exists, then return nothing.
		 */
		if( !isset(slimTranslate::$setting->no_translations) && !isset(slimTranslate::$setting->no_translation_alert) ) {
			return false;
		}
		
		/**
		 * check if no_translations variable doesn't exists,
		 * then it's returning no_translation_alert.
		 */
		else if( !isset(slimTranslate::$setting->no_translations) && isset(slimTranslate::$setting->no_translation_alert) ) {
			return slimTranslate::$setting->no_translation_alert;
		}
		
		/**
		 * if alert on this language is empty, then it's returning
		 * by wordpress default language
		 */
		else if( isset(slimTranslate::$setting->no_translations->$language) ) {
			// trim language
			$trim			= trim(slimTranslate::$setting->no_translations->$language);
			$trim_default	= trim(slimTranslate::$setting->no_translations->$default_language);
			if( !empty($trim) ) {
				return $trim;
			} else if( !empty($trim_default) ) {
				return $trim_default;
			} else {
				return false;
			}
		}
		
		/**
		 * if language that choosed doen't exist, then default language
		 * will be returned.
		 */
		else if( isset(slimTranslate::$setting->no_translations->$default_language) ) {
			// trim language
			$trim_default	= trim(slimTranslate::$setting->no_translations->$default_language);
			if( !empty($trim_default) ) {
				return $trim_default;
			} else {
				return false;
			}
		}
		
		/**
		 * if no_translation_alert variable exists, then it will be
		 * returned.
		 */
		else if( isset(slimTranslate::$setting->no_translation_alert) ) {
			// trim language
			$trim_default	= trim(slimTranslate::$setting->no_translation_alert);
			if( !empty($trim_default) ) {
				return $trim_default;
			} else {
				return false;
			}
		}
		
		/**
		 * if all filters pass away, it will return false
		 */
		else {
			return false;
		}

	} // FUNCTION



	/**
	 * GET THE ALERT => get the alert base on language
	 * 
	 * @access public
	 * @since 1.1.0
	 * @see function get_the_alert
	 */
	public static function the_alert( $language = false ) {
		echo self::get_the_alert( $language );
	}



	/**
	 * REMOVE TRANSLATION under contents
	 * 
	 * @access public
	 * @since 1.2.0
	 */
	public static function remove_translation( $content = false ) {
		// if content false, then return back the content
		if( !$content ) {
			return $content;
		}
		// filter the content
		if( strpos( ' ' . $content, '<!-- SLIMTRANSLATEw54$30oqd3 -->' ) > 0 ) {
			return substr( $content, 0, strpos( $content, '<!-- SLIMTRANSLATEw54$30oqd3 -->' ) );
		} else {
			return $content;
		}
	}



	/**
	 * Check for no translation alert toggle setting
	 * 
	 * @access public
	 * @since 2.0.0
	 */
	public static function get_no_translation_toggle() {
		if( !isset(slimTranslate::$setting->no_translation_toggle) ) {
			return false;
		}
		if( slimTranslate::$setting->no_translation_toggle ) {
			return true;
		} else {
			return false;
		}
	}

} // CLASS
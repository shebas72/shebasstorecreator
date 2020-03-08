<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



class st_config extends st_config_widget {



	/**
	 * CREATE NONCE => create verification code, based on wp_create_nonce
	 * 
	 * @since 1.0
	 */
	public static function create_nonce( $key ) {
		$key = ( isset(slimTranslate::$args->meta_prefix) ? slimTranslate::$args->meta_prefix : slimTranslate::$args['meta_prefix'] ) . $key;
		return wp_create_nonce( $key );
	}



	/**
	 * VERIFY NONCE => verification code, based on wp_verify_nonce
	 * 
	 * @since 1.0
	 */
	public static function verify_nonce( $code, $key ) {
		$key = ( isset(slimTranslate::$args->meta_prefix) ? slimTranslate::$args->meta_prefix : slimTranslate::$args['meta_prefix'] ) . $key;
		return wp_verify_nonce( $code, $key );
	}



	/**
	 * GET IP ADDRESS => get client / user IP address
	 * 
	 * @since 1.0
	 */
	public static function get_ip() {
		if( isset($_SERVER['HTTP_CLIENT_IP']) ) {
			$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
		} else if( isset($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else if( isset($_SERVER['HTTP_X_FORWARDED']) ) {
			$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
		} else if( isset($_SERVER['HTTP_FORWARDED_FOR']) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
		} else if( isset($_SERVER['HTTP_FORWARDED']) ) {
			$ipaddress = $_SERVER['HTTP_FORWARDED'];
		} else if( isset($_SERVER['REMOTE_ADDR']) ) {
			$ipaddress = $_SERVER['REMOTE_ADDR'];
		} else {
			$ipaddress = false;
		}
		return $ipaddress;
	}



	/**
	 * LANGUAGE english US filtering
	 * 
	 * @since 1.0
	 */
	public static function filter_us( $obj ) {
		$obj = trim($obj);
		if( empty($obj) ) {
			return 'en_US';
		} else {
			return $obj;
		}
	}



	/**
	 * getting address bar uri
	 * 
	 * @since 1.4.0
	 * @return String
	 */
	public static function get_uri() {
		
		if( !isset($_SERVER['REQUEST_URI']) ) {
			
			$_SERVER['REQUEST_URI'] = $_SERVER['SCRIPT_NAME'];
			
			if($_SERVER['QUERY_STRING']) {
				$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
			}

		}

		return $_SERVER['REQUEST_URI'];
	}



	/**
	 * check is some address has query string or not.
	 * 
	 * @since 1.4.0
	 * @param string $address URI
	 * @return bool
	 */
	public static function has_query( $address = false ) {

		/**
		 * if address empty, then return the uri
		 */
		if( !$address ) {
			$address = slimTranslate::get_uri();
		}
		
		/**
		 * if character "?" found inside string, then
		 * return true
		 */
		if( strpos( ' ' . $address, '?' ) > 0 ) {
			return true;
		} else {
			return false;
		}

	}



	/**
	 * get wordpress language
	 * 
	 * @since 1.0
	 */
	public static function get_wplang() {
		return self::filter_us(get_option('WPLANG'));
	}



	/**
	 * get backend language
	 * 
	 * @since 1.4.0
	 */
	public static function get_backend_language() {
		// getting current user who login
		$user = wp_get_current_user();

		// getting user meta of backend language
		$language = get_user_meta( $user->ID, '_st_backend_language', true );

		/**
		 * if backend language doesns't exist yet,
		 * then will get system's language.
		 */
		if(!$language) {
			$language = slimTranslate::get_wplang();
		}

		/**
		 * preparing false value of variable that
		 * will be executed inside looping of
		 * foreach below.
		 */
		$enabled = false;

		/**
		 * looping to check is the language choosed from
		 * slim translate setting or not. If language
		 * that choosed is selected from slim translate
		 * setting, then "$enabled" will turn into true.
		 */
		foreach( slimTranslate::get_selected_languages() as $key => $val ) {
			if( $val == $language ) {
				$enabled = true;
			}
		}

		/**
		 * if "$enabled" variable is in {false} condition,
		 * then backend language will be back to
		 * default wordpress language.
		 */
		if( !$enabled ) {
			$language = slimTranslate::get_wplang();
		}

		// returning the language
		return $language;
	}



	/**
	 * check is language already inside the selected
	 * language or not
	 * 
	 * @since 1.4.0
	 * @param String $lang check this language is ready or not
	 * @return bool
	 */
	public static function is_language_ready( $lang ) {

		/**
		 * preparing false value of variable that
		 * will be executed inside looping of
		 * foreach below.
		 */
		$enabled = false;

		/**
		 * looping to check is the language choosed from
		 * slim translate setting or not. If language
		 * that choosed is selected from slim translate
		 * setting, then "$enabled" will turn into true.
		 */
		foreach( slimTranslate::get_selected_languages() as $val ) {
			if( $val == $lang ) {
				$enabled = true;
			}
		}
		
		return $enabled;
	}



	/**
	 * print get wordpress language
	 * 
	 * @since 1.1.0
	 * @see function get_wplang
	 */
	public static function wplang() {
		echo get_wplang();
	}



	/**
	 * FILE GET CONTENTS: get json or http contents inside body
	 * use this function instead
	 * 
	 * ARGUMENTS that exists:
	 * + [http]: URL address
	 * 
	 * slimTranslate::get_contents( 'http://example.com/' );
	 * 
	 * @since 1.0
	 */
	public static function get_contents( $http ) {
		// set md5 encoding from the $http
		$transient = md5($http);
		// Check for transient, if none, grab remote HTML file
		if ( false === ( $html = get_transient( $transient ) ) ) {

			// Get remote HTML file
			$response = wp_remote_get( $http );

			// Check for error
			if ( is_wp_error( $response ) ) {
				return;
			}

			// Parse remote HTML file
			$data = wp_remote_retrieve_body( $response );

			// Check for error
			if ( is_wp_error( $data ) ) {
				return;
			}

			// Store remote HTML file in transient, expire after 5 minute
			set_transient( $transient, $data, MINUTE_IN_SECONDS );

			// get back the transient
			$html = get_transient( $transient );

		} // IF
		return $html;

	} // FUNCTION



	/**
	 * Languages name
	 * 
	 * @since 2.0.2
	 */
	public static function get_languages( $key = false, $get = 'name' ) {

		// languages list
		$languages = array(
			'af' 				=> array( 'za', self::unicode_decode('\u0041\u0066\u0072\u0069\u006b\u0061\u0061\u006e\u0073'), 															'za' ),
			'ak' 				=> array( 'gh', self::unicode_decode('\u0041\u006b\u0061\u006e'), 																							'gh' ),
			'sq' 				=> array( 'al', self::unicode_decode('\u0053\u0068\u0071\u0069\u0070'), 																					'al' ),
			'arq' 				=> array( 'dz', self::unicode_decode('\u0627\u0644\u062f\u0627\u0631\u062c\u0629 \u0627\u0644\u062c\u0632\u0627\u064a\u0631\u064a\u0629'), 					'dz' ),
			'am' 				=> array( 'et', self::unicode_decode('\u12a0\u121b\u122d\u129b'), 																							'et' ),
			'ar' 				=> array( 'sa', self::unicode_decode('\u0627\u0644\u0639\u0631\u0628\u064a\u0629'), 																		'sa' ),
			'hy' 				=> array( 'am', self::unicode_decode('\u0540\u0561\u0575\u0565\u0580\u0565\u0576'), 																		'am' ),
			'rup_MK'			=> array( 'mk', self::unicode_decode('\u0041\u0072\u006d\u00e3\u006e\u0065\u0061\u0073\u0068\u0063\u0065'), 												'rup_mk' ),
			'frp' 				=> array( 'fr', self::unicode_decode('\u0041\u0072\u0070\u0069\u0074\u0061\u006e'), 																		'frp_fr' ),
			'as' 				=> array( 'in', self::unicode_decode('\u0985\u09b8\u09ae\u09c0\u09af\u09bc\u09be'), 																		'as_in' ),
			'ast' 				=> array( 'ro', self::unicode_decode('\u0041\u0073\u0074\u0075\u0072\u0069\u0061\u006e\u0075'), 															'ast_ro' ),
			'az' 				=> array( 'az', self::unicode_decode('\u0041\u007a\u0259\u0072\u0062\u0061\u0079\u0063\u0061\u006e \u0064\u0069\u006c\u0069'), 								'az' ),
			'az_TR'				=> array( 'tr', self::unicode_decode('\u0041\u007a\u0259\u0072\u0062\u0061\u0079\u0063\u0061\u006e \u0054\u00fc\u0072\u006b\u0063\u0259\u0073\u0069'), 		'az_tr' ),
			'bcc'				=> array( 'ir', self::unicode_decode('\u0628\u0644\u0648\u0686\u06cc \u0645\u06a9\u0631\u0627\u0646\u06cc'),												'bcc_ir' ),
			'ba'				=> array( 'ru', self::unicode_decode('\u0431\u0430\u0448\u04a1\u043e\u0440\u0442 \u0442\u0435\u043b\u0435'),		 										'ba_ru' ),
			'eu' 				=> array( 'ro', self::unicode_decode('\u0045\u0075\u0073\u006b\u0061\u0072\u0061'), 																		'eu_ro' ),
			'bel'				=> array( 'by', self::unicode_decode('\u0411\u0435\u043b\u0430\u0440\u0443\u0441\u043a\u0430\u044f \u043c\u043e\u0432\u0430'), 								'by' ),
			'bn_BD' 			=> array( 'bd', self::unicode_decode('\u09ac\u09be\u0982\u09b2\u09be'), 																					'bd' ),
			'bs_BA' 			=> array( 'ba', 'Bosanski', 					'ba' ),
			'bre'				=> array( 'fr', 'Brezhoneg', 					'bre_fr' ),
			'bg_BG' 			=> array( 'bg', self::unicode_decode('\u0411\u044a\u043b\u0433\u0430\u0440\u0441\u043a\u0438'), 															'bg' ),
			'ca' 				=> array( 'es', self::unicode_decode('\u0043\u0061\u0074\u0061\u006c\u00e0'), 																				'ca_es' ),
			'ceb' 				=> array( 'ph', 'Cebuano', 						'ceb_ph' ),
			'zh_CN' 			=> array( 'cn', self::unicode_decode('\u7b80\u4f53\u4e2d\u6587'), 																							'cn' ),
			'zh_HK' 			=> array( 'hk', self::unicode_decode('\u9999\u6e2f\u4e2d\u6587\u7248'), 																					'hk' ),
			'zh_TW' 			=> array( 'tw', self::unicode_decode('\u7e41\u9ad4\u4e2d\u6587'), 																							'tw' ),
			'co' 				=> array( 'ro', 'Corsu',						'co_ro' ),
			'hr' 				=> array( 'hr', 'Hrvatski', 					'hr' ),
			'cs_CZ' 			=> array( 'cz', self::unicode_decode('\u010c\u0065\u0161\u0074\u0069\u006e\u0061\u200e'), 																	'cz' ),
			'da_DK' 			=> array( 'dk', 'Dansk', 						'dk' ),
			'dv' 				=> array( 'mv', self::unicode_decode('\u078b\u07a8\u0788\u07ac\u0780\u07a8'),																				'mv' ),
			'nl_NL' 			=> array( 'nl', 'Nederlands', 					'nl' ),
			'nl_BE' 			=> array( 'be', self::unicode_decode('\u004e\u0065\u0064\u0065\u0072\u006c\u0061\u006e\u0064\u0073 \u0028\u0042\u0065\u006c\u0067\u0069\u00eb\u0029'),		'be' ),
			'dzo' 				=> array( 'bt', self::unicode_decode('\u0f62\u0fab\u0f7c\u0f44\u0f0b\u0f41'),																				'bt' ),
			'en_AU' 			=> array( 'au', 'English (Australia)',			'au' ),
			'en_CA' 			=> array( 'ca', 'English (Canada)', 			'ca' ),
			'en_NZ' 			=> array( 'nz', 'English (New Zealand)', 		'en_nz' ),
			'en_ZA' 			=> array( 'za', 'English (South Africa)', 		'en_za' ),
			'en_GB' 			=> array( 'gb', 'English (UK)', 				'gb' ),
			'en_US' 			=> array( 'us', 'English (US)', 				'us' ),
			'eo' 				=> array( 'pl', 'Esperanto', 					'eo_pl' ),
			'et' 				=> array( 'ee', 'Eesti', 						'ee' ),
			'fo' 				=> array( 'fo', self::unicode_decode('\u0046\u00f8\u0072\u006f\u0079\u0073\u006b\u0074'), 																	'fo' ),
			'fi' 				=> array( 'fi', 'Suomi', 						'fi' ),
			'fr_BE' 			=> array( 'be', self::unicode_decode('\u0046\u0072\u0061\u006e\u00e7\u0061\u0069\u0073 \u0064\u0065 \u0042\u0065\u006c\u0067\u0069\u0071\u0075\u0065'), 	'fr_be' ),
			'fr_CA' 			=> array( 'ca', self::unicode_decode('\u0046\u0072\u0061\u006e\u00e7\u0061\u0069\u0073 \u0064\u0075 \u0043\u0061\u006e\u0061\u0064\u0061'), 				'fr_ca' ),
			'fr_FR' 			=> array( 'fr', self::unicode_decode('\u0046\u0072\u0061\u006e\u00e7\u0061\u0069\u0073'), 																	'fr' ),
			'fur' 				=> array( 'it', 'Friulian', 					'fur_it' ),
			'fuc' 				=> array( 'mr', 'Pulaar',	 					'mr' ),
			'gl_ES' 			=> array( 'es', 'Galego', 						'gl_es' ),
			'ka_GE' 			=> array( 'ge', self::unicode_decode('\u10e5\u10d0\u10e0\u10d7\u10e3\u10da\u10d8'),																			'ge' ),
			'de_DE' 			=> array( 'de', 'Deutsch', 						'de' ),
			'de_CH' 			=> array( 'ch', 'Deutsch (Schweiz)', 			'ch' ),
			'el' 				=> array( 'gr', self::unicode_decode('\u0395\u03bb\u03bb\u03b7\u03bd\u03b9\u03ba\u03ac'),	 																'gr' ),
			'kal' 				=> array( 'gl', 'Kalaallisut',	 				'gl' ),
			'gn' 				=> array( 'bo', self::unicode_decode('\u0041\u0076\u0061\u00f1\u0065\u0027\u1ebd'), 																		'bo' ),
			'gu' 				=> array( 'in', self::unicode_decode('\u0a97\u0ac1\u0a9c\u0ab0\u0abe\u0aa4\u0ac0'), 																		'gu_in' ),
			'hat' 				=> array( 'ht', 'Kreyol ayisyen', 				'ht' ),
			'haw_US'			=> array( 'us', self::unicode_decode('\u014c\u006c\u0065\u006c\u006f \u0048\u0061\u0077\u0061\u0069\u02bb\u0069'), 											'haw_us' ),
			'haz' 				=> array( 'af', self::unicode_decode('\u0647\u0632\u0627\u0631\u0647 \u06af\u06cc'), 																		'haz_af' ),
			'he_IL' 			=> array( 'il', self::unicode_decode('\u05e2\u05b4\u05d1\u05b0\u05e8\u05b4\u05d9\u05ea'),																	'il' ),
			'hi_IN' 			=> array( 'in', self::unicode_decode('\u0939\u093f\u0928\u094d\u0926\u0940'), 																				'in' ),
			'hu_HU' 			=> array( 'hu', 'Magyar',		 				'hu' ),
			'is_IS' 			=> array( 'is', self::unicode_decode('\u00cd\u0073\u006c\u0065\u006e\u0073\u006b\u0061'), 																	'is' ),
			'ido'				=> array( 'fr', 'Ido',		 					'ido_fr' ),
			'id_ID' 			=> array( 'id', 'Bahasa Indonesia', 			'id' ),
			'ga'				=> array( 'ie', 'Gaelige', 						'ie' ),
			'it_IT' 			=> array( 'it', 'Italiano', 					'it' ),
			'ja' 				=> array( 'jp', self::unicode_decode('\u65e5\u672c\u8a9e'), 																								'jp' ),
			'jv_ID'				=> array( 'id', 'Basa Jawa', 					'jv_id' ),
			'kab'				=> array( 'dz', 'Taqbaylit', 					'kab_dz' ),
			'kn'				=> array( 'in', self::unicode_decode('\u0c95\u0ca8\u0ccd\u0ca8\u0ca1'), 																					'kn_in' ),
			'kk'				=> array( 'kz', self::unicode_decode('\u049a\u0430\u0437\u0430\u049b \u0442\u0456\u043b\u0456'), 															'kz' ),
			'km'				=> array( 'kh', self::unicode_decode('\u1797\u17b6\u179f\u17b6\u1781\u17d2\u1798\u17c2\u179a'),	 															'kh' ),
			'kin'				=> array( 'rw', 'Ikinyarwanda', 				'rw' ),
			'ko_KR' 			=> array( 'kr', self::unicode_decode('\ud55c\uad6d\uc5b4'), 																								'kr' ),
			'ckb'				=> array( 'ir', self::unicode_decode('\u0643\u0648\u0631\u062f\u06cc\u200e'),																				'ckb_ir' ),
			'kir'				=> array( 'kg', self::unicode_decode('\u041a\u044b\u0440\u0433\u044b\u0437\u0447\u0430'),	 																'kir' ),
			'lo'				=> array( 'la', self::unicode_decode('\u0e9e\u0eb2\u0eaa\u0eb2\u0ea5\u0eb2\u0ea7'),	 																		'la' ),
			'lv'				=> array( 'lv', self::unicode_decode('\u004c\u0061\u0074\u0076\u0069\u0065\u0161\u0075 \u0076\u0061\u006c\u006f\u0064\u0061'),		 						'lv' ),
			'li'				=> array( 'de', 'Limburgs', 					'li_de' ),
			'lin'				=> array( 'cg', 'Ngala', 						'cg' ),
			'lt_LT' 			=> array( 'lt', self::unicode_decode('\u004c\u0069\u0065\u0074\u0075\u0076\u0069\u0173 \u006b\u0061\u006c\u0062\u0061'), 				'lt' ),
			'lb_LU'				=> array( 'lu', self::unicode_decode('\u004c\u00eb\u0074\u007a\u0065\u0062\u0075\u0065\u0072\u0067\u0065\u0073\u0063\u0068'), 			'lu' ),
			'mk_MK' 			=> array( 'mk', self::unicode_decode('\u041c\u0430\u043a\u0435\u0434\u043e\u043d\u0441\u043a\u0438 \u0458\u0430\u0437\u0438\u043a'), 				'mk' ),
			'mg_MG'				=> array( 'mg', 'Malagasy', 					'mg' ),
			'ms_MY' 			=> array( 'my', 'Bahasa Melayu', 				'my' ),
			'ml_IN'				=> array( 'in', self::unicode_decode('\u0d2e\u0d32\u0d2f\u0d3e\u0d33\u0d02'),				'ml_in' ),
			'mri'				=> array( 'nz', self::unicode_decode('\u0054\u0065 \u0052\u0065\u006f \u004d\u0101\u006f\u0072\u0069'), 					'nz' ),
			'mr' 				=> array( 'in', self::unicode_decode('\u092e\u0930\u093e\u0920\u0940'), 					'mr_in' ),
			'mn' 				=> array( 'mn', self::unicode_decode('\u041c\u043e\u043d\u0433\u043e\u043b'), 			'mn' ),
			'ary' 				=> array( 'ma', self::unicode_decode('\u0627\u0644\u0639\u0631\u0628\u064a\u0629 \u0627\u0644\u0645\u063a\u0631\u0628\u064a\u0629'), 			'ma' ),
			'my_MM' 			=> array( 'mm', self::unicode_decode('\u1017\u1019\u102c\u1005\u102c'), 		'mm' ),
			'ne_NP' 			=> array( 'np', self::unicode_decode('\u0928\u0947\u092a\u093e\u0932\u0940'), 		'np' ),
			'nb_NO' 			=> array( 'no', self::unicode_decode('\u004e\u006f\u0072\u0073\u006b \u0062\u006f\u006b\u006d\u00e5\u006c'),		'nb_no' ),
			'nn_NO' 			=> array( 'no', 'Norsk nynorsk', 				'no' ),
			'oci' 				=> array( 'fr', 'Occitan', 						'oci_fr' ),
			'ps' 				=> array( 'af', self::unicode_decode('\u067e\u069a\u062a\u0648'), 					'af' ),
			'fa_IR' 			=> array( 'ir', self::unicode_decode('\u0641\u0627\u0631\u0633\u06cc'),					'ir' ),
			'fa_AF' 			=> array( 'af', self::unicode_decode('\u0028\u0641\u0627\u0631\u0633\u06cc \u0028\u0627\u0641\u063a\u0627\u0646\u0633\u062a\u0627\u0646'),					'fa_af' ),
			'pl_PL' 			=> array( 'pl', 'Polski', 						'pl' ),
			'pt_BR' 			=> array( 'br', self::unicode_decode('\u0050\u006f\u0072\u0074\u0075\u0067\u0075\u00ea\u0073 \u0064\u006f \u0042\u0072\u0061\u0073\u0069\u006c'), 		'br' ),
			'pt_PT' 			=> array( 'pt', self::unicode_decode('\u0050\u006f\u0072\u0074\u0075\u0067\u0075\u00ea\u0073'), 	'pt' ),
			'ro_RO' 			=> array( 'ro', self::unicode_decode('\u0052\u006f\u006d\u00e2\u006e\u0103'),					'ro' ),
			'ru_RU' 			=> array( 'ru', self::unicode_decode('\u0420\u0443\u0441\u0441\u043a\u0438\u0439'), 					'ru' ),
			'gd' 				=> array( 'gb', self::unicode_decode('\u0047\u00e0\u0069\u0064\u0068\u006c\u0069\u0067'), 			'gd_gb' ),
			'sr_RS' 			=> array( 'rs', self::unicode_decode('\u0421\u0440\u043f\u0441\u043a\u0438 \u0458\u0435\u0437\u0438\u043a'), 					'rs' ),
			'sk_SK' 			=> array( 'sk', self::unicode_decode('\u0053\u006c\u006f\u0076\u0065\u006e\u010d\u0069\u006e\u0061'), 					'sk' ),
			'sl_SI' 			=> array( 'si', self::unicode_decode('\u0053\u006c\u006f\u0076\u0065\u006e\u0161\u010d\u0069\u006e\u0061'), 				'si' ),
			'so_SO' 			=> array( 'so', 'Afsoomaali', 				'so' ),
			'azb' 				=> array( 'az', self::unicode_decode('\u06af\u0624\u0646\u0626\u06cc \u0622\u0630\u0631\u0628\u0627\u06cc\u062c\u0627\u0646'), 		'azb_az' ),
			'es_AR' 			=> array( 'ar', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0041\u0072\u0067\u0065\u006e\u0074\u0069\u006e\u0061'), 		'ar' ),
			'es_CL' 			=> array( 'cl', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0043\u0068\u0069\u006c\u0065'),	 		'cl' ),
			'es_CO' 			=> array( 'co', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0043\u006f\u006c\u006f\u006d\u0062\u0069\u0061'), 		'co' ),
			'es_GT' 			=> array( 'gt', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0047\u0075\u0061\u0074\u0065\u006d\u0061\u006c\u0061'), 		'gt' ),
			'es_MX' 			=> array( 'mx', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u004d\u00e9\u0078\u0069\u0063\u006f'), 		'mx' ),
			'es_PE' 			=> array( 'pe', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0050\u0065\u0072\u00fa'), 			'pe' ),
			'es_ES' 			=> array( 'es', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c'),	 		'es' ),
			'es_VE' 			=> array( 've', self::unicode_decode('\u0045\u0073\u0070\u0061\u00f1\u006f\u006c \u0064\u0065 \u0056\u0065\u006e\u0065\u007a\u0075\u0065\u006c\u0061'), 		've' ),
			'su_ID'				=> array( 'id', 'Basa Sunda', 					'su_id' ),
			'sv_SE' 			=> array( 'se', 'Svenska', 						'se' ),
			'tl' 				=> array( 'ph', 'Tagalog', 						'ph' ),
			'th' 				=> array( 'th', self::unicode_decode('\u0e44\u0e17\u0e22'), 					'th' ),
			'bo' 				=> array( 'cn', self::unicode_decode('\u0f56\u0f7c\u0f51\u0f0b\u0f61\u0f72\u0f42'),					'bo_cn' ),
			'tr_TR' 			=> array( 'tr', self::unicode_decode('\u0054\u00fc\u0072\u006b\u00e7\u0065'), 					'tr' ),
			'tuk' 				=> array( 'tm', self::unicode_decode('\u0054\u00fc\u0072\u006b\u006d\u0065\u006e\u00e7\u0065'), 					'tm' ),
			'ug_CN' 			=> array( 'cn', self::unicode_decode('\u0055\u0079\u01a3\u0075\u0072\u0071\u0259'), 					'ug_cn' ),
			'uk' 				=> array( 'ua', self::unicode_decode('\u0423\u043a\u0440\u0430\u0457\u043d\u0441\u044c\u043a\u0430'), 				'ua' ),
			'ur'	 			=> array( 'pk', self::unicode_decode('\u0627\u0631\u062f\u0648'), 					'pk' ),
			'uz_UZ'	 			=> array( 'uz', self::unicode_decode('\u004f\u2018\u007a\u0062\u0065\u006b\u0063\u0068\u0061'), 					'uz' ),
			'vi' 				=> array( 'vn', self::unicode_decode('\u0054\u0069\u1ebf\u006e\u0067 \u0056\u0069\u1ec7\u0074'), 				'vn' ),
			'cy' 				=> array( 'gb', 'Cymraeg', 						'cy_gb' ),
		);

		// return all of them
		if( $key === false ) {
			return $languages;
		}
		
		// return a point
		else if( isset( $languages[$key] ) ) {
			if( $get == 'code' ) {
				return $languages[$key][0];
			} else {
				return $languages[$key][1];
			}
		}

		// return nothing if languages doesn't exists
		else {
			return false;
		}

	} // FUNCTION



	/**
	 * WOOCOMMERCE CHECK => check is this website using woocommerce or not
	 * 
	 * @since 1.0
	 */
	public static function is_wc() {
		$wc = slimTranslate::get_var( 'wc' );
		if( $wc ) {
			return true;
		} else {
			return false;
		}
	} // FUNCTION



	/**
	 * LANGUAGES DIR => get wordpress languages directory
	 * 
	 * @since 1.0
	 */
	public static function languages_dir() {
		return slimTranslate_dir( wp_upload_dir()['basedir'] ) . '/languages';
	} // FUNCTION



	/**
	 * GET WORDPRESS VERSION
	 * 
	 * @access public
	 * @since 1.1.0
	 * @return string
	 */
	public static function get_wpversion() {
		$wp_version = get_bloginfo('version');
		if( strpos($wp_version, '-') > 0 ) {
			$wp_version = substr( $wp_version, 0, strpos( $wp_version, '-' ) );
		} else {
			$wp_version = substr( $wp_version, 0 );
		}
		return $wp_version;
	} // FUNCTION



	/**
	 * echo GET WORDPRESS VERSION
	 * 
	 * @since 1.1.0
	 * @see function get_wpversion
	 */
	public static function wpversion() {
		echo self::get_wpversion();
	} // FUNCTION



	/**
	 * get looping of all languages that
	 * choosed.
	 * 
	 * @since 1.3.0
	 * @return Object Array
	 */
	public static function get_selected_languages() {
		$languages = array( slimTranslate::get_wplang() );
		if( count(slimTranslate::$setting->languages) > 0 ) {
			foreach( slimTranslate::$setting->languages as $var ) {
				if( slimTranslate::get_wplang() !== $var ) {
					array_push( $languages, $var );
				}
			}
		}
		return $languages;
	} // FUNCTION



	/**
	 * Checking is the string empty or not by
	 * including trim action.
	 * 
	 * @since 1.4.0
	 * 
	 * @param String $obj check string that want to check
	 * @return Boolean
	 */
	public static function is_empty( $obj ) {
		$obj = trim($obj);
		if( empty($obj) ) {
			return true;
		} else {
			return false;
		}
	} // FUNCTION



	/**
	 * Decoding the unicode
	 * 
	 * @since 2.0.2
	 * 
	 * @param String $string unicode that need to be decoded
	 * @return String
	 */
	public static function unicode_decode( $string ) {
		$string = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
			return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
		}, $string);
		return $string;
	}

} // CLASS
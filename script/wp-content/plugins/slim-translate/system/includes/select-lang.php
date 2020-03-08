<?PHP
/**
 * "../includes/select-lang.php"
 * 
 * @package		Slim Translate
 * @since		1.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * if this is a backend page, than it will closed
 */
if( is_admin() ) {
	return false;
}



// get global language
global $locale;



/**
 * allowable languages list
 */
$setting_languages_ = slimTranslate::$setting->languages;
foreach( $setting_languages_ as $key => $val ) {
	$setting_languages[$val] = true;
}



/**
 * auto select language
 */
if( slimTranslate::$setting->auto_language && !isset($_COOKIE['slim_translate_language']) && !isset($_GET['st-lang']) ) {
	$ip = slimTranslate::get_contents( 'http://freegeoip.net/json/' . slimTranslate::get_ip() );
	$ip = json_decode( $ip );
	if( !empty($ip->country_code) ) {
		$locate = $ip->country_code;
		$locate = strtolower($locate);
		$languages_ = slimTranslate::get_languages();
		foreach( $languages_ as $key => $val ) {
			$languages[$val[2]] = $key;
		}
		// set languages
		if( isset($languages[$locate]) && isset($setting_languages[$languages[$locate]]) ) {
			$auto_language_set = true;
			$locale = $languages[$locate];
			slimTranslate::$language = $languages[$locate];
		}
	}
}



/**
 * when user choosing the language
 */
if( !isset($auto_language_set) && isset($_GET['st-lang']) && slimTranslate::get_languages($_GET['st-lang']) && isset($setting_languages[$_GET['st-lang']]) ) {

	// setting cookies
	$cookie = 'slim_translate_language';
	$cookie_day	= time() + (86400 * 30); // a day
	$cookie_year = time() + 31556926; // a year
	$cookie_time_delete = time() - 3600; // yesterday
	setcookie( $cookie, false, $cookie_time_delete );
	setcookie( $cookie, false, $cookie_time_delete, WT_ST_URIPATH, WT_ST_URIHOST );
	setcookie( $cookie, $_GET['st-lang'], $cookie_day, WT_ST_URIPATH, WT_ST_URIHOST );

	// $address
	$address = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

	if( isset($_GET['st-continue']) ) {
		header( 'Location:' . $_GET['st-continue'] );
	} else {
		header( 'Location:' . substr( $address, 0, strpos( $address, 'st-lang' )-1 ) );
	}
	exit;

} // IF



/**
 * set language if user set the cookie
 */
else if( !isset($auto_language_set) && isset($_COOKIE['slim_translate_language']) && isset($setting_languages[$_COOKIE['slim_translate_language']]) ) {
	$locale = $_COOKIE['slim_translate_language'];
	slimTranslate::$language = $_COOKIE['slim_translate_language'];
} // IF



/**
 * HOOK locale set site language by the locale
 * 
 * @since 1.0
 */
add_filter( 'locale', function( $locale ) {
	
	/**
	 * if there are nothing language set before,
	 * then progress will be terminated.
	 */
	if( !isset(slimTranslate::$language) ) {
		return $locale;
	}
	
	/**
	 * if language empty, then progress will terminated
	 */
	$trim = trim(slimTranslate::$language);
	if( empty($trim) ) {
		return $locale;
	
	/**
	 * but if language are set, then language will be
	 * set as $locale
	 */
	} else {
		return slimTranslate::$language;
	}

}); // HOOK filter locale

// define( 'WPLANG', slimTranslate::$language );
<?PHP
/**
 * "../core/translate/bloginfo.php"
 * 
 * ABOUT: Filter all blog information
 * 
 * @package		Slim Translate
 * @since		1.0.2
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 1.0.2
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * HOOK bloginfo => filter all blog information
 * 
 * @since 1.0.2
 * 
 * @return string
 */
add_filter( 'bloginfo', function( $output, $show ) {

	/**
	 * if this blog info is getting for description,
	 * and it's not a default language.
	 */
	if( $show == 'description' && slimTranslate::$language !== slimTranslate::get_wplang() ) {

		/**
		 * if blogdescriptions variable is not exists,
		 * then it will be terminated.
		 */
		if( !isset(slimTranslate::$setting->blogdescriptions) ) {
			return $output;
		}

		/**
		 * getting translation of blog description
		 * that already set before of slim translate
		 */
		$option = slimTranslate::$setting->blogdescriptions;
		$lang = slimTranslate::$language;
		if( isset($option->$lang) ) {

			/**
			 * if translation is not empty, then process will
			 * continue. But if it's empty, then return 
			 * default blog description
			 */
			$trim = trim($option->$lang);
			if( !empty($trim) ) {
				return $option->$lang;
			} else {
				return $output;
			}
			
		} else {
			return $output;
		} // ELSE

	} // IF

	/**
	 * if all if was not like what it's needed, then
	 * it's returning the output
	 */
	else {
		return $output;
	} // ELSE

}, 10, 2 ); // HOOK bloginfo
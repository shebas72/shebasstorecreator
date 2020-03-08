<?PHP
/**
 * "../includes/corner-widget.php"
 * 
 * ABOUT: Corner widget for the plugin
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
 * check if corner widget doesn't actived, then it will terminate.
 * 
 * @since 1.0
 */
if( slimTranslate::$setting->corner_widget->active === false ) {
	return false;
}



/**
 * include the corner widget to footer of the page
 * 
 * @since 1.0
 */
add_action( 'get_footer', function() {
	
	echo '<div class="st-translate-widget ' . slimTranslate::$setting->corner_widget->vertical_align . ' ' . slimTranslate::$setting->corner_widget->horizontal_align . '">';

		/**
		 * active / default language will show as the toggle
		 */
		echo '<div class="st-toggle">';
			echo '<a href="#" class="st-flag-item">';
				echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::$language, 'code' ) . '"></span>';
				echo '<div>' . slimTranslate::get_languages( slimTranslate::$language ) . '</div>';
			echo '</a>';
		echo '</div>';

		/**
		 * another language will show if visitor click the toggle
		 */
		if( count(slimTranslate::$setting->languages) > 0 ) {

			if( count($_GET) > 0 ) {
				$get = '';
				foreach( $_GET as $key => $val ) {
					if( $key != 'st-lang' ) {
						$get = $get . '&' . $key . '=' . $val;
					}
				}
			} else {
				$get = '';
			}

			echo '<div class="st-dropdown" style="display: none;">';
			foreach( slimTranslate::$setting->languages as $key => $val ) {
				if( slimTranslate::$language !== $val ) {
					echo '<a href="?st-lang=' . $val . $get . '&st-continue=' . urlencode( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) . '" class="st-flag-item">';
						echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $val, 'code' ) . '"></span>';
						echo '<div>' . slimTranslate::get_languages( $val ) . '</div>';
					echo '</a>';
				}
			}
			echo '</div>';
		} // IF

	echo '</div>';

}); // HOOK ACTION get_footer
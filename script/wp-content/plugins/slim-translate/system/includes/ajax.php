<?PHP
/**
 * "../includes/ajax.php"
 * 
 * ABOUT: All ajax actions will be here
 * 
 * @package		Slim Translate
 * @since		1.3.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 1.3.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * ajax result for "nav-menus.php"
 * 
 * @since 1.3.0
 */
$nav_menus = function() {
	require_once( slimTranslate::$path . '/core/ajax/nav-menus.php' );
	exit;
};
add_action( 'wp_ajax_slimTranslate_ajax_nav-menus', $nav_menus );
add_action( 'wp_ajax_nopriv_slimTranslate_ajax_nav-menus', $nav_menus );



/**
 * save setting, action for
 * ajax result "nav-menus.php"
 * 
 * @since 1.3.0
 */
$nav_menus_save = function() {
	require_once( slimTranslate::$path . '/core/ajax/nav-menus-save.php' );
	exit;
};
add_action( 'wp_ajax_slimTranslate_ajax_nav-menus-save', $nav_menus_save );
add_action( 'wp_ajax_nopriv_slimTranslate_ajax_nav-menus-save', $nav_menus_save );



/**
 * widgets ajax form
 * 
 * @since 2.0.0
 */
$widgets = function() {
	require_once( slimTranslate::$path . '/core/ajax/widgets.php' );
	exit;
};
add_action( 'wp_ajax_slimTranslate_ajax_admin-widgets', $widgets );
add_action( 'wp_ajax_nopriv_slimTranslate_ajax_admin-widgets', $widgets );



/**
 * save setting, action for
 * ajax result "widgets.php"
 * 
 * @since 2.0.0
 */
$widgets_save = function() {
	require_once( slimTranslate::$path . '/core/ajax/widgets-save.php' );
	exit;
};
add_action( 'wp_ajax_slimTranslate_ajax_widgets-save', $widgets_save );
add_action( 'wp_ajax_nopriv_slimTranslate_ajax_widgets-save', $widgets_save );
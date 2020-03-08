<?PHP
/**
 * "../includes/settings.php"
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
 * if setting false, then setting page will not registered
 */
if( slimTranslate::$args->setting->active === false ) {
	return false;
}



/**
 * action when save setting
 */
if( isset($_POST['_st_setting-action']) && $_POST['_st_setting-action'] == 'general' ) {
	slimTranslate::save_setting_general();
} else if( isset($_POST['_st_setting-action']) && $_POST['_st_setting-action'] == 'languages' ) {
	slimTranslate::save_setting_languages();
} else if( isset($_POST['_st_setting-action']) && $_POST['_st_setting-action'] == 'custom-css' ) {
	slimTranslate::save_setting_custom_css();
}


/**
 * register setting page as a menu above appereance menu
 */
if( slimTranslate::$args->setting->position == 'menu' ) {
	add_action( 'admin_menu', function() {
		//add an item to the menu
		add_menu_page (
			slimTranslate::$args->setting->page_title,
			slimTranslate::$args->setting->menu_label,
			'manage_options',
			slimTranslate::$args->setting->slug,
			function() {
				require_once slimTranslate::$path . '/core/settings/config.php';
			},
			slimTranslate::$args->setting->icon,
			'59'
		);
	});
}


/**
 * register setting page as a submenu inside tools menu
 */
else {
	// registering menu
	add_action( 'admin_menu', function() {
		add_management_page(
			slimTranslate::$args->setting->page_title,
			slimTranslate::$args->setting->menu_label,
			'manage_options',
			slimTranslate::$args->setting->slug,
			function() {
				require_once slimTranslate::$path . '/core/settings/config.php';
			}
		);
	});
}
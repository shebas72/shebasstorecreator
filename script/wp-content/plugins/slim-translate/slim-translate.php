<?PHP
/**
 * @package		Slim Translate
 * @since		1.0
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @version		2.0.2
 * 
 * @wordpress-plugin
 * Plugin Name: Slim Translate
 * Plugin URI:  http://warungthemes.com
 * Description: Let visitors read what they understanding, and let visitors choose their own language as they want. "Slim Translate" can directly change the language without login to backend and change the language from inside the system.
 * Version:     2.0.2
 * Author:      Bestafiko Borizqy
 * Author URI:  http://themeforest.net/user/warungdsgn/?ref=warungdsgn
 * License: GPL/MIT
 * License URI: http://themeforest.net/licenses
 * Text Domain: slim-translate
 * Domain Path: /languages
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
 * getting system
 * 
 * @since 1.0
 */
require_once plugin_dir_path( __FILE__ ) . '/system/config.php';



/**
 * execute the plugin
 * 
 * @since 1.0
 */
slimTranslate::execute( array(
	'auto_language'		=> true,
	'mode'				=> 'plugin',
	'corner_widget'		=> array(
		'active'			=> true,
		'vertical_align'	=> 'st-v-top',
		'horizontal_align'	=> 'st-h-right',
	),
));
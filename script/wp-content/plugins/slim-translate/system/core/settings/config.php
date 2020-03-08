<?PHP
/**
 * "../core/settings/config.php"
 * 
 * ABOUT: setting's configuration
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



wp_enqueue_style( 'slim-translate-css', slimTranslate::$path_url . '/assets/css/style.css' );
wp_enqueue_script( 'slim-translate-js', slimTranslate::$path_url . '/assets/js/script.js' );
wp_localize_script( 'slim-translate-js', 'slim_translate', slimTranslate::get_var( 'js_translate' ) );
wp_enqueue_script( 'ace-editor-no-conflict-js', slimTranslate::$path_url . '/assets/plugins/ace-editor/src-min/ace.js' );
wp_enqueue_script( 'slim-translate-ace-editor-js', slimTranslate::$path_url . '/assets/js/script-ace-editor.js' );

require_once slimTranslate::$path . '/core/settings/wrapper.php';
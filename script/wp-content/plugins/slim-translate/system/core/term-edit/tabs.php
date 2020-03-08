<?PHP
/**
 * "../core/term-edit/tabs.php"
 * 
 * ABOUT: Term's Description fields
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
 * tabs for term OR taxomony, including two fields
 * that use as verification that it's real page.
 * 
 * @since 1.0
 */
echo '<main class="slim-edit-tabs">';
	echo '<a href="#" data-title-target="_st_term_title_name" data-content-target="_st_term_content_description" class="slim-tab-item slim-tab-item-term active"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::get_wplang(), 'code' ) . '"></span> <span class="flag-text">' . slimTranslate::get_languages( slimTranslate::get_wplang() ) . '</span></a>';
	foreach( slimTranslate::$setting->languages as $var ) {
		if( slimTranslate::get_wplang() !== $var ) {
			echo '<a href="#" data-title-target="_st_term_title_' . $var . '" data-content-target="_st_term_content_' . $var . '" class="slim-tab-item slim-tab-item-term"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( $var, 'code' ) . '"></span> <span class="flag-text">' . slimTranslate::get_languages( $var ) . '</span></a>';
		}
	}
echo '</main>';

echo '<input type="hidden" name="_slim_translate_term_nonce_id" value="' . slimTranslate::$args->option_name . '" required />';
echo '<input type="hidden" name="_slim_translate_term_nonce_vr" value="' . slimTranslate::create_nonce( slimTranslate::$args->option_name ) . '" required />';
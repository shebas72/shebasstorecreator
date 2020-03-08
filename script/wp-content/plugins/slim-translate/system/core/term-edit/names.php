<?PHP
/**
 * "../core/term-edit/names.php"
 * 
 * ABOUT: Term's Names fields
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
 * translation fields for term's name
 * 
 * @since 1.0
 */
echo '<input type="hidden" id="_st_term_title_name" name="name" value="' . $term_name . '" />';
foreach( slimTranslate::$setting->languages as $lang ) {
	if( slimTranslate::get_wplang() !== $lang ) {
		echo '<input type="hidden" id="_st_term_title_' . $lang . '" name="_st_term_title_' . $lang . '" placeholder="' . $lang . '" value="' . get_term_meta( $term_id, '_st_term_title_' . $lang, true ) . '" />';
	}
}
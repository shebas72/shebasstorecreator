<?PHP
/**
 * "../core/term-edit/descriptions.php"
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
 * translation fields for term's description
 * 
 * @since 1.0
 */
echo '<textarea style="display: none !important;"  id="_st_term_content_description" name="description">' . $term_description . '</textarea>';
foreach( slimTranslate::$setting->languages as $lang ) {
	if( slimTranslate::get_wplang() !== $lang ) {
		echo '<textarea style="display: none !important;"  id="_st_term_content_' . $lang . '" name="_st_term_content_' . $lang . '">' . get_term_meta( $term_id, '_st_term_content_' . $lang, true ) . '</textarea>';
	}
}
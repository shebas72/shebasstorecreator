<?PHP
/**
 * "../core/translate/queried_object-archive.php"
 * 
 * ABOUT: Filter for queried_object but if in
 * archive page only
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
 * HOOK wp => filter the global $post variable
 * 
 * @since 1.0
 * 
 * @return string
 */
add_action( 'slimTranslate/wp', function() {

	/**
	 * is this is not singular page, then progress will
	 * be terminated.
	 */
	if( !is_archive() ) {
		return false;
	}

	/**
	 * getting $post variable
	 */
	global $wp_query;

	/**
	 * if queried_objext doesn't exists, it will terminated
	 * by return false;
	 */
	if( !isset($wp_query->queried_object) ) {
		return false;
	}

	/**
	 * FILTER NAME
	 */
	$name_new = get_term_meta( $wp_query->queried_object->term_id, '_st_term_title_' . slimTranslate::$language, true );
	$wp_query->queried_object->name = $name_new ? $name_new : $wp_query->queried_object->name;

	/**
	 * FILTER CAT NAME
	 */
	$wp_query->queried_object->cat_name = $name_new ? $name_new : $wp_query->queried_object->cat_name;

	/**
	 * FILTER DESCRIPTION
	*/
	$desc_new = get_term_meta( $wp_query->queried_object->term_id, '_st_term_content_' . slimTranslate::$language, true );
	$wp_query->queried_object->description = $desc_new ? $desc_new : $wp_query->queried_object->description;

	/**
	 * FILTER CATEGORY DESCRIPTION
	*/
	$desc_new = get_term_meta( $wp_query->queried_object->term_id, '_st_term_content_' . slimTranslate::$language, true );
	$wp_query->queried_object->category_description = $desc_new ? $desc_new : $wp_query->queried_object->category_description;

}, 31); // HOOK wp
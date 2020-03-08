<?PHP
/**
 * "../includes/term-edit.php"
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



// adding FLAG ICON
add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_style( 'slim-translate-css', slimTranslate::$path_url . '/assets/css/style.css' );
	wp_enqueue_script( 'slim-translate-js', slimTranslate::$path_url . '/assets/js/script.js', array('jquery'), '', true );
	wp_localize_script( 'slim-translate-js', 'slim_translate', slimTranslate::get_var( 'js_translate' ) );
});



// save post
add_action( 'edited_category', array( 'st_config_term', 'save_term' ) );
add_action( 'edited_post_tag', array( 'st_config_term', 'save_term' ) );
if( slimTranslate::is_wc() ) {
	add_action( 'edited_product_cat', array( 'st_config_term', 'save_term' ) );
	add_action( 'edited_product_tag', array( 'st_config_term', 'save_term' ) );
	$objects = wc_get_attribute_taxonomies();
	foreach( $objects as $object ) {
		add_action( 'edited_pa_' . $object->attribute_name , array( 'st_config_term', 'save_term' ) );
	}
}



// tabs
add_action( 'category_edit_form_fields', array( 'st_config_term', 'extra_form' ) );
add_action( 'post_tag_edit_form_fields', array( 'st_config_term', 'extra_form' ) );
if( slimTranslate::is_wc() ) {
	add_action( 'product_cat_edit_form_fields', array( 'st_config_term', 'extra_form' ) );
	add_action( 'product_tag_edit_form_fields', array( 'st_config_term', 'extra_form' ) );
	$objects = wc_get_attribute_taxonomies();
	foreach( $objects as $object ) {
		add_action( "pa_" . $object->attribute_name . "_edit_form_fields", array( 'st_config_term', 'extra_form' ) );
	}
}



// filters
if( !is_admin() ) {
	require_once slimTranslate::$path . '/core/term-edit/filters.php';
}
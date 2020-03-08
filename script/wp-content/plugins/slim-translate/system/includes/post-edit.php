<?PHP
/**
 * "../includes/post-edit.php"
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
 * adding stylesheet and javascript to backend screens.
 * all stylesheet and javascript will be added to form when
 * editing the post/page.
 * 
 * @since 1.0
 */
add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_style( 'slim-translate-css', slimTranslate::$path_url . '/assets/css/style.css' );
	wp_enqueue_script( 'slim-translate-js', slimTranslate::$path_url . '/assets/js/script.js', array('jquery'), WT_ST_VERSION, true );
	wp_localize_script( 'slim-translate-js', 'slim_translate', slimTranslate::get_var( 'js_translate' ) );
});


/**
 * tabs to switch the language.
 * 
 * @since 1.0
 */
add_action( 'edit_form_top', function() {
	require_once slimTranslate::$path . '/core/post-edit/tabs.php';
});



/**
 * translation form for title
 * 
 * @since 1.0
 */
add_action( 'edit_form_after_title', function() {
	require_once slimTranslate::$path . '/core/post-edit/titles.php';
});



/**
 * translation form for content
 * 
 * @since 1.0
 */
add_action( 'edit_form_after_title', function() {
	require_once slimTranslate::$path . '/core/post-edit/contents.php';
});



/**
 * HOOK => action when saving the post / page
 * 
 * @since 1.0
 */
add_action( 'save_post', function( $post_id, $post, $update ) {
	if( isset($_POST['_slim_translate_nonce_id']) && isset($_POST['_slim_translate_nonce_vr']) ) {
		
		// verifying data
		if( !slimTranslate::verify_nonce( $_POST['_slim_translate_nonce_vr'], $_POST['_slim_translate_nonce_id'] ) ) {
			return false;
		}

		// TITLES
		$prefix_title = '_st_title_';
		foreach( slimTranslate::$setting->languages as $lang ) {
			if( slimTranslate::get_wplang() !== $lang && isset($_POST[$prefix_title . $lang]) && !empty($_POST[$prefix_title . $lang]) ) {
				add_post_meta( $post_id, $prefix_title . $lang, sanitize_text_field($_POST[$prefix_title . $lang]), true );
				update_post_meta( $post_id, $prefix_title . $lang, sanitize_text_field($_POST[$prefix_title . $lang]) );
			}
		}

		// CONTENTS
		$prefix_content = '_st_content_';
		foreach( slimTranslate::$setting->languages as $lang ) {
			if( slimTranslate::get_wplang() !== $lang && isset($_POST[$prefix_content . $lang]) && !empty($_POST[$prefix_content . $lang]) ) {
				add_post_meta( $post_id, $prefix_content . $lang, $_POST[$prefix_content . $lang], true );
				update_post_meta( $post_id, $prefix_content . $lang, $_POST[$prefix_content . $lang] );
			}
		}

		// EXCERPT
		$prefix_excerpt = '_st_excerpt_';
		foreach( slimTranslate::$setting->languages as $lang ) {
			if( slimTranslate::get_wplang() !== $lang && isset($_POST[$prefix_excerpt . $lang]) && !empty($_POST[$prefix_excerpt . $lang]) ) {
				add_post_meta( $post_id, $prefix_excerpt . $lang, $_POST[$prefix_excerpt . $lang], true );
				update_post_meta( $post_id, $prefix_excerpt . $lang, $_POST[$prefix_excerpt . $lang] );
			}
		}

	}
}, 10, 3); // HOOK ACTION save_post



/**
 * filter only for front-end for visitors
 * 
 * @since 1.0
 */
if( !is_admin() ) {
	require_once slimTranslate::$path . '/core/translate/wp_nav_menu-filter.php';
	require_once slimTranslate::$path . '/core/translate/bloginfo.php';
	require_once slimTranslate::$path . '/core/translate/queried_object-singular.php';
	require_once slimTranslate::$path . '/core/translate/queried_object-archive.php';
	require_once slimTranslate::$path . '/core/translate/posts.php';
	require_once slimTranslate::$path . '/core/translate/post.php';
	require_once slimTranslate::$path . '/core/post-edit/filters.php';
}
<?PHP
/**
 * "../core/translate/post.php"
 * 
 * ABOUT: Filter for post variable
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
	 * getting $post variable
	 */
	global $post;

	/**
	 * if post is nothing, then it will terminated
	 */
	if( !isset($post->ID) ) {
		return false;
	}

	/**
	 * FILTERING TITLE
	 */

		/**
		 * prepare for variables.
		 */
		$title_prefix = '_st_title_';
		$meta_key_title = $title_prefix . slimTranslate::$language;

		/**
		 * get post meta for translation.
		 */
		$post_translate_title = get_post_meta( $post->ID, $meta_key_title, true );

		/**
		 * if there is translation exists, title will change to the translation.
		 * but if no, then back to the original title.
		 */
		if( $post_translate_title ) {
			$post->post_title = $post_translate_title;
		}

	/**
	 * FILTERING CONTENT
	 */
	
		/**
		 * prepare for variables.
		 */
		$prefix = '_st_content_';
		$meta_key = $prefix . slimTranslate::$language;

		/**
		 * get post meta for translation.
		 */
		$post_translate = get_post_meta( $post->ID, $meta_key, true );

		/**
		 * if there is translation exists, content will change to the translation.
		 * but if no, then back to the original content prepended with alert.
		 */
		if( $post_translate ) {
			$post->post_content = slimTranslate::remove_translation( $post_translate );
		}

	/**
	 * FILTERING EXCERPT
	 */

		/**
		 * prepare for variables.
		 */
		$prefix_excerpt = '_st_excerpt_';
		$meta_key_excerpt = $prefix_excerpt . slimTranslate::$language;

		/**
		 * get post meta for translation.
		 */
		$post_translate_excerpt = get_post_meta( $post->ID, $meta_key_excerpt, true );

		/**
		 * if there is translation exists, excerpt will change to the translation.
		 * but if no, then back to the original excerpt prepended with alert.
		 */
		if( $post_translate_excerpt ) {
			$post->post_excerpt = $post_translate_excerpt;
		}

}, 32); // HOOK wp
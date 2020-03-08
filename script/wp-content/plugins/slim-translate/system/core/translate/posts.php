<?PHP
/**
 * "../core/translate/posts.php"
 * 
 * ABOUT: Filter for posts variable
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
 * HOOK wp => filter the global $posts variable
 * 
 * @since 1.0
 * 
 * @return string
 */
add_action( 'slimTranslate/wp', function() {

	/**
	 * getting global posts variable
	 */
	global $posts;

	/**
	 * looping the posts
	 */
	$i = 0;
	foreach( $posts as $post ) {

		/**
		 * post title
		 */
		if( isset($post->post_title) ) {
			$meta = get_post_meta( $post->ID, '_st_title_' . slimTranslate::$language, true );
			if( $meta ) {
				$posts[$i]->post_title = $meta;
			}
		} // IF

		/**
		 * post content
		 */
		if( isset($post->post_content) ) {
			/**
			 * get post meta for translation.
			 */
			$meta = get_post_meta( $post->ID, '_st_content_' . slimTranslate::$language, true );

			/**
			 * if there is translation exists, content will change to the translation.
			 * but if no, then back to the original content prepended with alert.
			 */
			if( $meta ) {
				$posts[$i]->post_content = slimTranslate::remove_translation( $meta );
			}
		} // IF

		/**
		 * post excerpt
		 */
		if( isset($post->post_excerpt) ) {
			/**
			 * get post meta for translation.
			 */
			$meta = get_post_meta( $post->ID, '_st_excerpt_' . slimTranslate::$language, true );

			/**
			 * if there is translation exists, excerpt will change to the translation.
			 * but if no, then back to the original excerpt prepended with alert.
			 */
			if( $meta ) {
				$posts[$i]->post_excerpt = $meta;
			}
		} // IF

		$i++;

	} // FOREACH

}, 30); // HOOK wp
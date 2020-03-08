<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * HOOK => filtering the_title
 * 
 * @since 1.0
 * 
 * @param string  $title. Default title for the post or page
 * @param integer $post_id. post or page ID
 * @return string
 */
add_filter( 'the_title', function( $title, $post_id ) {
	
	/**
	 * prepare for variables.
	 */
	$prefix = '_st_title_';
	$meta_key = $prefix . slimTranslate::$language;

	/**
	 * get post meta for translation.
	 */
	$post_translate = get_post_meta( $post_id, $meta_key, true );

	/**
	 * if there is translation exists, title will change to the translation.
	 * but if no, then back to the original title.
	 */
	if( $post_translate ) {
		return $post_translate;
	} else {
		return $title;
	}

}, 10, 2); // HOOK the_title



/**
 * HOOK => filtering the_content
 * 
 * @since 1.0
 * 
 * @global $post
 * 
 * @param string $content. content / value default by post or page
 * @return string
 */
add_filter( 'the_content', function( $content ) {
	
	/**
	 * get global post variable.
	 * prepare for variables.
	 */
	global $post;
	$prefix = '_st_content_';
	$meta_key = $prefix . slimTranslate::$language;

	/**
	 * get post meta for translation.
	 */
	$post_translate = get_post_meta( $post->ID, $meta_key, true );

	/**
	 * if there are no translation, then alert will show up.
	 * But, alert will only show on single page.
	 */
	if( (is_page() || is_single()) && slimTranslate::$language != slimTranslate::get_wplang() ) {
		if( slimTranslate::is_wc() &&
			(
				strpos( ' ' . $content, '[woocommerce_cart]' ) > 0 ||
				strpos( ' ' . $content, '[woocommerce_my_account]' ) > 0 ||
				strpos( ' ' . $content, '[woocommerce_checkout]' ) > 0
			)
		) {
			$alert = false;
		} else {
			$alert = slimTranslate::$setting->no_translation_alert;
			$alert = slimTranslate::get_the_alert();
			$alert = slimTranslate::get_no_translation_toggle() ? '<div class="st-alert st-alert-' . slimTranslate::$language . '">' . slimTranslate::get_the_alert() . '</div>' : false;
		}
	} else {
		$alert = false;
	}

	/**
	 * if there is translation exists, content will change to the translation.
	 * but if no, then back to the original content prepended with alert.
	 */
	if( $post_translate ) {
		return slimTranslate::remove_translation( $post_translate );
	} else {
		return slimTranslate::remove_translation( $alert . $content );
	}

}, 1); // HOOK the_content
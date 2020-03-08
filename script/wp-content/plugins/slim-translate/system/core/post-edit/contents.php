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
 * get global variable of $post
 */
global $post;



/**
 * end progress if there are no need extra form
 * 
 * @since 1.0
 * @see ../core/post-edit/tabs.php" line:30
 */
if( slimTranslate::get_var( 'no_extra_form' ) ) {
	return false;
}



/**
 * preparing the form
 */
echo '<textarea class="st-content-translate-default" style="display: none !important;" id="_st_content_content" name="content">' . $post->post_content . '</textarea>';
foreach( slimTranslate::$setting->languages as $lang ) {
	if( slimTranslate::get_wplang() !== $lang ) {
		echo '<textarea class="st-content-translate-item" style="display: none !important;" type="text" id="_st_content_' . $lang . '" name="_st_content_' . $lang . '">' . wpautop(get_post_meta( $post->ID, '_st_content_' . $lang, true )) . '</textarea>';
	}
}



/**
 * preparing the form for excerpts
 * 
 * only for WooCommerce
 */
if( slimTranslate::is_wc() ) {
	echo '<textarea class="st-excerpt-translate-default" style="display: none !important;" id="_st_excerpt_excerpt" name="excerpt">' . $post->post_excerpt . '</textarea>';
	foreach( slimTranslate::$setting->languages as $lang ) {
		if( slimTranslate::get_wplang() !== $lang ) {
			echo '<textarea class="st-excerpt-translate-item" style="display: none !important;" type="text" id="_st_excerpt_' . $lang . '" name="_st_excerpt_' . $lang . '">' . wpautop(get_post_meta( $post->ID, '_st_excerpt_' . $lang, true )) . '</textarea>';
		}
	}
}
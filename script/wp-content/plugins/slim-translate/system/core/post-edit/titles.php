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
 * end progress if there are no need extra form
 * 
 * @since 1.0
 * @see ../core/post-edit/tabs.php" line:30
 */
if( slimTranslate::get_var( 'no_extra_form' ) ) {
	return false;
}



global $post;

echo '<input class="st-title-translate-default" type="hidden" id="_st_title_post_title" name="post_title" value="' . get_the_title() . '" />';
foreach( slimTranslate::$setting->languages as $lang ) {
	if( slimTranslate::get_wplang() !== $lang ) {
		echo '<input class="st-title-translate-item" type="hidden" id="_st_title_' . $lang . '" name="_st_title_' . $lang . '" value="' . get_post_meta( $post->ID, '_st_title_' . $lang, true ) . '" />';
	}
}
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
 * getting $post global variable
 * 
 * @since 1.0
 */
global $post;



/**
 * replace content
 * 
 * @since 1.2.0
 */
$post->post_content = slimTranslate::remove_translation( $post->post_content );



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( 
	$post->post_type != 'post' &&
	$post->post_type != 'page' &&
	$post->post_type != 'product'
) {
	slimTranslate::set_var( 'no_extra_form' );
	return false;
}



echo '<main class="slim-edit-tabs">';

	echo '<a href="#" data-title-target="_st_title_post_title" data-content-target="_st_content_content" data-excerpt-target="_st_excerpt_excerpt" class="slim-tab-item slim-tab-item-post active"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::get_wplang(), 'code' ) . '"></span> <span class="flag-text">' . slimTranslate::get_languages( slimTranslate::get_wplang() ) . '</span></a>';
	foreach( slimTranslate::$setting->languages as $var ) {
		if( slimTranslate::get_wplang() !== $var ) {
			echo '<a href="#" data-title-target="_st_title_' . $var . '" data-content-target="_st_content_' . $var . '" data-excerpt-target="_st_excerpt_' . $var . '" class="slim-tab-item slim-tab-item-post"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( $var, 'code' ) . '"></span> <span class="flag-text">' . slimTranslate::get_languages( $var ) . '</span></a>';
		}
	}

echo '</main>';

echo '<input type="hidden" name="_slim_translate_nonce_id" value="' . slimTranslate::$args->option_name . '" required />';
echo '<input type="hidden" name="_slim_translate_nonce_vr" value="' . slimTranslate::create_nonce( slimTranslate::$args->option_name ) . '" required />';
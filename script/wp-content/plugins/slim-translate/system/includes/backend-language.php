<?PHP
/**
 * "../includes/backend-language.php"
 * 
 * ABOUT: Setting for backend language
 * 
 * @package		Slim Translate
 * @since		1.4.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 1.4.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * putting menu on admin bar menu. it's only appear in
 * admin page, it will not appear in front-end even
 * admin login.
 * 
 * @since 1.4.0
 */
add_action( 'admin_bar_menu', function() {

	/**
	 * if it's not in admin page, then progress will
	 * be terminated
	 */
	if( !is_admin() ) {
		return false;
	}

	/**
	 * getting $wp_admin_bar variable
	 */
	global $wp_admin_bar;

	/**
	 * setting admin_bar_id ID
	 */
	slimTranslate::set_var( 'admin_bar_id', 'slimTranslate-backend-language' );

	/**
	 * get all languages that available
	 */
	$languages = slimTranslate::get_selected_languages();

	/**
	 * putting parent menu
	 */
	$wp_admin_bar->add_menu( array(
		'id' 		=> slimTranslate::get_var( 'admin_bar_id' ),
		'parent'	=> 'top-secondary',
		'title'		=> '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::get_backend_language(), 'code' ) . '"></span>' . slimTranslate::get_languages( slimTranslate::get_backend_language() ),
		'href'		=> '#',
		'meta' => array(
			'class' => 'st-backend-language-dropdown',
		)
	));

	/**
	 * putting submenus into parent menu that already
	 * set before by code above.
	 */
	foreach( $languages as $language ) {
		if( $language !== slimTranslate::get_backend_language() ) {
			$wp_admin_bar->add_menu( array(
				'parent'	=> slimTranslate::get_var( 'admin_bar_id' ),
				'title'		=> '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $language, 'code' ) . '"></span> ' . slimTranslate::get_languages( $language ),
				'id'		=> slimTranslate::get_var( 'admin_bar_id' ) . slimTranslate::get_languages( $language, 'code' ),
				'href'		=> admin_url() . '?st-back-lang=' . $language . '&st-back-cont=' . urlencode(slimTranslate::get_uri()),
			));
		}
	}

}, 2000); // action



/**
 * action to changing the language,
 * 
 * @since 1.4.0
 */
add_action( 'admin_init', function() {

	/**
	 * if it's not in admin page, then progress will
	 * be terminated
	 */
	if( !is_admin() ) {
		return false;
	}

	/**
	 * if st-back-lang doesn't exist, then progress will
	 * be terminated.
	 */
	if( !isset($_GET['st-back-lang']) ) {
		return false;
	}

	/**
	 * sanitizing st-back-lang query
	 */
	$selecting = sanitize_text_field($_GET['st-back-lang']);

	/**
	 * if language that user choosed doesn't exist inside
	 * selected language, then page will be redirect to
	 * dashboard.
	 */
	if( slimTranslate::is_language_ready($selecting) === false ) {
		wp_redirect( admin_url() );
	}

	/**
	 * set back-end language
	 * 
	 * @see function set_backend_language
	 */
	$setting = slimTranslate::set_backend_language( $selecting );

	/**
	 * if progress changing language failed, then
	 * page will redirect to dashboard.
	 */
	if( !$setting ) {
		wp_redirect( admin_url() );
	}

	/**
	 * if st-back-cont query exists, then
	 * page will be redirected to the page
	 * inside st-back-cont query.
	 */
	if( isset($_GET['st-back-cont']) ) {
		header( 'Location:' . $_GET['st-back-cont'] );
	}

}); // action
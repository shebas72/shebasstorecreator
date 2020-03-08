<?PHP
/**
 * "../includes/base.php"
 * 
 * ABOUT: Basic informations, variables, actions for the plugins
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
 * plugin's information
 * 
 * @since 1.0
 */
if( !defined('WT_ST_NAME') ) {
	define( 'WT_ST_NAME', 'Slim Translate' );
}
if( !defined('WT_ST_VERSION') ) {
	define( 'WT_ST_VERSION', '2.0.2' );
}



/**
 * Enqueue scripts and stylesheets to back-end.
 * 
 * @since 1.0
 * @param updated 2.0.0
 */
add_action( 'admin_enqueue_scripts', function() {
	wp_enqueue_style( 'flag-icon-css', slimTranslate::$path_url . '/assets/plugins/flag-icon/css/flag-icon.min.css' );
	wp_enqueue_style( 'slim-translate-backend-css', slimTranslate::$path_url . '/assets/css/style-backend.css' );
	wp_enqueue_script( 'slim-translate-backend-js', slimTranslate::$path_url . '/assets/js/script-backend.js', array('jquery'), WT_ST_VERSION, true );
	wp_localize_script( 'slim-translate-backend-js', 'slim_translate', slimTranslate::get_var( 'js_translate' ) );
}, 30);



/**
 * Enqueue scripts to "nav-menus.php"
 * 
 * @since 1.3.0
 */
global $pagenow;
if( is_admin() && $pagenow == 'nav-menus.php' ) {
	add_action( 'admin_enqueue_scripts', function() {
		wp_enqueue_script( 'slim-translate-nav-menus-js', slimTranslate::$path_url . '/assets/js/script-nav-menus.js', array('jquery'), WT_ST_VERSION, true );
		wp_localize_script( 'slim-translate-nav-menus-js', 'slim_translate', slimTranslate::get_var( 'js_translate' ) );
	});
}




/**
 * Enqueue scripts and stylesheets to front-end.
 * 
 * @since 1.0
 */
add_action( 'slimTranslate/function/after', function() {
	add_action( 'wp_enqueue_scripts', function() {
		wp_enqueue_style( 'flag-icon-css', slimTranslate::$path_url . '/assets/plugins/flag-icon/css/flag-icon.min.css' );
		wp_enqueue_style( 'slim-translate-frontend-css', slimTranslate::$path_url . '/assets/css/style-frontend.css' );
		wp_enqueue_style( 'slim-translate-custom-css', site_url() . '/?slim-translate-css=true' );
		wp_enqueue_script( 'slim-translate-frontend-js', slimTranslate::$path_url . '/assets/js/script-frontend.js', array('jquery'), WT_ST_VERSION, true );
	});
});



/**
 * DEFINE THE HOSTS
 * first funciton of these definitions are for
 * the cookies
 * 
 * @since 1.0
 */
$st_urihost = preg_replace('|https?://|i', '', site_url() . '/' );
$st_urihost = substr( $st_urihost, 0, strpos( $st_urihost, '/' ) );
define( 'WT_ST_URIHOST',	$st_urihost );
define( 'WT_ST_URIPATH',	COOKIEPATH );



/**
 * CREATE the hooks => basic of the hooks
 * Version 1.0 is the first version that have
 * actions.
 * 
 * @since 1.0
 */
add_action( 'setup_theme', function() {
	/**
	 * if WooCommerce exists and installed, then variable of
	 * wc will be set, and explain that this site is using
	 * WooCommerce.
	 */
	if( class_exists('WooCommerce') ) {
		slimTranslate::set_var( 'wc', true );
	}
	add_action( 'slimTranslate/function', function() {
		slimTranslate::set_var( 'slimTranslate/function', true );
	}, -999 );
	do_action( 'slimTranslate/function' );
});
add_action( 'after_setup_theme', function() {
	add_action( 'slimTranslate/function/after', function() {
		slimTranslate::set_var( 'slimTranslate/function/after', true );
	}, -999 );
	do_action( 'slimTranslate/function/after' );
});
add_action( 'init', function() {
	add_action( 'slimTranslate/init', function() {
		slimTranslate::set_var( 'slimTranslate/init', true );
	}, -999 );
	do_action( 'slimTranslate/init' );
});
add_action( 'wp', function() {
	add_action( 'slimTranslate/wp', function() {
		slimTranslate::set_var( 'slimTranslate/wp', true );
	}, -999 );
	do_action( 'slimTranslate/wp' );
});



/**
 * - Prepare javascript translation languages
 * - include translation widget
 * 
 * @since 1.3.0
 */
add_action( 'slimTranslate/base', function() {

	slimTranslate::set_var( 'function-translate', function() {
		slimTranslate::set_var( 'js_translate', array(
			'ajax_url'			=> admin_url( 'admin-ajax.php' ),
			'areyousure'		=> esc_html__( 'Are you sure want to discard this changes?', 'slim-translate' ),
			'translate_menu'	=> esc_html__( 'Translate custom link', 'slim-translate' ),
			'translate_login'	=> is_user_logged_in() ? true : false,
			'translate_user'	=> is_user_logged_in() ? slimTranslate::create_nonce(wp_get_current_user()->user_login) : false,
		));
	});

	if( function_exists('is_user_logged_in') ) {
		$function = slimTranslate::get_var('function-translate');
		$function();
	} else {
		add_action( 'init', function() {
			$function = slimTranslate::get_var('function-translate');
			$function();
		});
	}

	require_once( slimTranslate::$path . '/includes/widget.php' );

});



/**
 * including ajax progress
 * 
 * @since 1.3.0
 */
add_action( 'slimTranslate/function/after', function() {
	require_once( slimTranslate::$path . '/includes/ajax.php' );
}, 100 );



/**
 * setting up the backend language
 * 
 * @since 1.4.0
 */
add_action( 'setup_theme', function() {
	global $locale, $pagenow;
	if( $pagenow != 'options-general.php' ) {
		$locale = slimTranslate::get_backend_language();
	}
	load_plugin_textdomain( 'slim-translate', false, 'slim-translate/languages' );
	require_once slimTranslate::$path . '/includes/backend-language.php';
}, 0 );
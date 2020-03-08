<?PHP
/**
 * "../core/ajax/widgets-save.php"
 * 
 * ABOUT: widgets submit
 * 
 * @package		Slim Translate
 * @since		2.0.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 2.0.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * if $_POST['ver'] doesn't exist, progress will
 * terminated
 */
if( !isset($_POST['ver']) || $_POST['ver'] == '' ) {
	exit;
}

/**
 * if it's not user login, then progress will terminated
 */
if( !is_user_logged_in() ) {
	exit;
}

/**
 * getting user information, then store it
 * into $user variable
 */
$user = wp_get_current_user();

/**
 * if user_login doesn't exist in $user,
 * the progress will terminated
 */
if( !isset($user->user_login) ) {
	exit;
}

/**
 * sanitize verification code
 */
$verification = sanitize_text_field( $_POST['ver'] );

/**
 * verifying code, if it's wrong then progress
 * will be terminated
 */
if( !slimTranslate::verify_nonce( $verification, $user->user_login ) ) {
	exit;
}

/**
 * getting basic posts and basic
 * variables
 */
$translates = $_POST['st_string_translate'];

/**
 * preparing notice function
 */
$notice = function( $messages, $type = 'success' ) {

	switch( $type ) {
		
		case 'success':
		default:
			$type = 'success';
			break;

		case 'danger':
		case 'error':
			$type = 'error';
			break;

		case 'warning':
			$type = 'warning';
			break;

	}

	echo '<div class="notice notice-' . $type . '" style="display: none;">';
		echo '<p>' . $messages . '</p>';
		echo '<button type="button" class="st-notice-dismiss notice-dismiss"></button>';
	echo '</div>';

};

/**
 * if translates empty, then return that it's failed
 */
if( count($translates) == 0 ) {
	exit( $notice( esc_html__( 'Failed to save your changes.', 'slim-translate' ), 'error' ) );
}

/**
 * looping the translation
 */
foreach( $translates as $string => $array ) {
	foreach( $array as $lang => $val ) {
		if( !slimTranslate::is_empty($val) && !slimTranslate::is_empty($lang) && !slimTranslate::is_empty($string) ) {		
			slimTranslate::set_widget_translate( $string, $val, $lang  );
		}
	}
}

/**
 * returning the result
 */
exit( $notice( esc_html__( 'Succeed, your changes have been saved.', 'slim-translate' ), 'success' ) );
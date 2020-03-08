<?PHP
/**
 * "../core/ajax/nav-menus-save.php"
 * 
 * ABOUT: nav menus submit
 * 
 * @package		Slim Translate
 * @since		1.3.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



/**
 * terminate all direct access for this file
 * 
 * @since 1.3.0
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
$return = true;
$translates = $_POST['st_menu_translate'];

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
 * preparing update function
 */
$update = function( $id, $lang, $val ) {
	
	$get = get_post_meta( $id, '_st_menu_' . $lang, $val, true );

	if( $val == $get ) {
		return true;
	}

	if( $get ) {
		$return = update_post_meta( $id, '_st_menu_' . $lang, $val, $get );
	} else {
		$return = add_post_meta( $id, '_st_menu_' . $lang, $val, true );
	}

	return $return ? true : false;

};

/**
 * looping the menus
 */
if( count($translates) == 0 ) {
	exit( $notice( esc_html__( 'Failed to save your changes.', 'slim-translate' ), 'error' ) );
}

/**
 * looping the menus
 */
foreach( $translates as $id => $array ) {
	foreach( $array as $lang => $val ) {
		$trim = trim($val);
		if( !empty($trim) ) {		
			if( !$update( $id, $lang, $val ) ) {
				$return = false;
			}
		}
	}
}

/**
 * returning the result
 */
if( $return ) {
	exit( $notice( esc_html__( 'Succeed, your changes have been saved.', 'slim-translate' ), 'success' ) );
} else {
	exit( $notice( esc_html__( 'Failed to save your changes.', 'slim-translate' ), 'error' ) );
}
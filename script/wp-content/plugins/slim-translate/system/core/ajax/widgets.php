<?PHP
/**
 * "../core/ajax/widgets.php"
 * 
 * ABOUT: widgets ajax, translate all input and textarea
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
 * collecting all strings that ready to translate
 */
$strings = slimTranslate::get_widget_translations();

/**
 * if there are no custom links, then showing no content
 */
if( count($strings) == 0 ) {
	exit( '<p class="st-modal-empty">' . esc_html__( 'You have not install any widgets.', 'slim-translate' ) . '</p>' );
}

echo '<main class="slim-edit-tabs slim-edit-tabs-modal">';
	foreach( slimTranslate::get_selected_languages() as $key => $val ) {
		echo '<a href="#" title="' . esc_attr(slimTranslate::get_languages( $val )) . '" data-language="' . $val . '" class="slim-tab-item slim-tab-item-widget ' . ( $key == 0 ? 'active' : '' ) . '"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( $val, 'code' ) . '"></span></a>';
	}
echo '</main>';

echo '<div class="st-modal-notice"></div>';

echo '<form action="" method="POST" id="form-nav-widgets">';

	echo '<table class="st-fullwidth st-table-translate">';
		foreach( $strings as $key => $val ) {
			echo '<tr>';
				echo '<td>';
					echo '<textarea type="text" tabindex="-1" class="widefat" readonly>' . esc_html( $key ) . '</textarea>';
				echo '</td>';
				echo '<td>';
					foreach( slimTranslate::get_selected_languages() as $number => $lang ) {
						if( $number == '0' ) {
							echo '<textarea type="text" data-value="' . $key . '" name="st_string_translate[' . $key . '][' . $lang . ']" data-language="' . $lang . '" class="widefat st-translate-item st-translate-item-first active" readonly >' . esc_html( $key ) . '</textarea>';
						} else {
							echo '<textarea type="text" name="st_string_translate[' . $key . '][' . $lang . ']" data-language="' . $lang . '" class="widefat st-translate-item" >' . esc_html( slimTranslate::get_widget_translate( $key, $lang, true ) ) . '</textarea>';
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	echo '</table>';

	echo '<div class="st-modal-footer st-text-right">';
		echo '<a href="#" class="button st-modal-close close-button">' . esc_html__( 'Cancel', 'slim-translate' ) . '</a>';
		echo '&nbsp;<button class="button button-primary submit-button">' . esc_html__( 'Save Changes', 'slim-translate' ) . '</button>';
		echo '<input name="action" value="slimTranslate_ajax_widgets-save" type="hidden" tabindex="-1" readonly />';
		echo '<input name="ver" value="' . esc_attr( $verification ) . '" type="hidden" tabindex="-1" readonly />';
	echo '</div>';

echo '</form>';
<?PHP
/**
 * "../core/ajax/nav-menus.php"
 * 
 * ABOUT: nav menus ajax, translate all custom links
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
 * preparing and getting database
 */
global $wpdb;
$prepare = $wpdb->prepare("SELECT * FROM {$wpdb->prefix}posts WHERE post_type = 'nav_menu_item' AND NOT(post_title = '') AND post_status = 'publish' ");
$results = $wpdb->get_results($prepare);

/**
 * if there are no custom links, then showing no content
 */
if( count($results) == 0 ) {
	exit( '<p class="st-modal-empty">' . esc_html__( 'You have no custom links yet.', 'slim-translate' ) . '</p>' );
}

echo '<main class="slim-edit-tabs slim-edit-tabs-modal">';
	foreach( slimTranslate::get_selected_languages() as $key => $val ) {
		echo '<a href="#" title="' . esc_attr(slimTranslate::get_languages( $val )) . '" data-language="' . $val . '" class="slim-tab-item slim-tab-item-menu ' . ( $key == 0 ? 'active' : '' ) . '"><span class="flag-icon flag-icon-' . slimTranslate::get_languages( $val, 'code' ) . '"></span></a>';
	}
echo '</main>';

echo '<div class="st-modal-notice"></div>';

echo '<form action="" method="POST" id="form-nav-menus">';

	echo '<table class="st-fullwidth st-table-translate">';
		foreach( $results as $key ) {
			echo '<tr>';
				echo '<td>';
					echo '<input type="hidden" tabindex="-1" value="' . esc_attr( $key->ID ) . '" readonly />';
					echo '<input type="text" tabindex="-1" class="widefat" value="' . esc_attr( $key->post_title ) . '" readonly />';
				echo '</td>';
				echo '<td>';
					foreach( slimTranslate::get_selected_languages() as $var => $val ) {
						if( $var == '0' ) {
							echo '<input type="text" name="st_menu_translate[' . $key->ID . '][' . $val . ']" data-language="' . $val . '" value="' . esc_attr( $key->post_title ) . '" class="widefat st-translate-item active" readonly />';
						} else {
							echo '<input type="text" name="st_menu_translate[' . $key->ID . '][' . $val . ']" data-language="' . $val . '" value="' . esc_attr( get_post_meta( $key->ID, '_st_menu_' . $val, true ) ) . '" class="widefat st-translate-item" />';
						}
					}
				echo '</td>';
			echo '</tr>';
		}
	echo '</table>';

	echo '<div class="st-modal-footer st-text-right">';
		echo '<a href="#" class="button st-modal-close close-button">' . esc_html__( 'Cancel', 'slim-translate' ) . '</a>';
		echo '&nbsp;<button class="button button-primary submit-button">' . esc_html__( 'Save Changes', 'slim-translate' ) . '</button>';
		echo '<input name="action" value="slimTranslate_ajax_nav-menus-save" type="hidden" tabindex="-1" readonly />';
		echo '<input name="ver" value="' . esc_attr( $verification ) . '" type="hidden" tabindex="-1" readonly />';
	echo '</div>';

echo '</form>';
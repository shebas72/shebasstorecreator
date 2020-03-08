<?PHP 



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



?><form action="" method="post" class="st-setting-languages">

	<input type="hidden" name="_st_setting-action" value="languages">
	<input type="hidden" name="_st_setting-nonce" value="<?PHP echo slimTranslate::create_nonce('languages'); ?>">
	<input type="hidden" name="_st_setting-continue" value="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . $_GET['page'] . '&st_tab=' . $_GET['st_tab'] ); ?>">

	<div class="st-setting-section-languages">
		
		<?PHP
		$languages_array = json_decode( json_encode( slimTranslate::$setting->languages ), true );
		foreach( slimTranslate::get_languages() as $key => $val ) {
			$checked = false;
			foreach( $languages_array as $lang ) {
				if( $lang == $key ) {
					$checked = ' checked="checked"';
				}
			}
			if( $key == slimTranslate::$setting->default_language ) {
				$default = true;
			} else {
				$default = false;
			}
			echo '<div class="st-detect-click">';
				echo '<input id="st-language-' . $key . '" type="checkbox" name="st_languages[]" value="' . $key . '"' . $checked . ' />';
				echo '<label for="st-language-' . (!$default ? $key : '') . '" class="' . ($default ? 'st-languages-setting-default' : false) . '" ' . ($default ? 'title="' . esc_attr__( 'Default Language', 'slim-translate' ) . '"' : false) . '>';
					echo '<div>';
						echo '<div>';
							echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $key, 'code' ) . '"></span>';
							echo '<span class="desc">' . slimTranslate::get_languages( $key, 'name' ) . '</span>';
						echo '</div>';
					echo '</div>';
				echo '</label>';
			echo '</div>';
		} ?>

	</div>

	<p class="submit" style="clear: both;">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?PHP esc_attr_e( 'Save Changes', 'slim-translate' ); ?>">
	</p>

</form>
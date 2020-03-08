<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}


	
$_default_language = empty(slimTranslate::$setting->default_language) ? 'en_US': slimTranslate::$setting->default_language;
$_auto_language = slimTranslate::$setting->auto_language ? ' checked="checked"': '';
$_no_translation_toggle = (isset(slimTranslate::$setting->no_translation_toggle) && slimTranslate::$setting->no_translation_toggle) ? ' checked="checked"': '';
$_no_translation_alert = isset(slimTranslate::$setting->no_translation_alert) ? slimTranslate::$setting->no_translation_alert: '';
$_corner_widget_toggle = slimTranslate::$setting->corner_widget->active ? ' checked="checked"': '';
$_corner_widget_valign = slimTranslate::$setting->corner_widget->vertical_align;
$_corner_widget_halign = slimTranslate::$setting->corner_widget->horizontal_align;



?><form action="" method="post" class="st-setting-general">

	<input type="hidden" name="_st_setting-action" value="general">
	<input type="hidden" name="_st_setting-nonce" value="<?PHP echo slimTranslate::create_nonce('general'); ?>">
	<input type="hidden" name="_st_setting-continue" value="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . $_GET['page'] ); ?>">

	<div class="st-setting-section" data-title="<?PHP esc_attr_e( 'Translation', 'slim-translate' ); ?>">
		<table class="form-table">

			<tr>
				<th width="40%" scope="row"><label for="st-default-language"><?PHP esc_html_e( 'Default Language', 'slim-translate' ); ?></label></th>
				<td>
					<p><select name="default_language" id="st-default-language" class="st-detect-change">
						<?PHP foreach( slimTranslate::get_languages() as $key => $val ) {
							echo '<option value="' . $key . '"' . ( $key == $_default_language ? ' selected' : '') . '>' . $val[1] . '</option>';
						} ?>
					</select></p>
					<p class="description"><?PHP esc_html_e( 'Choose default front-end language, what language that you want to be actived for front-end language.', 'slim-translate' ); ?></p>
				</td>
			</tr>

			<tr>
				<th width="40%" scope="row"><label for="st-auto-language"><?PHP esc_html_e( 'Auto Translate', 'slim-translate' ); ?></label></th>
				<td>
					<p><label>
						<input name="auto_language" type="checkbox" <?PHP echo $_auto_language; ?> class="st-detect-change" id="st-auto-language" value="1"> <?PHP esc_html_e( 'Let site suits to visitor\'s language', 'slim-translate' ); ?>
					</label></p>
					<p class="description"><?PHP _e( 'Auto translate allows this site to translate the page to user\'s native language. <br/> Example: if visitor in Indonesia, then page will be translated to Bahasa Indonesia.', 'slim-translate' ); ?> </p>
				</td>
			</tr>

			<tr>
				<th width="40%" scope="row"><label for="st-auto-language"><?PHP esc_html_e( 'No Translation Alert', 'slim-translate' ); ?></label></th>
				<td>
					<p><label>
						<input name="no_translation_toggle" type="checkbox" <?PHP echo $_no_translation_toggle; ?> class="st-detect-change" id="st-auto-language" value="1"> <?PHP esc_html_e( 'Enable No Translation Alert', 'slim-translate' ); ?>
					</label></p>
					<p class="description"><?PHP _e( 'By enabling this, your site will show up alert when a single post or page doesn\'t available in the language that user choosed.', 'slim-translate' ); ?> </p>
				</td>
			</tr>

		</table>
	</div>

	<div class="st-setting-section" data-title="<?PHP esc_attr_e( 'Corner Widget', 'slim-translate' ); ?>">
		<table class="form-table">

			<tr>
				<th width="40%" scope="row"><label for="st-corner-toggle"><?PHP esc_html_e( 'Toggle', 'slim-translate' ); ?></label></th>
				<td>
					<p><label>
						<input name="corner_widget[active]" <?PHP echo $_corner_widget_toggle; ?> class="st-detect-change" type="checkbox" id="st-corner-toggle" value="1"> <?PHP esc_html_e( 'Active Corner Widget - w+p+l+o+c+k+e+r+.+c+o+m', 'slim-translate' ); ?>
					</label></p>
					<p class="description">
						<?PHP _e( 'Enable this to appear corner widget in front-page.<br/>
						Corner Widget is widget that fixed at page\'s corner to change page language.', 'slim-translate' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th width="40%" scope="row"><label for="st-corner-toggle"><?PHP esc_html_e( 'Vertical Alignment', 'slim-translate' ); ?></label></th>
				<td>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_valign == 'st-v-top' ? 'checked="checked"': ''; ?> name="corner_widget[vertical_align]" value="st-v-top"> <?PHP esc_html_e( 'top', 'slim-translate' ); ?></label></p>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_valign == 'st-v-center' ? 'checked="checked"': ''; ?> name="corner_widget[vertical_align]" value="st-v-center"> <?PHP esc_html_e( 'center', 'slim-translate' ); ?></label></p>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_valign == 'st-v-bottom' ? 'checked="checked"': ''; ?> name="corner_widget[vertical_align]" value="st-v-bottom"> <?PHP esc_html_e( 'bottom', 'slim-translate' ); ?></label></p>
					<p class="description"><?PHP esc_html_e( 'You need to enabling "Corner Widget" to see the effect', 'slim-translate' ); ?></p>
				</td>
			</tr>

			<tr>
				<th width="40%" scope="row"><label for="st-corner-toggle"><?PHP esc_html_e( 'Horizontal Alignment', 'slim-translate' ); ?></label></th>
				<td>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_halign == 'st-h-left' ? 'checked="checked"' : ''; ?> name="corner_widget[horizontal_align]" value="st-h-left"> <?PHP esc_html_e( 'left', 'slim-translate' ); ?></label></p>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_halign == 'st-h-center' ? 'checked="checked"' : ''; ?> name="corner_widget[horizontal_align]" value="st-h-center"> <?PHP esc_html_e( 'center', 'slim-translate' ); ?></label></p>
					<p><label><input type="radio" class="st-detect-change" <?PHP echo $_corner_widget_halign == 'st-h-right' ? 'checked="checked"' : ''; ?> name="corner_widget[horizontal_align]" value="st-h-right"> <?PHP esc_html_e( 'right', 'slim-translate' ); ?></label></p>
					<p class="description"><?PHP esc_html_e( 'You need to enabling "Corner Widget" to see the effect', 'slim-translate' ); ?></p>
				</td>
			</tr>

		</table>
	</div>

	<div class="st-setting-section" data-title="<?PHP esc_attr_e( 'No Translation Alert', 'slim-translate' ); ?>">
		<table class="form-table">
		<?PHP
		$wp_lang = slimTranslate::get_wplang();
		if( !isset(slimTranslate::$setting->no_translations) ) {
			if( isset(slimTranslate::$setting->no_translation_alert) ) {
				$no_translations_default = slimTranslate::$setting->no_translation_alert;
			} else {
				$no_translations_default = '';
			}
		} else if( isset(slimTranslate::$setting->no_translations->$wp_lang) ) {
			$no_translations_default = slimTranslate::$setting->no_translations->$wp_lang;
		} else if( isset(slimTranslate::$setting->no_translation_alert) ) {
			$no_translations_default = slimTranslate::$setting->no_translation_alert;
		} else {
			$no_translations_default = '';
		}
		echo '<tr>';
			echo '<th width="40%" scope="row"><label for="st-alert-translation-' . slimTranslate::get_wplang() . '">' . slimTranslate::get_languages( slimTranslate::get_wplang() ) . '</label></th>';
			echo '<td>';
				echo '<p>';
					echo '<label><textarea name="no_translations[' . slimTranslate::get_wplang() . ']" class="st-detect-keyup" type="text" cols="50" rows="3" id="st-alert-translation-' . slimTranslate::get_wplang() . '" placeholder="' . esc_attr__( 'It\'s not available yet in this language.', 'slim-translate' ) . '">' . $no_translations_default . '</textarea>';
					echo '<span class="st-alert-flag flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::get_wplang(), 'code' ) . '"></span></label>';
				echo '</p>';
				echo '<p class="description">';
					esc_html_e( 'Default WordPress language.', 'slim-translate' );
				echo '</p>';
			echo '</td>';
		echo '</tr>';

		foreach( slimTranslate::$setting->languages as $var ) {
			if( slimTranslate::get_wplang() !== $var ) {
				if( !isset(slimTranslate::$setting->no_translations) ) {
					$no_translations_value = '';
				} else if( isset(slimTranslate::$setting->no_translations->$var) ) {
					$no_translations_value = slimTranslate::$setting->no_translations->$var;
				} else {
					$no_translations_value = '';
				}
				echo '<tr>';
					echo '<th width="40%" scope="row"><label for="st-alert-translation-' . $var . '">' . slimTranslate::get_languages( $var ) . '</label></th>';
					echo '<td>';
						echo '<p>';
							echo '<label><textarea name="no_translations[' . $var . ']" class="st-detect-keyup" type="text" cols="50" rows="3" id="st-alert-translation-' . $var . '">' . $no_translations_value . '</textarea>';
							echo '<span class="st-alert-flag flag-icon flag-icon-' . slimTranslate::get_languages( $var, 'code' ) . '"></span></label>';
						echo '</p>';
					echo '</td>';
				echo '</tr>';
			}
		}

		?>
		</table>
	</div>

	<div class="st-setting-section" data-title="<?PHP esc_attr_e( 'Blog Description', 'slim-translate' ); ?>">
		<table class="form-table">
		<?PHP
			
		echo '<tr>';
			echo '<th width="40%" scope="row"><label for="st-blogdescriptions-default">' . slimTranslate::get_languages( slimTranslate::get_wplang() ) . '</label></th>';
			echo '<td>';
				echo '<p><label>';
					echo '<input readonly="readonly" class="st-detect-change regular-text" type="text" id="st-blogdescriptions-default" value="' . get_bloginfo('description') . '" />';
					echo '<span class="st-blogdescription-flag flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::get_wplang(), 'code' ) . '"></span>';
				echo '</label></p>';
				echo '<p class="description">' . esc_html__( 'Default Blog Description only can changed from wordpress setting.', 'slim-translate' ) . '</p>';
			echo '</td>';
		echo '</tr>';

		foreach( slimTranslate::$setting->languages as $var ) {
			if( slimTranslate::get_wplang() !== $var ) {
				if( !isset(slimTranslate::$setting->blogdescriptions) ) {
					$blogdescriptions_value = '';
				} else if( isset(slimTranslate::$setting->blogdescriptions->$var) ) {
					$blogdescriptions_value = slimTranslate::$setting->blogdescriptions->$var;
				} else {
					$blogdescriptions_value = '';
				}
				echo '<tr>';
					echo '<th width="40%" scope="row"><label for="st-blogdescriptions-' . $var . '">' . slimTranslate::get_languages( $var ) . '</label></th>';
					echo '<td>';
						echo '<p><label>';
							echo '<input name="blogdescription[' . $var . ']" id="st-blogdescriptions-' . $var . '" class="st-detect-change regular-text" type="text" value="' . $blogdescriptions_value . '" />';
							echo '<span class="st-blogdescription-flag flag-icon flag-icon-' . slimTranslate::get_languages( $var, 'code' ) . '"></span>';
						echo '</label></p>';
					echo '</td>';
				echo '</tr>';
			}
		}

		?>
		</table>
	</div>

	<p class="submit">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?PHP esc_attr_e( 'Save Changes', 'slim-translate' ); ?>">
	</p>

</form>
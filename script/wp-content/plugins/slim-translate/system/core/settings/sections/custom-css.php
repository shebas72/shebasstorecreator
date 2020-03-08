<?PHP 



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



?><form action="" method="post" class="st-setting-custom-css">

	<input type="hidden" name="_st_setting-action" value="custom-css">
	<input type="hidden" name="_st_setting-nonce" value="<?PHP echo slimTranslate::create_nonce('custom-css'); ?>">
	<input type="hidden" name="_st_setting-continue" value="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . $_GET['page'] . '&st_tab=' . $_GET['st_tab'] ); ?>">

	<div class="st-setting-section-languages">
		
		<textarea name="custom_css"><?PHP echo slimTranslate::$setting->custom_css; ?></textarea>
		<pre id="st-ace-editor"></pre>

	</div>

	<p class="submit" style="clear: both;">
		<input type="submit" name="submit" id="submit" class="button button-primary" value="<?PHP esc_attr_e( 'Save Changes', 'slim-translate' ); ?>">
	</p>

</form>
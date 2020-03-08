<?PHP
/**
 * "../core/settings/warpper.php"
 * 
 * ABOUT: setting's basic page to includes the others
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



?><div class="wrap st-setting">
	
	<h1><?PHP echo slimTranslate::$args->name; ?> <small><?PHP echo slimTranslate::$args->version; ?></small></h1>

	<?PHP slimTranslate::setting_notice(); ?>

	<div class="wp-filter st-tabs">
		<ul class="filter-links">
			<li>
				<a href="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . slimTranslate::$args->setting->slug ); ?>" class="<?PHP echo (!isset($_GET['st_tab']) || empty($_GET['st_tab'])) ? 'current': ''; ?>"><?PHP esc_html_e( 'General', 'slim-translate' ); ?></a>
			</li>
			<li>
				<a href="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . slimTranslate::$args->setting->slug . '&st_tab=languages' ); ?>" class="<?PHP echo (isset($_GET['st_tab']) && $_GET['st_tab'] == 'languages') ? 'current': ''; ?>"><?PHP esc_html_e( 'Languages', 'slim-translate' ); ?></a>
			</li>
			<li>
				<a href="<?PHP echo admin_url( slimTranslate::$pagenow . '?page=' . slimTranslate::$args->setting->slug . '&st_tab=custom-css' ); ?>" class="<?PHP echo (isset($_GET['st_tab']) && $_GET['st_tab'] == 'custom-css') ? 'current': ''; ?>"><?PHP esc_html_e( 'Custom CSS', 'slim-translate' ); ?></a>
			</li>
		</ul>
	</div>

	<?PHP
	if( !isset($_GET['st_tab']) || empty($_GET['st_tab']) ) {
		require_once slimTranslate::$path . '/core/settings/sections/general.php';
	}
	else if( isset($_GET['st_tab']) && $_GET['st_tab'] == 'languages' ) {
		require_once slimTranslate::$path . '/core/settings/sections/languages.php';
	}
	else if( isset($_GET['st_tab']) && $_GET['st_tab'] == 'custom-css' ) {
		require_once slimTranslate::$path . '/core/settings/sections/custom-css.php';
	}
	?>

</div>
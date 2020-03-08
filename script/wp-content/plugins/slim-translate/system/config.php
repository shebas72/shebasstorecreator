<?PHP
/**
 * "../config.php"
 * 
 * ABOUT: this file is a default configuration,
 * and default class.
 * 
 * IF YOU WANT TO MODIFE THE SETTING, YOU CAN DO
 * THAT ON EXECUTE FUNCTION AS THE PARAMETER.
 * 
 * @package		Slim Translate
 * @version		1.0
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
 * check is "slimTranslate" class already registered before
 * 
 * @since 1.0
 */
if( !class_exists('slimTranslate') ) {



	/**
	 * get filename of the path, it's getting filename and
	 * the extension from the path
	 * 
	 * @access public
	 * @param string $file the path of file
	 * @return string
	 * @since 1.0
	 */
	if( !function_exists('slimTranslate_file') ) {
	 	function slimTranslate_file( $file ) {
			$file = str_replace( '\\', '/', $file );
			$server = $file;
			$array = explode( '/', $server );
			$file = $array[count($array)-1];
			return $file;
		}
	}



	/**
	 * get directory name of the path.
	 * 
	 * @access public
	 * @param string $file the path of file
	 * @return string
	 * @since 1.0
	 */
	if( !function_exists('slimTranslate_dir') ) {
	 	function slimTranslate_dir( $file ) {
			$file = str_replace( '\\', '/', $file );
			$server = $file;
			$array = explode( '/', $server );
			foreach( $array as $var => $val ) {
				if( $var <= (count($array)-2) ) {
					$data = (isset($data) ? $data : '') . $array[$var] . '/';
				}
			}
			$data = substr( $data, 0, strlen($data)-1 );
			return $data;
		}
	}



	/**
	 * BASE FILE AND CLASSES
	 * 
	 * @since 1.0
	 */
	require_once slimTranslate_dir(__FILE__) . '/includes/base.php';
	require_once slimTranslate_dir(__FILE__) . '/class/class-widget.php';
	require_once slimTranslate_dir(__FILE__) . '/class/class.php';
	require_once slimTranslate_dir(__FILE__) . '/class/class-settings.php';
	require_once slimTranslate_dir(__FILE__) . '/class/class-post.php';
	require_once slimTranslate_dir(__FILE__) . '/class/class-term.php';



	/**
	 * BASE CLASS CONFIGURATION
	 * 
	 * all basic configurations is here
	 * 
	 * @since 1.0
	 */
	class slimTranslate extends st_config_term {



		/**
		 * BASE VARIABLE
		 * 
		 * global variable of slim translate, all data will stored
		 * and retrieved from thisvariable.
		 * 
		 * @since 1.0
		 */
		public static $global = array();
		public static $setting;
		public static $args = array();
		public static $system;
		public static $language;
		public static $path;
		public static $path_url;
		public static $pagenow;



		/**
		 * option name that will be the key of
		 * translation string in option
		 * 
		 * @since 2.0.0
		 */
		public static $option_translate = '_st_string_translation';



		/**
		 * INITIALIZING
		 * 
		 * installing the plugins. When page load, this will called
		 * 
		 * @access private
		 * @since 1.0
		 */
		public static function args_default() {
			// if users didn't set the arguments, then
			// this default arguments will used instead
			self::$args = array(
				// variable or key for wp_options database / setting
				'option_name'		=> '_slim_translate_options',
				// plugin name
				'name'				=> WT_ST_NAME,
				// plugin version
				'version'			=> WT_ST_VERSION,
				// plugin mode or theme mode
				/**
				 * @since 2.0.1
				 */
				'mode'				=> 'theme',
				// header title
				'column_head'		=> esc_html__( 'Slim Translation', 'slim-translate' ),
				// data post meta
				'meta_prefix'		=> '_slim_translate_',
				// post type
				'post_type'			=> 'slim_translate',
				// auto language detect by country
				'auto_language'		=> true,
				// auto language detect by country
				'no_translation_alert'		=> esc_html__( 'It\'s not available yet for this language', 'slim-translate' ),
				// no translation alert toggle
				'no_translation_toggle' => true,
				// default translate language
				'languages'			=> array(),
				// default custom css value
				'custom_css'		=> '/* ' . esc_html__( 'Write your custom CSS below', 'slim-translate' ) . ' */',
				// corner widget setting
				'corner_widget'		=> array(
					// active or not
					'active'			=> true,
					// vertical alignment of corner_widget
					// top || center || bottom
					'vertical_align'	=> 'top',
					// horizontal alignment of corner_widget
					// left || center || right
					'horizontal_align'	=> 'right',
				),
				// setting page
				'setting'			=> array(
					// show setting page or not
					'active'		=> true,
					// menu location
					// menu || submenu
					'position'		=> 'menu',
					// setting page title(on tab)
					'page_title'	=> esc_html__( 'Slim Translate Settings', 'slim-translate' ),
					// setting page menu label
					'menu_label'	=> esc_html__( 'Slim Translate', 'slim-translate' ),
					// setting page slug
					'slug'			=> 'slim-setting',
					// setting page icon on menu
					'icon'			=> slimTranslate::$path_url . '/assets/img/logo.svg" class="st-flag-icon',
				),
			);
		}



		/**
		 * INITIALIZING
		 * 
		 * installing the plugins. When page load, this will called
		 * 
		 * @global $pagenow
		 * 
		 * @access private
		 * @since 1.0
		 */
		public static function init() {
			// default page now
			global $pagenow;
			self::$pagenow = $pagenow;
			// default language
			self::$language = slimTranslate::filter_us(get_option( 'WPLANG' ));
			// system directory name
			self::$system = slimTranslate_file(slimTranslate_dir(__FILE__));
			// system path url
			$wp_content = '/wp-content/';
			$dir_name = slimTranslate_dir(__FILE__);
			$dir_name = str_replace( '\\', '/', $dir_name );
			$dir_name = substr( $dir_name, strpos( $dir_name, $wp_content ) );
			self::$path_url = site_url() . $dir_name;
			// plugin path
			self::$path = str_replace( '\\', '/', slimTranslate_dir(__FILE__) );
			// set default arguments
			self::args_default();
			// widget => admin widget's page button
			add_filter( 'widgets_admin_page', 'slimTranslate::widgets_admin_page', 999 );
			// widget => showing for each form
			add_filter( 'widget_form_callback', 'slimTranslate::widget_form_callback', 10, 2 );
			// widget => updating widget
			add_filter( 'widget_update_callback', 'slimTranslate::widget_update_callback', 10, 4 );
			// widget => front-end filtering
			add_filter( 'widget_display_callback', 'slimTranslate::widget_display_callback', 10, 3 );
		} // FUNCTION


		/**
		 * EXECUTE => first action to executing the slim Translate
		 * 
		 * @since 1.0
		 */
		public static function execute( $args = false ) {
			// slim translate only can execute at once time
			// if more than once, it will terminated
			if( self::get_var('execute') ) {
				return false;
			}
			self::set_var( 'execute', true );
			// if value empty, then process will terminated
			if( $args === false ) {
				$args = self::$args;
			} else {
				self::$args = array_merge( self::$args, $args );
			}
			self::$args = self::array_to_object( self::$args );
			// adding setting to option
			self::install_setting();
			// get theme options
			self::$setting = json_decode( get_option(self::$args->option_name) );
			self::$language = self::$setting->default_language;
			$default_lang = true;
			foreach( self::$setting->languages as $val ) {
				if( $val == self::$language ) {
					$default_lang = false;
				}
			}
			if( $default_lang ) {
				array_unshift( self::$setting->languages, self::$language );
			}
			/**
			 * execution in the middle of execute function
			 *
			 * @since 2.0.1
			 */
			do_action( 'slimTranslate/execute' );
			// custom css
			slimTranslate::get_custom_css();
			/**
			 * executing
			 */
			// add custom hidden form under title
			// in slim_translate post editor
			self::hidden_form();
			// execute setting page
			self::execute_setting();
			// execute post list column
			self::column_post_list();
			// select user's language
			self::select_lang();
			// editor form
			self::execute_post_edit();
		}


		/**
		 * ARRAY TO OBJECT => convert an array to object
		 * 
		 * @since 1.0
		 */
		public static function array_to_object( $key ) {
			$encode = json_encode( $key );
			$decode = json_decode( $encode, false );
			return $decode;
		}


		/**
		 * SET VARIABLE => store variable's value without using
		 * prefix or something like that.
		 * 
		 * @since 1.0
		 */
		public static function set_var( $key, $value = false ) {
			// if value empty, then process will terminated
			if( $value === false ) {
				return false;
			}
			self::$global[$key] = $value;
		}



		/**
		 * GET VARIABLE => retrieve data after stored in set var
		 * 
		 * @since 1.0
		 */
		public static function get_var( $key = false ) {
			$data = self::$global;
			$key = trim($key);
			// without key
			if( $key === false || empty($key) ) {
				return $data;
			}
			// with key
			else if( isset($data[$key]) ) {
				return $data[$key];
			}
			// process terminated
			else {
				return false;
			}
		}


		/**
		 * REMOVE VARIABLE => remove variable that already exists
		 * 
		 * @since 1.0
		 */
		public static function remove_var( $key ) {
			unset( self::$global[$key] );
		}



		/**
		 * GET SETTING => get settings
		 * 
		 * @since 1.0
		 */
		public static function get_setting( $key = false ) {
			$setting = json_decode( self::$setting, false );
			// without key
			$key = trim($key);
			if( $key === false || empty($key) ) {
				return $setting;
			}
			// with key
			else if( isset($setting->$key) ) {
				return $setting->$key;
			}
			// process terminated
			else {
				return false;
			}
		}

	} // CLASS slimTranslate

	// first action,
	slimTranslate::init();

	/**
	 * action only for base.php
	 * 
	 * @since 1.2.0
	 */
	do_action( 'slimTranslate/base' );

} // if class doesn't exists
<?PHP



/**
 * terminate all direct access for this file
 * 
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



class st_config_term extends st_config_post {



	/**
	 * Header title for column
	 * 
	 * @since 1.0
	 */
	public static function col_term_head( $columns ) {
		wp_enqueue_style( 'slim-translate-css', slimTranslate::$path_url . '/assets/css/style.css' );
		$columns['st-translations-col'] = slimTranslate::$args->column_head;
		return $columns;
	}



	/**
	 * Value for translation column
	 * 
	 * @since 1.0
	 */
	public static function col_term_body( $value, $column_name, $tax_id ) {
		if ($column_name == 'st-translations-col') {
			$no_translate = ' class="no-translate" ';
			echo '<div class="slim-post-list">';
				foreach( slimTranslate::$setting->languages as $key ) {
					// get key from system
					$meta_key = '_st_term_title_' . $key;
					// meta value
					$meta_val = get_term_meta( $tax_id, $meta_key, true );
					echo '<a ' . ( ( !$meta_val && slimTranslate::get_wplang() !== $key ) ? $no_translate : false ) . 'data-title="' . slimTranslate::get_languages($key) . '">';
						echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $key, 'code' ) . '"></span>';
					echo '</a>';
				}
			echo '</div>';
		}
	}



	/**
	 * set term list
	 * 
	 * @since 1.0
	 */
	public static function column_term_list() {
		add_filter( "manage_edit-category_columns", array( 'st_config_term', 'col_term_head' ) );
		add_action( "manage_category_custom_column", array( 'st_config_term', 'col_term_body' ), 10, 3);
		add_filter( "manage_edit-post_tag_columns", array( 'st_config_term', 'col_term_head' ) );
		add_action( "manage_post_tag_custom_column", array( 'st_config_term', 'col_term_body' ), 10, 3);
		add_action( 'slimTranslate/function/after', function() {
			if( slimTranslate::is_wc() ) {
				add_filter( "manage_edit-product_cat_columns", array( 'st_config_term', 'col_term_head' ) );
				add_action( "manage_product_cat_custom_column", array( 'st_config_term', 'col_term_body' ), 10, 3);
				add_filter( "manage_edit-product_tag_columns", array( 'st_config_term', 'col_term_head' ) );
				add_action( "manage_product_tag_custom_column", array( 'st_config_term', 'col_term_body' ), 10, 3);
				$objects = wc_get_attribute_taxonomies();
				foreach( $objects as $object ) {
					add_filter( "manage_edit-pa_" . $object->attribute_name . "_columns", array( 'st_config_term', 'col_term_head' ) );
					add_action( "manage_pa_" . $object->attribute_name . "_custom_column", array( 'st_config_term', 'col_term_body' ), 10, 3);
				}
			}
		});
	} // FUNCTION



	/**
	 * SAVE TERM process
	 * 
	 * @since 1.0
	 */
	public static function save_term( $term_id ) {
		if( isset($_POST['_slim_translate_term_nonce_id']) && isset($_POST['_slim_translate_term_nonce_vr']) ) {
			
			// verifying data
			if( !slimTranslate::verify_nonce( $_POST['_slim_translate_term_nonce_vr'], $_POST['_slim_translate_term_nonce_id'] ) ) {
				return false;
			}
			
			// TITLES
			$prefix_title = '_st_term_title_';
			foreach( slimTranslate::$setting->languages as $lang ) {
				if( slimTranslate::get_wplang() !== $lang && isset($_POST[$prefix_title . $lang]) && !empty($_POST[$prefix_title . $lang]) ) {
					add_term_meta( $term_id, $prefix_title . $lang, sanitize_text_field($_POST[$prefix_title . $lang]), true );
					update_term_meta( $term_id, $prefix_title . $lang, sanitize_text_field($_POST[$prefix_title . $lang]) );
				}
			}

			// CONTENTS
			$prefix_content = '_st_term_content_';
			foreach( slimTranslate::$setting->languages as $lang ) {
				if( slimTranslate::get_wplang() !== $lang && isset($_POST[$prefix_content . $lang]) && !empty($_POST[$prefix_content . $lang]) ) {
					add_term_meta( $term_id, $prefix_content . $lang, $_POST[$prefix_content . $lang], true );
					update_term_meta( $term_id, $prefix_content . $lang, $_POST[$prefix_content . $lang] );
				}
			}

		}
	}



	/**
	 * TABS and NAMES
	 * 
	 * @since 1.0
	 * @access private
	 */
	public static function extra_form( $term ) {
		$term_id			= $term->term_id;
		$term_name			= $term->name;
		$term_description	= $term->description;
		require_once slimTranslate::$path . '/core/term-edit/tabs.php';
		require_once slimTranslate::$path . '/core/term-edit/names.php';
		require_once slimTranslate::$path . '/core/term-edit/descriptions.php';
	}



	/**
	 * set term list
	 * 
	 * @since 1.0
	 * @access private
	 */
	public static function execute_term_edit() {
		require_once slimTranslate::$path . '/includes/term-edit.php';
	} // FUNCTION

}
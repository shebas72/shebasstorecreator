<?PHP
/**
 * "../core/term-edit/filters.php"
 * 
 * ABOUT: filter for terms in front end
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



/**
 * filter global categories
 * 
 * @since 1.0
 */
add_filter( 'get_the_categories', function( $categories ) {

	/**
	 * check for looping if categories 
	 * exist and a specific post
	 */
	if( count($categories) > 0 ) {
		foreach( $categories as $key => $category ) {
			foreach( $category as $index => $val ) {

				/**
				 * switching the category's points
				 */
				switch($index) {

					/**
					 * replacing the name
					 */
					case 'name':
						$name = get_term_meta( $category->term_id, '_st_term_title_' . slimTranslate::$language, true );
						$categories[$key]->name = $name ? $name : $val;
						break;
					
					/**
					 * replacing category name, almost same with name,
					 * just different on the name.
					 * It has prefix "cat_"
					 */
					case 'cat_name':
						$cat_name = get_term_meta( $category->term_id, '_st_term_title_' . slimTranslate::$language, true );
						$categories[$key]->cat_name = $cat_name ? $cat_name : $val;
						break;
					
					/**
					 * replacing term's description
					 */
					case 'description':
						$description = get_term_meta( $category->term_id, '_st_term_content_' . slimTranslate::$language, true );
						$categories[$key]->description = $description ? $description : $val;
						break;
					
					/**
					 * replacing term's description, almost like the
					 * description. just different on the name.
					 * It has prefix "cat_"
					 */
					case 'category_description':
						$category_description = get_term_meta( $category->term_id, '_st_term_content_' . slimTranslate::$language, true );
						$categories[$key]->category_description = $category_description ? $category_description : $val;
						break;

				} // SWITCH

			} // FOREACH
		} // FOREACH
	} // IF

	return $categories;

}); // FILTER get_the_categories



/**
 * single_cat_title
 */
add_filter( 'single_cat_title', function( $name ) {
	$term = get_term_by( 'name', $name, 'category' );
	if( !isset($term->term_id) ) {
		return $name;
	}
	$name_new = get_term_meta( $term->term_id, '_st_term_title_' . slimTranslate::$language, true );
	return $name_new ? $name_new : $name;
});



/**
 * single_tag_title
 */
add_filter( 'single_tag_title', function( $name ) {
	$term = get_term_by( 'name', $name, 'post_tag' );
	if( !isset($term->term_id) ) {
		return $name;
	}
	$name_new = get_term_meta( $term->term_id, '_st_term_title_' . slimTranslate::$language, true );
	return $name_new ? $name_new : $name;
});



/**
 * single_tag_title
 */
add_filter( 'get_the_archive_description', function( $description ) {
	$term = get_term_by( 'description', $description, 'post_tag' );
	if( !isset($term->term_id) ) {
		return $description;
	}
	$name_new = get_term_meta( $term->term_id, '_st_term_title_' . slimTranslate::$language, true );
	return $name_new ? $name_new : $name;
});



/**
 * filtering terms from "get_the_terms" function
 * 
 * @since 1.0
 */
add_filter( 'get_the_terms', function( $terms, $post_id, $taxomony ) {
	/**
	 * Looping to edit each term details
	 */
	if( count($terms) > 0 ) {
		$i = 0;
		foreach( $terms as $term ) {
			
			/**
			 * filtering taxomony name
			 */
			if( isset($term->name) ) {
				$name = get_term_meta( $term->term_id, '_st_term_title_' . slimTranslate::$language, true );
				$terms[$i]->name = $name ? $name : $terms[$i]->name;
			}
			
			/**
			 * filtering taxomony description
			 */
			if( isset($term->description) ) {
				$description = get_term_meta( $term->term_id, '_st_term_content_' . slimTranslate::$language, true );
				$terms[$i]->description = $description ? $description : $terms[$i]->description;
			}

			// add number for every loop
			$i++;

		} // FOREACH
	}

	/**
	 * returning the point
	 */
	// print_r( $terms );
	return $terms;

}, 10, 3); // FILTER



/**
 * WooCommerce Compatibility => WooCommerce get product terms filtering
 * 
 * @since 1.0
 * @see HOOK get_the_terms "../core/term-edit/filters.php"
 */
add_filter( 'woocommerce_get_product_terms', function( $terms, $product_id, $taxomony, $args ) {
	/**
	 * Looping to edit each term details
	 */
	if( count($terms) > 0 ) {
		$i = 0;
		foreach( $terms as $term ) {
			
			/**
			 * filtering taxomony name
			 */
			if( isset($term->name) ) {
				$name = get_term_meta( $term->term_id, '_st_term_title_' . slimTranslate::$language, true );
				$terms[$i]->name = $name ? $name : $terms[$i]->name;
			}
			
			/**
			 * filtering taxomony description
			 */
			if( isset($term->description) ) {
				$description = get_term_meta( $term->term_id, '_st_term_content_' . slimTranslate::$language, true );
				$terms[$i]->description = $description ? $description : $terms[$i]->description;
			}

			// add number for every loop
			$i++;

		} // FOREACH
	}

	/**
	 * returning the point
	 */
	return $terms;

}, 10, 4 ); // FILTER



/**
 * Get Term hooks
 * 
 * @since 1.0
 * @see HOOK get_term "../core/term-edit/filters.php"
 */
add_filter( 'get_term', function( $terms, $taxomony ) {

	/**
	 * title translate
	 */
	if( isset($terms->name) ) {
		$name_new = get_term_meta( $terms->term_id, '_st_term_title_' . slimTranslate::$language, true );
		$terms->name = $name_new ? $name_new : $terms->name;
	}

	/**
	 * description translate
	*/
	if( isset($terms->description) ) {
		$desc_new = get_term_meta( $terms->term_id, '_st_term_content_' . slimTranslate::$language, true );
		$terms->description = $desc_new ? $desc_new : $terms->description;
	}
	/**
	 * returning the term
	 */
	return $terms;

}, 10, 2 ); // FILTER
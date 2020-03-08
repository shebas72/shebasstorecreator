<?PHP
/**
 * "../core/translate/wp_nav_menu-filter.php"
 * 
 * ABOUT: filtering WordPress navigation menu, then
 * translate them
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
 * @since 1.0
 */
if( !defined('ABSPATH') ) {
	exit;
}



/**
 * WordPress Navigation Items => filter and translate
 * items navigation
 * 
 * @since 1.3.0
 * @return object array
 */
add_action( 'wp_get_nav_menu_items', function( $items, $menu, $args ) {
	
	/**
	 * loop for every items that menu has.
	 */
	foreach( $items as $numb => $item ) {
	
		/**
		 * if it's a menu item, then progress will continue.
		 * But if not, then title will not be changed.
		 */
		if( $item->post_type == 'nav_menu_item' ) {
			
			/**
			 * change title
			 */
			
			/**
			 * getting translation from database
			 */
			$title = get_post_meta( $item->ID, '_st_menu_' . slimTranslate::$language, true );
			
			/**
			 * changing post_title from object
			 */
			$items[$numb]->post_title = $title ? $title : $item->post_title;
			
			/**
			 * changing title from object
			 */
			$items[$numb]->title = $title ? $title : $item->title;

		} // IF
	
	} // FOOREACH
	
	return $items;

}, 10, 3 ); // ACITON
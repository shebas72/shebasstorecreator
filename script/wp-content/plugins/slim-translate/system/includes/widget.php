<?PHP
/**
 * "../includes/widget.php"
 * 
 * @package		Slim Translate
 * @since		1.2.0
 * @category	plugin
 * @author		Bestafiko Borizqy <fiko@warungthemes.com>
 * @link		http://warungthemes.com/slim
 */



class slimTranslate_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array(
			'classname' => 'st-widget-translate',
			'description' => esc_html__( 'Translate your site through this widget.', 'slim-translate' )
		);
		parent::__construct('st-widget-translate', esc_html__( 'Translation', 'slim-translate' ), $widget_ops);
	}


	function widget( $args , $instance ) {

		/**
		 * prepare for the variables
		 */
		extract($args);
		$title = (isset($instance['title']) && $instance['title']) ? $instance['title'] : esc_html__( 'Translate', 'slim-translate' );
		$style = (isset($instance['style']) && $instance['style']) ? $instance['style'] : 'st-translate-widget';
		$class = (isset($instance['class']) && $instance['class']) ? $instance['class'] : false;

		print( $before_widget . $before_title . $title . $after_title );
		echo '<div class="st-widget-translate ' . $style . ' ' . $class .'">';

			/**
			 * active / default language will show as the toggle
			 */
			echo '<div class="st-toggle">';
				echo '<a ' . ( $style == 'st-widget-boxs' ? 'title="' . slimTranslate::get_languages( slimTranslate::$language ) . '"' : '' ) . ' href="#" class="st-flag-item">';
					echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( slimTranslate::$language, 'code' ) . '"></span>';
					echo $style == 'st-translate-widget' ? '<div>' . slimTranslate::get_languages( slimTranslate::$language ) . '</div>' : '';
				echo '</a>';
			echo '</div>';

			/**
			 * another language will show if visitor click the toggle
			 */
			if( count(slimTranslate::$setting->languages) > 0 ) {

				if( count($_GET) > 0 ) {
					$get = '';
					foreach( $_GET as $key => $val ) {
						if( $key != 'st-lang' ) {
							$get = $get . '&' . $key . '=' . $val;
						}
					}
				} else {
					$get = '';
				}

				echo '<div class="st-dropdown" ' . ( $style == 'st-translate-widget' ? 'style="display: none;"' : '' ) . '>';
				foreach( slimTranslate::$setting->languages as $key => $val ) {
					if( slimTranslate::$language !== $val ) {
						echo '<a ' . ( $style == 'st-widget-boxs' ? 'title="' . slimTranslate::get_languages( $val ) . '"' : '' ) . ' href="?st-lang=' . $val . $get . '&st-continue=' . urlencode( 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ) . '" class="st-flag-item">';
							echo '<span class="flag-icon flag-icon-' . slimTranslate::get_languages( $val, 'code' ) . '"></span>';
							echo $style == 'st-translate-widget' ? '<div>' . slimTranslate::get_languages( $val ) . '</div>' : '';
						echo '</a>';
					}
				}
				echo '</div>';
			} // IF

		echo '</div>';
		print( $after_widget );

	}

	/**
	 * form's function for backend
	 */
    function form($instance) {

		/**
		 * prepare for the variables
		 */
		$instance['title'] = isset($instance['title']) ? $instance['title'] : '';
		$instance['style'] = isset($instance['style']) ? $instance['style'] : '';
		$instance['class'] = isset($instance['class']) ? $instance['class'] : '';

		echo '<div class="st-form-widget">';
			
			// WIDGET TITLE
			echo '<div class="st-form-widget-field">';
				echo '<label for="' . esc_attr( $this->get_field_id('title') ) . '">' . esc_html__( 'Title', 'slim-translate' ) . '</label>';
				echo '<input class="st-fullwidth" type="text" value="' . esc_attr( $instance['title'] ) . '"  name="' . esc_attr( $this->get_field_name('title') ) . '" id="' . esc_attr( $this->get_field_id('title') ) . '" />';
			echo '</div>';
			
			// WIDGET STYLE
			echo '<div class="st-form-widget-field">';
				echo '<label for="' . esc_attr( $this->get_field_id('style') ) . '">' . esc_html__( 'Widget Style', 'slim-translate' ) . '</label>';
				echo '<select name="' . esc_attr( $this->get_field_name('style') ) . '" id="' . esc_attr( $this->get_field_id('style') ) . '" >';
					echo '<option ' . ( $instance['style'] == 'st-translate-widget' ? 'selected' : '' ) . ' value="st-translate-widget">' . esc_html__( 'Corner Widget', 'slim-translate' ) . '</option>';
					echo '<option ' . ( $instance['style'] == 'st-widget-boxs' ? 'selected' : '' ) . ' value="st-widget-boxs">' . esc_html__( 'Boxs', 'slim-translate' ) . '</option>';
				echo '</select>';
			echo '</div>';
			
			// CUSTOM CLASS
			echo '<div class="st-form-widget-field">';
				echo '<label for="' . esc_attr( $this->get_field_id('class') ) . '">' . esc_html__( 'Custom Class', 'slim-translate' ) . '</label>';
				echo '<input class="st-fullwidth" type="text" value="' . esc_attr( $instance['class'] ) . '"  name="' . esc_attr( $this->get_field_name('class') ) . '" id="' . esc_attr( $this->get_field_id('class') ) . '" />';
				echo '<p class="description">' . esc_html__( 'Separate class name with comma!', 'slim-translate' ) . '</p>';
			echo '</div>';

		echo '</div>';

    } // FUNCTION

}


/* REGISTER
========================================= */
add_action( 'widgets_init', function() {
	register_widget( 'slimTranslate_widget' );
});
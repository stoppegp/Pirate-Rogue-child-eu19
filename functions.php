<?php
/* enqueue styles og parent theme */
function parent_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
    
	// Dequeue Style from pirate-crew, this theme has its own style for it
    wp_dequeue_style('pirate-crew');
 
}
add_action( 'wp_enqueue_scripts', 'parent_enqueue_styles' );


/* add additional colors for colorsets */
function pirate_rogue_child_eu19_body_class_modify_customizer_settings( $wp_customize ) {
	global $xwolf_customizer_setoptions;

	$additional_colorlist = array('eublue' => '#003399');
	
	foreach ($xwolf_customizer_setoptions['pirate_rogue_themeoptions']['fields'] as $key => $val) {
		if ('colorlist-radio' == $val['type']) {
			$xwolf_customizer_setoptions['pirate_rogue_themeoptions']['fields'][$key]['liste'] += $additional_colorlist;
		}
	}
}
add_action( 'customize_register', 'pirate_rogue_child_eu19_body_class_modify_customizer_settings', 1 );

/* function to run after parents function.php */
function late_child_function() {
	
	/* add shortcode for slider */
	if (!function_exists('pirate_rogue_shortcode_slider') && !function_exists('pirate_rogue_shortcode_slider_entry')) {
		function pirate_rogue_shortcode_slider( $atts, $content = null ) {
			// pirate-rogue-script must be enqueued after slick
			wp_dequeue_script('pirate-rogue-script');
			wp_enqueue_script('pirate-rogue-slick');
			wp_enqueue_script('pirate-rogue-script');

			$out = '<div class="featured-slider cf">'.do_shortcode( $content ).'</div>';
			return $out;
		}
		function pirate_rogue_shortcode_slider_entry( $atts, $content = null ) {
			extract(shortcode_atts(array(
				'url'	=> '',
				'img'	=> '',
				'alt'   => '',
			), $atts));
			$url =  esc_attr($url);
			$img =  esc_attr($img);
			$alt =  esc_attr($alt);
			$out = '<article><div class="entry-thumbnail" role="presentation"><a href="'.$url.'"><img src="'.$img.'" alt="'.$alt.'"></a></div></article>';
			return $out;
		}
		add_shortcode('slider', 'pirate_rogue_shortcode_slider');
		add_shortcode('slider-entry', 'pirate_rogue_shortcode_slider_entry');
	}

	/* Extends the parents body classes */
	function pirate_rogue_child_eu19_body_class( $classes ) {

		/* add slider-class when slider-shortcode is used */
		global $post;
		if( isset($post->post_content) && has_shortcode( $post->post_content, 'slider' ) ) {
			$classes[] = 'slider-on';
		}
		return $classes;
	}
	add_filter( 'body_class', 'pirate_rogue_child_eu19_body_class' );
	
	/* set new default colors */
	    //set_theme_mod( 'pirate_rogue_main_meta_bgcol', 'eublue' );
	    //set_theme_mod( 'pirate_rogue_main_meta_bgcol_hover', 'main' );
	    //set_theme_mod( 'pirate_rogue_main_meta_textcol', 'white' );
	    //set_theme_mod( 'pirate_rogue_main_meta_textcol_hover', 'white' );
	    set_theme_mod( 'pirate_rogue_footer_background_color', 'black' );
		
	

}
add_action( 'after_setup_theme', 'late_child_function' );
?>

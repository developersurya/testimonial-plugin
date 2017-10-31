<?php
/**
 * @package testimonial plugin by developerSurya
 * @version 1.1
 */
/*
Plugin Name: Testimonial plugin by developerSurya
Plugin URI: http://hellosurya.com.np
Description: This is just a plugin for showing testimonial by shortcode e.g [testimonial total='2'].
Author: Surya Manandhar
Version: 1.1
Author URI: http://hellosurya.com.np
*/

//try to make changes in next file
//load js for plugin
function t_admin_scripts() {
	wp_enqueue_script( 'jquery' );
	//wp_enqueue_script( 'jquery', plugin_dir_url( __FILE__ ) . '/js/custom.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'bootstrap', plugin_dir_url( __FILE__ ) . '/js/bootstrap.js', array( 'jquery' ), '', true );
	wp_register_style( 'bootstrap',plugin_dir_url( __FILE__ ) . '/css/bootstrap.css');
	wp_enqueue_style( 'bootstrapfontawesome','https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css');
	wp_register_style( 'customcsss',plugin_dir_url( __FILE__ ) . '/css/customcss.css');
	
	wp_enqueue_style( 'bootstrap' );
	wp_enqueue_style( 'customcsss' );
}
add_action( 'init', 't_admin_scripts' ); 

//looad css for plugin
function load_t_wp_admin_style() {
       
}
add_action( 'admin_enqueue_scripts', 'load_t_wp_admin_style' );
function codex_custom_init() {
 
    $args = array(
      	'label'  => 'Testimonial',
         'description'        => __( 'Description.', 'Testimonial plugins with bootstrap' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'testimonial' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'thumbnail' )
	);

    register_post_type( 'Testimonial', $args );
}
add_action( 'init', 'codex_custom_init' );

function testimonial_func( $atts ){
	  $foobar_atts = shortcode_atts( array(
        'total' => '5',
        'attribution' => 'Author',
    ), $atts );
		$string = '';
		$string .= '<div class="testomonial-wrp">
		<div class="carousel slide" data-ride="carousel" id="quote-carousel">
		<div class="carousel-inner text-center">';
		$num= $foobar_atts['total'];
		//var_dump($num);
		$args= array('post_type' => 'Testimonial','posts_per_page'=>$num);
		$the_query = new WP_Query( $args );
		$count=0;
		
		if ( $the_query->have_posts() ) {
		while ( $the_query->have_posts() ) {
		$the_query->the_post();
		if($count=="0"){$first="active";}else{$first="";}
    	$string .= '<div class="item '.$first.'">
				<blockquote>
					<div class="row">
						<div class="col-sm-8 col-sm-offset-2">';
	 	 $string .= '<p>'.get_the_content().'</p>';
		 $string .= '<small>'.get_the_title().'</small>';
		 $string .= '</div></div></blockquote></div>';
		  $count++;
			   }
			    $string.='</div>';
				wp_reset_postdata();
			}
			$args= array('post_type' => 'Testimonial','posts_per_page'=>$num);
			$the_query = new WP_Query( $args );
			$count=0;
			$string .= '<ol class="carousel-indicators">';
			if ( $the_query->have_posts() ) {
			while ( $the_query->have_posts() ) {
			$the_query->the_post();
			if($count=="0"){$first="active";}else{$first="";}
			 $medium_image_url = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium');
   			$medium_image_url[0]; 
		 	$string .= '<li data-target="#quote-carousel" data-slide-to="'.$count.'" class="'.$first.'">
				<img class="img-responsive " src="'.$medium_image_url[0].'">
			</li>';
		  	$count++;
			   }
				wp_reset_postdata();
			}
			$string .= '</ol>';
		 	$string .= '</div></div>';
			return $string;
	?>
	<?php  
	 
}
add_shortcode( 'testimonial', 'testimonial_func' );


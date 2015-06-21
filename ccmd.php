<?php 
/**
 * Plugin Name: Category Meta
 * Description: Adds Meta Functionality to taxonomies
 * Author: Richard Miles
 * Version: 1.0
 * Author URI: http://richmiles.co.za
 */
require_once( 'classes/class-ccmd.php' );
 // $meta_values = get_post_meta( $post_id, $key, $single ); 
	// echo get_category_meta('hello' , 'the_id' , 'genre');
function get_category_meta($catid , $key = '' , $tax = 'category') {
	if (get_option( "cat_settings_$catid" )) {
		return get_option( "cat_settings_$catid" )[$key];  
	} else {
		// get_term_by('slug', 'my-term-slug', 'category');
		$idObj = get_term_by('slug' , $catid , $tax); 
		$id = $idObj->term_id;
		return get_option( "cat_settings_$id" )[$key];  
	}

}

add_action( 'init', 'create_book_tax' );

function create_book_tax() {

	$bob = new ccmd('genre');
	$bob->add_section('sample');

	$args = array(
		'id'=>'the other one' ,
		'name'=>'the other one'
		);
	$bob->add_setting( $args );

	$args = array(
		'id'=>'the_idthree' ,
		'name'=>'the_namethree', 
		'type'=>'select' ,
		'options'=> array('one' , 'two' , 'three'),
		'description'=>'the_descriptionthree' , 
		'section'=>'sample'
		);

	$bob->add_setting( $args );

	register_taxonomy(
		'genre',
		'post',
		array(
			'label' => __( 'Genre' ),
			'rewrite' => array( 'slug' => 'genre' ),
			'hierarchical' => true,
			)
		);
}


<?php
/**
 * This page is an example page of how to add custom category metadata to your WordPress
 *  plugin or theme.
 **/

add_action( 'init', 'create_book_tax' );

function create_book_tax() {

	register_taxonomy(
		'genre',
		'post',
		array(
			'label' => __( 'Genre' ),
			'rewrite' => array( 'slug' => 'genre' ),
			'hierarchical' => true,
			)
		);
	
	$ccmd = new ccmd('genre');
	$ccmd->add_section('sample');

	$args = array(
		'id'=>'the other one' ,
		'name'=>'the other one'
		);
	$ccmd->add_setting( $args );

	$args = array(
		'id'=>'the_idthree' ,
		'name'=>'the_namethree', 
		'type'=>'select' ,
		'options'=> array('one' , 'two' , 'three'),
		'description'=>'the_descriptionthree' , 
		'section'=>'sample'
		);

	$ccmd->add_setting( $args );


}

?>
<?php 
/**
 * Plugin Name: Category Meta
 * Description: Adds Meta Functionality to taxonomies
 * Author: Richard Miles
 * Version: 1.0
 * Author URI: http://richmiles.co.za
 */

if (!class_exists('ccmd')) {
	require_once( 'classes/class-ccmd.php' );
}

if (!function_exists('get_category_meta')) {
	function get_category_meta($catid , $key = '' , $tax = 'category') {
		if (get_option( "cat_settings_$catid" )) {
			return get_option( "cat_settings_$catid" )[$key];  
		} else {
			$idObj = get_term_by('slug' , $catid , $tax); 
			$id = $idObj->term_id;
			return get_option( "cat_settings_$id" )[$key];  
		}
	}
}

add_action('admin_enqueue_scripts' , function() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');

	wp_enqueue_style('thickbox');
});
 



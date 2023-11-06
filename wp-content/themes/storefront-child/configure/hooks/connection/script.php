<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'add_enqueue_script' ) ) {
	/**
	 * added script or style
	 */
	function add_enqueue_script() {

		wp_enqueue_style( 'bootstrap-css', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css' );
		wp_enqueue_script( 'jquery', 'https://code.jquery.com/jquery-3.5.1.min.js', array(), null, true );
		wp_enqueue_script( 'bootstrap-js', 'https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array( 'jquery' ), null, true );
	}
}
add_action( 'wp_enqueue_scripts', 'add_enqueue_script' );

if ( ! function_exists( 'add_enqueue_admin' ) ) {
	/**
	 * added script or style
	 */
	function add_enqueue_admin() {
		wp_enqueue_style( 'admin-styles', get_stylesheet_directory_uri() . '/assets/css/admin/product-customization.css' );
		wp_enqueue_script( 'admin-script', get_stylesheet_directory_uri() . '/assets/js/admin/admin.js', array( 'jquery' ), '', true );
	}
}
add_action( 'admin_enqueue_scripts', 'add_enqueue_admin' );

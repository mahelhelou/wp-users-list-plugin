<?php
/*
Plugin Name:    WP Users List
Description:    Print all users and their roles in a beautiful formatted table
Version:        1.0
Author:         Mahmoud El Helou
Text Domain:    wp-users-list
License:        GPLv2
*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

add_action( 'plugins_loaded', 'wp_users_list_load_textdomain' );
/**
 * Provides the location of the PO and MO files for this plugin based on the location of the languages directory
 */
function wp_users_list_load_textdomain() {
	$plugin_path = plugin_basename( dirname( __FILE__ ) );
	$plugin_path .= '/languages';

	load_plugin_textdomain(
		'wp-users-list',
		false,
		$plugin_path
	);
}

/**
 * Allow the user to print the users list using shortcode
 */
add_shortcode( 'UsersList', 'wp_users_list_display_page' );
add_action( 'admin_menu', 'wp_users_list_display_page' );
/**
 * Adds a new sub menu page to show a table of all available users
 * The new submenu page will be available in Users -> Users List
 * The menu page will be translation-ready
 */

function wp_users_list_display_page() {

	add_submenu_page(
		'users.php',
		__( 'Users List Page', 'wp-users-list' ),
		__( 'Users List', 'wp-users-list' ),
		'manage_options',
		'wp-users-list-menu',
		'wp_users_list_display_submenu_page'
	);

}

/**
 * Displays the content of the page for users list table
 * Submenu item is located in the Users -> Users List
 */
function wp_users_list_display_submenu_page() {
	if ( is_admin() ) {
		require_once( 'users-list-ui.php' );
	} else {
		echo '<h2>Sorry. You are not authorized to enter this page!';
	}
}

/**
 * Add styles to the table of users list
 * The table is located in Users -> Users List
 */

/**
 * Apply the scripts only to Users List page
 */

if ( isset( $_GET['page'] ) &&  $_GET['page'] == 'wp-users-list-menu' ) {
	add_action( 'admin_enqueue_scripts', 'wp_users_list_scripts' );
}

function wp_users_list_scripts() {
	// Load CSS
	wp_enqueue_style( 'data-tables', plugin_dir_url( __FILE__ ) . '/assets/css/data-tables.css' );
	wp_enqueue_style( 'users-list-css', plugin_dir_url( __FILE__ ) . '/assets/css/users-list-styles.css' );

	// Load JS
	wp_enqueue_script( 'data-tables-js', plugin_dir_url( __FILE__ ) . '/assets/js/data-tables.js', array( 'jquery' ), null, true );
	wp_enqueue_script( 'users-list-js', plugin_dir_url( __FILE__ ) . '/assets/js/users-list-scripts.js', array( 'jquery' ), null, true );
}
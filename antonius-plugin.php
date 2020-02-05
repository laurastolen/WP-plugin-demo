<?php

/**
 * @package Sandhills_Demo
 * @version 1.0.1
 */
/*
Plugin Name: Sandhills Demo
Plugin URI: https://github.com/laurastolen/WP-plugin-demo
Description: An attempt at a WordPress plugin - my first time using WordPress, and my first time writing anything in PHP!
Author: Laura Antonius
Version: 1.0.1
Author URI: https://github.com/laurastolen
*/

defined( 'ABSPATH' ) or die( 'Not allowed!' );

// fx to create custom post type
function make_post() {
  register_post_type( 'demoPost', ['public' => true, 'label' => 'New Post!' ] );
}
// hook to inititialization
add_action('init', 'make_post');
add_action('init', 'user_ip_address');



// fx to get user's ip address
function get_ip_address( $atts ) {
  $body = wp_remote_retrieve_body( wp_remote_get( 'bot.whatismyipaddress.com' ) );
  // echo $body;
  return $body;
}



// creates shortcode so [ip_address] displays the output of user_ip_address fx
add_shortcode( "ip_address", "get_ip_address" );



// getting stored ip address if present, otherwise find it anew
$ip_address_to_display = get_transient( 'stored_ip_address' );
if( false === $ip_address_to_display ) {
    // transient has expired, need new data
    $body = wp_remote_retrieve_body( wp_remote_get( 'bot.whatismyipaddress.com' ) );
    // set transient to new data
    set_transient( 'stored_ip_address', $body, 60*60 );
}

// now can use $ip_address_to_display on page

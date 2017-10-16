<?php 
/*
Plugin Name:  ASR Google Map
Plugin URI:   http://asrcoder.com
Author:       Akhtarujjaman Shuvo
Author URI:   http://fb.com/suvobd.ml
Version: 	  1.0
Description:  A simple plugin that help you to create ulimited google map on your wordpress site and you can show your map anywhere using shortcode like a pro.
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  asr_td
Domain Path:  /languages

ASR Google Map is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
ASR Google Map is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with ASR Google Map. If not, see https://www.gnu.org/licenses/gpl-2.0.html.

*/

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

require_once( 'inc/functions.php' );
require_once( 'inc/shortcode.php' );
require_once( 'inc/meta-boxes.php' );

/**
*Plugin Scripts
*/
function asrgm_gmap_front_enqueue_scripts() {   	
    wp_enqueue_script( 'asr-gmp-api', 'https://maps.googleapis.com/maps/api/js?key='.get_option('asr_gmap_api').'&callback=initMap',array(),'1.0',true );
}
add_action('wp_enqueue_scripts', 'asrgm_gmap_front_enqueue_scripts');

/**
*Admin Scripts
*/
function asrgm_gmap_admin_enqueue_scripts() {   
	if ( 'gmap-pro' == get_post_type() ){	// work only Google Map Setting Page	
		//Enqueue Css(s)
		wp_enqueue_style( 'gmap-stylesheet', plugin_dir_url(__FILE__).'admin/css/gmap-main.css',array(),'1.0' );
		wp_enqueue_style( 'gmap-admin-stylesheet', plugin_dir_url(__FILE__).'admin/css/gmap-admin.css',array(),'1.0.1' );
		
		//Enqueue js(s)
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'gmap-scripts', plugin_dir_url(__FILE__).'admin/js/gmap-scripts.js',array('jquery'),'1.0',true );
	}
}
add_action('admin_enqueue_scripts', 'asrgm_gmap_admin_enqueue_scripts');
<?php 

/*
 Plugin Name: WP Spark
 Description: An expressive and elegant object-oriented API for WordPress
 Author: Cyrus Collier
 Version: 0.1
 */
$vendor_dir = dirname( dirname( __DIR__ ) );
if ( !file_exists( $vendor_dir . '/autoload.php' ) )
    $vendor_dir = dirname( dirname( $vendor_dir ) );
require_once $vendor_dir . '/autoload.php';

add_action( 'muplugins_loaded', 'spark' );
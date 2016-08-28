<?php 

define( 'ROOT_DIR' , dirname( dirname( __DIR__ ) ) );
define( 'WP_TESTS_DIR', ROOT_DIR . '/vendor/wordpress-dev' );
define( 'SRC_DIR', ROOT_DIR . '/src' );

copy( __DIR__ . '/wp-tests-config.php', WP_TESTS_DIR . '/wp-tests-config.php' );

if ( !file_exists( WP_TESTS_DIR . '/src/wp-content/mu-plugins' ) )
    mkdir( WP_TESTS_DIR . '/src/wp-content/mu-plugins' );
copy( SRC_DIR . '/spark.php', WP_TESTS_DIR . '/src/wp-content/mu-plugins/spark.php' );

require_once WP_TESTS_DIR . '/tests/phpunit/includes/bootstrap.php';
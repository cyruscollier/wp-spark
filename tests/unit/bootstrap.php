<?php 

define('WP_PATH', 'vendor/wordpress-dev/src/');
define('WP_CONTENT_DIR', WP_PATH . '/wp-content/');

require WP_PATH . 'wp-includes/class-wp-post.php';
require WP_PATH . 'wp-includes/class-wp-post-type.php';
require WP_PATH . 'wp-includes/class-wp-widget.php';

/* Mocked WP functions used in domain objects */
function apply_filters($tag, $value) { return $value; }
function do_action($tag) {}
function get_the_excerpt($post) { return $post->post_excerpt; }
function maybe_unserialize($value) { return $value; }
function maybe_serialize($value) { return $value; }
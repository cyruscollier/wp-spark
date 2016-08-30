<?php 

define('WP_PATH', 'vendor/wordpress-dev/src/');

require_once WP_PATH . 'wp-includes/class-wp-post.php';

/* Mocked WP functions used in domain objects */
function apply_filters($tag, $value) { return $value; }
function do_action($tag) {}
function get_the_excerpt($post) { return $post->post_excerpt; }
function maybe_unserialize($value) { return $value; }

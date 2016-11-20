<?php
/**
 * This is the start php file for every request.
 * You should point your web to this folder and make this file the entry point.
 * From here WordPress is loaded and as default WP will read wp-config in the same folder.
 */

define('WP_USE_THEMES', true);
require_once dirname(__FILE__) . '/wp/wp-blog-header.php';

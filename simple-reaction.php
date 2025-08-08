<?php
/**
 * Plugin Name: Post Reactions Plugin
 * Description: Adds emoji-style reactions to posts.
 * Version: 1.0
 * Author: Jack
 */

define('PRP_PATH', plugin_dir_path(__FILE__));
define('PRP_URL', plugin_dir_url(__FILE__));

// Load reaction core
require_once PRP_PATH . 'includes/reaction-core.php';

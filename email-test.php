<?php
/*
Plugin Name: Email Test
Plugin Group: Utilities
Plugin URI: https://github.com/webdeveric/email-test
Version: 0.3.0
Description: Send a test email from WordPress.
Author: Eric King
Author URI: http://webdeveric.com/
*/

namespace webdeveric\EmailTest;

include __DIR__ . '/src/functions.php';

\add_action('admin_menu', __NAMESPACE__ . '\adminMenu');

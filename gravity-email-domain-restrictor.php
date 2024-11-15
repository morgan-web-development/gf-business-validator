<?php
/**
 * Plugin Name: Gravity Forms Email Domain Restrictor
 * Plugin URI: https://yourwebsite.com
 * Description: Adds a checkbox to Gravity Forms email fields to restrict specific domains like Gmail and Outlook.
 * Version: 1.0
 * Author: Your Name
 * Author URI: https://yourwebsite.com
 * Text Domain: gravity-email-domain-restrictor
 * Domain Path: /languages
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('GF_EMAIL_RESTRICTOR_VERSION', '1.0');
define('GF_EMAIL_RESTRICTOR_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('GF_EMAIL_RESTRICTOR_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include necessary files
require_once GF_EMAIL_RESTRICTOR_PLUGIN_DIR . 'includes/admin-settings.php';
require_once GF_EMAIL_RESTRICTOR_PLUGIN_DIR . 'includes/field-validation.php';

// Load text domain for translations
add_action('plugins_loaded', function () {
    load_plugin_textdomain('gravity-email-domain-restrictor', false, dirname(plugin_basename(__FILE__)) . '/languages');
});

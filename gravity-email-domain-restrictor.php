<?php
/**
 * Plugin Name: Gravity Forms Email Domain Restrictor
 * Plugin URI: https://morganwebdevelopment.com
 * Description: Adds a checkbox to Gravity Forms email fields to restrict specific domains like Gmail and Outlook.
 * Version: 1.0
 * Author: Morgan Web Development
 * Author URI: https://morganwebdevelopment.com
 * Text Domain: gravity-email-domain-restrictor
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Ensure Gravity Forms is active
add_action('plugins_loaded', function () {
    if (!class_exists('GFForms')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p>Gravity Forms Email Domain Restrictor requires Gravity Forms to be installed and active.</p></div>';
        });
        return;
    }

    // Load necessary files
    require_once plugin_dir_path(__FILE__) . 'includes/admin-settings.php';
    require_once plugin_dir_path(__FILE__) . 'includes/field-validation.php';
});

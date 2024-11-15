<?php
// Ensure this is called by WordPress during uninstallation
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Cleanup actions
delete_option('gravity_email_restrictor_settings');

<?php

// Prevent direct access
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// Perform cleanup (e.g., remove options, settings)
delete_option('gravity_email_restrictor_settings');


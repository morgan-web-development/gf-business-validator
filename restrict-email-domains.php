<?php
/*
Plugin Name: Gravity Forms Custom Email Domain Restriction
Description: Adds an option to Gravity Forms email fields to restrict custom domains entered by the user.
Version: 1.0
Author: Your Name
*/

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check if Gravity Forms is active.
if ( ! class_exists( 'GFForms' ) ) {
    add_action( 'admin_notices', function() {
        ?>
        <div class="error notice">
            <p><?php esc_html_e( 'Gravity Forms Custom Email Domain Restriction requires Gravity Forms to be installed and activated.', 'gravity-forms-email-restriction' ); ?></p>
        </div>
        <?php
    } );
    return;
}

// Add the custom settings to the email field.
add_action( 'gform_field_advanced_settings', function( $position, $form_id ) {
    if ( $position === 50 ) {
        ?>
        <li class="restrict-email-domains-setting field_setting">
            <input type="checkbox" id="restrict_email_domains" onclick="SetFieldProperty('restrictEmailDomains', this.checked);" />
            <label for="restrict_email_domains" class="inline">
                <?php esc_html_e( 'Restrict specific domains', 'gravity-forms-email-restriction' ); ?>
            </label>
            <textarea id="blocked_domains" rows="3" style="width:100%;" placeholder="Enter domains, separated by commas"
                oninput="SetFieldProperty('blockedDomains', this.value);"></textarea>
            <label for="blocked_domains">
                <?php esc_html_e( 'Enter domains to block (e.g., gmail.com, outlook.com)', 'gravity-forms-email-restriction' ); ?>
            </label>
        </li>
        <?php
    }
}, 10, 2 );

// Save and load the custom settings.
add_action( 'gform_editor_js', function() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Add the custom settings to email fields.
            fieldSettings.email += ', .restrict-email-domains-setting';

            // Load settings when the field is selected.
            jQuery(document).on('gform_load_field_settings', function(event, field) {
                jQuery('#restrict_email_domains').prop('checked', field['restrictEmailDomains'] === true);
                jQuery('#blocked_domains').val(field['blockedDomains'] || '');
            });
        });
    </script>
    <?php
});

// Validate the email against the blocked domains.
add_filter( 'gform_field_validation', function( $result, $value, $form, $field ) {
    if ( $field->type === 'email' && rgar( $field, 'restrictEmailDomains' ) ) {
        $blocked_domains = array_map( 'trim', explode( ',', rgar( $field, 'blockedDomains' ) ) );
        $email_domain    = substr( strrchr( $value, '@' ), 1 );

        if ( in_array( $email_domain, $blocked_domains, true ) ) {
            $result['is_valid'] = false;
            $result['message']  = __( 'The email domain you entered is not allowed.', 'gravity-forms-email-restriction' );
        }
    }
    return $result;
}, 10, 4 );

<?php
/*
Plugin Name: Gravity Forms Email Restriction
Description: Adds an option to Gravity Forms email fields to restrict Gmail and Outlook domains.
Version: 1.0
Author: Morgan Web Development
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
            <p><?php esc_html_e( 'Gravity Forms Email Restriction requires Gravity Forms to be installed and activated.', 'gravity-forms-email-restriction' ); ?></p>
        </div>
        <?php
    } );
    return;
}

// Add the checkbox option to the email field settings.
add_action( 'gform_field_advanced_settings', function( $position, $form_id ) {
    if ( $position === 50 ) {
        ?>
        <li class="restrict-email-domains-setting field_setting">
            <input type="checkbox" id="restrict_email_domains" onclick="SetFieldProperty('restrictEmailDomains', this.checked);" />
            <label for="restrict_email_domains" class="inline">
                <?php esc_html_e( 'Restrict Gmail and Outlook domains', 'gravity-forms-email-restriction' ); ?>
            </label>
        </li>
        <?php
    }
}, 10, 2 );

// Add the setting to the field properties.
add_filter( 'gform_field_content', function( $content, $field ) {
    if ( $field->type === 'email' && rgar( $field, 'restrictEmailDomains' ) ) {
        $content .= '<input type="hidden" name="restrict_email_domains" value="1" />';
    }
    return $content;
}, 10, 2 );

// Enqueue the Gravity Forms script for handling the checkbox.
add_action( 'gform_editor_js', function() {
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            // Load the restrictEmailDomains property when the field is loaded.
            fieldSettings.email += ', .restrict-email-domains-setting';

            // Update the checkbox value when the field is selected.
            jQuery(document).on('gform_load_field_settings', function(event, field) {
                jQuery('#restrict_email_domains').prop('checked', field['restrictEmailDomains'] === true);
            });
        });
    </script>
    <?php
});

// Add server-side validation to restrict Gmail and Outlook domains.
add_filter( 'gform_field_validation', function( $result, $value, $form, $field ) {
    if ( $field->type === 'email' && rgar( $field, 'restrictEmailDomains' ) ) {
        $restricted_domains = [ 'gmail.com', 'outlook.com', 'yahoo.com', 'hotmail.com' ];
        $email_domain = substr( strrchr( $value, '@' ), 1 );

        if ( in_array( $email_domain, $restricted_domains, true ) ) {
            $result['is_valid'] = false;
            $result['message']  = __( 'Emails from Gmail and Outlook domains are not allowed.', 'gravity-forms-email-restriction' );
        }
    }
    return $result;
}, 10, 4 );

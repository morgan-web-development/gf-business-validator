<?php

// Add a custom setting to the email field
add_filter('gform_field_standard_settings', function ($position, $form_id) {
    // Add the setting after the "Required" field
    if ($position == 25) {
        ?>
        <li class="restrict-email-domains-setting field_setting">
            <input type="checkbox" id="field_restrict_email_domains" onclick="SetFieldProperty('restrictEmailDomains', this.checked)" />
            <label for="field_restrict_email_domains" class="inline">
                <?php esc_html_e('Restrict Gmail and Outlook domains', 'gravity-email-domain-restrictor'); ?>
            </label>
        </li>
        <?php
    }
}, 10, 2);

// Add the custom property to email fields
add_filter('gform_field_advanced_settings', function ($position, $form_id) {
    ?>
    <script type="text/javascript">
        // Make the new property visible when an email field is selected
        fieldSettings['email'] += ', .restrict-email-domains-setting';

        // Load the property value when editing a field
        jQuery(document).on('gform_load_field_settings', function(event, field) {
            jQuery('#field_restrict_email_domains').prop('checked', field['restrictEmailDomains'] == true);
        });
    </script>
    <?php
}, 10, 2);

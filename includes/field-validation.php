<?php

// Validate email fields based on the restrictEmailDomains setting
add_filter('gform_field_validation', function ($result, $value, $form, $field) {
    // Check if the field is an email field and has the restrictEmailDomains property enabled
    if ($field->type === 'email' && !empty($field->restrictEmailDomains)) {
        // List of disallowed domains
        $disallowed_domains = ['gmail.com', 'outlook.com'];

        // Extract the domain from the email
        $email_parts = explode('@', $value);
        $email_domain = isset($email_parts[1]) ? strtolower($email_parts[1]) : '';

        // Validate the domain
        if (in_array($email_domain, $disallowed_domains)) {
            $result['is_valid'] = false;
            $result['message'] = 'Email addresses from Gmail or Outlook are not allowed.';
        }
    }

    return $result;
}, 10, 4);


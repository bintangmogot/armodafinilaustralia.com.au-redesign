<?php
add_action('acf/init', function() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_theme_settings',
        'title' => 'Theme Settings',
        'fields' => array(
            array(
                'key' => 'field_tab_header',
                'label' => 'Header & Top Bar',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_topbar_left',
                'label' => 'Top Bar Left Text',
                'name' => 'topbar_left',
                'type' => 'text',
                'default_value' => 'Premium cognitive support â€” Australia-wide dispatch',
            ),
            array(
                'key' => 'field_topbar_center',
                'label' => 'Top Bar Center Text',
                'name' => 'topbar_center',
                'type' => 'text',
                'default_value' => '6â€“12 business days â€” discreet packaging',
            ),
            array(
                'key' => 'field_topbar_right',
                'label' => 'Top Bar Right Text',
                'name' => 'topbar_right',
                'type' => 'text',
                'default_value' => 'Support',
            ),


            array(
                'key' => 'field_tab_social',
                'label' => 'Social Media',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_facebook_link',
                'label' => 'Facebook Link',
                'name' => 'facebook_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_instagram_link',
                'label' => 'Instagram Link',
                'name' => 'instagram_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_twitter_link',
                'label' => 'Twitter Link',
                'name' => 'twitter_link',
                'type' => 'url',
            ),
            array(
                'key' => 'field_tab_contact',
                'label' => 'Contact Info',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_support_email',
                'label' => 'Support Email',
                'name' => 'support_email',
                'type' => 'email',
                'default_value' => 'support@armodafinil-australia-direct.com',
                'instructions' => 'Used in the top bar and footer. Leave blank to hide from the footer.',
            ),
            array(
                'key' => 'field_whatsapp_number',
                'label' => 'Support Phone Number',
                'name' => 'whatsapp_number',
                'type' => 'text',
                'default_value' => '+61 4 8999 5839',
                'instructions' => 'Leave blank to hide from the footer.',
            ),


            array(
                'key' => 'field_tab_footer',
                'label' => 'Footer',
                'name' => '',
                'type' => 'tab',
                'placement' => 'top',
                'endpoint' => 0,
            ),
            array(
                'key' => 'field_footer_description',
                'label' => 'Footer Description',
                'name' => 'footer_description',
                'type' => 'textarea',
                'default_value' => 'Steady focus, cleaner clarity, and dependable dispatch &mdash; built for Australian customers who take their day seriously.',
            ),
            array(
                'key' => 'field_ssl_text',
                'label' => 'SSL Text',
                'name' => 'ssl_text',
                'type' => 'text',
                'default_value' => 'SSL secured',
            ),
            array(
                'key' => 'field_dispatch_text',
                'label' => 'Dispatch Text',
                'name' => 'dispatch_text',
                'type' => 'text',
                'default_value' => 'AU-wide dispatch',
            ),
            array(
                'key' => 'field_checkout_text',
                'label' => 'Checkout Text',
                'name' => 'checkout_text',
                'type' => 'text',
                'default_value' => 'Encrypted checkout',
            ),
            array(
                'key' => 'field_location_text',
                'label' => 'Location Text',
                'name' => 'location_text',
                'type' => 'text',
                'default_value' => 'Sydney, AU',
            ),
            array(
                'key' => 'field_copyright_text',
                'label' => 'Copyright Text',
                'name' => 'copyright_text',
                'type' => 'text',
                'default_value' => '© 2026 Armodafinil. Information only &mdash; not medical advice.',
            ),

        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-general-settings',
                ),
            ),
        ),
    ));

    endif;
});


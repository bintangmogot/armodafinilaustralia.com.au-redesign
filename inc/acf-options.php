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
            ),
            array(
                'key' => 'field_topbar_center',
                'label' => 'Top Bar Center Text',
                'name' => 'topbar_center',
                'type' => 'text',
            ),
            array(
                'key' => 'field_topbar_right',
                'label' => 'Top Bar Right Text',
                'name' => 'topbar_right',
                'type' => 'text',
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
                'instructions' => 'Used in the top bar and footer. Leave blank to hide from the footer.',
            ),
            array(
                'key' => 'field_whatsapp_number',
                'label' => 'Support Phone Number',
                'name' => 'whatsapp_number',
                'type' => 'text',
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
            ),
            array(
                'key' => 'field_ssl_text',
                'label' => 'SSL Text',
                'name' => 'ssl_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_dispatch_text',
                'label' => 'Dispatch Text',
                'name' => 'dispatch_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_checkout_text',
                'label' => 'Checkout Text',
                'name' => 'checkout_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_location_text',
                'label' => 'Location Text',
                'name' => 'location_text',
                'type' => 'text',
            ),
            array(
                'key' => 'field_copyright_text',
                'label' => 'Copyright Text',
                'name' => 'copyright_text',
                'type' => 'text',
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


<?php
/**
 * Theme Settings (ACF options page).
 *
 * Field names and keys marked "live" match the values already stored by the live site,
 * so nothing has to be re-entered after the switch. Nothing here has default copy.
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'acf/init', function () {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}

	$tab = static function ( $key, $label ) {
		return array(
			'key'       => $key,
			'label'     => $label,
			'name'      => '',
			'type'      => 'tab',
			'placement' => 'top',
			'endpoint'  => 0,
		);
	};

	acf_add_local_field_group( array(
		'key'      => 'group_theme_settings',
		'title'    => 'Theme Settings',
		'fields'   => array(
			$tab( 'field_tab_header', 'Header' ),
			array(
				'key'           => 'field_theme_enable_announcement', // live
				'label'         => 'Show Announcement Bar',
				'name'          => 'enable_announcement_bar',
				'type'          => 'true_false',
				'ui'            => 1,
				'default_value' => 0,
			),
			array(
				'key'   => 'field_theme_announcement_text', // live
				'label' => 'Announcement Text',
				'name'  => 'announcement_text',
				'type'  => 'text',
			),
			array(
				'key'           => 'field_theme_enable_feature_bar', // live
				'label'         => 'Show Feature Bar',
				'name'          => 'enable_feature_bar',
				'type'          => 'true_false',
				'ui'            => 1,
				'default_value' => 0,
			),
			array(
				'key'          => 'field_theme_feature_bar_items', // live
				'label'        => 'Feature Bar Items',
				'name'         => 'feature_bar_items',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add Item',
				'sub_fields'   => array(
					array(
						'key'          => 'field_theme_feature_icon', // live
						'label'        => 'Icon (inline SVG)',
						'name'         => 'icon',
						'type'         => 'textarea',
						'rows'         => 3,
						'instructions' => 'Paste a single inline SVG. Leave empty for no icon.',
					),
					array(
						'key'   => 'field_theme_feature_text', // live
						'label' => 'Text',
						'name'  => 'text',
						'type'  => 'text',
					),
				),
			),
			array(
				'key'          => 'field_header_whatsapp_label',
				'label'        => 'Header WhatsApp Button Label',
				'name'         => 'header_whatsapp_label',
				'type'         => 'text',
				'instructions' => 'The button uses the WhatsApp number from the Contact tab. Leave empty to hide the button.',
			),
			array(
				'key'          => 'field_header_search_label',
				'label'        => 'Header Search Label',
				'name'         => 'header_search_label',
				'type'         => 'text',
				'instructions' => 'Text shown inside the search box. Leave empty to hide the search box.',
			),
			array(
				'key'   => 'field_header_logo_alt',
				'label' => 'Logo Alt Text',
				'name'  => 'header_logo_alt',
				'type'  => 'text',
			),

			$tab( 'field_tab_contact', 'Contact' ),
			array(
				'key'   => 'field_footer_direct_helpline', // live
				'label' => 'Phone',
				'name'  => 'footer_direct_helpline',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_contact_whatsapp_number',
				'label'        => 'WhatsApp Number',
				'name'         => 'footer_whatsapp',
				'type'         => 'text',
				'instructions' => 'Shown as typed. The chat link is built from the digits (a leading 0 becomes 61).',
			),
			array(
				'key'   => 'field_footer_email', // live
				'label' => 'Email Address',
				'name'  => 'footer_email',
				'type'  => 'email',
			),
			array(
				'key'   => 'field_footer_corporate_registry', // live
				'label' => 'Address',
				'name'  => 'footer_corporate_registry',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_footer_track_order_url', // live
				'label' => 'Track Order URL',
				'name'  => 'footer_track_order_url',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_footer_facebook', // live
				'label' => 'Facebook URL',
				'name'  => 'footer_facebook',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_footer_linkedin', // live
				'label' => 'LinkedIn URL',
				'name'  => 'footer_linkedin',
				'type'  => 'url',
			),

			$tab( 'field_tab_footer', 'Footer' ),
			array(
				'key'          => 'field_footer_description',
				'label'        => 'About Text',
				'name'         => 'footer_description',
				'type'         => 'textarea',
				'rows'         => 4,
				'instructions' => 'Shown under the logo.',
			),
			array(
				'key'          => 'field_68adc7eef57a0', // live
				'label'        => 'Delivery Text',
				'name'         => 'footer_text',
				'type'         => 'textarea',
				'rows'         => 3,
				'instructions' => 'Short delivery or coverage line below the About Text.',
			),
			array(
				'key'          => 'field_footer_menu_1_heading', // live
				'label'        => 'Column 1 Heading',
				'name'         => 'footer_menu_1_heading',
				'type'         => 'text',
				'instructions' => 'Links come from Appearance > Menus > Footer Category Menu.',
			),
			array(
				'key'          => 'field_footer_menu_2_heading', // live
				'label'        => 'Column 2 Heading',
				'name'         => 'footer_menu_2_heading',
				'type'         => 'text',
				'instructions' => 'Links come from Appearance > Menus > Footer Quick Links.',
			),
			array(
				'key'          => 'field_footer_menu_3_heading', // live
				'label'        => 'Column 3 Heading',
				'name'         => 'footer_menu_3_heading',
				'type'         => 'text',
				'instructions' => 'Links come from Appearance > Menus > Footer Important Links.',
			),
			array(
				'key'          => 'field_footer_disclaimer',
				'label'        => 'Medical Disclaimer',
				'name'         => 'footer_disclaimer',
				'type'         => 'wysiwyg',
				'media_upload' => 0,
				'tabs'         => 'visual',
				'toolbar'      => 'basic',
				'instructions' => 'Shown in a panel above the copyright line.',
			),
			array(
				'key'          => 'field_footer_payment_images',
				'label'        => 'Payment Logos',
				'name'         => 'footer_payment_images',
				'type'         => 'gallery',
				'return_format' => 'id',
				'preview_size' => 'thumbnail',
				'library'      => 'all',
			),
			array(
				'key'          => 'field_footer_shipping_images',
				'label'        => 'Shipping Logos',
				'name'         => 'footer_shipping_images',
				'type'         => 'gallery',
				'return_format' => 'id',
				'preview_size' => 'thumbnail',
				'library'      => 'all',
			),
			array(
				'key'          => 'field_footer_copyright',
				'label'        => 'Copyright Text',
				'name'         => 'footer_copyright',
				'type'         => 'text',
				'instructions' => 'Use {year} for the current year and {site_name} for the site title.',
			),

			$tab( 'field_tab_search', 'Search' ),
			array(
				'key'   => 'field_search_all_label',
				'label' => 'All Categories Label',
				'name'  => 'search_all_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_search_empty_title',
				'label' => 'Start Title',
				'name'  => 'search_empty_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_search_empty_text',
				'label' => 'Start Text',
				'name'  => 'search_empty_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_search_popular_label',
				'label' => 'Popular Searches Label',
				'name'  => 'search_popular_label',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_search_popular_terms',
				'label'        => 'Popular Searches',
				'name'         => 'search_popular_terms',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Add Term',
				'sub_fields'   => array(
					array(
						'key'   => 'field_search_popular_term',
						'label' => 'Term',
						'name'  => 'term',
						'type'  => 'text',
					),
				),
			),
			array(
				'key'          => 'field_search_no_results',
				'label'        => 'No Results Text',
				'name'         => 'search_no_results_text',
				'type'         => 'text',
				'instructions' => 'Use {query} for the searched word.',
			),

			$tab( 'field_tab_labels', 'Interface Labels' ),
			array(
				'key'   => 'field_label_buy_now',
				'label' => 'Buy Button (product cards)',
				'name'  => 'label_buy_now',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_read_more',
				'label' => 'Read More',
				'name'  => 'label_read_more',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_read_less',
				'label' => 'Read Less',
				'name'  => 'label_read_less',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_load_more',
				'label' => 'Load More',
				'name'  => 'label_load_more',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_loading',
				'label' => 'Loading',
				'name'  => 'label_loading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_previous',
				'label' => 'Previous (carousel)',
				'name'  => 'label_previous',
				'type'  => 'text',
				'instructions' => 'Used as the accessible name of the arrow buttons.',
			),
			array(
				'key'   => 'field_label_next',
				'label' => 'Next (carousel)',
				'name'  => 'label_next',
				'type'  => 'text',
				'instructions' => 'Used as the accessible name of the arrow buttons.',
			),
			array(
				'key'   => 'field_label_verified',
				'label' => 'Verified Buyer Badge',
				'name'  => 'label_verified',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_home',
				'label' => 'Home (breadcrumb)',
				'name'  => 'label_home',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_showing_reviews',
				'label' => 'Reviews Count Line',
				'name'  => 'label_showing_reviews',
				'type'  => 'text',
				'instructions' => 'Use {shown} and {total}, for example: Showing {shown} of {total} reviews.',
			),
			array(
				'key'   => 'field_label_rating_from',
				'label' => 'Average Rating Line',
				'name'  => 'label_rating_from',
				'type'  => 'text',
				'instructions' => 'Use {total}, for example: From {total} reviews.',
			),
			array(
				'key'   => 'field_label_no_reviews',
				'label' => 'No Reviews Text',
				'name'  => 'label_no_reviews',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_no_products',
				'label' => 'No Products Text',
				'name'  => 'label_no_products',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_rating',
				'label' => 'Review Form: Rating',
				'name'  => 'label_form_rating',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_title',
				'label' => 'Review Form: Title',
				'name'  => 'label_form_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_title_ph',
				'label' => 'Review Form: Title Placeholder',
				'name'  => 'label_form_title_ph',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_review',
				'label' => 'Review Form: Review',
				'name'  => 'label_form_review',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_review_ph',
				'label' => 'Review Form: Review Placeholder',
				'name'  => 'label_form_review_ph',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_name',
				'label' => 'Review Form: Name',
				'name'  => 'label_form_name',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_name_ph',
				'label' => 'Review Form: Name Placeholder',
				'name'  => 'label_form_name_ph',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_email',
				'label' => 'Review Form: Email',
				'name'  => 'label_form_email',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_email_ph',
				'label' => 'Review Form: Email Placeholder',
				'name'  => 'label_form_email_ph',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_submit',
				'label' => 'Review Form: Submit Button',
				'name'  => 'label_form_submit',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_submitting',
				'label' => 'Review Form: Submitting',
				'name'  => 'label_form_submitting',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_form_error',
				'label' => 'Review Form: Connection Error',
				'name'  => 'label_form_error',
				'type'  => 'text',
			),

			array(
				'key'   => 'field_label_unit_tabs',
				'label' => 'Quantity Unit (after the number)',
				'name'  => 'label_unit_tabs',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_choose_quantity',
				'label' => 'Choose Quantity Heading',
				'name'  => 'label_choose_quantity',
				'type'  => 'text',
			),

			array(
				'key'   => 'field_label_search_results',
				'label' => 'Search Results Heading',
				'name'  => 'label_search_results',
				'type'  => 'text',
				'instructions' => 'Use {query} for the searched word.',
			),
			array(
				'key'   => 'field_label_no_results_page',
				'label' => 'Search: Nothing Found Text',
				'name'  => 'label_no_results_page',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_404_title',
				'label' => 'Not Found Page: Heading',
				'name'  => 'label_404_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_404_text',
				'label' => 'Not Found Page: Text',
				'name'  => 'label_404_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_back_home',
				'label' => 'Back to Home Button',
				'name'  => 'label_back_home',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_related_posts',
				'label' => 'Related Posts Heading',
				'name'  => 'label_related_posts',
				'type'  => 'text',
			),

			$tab( 'field_tab_blog', 'Blog' ),
			array(
				'key'   => 'field_blog_title',
				'label' => 'Blog Page Heading',
				'name'  => 'blog_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_blog_subtitle',
				'label' => 'Blog Badge Text',
				'name'  => 'blog_subtitle',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_blog_description',
				'label' => 'Blog Intro',
				'name'  => 'blog_description',
				'type'  => 'textarea',
				'rows'  => 3,
			),

			$tab( 'field_tab_tracking', 'Tracking' ),
			array(
				'key'          => 'field_ga_measurement_id',
				'label'        => 'Google Analytics ID',
				'name'         => 'ga_measurement_id',
				'type'         => 'text',
				'instructions' => 'For example G-XXXXXXXXXX. Leave empty to turn tracking off.',
			),
		),
		'location' => array(
			array(
				array(
					'param'    => 'options_page',
					'operator' => '==',
					'value'    => 'theme-general-settings',
				),
			),
		),
	) );
} );

/**
 * WhatsApp chat URL from the stored number.
 */
function armo_whatsapp_url() {
	$digits = preg_replace( '/\D+/', '', (string) get_field( 'footer_whatsapp', 'option' ) );
	if ( '' === $digits ) {
		return '';
	}
	if ( 0 === strpos( $digits, '0' ) ) {
		$digits = '61' . substr( $digits, 1 );
	}
	return 'https://wa.me/' . $digits;
}

/**
 * A text label from Theme Settings > Interface Labels. Returns an empty string when unset.
 */
function armo_label( $name ) {
	return (string) get_field( $name, 'option' );
}

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

			array(
				'key'   => 'field_label_checkout_title',
				'label' => 'Checkout: Page Heading',
				'name'  => 'label_checkout_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_step_contact',
				'label' => 'Checkout: Step 1 Title',
				'name'  => 'label_checkout_step_contact',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_step_medical',
				'label' => 'Checkout: Step 2 Title',
				'name'  => 'label_checkout_step_medical',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_step_payment',
				'label' => 'Checkout: Step 3 Title',
				'name'  => 'label_checkout_step_payment',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_continue_medical',
				'label' => 'Checkout: Continue to Step 2',
				'name'  => 'label_checkout_continue_medical',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_continue_payment',
				'label' => 'Checkout: Continue to Step 3',
				'name'  => 'label_checkout_continue_payment',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_checkout_back',
				'label' => 'Checkout: Back Button',
				'name'  => 'label_checkout_back',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_back_to_cart',
				'label' => 'Back to Cart Link',
				'name'  => 'label_back_to_cart',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_order_summary',
				'label' => 'Order Summary Heading',
				'name'  => 'label_order_summary',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_cart_title',
				'label' => 'Cart: Page Heading',
				'name'  => 'label_cart_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_secure_ssl',
				'label' => 'Checkout Trust: SSL',
				'name'  => 'label_secure_ssl',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_secure_encrypted',
				'label' => 'Checkout Trust: Encrypted',
				'name'  => 'label_secure_encrypted',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_secure_tracked',
				'label' => 'Checkout Trust: Tracked',
				'name'  => 'label_secure_tracked',
				'type'  => 'text',
			),

			array(
				'key'   => 'field_label_each',
				'label' => 'Cart: Price Each Suffix',
				'name'  => 'label_each',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_remove_item',
				'label' => 'Cart: Remove Item',
				'name'  => 'label_remove_item',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_free_shipping_more',
				'label' => 'Cart: Free Shipping Prompt',
				'name'  => 'label_free_shipping_more',
				'type'  => 'text',
				'instructions' => 'Use {amount} for the money still needed, for example: Add {amount} more to unlock free shipping.',
			),
			array(
				'key'   => 'field_label_cart_secure_note',
				'label' => 'Cart: Secure Note',
				'name'  => 'label_cart_secure_note',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_cart_empty_text',
				'label' => 'Empty Cart Text',
				'name'  => 'label_cart_empty_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_explore_products',
				'label' => 'Empty Cart Button',
				'name'  => 'label_explore_products',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_coupon_title',
				'label' => 'Coupon Box Title',
				'name'  => 'label_coupon_title',
				'type'  => 'text',
			),

			array(
				'key'   => 'field_label_payid',
				'label' => 'Emails: PayID Label',
				'name'  => 'label_payid',
				'type'  => 'text',
				'instructions' => 'Printed before the PayID taken from the first bank account (IBAN field) in order emails.',
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

			array(
				'key'   => 'field_label_all_products',
				'label' => 'Back to Shop Link',
				'name'  => 'label_all_products',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_in_stock',
				'label' => 'In Stock',
				'name'  => 'label_in_stock',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_out_of_stock',
				'label' => 'Out of Stock',
				'name'  => 'label_out_of_stock',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_add_to_cart',
				'label' => 'Add to Cart',
				'name'  => 'label_add_to_cart',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_buy_now_checkout',
				'label' => 'Buy Now (goes to checkout)',
				'name'  => 'label_buy_now_checkout',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_adding',
				'label' => 'Adding to Cart',
				'name'  => 'label_adding',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_added',
				'label' => 'Added to Cart',
				'name'  => 'label_added',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_share',
				'label' => 'Share',
				'name'  => 'label_share',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_link_copied',
				'label' => 'Link Copied',
				'name'  => 'label_link_copied',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_per_unit',
				'label' => 'Per Unit Suffix',
				'name'  => 'label_per_unit',
				'type'  => 'text',
				'instructions' => 'Shown after the price per tablet, for example: / tablet.',
			),
			array(
				'key'   => 'field_label_product_specs',
				'label' => 'Product Specs Heading',
				'name'  => 'label_product_specs',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_reviews_heading',
				'label' => 'Product Reviews Heading',
				'name'  => 'label_reviews_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_star_count',
				'label' => 'Star Count Word',
				'name'  => 'label_star_count',
				'type'  => 'text',
				'instructions' => 'Shown after 5, 4, 3 ... in the review summary, for example: star.',
			),
			array(
				'key'   => 'field_label_related_products',
				'label' => 'Related Products Heading',
				'name'  => 'label_related_products',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_medically_reviewed',
				'label' => 'Medically Reviewed By',
				'name'  => 'label_medically_reviewed',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_last_updated',
				'label' => 'Last Updated',
				'name'  => 'label_last_updated',
				'type'  => 'text',
			),

			$tab( 'field_tab_product', 'Product Page' ),
			array(
				'key'   => 'field_product_shipping_notice',
				'label' => 'Free Shipping Notice',
				'name'  => 'product_shipping_notice',
				'type'  => 'text',
				'instructions' => 'Shown under the price, for example the free shipping threshold.',
			),
			array(
				'key'          => 'field_product_trust_items',
				'label'        => 'Trust Items',
				'name'         => 'product_trust_items',
				'type'         => 'repeater',
				'layout'       => 'table',
				'button_label' => 'Add Item',
				'sub_fields'   => array(
					array( 'key' => 'field_product_trust_text', 'label' => 'Text', 'name' => 'text', 'type' => 'text' ),
				),
			),

			array(
				'key'   => 'field_free_shipping_threshold',
				'label' => 'Free Shipping Threshold (AUD)',
				'name'  => 'free_shipping_threshold',
				'type'  => 'number',
				'instructions' => 'Used by the cart prompt only. The real free shipping rule is set in WooCommerce shipping zones.',
			),

			$tab( 'field_tab_cta', 'Closing CTA' ),
			array(
				'key'   => 'field_cta_heading',
				'label' => 'Heading',
				'name'  => 'cta_heading',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_cta_text',
				'label' => 'Text',
				'name'  => 'cta_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_cta_button_label',
				'label' => 'Button Label',
				'name'  => 'cta_button_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_cta_button_url',
				'label' => 'Button Link',
				'name'  => 'cta_button_url',
				'type'  => 'url',
			),
			array(
				'key'   => 'field_cta_secondary_label',
				'label' => 'Second Button Label',
				'name'  => 'cta_secondary_label',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_cta_secondary_url',
				'label' => 'Second Button Link',
				'name'  => 'cta_secondary_url',
				'type'  => 'url',
			),

			$tab( 'field_tab_thankyou', 'Thank You' ),
			array(
				'key'   => 'field_label_thankyou_title',
				'label' => 'Heading',
				'name'  => 'label_thankyou_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_thankyou_text',
				'label' => 'Message',
				'name'  => 'label_thankyou_text',
				'type'  => 'text',
				'instructions' => 'Use {name} for the first name and {email} for the customer email.',
			),
			array(
				'key'   => 'field_label_thankyou_order_id',
				'label' => 'Order Number Label',
				'name'  => 'label_thankyou_order_id',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_thankyou_next_title',
				'label' => 'What Happens Next Heading',
				'name'  => 'label_thankyou_next_title',
				'type'  => 'text',
			),
			array(
				'key'          => 'field_thankyou_steps',
				'label'        => 'What Happens Next Steps',
				'name'         => 'thankyou_steps',
				'type'         => 'repeater',
				'layout'       => 'block',
				'button_label' => 'Add Step',
				'sub_fields'   => array(
					array( 'key' => 'field_thankyou_step_title', 'label' => 'Title', 'name' => 'title', 'type' => 'text' ),
					array( 'key' => 'field_thankyou_step_text', 'label' => 'Text', 'name' => 'text', 'type' => 'textarea', 'rows' => 2 ),
				),
			),
			array(
				'key'   => 'field_label_continue_shopping',
				'label' => 'Continue Shopping Button',
				'name'  => 'label_continue_shopping',
				'type'  => 'text',
			),

			$tab( 'field_tab_medical', 'Medical Form' ),
			array(
				'key'   => 'field_label_med_title',
				'label' => 'Heading',
				'name'  => 'label_med_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_physician',
				'label' => 'Physician Name Label',
				'name'  => 'label_med_physician',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_physician_phone',
				'label' => 'Physician Phone Label',
				'name'  => 'label_med_physician_phone',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_allergies',
				'label' => 'Drug Allergies Label',
				'name'  => 'label_med_allergies',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_medications',
				'label' => 'Current Medications Label',
				'name'  => 'label_med_medications',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_treatments',
				'label' => 'Current Treatments Label',
				'name'  => 'label_med_treatments',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_smoke',
				'label' => 'Smoke Question',
				'name'  => 'label_med_smoke',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_drink',
				'label' => 'Alcohol Question',
				'name'  => 'label_med_drink',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_yes',
				'label' => 'Yes',
				'name'  => 'label_med_yes',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_no',
				'label' => 'No',
				'name'  => 'label_med_no',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_medical_certification',
				'label' => 'Certification Statement',
				'name'  => 'medical_certification',
				'type'  => 'textarea',
				'rows'  => 5,
				'instructions' => 'Shown above the upload box. Wording to be approved by the client.',
			),
			array(
				'key'   => 'field_label_med_upload_title',
				'label' => 'Upload Title',
				'name'  => 'label_med_upload_title',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_upload_text',
				'label' => 'Upload Instruction',
				'name'  => 'label_med_upload_text',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_choose_file',
				'label' => 'Choose File Link',
				'name'  => 'label_med_choose_file',
				'type'  => 'text',
			),
			array(
				'key'   => 'field_label_med_selected',
				'label' => 'Selected File Prefix',
				'name'  => 'label_med_selected',
				'type'  => 'text',
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

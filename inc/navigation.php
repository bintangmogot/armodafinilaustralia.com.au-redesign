<?php
/**
 * Menu locations, menu markup classes and the one-time carry-over of the live theme's
 * menu assignments and logo.
 *
 * Location slugs match the live theme, so the existing menus keep their places.
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'after_setup_theme', function () {
	register_nav_menus( array(
		'primary'          => __( 'Primary Menu (Header)', 'armodafinil-australia' ),
		'mobile'           => __( 'Mobile Menu (Header)', 'armodafinil-australia' ),
		'footer'           => __( 'Footer Category Menu', 'armodafinil-australia' ),
		'footer-quick'     => __( 'Footer Quick Links', 'armodafinil-australia' ),
		'footer-important' => __( 'Footer Important Links', 'armodafinil-australia' ),
	) );
} );

/**
 * When this theme is activated for the first time, copy the live theme's saved menu
 * locations and custom logo so the site does not come up without a menu or logo.
 */
add_action( 'after_switch_theme', function () {
	$new_key = 'theme_mods_' . get_option( 'stylesheet' );
	$current = get_option( $new_key );
	if ( is_array( $current ) && ! empty( $current['nav_menu_locations'] ) ) {
		return;
	}
	$old = get_option( 'theme_mods_armodafinil-australia' );
	if ( ! is_array( $old ) ) {
		return;
	}
	$carry = array_intersect_key( (array) $old, array_flip( array( 'nav_menu_locations', 'custom_logo' ) ) );
	update_option( $new_key, array_merge( is_array( $current ) ? $current : array(), $carry ) );
} );

add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {
	switch ( $args->theme_location ?? '' ) {
		case 'primary':
			$atts['class'] = 'armo-nav-link';
			break;
		case 'mobile':
			$atts['class'] = 'armo-drawer-link';
			break;
		case 'footer':
		case 'footer-quick':
		case 'footer-important':
			$atts['class'] = 'armo-footer-link';
			break;
	}
	return $atts;
}, 10, 3 );

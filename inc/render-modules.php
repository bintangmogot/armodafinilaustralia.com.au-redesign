<?php
/**
 * Renders the flexible content on a page.
 *
 * Content created before the redesign lives in the `modules` field and is drawn by
 * modules-legacy/. Sections added after the redesign live in `page_modules` and are drawn
 * by modules/. A page can hold either, or both (legacy first).
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Print every module of a post.
 *
 * @param int|null $post_id Post to read the fields from. Defaults to the current post.
 * @return bool True when at least one module was printed.
 */
function armo_render_modules( $post_id = null ) {
	if ( ! function_exists( 'have_rows' ) ) {
		return false;
	}

	$post_id  = $post_id ? $post_id : get_the_ID();
	$rendered = false;

	foreach ( array(
		'modules'      => 'modules-legacy/content',
		'page_modules' => 'modules/content',
	) as $field => $template_slug ) {
		if ( ! have_rows( $field, $post_id ) ) {
			continue;
		}
		while ( have_rows( $field, $post_id ) ) {
			the_row();
			ob_start();
			get_template_part( $template_slug, get_row_layout() );
			$html = ob_get_clean();

			// A module whose fields are empty prints nothing: skip output with no visible text and no media.
			$has_text  = '' !== trim( wp_strip_all_tags( preg_replace( '#<(script|style)\b.*?</\1>#is', '', $html ) ) );
			$has_media = (bool) preg_match( '/<(img|iframe|video|form)\b/i', $html );
			if ( $has_text || $has_media ) {
				echo $html; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside the module templates.
				$rendered = true;
			}
		}
	}

	return $rendered;
}

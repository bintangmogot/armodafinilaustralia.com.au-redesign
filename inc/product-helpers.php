<?php
/**
 * Helpers shared by product cards, product page and schema output.
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Rating summary for a product from the `reviews` post type (ACF: rating, linked_product).
 * Returns count 0 and average 0 when there are no reviews: nothing is invented.
 *
 * @param int $product_id Product ID.
 * @return array{count:int,average:float}
 */
function armo_product_rating_summary( $product_id ) {
	static $cache = array();
	$product_id = (int) $product_id;
	if ( isset( $cache[ $product_id ] ) ) {
		return $cache[ $product_id ];
	}

	$ids = get_posts( array(
		'post_type'      => 'reviews',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'fields'         => 'ids',
		'no_found_rows'  => true,
		'meta_query'     => array(
			array(
				'key'   => 'linked_product',
				'value' => $product_id,
			),
		),
	) );

	$total = 0.0;
	$count = 0;
	foreach ( $ids as $review_id ) {
		$rating = (float) get_post_meta( $review_id, 'rating', true );
		if ( $rating > 0 ) {
			$total += $rating;
			++$count;
		}
	}

	$cache[ $product_id ] = array(
		'count'   => $count,
		'average' => $count ? round( $total / $count, 1 ) : 0.0,
	);
	return $cache[ $product_id ];
}

/**
 * Quantity options of a variable product as card pills.
 *
 * Each option: label ("50 Tabs"), price (plain number), price_html, url (product page with the
 * option preselected).
 *
 * @param WC_Product $product Product.
 * @return array<int,array<string,string>>
 */
function armo_product_quantity_options( $product ) {
	if ( ! $product || ! $product->is_type( 'variable' ) ) {
		return array();
	}

	$options = array();
	foreach ( $product->get_available_variations() as $variation ) {
		if ( empty( $variation['is_purchasable'] ) || empty( $variation['is_in_stock'] ) ) {
			continue;
		}
		$attributes = $variation['attributes'];
		$value      = (string) reset( $attributes );
		if ( '' === $value ) {
			continue;
		}
		$label = $value;
		$match = array();
		if ( preg_match( '/\d[\d,]*/', $value, $match ) ) {
			$unit  = armo_label( 'label_unit_tabs' );
			$label = $unit ? $match[0] . ' ' . $unit : $match[0];
		}
		$options[] = array(
			'label'      => $label,
			'sort'       => (int) str_replace( ',', '', $match ? $match[0] : '0' ),
			'price'      => (string) $variation['display_price'],
			'price_html' => wc_price( $variation['display_price'] ),
			'url'        => add_query_arg( $attributes, $product->get_permalink() ),
		);
	}

	usort( $options, static function ( $a, $b ) {
		return $a['sort'] <=> $b['sort'];
	} );
	return $options;
}

/**
 * Five star icons, the first $rating filled. Returns trusted markup built from numbers only.
 *
 * @param int $rating Whole number 0-5.
 * @param int $size   Icon size in pixels.
 * @return string
 */
function armo_stars_html( $rating, $size = 16 ) {
	$rating = max( 0, min( 5, (int) $rating ) );
	$size   = (int) $size;
	$path   = 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z';
	$html   = '<span class="inline-flex" role="img" aria-label="' . esc_attr( $rating . '/5' ) . '">';
	for ( $i = 1; $i <= 5; $i++ ) {
		$html .= '<svg xmlns="http://www.w3.org/2000/svg" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true" class="' . ( $i <= $rating ? 'text-star' : 'text-border' ) . '"><path d="' . $path . '"/></svg>';
	}
	return $html . '</span>';
}

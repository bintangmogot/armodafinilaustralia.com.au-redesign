<?php
/**
 * Structured data additions on top of All in One SEO's graph.
 *
 * - Product pages: aggregateRating from the `reviews` post type, only when real reviews exist.
 * - Pages with FAQ modules: a FAQPage node built from the same ACF rows that print the FAQ.
 *
 * Hook checked in the AIOSEO source: aioseo_schema_output (app/Common/Schema/Helpers.php).
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Question and answer pairs from every FAQ module on a post (modules and page_modules).
 *
 * @param int $post_id Post ID.
 * @return array<int,array{question:string,answer:string}>
 */
function armo_collect_faq_items( $post_id ) {
	$items = array();
	if ( ! function_exists( 'get_field' ) ) {
		return $items;
	}

	foreach ( array( 'modules', 'page_modules' ) as $field ) {
		$rows = get_field( $field, $post_id );
		if ( empty( $rows ) || ! is_array( $rows ) ) {
			continue;
		}
		foreach ( $rows as $row ) {
			if ( empty( $row['acf_fc_layout'] ) ) {
				continue;
			}
			if ( 'faqs' === $row['acf_fc_layout'] && ! empty( $row['faqs'] ) ) {
				foreach ( $row['faqs'] as $faq ) {
					$items[] = array( 'question' => (string) ( $faq['question'] ?? '' ), 'answer' => (string) ( $faq['answer'] ?? '' ) );
				}
			}
		}
	}

	return array_values( array_filter( $items, static function ( $item ) {
		return '' !== trim( wp_strip_all_tags( $item['question'] ) ) && '' !== trim( wp_strip_all_tags( $item['answer'] ) );
	} ) );
}

add_filter( 'aioseo_schema_output', function ( $graphs ) {
	if ( ! is_array( $graphs ) || ! is_singular() ) {
		return $graphs;
	}
	$post_id = get_queried_object_id();

	if ( function_exists( 'is_product' ) && is_product() ) {
		$rating = armo_product_rating_summary( $post_id );
		if ( $rating['count'] > 0 ) {
			foreach ( $graphs as $index => $graph ) {
				if ( isset( $graph['@type'] ) && 'Product' === $graph['@type'] ) {
					$graphs[ $index ]['aggregateRating'] = array(
						'@type'       => 'AggregateRating',
						'ratingValue' => $rating['average'],
						'reviewCount' => $rating['count'],
						'bestRating'  => 5,
						'worstRating' => 1,
					);
				}
			}
		}
	}

	$faq_items = armo_collect_faq_items( $post_id );
	if ( ! empty( $faq_items ) ) {
		$entities = array();
		foreach ( $faq_items as $item ) {
			$entities[] = array(
				'@type'          => 'Question',
				'name'           => wp_strip_all_tags( $item['question'] ),
				'acceptedAnswer' => array(
					'@type' => 'Answer',
					'text'  => wp_kses_post( $item['answer'] ),
				),
			);
		}
		$graphs[] = array(
			'@type'      => 'FAQPage',
			'@id'        => get_permalink( $post_id ) . '#faq',
			'mainEntity' => $entities,
		);
	}

	return $graphs;
} );

<?php
/**
 * Product inside a loop (shop, categories, search): the shared product card.
 *
 * @package Armodafinil_Australia
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

get_template_part( 'template-parts/product-card', null, array( 'product' => $product ) );

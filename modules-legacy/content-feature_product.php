<?php
/**
 * Module: feature_product (modules field).
 * Fields: heading, feature_product (relationship, objects), price_subtext
 *
 * @package Armodafinil_Australia
 */

$heading  = get_sub_field( 'heading' );
$products = get_sub_field( 'feature_product' );
$subtext  = get_sub_field( 'price_subtext' );

if ( empty( $products ) || ! is_array( $products ) ) {
	return;
}
?>
<section class="section bg-white">
	<div class="container-site">
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
			<?php foreach ( $products as $item ) : ?>
				<?php
				$product = wc_get_product( is_object( $item ) ? $item->ID : $item );
				if ( ! $product ) {
					continue;
				}
				get_template_part( 'template-parts/product-card', null, array( 'product' => $product, 'price_subtext' => $subtext ) );
				?>
			<?php endforeach; ?>
		</div>
	</div>
</section>

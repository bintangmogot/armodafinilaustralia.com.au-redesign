<?php
/**
 * Module: feature_product_inline (modules field), used inside blog posts.
 * Fields: heading, feature_product (relationship, objects), price_subtext
 * Shows the selected products as cards, side by side on wide screens.
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
<section class="py-10 lg:py-14">
	<div class="container-site max-w-4xl">
		<?php if ( $heading ) : ?>
			<h2 class="mb-6 text-center font-heading text-2xl font-bold text-primary md:text-3xl"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="grid gap-4 <?php echo count( $products ) > 1 ? 'sm:grid-cols-2' : 'mx-auto max-w-sm'; ?>">
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

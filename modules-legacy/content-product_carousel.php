<?php
/**
 * Module: product_carousel (modules field).
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
$prev = armo_label( 'label_previous' );
$next = armo_label( 'label_next' );
?>
<section class="section bg-white">
	<div class="container-site" data-carousel>
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="relative">
			<?php if ( $prev ) : ?>
				<button type="button" data-carousel-prev class="absolute -left-4 top-1/3 z-10 hidden h-11 w-11 items-center justify-center rounded-full border border-border bg-white text-primary shadow-soft hover:bg-secondary xl:flex" aria-label="<?php echo esc_attr( $prev ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
				</button>
			<?php endif; ?>

			<div data-carousel-track class="relative -mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-4 pb-4 [scrollbar-width:none] sm:mx-0 sm:px-0 [&::-webkit-scrollbar]:hidden">
				<?php foreach ( $products as $item ) : ?>
					<?php
					$product = wc_get_product( is_object( $item ) ? $item->ID : $item );
					if ( ! $product ) {
						continue;
					}
					?>
					<div class="w-[72%] shrink-0 snap-start sm:w-[calc(50%-8px)] lg:w-[calc(25%-12px)]">
						<?php get_template_part( 'template-parts/product-card', null, array( 'product' => $product, 'price_subtext' => $subtext ) ); ?>
					</div>
				<?php endforeach; ?>
			</div>

			<?php if ( $next ) : ?>
				<button type="button" data-carousel-next class="absolute -right-4 top-1/3 z-10 hidden h-11 w-11 items-center justify-center rounded-full border border-border bg-white text-primary shadow-soft hover:bg-secondary xl:flex" aria-label="<?php echo esc_attr( $next ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
				</button>
			<?php endif; ?>
		</div>
	</div>
</section>

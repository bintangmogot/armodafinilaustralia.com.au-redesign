<?php
/**
 * Module: reviews_carousel_grid (modules field).
 * Fields: heading. Shows the latest reviews that are not tied to one product.
 *
 * @package Armodafinil_Australia
 */

$heading = get_sub_field( 'heading' );
$reviews = new WP_Query( array(
	'post_type'      => 'reviews',
	'posts_per_page' => 12,
	'post_status'    => 'publish',
	'no_found_rows'  => true,
	'meta_query'     => array(
		'relation' => 'OR',
		array( 'key' => 'linked_product', 'compare' => 'NOT EXISTS' ),
		array( 'key' => 'linked_product', 'value' => '', 'compare' => '=' ),
	),
) );

if ( ! $reviews->have_posts() ) {
	wp_reset_postdata();
	return;
}
$prev = armo_label( 'label_previous' );
$next = armo_label( 'label_next' );
?>
<section class="section bg-secondary">
	<div class="container-site" data-carousel>
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="relative">
			<?php if ( $prev ) : ?>
				<button type="button" data-carousel-prev class="absolute -left-4 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-border bg-white text-primary shadow-soft hover:bg-secondary xl:flex" aria-label="<?php echo esc_attr( $prev ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
				</button>
			<?php endif; ?>

			<div data-carousel-track class="relative -mx-4 flex snap-x snap-mandatory gap-4 overflow-x-auto scroll-smooth px-4 pb-4 [scrollbar-width:none] sm:mx-0 sm:px-0 [&::-webkit-scrollbar]:hidden">
				<?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
					<div class="w-[85%] shrink-0 snap-start sm:w-[calc(50%-8px)] lg:w-[calc(33.333%-11px)]">
						<?php get_template_part( 'template-parts/review-card' ); ?>
					</div>
				<?php endwhile; ?>
			</div>

			<?php if ( $next ) : ?>
				<button type="button" data-carousel-next class="absolute -right-4 top-1/2 z-10 hidden h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-border bg-white text-primary shadow-soft hover:bg-secondary xl:flex" aria-label="<?php echo esc_attr( $next ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
				</button>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>

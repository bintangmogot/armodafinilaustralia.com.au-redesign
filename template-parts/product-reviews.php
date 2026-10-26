<?php
/**
 * Reviews of one product from the `reviews` post type. Shows the real average, the real star
 * split and the latest five reviews, with a load more button. Nothing is shown without reviews.
 *
 * @package Armodafinil_Australia
 */

$product_id = get_the_ID();
$per_page   = 5;

$query = new WP_Query( array(
	'post_type'      => 'reviews',
	'post_status'    => 'publish',
	'posts_per_page' => $per_page,
	'orderby'        => 'date',
	'order'          => 'DESC',
	'meta_query'     => array( array( 'key' => 'linked_product', 'value' => $product_id ) ),
) );
$total = (int) $query->found_posts;
if ( ! $total ) {
	wp_reset_postdata();
	return;
}

$summary = armo_product_rating_summary( $product_id );
$split   = array( 5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0 );
$all_ids = get_posts( array( 'post_type' => 'reviews', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true, 'meta_query' => array( array( 'key' => 'linked_product', 'value' => $product_id ) ) ) );
foreach ( $all_ids as $review_id ) {
	$stars = (int) round( (float) get_post_meta( $review_id, 'rating', true ) );
	if ( $stars >= 1 && $stars <= 5 ) {
		++$split[ $stars ];
	}
}

$heading     = armo_label( 'label_reviews_heading' );
$stars_label = armo_label( 'label_star_count' );
$load_more   = armo_label( 'label_load_more' );
$loading     = armo_label( 'label_loading' );
?>
<section class="section bg-secondary/60" id="reviews">
	<div class="container-site">
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="grid gap-8 lg:grid-cols-[320px_1fr] lg:gap-12">
			<aside class="h-fit rounded-2xl border border-border bg-white p-6">
				<p class="font-heading text-5xl font-bold leading-none text-primary"><?php echo esc_html( number_format_i18n( $summary['average'], 1 ) ); ?></p>
				<div class="mt-2"><?php echo armo_stars_html( (int) round( $summary['average'] ), 20 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<p class="mt-1 text-sm text-muted-foreground"><?php echo (int) $summary['count']; ?></p>
				<ul class="m-0 mt-5 list-none space-y-2 p-0">
					<?php foreach ( $split as $star => $count ) : ?>
						<?php $percent = $summary['count'] ? round( $count / $summary['count'] * 100 ) : 0; ?>
						<li class="flex items-center gap-3 text-sm text-muted-foreground">
							<span class="w-16 shrink-0"><?php echo (int) $star; ?><?php echo $stars_label ? ' ' . esc_html( $stars_label ) : ''; ?></span>
							<span class="h-2 flex-1 overflow-hidden rounded-full bg-secondary"><span class="block h-full rounded-full bg-star" style="width: <?php echo (int) $percent; ?>%"></span></span>
							<span class="w-10 shrink-0 text-right"><?php echo (int) $percent; ?>%</span>
						</li>
					<?php endforeach; ?>
				</ul>
			</aside>

			<div>
				<div id="product-reviews-list" class="flex flex-col gap-4" data-product="<?php echo (int) $product_id; ?>" data-ajax="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-page="1" data-loading="<?php echo esc_attr( $loading ); ?>">
					<?php while ( $query->have_posts() ) : $query->the_post(); ?>
						<?php get_template_part( 'template-parts/review-card' ); ?>
					<?php endwhile; ?>
				</div>
				<?php if ( $query->max_num_pages > 1 && $load_more ) : ?>
					<div class="mt-8 text-center"><button type="button" id="product-reviews-more" class="btn-outline"><?php echo esc_html( $load_more ); ?></button></div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>

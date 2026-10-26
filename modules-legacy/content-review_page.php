<?php
/**
 * Module: review_page (modules field). Carries the page H1.
 * Fields: heading. Lists general reviews (not tied to one product), 5 per page, with load more.
 *
 * @package Armodafinil_Australia
 */

$heading  = get_sub_field( 'heading' );
$paged    = max( 1, (int) get_query_var( 'paged' ) );
$per_page = 5;
$general  = array(
	'relation' => 'OR',
	array( 'key' => 'linked_product', 'compare' => 'NOT EXISTS' ),
	array( 'key' => 'linked_product', 'value' => '', 'compare' => '=' ),
);

$reviews = new WP_Query( array(
	'post_type'      => 'reviews',
	'posts_per_page' => $per_page,
	'paged'          => $paged,
	'post_status'    => 'publish',
	'meta_query'     => $general,
) );

$total = (int) $reviews->found_posts;
$ids   = get_posts( array( 'post_type' => 'reviews', 'post_status' => 'publish', 'posts_per_page' => -1, 'fields' => 'ids', 'no_found_rows' => true, 'meta_query' => $general ) );
$sum   = 0;
$rated = 0;
foreach ( $ids as $review_id ) {
	$value = (int) get_post_meta( $review_id, 'rating', true );
	if ( $value > 0 ) {
		$sum += $value;
		++$rated;
	}
}
$average = $rated ? round( $sum / $rated, 1 ) : 0;
$end     = min( $paged * $per_page, $total );

$showing_tpl = armo_label( 'label_showing_reviews' );
$from_tpl    = armo_label( 'label_rating_from' );
$showing     = $showing_tpl ? str_replace( array( '{shown}', '{total}' ), array( $end, $total ), $showing_tpl ) : '';
$from        = $from_tpl ? str_replace( '{total}', $total, $from_tpl ) : '';
$load_more   = armo_label( 'label_load_more' );
$loading     = armo_label( 'label_loading' );

if ( ! $reviews->have_posts() && ! $heading ) {
	wp_reset_postdata();
	return;
}
?>
<section class="section bg-white">
	<div class="container-site">
		<?php if ( $heading ) : ?>
			<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>

		<div class="mt-8 grid gap-8 lg:mt-12 lg:grid-cols-[260px_1fr] lg:gap-14" id="reviews-wrapper" data-showing="<?php echo esc_attr( $showing_tpl ); ?>" data-total="<?php echo (int) $total; ?>" data-per-page="<?php echo (int) $per_page; ?>" data-loading="<?php echo esc_attr( $loading ); ?>">
			<aside class="lg:sticky lg:top-28 lg:self-start">
				<?php if ( $average > 0 ) : ?>
					<div class="flex items-center gap-4 lg:flex-col lg:items-start">
						<p class="font-heading text-6xl font-bold leading-none text-primary"><?php echo esc_html( number_format_i18n( $average, 1 ) ); ?></p>
						<div>
							<?php echo armo_stars_html( (int) round( $average ), 22 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
							<?php if ( $from ) : ?><p class="mt-1.5 text-sm font-medium text-muted-foreground"><?php echo esc_html( $from ); ?></p><?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
				<?php if ( $showing ) : ?>
					<p class="mt-5 text-xs font-semibold uppercase tracking-wide text-muted-foreground" id="aggregate-count-display"><?php echo esc_html( $showing ); ?></p>
				<?php endif; ?>
			</aside>

			<div>
				<div id="reviews-container" class="flex flex-col gap-4">
					<?php if ( $reviews->have_posts() ) : ?>
						<?php while ( $reviews->have_posts() ) : $reviews->the_post(); ?>
							<?php get_template_part( 'template-parts/review-card' ); ?>
						<?php endwhile; ?>
					<?php elseif ( armo_label( 'label_no_reviews' ) ) : ?>
						<p class="text-muted-foreground"><?php echo esc_html( armo_label( 'label_no_reviews' ) ); ?></p>
					<?php endif; ?>
				</div>

				<div id="reviews-pagination" class="mt-8 flex flex-col items-center gap-4">
					<?php if ( $reviews->max_num_pages > $paged && $load_more ) : ?>
						<a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>" id="load-more-btn" class="btn-outline"><?php echo esc_html( $load_more ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>

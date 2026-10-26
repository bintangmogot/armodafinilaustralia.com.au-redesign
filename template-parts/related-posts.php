<?php
/**
 * Related posts: three more posts from the same category. Heading from Theme Settings.
 *
 * @package Armodafinil_Australia
 */

if ( ! is_single() || 'post' !== get_post_type() ) {
	return;
}
$categories = get_the_category();
if ( empty( $categories ) ) {
	return;
}

$related = new WP_Query( array(
	'post_type'      => 'post',
	'posts_per_page' => 3,
	'post__not_in'   => array( get_the_ID() ),
	'category__in'   => wp_list_pluck( $categories, 'term_id' ),
	'no_found_rows'  => true,
) );
if ( ! $related->have_posts() ) {
	return;
}
$heading = armo_label( 'label_related_posts' );
?>
<section class="section border-t border-border bg-secondary">
	<div class="container-site">
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>
		<div class="grid gap-6 md:grid-cols-3">
			<?php while ( $related->have_posts() ) : $related->the_post(); ?>
				<?php get_template_part( 'template-parts/post-card' ); ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>
<?php wp_reset_postdata(); ?>

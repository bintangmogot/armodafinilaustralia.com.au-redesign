<?php
/**
 * Module: featured_blog (modules field).
 * Fields: intro_content (wysiwyg). Shows the latest three posts (or those tagged "featured").
 *
 * @package Armodafinil_Australia
 */

$intro_content = get_sub_field( 'intro_content' );
$recent        = new WP_Query( array( 'posts_per_page' => 3, 'post_type' => 'post', 'post_status' => 'publish', 'tag' => 'featured', 'no_found_rows' => true ) );
if ( ! $recent->have_posts() ) {
	$recent = new WP_Query( array( 'posts_per_page' => 3, 'post_type' => 'post', 'post_status' => 'publish', 'no_found_rows' => true ) );
}
if ( ! $recent->have_posts() ) {
	return;
}
?>
<section class="section bg-secondary">
	<div class="container-site">
		<?php if ( $intro_content ) : ?>
			<div class="armo-prose mx-auto mb-10 max-w-3xl text-center"><?php echo wp_kses_post( armo_content( $intro_content ) ); ?></div>
		<?php endif; ?>
		<div class="grid gap-6 md:grid-cols-3">
			<?php while ( $recent->have_posts() ) : $recent->the_post(); ?>
				<?php get_template_part( 'template-parts/post-card' ); ?>
			<?php endwhile; ?>
		</div>
		<?php wp_reset_postdata(); ?>
	</div>
</section>

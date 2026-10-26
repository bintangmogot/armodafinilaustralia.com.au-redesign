<?php
/**
 * Search results (posts and pages; product search uses the header search dialog).
 *
 * @package Armodafinil_Australia
 */

get_header();
$template = armo_label( 'label_search_results' );
$heading  = $template ? str_replace( '{query}', get_search_query(), $template ) : get_search_query();
?>
<main id="primary" class="site-main">
	<header class="border-b border-border bg-secondary">
		<div class="container-site py-10 md:py-14">
			<h1 class="font-heading text-[clamp(1.75rem,1.4rem+2vw,2.75rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( $heading ); ?></h1>
		</div>
	</header>

	<section class="section bg-white">
		<div class="container-site">
			<?php if ( have_posts() ) : ?>
				<div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
					<?php while ( have_posts() ) : the_post(); ?>
						<?php get_template_part( 'template-parts/post-card' ); ?>
					<?php endwhile; ?>
				</div>
				<?php get_template_part( 'template-parts/pagination' ); ?>
			<?php elseif ( armo_label( 'label_no_results_page' ) ) : ?>
				<p class="text-muted-foreground"><?php echo esc_html( armo_label( 'label_no_results_page' ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

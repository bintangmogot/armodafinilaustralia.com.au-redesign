<?php
/**
 * Category, tag and date archives of posts.
 *
 * @package Armodafinil_Australia
 */

get_header();
$description = get_the_archive_description();
?>
<main id="primary" class="site-main">
	<header class="border-b border-border bg-secondary">
		<div class="container-site py-10 text-center md:py-14">
			<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( wp_strip_all_tags( get_the_archive_title() ) ); ?></h1>
			<?php if ( $description ) : ?><div class="section-lead"><?php echo wp_kses_post( $description ); ?></div><?php endif; ?>
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
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

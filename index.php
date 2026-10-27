<?php
/**
 * Blog index (Settings > Reading > Posts page). Heading and intro come from Theme Settings > Blog,
 * falling back to the page title.
 *
 * @package Armodafinil_Australia
 */

get_header();

$page_id     = (int) get_option( 'page_for_posts' );
$blog_title  = get_field( 'blog_title', 'option' ) ?: ( $page_id ? get_the_title( $page_id ) : get_bloginfo( 'name' ) );
$subtitle    = get_field( 'blog_subtitle', 'option' );
$description = get_field( 'blog_description', 'option' );
?>
<main id="primary" class="site-main">
	<header class="border-b border-border bg-secondary">
		<div class="container-site py-10 text-center md:py-14">
			<?php if ( $subtitle ) : ?><p class="badge"><?php echo esc_html( $subtitle ); ?></p><?php endif; ?>
			<h1 class="mt-3 font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( $blog_title ); ?></h1>
			<?php if ( $description ) : ?><p class="section-lead"><?php echo esc_html( $description ); ?></p><?php endif; ?>
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
			<?php elseif ( armo_label( 'label_no_products' ) ) : ?>
				<p class="text-center text-muted-foreground"><?php echo esc_html( armo_label( 'label_no_products' ) ); ?></p>
			<?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

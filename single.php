<?php
/**
 * Single blog post. Content lives in the post's ACF modules (older posts) or the editor.
 *
 * @package Armodafinil_Australia
 */

get_header();
?>
<main id="primary" class="site-main">
	<?php while ( have_posts() ) : the_post(); ?>
		<?php
		$thumb_id   = get_post_thumbnail_id();
		$categories = get_the_category();
		$category   = $categories ? $categories[0] : null;
		?>
		<article>
			<header class="border-b border-border bg-secondary">
				<div class="container-site mx-auto max-w-4xl py-10 text-center md:py-14">
					<?php if ( $category ) : ?>
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" class="badge"><?php echo esc_html( $category->name ); ?></a>
					<?php endif; ?>
					<h1 class="mt-4 font-heading text-[clamp(1.875rem,1.4rem+2.4vw,3rem)] font-bold leading-[1.12] text-primary"><?php the_title(); ?></h1>
					<time class="mt-4 block text-sm text-muted-foreground" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
				</div>
			</header>

			<?php if ( $thumb_id ) : ?>
				<div class="container-site mx-auto max-w-4xl pt-8 md:pt-10">
					<?php echo wp_get_attachment_image( $thumb_id, 'large', false, array( 'class' => 'h-auto w-full rounded-2xl border border-border', 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?>
				</div>
			<?php endif; ?>

			<?php
			ob_start();
			$has_modules = armo_render_modules();
			$modules     = ob_get_clean();
			if ( $has_modules ) {
				echo $modules; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside the module templates.
			} else {
				echo '<section class="section bg-white"><div class="container-site"><div class="armo-prose mx-auto max-w-3xl">';
				the_content();
				echo '</div></div></section>';
			}
			?>

			<?php $tags = get_the_tags(); ?>
			<?php if ( $tags ) : ?>
				<div class="container-site mx-auto max-w-3xl pb-8">
					<ul class="m-0 flex list-none flex-wrap gap-2 p-0">
						<?php foreach ( $tags as $tag ) : ?>
							<li><a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="badge normal-case tracking-normal hover:bg-white"><?php echo esc_html( $tag->name ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		</article>
	<?php endwhile; ?>

	<?php get_template_part( 'template-parts/related-posts' ); ?>
</main>
<?php
get_footer();

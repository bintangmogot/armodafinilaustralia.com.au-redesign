<?php
/**
 * Blog post card (inside a WP loop).
 *
 * @package Armodafinil_Australia
 */

$thumb_id = get_post_thumbnail_id();
?>
<article class="group flex h-full flex-col overflow-hidden rounded-2xl border border-border bg-white transition-shadow hover:shadow-card">
	<?php if ( $thumb_id ) : ?>
		<a href="<?php the_permalink(); ?>" class="block aspect-[16/10] overflow-hidden bg-secondary" tabindex="-1" aria-hidden="true">
			<?php echo wp_get_attachment_image( $thumb_id, 'medium_large', false, array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?>
		</a>
	<?php endif; ?>
	<div class="flex flex-1 flex-col p-5">
		<time class="text-xs font-medium uppercase tracking-wide text-muted-foreground" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
		<h3 class="mt-2 font-heading text-lg font-semibold leading-snug text-primary"><a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a></h3>
		<p class="mt-2 line-clamp-3 text-sm leading-relaxed text-muted-foreground"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 28, '...' ) ); ?></p>
	</div>
</article>

<?php
/**
 * One review (inside a WP loop over the `reviews` post type).
 * Fields: rating, name (ACF). Title and text come from the post.
 *
 * @package Armodafinil_Australia
 */

$rating   = (int) get_field( 'rating' );
$name     = get_field( 'name' ) ?: get_the_title();
$verified = armo_label( 'label_verified' );
$text     = get_the_content();
?>
<article class="flex h-full flex-col rounded-2xl border border-border bg-white p-6">
	<div class="flex items-start justify-between gap-3">
		<div>
			<p class="font-heading text-base font-semibold text-primary"><?php echo esc_html( $name ); ?></p>
			<?php if ( $verified ) : ?>
				<p class="mt-0.5 flex items-center gap-1 text-xs font-medium text-success">
					<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>
					<?php echo esc_html( $verified ); ?>
				</p>
			<?php endif; ?>
		</div>
		<?php if ( $rating > 0 ) : ?>
			<?php echo armo_stars_html( $rating ); // phpcs:ignore WordPress.Security.EscapeOutput -- built from integers. ?>
		<?php endif; ?>
	</div>
	<?php if ( get_the_title() && get_field( 'name' ) ) : ?>
		<h3 class="mt-4 font-heading text-base font-semibold text-primary"><?php the_title(); ?></h3>
	<?php endif; ?>
	<?php if ( $text ) : ?>
		<div class="mt-2 text-[15px] leading-relaxed text-muted-foreground [&>p:last-child]:mb-0"><?php echo wp_kses_post( wpautop( $text ) ); ?></div>
	<?php endif; ?>
</article>

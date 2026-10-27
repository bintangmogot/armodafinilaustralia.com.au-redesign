<?php
/**
 * Module: final_thoughts (modules field).
 * Fields: background_image, title, description, list_items (repeater: item_text), bottom_text, cta_text, cta_link
 *
 * @package Armodafinil_Australia
 */

$bg_image    = get_sub_field( 'background_image' );
$title       = get_sub_field( 'title' );
$description = get_sub_field( 'description' );
$bottom_text = get_sub_field( 'bottom_text' );
$cta_text    = get_sub_field( 'cta_text' );
$cta_link    = get_sub_field( 'cta_link' );
$bg_id       = is_array( $bg_image ) ? (int) ( $bg_image['ID'] ?? 0 ) : (int) $bg_image;

if ( ! $title && ! $description && ! $cta_text ) {
	return;
}
?>
<section class="relative isolate overflow-hidden bg-primary py-14 text-white md:py-20">
	<?php if ( $bg_id ) : ?>
		<?php echo wp_get_attachment_image( $bg_id, 'large', false, array( 'alt' => '', 'class' => 'absolute inset-0 -z-20 h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
		<div class="absolute inset-0 -z-10 bg-primary/85"></div>
	<?php endif; ?>

	<div class="container-site">
		<div class="max-w-3xl">
			<?php if ( $title ) : ?>
				<h2 class="font-heading text-3xl font-bold text-white md:text-4xl"><?php echo esc_html( $title ); ?></h2>
			<?php endif; ?>
			<?php if ( $description ) : ?>
				<div class="mt-4 text-base leading-relaxed text-white/85 md:text-lg"><?php echo wp_kses_post( nl2br( esc_html( $description ) ) ); ?></div>
			<?php endif; ?>

			<?php if ( have_rows( 'list_items' ) ) : ?>
				<ul class="m-0 mt-6 list-none space-y-3 p-0">
					<?php while ( have_rows( 'list_items' ) ) : the_row(); ?>
						<?php $item_text = get_sub_field( 'item_text' ); ?>
						<?php if ( $item_text ) : ?>
							<li class="flex items-start gap-3 text-base text-white md:text-lg">
								<span class="mt-1 inline-flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-accent text-primary" aria-hidden="true">
									<svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
								</span>
								<span><?php echo esc_html( $item_text ); ?></span>
							</li>
						<?php endif; ?>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>
		</div>

		<?php if ( $bottom_text || ( $cta_text && $cta_link ) ) : ?>
			<div class="mt-10 flex flex-col items-start justify-between gap-6 border-t border-white/20 pt-8 md:flex-row md:items-center">
				<?php if ( $bottom_text ) : ?>
					<p class="max-w-lg font-heading text-xl font-semibold leading-snug text-white md:text-2xl"><?php echo esc_html( $bottom_text ); ?></p>
				<?php endif; ?>
				<?php if ( $cta_text && $cta_link ) : ?>
					<a href="<?php echo esc_url( $cta_link ); ?>" class="btn-buy h-14 px-7 text-base">
						<?php echo esc_html( $cta_text ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
					</a>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

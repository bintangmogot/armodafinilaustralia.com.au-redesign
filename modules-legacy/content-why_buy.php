<?php
/**
 * Module: why_buy (modules field).
 * Fields: heading, intro (wysiwyg), features (repeater: icon image, title, content)
 *
 * @package Armodafinil_Australia
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );

if ( ! $heading && ! have_rows( 'features' ) ) {
	return;
}
?>
<section class="section bg-white">
	<div class="container-site">
		<?php if ( $heading || $intro ) : ?>
			<div class="mb-8 max-w-3xl md:mb-12">
				<?php if ( $heading ) : ?>
					<h2 class="section-title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $intro ) : ?>
					<div class="armo-prose mt-4"><?php echo wp_kses_post( armo_content( $intro ) ); ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( have_rows( 'features' ) ) : ?>
			<div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3 lg:gap-6">
				<?php while ( have_rows( 'features' ) ) : the_row(); ?>
					<?php
					$icon          = get_sub_field( 'icon' );
					$feature_title = get_sub_field( 'title' );
					$feature_text  = get_sub_field( 'content' );
					$icon_id       = is_array( $icon ) ? (int) ( $icon['ID'] ?? 0 ) : (int) $icon;
					?>
					<div class="rounded-2xl border border-border bg-secondary p-6 lg:p-7">
						<?php if ( $icon_id ) : ?>
							<span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-xl bg-white">
								<?php echo wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'class' => 'h-7 w-7 object-contain', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => '' ) ); ?>
							</span>
						<?php endif; ?>
						<?php if ( $feature_title ) : ?>
							<h3 class="font-heading text-lg font-semibold leading-snug text-primary"><?php echo esc_html( $feature_title ); ?></h3>
						<?php endif; ?>
						<?php if ( $feature_text ) : ?>
							<p class="mt-2 text-base leading-relaxed text-muted-foreground"><?php echo esc_html( $feature_text ); ?></p>
						<?php endif; ?>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

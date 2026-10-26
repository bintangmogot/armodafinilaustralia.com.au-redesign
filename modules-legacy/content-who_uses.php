<?php
/**
 * Module: who_uses (modules field).
 * Fields: heading, intro (wysiwyg), users (repeater: title, image, description)
 *
 * @package Armodafinil_Australia
 */

$heading = get_sub_field( 'heading' );
$intro   = get_sub_field( 'intro' );

if ( ! $heading && ! have_rows( 'users' ) ) {
	return;
}
?>
<section class="section bg-secondary">
	<div class="container-site">
		<?php if ( $heading || $intro ) : ?>
			<div class="mx-auto mb-8 max-w-3xl text-center md:mb-12">
				<?php if ( $heading ) : ?>
					<h2 class="section-title"><?php echo esc_html( $heading ); ?></h2>
				<?php endif; ?>
				<?php if ( $intro ) : ?>
					<div class="armo-prose mt-4"><?php echo wp_kses_post( armo_content( $intro ) ); ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( have_rows( 'users' ) ) : ?>
			<div class="grid grid-cols-2 gap-3 md:gap-5 lg:grid-cols-4">
				<?php while ( have_rows( 'users' ) ) : the_row(); ?>
					<?php
					$user_title = get_sub_field( 'title' );
					$user_text  = get_sub_field( 'description' ) ?: ( get_sub_field( 'text' ) ?: get_sub_field( 'content' ) );
					$image      = get_sub_field( 'image' );
					$image_id   = is_array( $image ) ? (int) ( $image['ID'] ?? 0 ) : (int) $image;
					?>
					<div class="flex flex-col overflow-hidden rounded-2xl border border-border bg-white">
						<?php if ( $image_id ) : ?>
							<div class="aspect-[4/3] overflow-hidden bg-secondary">
								<?php echo wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'h-full w-full object-cover', 'loading' => 'lazy', 'decoding' => 'async', 'alt' => $user_title ? $user_title : '' ) ); ?>
							</div>
						<?php endif; ?>
						<div class="flex flex-1 flex-col gap-1.5 p-4 md:p-5">
							<?php if ( $user_title ) : ?>
								<h3 class="font-heading text-sm font-semibold leading-snug text-primary md:text-base"><?php echo esc_html( $user_title ); ?></h3>
							<?php endif; ?>
							<?php if ( $user_text ) : ?>
								<p class="text-sm leading-relaxed text-muted-foreground"><?php echo esc_html( $user_text ); ?></p>
							<?php endif; ?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		<?php endif; ?>
	</div>
</section>

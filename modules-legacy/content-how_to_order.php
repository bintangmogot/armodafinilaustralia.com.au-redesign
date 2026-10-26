<?php
/**
 * Module: how_to_order (modules field).
 * Fields: heading, steps (repeater: title, description), safety_title, safety_text (wysiwyg)
 *
 * @package Armodafinil_Australia
 */

$heading      = get_sub_field( 'heading' );
$safety_title = get_sub_field( 'safety_title' );
$safety_text  = get_sub_field( 'safety_text' );

if ( ! have_rows( 'steps' ) && ! $heading && ! $safety_text ) {
	return;
}
?>
<section class="section bg-white">
	<div class="container-site">
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<?php if ( have_rows( 'steps' ) ) : ?>
			<ol class="m-0 grid list-none grid-cols-1 gap-4 p-0 md:grid-cols-2 lg:grid-cols-4 lg:gap-6">
				<?php $count = 1; ?>
				<?php while ( have_rows( 'steps' ) ) : the_row(); ?>
					<?php
					$step_title = get_sub_field( 'title' );
					$step_text  = get_sub_field( 'description' );
					if ( ! $step_title && ! $step_text ) {
						continue;
					}
					?>
					<li class="rounded-2xl border border-border bg-secondary p-6">
						<span class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-primary font-heading text-base font-bold text-white"><?php echo (int) $count; ?></span>
						<?php if ( $step_title ) : ?>
							<h3 class="mt-4 font-heading text-lg font-semibold text-primary"><?php echo esc_html( $step_title ); ?></h3>
						<?php endif; ?>
						<?php if ( $step_text ) : ?>
							<p class="mt-2 text-base leading-relaxed text-muted-foreground"><?php echo esc_html( $step_text ); ?></p>
						<?php endif; ?>
					</li>
					<?php ++$count; ?>
				<?php endwhile; ?>
			</ol>
		<?php endif; ?>

		<?php if ( $safety_text ) : ?>
			<div class="mx-auto mt-8 max-w-3xl rounded-xl border border-border bg-white p-5 md:p-6">
				<?php if ( $safety_title ) : ?>
					<h3 class="font-heading text-lg font-semibold text-primary"><?php echo esc_html( $safety_title ); ?></h3>
				<?php endif; ?>
				<div class="armo-prose mt-2"><?php echo wp_kses_post( armo_content( $safety_text ) ); ?></div>
			</div>
		<?php endif; ?>
	</div>
</section>

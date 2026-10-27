<?php
/**
 * Closing call-to-action band. Text and links come from Theme Settings > Closing CTA.
 *
 * @package Armodafinil_Australia
 */

$heading   = get_field( 'cta_heading', 'option' );
$text      = get_field( 'cta_text', 'option' );
$primary   = get_field( 'cta_button_label', 'option' );
$primary_u = get_field( 'cta_button_url', 'option' );
$second    = get_field( 'cta_secondary_label', 'option' );
$second_u  = get_field( 'cta_secondary_url', 'option' );

if ( ! $heading ) {
	return;
}
?>
<section class="bg-primary py-14 text-white md:py-20">
	<div class="container-site mx-auto max-w-3xl text-center">
		<h2 class="font-heading text-[clamp(1.75rem,1.3rem+2vw,2.75rem)] font-bold leading-[1.15] text-white"><?php echo esc_html( $heading ); ?></h2>
		<?php if ( $text ) : ?>
			<p class="mx-auto mt-4 max-w-xl text-base text-white/80 md:text-lg"><?php echo esc_html( $text ); ?></p>
		<?php endif; ?>
		<div class="mt-8 flex flex-wrap items-center justify-center gap-3">
			<?php if ( $primary && $primary_u ) : ?>
				<a href="<?php echo esc_url( $primary_u ); ?>" class="btn-buy h-14 px-8 text-base"><?php echo esc_html( $primary ); ?></a>
			<?php endif; ?>
			<?php if ( $second && $second_u ) : ?>
				<a href="<?php echo esc_url( $second_u ); ?>" class="btn h-14 border border-white/40 px-8 text-base text-white hover:bg-white/10"><?php echo esc_html( $second ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</section>

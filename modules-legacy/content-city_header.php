<?php
/**
 * Module: city_header (modules field). Opens a city page, so it carries the page H1.
 * Fields: heading, subheading, content (wysiwyg), delivery_text, button_text, button_link, background_color
 *
 * @package Armodafinil_Australia
 */

$heading          = get_sub_field( 'heading' );
$subheading       = get_sub_field( 'subheading' );
$content          = get_sub_field( 'content' );
$delivery_text    = get_sub_field( 'delivery_text' );
$button_text      = get_sub_field( 'button_text' );
$button_link      = get_sub_field( 'button_link' );
$background_color = get_sub_field( 'background_color' );

if ( ! $heading && ! $content ) {
	return;
}
?>
<section class="section <?php echo $background_color ? '' : 'bg-secondary'; ?>"<?php echo $background_color ? ' style="background-color: ' . esc_attr( $background_color ) . ';"' : ''; ?>>
	<div class="container-site mx-auto max-w-4xl text-center">
		<?php if ( $heading ) : ?>
			<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( $heading ); ?></h1>
		<?php endif; ?>
		<?php if ( $subheading ) : ?>
			<p class="mt-3 font-heading text-xl font-semibold text-brand-500 md:text-2xl"><?php echo esc_html( $subheading ); ?></p>
		<?php endif; ?>
		<?php if ( $content ) : ?>
			<div class="armo-prose mt-6 max-w-none"><?php echo wp_kses_post( armo_content( $content ) ); ?></div>
		<?php endif; ?>
		<?php if ( $delivery_text ) : ?>
			<p class="mt-6 inline-flex items-center gap-2 font-semibold text-primary">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
				<span><?php echo esc_html( $delivery_text ); ?></span>
			</p>
		<?php endif; ?>
		<?php if ( $button_text && $button_link ) : ?>
			<div class="mt-6"><a href="<?php echo esc_url( $button_link ); ?>" class="btn-buy"><?php echo esc_html( $button_text ); ?></a></div>
		<?php endif; ?>
	</div>
</section>

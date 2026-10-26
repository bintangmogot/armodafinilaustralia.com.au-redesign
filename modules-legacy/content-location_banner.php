<?php
/**
 * Module: location_banner (modules field).
 * Fields: title, content (wysiwyg), button, button_link
 *
 * @package Armodafinil_Australia
 */

$title       = get_sub_field( 'title' );
$content     = get_sub_field( 'content' );
$button_text = get_sub_field( 'button' ) ?: get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );

if ( ! $title && ! $content ) {
	return;
}
?>
<section class="section bg-primary text-white">
	<div class="container-site max-w-[1000px]">
		<?php if ( $title ) : ?>
			<h2 class="font-heading text-2xl font-bold text-white md:text-3xl"><?php echo esc_html( $title ); ?></h2>
		<?php endif; ?>
		<?php if ( $content ) : ?>
			<div class="armo-prose mt-4 max-w-none text-base text-white/85 md:text-lg [&_a]:text-white [&_p]:text-white/85 [&_strong]:text-white"><?php echo wp_kses_post( armo_content( $content ) ); ?></div>
		<?php endif; ?>
		<?php if ( $button_text && $button_link ) : ?>
			<a href="<?php echo esc_url( $button_link ); ?>" class="btn-buy mt-6"><?php echo esc_html( $button_text ); ?></a>
		<?php endif; ?>
	</div>
</section>

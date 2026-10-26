<?php
/**
 * Module: contact (modules field).
 * Fields: form (wysiwyg or shortcode), email, phone, address (wysiwyg), map (iframe embed)
 *
 * @package Armodafinil_Australia
 */

$form    = get_sub_field( 'form' );
$email   = get_sub_field( 'email' );
$phone   = get_sub_field( 'phone' );
$address = get_sub_field( 'address' );
$map     = get_sub_field( 'map' );

if ( ! $form && ! $email && ! $phone && ! $address && ! $map ) {
	return;
}
?>
<section class="section bg-secondary">
	<div class="container-site grid gap-6 lg:grid-cols-2 lg:gap-10">
		<?php if ( $email || $phone || $address || $map ) : ?>
			<div class="h-fit space-y-5 rounded-2xl border border-border bg-white p-6 md:p-8">
				<?php if ( $email ) : ?>
					<a href="mailto:<?php echo esc_attr( $email ); ?>" class="block text-lg font-semibold text-primary hover:underline"><?php echo esc_html( $email ); ?></a>
				<?php endif; ?>
				<?php if ( $phone ) : ?>
					<a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>" class="block text-lg font-semibold text-primary hover:underline"><?php echo esc_html( $phone ); ?></a>
				<?php endif; ?>
				<?php if ( $address ) : ?>
					<div class="armo-prose"><?php echo wp_kses_post( armo_content( $address ) ); ?></div>
				<?php endif; ?>
				<?php if ( $map ) : ?>
					<div class="h-[260px] overflow-hidden rounded-xl border border-border lg:h-[300px] [&>iframe]:h-full [&>iframe]:w-full"><?php echo $map; // phpcs:ignore WordPress.Security.EscapeOutput -- iframe embed entered by an administrator. ?></div>
				<?php endif; ?>
			</div>
		<?php endif; ?>

		<?php if ( $form ) : ?>
			<div class="armo-prose rounded-2xl border border-border bg-white p-6 md:p-8"><?php echo armo_content( $form ); // phpcs:ignore WordPress.Security.EscapeOutput -- form plugin markup. ?></div>
		<?php endif; ?>
	</div>
</section>

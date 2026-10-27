<?php
/**
 * Site footer. Every visible word comes from Theme Settings or Appearance > Menus.
 *
 * @package Armodafinil_Australia
 */

$is_checkout = function_exists( 'is_checkout' ) && is_checkout() && ! is_wc_endpoint_url( 'order-received' );
$logo_id     = (int) get_theme_mod( 'custom_logo' );
$logo_alt    = get_field( 'header_logo_alt', 'option' ) ?: get_bloginfo( 'name' );
$about       = get_field( 'footer_description', 'option' );
$delivery    = get_field( 'footer_text', 'option' );
$phone       = get_field( 'footer_direct_helpline', 'option' );
$whatsapp    = get_field( 'footer_whatsapp', 'option' );
$wa_url      = armo_whatsapp_url();
$email       = get_field( 'footer_email', 'option' );
$address     = get_field( 'footer_corporate_registry', 'option' );
$facebook    = get_field( 'footer_facebook', 'option' );
$linkedin    = get_field( 'footer_linkedin', 'option' );
$disclaimer  = get_field( 'footer_disclaimer', 'option' );
$payments    = get_field( 'footer_payment_images', 'option' );
$shipping    = get_field( 'footer_shipping_images', 'option' );
$copyright   = get_field( 'footer_copyright', 'option' );
$columns     = array(
	array( 'location' => 'footer', 'heading' => get_field( 'footer_menu_1_heading', 'option' ) ),
	array( 'location' => 'footer-quick', 'heading' => get_field( 'footer_menu_2_heading', 'option' ) ),
	array( 'location' => 'footer-important', 'heading' => get_field( 'footer_menu_3_heading', 'option' ) ),
);
if ( $copyright ) {
	$copyright = str_replace( array( '{year}', '{site_name}' ), array( gmdate( 'Y' ), get_bloginfo( 'name' ) ), $copyright );
}
$contact_icon = static function ( $path ) {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="mt-0.5 shrink-0 text-white/60">' . $path . '</svg>';
};
?>

<?php if ( ! $is_checkout ) : ?>
<footer class="mt-16 bg-primary text-white">
	<div class="container-site grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-[1.4fr_1fr_1fr_1fr]">

		<div>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block rounded-lg bg-white px-3 py-2">
				<?php if ( $logo_id ) : ?>
					<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => $logo_alt, 'class' => 'site-logo', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				<?php else : ?>
					<span class="font-heading text-lg font-bold text-primary"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</a>
			<?php if ( $about ) : ?>
				<p class="mt-4 max-w-md text-sm leading-relaxed text-white/75"><?php echo esc_html( $about ); ?></p>
			<?php endif; ?>
			<?php if ( $delivery ) : ?>
				<p class="mt-3 max-w-md text-sm leading-relaxed text-white/75"><?php echo esc_html( $delivery ); ?></p>
			<?php endif; ?>

			<ul class="m-0 mt-5 list-none space-y-2.5 p-0 text-sm text-white/85">
				<?php if ( $phone ) : ?>
					<li class="flex items-start gap-2.5"><?php echo $contact_icon( '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.91.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92z"/>' ); // phpcs:ignore ?>
						<a class="hover:text-white" href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $phone ) ); ?>"><?php echo esc_html( $phone ); ?></a></li>
				<?php endif; ?>
				<?php if ( $whatsapp && $wa_url ) : ?>
					<li class="flex items-start gap-2.5"><?php echo $contact_icon( '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>' ); // phpcs:ignore ?>
						<a class="hover:text-white" href="<?php echo esc_url( $wa_url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $whatsapp ); ?></a></li>
				<?php endif; ?>
				<?php if ( $email ) : ?>
					<li class="flex items-start gap-2.5"><?php echo $contact_icon( '<rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-10 5L2 7"/>' ); // phpcs:ignore ?>
						<a class="hover:text-white" href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_html( $email ); ?></a></li>
				<?php endif; ?>
				<?php if ( $address ) : ?>
					<li class="flex items-start gap-2.5"><?php echo $contact_icon( '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>' ); // phpcs:ignore ?>
						<span><?php echo esc_html( $address ); ?></span></li>
				<?php endif; ?>
			</ul>

			<?php if ( $facebook || $linkedin ) : ?>
				<div class="mt-5 flex items-center gap-2">
					<?php if ( $facebook ) : ?>
						<a href="<?php echo esc_url( $facebook ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 hover:bg-white/20" aria-label="Facebook">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M13.5 21v-7.5h2.6l.4-3h-3V8.6c0-.9.3-1.5 1.6-1.5H16.6V4.4c-.3 0-1.2-.1-2.3-.1-2.3 0-3.8 1.4-3.8 3.9v2.3H8v3h2.5V21h3z"/></svg>
						</a>
					<?php endif; ?>
					<?php if ( $linkedin ) : ?>
						<a href="<?php echo esc_url( $linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-lg bg-white/10 hover:bg-white/20" aria-label="LinkedIn">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M6.9 8.6H3.6V20h3.3V8.6zM5.3 3.3a1.9 1.9 0 1 0 0 3.8 1.9 1.9 0 0 0 0-3.8zM20.4 13.3c0-3.1-1.7-4.9-4.1-4.9-1.4 0-2.4.7-2.8 1.4V8.6h-3.3V20h3.3v-6.2c0-1.6.8-2.5 2.1-2.5 1.2 0 1.9.8 1.9 2.5V20h3.3l-.4-6.7z"/></svg>
						</a>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</div>

		<?php foreach ( $columns as $column ) : ?>
			<?php if ( ! has_nav_menu( $column['location'] ) ) { continue; } ?>
			<nav aria-label="<?php echo esc_attr( $column['heading'] ?: get_bloginfo( 'name' ) ); ?>">
				<?php if ( $column['heading'] ) : ?>
					<h2 class="mb-4 font-heading text-base font-semibold text-white"><?php echo esc_html( $column['heading'] ); ?></h2>
				<?php endif; ?>
				<?php
				wp_nav_menu( array(
					'theme_location' => $column['location'],
					'container'      => false,
					'items_wrap'     => '<ul class="m-0 list-none space-y-2.5 p-0">%3$s</ul>',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
				?>
			</nav>
		<?php endforeach; ?>
	</div>

	<?php if ( $disclaimer ) : ?>
		<div class="container-site pb-8">
			<div class="rounded-xl border border-white/15 bg-white/5 p-5 text-sm leading-relaxed text-white/80 md:p-6 [&_a]:text-white [&_a]:underline [&_p+p]:mt-3"><?php echo wp_kses_post( $disclaimer ); ?></div>
		</div>
	<?php endif; ?>

	<?php if ( ! empty( $payments ) || ! empty( $shipping ) ) : ?>
		<div class="container-site flex flex-wrap items-center gap-x-6 gap-y-3 border-t border-white/10 py-6">
			<?php foreach ( array_merge( (array) $payments, (array) $shipping ) as $image_id ) : ?>
				<span class="inline-flex h-9 items-center rounded-md bg-white px-2.5">
					<?php echo wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'h-6 w-auto max-w-[96px] object-contain', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				</span>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<?php if ( $copyright ) : ?>
		<div class="border-t border-white/10">
			<p class="container-site py-5 text-xs text-white/60"><?php echo esc_html( $copyright ); ?></p>
		</div>
	<?php endif; ?>
</footer>
<?php endif; ?>

</div><!-- #page -->

<?php get_template_part( 'template-parts/search-modal' ); ?>
<?php wp_footer(); ?>
</body>
</html>

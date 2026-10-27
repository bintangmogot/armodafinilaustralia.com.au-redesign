<?php
/**
 * Module: cta_button (modules field).
 * Fields: button_text, button_link (url)
 *
 * @package Armodafinil_Australia
 */

$button_text = get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );

if ( ! $button_text || ! $button_link ) {
	return;
}
?>
<section class="py-8 lg:py-12">
	<div class="container-site text-center">
		<a href="<?php echo esc_url( $button_link ); ?>" class="btn-buy h-14 px-8 text-base">
			<?php echo esc_html( $button_text ); ?>
			<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
		</a>
	</div>
</section>

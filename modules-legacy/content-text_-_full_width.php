<?php
/**
 * Module: text_-_full_width (modules field).
 * Fields: content (wysiwyg), background_color
 *
 * @package Armodafinil_Australia
 */

$content          = get_sub_field( 'content' );
$background_color = get_sub_field( 'background_color' );

if ( ! $content ) {
	return;
}
?>
<?php $in_post = is_singular( 'post' ); ?>
<section class="py-8 lg:py-12 <?php echo $background_color ? '' : ( $in_post ? 'bg-white' : 'bg-secondary' ); ?>"<?php echo $background_color ? ' style="background-color: ' . esc_attr( $background_color ) . ';"' : ''; ?>>
	<div class="container-site">
		<div class="armo-prose mx-auto <?php echo $in_post ? 'max-w-3xl text-left' : 'max-w-4xl text-center'; ?>"><?php echo wp_kses_post( armo_content( $content ) ); ?></div>
	</div>
</section>

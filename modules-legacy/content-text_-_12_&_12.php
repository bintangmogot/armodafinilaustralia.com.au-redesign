<?php
/**
 * Module: text_-_12_&_12 (modules field).
 * Fields: content_left (wysiwyg), content_right (wysiwyg)
 *
 * @package Armodafinil_Australia
 */

$content_left  = get_sub_field( 'content_left' );
$content_right = get_sub_field( 'content_right' );

if ( ! $content_left && ! $content_right ) {
	return;
}
?>
<section class="section bg-white">
	<div class="container-site grid gap-8 md:grid-cols-2 md:gap-12">
		<?php if ( $content_left ) : ?>
			<div class="armo-prose"><?php echo wp_kses_post( armo_content( $content_left ) ); ?></div>
		<?php endif; ?>
		<?php if ( $content_right ) : ?>
			<div class="armo-prose"><?php echo wp_kses_post( armo_content( $content_right ) ); ?></div>
		<?php endif; ?>
	</div>
</section>

<?php
/**
 * Module: text_left (modules field).
 * Fields: sections (repeater: content wysiwyg)
 *
 * @package Armodafinil_Australia
 */

if ( ! have_rows( 'sections' ) ) {
	return;
}
?>
<section class="section bg-white">
	<div class="container-site">
		<div class="mx-auto max-w-4xl divide-y divide-border">
			<?php while ( have_rows( 'sections' ) ) : the_row(); ?>
				<?php $section_content = get_sub_field( 'content' ); ?>
				<?php if ( $section_content ) : ?>
					<div class="armo-prose py-8 first:pt-0 last:pb-0"><?php echo wp_kses_post( armo_content( $section_content ) ); ?></div>
				<?php endif; ?>
			<?php endwhile; ?>
		</div>
	</div>
</section>

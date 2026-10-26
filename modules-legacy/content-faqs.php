<?php
/**
 * Module: faqs (modules field).
 * Fields: faq_title, faqs (repeater: question, answer wysiwyg)
 * Questions and answers are also printed as FAQPage structured data by inc/schema.php.
 *
 * @package Armodafinil_Australia
 */

$faq_title = get_sub_field( 'faq_title' );

if ( ! have_rows( 'faqs' ) ) {
	return;
}
?>
<section class="section bg-secondary">
	<div class="container-site">
		<?php if ( $faq_title ) : ?>
			<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $faq_title ); ?></h2>
		<?php endif; ?>

		<div class="mx-auto max-w-3xl space-y-3">
			<?php while ( have_rows( 'faqs' ) ) : the_row(); ?>
				<?php
				$question = get_sub_field( 'question' );
				$answer   = get_sub_field( 'answer' );
				if ( ! $question ) {
					continue;
				}
				?>
				<details class="group rounded-xl border border-border bg-white">
					<summary class="flex cursor-pointer list-none items-center justify-between gap-4 px-5 py-4 md:px-6">
						<h3 class="m-0 font-heading text-base font-semibold leading-snug text-primary md:text-lg"><?php echo esc_html( $question ); ?></h3>
						<span class="relative h-5 w-5 shrink-0 text-primary" aria-hidden="true">
							<span class="absolute left-0 top-1/2 h-0.5 w-5 -translate-y-1/2 bg-current"></span>
							<span class="absolute left-1/2 top-0 h-5 w-0.5 -translate-x-1/2 bg-current transition-transform group-open:scale-y-0"></span>
						</span>
					</summary>
					<?php if ( $answer ) : ?>
						<div class="armo-prose px-5 pb-5 md:px-6"><?php echo wp_kses_post( armo_content( $answer ) ); ?></div>
					<?php endif; ?>
				</details>
			<?php endwhile; ?>
		</div>
	</div>
</section>

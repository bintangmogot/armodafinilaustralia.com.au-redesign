<?php
/**
 * Module: review_form (modules field).
 * Fields: heading. Submits through admin-ajax (armo_submit_review); reviews arrive as drafts.
 * All labels come from Theme Settings > Interface Labels.
 *
 * @package Armodafinil_Australia
 */

$heading = get_sub_field( 'heading' );
$labels  = array(
	'rating'     => armo_label( 'label_form_rating' ),
	'title'      => armo_label( 'label_form_title' ),
	'title_ph'   => armo_label( 'label_form_title_ph' ),
	'review'     => armo_label( 'label_form_review' ),
	'review_ph'  => armo_label( 'label_form_review_ph' ),
	'name'       => armo_label( 'label_form_name' ),
	'name_ph'    => armo_label( 'label_form_name_ph' ),
	'email'      => armo_label( 'label_form_email' ),
	'email_ph'   => armo_label( 'label_form_email_ph' ),
	'submit'     => armo_label( 'label_form_submit' ),
	'submitting' => armo_label( 'label_form_submitting' ),
	'error'      => armo_label( 'label_form_error' ),
);

if ( ! $labels['submit'] ) {
	return;
}
$field_class = 'mt-1.5 w-full rounded-lg border border-border bg-white px-4 py-3 text-base text-foreground placeholder:text-muted-foreground focus:border-primary focus:outline-none focus:ring-2 focus:ring-ring/30';
$label_class = 'block text-sm font-semibold text-primary';
?>
<section class="section bg-secondary">
	<div class="container-site max-w-3xl">
		<?php if ( $heading ) : ?>
			<h2 class="section-title mb-8 text-center"><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<form id="armo-review-form" class="space-y-5 rounded-2xl border border-border bg-white p-6 md:p-8" data-ajax="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-submitting="<?php echo esc_attr( $labels['submitting'] ); ?>" data-error="<?php echo esc_attr( $labels['error'] ); ?>" novalidate>
			<?php wp_nonce_field( 'armo_submit_review', 'armo_review_nonce' ); ?>
			<input type="hidden" name="action" value="armo_submit_review">

			<?php if ( $labels['rating'] ) : ?>
				<fieldset>
					<legend class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $labels['rating'] ); ?></legend>
					<div class="mt-2 flex flex-row-reverse justify-end gap-1" id="armo-rating">
						<?php for ( $i = 5; $i >= 1; $i-- ) : ?>
							<input type="radio" name="review_rating" id="rating-<?php echo (int) $i; ?>" value="<?php echo (int) $i; ?>" class="peer sr-only" <?php checked( 5, $i ); ?>>
							<label for="rating-<?php echo (int) $i; ?>" class="cursor-pointer text-border transition-colors peer-checked:text-star peer-hover:text-star [&:has(~label:hover)]:text-star hover:text-star peer-focus-visible:ring-2">
								<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
							</label>
						<?php endfor; ?>
					</div>
				</fieldset>
			<?php endif; ?>

			<div>
				<label for="review_title" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $labels['title'] ); ?></label>
				<input type="text" id="review_title" name="review_title" required class="<?php echo esc_attr( $field_class ); ?>" placeholder="<?php echo esc_attr( $labels['title_ph'] ); ?>">
			</div>
			<div>
				<label for="review_content" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $labels['review'] ); ?></label>
				<textarea id="review_content" name="review_content" rows="5" required class="<?php echo esc_attr( $field_class ); ?>" placeholder="<?php echo esc_attr( $labels['review_ph'] ); ?>"></textarea>
			</div>
			<div class="grid gap-5 md:grid-cols-2">
				<div>
					<label for="review_name" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $labels['name'] ); ?></label>
					<input type="text" id="review_name" name="review_name" required class="<?php echo esc_attr( $field_class ); ?>" placeholder="<?php echo esc_attr( $labels['name_ph'] ); ?>">
				</div>
				<div>
					<label for="review_email" class="<?php echo esc_attr( $label_class ); ?>"><?php echo esc_html( $labels['email'] ); ?></label>
					<input type="email" id="review_email" name="review_email" required class="<?php echo esc_attr( $field_class ); ?>" placeholder="<?php echo esc_attr( $labels['email_ph'] ); ?>">
				</div>
			</div>

			<div id="armo-review-message" class="hidden rounded-lg p-4 text-sm font-medium" role="status"></div>
			<button type="submit" id="review-submit-btn" class="btn-buy w-full md:w-auto" data-label="<?php echo esc_attr( $labels['submit'] ); ?>"><?php echo esc_html( $labels['submit'] ); ?></button>
		</form>
	</div>
</section>

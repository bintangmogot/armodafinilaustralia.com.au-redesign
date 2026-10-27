<?php
/**
 * Usage note, informational warning and medical reviewer line under the product description.
 * Fields: usage_note_title, usage_note_text, informational_warning_text (product, then Theme Settings),
 * medical_reviewer_post (product).
 *
 * @package Armodafinil_Australia
 */

$product_id  = isset( $args['product_id'] ) ? (int) $args['product_id'] : get_the_ID();
$usage_title = get_field( 'usage_note_title', $product_id ) ?: get_field( 'usage_note_title', 'option' );
$usage_text  = get_field( 'usage_note_text', $product_id ) ?: get_field( 'usage_note_text', 'option' );
$info_text   = get_field( 'informational_warning_text', $product_id ) ?: get_field( 'informational_warning_text', 'option' );
$reviewer_id = (int) get_field( 'medical_reviewer_post', $product_id );
$reviewer    = $reviewer_id ? get_the_title( $reviewer_id ) : '';

if ( $usage_text ) {
	$usage_text = str_replace( '{product_name}', get_the_title( $product_id ), $usage_text );
}

if ( ! $usage_text && ! $info_text && ! $reviewer ) {
	return;
}
$reviewed_label = armo_label( 'label_medically_reviewed' );
$updated_label  = armo_label( 'label_last_updated' );
?>
<section class="section bg-white">
	<div class="container-site mx-auto max-w-4xl space-y-4">
		<?php if ( $usage_text ) : ?>
			<div class="rounded-xl border border-accent/60 bg-accent/10 p-5">
				<?php if ( $usage_title ) : ?><h2 class="font-heading text-base font-semibold text-primary"><?php echo esc_html( $usage_title ); ?></h2><?php endif; ?>
				<div class="armo-prose mt-1 text-[15px]"><?php echo wp_kses_post( $usage_text ); ?></div>
			</div>
		<?php endif; ?>

		<?php if ( $info_text ) : ?>
			<div class="armo-prose rounded-xl border border-border bg-secondary p-5 text-[15px]"><?php echo wp_kses_post( $info_text ); ?></div>
		<?php endif; ?>

		<?php if ( $reviewer ) : ?>
			<p class="flex flex-wrap justify-between gap-2 text-sm text-muted-foreground">
				<span><?php echo $reviewed_label ? esc_html( $reviewed_label ) . ' ' : ''; ?><a href="<?php echo esc_url( get_permalink( $reviewer_id ) ); ?>" class="font-semibold text-primary hover:underline"><?php echo esc_html( $reviewer ); ?></a></span>
				<?php if ( $updated_label ) : ?><span><?php echo esc_html( $updated_label ); ?> <?php echo esc_html( get_the_modified_date( 'F Y', $product_id ) ); ?></span><?php endif; ?>
			</p>
		<?php endif; ?>
	</div>
</section>

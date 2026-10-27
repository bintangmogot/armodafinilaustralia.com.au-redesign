<?php
/**
 * Product card used by the carousel, featured grids and the shop.
 *
 * Args: product (WC_Product), price_subtext (string, optional).
 * Variable products show their quantity options as buttons; choosing one updates the price
 * and the buy link (assets/js/product-card.js).
 *
 * @package Armodafinil_Australia
 */

$product = isset( $args['product'] ) ? $args['product'] : null;
if ( ! $product instanceof WC_Product ) {
	return;
}

$product_id   = $product->get_id();
$permalink    = $product->get_permalink();
$subtext      = ! empty( $args['price_subtext'] ) ? $args['price_subtext'] : (string) get_field( 'price_subtext', $product_id );
$rating       = armo_product_rating_summary( $product_id );
$options      = armo_product_quantity_options( $product );
$buy_label    = armo_label( 'label_buy_now' );
$qty_label    = armo_label( 'label_choose_quantity' );
$read_more    = armo_label( 'label_read_more' );
$copy         = get_field( 'shop_page_text', $product_id );
$copy         = $copy ? $copy : $product->get_short_description();
$copy_plain   = trim( wp_strip_all_tags( strip_shortcodes( (string) $copy ) ) );
$star_path    = 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z';
?>
<article class="product-card flex h-full flex-col overflow-hidden rounded-2xl border border-border bg-white transition-shadow hover:shadow-card" data-product-card>
	<a href="<?php echo esc_url( $permalink ); ?>" class="block bg-secondary p-4" tabindex="-1" aria-hidden="true">
		<?php
		echo $product->get_image( 'woocommerce_thumbnail', array(
			'class'    => 'mx-auto aspect-square h-auto w-full max-w-[260px] rounded-lg object-contain',
			'loading'  => 'lazy',
			'decoding' => 'async',
		) ); // phpcs:ignore WordPress.Security.EscapeOutput
		?>
	</a>

	<div class="flex flex-1 flex-col p-4 md:p-5">
		<h3 class="font-heading text-base font-semibold leading-snug text-primary md:text-lg">
			<a href="<?php echo esc_url( $permalink ); ?>" class="hover:underline"><?php echo wp_kses_post( armo_content( $product->get_name() ) ); ?></a>
		</h3>

		<?php if ( $rating['count'] > 0 ) : ?>
			<div class="mt-1.5 flex items-center gap-1.5">
				<span class="flex" aria-hidden="true">
					<?php for ( $i = 1; $i <= 5; $i++ ) : ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" class="<?php echo $i <= round( $rating['average'] ) ? 'text-star' : 'text-border'; ?>" fill="currentColor"><path d="<?php echo esc_attr( $star_path ); ?>"/></svg>
					<?php endfor; ?>
				</span>
				<span class="text-xs text-muted-foreground"><?php echo esc_html( number_format_i18n( $rating['average'], 1 ) ); ?> (<?php echo (int) $rating['count']; ?>)</span>
			</div>
		<?php endif; ?>

		<?php if ( $copy_plain ) : ?>
			<p class="mt-2 line-clamp-2 text-sm leading-snug text-muted-foreground"><?php echo esc_html( $copy_plain ); ?></p>
		<?php endif; ?>

		<div class="mt-3 text-lg font-bold text-primary" data-card-price><?php echo wp_kses_post( $product->get_price_html() ); ?></div>
		<?php if ( $subtext ) : ?>
			<p class="text-sm font-medium text-success"><?php echo esc_html( $subtext ); ?></p>
		<?php endif; ?>

		<?php if ( ! empty( $options ) ) : ?>
			<div class="mt-3" role="group"<?php echo $qty_label ? ' aria-label="' . esc_attr( $qty_label ) . '"' : ''; ?>>
				<div class="grid grid-cols-2 gap-2">
					<?php foreach ( $options as $index => $option ) : ?>
						<button type="button" class="qty-pill rounded-lg border border-border px-2 py-2 text-sm font-semibold text-primary transition-colors hover:border-primary" data-price="<?php echo esc_attr( $option['price_html'] ); ?>" data-url="<?php echo esc_url( $option['url'] ); ?>" aria-pressed="false"><?php echo esc_html( $option['label'] ); ?></button>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>

		<div class="mt-auto pt-4">
			<?php if ( $buy_label ) : ?>
				<a href="<?php echo esc_url( $permalink ); ?>" class="btn-buy w-full" data-card-buy><?php echo esc_html( $buy_label ); ?></a>
			<?php endif; ?>
		</div>
	</div>
</article>

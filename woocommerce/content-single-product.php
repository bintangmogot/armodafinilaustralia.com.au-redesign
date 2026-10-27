<?php
/**
 * Single product content.
 *
 * Every visible word comes from WooCommerce product data, the product's ACF fields or Theme
 * Settings (Interface Labels, Product Page). Behaviour lives in assets/js/product-page.js.
 *
 * @package Armodafinil_Australia
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$product_id  = $product->get_id();
$is_variable = $product->is_type( 'variable' );
$shop_url    = get_permalink( wc_get_page_id( 'shop' ) );
$rating      = armo_product_rating_summary( $product_id );
$decimals    = wc_get_price_decimals();
$currency    = html_entity_decode( get_woocommerce_currency_symbol() );
$unit        = armo_label( 'label_unit_tabs' );

// Quantity options (one per variation) and the default selection.
$options = array();
if ( $is_variable ) {
	foreach ( $product->get_available_variations() as $variation ) {
		if ( empty( $variation['is_purchasable'] ) || empty( $variation['is_in_stock'] ) ) {
			continue;
		}
		$value  = (string) reset( $variation['attributes'] );
		$number = preg_match( '/\d[\d,]*/', $value, $match ) ? (int) str_replace( ',', '', $match[0] ) : 0;
		$label  = $number ? ( $unit ? $number . ' ' . $unit : (string) $number ) : $value;
		$options[] = array(
			'id'         => (int) $variation['variation_id'],
			'label'      => $label,
			'number'     => $number,
			'price'      => (float) $variation['display_price'],
			'attributes' => $variation['attributes'],
		);
	}
	usort( $options, static function ( $a, $b ) {
		return $a['number'] <=> $b['number'];
	} );
}
$first       = $options ? $options[0] : null;
$start_price = $first ? $first['price'] : (float) wc_get_price_to_display( $product );

$format_price = static function ( $amount ) use ( $currency, $decimals ) {
	return $currency . number_format_i18n( $amount, $decimals );
};

// Gallery.
$gallery_ids = array_filter( array_merge( array( $product->get_image_id() ), $product->get_gallery_image_ids() ) );

$price_note   = get_field( 'price_subtext', $product_id );
$under_image  = get_field( 'text_under_product_image', $product_id );
$short_desc   = apply_filters( 'woocommerce_short_description', $product->get_short_description() );
$description  = apply_filters( 'the_content', $product->get_description() );
$extra_tabs   = get_field( 'extra_tabs', $product_id );
$in_stock     = $product->is_in_stock();
$stock_label  = $in_stock ? armo_label( 'label_in_stock' ) : armo_label( 'label_out_of_stock' );
$ship_notice  = get_field( 'product_shipping_notice', 'option' );
$trust_items  = get_field( 'product_trust_items', 'option' );
$custom_specs = get_field( 'custom_product_specs', $product_id );
$specs        = array();
foreach ( $product->get_attributes() as $attribute ) {
	if ( $attribute->get_variation() ) {
		continue;
	}
	$name = wc_attribute_label( $attribute->get_name() );
	if ( $attribute->is_taxonomy() ) {
		$values = wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'names' ) );
	} else {
		$values = $attribute->get_options();
	}
	if ( $values ) {
		$specs[ $name ] = implode( ', ', array_map( 'wp_strip_all_tags', $values ) );
	}
}
if ( is_array( $custom_specs ) ) {
	foreach ( $custom_specs as $spec ) {
		if ( ! empty( $spec['spec_name'] ) && ! empty( $spec['spec_value'] ) ) {
			$specs[ $spec['spec_name'] ] = $spec['spec_value'];
		}
	}
}

$icon_check = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 6 9 17l-5-5"/></svg>';
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'armo-product', $product ); ?>>

	<nav class="border-b border-border bg-white" aria-label="<?php echo esc_attr( get_the_title( wc_get_page_id( 'shop' ) ) ); ?>">
		<?php woocommerce_breadcrumb( array(
			'delimiter'   => '<span class="mx-1.5 text-border" aria-hidden="true">/</span>',
			'wrap_before' => '<div class="container-site flex h-12 flex-wrap items-center text-sm text-muted-foreground [&_a:hover]:text-primary [&_a:hover]:underline">',
			'wrap_after'  => '</div>',
		) ); ?>
	</nav>

	<section class="bg-secondary/40 py-8 md:py-12">
		<div class="container-site grid items-start gap-8 lg:grid-cols-2 lg:gap-12">

			<div class="lg:sticky lg:top-28">
				<div class="overflow-hidden rounded-2xl border border-border bg-white p-4" id="product-main-image">
					<?php
					if ( $gallery_ids ) {
						echo wp_get_attachment_image( reset( $gallery_ids ), 'large', false, array(
							'class'         => 'mx-auto h-auto max-h-[520px] w-full object-contain',
							'fetchpriority' => 'high',
							'loading'       => 'eager',
							'decoding'      => 'async',
						) );
					} else {
						echo wc_placeholder_img( 'large' ); // phpcs:ignore WordPress.Security.EscapeOutput
					}
					?>
				</div>
				<?php if ( count( $gallery_ids ) > 1 ) : ?>
					<ul class="m-0 mt-3 grid list-none grid-cols-5 gap-2 p-0" id="product-thumbs">
						<?php foreach ( $gallery_ids as $index => $image_id ) : ?>
							<li>
								<button type="button" class="block w-full overflow-hidden rounded-lg border bg-white p-1 <?php echo 0 === $index ? 'border-primary' : 'border-border'; ?>" data-src="<?php echo esc_url( wp_get_attachment_image_url( $image_id, 'large' ) ); ?>" data-srcset="<?php echo esc_attr( (string) wp_get_attachment_image_srcset( $image_id, 'large' ) ); ?>" aria-label="<?php echo esc_attr( get_the_title( $image_id ) ); ?>">
									<?php echo wp_get_attachment_image( $image_id, 'thumbnail', false, array( 'class' => 'h-auto w-full', 'loading' => 'lazy', 'alt' => '' ) ); ?>
								</button>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( $under_image ) : ?>
					<div class="mt-3 flex items-start gap-2.5 rounded-xl border border-border bg-white px-4 py-3 text-sm font-medium text-primary [&_p]:m-0">
						<span class="mt-0.5 shrink-0 text-success"><?php echo $icon_check; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
						<div><?php echo wp_kses_post( $under_image ); ?></div>
					</div>
				<?php endif; ?>
			</div>

			<div>
				<?php if ( $stock_label ) : ?>
					<p class="inline-flex items-center gap-1.5 rounded-full border border-border bg-white px-3 py-1 text-xs font-semibold <?php echo $in_stock ? 'text-success' : 'text-destructive'; ?>">
						<?php echo $in_stock ? $icon_check : ''; // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<?php echo esc_html( $stock_label ); ?>
					</p>
				<?php endif; ?>

				<h1 class="mt-3 font-heading text-[clamp(1.75rem,1.3rem+2vw,2.6rem)] font-bold leading-[1.15] text-primary"><?php echo wp_kses_post( armo_content( $product->get_name() ) ); ?></h1>

				<?php if ( $rating['count'] > 0 ) : ?>
					<p class="mt-3 flex items-center gap-2 text-sm text-muted-foreground">
						<?php echo armo_stars_html( (int) round( $rating['average'] ) ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
						<a href="#reviews" class="font-medium text-primary hover:underline"><?php echo esc_html( number_format_i18n( $rating['average'], 1 ) ); ?> (<?php echo (int) $rating['count']; ?>)</a>
					</p>
				<?php endif; ?>

				<p class="mt-5 flex flex-wrap items-baseline gap-x-3">
					<span class="font-heading text-4xl font-bold text-primary" id="dynamic-price"><?php echo esc_html( $format_price( $start_price ) ); ?></span>
					<span class="text-sm font-medium text-success" id="dynamic-per-pill"><?php echo $price_note ? esc_html( $price_note ) : ''; ?></span>
				</p>

				<?php if ( $short_desc ) : ?>
					<div class="armo-prose mt-5 rounded-xl border border-border bg-white p-5 text-[15px]"><?php echo wp_kses_post( $short_desc ); ?></div>
				<?php endif; ?>

				<?php if ( $ship_notice ) : ?>
					<p class="mt-5 flex items-center gap-3 rounded-xl border border-accent/60 bg-accent/10 px-4 py-3 text-sm font-medium text-primary">
						<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.62l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
						<?php echo esc_html( $ship_notice ); ?>
					</p>
				<?php endif; ?>

				<form class="cart mt-6" id="armo-cart-form" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype="multipart/form-data" data-checkout="<?php echo esc_url( wc_get_checkout_url() ); ?>" data-cart="<?php echo esc_url( wc_get_cart_url() ); ?>" data-currency="<?php echo esc_attr( $currency ); ?>" data-decimals="<?php echo (int) $decimals; ?>" data-adding="<?php echo esc_attr( armo_label( 'label_adding' ) ); ?>" data-added="<?php echo esc_attr( armo_label( 'label_added' ) ); ?>" data-copied="<?php echo esc_attr( armo_label( 'label_link_copied' ) ); ?>" data-unit="<?php echo esc_attr( armo_label( 'label_per_unit' ) ); ?>" data-note="<?php echo esc_attr( (string) $price_note ); ?>">
					<?php if ( $options ) : ?>
						<fieldset>
							<legend class="flex w-full items-center justify-between text-sm">
								<span class="font-semibold text-primary"><?php echo esc_html( armo_label( 'label_choose_quantity' ) ); ?></span>
							</legend>
							<div class="mt-3 grid grid-cols-2 gap-2 sm:grid-cols-3" id="variant-buttons">
								<?php foreach ( $options as $index => $option ) : ?>
									<button type="button" class="variant-btn rounded-lg border px-3 py-2.5 text-left transition-colors <?php echo 0 === $index ? 'is-active' : 'border-border bg-white text-primary hover:border-primary'; ?>" data-vid="<?php echo (int) $option['id']; ?>" data-price="<?php echo esc_attr( $option['price'] ); ?>" data-qty="<?php echo (int) $option['number']; ?>" data-attrs="<?php echo esc_attr( wp_json_encode( $option['attributes'] ) ); ?>" aria-pressed="<?php echo 0 === $index ? 'true' : 'false'; ?>">
										<span class="block text-base font-semibold"><?php echo esc_html( $option['label'] ); ?></span>
										<span class="price-label block text-xs"><?php echo esc_html( $format_price( $option['price'] ) ); ?></span>
									</button>
								<?php endforeach; ?>
							</div>
							<input type="hidden" name="variation_id" class="variation_id" value="<?php echo (int) $first['id']; ?>">
							<div id="dynamic-attributes-container">
								<?php foreach ( $first['attributes'] as $key => $value ) : ?>
									<input type="hidden" name="<?php echo esc_attr( $key ); ?>" value="<?php echo esc_attr( $value ); ?>">
								<?php endforeach; ?>
							</div>
						</fieldset>
					<?php endif; ?>

					<div class="mt-6 flex flex-wrap items-stretch gap-3">
						<div class="inline-flex h-12 items-center overflow-hidden rounded-lg border border-border bg-white">
							<button type="button" class="qty-btn grid h-full w-11 place-items-center text-primary hover:bg-secondary" data-action="minus" aria-label="-">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14"/></svg>
							</button>
							<input type="number" name="quantity" value="1" min="1" class="qty-input h-full w-12 border-0 p-0 text-center text-base font-semibold text-primary outline-none [appearance:textfield] [&::-webkit-inner-spin-button]:appearance-none" aria-label="<?php echo esc_attr__( 'Quantity', 'woocommerce' ); ?>">
							<button type="button" class="qty-btn grid h-full w-11 place-items-center text-primary hover:bg-secondary" data-action="plus" aria-label="+">
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true"><path d="M5 12h14M12 5v14"/></svg>
							</button>
						</div>

						<?php if ( $in_stock ) : ?>
							<button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product_id ); ?>" class="btn-buy flex-1 sm:flex-none" data-label="<?php echo esc_attr( armo_label( 'label_add_to_cart' ) ); ?>"><?php echo esc_html( armo_label( 'label_add_to_cart' ) ); ?></button>
							<?php if ( armo_label( 'label_buy_now_checkout' ) ) : ?>
								<button type="button" class="btn-primary flex-1 sm:flex-none" id="buy-now-btn"><?php echo esc_html( armo_label( 'label_buy_now_checkout' ) ); ?></button>
							<?php endif; ?>
						<?php endif; ?>

						<?php if ( armo_label( 'label_share' ) ) : ?>
							<button type="button" id="share-btn" class="inline-flex h-12 w-12 items-center justify-center rounded-lg border border-border bg-white text-primary hover:bg-secondary" aria-label="<?php echo esc_attr( armo_label( 'label_share' ) ); ?>">
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><path d="m8.6 13.5 6.8 4M15.4 6.5l-6.8 4"/></svg>
							</button>
						<?php endif; ?>
					</div>
					<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
				</form>
				<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

				<?php if ( ! empty( $trust_items ) ) : ?>
					<ul class="m-0 mt-6 grid list-none grid-cols-1 gap-2 p-0 sm:grid-cols-3">
						<?php foreach ( $trust_items as $item ) : ?>
							<?php if ( empty( $item['text'] ) ) { continue; } ?>
							<li class="flex items-center gap-2 rounded-lg border border-border bg-white px-3 py-2.5 text-xs font-medium text-primary">
								<span class="shrink-0 text-success"><?php echo $icon_check; // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
								<?php echo esc_html( $item['text'] ); ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $specs ) : ?>
					<details class="group mt-8 overflow-hidden rounded-xl border border-border bg-white" open>
						<summary class="flex cursor-pointer list-none items-center justify-between gap-3 px-4 py-3.5">
							<span class="font-heading text-base font-semibold text-primary"><?php echo esc_html( armo_label( 'label_product_specs' ) ); ?> <span class="font-normal text-muted-foreground">(<?php echo (int) count( $specs ); ?>)</span></span>
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="transition-transform group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>
						</summary>
						<dl class="m-0 divide-y divide-border border-t border-border px-4 text-sm">
							<?php foreach ( $specs as $spec_name => $spec_value ) : ?>
								<div class="flex justify-between gap-4 py-3">
									<dt class="min-w-[120px] text-muted-foreground"><?php echo esc_html( $spec_name ); ?></dt>
									<dd class="m-0 text-right font-medium text-primary"><?php echo esc_html( $spec_value ); ?></dd>
								</div>
							<?php endforeach; ?>
						</dl>
					</details>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<?php
	$has_description = '' !== trim( wp_strip_all_tags( $description ) );
	$has_tabs        = is_array( $extra_tabs ) && ! empty( array_filter( array_column( $extra_tabs, 'tab_content' ) ) );
	?>
	<?php if ( $has_description || $has_tabs ) : ?>
		<section class="section bg-white" id="product-description-section">
			<div class="container-site">
				<div class="mx-auto max-w-3xl space-y-10">
					<?php if ( $has_description ) : ?>
						<div class="armo-prose"><?php echo $description; // phpcs:ignore WordPress.Security.EscapeOutput -- the_content filter output. ?></div>
					<?php endif; ?>
					<?php if ( $has_tabs ) : ?>
						<?php foreach ( $extra_tabs as $tab ) : ?>
							<?php if ( empty( $tab['tab_content'] ) ) { continue; } ?>
							<div>
								<?php if ( ! empty( $tab['tab_title'] ) ) : ?>
									<h2 class="mb-3 font-heading text-2xl font-bold text-primary"><?php echo esc_html( $tab['tab_title'] ); ?></h2>
								<?php endif; ?>
								<div class="armo-prose"><?php echo wp_kses_post( armo_content( $tab['tab_content'] ) ); ?></div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php armo_render_modules( $product_id ); ?>

	<?php get_template_part( 'template-parts/product-notes', null, array( 'product_id' => $product_id ) ); ?>

	<?php get_template_part( 'template-parts/product-reviews' ); ?>

	<?php
	$related_ids = wc_get_related_products( $product_id, 4 );
	$related_h   = armo_label( 'label_related_products' );
	if ( $related_ids ) :
		?>
		<section class="section bg-white">
			<div class="container-site">
				<?php if ( $related_h ) : ?>
					<h2 class="section-title mb-8 text-center md:mb-12"><?php echo esc_html( $related_h ); ?></h2>
				<?php endif; ?>
				<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
					<?php foreach ( $related_ids as $related_id ) : ?>
						<?php
						$related = wc_get_product( $related_id );
						if ( $related ) {
							get_template_part( 'template-parts/product-card', null, array( 'product' => $related ) );
						}
						?>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
	<?php endif; ?>

	<?php get_template_part( 'template-parts/order-cta' ); ?>
</div>

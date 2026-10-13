<?php
/**
 * Review order table
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="review-order-summary-wrapper hidden lg:block">
    <h2 class="font-serif text-xl font-semibold text-ink-900">Order summary</h2>
    
    <ul class="mt-4 space-y-3 m-0 p-0 list-none">
        <?php
        do_action( 'woocommerce_review_order_before_cart_contents' );

        foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <li class="flex gap-3 items-start <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <div class="relative w-14 h-14 rounded-lg bg-brand-50 border border-ink-200 shrink-0 flex items-center justify-center">
                        <?php echo apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'w-full h-full object-cover rounded-lg')), $cart_item, $cart_item_key ); ?>
                        <span class="absolute -top-1 -right-1 w-5 h-5 grid place-items-center rounded-full bg-ink-900 text-white text-[10px] font-semibold leading-none pt-0.5">
                            <?php echo $cart_item['quantity']; ?>
                        </span>
                    </div>
                    <div class="flex-1 min-w-0 flex flex-col justify-center h-14">
                        <div class="text-sm font-medium text-ink-900 line-clamp-2 leading-snug">
                            <?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ) . '&nbsp;'; ?>
                            <?php echo wc_get_formatted_cart_item_data( $cart_item ); ?>
                        </div>
                    </div>
                    <div class="text-sm font-semibold text-ink-900 h-14 flex items-center">
                        <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                    </div>
                </li>
                <?php
            }
        }

        do_action( 'woocommerce_review_order_after_cart_contents' );
        ?>
    </ul>

    <div class="mt-5 pt-5 border-t border-ink-200 space-y-2 text-sm cart-subtotals-wrapper">
        <div class="flex justify-between cart-subtotal">
            <span class="text-ink-500"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></span>
            <span class="font-medium"><?php wc_cart_totals_subtotal_html(); ?></span>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="flex justify-between cart-discount coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <span class="text-ink-500"><?php wc_cart_totals_coupon_label( $coupon ); ?></span>
                <span class="font-medium text-brand-700"><?php wc_cart_totals_coupon_html( $coupon ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
            <div class="cart-shipping-wrapper w-full">
                <?php wc_cart_totals_shipping_html(); ?>
            </div>
            <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="flex justify-between fee">
                <span class="text-ink-500"><?php echo esc_html( $fee->name ); ?></span>
                <span class="font-medium"><?php wc_cart_totals_fee_html( $fee ); ?></span>
            </div>
        <?php endforeach; ?>

        <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
            <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
                <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited ?>
                    <div class="flex justify-between tax-rate tax-rate-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                        <span class="text-ink-500"><?php echo esc_html( $tax->label ); ?></span>
                        <span class="font-medium"><?php echo wp_kses_post( $tax->formatted_amount ); ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <div class="flex justify-between tax-total">
                    <span class="text-ink-500"><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></span>
                    <span class="font-medium"><?php wc_cart_totals_taxes_total_html(); ?></span>
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

        <div class="flex justify-between pt-3 border-t border-ink-200 order-total">
            <span class="font-semibold text-ink-900"><?php esc_html_e( 'Total', 'woocommerce' ); ?></span>
            <span class="font-semibold text-ink-900 text-lg"><?php wc_cart_totals_order_total_html(); ?></span>
        </div>

        <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
    </div>
    
    <div class="mt-4 flex flex-wrap items-center gap-x-3 gap-y-1 text-[11px] text-ink-500">
        <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600 !fill-none"><path style="fill: none !important;" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path style="fill: none !important;" d="m9 12 2 2 4-4"/></svg> SSL secured</span>
        <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600 !fill-none"><rect style="fill: none !important;" width="18" height="11" x="3" y="11" rx="2" ry="2"/><path style="fill: none !important;" d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Encrypted</span>
        <span class="inline-flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600 !fill-none"><path style="fill: none !important;" d="M5 18H3c-.6 0-1-.4-1-1V7c0-.6.4-1 1-1h10c.6 0 1 .4 1 1v11"/><path style="fill: none !important;" d="M14 9h4l4 4v5c0 .6-.4 1-1 1h-2"/><circle style="fill: none !important;" cx="7" cy="18" r="2"/><circle style="fill: none !important;" cx="17" cy="18" r="2"/></svg> Tracked</span>
    </div>
</div>


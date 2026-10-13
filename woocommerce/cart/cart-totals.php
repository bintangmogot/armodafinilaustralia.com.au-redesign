<?php
defined( 'ABSPATH' ) || exit;
?>
<div class="cart_totals <?php echo ( WC()->customer->has_calculated_shipping() ) ? 'calculated_shipping' : ''; ?>">

    <?php do_action( 'woocommerce_before_cart_totals' ); ?>

    <h2 class="font-serif text-xl font-semibold text-ink-900 !mb-0"><?php esc_html_e( 'Order summary', 'woocommerce' ); ?></h2>

    <div class="mt-4 space-y-3 text-sm">
        <div class="flex justify-between items-center">
            <div class="text-ink-500"><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></div>
            <div class="font-medium"><?php wc_cart_totals_subtotal_html(); ?></div>
        </div>

        <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
            <div class="flex justify-between items-center text-brand-600 coupon-<?php echo esc_attr( sanitize_title( $code ) ); ?>">
                <div><?php wc_cart_totals_coupon_label( $coupon ); ?></div>
                <div><?php wc_cart_totals_coupon_html( $coupon ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
            <?php do_action( 'woocommerce_cart_totals_before_shipping' ); ?>
            <?php wc_cart_totals_shipping_html(); ?>
            <?php do_action( 'woocommerce_cart_totals_after_shipping' ); ?>
        <?php elseif ( WC()->cart->needs_shipping() && 'yes' === get_option( 'woocommerce_enable_shipping_calc' ) ) : ?>
            <div class="flex flex-col gap-2 pt-2 pb-2">
                <div class="text-ink-500"><?php esc_html_e( 'Shipping', 'woocommerce' ); ?></div>
                <div><?php woocommerce_shipping_calculator(); ?></div>
            </div>
        <?php endif; ?>

        <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
            <div class="flex justify-between items-center fee">
                <div class="text-ink-500"><?php echo esc_html( $fee->name ); ?></div>
                <div class="font-medium"><?php wc_cart_totals_fee_html( $fee ); ?></div>
            </div>
        <?php endforeach; ?>

        <?php do_action( 'woocommerce_cart_totals_before_order_total' ); ?>

        <div class="flex justify-between items-center pt-3 border-t border-ink-200 order-total">
            <div class="font-semibold text-ink-900"><?php esc_html_e( 'Total', 'woocommerce' ); ?></div>
            <div class="font-semibold text-ink-900"><?php wc_cart_totals_order_total_html(); ?></div>
        </div>

        <?php do_action( 'woocommerce_cart_totals_after_order_total' ); ?>
    </div>
    
    <?php
    $subtotal = WC()->cart->get_displayed_subtotal();
    if ($subtotal < 299) {
        $needed = 299 - $subtotal;
        ?>
        <p class="mt-4 text-xs text-brand-700 bg-brand-50 border border-brand-100 rounded-lg p-3 leading-relaxed">
            Add <?php echo wc_price($needed); ?> more to unlock free shipping.
        </p>
        <?php
    }
    ?>

    <div class="wc-proceed-to-checkout mt-5">
        <?php do_action( 'woocommerce_proceed_to_checkout' ); ?>
    </div>
    
    <p class="mt-3 text-xs text-ink-500 text-center">Secure, encrypted checkout &amp; discreet packaging</p>

    <?php do_action( 'woocommerce_after_cart_totals' ); ?>

</div>

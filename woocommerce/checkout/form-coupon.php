<?php
/**
 * Checkout coupon form
 */

defined( 'ABSPATH' ) || exit;

if ( ! wc_coupons_enabled() ) {
	return;
}

?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
    <div class="woocommerce-form-coupon-toggle mb-6">
        <?php
            wc_print_notice( apply_filters( 'woocommerce_checkout_coupon_message', esc_html__( 'Have a coupon?', 'woocommerce' ) . ' <a href="#" role="button" aria-label="' . esc_attr__( 'Enter your coupon code', 'woocommerce' ) . '" aria-controls="woocommerce-checkout-form-coupon" aria-expanded="false" class="showcoupon font-semibold underline underline-offset-2 hover:text-brand-700 transition-colors">' . esc_html__( 'Click here to enter your code', 'woocommerce' ) . '</a>' ), 'notice' );
        ?>
    </div>

    <form class="checkout_coupon woocommerce-form-coupon bg-white border border-ink-200 rounded-xl p-5 mb-8 shadow-sm lg:w-1/2" method="post" style="display:none" id="woocommerce-checkout-form-coupon">
        <p class="text-sm font-semibold text-ink-900 mb-1">Enter your coupon</p>
        <p class="text-xs text-ink-500 mb-4"><?php esc_html_e( 'If you have a promo code, please apply it below.', 'woocommerce' ); ?></p>
        
        <div class="flex gap-2 w-full">
            <label for="coupon_code" class="screen-reader-text"><?php esc_html_e( 'Coupon:', 'woocommerce' ); ?></label>
            <input type="text" name="coupon_code" class="h-10 px-4 border border-ink-200 rounded-lg text-sm outline-none focus:border-brand-600 flex-1 min-w-0 bg-white" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" id="coupon_code" value="" />
            <button type="submit" class="h-10 px-5 rounded-lg bg-ink-900 hover:bg-ink-800 text-white text-sm font-semibold transition-colors shrink-0" name="apply_coupon" value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_html_e( 'Apply', 'woocommerce' ); ?></button>
        </div>
        <div class="clear"></div>
    </form>
</div>

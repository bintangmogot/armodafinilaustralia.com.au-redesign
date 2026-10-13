<?php
defined( 'ABSPATH' ) || exit;
do_action( 'woocommerce_before_cart' ); ?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16">
    <h1 class="font-serif text-3xl md:text-4xl font-semibold text-ink-900">Your cart</h1>
    <div class="mt-8 grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <form class="woocommerce-cart-form" action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post">
                <?php do_action( 'woocommerce_before_cart_table' ); ?>
                <div class="space-y-4">
                    <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                        $_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
                        $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

                        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                            $product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
                            ?>
                            <div class="flex gap-4 bg-white border border-ink-200 rounded-2xl p-4 woocommerce-cart-form__cart-item <?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                                <div class="w-24 h-24 rounded-lg overflow-hidden bg-brand-50 shrink-0 flex items-center justify-center">
                                    <?php
                                    $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image('thumbnail', array('class' => 'w-full h-full object-cover')), $cart_item, $cart_item_key );
                                    if ( ! $product_permalink ) {
                                        echo $thumbnail;
                                    } else {
                                        printf( '<a href="%s">%s</a>', esc_url( $product_permalink ), $thumbnail );
                                    }
                                    ?>
                                </div>
                                <div class="flex-1 min-w-0 flex flex-col justify-center">
                                    <div class="font-serif text-lg font-semibold text-ink-900 leading-snug">
                                        <?php
                                        if ( ! $product_permalink ) {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) . '&nbsp;' );
                                        } else {
                                            echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', sprintf( '<a href="%s" class="text-ink-900 hover:text-brand-600 transition-colors">%s</a>', esc_url( $product_permalink ), $_product->get_name() ), $cart_item, $cart_item_key ) );
                                        }
                                        do_action( 'woocommerce_after_cart_item_name', $cart_item, $cart_item_key );
                                        echo wc_get_formatted_cart_item_data( $cart_item );
                                        ?>
                                    </div>
                                    <div class="text-sm text-ink-500 mt-1">
                                        <?php echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); ?> each
                                    </div>
                                    <div class="mt-3 flex items-center justify-between gap-3 flex-wrap">
                                        <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white custom-qty-wrapper">
                                            <button type="button" class="qty-btn minus w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/></svg></button>
                                            <?php
                                            if ( $_product->is_sold_individually() ) {
                                                echo sprintf( '<input type="hidden" name="cart[%s][qty]" value="1" /> <span class="w-8 text-center text-sm font-semibold">1</span>', $cart_item_key );
                                            } else {
                                                echo woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                                        'min_value'    => '0',
                                                        'product_name' => $_product->get_name(),
                                                        'classes'      => 'w-8 h-9 text-center text-sm font-semibold p-0 border-0 outline-none focus:ring-0 bg-transparent appearance-none',
                                                    ),
                                                    $_product,
                                                    false
                                                );
                                            }
                                            ?>
                                            <button type="button" class="qty-btn plus w-9 h-9 grid place-items-center hover:bg-ink-100 text-ink-700 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 0 14"/></svg></button>
                                        </div>
                                        <div class="font-semibold text-ink-900">
                                            <?php echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); ?>
                                        </div>
                                        <div class="relative">
                                            <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove hidden" aria-label="%s" data-product_id="%s" data-product_sku="%s"></a>',
                                                    esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
                                                    esc_html__( 'Remove this item', 'woocommerce' ),
                                                    esc_attr( $product_id ),
                                                    esc_attr( $_product->get_sku() )
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                            <button type="button" class="trigger-remove text-ink-500 hover:text-red-600 transition-colors" aria-label="Remove item">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    endforeach; ?>
                </div>
                <?php do_action( 'woocommerce_cart_contents' ); ?>
                <div class="mt-6 flex flex-wrap gap-4 items-center justify-between border-t border-ink-200 pt-6">
                    <?php if ( wc_coupons_enabled() ) { ?>
                        <div class="flex gap-2 w-full sm:w-auto">
                            <input type="text" name="coupon_code" class="h-11 px-4 border border-ink-200 rounded-full text-sm outline-none focus:border-brand-600 flex-1 min-w-[150px]" id="coupon_code" value="" placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>" />
                            <button type="submit" class="h-11 px-5 rounded-full bg-ink-100 hover:bg-ink-200 text-ink-900 text-sm font-semibold transition-colors shrink-0" name="apply_coupon" value="<?php esc_attr_e( 'Apply', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply', 'woocommerce' ); ?></button>
                            <?php do_action( 'woocommerce_cart_coupon' ); ?>
                        </div>
                    <?php } ?>
                    <button type="submit" class="h-11 px-5 rounded-full border border-brand-200 hover:border-brand-600 text-brand-700 text-sm font-semibold transition-colors w-full sm:w-auto" name="update_cart" value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
                    <?php do_action( 'woocommerce_cart_actions' ); ?>
                    <?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
                </div>
                <?php do_action( 'woocommerce_after_cart_contents' ); ?>
            </form>
            <?php do_action( 'woocommerce_after_cart_table' ); ?>
        </div>
        <aside class="bg-white border border-ink-200 rounded-2xl p-6 h-fit sticky top-24">
            <?php do_action( 'woocommerce_cart_collaterals' ); ?>
        </aside>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.body.addEventListener('click', function(e) {
        if (e.target.closest('.trigger-remove')) {
            e.preventDefault();
            const btn = e.target.closest('.trigger-remove');
            const hiddenLink = btn.parentElement.querySelector('.remove');
            if (hiddenLink) hiddenLink.click();
        }
        
        if (e.target.closest('.qty-btn.minus')) {
            e.preventDefault();
            const wrapper = e.target.closest('.custom-qty-wrapper');
            const input = wrapper.querySelector('input[type="number"]');
            if (input) {
                let val = parseInt(input.value) || 0;
                if (val > 1) {
                    input.value = val - 1;
                    jQuery("[name='update_cart']").prop("disabled", false).trigger("click");
                }
            }
        }
        
        if (e.target.closest('.qty-btn.plus')) {
            e.preventDefault();
            const wrapper = e.target.closest('.custom-qty-wrapper');
            const input = wrapper.querySelector('input[type="number"]');
            if (input) {
                let val = parseInt(input.value) || 0;
                input.value = val + 1;
                jQuery("[name='update_cart']").prop("disabled", false).trigger("click");
            }
        }
    });
});
</script>

<?php do_action( 'woocommerce_after_cart' ); ?>


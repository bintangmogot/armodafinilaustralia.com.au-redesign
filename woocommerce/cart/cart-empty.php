<?php
/**
 * Empty cart page
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="max-w-3xl mx-auto px-4 py-24 text-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-10 h-10 text-brand-600 mx-auto"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    
    <h1 class="mt-4 font-serif text-3xl font-semibold text-ink-900"><?php esc_html_e( 'Your cart is empty', 'woocommerce' ); ?></h1>
    
    <?php do_action( 'woocommerce_cart_is_empty' ); ?>
    
    <?php if ( wc_get_page_id( 'shop' ) > 0 ) : ?>
        <p class="mt-2 text-ink-500">Browse the catalogue and add something to get started.</p>
        <a class="mt-6 inline-flex items-center gap-2 h-11 px-5 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" href="<?php echo esc_url( apply_filters( 'woocommerce_return_to_shop_redirect', wc_get_page_permalink( 'shop' ) ) ); ?>">
            Explore products 
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
        </a>
    <?php endif; ?>
</div>

<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="w-full flex justify-center items-center gap-2 h-11 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
    <?php esc_html_e( 'Checkout', 'woocommerce' ); ?>
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
</a>

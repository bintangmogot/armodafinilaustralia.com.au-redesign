<?php
/**
 * My Account navigation
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_account_navigation' );
?>

<nav class="woocommerce-MyAccount-navigation !w-full !float-none bg-white rounded-2xl shadow-sm border border-ink-200 p-3" aria-label="<?php esc_html_e( 'Account pages', 'woocommerce' ); ?>">
    <h3 class="font-serif text-lg font-semibold text-ink-900 px-4 py-3 mb-2 border-b border-ink-100">My Account</h3>
	<ul class="space-y-1">
		<?php foreach ( wc_get_account_menu_items() as $endpoint => $label ) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes( $endpoint ); ?>">
				<a href="<?php echo esc_url( wc_get_account_endpoint_url( $endpoint ) ); ?>" <?php echo wc_is_current_account_menu_item( $endpoint ) ? 'aria-current="page"' : ''; ?>>
					<?php echo esc_html( $label ); ?>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>
</nav>
<style>
.woocommerce-MyAccount-navigation ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.woocommerce-MyAccount-navigation li a {
    display: block;
    padding: 0.75rem 1rem;
    color: #475569; /* ink-600 */
    font-weight: 500;
    font-size: 0.875rem;
    border-radius: 0.5rem;
    transition: all 0.15s ease;
    text-decoration: none;
}
.woocommerce-MyAccount-navigation li a:hover {
    background-color: #f8fafc; /* ink-50 */
    color: #09152b; /* ink-900 */
}
.woocommerce-MyAccount-navigation li.is-active a {
    background-color: #0d9488; /* brand-600 */
    color: #ffffff;
    font-weight: 600;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
}
</style>

<?php do_action( 'woocommerce_after_account_navigation' ); ?>


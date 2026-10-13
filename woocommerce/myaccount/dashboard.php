<?php
/**
 * My Account Dashboard
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$allowed_html = array(
	'a' => array(
		'href' => array(),
	),
);
?>

<div class="mb-8">
    <h2 class="font-serif text-2xl font-bold text-ink-900 mb-2">Welcome back, <?php echo esc_html( $current_user->display_name ); ?>!</h2>
    <p class="text-ink-600 text-sm">
        <?php
        printf(
            /* translators: 1: user display name 2: logout url */
            wp_kses( __( 'Not %1$s? <a href="%2$s" class="text-brand-600 hover:underline">Log out</a>', 'woocommerce' ), $allowed_html ),
            esc_html( $current_user->display_name ),
            esc_url( wc_logout_url() )
        );
        ?>
    </p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
    <a href="<?php echo esc_url( wc_get_endpoint_url( 'orders' ) ); ?>" class="flex items-start gap-4 p-5 rounded-xl border border-ink-200 bg-ink-50 hover:border-brand-300 hover:bg-brand-50 transition-colors group">
        <div class="w-10 h-10 rounded-full bg-white border border-ink-200 grid place-items-center text-brand-600 shrink-0 group-hover:bg-brand-600 group-hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path style="fill:none !important;" d="m3.3 7 8.7 5 8.7-5"/><path style="fill:none !important;" d="M12 22V12"/></svg>
        </div>
        <div>
            <h3 class="font-semibold text-ink-900 mb-1">Orders</h3>
            <p class="text-sm text-ink-600 leading-tight">View recent orders and track shipments.</p>
        </div>
    </a>
    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-address' ) ); ?>" class="flex items-start gap-4 p-5 rounded-xl border border-ink-200 bg-ink-50 hover:border-brand-300 hover:bg-brand-50 transition-colors group">
        <div class="w-10 h-10 rounded-full bg-white border border-ink-200 grid place-items-center text-brand-600 shrink-0 group-hover:bg-brand-600 group-hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle style="fill:none !important;" cx="12" cy="10" r="3"/></svg>
        </div>
        <div>
            <h3 class="font-semibold text-ink-900 mb-1">Addresses</h3>
            <p class="text-sm text-ink-600 leading-tight">Manage billing and shipping addresses.</p>
        </div>
    </a>
    <a href="<?php echo esc_url( wc_get_endpoint_url( 'edit-account' ) ); ?>" class="flex items-start gap-4 p-5 rounded-xl border border-ink-200 bg-ink-50 hover:border-brand-300 hover:bg-brand-50 transition-colors group">
        <div class="w-10 h-10 rounded-full bg-white border border-ink-200 grid place-items-center text-brand-600 shrink-0 group-hover:bg-brand-600 group-hover:text-white transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle style="fill:none !important;" cx="12" cy="7" r="4"/></svg>
        </div>
        <div>
            <h3 class="font-semibold text-ink-900 mb-1">Account Details</h3>
            <p class="text-sm text-ink-600 leading-tight">Update your password and personal info.</p>
        </div>
    </a>
</div>

<?php
	/**
	 * My Account dashboard.
	 *
	 * @since 2.6.0
	 */
	do_action( 'woocommerce_account_dashboard' );
	do_action( 'woocommerce_before_my_account' );
	do_action( 'woocommerce_after_my_account' );

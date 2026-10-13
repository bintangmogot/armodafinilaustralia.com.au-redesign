<?php
/**
 * Thankyou page
 *
 * @see https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 8.1.0
 *
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 woocommerce-order">

	<?php
	if ( $order ) :

		do_action( 'woocommerce_before_thankyou', $order->get_id() );
		?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed p-4 mb-6 rounded-xl bg-red-50 text-red-900 border border-red-200"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>

			<p class="woocommerce-notice woocommerce-notice--error woocommerce-thankyou-order-failed-actions flex gap-3">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>

		<?php else : ?>

            <div class="space-y-6 lg:space-y-8">
                <!-- Order Confirmed Card -->
                <section class="bg-white border border-brand-200 shadow-sm ring-1 ring-brand-200/50 rounded-2xl p-8 text-center relative overflow-hidden">
                    <div class="absolute -top-12 -right-12 w-32 h-32 bg-brand-50 rounded-full blur-2xl opacity-60"></div>
                    <div class="absolute -bottom-12 -left-12 w-32 h-32 bg-brand-50 rounded-full blur-2xl opacity-60"></div>

                    <div class="relative z-10 w-16 h-16 rounded-full bg-brand-100 text-brand-700 grid place-items-center mx-auto mb-5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path style="fill:none !important;" d="m9 11 3 3L22 4"/></svg>
                    </div>
                    <h2 class="relative z-10 font-serif text-3xl font-semibold text-ink-900">Order confirmed</h2>
                    <p class="relative z-10 mt-3 text-ink-700 max-w-lg mx-auto leading-relaxed">
                        Thanks <b><?php echo esc_html( $order->get_billing_first_name() ? $order->get_billing_first_name() : 'friend' ); ?></b> - your order has been received. 
                        <?php if ( $order->get_billing_email() ) : ?>
                            A confirmation email is on its way to <b><?php echo esc_html( $order->get_billing_email() ); ?></b>.
                        <?php endif; ?>
                    </p>
                    <div class="relative z-10 mt-6 inline-flex items-center gap-2 bg-brand-50 border border-brand-200 text-brand-800 rounded-full px-5 py-2 font-mono text-sm font-semibold tracking-wide">
                        Order ID: <?php echo $order->get_order_number(); ?>
                    </div>
                </section>

                <!-- What happens next -->
                <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8">
                    <h3 class="font-serif text-xl font-semibold text-ink-900 mb-6">What happens next?</h3>
                    <ol class="space-y-5 text-sm text-ink-700">
                        <li class="flex gap-4">
                            <span class="w-6 h-6 grid place-items-center rounded-full bg-ink-100 text-ink-600 text-xs font-bold shrink-0">1</span>
                            <span class="leading-relaxed">
                                <b class="text-ink-900">Payment.</b> 
                                <?php 
                                $payment_method = $order->get_payment_method();
                                if ( $payment_method === 'bacs' ) {
                                    echo 'You will receive our bank details below (and by email). Please transfer the funds within 24 hours.';
                                } elseif ( $payment_method === 'crypto' || strpos($payment_method, 'bitcoin') !== false ) {
                                    echo 'A wallet address for your chosen currency is provided. Please complete the transfer.';
                                } else {
                                    echo 'Your payment is being processed now - no further action needed.';
                                }
                                ?>
                            </span>
                        </li>
                        <li class="flex gap-4">
                            <span class="w-6 h-6 grid place-items-center rounded-full bg-ink-100 text-ink-600 text-xs font-bold shrink-0">2</span>
                            <span class="leading-relaxed"><b class="text-ink-900">Dispatch.</b> Your parcel leaves our facility within 24-48 business hours after funds clear.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="w-6 h-6 grid place-items-center rounded-full bg-ink-100 text-ink-600 text-xs font-bold shrink-0">3</span>
                            <span class="leading-relaxed"><b class="text-ink-900">Tracking.</b> Same-day tracking is emailed to you as soon as your parcel is scanned by the courier.</span>
                        </li>
                        <li class="flex gap-4">
                            <span class="w-6 h-6 grid place-items-center rounded-full bg-ink-100 text-ink-600 text-xs font-bold shrink-0">4</span>
                            <span class="leading-relaxed"><b class="text-ink-900">Delivery.</b> Most Australian addresses receive the parcel within 7-10 business days, dispatched in neutral outer packaging.</span>
                        </li>
                    </ol>
                </section>

                <!-- Payment Details (BACS, Crypto, etc) -->
                <div class="woocommerce-thankyou-hooks space-y-6">
                    <?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
                    <?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-wrap gap-3 justify-center pt-4">
                    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
                        Continue shopping 
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M5 12h14"/><path style="fill:none !important;" d="m12 5 7 7-7 7"/></svg>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline style="fill:none !important;" points="9 22 9 12 15 12 15 22"/></svg>
                        Back to home
                    </a>
                </div>
            </div>

		<?php endif; ?>

	<?php else : ?>

        <!-- Fallback if no order found -->
        <div class="bg-white border border-ink-200 rounded-2xl p-8 text-center max-w-2xl mx-auto">
            <h2 class="font-serif text-3xl font-semibold text-ink-900 mb-4"><?php esc_html_e( 'Order received', 'woocommerce' ); ?></h2>
            <p class="text-ink-700 mb-8"><?php esc_html_e( 'Thank you. Your order has been received.', 'woocommerce' ); ?></p>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">Continue shopping</a>
        </div>

	<?php endif; ?>

</div>
<style>
/* Style WooCommerce default hooks content (e.g. BACS Bank details) */
.woocommerce-thankyou-hooks h2 {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-size: 1.25rem;
    font-weight: 600;
    color: #09152b; /* ink-900 */
    margin-bottom: 1rem;
}
.woocommerce-thankyou-hooks h3 {
    font-family: "Playfair Display", ui-serif, Georgia, serif;
    font-size: 1.125rem;
    font-weight: 600;
    color: #09152b;
    margin-bottom: 0.75rem;
}
.woocommerce-thankyou-hooks ul.order_details {
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    list-style: none;
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
}
.woocommerce-thankyou-hooks ul.order_details li {
    font-size: 0.875rem;
    color: #64748b;
}
.woocommerce-thankyou-hooks ul.order_details li strong {
    display: block;
    color: #09152b;
    font-size: 1rem;
    margin-top: 0.25rem;
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details {
    background: #f8fafc;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}

/* All WooCommerce tables (Order Details, Medical Conditions, etc) */
.woocommerce-thankyou-hooks table.shop_table {
    width: 100%;
    border-collapse: separate; border-spacing: 0;
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    overflow: hidden;
    margin-bottom: 2rem;
}
.woocommerce-thankyou-hooks table.shop_table thead th {
    background: #f8fafc;
    font-weight: 600;
    color: #09152b;
    border-bottom: 1px solid #e2e8f0;
}
.woocommerce-thankyou-hooks table.shop_table th,
.woocommerce-thankyou-hooks table.shop_table td {
    padding: 1rem 1.5rem;
    font-size: 0.875rem;
    color: #334155;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: top;
}
.woocommerce-thankyou-hooks table.shop_table tr:last-child th,
.woocommerce-thankyou-hooks table.shop_table tr:last-child td {
    border-bottom: none;
}

/* Receipt-style alignment for Order Details Table */
.woocommerce-thankyou-hooks table.shop_table.order_details th:first-child,
.woocommerce-thankyou-hooks table.shop_table.order_details td:first-child {
    text-align: left;
}
.woocommerce-thankyou-hooks table.shop_table.order_details th:last-child,
.woocommerce-thankyou-hooks table.shop_table.order_details td:last-child {
    text-align: right;
}
.woocommerce-thankyou-hooks table.shop_table.order_details tfoot th {
    font-weight: 600;
    color: #09152b;
}
.woocommerce-thankyou-hooks table.shop_table.order_details tfoot td {
    font-weight: 500;
    color: #09152b;
}

/* Medical Conditions Table specific tweaks */
.woocommerce-thankyou-hooks table.woocommerce-table--customer-details th {
    font-weight: 600;
    color: #09152b;
    width: 40%;
    text-align: left;
}
.woocommerce-thankyou-hooks table.woocommerce-table--customer-details td {
    text-align: left;
}

.woocommerce-customer-details {
    background: #fff;
    border: 1px solid #e2e8f0; box-shadow: 0 1px 2px 0 rgba(0,0,0,0.05);
    border-radius: 1rem;
    padding: 1.5rem;
    margin-top: 1.5rem;
}
.woocommerce-customer-details address {
    font-style: normal;
    font-size: 0.875rem;
    color: #334155;
    line-height: 1.6;
}

.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details h3 { padding-left: 1rem;
    font-size: 1.125rem;
    color: #0f172a;
    margin-bottom: 1rem;
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details {
    display: flex !important;
    flex-direction: column !important;
    gap: 1.25rem !important;
    padding: 1rem 1.5rem !important; margin: 1rem 0 0 0 !important;
    list-style: none !important;
}
@media (min-width: 640px) {
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul,
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details {
        flex-direction: row !important;
        flex-wrap: wrap !important;
        gap: 2.5rem !important;
    }
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li {
    float: none !important;
    text-align: left !important;
    border: none !important;
    padding: 0 !important;
    margin: 0 !important;
    width: 100% !important;
}
@media (min-width: 640px) {
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li,
    .woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li {
        width: auto !important;
    }
}
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul li strong,
.woocommerce-thankyou-hooks section.woocommerce-bacs-bank-details ul.order_details.bacs_details li strong {
    display: block !important;
    font-size: 1.125rem !important;
    color: #0f172a !important;
    font-weight: 700 !important;
    margin-top: 0.25rem !important;
}
</style>





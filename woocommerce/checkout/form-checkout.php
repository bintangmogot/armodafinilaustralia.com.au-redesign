<?php
/**
 * Checkout Form
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
	return;
}
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-16 checkout-container">
    <div class="flex items-center justify-between gap-3 mb-8 flex-wrap">
        <h1 class="font-serif text-3xl md:text-4xl font-semibold text-ink-900"><?php echo esc_html( armo_label( 'label_checkout_title' ) ?: get_the_title() ); ?></h1>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> <?php echo esc_html( armo_label( 'label_back_to_cart' ) ); ?>
        </a>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout grid lg:grid-cols-3 gap-8" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <div class="lg:col-span-2 space-y-6" id="checkout-accordion">

            <!-- Step 1: Contact & delivery -->
            <section class="bg-white border border-brand-200 rounded-2xl p-6 md:p-8 step-section ring-1 ring-brand-200 shadow-sm transition-all" data-step="1" id="step-1">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-brand-600 text-white grid place-items-center text-sm font-semibold step-badge shrink-0">1</span> <?php echo esc_html( armo_label( 'label_checkout_step_contact' ) ); ?>
                </h2>
                <div class="step-content">
                    <?php if ( $checkout->get_checkout_fields() ) : ?>
                        <?php do_action( 'woocommerce_checkout_before_customer_details' ); ?>
                        <div id="customer_details">
                            <?php do_action( 'woocommerce_checkout_billing' ); ?>
                            <?php do_action( 'woocommerce_checkout_shipping' ); ?>
                        </div>
                    <?php endif; ?>
                    <div class="mt-8 pt-6 border-t border-ink-100 flex items-center gap-4">
                        <button type="button" class="btn-next-step inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" data-target="2"><?php echo esc_html( armo_label( 'label_checkout_continue_medical' ) ); ?></button>
                    </div>
                </div>
            </section>

            <!-- Step 2: Medical info -->
            <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 step-section opacity-60 transition-all cursor-pointer hover:border-ink-300" data-step="2" id="step-2">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-ink-100 text-ink-500 grid place-items-center text-sm font-semibold step-badge shrink-0 transition-colors">2</span> <?php echo esc_html( armo_label( 'label_checkout_step_medical' ) ); ?>
                </h2>
                <div class="step-content hidden mt-6 pt-6 border-t border-ink-100">
                    <div class="medical-info-fields-wrapper">
                        <?php do_action( 'armo_custom_checkout_medical_conditions' ); ?>
                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                    </div>
                    <div class="mt-8 pt-6 border-t border-ink-100 flex items-center gap-4">
                        <button type="button" class="btn-prev-step text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors inline-flex items-center gap-1.5" data-target="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> <?php echo esc_html( armo_label( 'label_checkout_back' ) ); ?></button>
                        <button type="button" class="btn-next-step inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" data-target="3"><?php echo esc_html( armo_label( 'label_checkout_continue_payment' ) ); ?></button>
                    </div>
                </div>
            </section>

            <!-- Step 3: Payment & confirm -->
            <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 step-section opacity-60 transition-all cursor-not-allowed" data-step="3" id="step-3">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-ink-100 text-ink-500 grid place-items-center text-sm font-semibold step-badge shrink-0 transition-colors">3</span> <?php echo esc_html( armo_label( 'label_checkout_step_payment' ) ); ?>
                </h2>
                <div class="step-content hidden mt-6 pt-6 border-t border-ink-100">
                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    <div class="mt-6 pt-6 border-t border-ink-100 flex items-center gap-4">
                        <button type="button" class="btn-prev-step text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors inline-flex items-center gap-1.5" data-target="2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> <?php echo esc_html( armo_label( 'label_checkout_back' ) ); ?></button>
                    </div>
                </div>
            </section>
        </div>

        <aside class="sidebar-summary-container bg-white border border-ink-200 rounded-2xl p-6 h-fit lg:sticky lg:top-24 shadow-soft">
            <!-- Populated via JS from the order review table inside Step 3 -->
        </aside>

    </form>
</div>

<?php do_action( 'woocommerce_after_checkout_form', $checkout ); ?>



















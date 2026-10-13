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
        <h1 class="font-serif text-3xl md:text-4xl font-semibold text-ink-900">Checkout</h1>
        <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="inline-flex items-center gap-1.5 text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> Back to cart
        </a>
    </div>

    <form name="checkout" method="post" class="checkout woocommerce-checkout grid lg:grid-cols-3 gap-8" action="<?php echo esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">

        <div class="lg:col-span-2 space-y-6" id="checkout-accordion">

            <!-- Step 1: Contact & delivery -->
            <section class="bg-white border border-brand-200 rounded-2xl p-6 md:p-8 step-section ring-1 ring-brand-200 shadow-sm transition-all" data-step="1" id="step-1">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3 mb-6">
                    <span class="w-8 h-8 rounded-full bg-brand-600 text-white grid place-items-center text-sm font-semibold step-badge shrink-0">1</span> Contact & delivery
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
                        <button type="button" class="btn-next-step inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" data-target="2">Continue to medical info</button>
                    </div>
                </div>
            </section>

            <!-- Step 2: Medical info -->
            <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 step-section opacity-60 transition-all cursor-pointer hover:border-ink-300" data-step="2" id="step-2">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-ink-100 text-ink-500 grid place-items-center text-sm font-semibold step-badge shrink-0 transition-colors">2</span> Medical info (optional)
                </h2>
                <div class="step-content hidden mt-6 pt-6 border-t border-ink-100">
                    <div class="medical-info-fields-wrapper">
                        <?php do_action( 'woocommerce_checkout_after_customer_details' ); ?>
                    </div>
                    <div class="mt-8 pt-6 border-t border-ink-100 flex items-center gap-4">
                        <button type="button" class="btn-prev-step text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors inline-flex items-center gap-1.5" data-target="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> Back</button>
                        <button type="button" class="btn-next-step inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors" data-target="3">Continue to payment</button>
                    </div>
                </div>
            </section>

            <!-- Step 3: Payment & confirm -->
            <section class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 step-section opacity-60 transition-all cursor-not-allowed" data-step="3" id="step-3">
                <h2 class="font-serif text-xl font-semibold text-ink-900 flex items-center gap-3">
                    <span class="w-8 h-8 rounded-full bg-ink-100 text-ink-500 grid place-items-center text-sm font-semibold step-badge shrink-0 transition-colors">3</span> Payment & confirm
                </h2>
                <div class="step-content hidden mt-6 pt-6 border-t border-ink-100">
                    <?php do_action( 'woocommerce_checkout_before_order_review_heading' ); ?>
                    <?php do_action( 'woocommerce_checkout_before_order_review' ); ?>
                    <div id="order_review" class="woocommerce-checkout-review-order">
                        <?php do_action( 'woocommerce_checkout_order_review' ); ?>
                    </div>
                    <?php do_action( 'woocommerce_checkout_after_order_review' ); ?>
                    <div class="mt-6 pt-6 border-t border-ink-100 flex items-center gap-4">
                        <button type="button" class="btn-prev-step text-sm font-semibold text-ink-700 hover:text-brand-700 transition-colors inline-flex items-center gap-1.5" data-target="2"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill: none !important;" d="m15 18-6-6 6-6"/></svg> Back</button>
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const $ = jQuery;
    
    // Accordion Logic
    function goToStep(stepNum) {
        $('.step-section').each(function() {
            var $sec = $(this);
            var num = parseInt($sec.data('step'));
            if (num === stepNum) {
                // Activate
                $sec.removeClass('opacity-60 cursor-pointer hover:border-ink-300 cursor-not-allowed').addClass('border-brand-200 ring-1 ring-brand-200 shadow-sm');
                $sec.find('.step-content').slideDown(300);
                $sec.find('.step-badge').removeClass('bg-ink-100 text-ink-500 bg-brand-700').addClass('bg-brand-600 text-white').html(num);
                $sec.find('h2').addClass('mb-6');
            } else if (num < stepNum) {
                // Completed
                $sec.removeClass('border-brand-200 ring-1 ring-brand-200 shadow-sm cursor-not-allowed').addClass('opacity-60 cursor-pointer hover:border-ink-300');
                $sec.find('.step-content').slideUp(300);
                $sec.find('.step-badge').removeClass('bg-brand-600 bg-ink-100 text-ink-500 text-white').addClass('bg-brand-700 text-white').html('<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>');
                $sec.find('h2').removeClass('mb-6');
            } else {
                // Future
                $sec.removeClass('border-brand-200 ring-1 ring-brand-200 shadow-sm cursor-pointer hover:border-ink-300').addClass('opacity-60 cursor-not-allowed');
                $sec.find('.step-content').slideUp(300);
                $sec.find('.step-badge').removeClass('bg-brand-600 bg-brand-700 text-white').addClass('bg-ink-100 text-ink-500').html(num);
                $sec.find('h2').removeClass('mb-6');
            }
        });
        
        // Scroll to step
        $('html, body').animate({
            scrollTop: $('#step-' + stepNum).offset().top - 100
        }, 300);
    }
    
    $(document.body).on('click', '.btn-next-step', function() {
        // Optional: Trigger WooCommerce checkout validation here if needed, 
        // but since fields are all in one form, standard submission works at step 3.
        goToStep(parseInt($(this).data('target')));
    });
    
    $(document.body).on('click', '.btn-prev-step', function() {
        goToStep(parseInt($(this).data('target')));
    });
    
    $(document.body).on('click', '.step-section.cursor-pointer', function(e) {
        if ($(e.target).closest('.step-content').length === 0) {
            goToStep(parseInt($(this).data('step')));
        }
    });

    // Copy the live WooCommerce review into the sidebar. The sidebar controls
    // are display proxies only; the inputs inside #order_review remain the
    // canonical checkout fields that WooCommerce submits and replaces via AJAX.
    function updateSidebar() {
        var $source = $('#order_review .review-order-summary-wrapper').first();
        if (!$source.length) {
            return;
        }

        var $sourceInputs = $source.find('input, select, textarea');
        var $wrapper = $source.clone();
        $wrapper.removeClass('hidden'); // Ensure it shows in sidebar

        // jQuery/browser cloning is not consistent for live radio/checkbox
        // properties. Copy those properties explicitly from the refreshed
        // WooCommerce controls, then remove names so the visual proxy cannot
        // create duplicate checkout values during form serialization.
        $wrapper.find('input, select, textarea').each(function(index) {
            var $proxy = $(this);
            var $sourceInput = $sourceInputs.eq(index);
            var originalName = $sourceInput.attr('name');

            if (originalName) {
                $proxy.attr('data-checkout-input-name', originalName);
                $proxy.attr('name', 'proxy_' + originalName);
            }

            if ($proxy.is(':radio, :checkbox')) {
                $proxy.prop('checked', $sourceInput.prop('checked'));
            } else {
                $proxy.val($sourceInput.val());
            }
        });
        
        // Fix duplicate IDs in the cloned sidebar so labels work correctly
        $wrapper.find('[id]').each(function() {
            var oldId = $(this).attr('id');
            var newId = 'sidebar_' + oldId;
            $(this).attr('id', newId);
            
            // Update any labels pointing to this ID within the wrapper
            $wrapper.find('label[for="' + oldId + '"]').attr('for', newId);
        });

        $('.sidebar-summary-container').html($wrapper).css({opacity: 1, transition: 'opacity 0.2s'});
    }
    
    var sidebarRefreshTimer = null;
    $(document.body).on('updated_checkout', function() {
        window.clearTimeout(sidebarRefreshTimer);
        sidebarRefreshTimer = window.setTimeout(updateSidebar, 0);
    });
    
            // Sync sidebar input changes back to the real hidden form
    $(document.body).on('change', '.sidebar-summary-container input', function() {
        var $this = $(this);
        var type = $this.attr('type');
        var name = $this.attr('data-checkout-input-name');

        if (!name) {
            return;
        }
        
        // Add a visual loading state to the sidebar
        $('.sidebar-summary-container').css('opacity', '0.6');
        
        if (type === 'radio') {
            var val = $this.val();
            // Find the real radio in the form and trigger change
            var $realInput = $('#order_review input[name="' + name + '"][value="' + val + '"]');
            if ($realInput.length && !$realInput.prop('checked')) { $realInput.addClass('update_totals_on_change').prop('checked', true).trigger('change'); }
        } else if (type === 'checkbox') {
            var isChecked = $this.prop('checked');
            var $realInput = $('#order_review input[name="' + name + '"]');
            if ($realInput.length && $realInput.prop('checked') !== isChecked) { $realInput.addClass('update_totals_on_change').prop('checked', isChecked).trigger('change'); }
        } else {
            var $realInput = $('#order_review input[name="' + name + '"]');
            if ($realInput.length && $realInput.val() !== $this.val()) { $realInput.addClass('update_totals_on_change').val($this.val()).trigger('change'); }
        }
    });

    // Sync totals from AJAX response manually since DOM replacement is disabled
    $(document.body).on('updated_checkout', function(e, data) {
        if (data && data.fragments && data.fragments['.woocommerce-checkout-review-order-table']) {
            var $newHTML = $(data.fragments['.woocommerce-checkout-review-order-table']);
            
            // Sync Order Total
            var newTotal = $newHTML.find('.order-total .amount').html();
            if (newTotal) {
                $('.order-total .amount').html(newTotal);
                $('.sidebar-summary-container .order-total .amount').html(newTotal);
            }
            
            // Sync Shipping method amounts/labels if they changed
            $newHTML.find('.shipping_method').each(function() {
                var id = $(this).attr('id');
                var $newLabel = $newHTML.find('label[for="' + id + '"]');
                if ($newLabel.length) {
                    $('label[for="' + id + '"]').html($newLabel.html());
                }
            });
            
            // Remove lingering loading overlay
            $('.sidebar-summary-container').css({opacity: 1});
            
            // Update sidebar proxy HTML
            setTimeout(updateSidebar, 50);
        }
    });

    // Initial update
    updateSidebar();
});
</script>

<style>
/* Hide the summary inside Step 3, so it only appears in sidebar */
#step-3 .review-order-summary-wrapper {
    display: none !important;
}
/* Strip WooCommerce default grey background from #payment */
#payment.woocommerce-checkout-payment {
    background: transparent !important;
    border-radius: 0 !important;
    padding: 0 !important;
}
#payment.woocommerce-checkout-payment ul.payment_methods {
    border-bottom: 0 !important;
}
#payment.woocommerce-checkout-payment div.form-row.place-order {
    padding: 0 !important;
    margin: 1.5rem 0 0 !important;
    background: transparent !important;
}
/* Basic styling for WooCommerce fields inside the accordion */
.step-content .form-row {
    margin-bottom: 1.25rem;
}
.step-content .form-row label {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    color: #334155;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 0.5rem;
}
.step-content .form-row .optional {
    text-transform: lowercase;
    font-weight: 400;
    color: #64748b;
}
.step-content .form-row input.input-text,
.step-content .form-row select,
.step-content .form-row textarea {
    width: 100%;
    height: 2.75rem;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    padding: 0 0.75rem;
    font-size: 0.875rem;
    background: #fff;
    outline: none;
    transition: border-color 0.15s;
}
.step-content .form-row textarea {
    height: auto;
    padding: 0.75rem;
}
.step-content .form-row input.input-text:focus,
.step-content .form-row select:focus,
.step-content .form-row textarea:focus {
    border-color: #0d9488;
}
input[type="radio"], input[type="checkbox"] {
    accent-color: #0d9488;
}
#place_order {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    height: 3rem;
    padding: 0 2rem;
    border-radius: 9999px;
    background-color: #0d9488;
    color: white;
    font-weight: 600;
    font-size: 1rem;
    margin-top: 1rem;
    border: none;
    cursor: pointer;
    transition: background-color 0.15s;
    width: auto;
}
#place_order:hover {
    background-color: #0f766e;
}
.woocommerce-privacy-policy-text {
    font-size: 0.875rem;
    color: #64748b;
    margin-bottom: 1.5rem;
}
.wc_payment_methods {
    list-style: none !important;
    padding: 0 !important;
    margin: 0 !important;
    border: 1px solid #e2e8f0;
    border-radius: 0.75rem;
    overflow: hidden;
}
.wc_payment_methods li {
    padding: 1.25rem;
    margin: 0 !important;
    border-bottom: 1px solid #e2e8f0;
    background: #f8fafc;
}
.wc_payment_methods li:last-child {
    border-bottom: none;
}
.wc_payment_methods li input[type="radio"] {
    margin-right: 0.75rem;
}
.wc_payment_methods li label {
    font-weight: 600;
    color: #09152b;
    display: inline-block;
    margin: 0;
}
.wc_payment_methods li .payment_box {
    margin-top: 1rem;
    padding: 1rem;
    background: #fff;
    border-radius: 0.5rem;
    border: 1px solid #e2e8f0;
    font-size: 0.875rem;
    color: #475569;
    position: relative;
}
/* Hide the ugly WooCommerce triangle */
.wc_payment_methods li .payment_box::before {
    display: none !important;
}
.woocommerce-terms-and-conditions-wrapper {
    margin-top: 1.5rem;
    font-size: 0.875rem;
    color: #64748b;
}
.medical-info-fields-wrapper h3 { font-family: "Playfair Display", ui-serif, Georgia, serif; font-size: 1.25rem; font-weight: 600; color: #09152b; margin-bottom: 1.25rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.5rem; } 
</style>















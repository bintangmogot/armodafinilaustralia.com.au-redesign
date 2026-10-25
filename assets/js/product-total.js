document.addEventListener('DOMContentLoaded', function() {
    const qtyInput = document.querySelector('form.cart input.qty');
    const dynamicTotal = document.getElementById('armo-dynamic-total');
    
    if (!dynamicTotal) return;

    let currentPrice = 0;

    // Listen to WooCommerce variation found event (jQuery is required by WooCommerce here)
    if (typeof jQuery !== 'undefined') {
        jQuery('.variations_form').on('show_variation', function(event, variation) {
            if (variation.display_price) {
                currentPrice = variation.display_price;
                updateTotal();
            }
        });

        jQuery('.variations_form').on('hide_variation', function() {
            currentPrice = 0;
            dynamicTotal.innerText = '$0.00';
        });
    }

    // Listen to quantity changes
    if (qtyInput) {
        qtyInput.addEventListener('change', updateTotal);
        qtyInput.addEventListener('keyup', updateTotal);
    }
        
    // Listen to plus/minus buttons globally
    document.addEventListener('click', function(e) {
        if (e.target.closest('.qty-btn')) {
            const btn = e.target.closest('.qty-btn');
            const isPlus = btn.classList.contains('plus');
            
            // Find the specific quantity input for this button
            const wrapper = btn.closest('.quantity');
            if (!wrapper) return;
            const specificQtyInput = wrapper.querySelector('input.qty');
            if (!specificQtyInput) return;
            
            let val = parseInt(specificQtyInput.value) || 1;
            let min = parseInt(specificQtyInput.min) || 1;
            let max = parseInt(specificQtyInput.max) || 9999;
            
            if (isPlus && val < max) {
                specificQtyInput.value = val + 1;
            } else if (!isPlus && val > min) {
                specificQtyInput.value = val - 1;
            }
            
            // Trigger change event
            specificQtyInput.dispatchEvent(new Event('change', { bubbles: true }));
            
            // If it's the main single-product input, update the dynamic total
            if (qtyInput && specificQtyInput === qtyInput) {
                setTimeout(updateTotal, 50);
            }
            
            // If we are on the cart page, auto-click the hidden update button
            const updateCartBtn = document.querySelector('button[name="update_cart"]');
            if (updateCartBtn) {
                updateCartBtn.disabled = false;
                updateCartBtn.click();
            }
        }
    });

    function updateTotal() {
        if (!currentPrice || !qtyInput) return;
        
        let qty = parseInt(qtyInput.value) || 1;
        let total = currentPrice * qty;
        
        // Format to currency
        dynamicTotal.innerText = '$' + total.toFixed(2);
    }
});

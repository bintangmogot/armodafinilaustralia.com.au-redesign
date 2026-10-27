/* Checkout: three-step accordion and the order summary sidebar (moved out of the template). */
jQuery(function () {
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


/* Prescription upload drop zone (Medical Conditions step). */
(function () {
	document.addEventListener('DOMContentLoaded', function () {
		var dropzone = document.getElementById('medical_dropzone');
		var fileInput = document.getElementById('medical_prescription');
		if (!dropzone || !fileInput) { return; }

		var name = document.createElement('p');
		name.className = 'medical-file-name';
		dropzone.appendChild(name);
		var show = function () {
			if (fileInput.files && fileInput.files.length) {
				name.textContent = (dropzone.dataset.selected ? dropzone.dataset.selected + ' ' : '') + fileInput.files[0].name;
			}
		};

		dropzone.addEventListener('dragover', function (e) { e.preventDefault(); dropzone.classList.add('is-over'); });
		dropzone.addEventListener('dragleave', function (e) { e.preventDefault(); dropzone.classList.remove('is-over'); });
		dropzone.addEventListener('drop', function (e) {
			e.preventDefault();
			dropzone.classList.remove('is-over');
			if (e.dataTransfer.files && e.dataTransfer.files.length) { fileInput.files = e.dataTransfer.files; show(); }
		});
		dropzone.addEventListener('click', function (e) {
			if (e.target !== fileInput && e.target.tagName !== 'LABEL') { fileInput.click(); }
		});
		fileInput.addEventListener('change', show);
	});
})();

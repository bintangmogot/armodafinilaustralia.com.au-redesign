/* Single product page: quantity buttons, stepper, ajax add to cart, buy now, share, gallery, reviews. */
(function () {
	var form = document.getElementById('armo-cart-form');

	function formatPrice(amount, forcedDecimals) {
		var decimals = typeof forcedDecimals === 'number' ? forcedDecimals : (parseInt(form ? form.dataset.decimals : '0', 10) || 0);
		return (form ? form.dataset.currency : '') + amount.toLocaleString('en-AU', { minimumFractionDigits: decimals, maximumFractionDigits: decimals });
	}

	// Gallery thumbnails swap the main image.
	var thumbs = document.getElementById('product-thumbs');
	var main = document.querySelector('#product-main-image img');
	if (thumbs && main) {
		thumbs.addEventListener('click', function (e) {
			var button = e.target.closest('button[data-src]');
			if (!button) { return; }
			main.src = button.dataset.src;
			if (button.dataset.srcset) { main.srcset = button.dataset.srcset; }
			thumbs.querySelectorAll('button').forEach(function (b) {
				b.classList.toggle('border-primary', b === button);
				b.classList.toggle('border-border', b !== button);
			});
		});
	}

	if (form) {
		// Quantity stepper.
		form.querySelectorAll('.qty-btn').forEach(function (btn) {
			btn.addEventListener('click', function () {
				var input = form.querySelector('.qty-input');
				var value = parseInt(input.value, 10) || 1;
				value = btn.dataset.action === 'plus' ? value + 1 : Math.max(1, value - 1);
				input.value = value;
			});
		});

		// Quantity buttons (variations).
		var buttons = form.querySelectorAll('.variant-btn');
		var variationInput = form.querySelector('.variation_id');
		var attrBox = document.getElementById('dynamic-attributes-container');
		var priceEl = document.getElementById('dynamic-price');
		var noteEl = document.getElementById('dynamic-per-pill');

		var select = function (btn) {
			buttons.forEach(function (b) {
				var on = b === btn;
				b.classList.toggle('is-active', on);
				b.setAttribute('aria-pressed', on ? 'true' : 'false');
			});
			var price = parseFloat(btn.dataset.price);
			var qty = parseInt(btn.dataset.qty, 10) || 0;
			if (variationInput) { variationInput.value = btn.dataset.vid; }
			if (attrBox) {
				attrBox.textContent = '';
				var attrs = JSON.parse(btn.dataset.attrs || '{}');
				Object.keys(attrs).forEach(function (key) {
					var input = document.createElement('input');
					input.type = 'hidden';
					input.name = key;
					input.value = attrs[key];
					attrBox.appendChild(input);
				});
			}
			if (priceEl) { priceEl.textContent = formatPrice(price); }
			if (noteEl) {
				// Per-unit figure for the chosen pack; falls back to the product's own price note.
				noteEl.textContent = (qty > 1 && form.dataset.unit) ? formatPrice(price / qty, 2) + ' ' + form.dataset.unit : (form.dataset.note || '');
			}
		};
		buttons.forEach(function (btn) { btn.addEventListener('click', function () { select(btn); }); });
		if (buttons.length) { select(buttons[0]); }

		// Add to cart without leaving the page, then refresh the side cart.
		var addToCart = function (done) {
			var submit = form.querySelector('button[name="add-to-cart"]');
			var label = submit ? submit.dataset.label : '';
			if (submit) {
				submit.disabled = true;
				if (form.dataset.adding) { submit.textContent = form.dataset.adding; }
			}
			var data = new FormData(form);
			if (submit) { data.append('add-to-cart', submit.value); }

			fetch(form.dataset.cart, { method: 'POST', body: data, credentials: 'same-origin', headers: { 'X-Requested-With': 'XMLHttpRequest' } })
				.then(function (r) { if (!r.ok) { throw new Error('add to cart failed'); } return r.text(); })
				.then(function () {
					if (done) { done(); return; }
					if (submit && form.dataset.added) { submit.textContent = form.dataset.added; }
					setTimeout(function () { if (submit) { submit.textContent = label; submit.disabled = false; } }, 1800);
					if (window.jQuery) { window.jQuery(document.body).trigger('wc_fragment_refresh'); }
				})
				.catch(function () { if (submit) { submit.textContent = label; submit.disabled = false; } });
		};

		form.addEventListener('submit', function (e) { e.preventDefault(); addToCart(); });

		var buyNow = document.getElementById('buy-now-btn');
		if (buyNow) {
			buyNow.addEventListener('click', function () {
				addToCart(function () { window.location.href = form.dataset.checkout; });
			});
		}

		// Share: native sheet where available, otherwise copy the link.
		var share = document.getElementById('share-btn');
		if (share) {
			share.addEventListener('click', function () {
				if (navigator.share && window.isSecureContext) {
					navigator.share({ title: document.title, url: window.location.href }).catch(function () {});
					return;
				}
				var copy = function () {
					var area = document.createElement('textarea');
					area.value = window.location.href;
					area.style.position = 'fixed';
					area.style.left = '-9999px';
					document.body.appendChild(area);
					area.select();
					try { document.execCommand('copy'); } catch (err) { /* ignore */ }
					document.body.removeChild(area);
				};
				if (navigator.clipboard && window.isSecureContext) {
					navigator.clipboard.writeText(window.location.href).catch(copy);
				} else {
					copy();
				}
				if (form.dataset.copied) { share.setAttribute('title', form.dataset.copied); }
			});
		}
	}

	// Reviews: load more through the existing armo_load_product_reviews endpoint.
	var list = document.getElementById('product-reviews-list');
	var more = document.getElementById('product-reviews-more');
	if (list && more) {
		more.addEventListener('click', function () {
			var label = more.textContent;
			var page = (parseInt(list.dataset.page, 10) || 1) + 1;
			more.disabled = true;
			if (list.dataset.loading) { more.textContent = list.dataset.loading; }

			var body = new URLSearchParams({ action: 'armo_load_product_reviews', product_id: list.dataset.product, page: page });
			fetch(list.dataset.ajax, { method: 'POST', body: body, credentials: 'same-origin' })
				.then(function (r) { return r.json(); })
				.then(function (res) {
					if (res && res.success) {
						list.insertAdjacentHTML('beforeend', res.data.html);
						list.dataset.page = page;
						if (!res.data.has_more) { more.parentNode.removeChild(more); return; }
					}
					more.textContent = label;
					more.disabled = false;
				})
				.catch(function () { more.textContent = label; more.disabled = false; });
		});
	}
})();

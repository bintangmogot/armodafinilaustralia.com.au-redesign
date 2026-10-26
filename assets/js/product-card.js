/* Product cards: quantity buttons update the price and buy link. Carousels: arrow buttons scroll one card. */
(function () {
	document.addEventListener('click', function (e) {
		var pill = e.target.closest('.qty-pill');
		if (pill) {
			var card = pill.closest('[data-product-card]');
			if (!card) { return; }
			card.querySelectorAll('.qty-pill').forEach(function (p) {
				var on = p === pill;
				p.setAttribute('aria-pressed', on ? 'true' : 'false');
				p.classList.toggle('is-active', on);
			});
			var price = card.querySelector('[data-card-price]');
			if (price) { price.innerHTML = pill.getAttribute('data-price'); } // price markup from our own template
			var buy = card.querySelector('[data-card-buy]');
			if (buy && pill.getAttribute('data-url')) { buy.setAttribute('href', pill.getAttribute('data-url')); }
			return;
		}

		var arrow = e.target.closest('[data-carousel-prev], [data-carousel-next]');
		if (arrow) {
			var root = arrow.closest('[data-carousel]');
			var track = root && root.querySelector('[data-carousel-track]');
			if (!track || !track.firstElementChild) { return; }
			var step = track.firstElementChild.getBoundingClientRect().width + 16;
			var forward = arrow.hasAttribute('data-carousel-next');
			var atEnd = track.scrollLeft + track.clientWidth >= track.scrollWidth - 8;
			if (forward && atEnd) {
				track.scrollTo({ left: 0, behavior: 'smooth' });
			} else {
				track.scrollBy({ left: forward ? step : -step, behavior: 'smooth' });
			}
		}
	});
})();

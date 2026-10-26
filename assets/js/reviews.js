/* Reviews page "load more" and the review submission form. */
(function () {
	// Load more: fetch the next page, append its cards, update the pagination block and the count line.
	var wrapper = document.getElementById('reviews-wrapper');
	if (wrapper) {
		wrapper.addEventListener('click', function (e) {
			var button = e.target.closest('#load-more-btn');
			if (!button) { return; }
			e.preventDefault();

			var original = button.textContent;
			button.textContent = wrapper.dataset.loading || original;
			button.style.pointerEvents = 'none';

			fetch(button.getAttribute('href'), { credentials: 'same-origin' })
				.then(function (r) { return r.text(); })
				.then(function (html) {
					var doc = new DOMParser().parseFromString(html, 'text/html');
					var cards = doc.getElementById('reviews-container');
					if (cards) {
						document.getElementById('reviews-container').insertAdjacentHTML('beforeend', cards.innerHTML);
					}
					var pagination = doc.getElementById('reviews-pagination');
					document.getElementById('reviews-pagination').innerHTML = pagination ? pagination.innerHTML : '';

					var shown = document.querySelectorAll('#reviews-container > article').length;
					var line = document.getElementById('aggregate-count-display');
					if (line && wrapper.dataset.showing) {
						line.textContent = wrapper.dataset.showing.replace('{shown}', shown).replace('{total}', wrapper.dataset.total);
					}
				})
				.catch(function () {
					button.textContent = original;
					button.style.pointerEvents = '';
				});
		});
	}

	// Review form.
	var form = document.getElementById('armo-review-form');
	if (!form) { return; }
	var message = document.getElementById('armo-review-message');
	var submit = document.getElementById('review-submit-btn');

	function show(text, ok) {
		message.textContent = text;
		message.className = 'rounded-lg p-4 text-sm font-medium ' + (ok ? 'bg-secondary text-primary' : 'bg-red-50 text-red-800');
	}

	form.addEventListener('submit', function (e) {
		e.preventDefault();
		submit.disabled = true;
		submit.textContent = form.dataset.submitting || submit.textContent;
		message.className = 'hidden';

		fetch(form.dataset.ajax, { method: 'POST', body: new FormData(form), credentials: 'same-origin' })
			.then(function (r) { return r.json(); })
			.then(function (data) {
				var text = data && data.data && data.data.message ? data.data.message : '';
				show(text, !!(data && data.success));
				if (data && data.success) { form.reset(); }
			})
			.catch(function () { show(form.dataset.error || '', false); })
			.then(function () {
				submit.disabled = false;
				submit.textContent = submit.dataset.label;
			});
	});
})();

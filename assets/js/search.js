/* Site search dialog: opens from the header, queries admin-ajax, lists products. */
(function () {
	var dialog = document.getElementById('search-dialog');
	if (!dialog) { return; }

	var input = document.getElementById('search-input');
	var start = document.getElementById('search-start');
	var list = document.getElementById('search-results');
	var empty = document.getElementById('search-empty');
	var category = '';
	var timer = null;
	var request = 0;

	function open() {
		dialog.classList.remove('hidden');
		dialog.classList.add('flex');
		document.body.style.overflow = 'hidden';
		input.focus();
	}

	function close() {
		dialog.classList.add('hidden');
		dialog.classList.remove('flex');
		document.body.style.overflow = '';
	}

	function show(state) {
		start.classList.toggle('hidden', state !== 'start');
		list.classList.toggle('hidden', state !== 'results');
		empty.classList.toggle('hidden', state !== 'empty');
	}

	function render(items) {
		list.textContent = '';
		items.forEach(function (item) {
			var li = document.createElement('li');
			var a = document.createElement('a');
			a.href = item.url;
			a.className = 'flex items-center gap-3 rounded-lg p-2.5 hover:bg-secondary';
			var img = document.createElement('img');
			img.src = item.image;
			img.alt = '';
			img.width = 48;
			img.height = 48;
			img.loading = 'lazy';
			img.className = 'h-12 w-12 shrink-0 rounded-md border border-border bg-white object-cover';
			var text = document.createElement('div');
			text.className = 'min-w-0 flex-1';
			var title = document.createElement('p');
			title.className = 'truncate text-sm font-semibold text-primary';
			title.textContent = item.title;
			var price = document.createElement('p');
			price.className = 'text-sm text-muted-foreground';
			price.innerHTML = item.price; // WooCommerce price markup from our own endpoint.
			text.appendChild(title);
			text.appendChild(price);
			a.appendChild(img);
			a.appendChild(text);
			li.appendChild(a);
			list.appendChild(li);
		});
	}

	function search(query) {
		var id = ++request;
		var url = dialog.dataset.ajax + '?action=armodafinil_search&q=' + encodeURIComponent(query) + '&cat=' + encodeURIComponent(category);
		fetch(url, { credentials: 'same-origin' })
			.then(function (r) { return r.json(); })
			.then(function (data) {
				if (id !== request) { return; }
				if (data.success && data.data && data.data.length) {
					render(data.data);
					show('results');
				} else {
					empty.textContent = (dialog.dataset.noResults || '').replace('{query}', query);
					show('empty');
				}
			})
			.catch(function () { show('start'); });
	}

	function run() {
		var query = input.value.trim();
		clearTimeout(timer);
		if (query.length < 2) { show('start'); return; }
		timer = setTimeout(function () { search(query); }, 250);
	}

	document.addEventListener('click', function (e) {
		if (e.target.closest('#header-search-trigger, [data-search-open]')) { open(); }
		if (e.target.closest('[data-search-close]')) { close(); }
		var pop = e.target.closest('.search-popular');
		if (pop) { input.value = pop.textContent; run(); }
		var cat = e.target.closest('.search-cat');
		if (cat) {
			category = cat.dataset.cat || '';
			dialog.querySelectorAll('.search-cat').forEach(function (b) { b.classList.toggle('is-active', b === cat); });
			run();
		}
	});

	document.addEventListener('keydown', function (e) {
		if ((e.ctrlKey || e.metaKey) && e.key.toLowerCase() === 'k') {
			e.preventDefault();
			if (dialog.classList.contains('hidden')) { open(); } else { close(); }
		}
		if (e.key === 'Escape' && !dialog.classList.contains('hidden')) { close(); }
	});

	input.addEventListener('input', run);
})();

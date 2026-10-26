/* Header behaviour: mobile drawer and shadow on scroll. */
(function () {
	var header = document.getElementById('site-header');
	var button = document.getElementById('mobile-menu-btn');
	var drawer = document.getElementById('mobile-drawer');

	if (button && drawer) {
		button.addEventListener('click', function () {
			var open = drawer.classList.toggle('hidden') === false;
			button.setAttribute('aria-expanded', open ? 'true' : 'false');
		});
	}

	if (header) {
		var onScroll = function () { header.classList.toggle('shadow-sm', window.scrollY > 8); };
		window.addEventListener('scroll', onScroll, { passive: true });
		onScroll();
	}

	// Wide tables scroll sideways inside their own box instead of widening the page.
	document.querySelectorAll('.armo-prose table').forEach(function (table) {
		if (table.parentNode.classList.contains('armo-table-wrapper')) { return; }
		var wrap = document.createElement('div');
		wrap.className = 'armo-table-wrapper';
		table.parentNode.insertBefore(wrap, table);
		wrap.appendChild(table);
	});
})();

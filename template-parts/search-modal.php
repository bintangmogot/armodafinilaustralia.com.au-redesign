<div id="cmdk-search-modal" class="fixed inset-0 z-[100] flex items-start justify-center pt-20 px-4 sm:px-6 hidden" aria-modal="true" role="dialog">
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-ink-900/40 backdrop-blur-sm transition-opacity" id="cmdk-backdrop"></div>

    <!-- Modal Panel -->
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-2xl flex flex-col overflow-hidden transform transition-all shadow-[0_20px_60px_-15px_rgba(0,0,0,0.15)] ring-1 ring-ink-200">
        
        <!-- Search Input Header -->
        <div class="p-4 sm:p-5 border-b border-ink-100/80">
            <div class="relative flex items-center h-14 bg-white rounded-xl border-2 border-brand-300 focus-within:border-brand-500 focus-within:ring-4 focus-within:ring-brand-500/10 transition-all shadow-[0_0_0_1px_rgba(94,234,212,0.5)_inset]">
                <div class="pl-4 pr-3 text-brand-600 shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input type="text" id="cmdk-input" class="flex-1 h-full bg-transparent border-0 outline-none text-ink-900 text-lg placeholder:text-ink-400 placeholder:font-medium" placeholder="Search medicines, brands, strengths..." autocomplete="off">
                <button type="button" id="cmdk-close" class="px-4 text-ink-400 hover:text-ink-700 transition-colors shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                </button>
            </div>
            
            <!-- Filters -->
            <div class="mt-4 flex items-center gap-2 px-1">
                <span class="text-[11px] font-bold tracking-widest text-ink-400 uppercase mr-2">Look in</span>
<button data-cat="" class="cat-filter px-3.5 py-1.5 rounded-full text-xs font-semibold bg-brand-600 text-white shadow-sm hover:bg-brand-700 transition-colors">All</button>
<button data-cat="18" class="cat-filter px-3.5 py-1.5 rounded-full text-xs font-semibold bg-ink-50 text-ink-600 hover:bg-ink-100 border border-ink-200/60 transition-colors">Armodafinil</button>
<button data-cat="19" class="cat-filter px-3.5 py-1.5 rounded-full text-xs font-semibold bg-ink-50 text-ink-600 hover:bg-ink-100 border border-ink-200/60 transition-colors">Modafinil</button>
</div>
        </div>

        <!-- Results Area -->
        <div id="cmdk-results" class="max-h-[60vh] overflow-y-auto p-2">
            <!-- Empty State / Initial -->
            <div id="cmdk-empty-state" class="py-16 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 rounded-full border-2 border-ink-100 flex items-center justify-center text-ink-300 mb-6 bg-white shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <h3 class="font-bold text-ink-900 text-lg mb-2">Start typing to search</h3>
                <p class="text-ink-500 text-sm mb-8">Find medicines across our Australian catalog</p>
                
                <div class="flex items-center gap-2">
                    <span class="text-xs font-medium text-ink-400 mr-1">Popular:</span>
                    <button class="popular-pill px-3 py-1.5 rounded-full border border-ink-200 text-xs font-semibold text-ink-700 hover:border-brand-300 hover:text-brand-700 transition-colors bg-white shadow-sm">Armodafinil</button>
                    <button class="popular-pill px-3 py-1.5 rounded-full border border-ink-200 text-xs font-semibold text-ink-700 hover:border-brand-300 hover:text-brand-700 transition-colors bg-white shadow-sm">Artvigil</button>
                    <button class="popular-pill px-3 py-1.5 rounded-full border border-ink-200 text-xs font-semibold text-ink-700 hover:border-brand-300 hover:text-brand-700 transition-colors bg-white shadow-sm">Waklert</button>
                </div>
            </div>

            <!-- Loading State -->
            <div id="cmdk-loading" class="hidden py-16 flex flex-col items-center justify-center">
                <svg class="animate-spin h-8 w-8 text-brand-500 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <p class="text-ink-500 text-sm font-medium">Searching...</p>
            </div>

            <!-- Results List -->
            <ul id="cmdk-results-list" class="hidden"></ul>
            
            <!-- No Results -->
            <div id="cmdk-no-results" class="hidden py-16 text-center">
                <p class="text-ink-900 font-semibold mb-1">No results found for "<span id="cmdk-query-text" class="text-brand-600"></span>"</p>
                <p class="text-ink-500 text-sm">Please check your spelling or try another term.</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-ink-50/50 border-t border-ink-100 p-4 text-center">
            <p class="text-xs font-medium text-ink-400">Press <kbd class="bg-white border border-ink-200 rounded px-1.5 py-0.5 font-sans mx-1 shadow-sm text-[10px] text-ink-500">Ctrl K</kbd> anywhere to open search</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('cmdk-search-modal');
    const backdrop = document.getElementById('cmdk-backdrop');
    const trigger = document.getElementById('header-search-trigger');
    const closeBtn = document.getElementById('cmdk-close');
    const input = document.getElementById('cmdk-input');
    const emptyState = document.getElementById('cmdk-empty-state');
    const loadingState = document.getElementById('cmdk-loading');
    const resultsList = document.getElementById('cmdk-results-list');
    const noResults = document.getElementById('cmdk-no-results');
    const queryText = document.getElementById('cmdk-query-text');
    
    let searchTimeout = null;

    function openModal() {
        modal.classList.remove('hidden');
        setTimeout(() => input.focus(), 50);
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    if(trigger) trigger.addEventListener('click', openModal);
    backdrop.addEventListener('click', closeModal);
    closeBtn.addEventListener('click', closeModal);

    // Keyboard shortcut
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'k') {
            e.preventDefault();
            if(modal.classList.contains('hidden')) {
                openModal();
            } else {
                closeModal();
            }
        }
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeModal();
        }
    });

    // Popular pills
    document.querySelectorAll('.popular-pill').forEach(pill => {
        pill.addEventListener('click', function() {
            input.value = this.innerText;
            performSearch(this.innerText);
        });
    });

    input.addEventListener('input', function(e) {
        const query = e.target.value.trim();
        
        clearTimeout(searchTimeout);
        
        if (query.length === 0) {
            showState('empty');
            return;
        }

        if (query.length < 2) return;

        searchTimeout = setTimeout(() => {
            performSearch(query);
        }, 300);
    });

    function showState(state) {
        emptyState.classList.add('hidden');
        loadingState.classList.add('hidden');
        resultsList.classList.add('hidden');
        noResults.classList.add('hidden');

        if (state === 'empty') emptyState.classList.remove('hidden');
        if (state === 'loading') loadingState.classList.remove('hidden');
        if (state === 'results') resultsList.classList.remove('hidden');
        if (state === 'no-results') noResults.classList.remove('hidden');
    }

    let activeCategory = '';

    document.querySelectorAll('.cat-filter').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.cat-filter').forEach(b => {
                b.className = 'cat-filter px-3.5 py-1.5 rounded-full text-xs font-semibold bg-ink-50 text-ink-600 hover:bg-ink-100 border border-ink-200/60 transition-colors';
            });
            this.className = 'cat-filter px-3.5 py-1.5 rounded-full text-xs font-semibold bg-brand-600 text-white shadow-sm hover:bg-brand-700 transition-colors';
            activeCategory = this.getAttribute('data-cat');
            const q = input.value.trim();
            if (q.length >= 2) performSearch(q);
        });
    });

    function performSearch(query) {
        showState('loading');
        
        fetch('<?php echo admin_url('admin-ajax.php'); ?>?action=armodafinil_search&q=' + encodeURIComponent(query) + '&cat=' + activeCategory)
            .then(res => res.json())
            .then(data => {
                if (data.success && data.data && data.data.length > 0) {
                    renderResults(data.data);
                    showState('results');
                } else {
                    queryText.innerText = query;
                    showState('no-results');
                }
            })
            .catch(() => {
                showState('empty');
            });
    }

    function renderResults(products) {
        resultsList.innerHTML = products.map(product => `
            <li>
                <a href="${product.url}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-ink-50 transition-colors group border border-transparent hover:border-ink-200">
                    <img src="${product.image}" alt="" class="w-12 h-12 rounded-lg object-cover border border-ink-100 bg-white">
                    <div class="flex-1 min-w-0">
                        <h4 class="font-semibold text-ink-900 group-hover:text-brand-600 transition-colors truncate">${product.title}</h4>
                        <div class="text-sm font-medium text-ink-500 mt-0.5 flex flex-col">
                            <div class="whitespace-nowrap [&>span]:!font-medium [&>del]:font-normal [&>del]:text-[12px] [&>ins]:no-underline">${product.price.replace(' - ', ' &ndash; ')}</div>
                            ${product.price_per_unit ? `<span class="text-[10px] text-ink-400 font-medium">` + product.price_per_unit + `</span>` : ""}
                        </div>
                    </div>
                    <div class="shrink-0 text-brand-600 opacity-0 group-hover:opacity-100 transition-opacity pr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </div>
                </a>
            </li>
        `).join('');
    }
});
</script>

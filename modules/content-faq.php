<?php
/**
 * FAQ Module Template (Advanced JS Filter)
 * 
 * Data provided by ACF Sub Fields: faq_categories
 */

$raw_categories = get_sub_field('faq_categories');
$categories = array('All topics');
$faqs = array();

// Support Block Fields
$support_title    = get_sub_field('support_title') ?: 'Still need help?';
$support_subtitle = get_sub_field('support_subtitle') ?: 'Our pharmacy support team typically responds within one business day.';
$support_email    = get_sub_field('support_email');
$support_btn_text = get_sub_field('support_btn_text') ?: 'Contact us';
$support_btn_url  = get_sub_field('support_btn_url') ?: '/contact';

// Default icons mapping for fallback
$icons = array(
    'All topics' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-help-circle w-4 h-4"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>',
    'package' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-4 h-4"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>',
    'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card w-4 h-4"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
    'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>',
    'user' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user w-4 h-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
);
$category_icons = array();

if ( !empty( $raw_categories ) ) {
    foreach ( $raw_categories as $cat ) {
        if ( empty($cat['cat_name']) ) continue;
        
        $cat_name = $cat['cat_name'];
        $categories[] = $cat_name;
        
        $icon_name = !empty($cat['cat_icon']) ? $cat['cat_icon'] : 'help-circle';
        $category_icons[$cat_name] = isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['All topics'];
        
        if ( !empty($cat['faqs']) ) {
            foreach ( $cat['faqs'] as $faq ) {
                $faqs[] = array(
                    'category' => $cat_name,
                    'question' => $faq['question'],
                    'answer'   => $faq['answer'],
                );
            }
        }
    }
} else {
    // Fallback data if module is empty
    $categories = array('All topics', 'Ordering', 'Payment', 'Shipping', 'Account');
    $category_icons = array(
        'Ordering' => $icons['package'],
        'Payment' => $icons['credit-card'],
        'Shipping' => $icons['truck'],
        'Account' => $icons['user'],
    );
    $faqs = array(
        array('category' => 'Ordering', 'question' => 'How do I place an order?', 'answer' => 'Pick your product and pack size, add it to your cart, then complete checkout with your delivery details. A confirmation email with payment instructions will land in your inbox shortly after.'),
        array('category' => 'Payment', 'question' => 'What payment methods do you accept?', 'answer' => 'We accept Australian bank transfer, major cards through our encrypted gateway, and a handful of supported cryptocurrencies. Every transaction is processed on a secure, PCI-aligned checkout.'),
        array('category' => 'Shipping', 'question' => 'When is shipping free?', 'answer' => 'Orders above A$299 qualify for complimentary Australia-wide dispatch, plus 10% off with code ARMD10 applied at checkout.'),
        array('category' => 'Payment', 'question' => 'Do you offer discounts?', 'answer' => 'Yes � new-customer welcome codes, bundle savings for larger pack sizes, and the ongoing ARMD10 code work in combination with our free-shipping threshold.'),
        array('category' => 'Shipping', 'question' => 'How long does delivery take?', 'answer' => 'Most Australian metropolitan addresses receive their parcel within 6�12 business days. Regional and remote postcodes may take a few days longer during peak periods.'),
        array('category' => 'Ordering', 'question' => 'Do I need a prescription?', 'answer' => 'Australian regulations may require a prescription depending on your circumstances. We recommend a chat with your GP or our support team before you order for personal use.'),
        array('category' => 'Shipping', 'question' => 'Is my order discreet?', 'answer' => 'Every parcel ships in neutral outer packaging � no brand names, product references, or clinical branding are printed on the outside.'),
        array('category' => 'Ordering', 'question' => 'What is your return policy?', 'answer' => 'Sealed, unopened items can be returned within 14 days of delivery. Email support with your order number and we will send return instructions the next business day.'),
        array('category' => 'Account', 'question' => 'Do I need an account?', 'answer' => 'No � checkout works fine as a guest. Creating an account simply speeds up future orders and gives you a running history of shipments and tracking links.'),
        array('category' => 'Account', 'question' => 'How do I contact support?', 'answer' => 'WhatsApp is fastest during business hours, or email support@armodafinildirect.example anytime. Our team usually replies within one business day.'),
    );
}
?>

<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-10" id="faq-app">
    
    <!-- Filter Buttons -->
    <div class="flex flex-wrap gap-2 justify-center">
        <?php foreach ($categories as $cat) : ?>
            <button type="button" 
                data-faq-cat="<?php echo esc_attr($cat); ?>"
                class="faq-cat-btn inline-flex items-center gap-2 text-sm font-medium px-4 h-10 rounded-full border transition-colors <?php echo $cat === 'All topics' ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">
                <?php echo $cat === 'All topics' ? $icons['All topics'] : (isset($category_icons[$cat]) ? $category_icons[$cat] : $icons['All topics']); ?> <?php echo esc_html($cat); ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Search Bar -->
    <div class="mt-6 flex items-center bg-white border border-ink-200 rounded-full px-4 h-12 max-w-2xl mx-auto shadow-soft focus-within:border-brand-500 focus-within:ring-1 focus-within:ring-brand-500 transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search w-4 h-4 text-ink-500"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        <input type="text" id="faq-search" placeholder="Search questions..." class="bg-transparent outline-none border-0 text-sm flex-1 mx-3 text-ink-900 placeholder-ink-400 focus:ring-0 focus:outline-none" />
    </div>

    <!-- FAQ Items -->
    <div class="mt-8 space-y-3" id="faq-list">
        <p id="faq-empty" class="text-center text-ink-500 py-16 hidden">No answers match your search. Try a different keyword.</p>
        
        <?php foreach ( $faqs as $index => $f ) : 
            $item_cat = isset($f['category']) ? $f['category'] : 'Ordering';
        ?>
            <div class="faq-item border border-ink-200 rounded-2xl bg-white overflow-hidden transition-colors" data-cat="<?php echo esc_attr($item_cat); ?>" data-text="<?php echo esc_attr(strtolower($f['question'] . ' ' . $f['answer'])); ?>">
                <button type="button" class="faq-toggle w-full flex items-center gap-4 text-left px-5 py-4 focus:outline-none">
                    <span class="faq-num w-8 h-8 grid place-items-center rounded-lg text-sm font-semibold shrink-0 bg-brand-50 text-brand-700 transition-colors"><?php echo $index + 1; ?></span>
                    <span class="flex-1 font-medium text-ink-900"><?php echo esc_html($f['question']); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="faq-chevron lucide lucide-chevron-down w-4 h-4 text-ink-500 transition-transform"><path d="m6 9 6 6 6-6"/></svg>
                </button>
                <div class="faq-content hidden p-5 text-sm text-ink-700 leading-relaxed flex gap-3 items-start border-t border-transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-help-circle w-4 h-4 text-brand-600 mt-1 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                    <span><?php echo wp_kses_post( wpautop( $f['answer'] ) ); ?></span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Support Block -->
    <div class="mt-14 bg-white border border-ink-200 rounded-2xl p-8 text-center shadow-soft">
        <h2 class="font-serif text-2xl font-semibold text-ink-900"><?php echo esc_html($support_title); ?></h2>
        <p class="mt-2 text-ink-700"><?php echo esc_html($support_subtitle); ?></p>
        <div class="mt-5 flex flex-wrap gap-3 justify-center">
            <?php if ( $support_email ) : ?>
                <a href="mailto:<?php echo esc_attr($support_email); ?>" class="inline-flex items-center gap-2 h-11 px-5 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-4 h-4"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    <?php echo esc_html($support_email); ?>
                </a>
            <?php endif; ?>
            <?php if ( $support_btn_text && $support_btn_url ) : ?>
                <a href="<?php echo esc_url($support_btn_url); ?>" class="inline-flex items-center gap-2 h-11 px-5 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                    <?php echo esc_html($support_btn_text); ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            <?php endif; ?>
        </div>
        <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 justify-center text-xs text-ink-500">
            <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> Verified pharmacy</span>
            <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-credit-card w-3.5 h-3.5 text-brand-600"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg> Secure checkout</span>
            <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-3.5 h-3.5 text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> AU-wide delivery</span>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const app = document.getElementById('faq-app');
    if (!app) return;

    let currentCat = 'All topics';
    let searchQuery = '';
    
    const catBtns = app.querySelectorAll('.faq-cat-btn');
    const searchInput = document.getElementById('faq-search');
    const faqItems = app.querySelectorAll('.faq-item');
    const emptyMsg = document.getElementById('faq-empty');

    function filterFaqs() {
        let visibleCount = 0;
        
        faqItems.forEach((item, index) => {
            const itemCat = item.getAttribute('data-cat');
            const itemText = item.getAttribute('data-text');
            
            const matchCat = currentCat === 'All topics' || currentCat === itemCat;
            const matchSearch = searchQuery === '' || itemText.includes(searchQuery);
            
            if (matchCat && matchSearch) {
                item.style.display = 'block';
                visibleCount++;
                // Reset numbering based on visible order
                item.querySelector('.faq-num').textContent = visibleCount;
                
                // Open by default when filtering
                openItem(item);
            } else {
                item.style.display = 'none';
            }
        });
        
        // Hide/show empty message
        if (visibleCount > 0) {
            emptyMsg.classList.add('hidden');
        } else {
            emptyMsg.classList.remove('hidden');
        }
    }

    function closeItem(item) {
        item.classList.remove('border-brand-500', 'shadow-card');
        item.classList.add('border-ink-200');
        
        const num = item.querySelector('.faq-num');
        num.classList.remove('bg-brand-600', 'text-white');
        num.classList.add('bg-brand-50', 'text-brand-700');
        
        const chevron = item.querySelector('.faq-chevron');
        chevron.classList.remove('rotate-180', 'text-brand-600');
        
        item.querySelector('.faq-content').classList.add('hidden');
    }

    function openItem(item) {
        item.classList.remove('border-ink-200');
        item.classList.add('border-brand-500', 'shadow-card');
        
        const num = item.querySelector('.faq-num');
        num.classList.remove('bg-brand-50', 'text-brand-700');
        num.classList.add('bg-brand-600', 'text-white');
        
        const chevron = item.querySelector('.faq-chevron');
        chevron.classList.add('rotate-180', 'text-brand-600');
        
        item.querySelector('.faq-content').classList.remove('hidden');
    }

    // Initialize toggles
    faqItems.forEach(item => {
        const toggle = item.querySelector('.faq-toggle');
        toggle.addEventListener('click', () => {
            const isOpen = !item.querySelector('.faq-content').classList.contains('hidden');
            
            // Toggle clicked
            if (!isOpen) {
                openItem(item);
            } else {
                closeItem(item);
            }
        });
    });

    // Initialize category buttons
    catBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            currentCat = btn.getAttribute('data-faq-cat');
            
            // Update active state
            catBtns.forEach(b => {
                b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600');
                b.classList.add('bg-white', 'text-ink-700', 'border-ink-200', 'hover:border-brand-600');
            });
            btn.classList.remove('bg-white', 'text-ink-700', 'border-ink-200', 'hover:border-brand-600');
            btn.classList.add('bg-brand-600', 'text-white', 'border-brand-600');
            
            filterFaqs();
        });
    });

    // Initialize search
    searchInput.addEventListener('input', (e) => {
        searchQuery = e.target.value.toLowerCase();
        filterFaqs();
    });

    // Run initial filter to open first item
    filterFaqs();
});
</script>





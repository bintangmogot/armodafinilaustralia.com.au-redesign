<?php
/**
 * Simple FAQ Module Template (No Categories)
 */

$title    = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$faqs     = get_sub_field('faqs');
?>

<section class="py-16 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?php if ( $title || $subtitle ) : ?>
            <div class="text-center mb-10">
                <?php if ( $title ) : ?>
                    <h2 class="font-serif text-3xl sm:text-4xl font-bold text-ink-900 leading-tight mb-4"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ( $subtitle ) : ?>
                    <p class="text-lg text-ink-600 max-w-2xl mx-auto"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <?php if ( !empty($faqs) ) : ?>
            <div class="flex flex-col gap-4">
                <?php foreach ( $faqs as $index => $f ) : ?>
                    <div class="faq-item border border-ink-200 rounded-2xl bg-white overflow-hidden transition-colors">
                        <button type="button" class="faq-toggle w-full flex items-center gap-4 text-left px-5 py-4 focus:outline-none hover:bg-ink-50 transition-colors bg-ink-50">
                            <span class="faq-num w-8 h-8 grid place-items-center rounded-lg text-sm font-semibold shrink-0 bg-brand-50 text-brand-700 transition-colors"><?php echo $index + 1; ?></span>
                            <span class="flex-1 font-medium text-ink-900"><?php echo esc_html($f['question']); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="faq-chevron lucide lucide-chevron-down w-4 h-4 text-ink-500 transition-transform" style="transform: rotate(180deg);"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        <div class="faq-content p-5 text-sm text-ink-700 leading-relaxed flex gap-3 items-start border-t border-transparent">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-help-circle w-4 h-4 text-brand-600 mt-1 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                            <span><?php echo wp_kses_post( wpautop( $f['answer'] ) ); ?></span>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        
    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const faqToggles = document.querySelectorAll('.faq-item .faq-toggle');
    faqToggles.forEach(toggle => {
        // Prevent double-binding if multiple modules exist by marking them
        if (toggle.dataset.bound === 'true') return;
        toggle.dataset.bound = 'true';
        
        toggle.addEventListener('click', function() {
            const content = this.nextElementSibling;
            const chevron = this.querySelector('.faq-chevron');
            
            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                chevron.style.transform = 'rotate(180deg)';
                this.classList.add('bg-ink-50');
            } else {
                content.classList.add('hidden');
                chevron.style.transform = '';
                this.classList.remove('bg-ink-50');
            }
        });
    });
});
</script>


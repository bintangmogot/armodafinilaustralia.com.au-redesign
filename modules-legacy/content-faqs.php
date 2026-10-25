<?php
/**
 * Layout: FAQs
 * Fields: faq_title (text), faqs (repeater: question (text), answer (wysiwyg))
 * Design: White background, centered heading, dark blue accordion cards with plus/minus icons
 */
$faq_title = get_sub_field('faq_title');
$faq_id = 'faq-' . uniqid();
?>
<section class="py-14 lg:py-16 px-6 lg:px-12 bg-white">
    <div class="max-w-4xl mx-auto">
        <?php if ($faq_title) : ?>
            <h3 class="text-2xl lg:text-3xl font-bold text-center text-primary mb-10"><?php echo esc_html($faq_title); ?></h3>
        <?php endif; ?>

        <?php if (have_rows('faqs')) : ?>
            <div class="space-y-4" id="<?php echo esc_attr($faq_id); ?>">
                <?php $i = 0; while (have_rows('faqs')) : the_row(); 
                    $question = get_sub_field('question');
                    $answer   = get_sub_field('answer');
                ?>
                    <details class="bg-gradient-review rounded-xl shadow-sm group overflow-hidden" open>
                        <summary class="cursor-pointer list-none flex justify-between items-center px-6 md:px-8 py-5 hover:bg-[#1a51a3] transition-colors">
                            <h3 class="font-bold text-base md:text-lg text-white pr-4 m-0 leading-snug"><?php echo esc_html($question); ?></h3>
                            
                            <!-- Plus icon (shown when closed) -->
                            <svg class="w-6 h-6 text-white block group-open:hidden flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            
                            <!-- Minus icon (shown when open) -->
                            <svg class="w-6 h-6 text-white hidden group-open:block flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </summary>
                        <div class="px-6 md:px-8 pb-6 text-white/90 leading-relaxed text-base md:text-lg module-faqs-content">
                            <?php echo armo_content($answer); ?>
                        </div>
                    </details>
                <?php $i++; endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ FAQs module - add FAQ items in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

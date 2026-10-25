<?php
/**
 * Layout: Text - Left Aligned (Repeater)
 * Fields: sections (repeater) -> content (wysiwyg)
 * Design: White background, left-aligned text with dark navy headings, separated by dividers
 */
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-white overflow-hidden">
    <div class="max-w-4xl mx-auto">
        <?php if (have_rows('sections')) : ?>
            <div class="module-text-left-content prose max-w-none text-left text-base lg:text-lg text-[#1E1E1E] leading-relaxed">
                <?php while (have_rows('sections')) : the_row(); ?>
                    
                    <hr class="border-t border-gray-300 my-10">

                    <div class="text-left-section">
                        <?php echo armo_content(get_sub_field('content')); ?>
                    </div>

                <?php endwhile; ?>
                
                <hr class="border-t border-gray-300 mt-10">
            </div>
        <?php else : ?>
            <p class="text-[#1E1E1E] italic">[ Text Left Aligned module - add sections in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

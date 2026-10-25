<?php
/**
 * Layout: CTA
 * Fields: content (wysiwyg)
 * Design: Navy blue gradient background with centered text and CTA button
 */
$content = get_sub_field('content');
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-gradient-to-r from-primary-dark to-[#162070] text-white">
    <div class="max-w-4xl mx-auto text-center">
        <?php if ($content) : ?>
            <div class="module-cta-content"><?php echo armo_content($content); ?></div>
        <?php else : ?>
            <p class="text-white/30 italic">[ CTA module - add content in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

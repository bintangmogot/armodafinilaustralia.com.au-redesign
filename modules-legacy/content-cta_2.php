<?php
/**
 * Layout: CTA 2
 * Fields: content (wysiwyg)
 */
$content = get_sub_field('content');
?>
<section class="py-16 px-4 bg-gray-900 text-white">
    <div class="max-w-3xl mx-auto text-center">
        <?php if ($content) : ?>
            <div class="prose prose-invert prose-lg mx-auto"><?php echo armo_content($content); ?></div>
        <?php else : ?>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Layout: Text - 1/2 & 1/2
 * Fields: content_left (wysiwyg), content_right (wysiwyg)
 */
$content_left  = get_sub_field('content_left');
$content_right = get_sub_field('content_right');
?>
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8">
        <div class="prose">
            <?php echo $content_left ? armo_content($content_left) : '<p class="text-gray-400 italic">[ Left column - add content in ACF ]</p>'; ?>
        </div>
        <div class="prose">
            <?php echo $content_right ? armo_content($content_right) : '<p class="text-gray-400 italic">[ Right column - add content in ACF ]</p>'; ?>
        </div>
    </div>
</section>

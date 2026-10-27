<?php
/**
 * Layout: Text - 2/3 & 1/3
 * Fields: content_left (wysiwyg), content_right (wysiwyg)
 */
$content_left  = get_sub_field('content_left');
$content_right = get_sub_field('content_right');
?>
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto grid md:grid-cols-3 gap-8">
        <div class="md:col-span-2 prose">
            <?php echo $content_left ? armo_content($content_left) : ''; ?>
        </div>
        <div class="prose">
            <?php echo $content_right ? armo_content($content_right) : ''; ?>
        </div>
    </div>
</section>

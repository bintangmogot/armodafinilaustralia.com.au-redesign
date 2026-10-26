<?php
/**
 * Layout: Text - Side Image
 * Fields: image (image, return_format=id), content (wysiwyg)
 * Design: Navy/dark blue gradient background, text left, image right
 */
$image   = get_sub_field('image');
$content = get_sub_field('content');
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-gradient-to-br from-primary-dark via-[#0f1a5e] to-[#162070] text-white overflow-hidden">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-10 lg:gap-16 items-center">
        <!-- Text Content -->
        <div>
            <?php if ($content) : ?>
                <div class="module-side-image-content">
                    <?php echo armo_content($content); ?>
                </div>
            <?php else : ?>
            <?php endif; ?>
        </div>

        <!-- Image -->
        <div class="relative">
            <?php if ($image) : ?>
                <div class="rounded-2xl overflow-hidden shadow-2xl shadow-black/30">
                    <?php echo wp_get_attachment_image($image, 'large', false, array('class' => 'w-full h-auto object-cover')); ?>
                </div>
            <?php else : ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php
/**
 * Layout: Boxes
 * Fields: boxes (repeater: image (image, return=id), content (wysiwyg))
 * Design: White bg, 3x2 grid of feature cards with icons, titles, descriptions
 */
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-white">
    <div class="max-w-7xl mx-auto">
        <?php if (have_rows('boxes')) : ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <?php while (have_rows('boxes')) : the_row();
                    $image   = get_sub_field('image');
                    $content = get_sub_field('content');
                ?>
                    <div class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary-dark/5 transition-all duration-300 border border-transparent hover:border-primary-dark/10">
                        <?php if ($image) : ?>
                            <div class="mb-5">
                                <?php echo wp_get_attachment_image($image, 'thumbnail', false, array('class' => 'w-12 h-12 lg:w-14 lg:h-14')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($content) : ?>
                            <div class="module-boxes-content">
                                <?php echo armo_content($content); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ Boxes module - add box items in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

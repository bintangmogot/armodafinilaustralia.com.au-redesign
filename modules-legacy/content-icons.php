<?php
/**
 * Layout: Icons
 * Fields: intro_content (wysiwyg), icons (repeater: icon (image, return=id), title (wysiwyg))
 * Design: Dark navy strip with icon + label pairs in a horizontal row
 */
$intro_content = get_sub_field('intro_content');
?>
<section class="py-6 lg:py-8 px-6 lg:px-12 bg-primary-dark">
    <div class="max-w-7xl mx-auto">
        <?php if ($intro_content) : ?>
            <div class="text-center text-white/80 mb-6 text-base"><?php echo armo_content($intro_content); ?></div>
        <?php endif; ?>
        
        <?php if (have_rows('icons')) : ?>
            <div class="flex flex-wrap justify-center items-center gap-6 lg:gap-12">
                <?php while (have_rows('icons')) : the_row(); 
                    $icon  = get_sub_field('icon');
                    $title = get_sub_field('title');
                ?>
                    <div class="flex items-center gap-3 text-white">
                        <?php if ($icon) : ?>
                            <div class="flex-shrink-0">
                                <?php echo wp_get_attachment_image($icon, 'thumbnail', false, array('class' => 'w-8 h-8 lg:w-10 lg:h-10 brightness-0 invert')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($title) : ?>
                            <div class="text-sm lg:text-base font-medium text-white/90 leading-tight"><?php echo armo_content($title); ?></div>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-white/30 text-center italic text-sm">[ Icons module - add icon items in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

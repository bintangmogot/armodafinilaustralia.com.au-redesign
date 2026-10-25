<?php
/**
 * Layout: Icons 2
 * Fields: icon_2 (repeater: icon (image, return=id), content (text))
 */
?>
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <?php if (have_rows('icon_2')) : ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
                <?php while (have_rows('icon_2')) : the_row();
                    $icon    = get_sub_field('icon');    // Returns ID
                    $content = get_sub_field('content'); // Returns text
                ?>
                    <div class="bg-white rounded-lg p-4 text-center shadow-sm">
                        <?php if ($icon) : ?>
                            <div class="mb-3">
                                <?php echo wp_get_attachment_image($icon, 'thumbnail', false, array('class' => 'w-12 h-12 mx-auto')); ?>
                            </div>
                        <?php endif; ?>
                        <?php if ($content) : ?>
                            <p class="text-base font-medium text-gray-900"><?php echo esc_html($content); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ Icons 2 module - add icon items in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

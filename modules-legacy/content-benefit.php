<?php
/**
 * Layout: Benefit
 * Fields: intro (wysiwyg), benefit (repeater: icon (image, return=id), content (wysiwyg))
 * Design: Blue gradient background, benefits with green checkmarks on left, image on right
 */
$intro = get_sub_field('intro');
?>
<section
    class="py-14 lg:py-20 px-6 lg:px-12 bg-gradient-to-br from-primary-dark via-[#0f1a5e] to-[#1a2570] text-white overflow-hidden">
    <div class="max-w-7xl mx-auto">
        <?php if ($intro): ?>
            <div class="module-benefit-intro mb-10 lg:mb-12 max-w-3xl">
                <?php echo armo_content($intro); ?>
            </div>
        <?php endif; ?>

        <?php if (have_rows('benefit')): ?>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                <!-- Benefits List -->
                <div class="space-y-8">
                    <?php while (have_rows('benefit')):
                        the_row();
                        $icon = get_sub_field('icon');
                        $content = get_sub_field('content');
                        ?>
                        <div class="flex gap-4 items-start">
                            <?php if ($icon): ?>
                                <div class="flex-shrink-0 mt-1">
                                    <?php echo wp_get_attachment_image($icon, 'thumbnail', false, array('class' => 'w-10 h-10')); ?>
                                </div>
                            <?php else: ?>
                                <!-- Default green checkmark circle -->
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-7 h-7 bg-green-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if ($content): ?>
                                <div class="module-benefit-content text-white/90">
                                    <?php echo armo_content($content); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Image placeholder - managed via ACF intro field or additional image field -->
                <div class="hidden lg:block">
                    <!-- This space can show an image from the intro WYSIWYG or be left for the background -->
                </div>
            </div>
        <?php else: ?>
        <?php endif; ?>
    </div>
</section>
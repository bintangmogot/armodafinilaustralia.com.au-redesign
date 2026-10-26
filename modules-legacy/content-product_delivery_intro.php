<?php
/**
 * Layout: Product Delivery Intro
 * Fields: left_content (wysiwyg), right_content (wysiwyg)
 */
$left_content  = get_sub_field('left_content');
$right_content = get_sub_field('right_content');
?>
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-8">
        <?php if ($left_content) : ?>
            <div class="prose"><?php echo armo_content($left_content); ?></div>
        <?php endif; ?>
        <?php if ($right_content) : ?>
            <div class="prose"><?php echo armo_content($right_content); ?></div>
        <?php endif; ?>
        <?php if (!$left_content && !$right_content) : ?>
        <?php endif; ?>
    </div>
</section>

<?php
/**
 * Layout: Text - Separate Headings
 * Fields: h1_heading, h2_heading, h3_heading, content (wysiwyg)
 * Design: White background, centered text with dark navy headings
 */
$h1_heading = get_sub_field('h1_heading');
$h1_color = get_sub_field('h1_color');
$h2_heading = get_sub_field('h2_heading');
$h2_color = get_sub_field('h2_color');
$h3_heading = get_sub_field('h3_heading');
$h3_color = get_sub_field('h3_color');
$content = get_sub_field('content');
$background_color = get_sub_field('background_color');
?>
<section class="py-4 lg:py-8 px-4 lg:px-8 <?php echo $background_color ? '' : 'bg-surface'; ?>" <?php if($background_color) echo 'style="background-color: ' . esc_attr($background_color) . ';"'; ?>>
    <div class="max-w-4xl mx-auto text-center">
        <?php if ($h1_heading) : ?>
            <h1 class="text-3xl lg:text-4xl font-extrabold mb-3 lg:mb-4 <?php echo $h1_color ? '' : 'text-primary'; ?>" <?php if($h1_color) echo 'style="color: ' . esc_attr($h1_color) . ';"'; ?>><?php echo esc_html($h1_heading); ?></h1>
        <?php endif; ?>

        <?php if ($h2_heading) : ?>
            <h2 class="text-2xl lg:text-3xl font-bold mb-2 lg:mb-3 <?php echo $h2_color ? '' : 'text-primary'; ?>" <?php if($h2_color) echo 'style="color: ' . esc_attr($h2_color) . ';"'; ?>><?php echo esc_html($h2_heading); ?></h2>
        <?php endif; ?>

        <?php if ($h3_heading) : ?>
            <h3 class="text-xl lg:text-2xl font-bold mb-2 lg:mb-3 <?php echo $h3_color ? '' : 'text-primary'; ?>" <?php if($h3_color) echo 'style="color: ' . esc_attr($h3_color) . ';"'; ?>><?php echo esc_html($h3_heading); ?></h3>
        <?php endif; ?>

        <?php if ($content) : ?>
            <div class="module-fulltext-content prose max-w-none mt-2 lg:mt-6 leading-[1.1]">
                <?php echo armo_content($content); ?>
            </div>
        <?php elseif (!$h1_heading && (!$h2_heading && !$h3_heading)) : ?>
            <p class="text-[#1E1E1E] text-center italic">[ Text Separate Headings module - add content in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

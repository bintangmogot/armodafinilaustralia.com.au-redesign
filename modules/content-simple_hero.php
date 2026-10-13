<?php
/**
 * Simple Hero Module Template
 */

$tag = get_sub_field('tag');
$title = get_sub_field('title');
$desc = get_sub_field('desc');
?>

<div class="section-wash">
    <div class="max-w-4xl mx-auto px-4 py-14 md:py-20 text-center">
        <?php if ($tag) : ?>
            <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5"><?php echo esc_html($tag); ?></span>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        <?php if ($desc) : ?>
            <p class="mt-3 text-ink-700 max-w-2xl mx-auto"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>
    </div>
</div>

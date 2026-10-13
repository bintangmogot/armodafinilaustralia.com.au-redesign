<?php
$badge = get_sub_field('badge');
$title = get_sub_field('title');
$desc = get_sub_field('desc');
?>
<div class="section-wash">
    <div class="max-w-4xl mx-auto px-4 py-14 md:py-20 text-center">
        <?php if ($badge) : ?>
            <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5 inline-flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/></svg> 
                <?php echo esc_html($badge); ?>
            </span>
        <?php endif; ?>
        <?php if ($title) : ?>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        <?php if ($desc) : ?>
            <p class="mt-4 text-lg text-ink-700 leading-relaxed"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>
    </div>
</div>

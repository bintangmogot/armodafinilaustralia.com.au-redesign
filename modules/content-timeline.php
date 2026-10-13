<?php
$badge = get_sub_field('badge') ?: 'Steps';
$title = get_sub_field('title') ?: 'Your path to delivery';
$steps = get_sub_field('steps');

$icons = array(
    'mouse-pointer-click' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><path d="M14 4.1 12 6"/><path d="m5.1 8-2.9-1.2"/><path d="m21.3 13.7-2.6-1.5"/><path d="M9.5 2 11 11.2l-3 3.6 5.8 5.8 3.5-3.3L22 22l-1.3-8.6-4.9-4.9z"/></svg>',
    'shopping-cart' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>',
    'map-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>',
    'credit-card' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>',
    'package-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><path d="m16 16 2 2 4-4"/><path d="M21 10V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l2-1.14"/><path d="m7.5 4.27 9 5.15"/><polyline points="3.29 7 12 12 20.71 7"/><line x1="12" x2="12" y1="22" y2="12"/></svg>',
);
$default_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4 md:w-5 md:h-5"><path d="M20 6 9 17l-5-5"/></svg>';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-xs uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($badge); ?></div>
    <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h2>

    <?php if (!empty($steps)) : ?>
        <ol class="mt-10 relative border-l-2 border-brand-100 ml-4 md:ml-6 space-y-8">
            <?php foreach ($steps as $s) : 
                $icon_svg = isset($icons[$s['icon']]) ? $icons[$s['icon']] : $default_icon;
            ?>
                <li class="pl-6 md:pl-10 relative">
                    <span class="absolute -left-[19px] md:-left-[22px] top-0 w-10 h-10 md:w-11 md:h-11 rounded-full bg-brand-600 text-white grid place-items-center font-semibold shadow-soft">
                        <?php echo $icon_svg; ?>
                    </span>
                    <div class="bg-white border border-ink-200 rounded-2xl p-5 md:p-6 hover-lift">
                        <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold tabular-nums">Step <?php echo esc_html($s['number']); ?></div>
                        <h3 class="mt-1 font-serif text-xl font-semibold text-ink-900"><?php echo esc_html($s['title']); ?></h3>
                        <p class="mt-2 text-ink-700 leading-relaxed"><?php echo esc_html($s['desc']); ?></p>
                    </div>
                </li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>
</div>

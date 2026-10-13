<?php
$badge = get_sub_field('badge');
$title = get_sub_field('title');
$content = get_sub_field('content');
$buttons = get_sub_field('buttons');
$cards = get_sub_field('cards');

$icons = array(
    'award' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/></svg>',
    'users' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
    'shield-check' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>',
    'truck' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>',
);
$default_icon = '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>';
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
    <div class="grid lg:grid-cols-2 gap-10 items-center">
        <div>
            <?php if ($badge) : ?>
                <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($badge); ?></span>
            <?php endif; ?>
            <?php if ($title) : ?>
                <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h2>
            <?php endif; ?>
            
            <?php if ($content) : ?>
                <div class="mt-4 text-ink-700 leading-relaxed policy-rich-text">
                    <?php echo apply_filters('the_content', $content); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($buttons)) : ?>
                <div class="mt-6 flex flex-wrap gap-3">
                    <?php foreach ($buttons as $btn) : 
                        $is_primary = ($btn['style'] === 'primary');
                        $classes = $is_primary 
                            ? 'inline-flex items-center gap-2 h-11 px-5 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors' 
                            : 'inline-flex items-center gap-2 h-11 px-5 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors';
                    ?>
                        <a href="<?php echo esc_url($btn['link']); ?>" class="<?php echo esc_attr($classes); ?>">
                            <?php if (!$is_primary && stripos($btn['text'], 'whatsapp') !== false) : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
                            <?php endif; ?>
                            <?php echo esc_html($btn['text']); ?>
                            <?php if ($is_primary) : ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                            <?php endif; ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($cards)) : ?>
            <div class="grid grid-cols-2 gap-4">
                <?php foreach ($cards as $card) : 
                    $icon_svg = isset($icons[strtolower($card['icon'])]) ? $icons[strtolower($card['icon'])] : $default_icon;
                ?>
                    <div class="p-5 bg-white border border-ink-200 rounded-2xl">
                        <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-700 grid place-items-center">
                            <?php echo $icon_svg; ?>
                        </div>
                        <h3 class="mt-3 font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($card['title']); ?></h3>
                        <p class="mt-1 text-sm text-ink-700"><?php echo esc_html($card['desc']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

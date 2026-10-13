<?php
/**
 * Shipping Features Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, features
 */

$title = get_sub_field('title') ?: 'Fast, discreet delivery';
$subtitle = get_sub_field('subtitle') ?: 'Care built into every step — from checkout to your doorstep.';
$features = get_sub_field('features');

if ( empty( $features ) ) {
    $features = array(
        array('icon' => 'Package', 'title' => 'Plain Packaging', 'desc' => 'Your order ships in an unmarked box with no logos or medical branding.'),
        array('icon' => 'Truck', 'title' => 'Tracked Dispatch', 'desc' => 'Every order includes an Australia Post tracking number sent via email.'),
        array('icon' => 'Zap', 'title' => 'Same-Day Send', 'desc' => 'Orders placed before 2pm AEST are handed to the courier the same afternoon.'),
        array('icon' => 'ShieldCheck', 'title' => 'Guaranteed Delivery', 'desc' => 'If it doesn’t arrive within the estimated window, we’ll reship it for free.'),
    );
}
?>

<section class="py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        
        <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ( $features as $f ) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 hover-lift shadow-sm">
                <div class="w-11 h-11 rounded-xl bg-brand-100 text-brand-700 grid place-items-center mb-4">
                    <?php if ( strtolower($f['icon']) === 'package' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-package w-5 h-5"><path d="m7.5 4.27 9 5.15"/><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    <?php elseif ( strtolower($f['icon']) === 'truck' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-5 h-5"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg>
                    <?php elseif ( strtolower($f['icon']) === 'zap' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap w-5 h-5"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-5 h-5"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                    <?php endif; ?>
                </div>
                <h3 class="font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($f['title']); ?></h3>
                <p class="mt-2 text-sm text-ink-700 leading-relaxed"><?php echo esc_html($f['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

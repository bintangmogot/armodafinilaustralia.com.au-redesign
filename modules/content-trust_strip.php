<?php
/**
 * Trust Strip Module Template
 * 
 * Data provided by ACF Sub Fields: items (repeater of 'text')
 */

$items = get_sub_field('items');

// Default fallback items if none exist
if ( empty( $items ) ) {
    $items = array(
        array('text' => 'Australian Pharmacy'),
        array('text' => 'Quality Verified'),
        array('text' => 'Same-Day Tracking'),
        array('text' => 'SSL Secure'),
        array('text' => 'Trusted by 100,000+ Buyers'),
    );
}

// Duplicate items to ensure the marquee effect loops smoothly
$marquee_items = array_merge( $items, $items, $items );
?>

<div class="border-y border-ink-200 bg-white overflow-hidden">
    <div class="mask-fade-x">
        <div class="flex gap-10 py-4 animate-marquee whitespace-nowrap">
            <?php foreach ( $marquee_items as $item ) : ?>
                <?php if ( ! empty( $item['text'] ) ) : ?>
                <span class="inline-flex items-center gap-2 text-sm font-medium text-ink-700">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                    <?php echo esc_html( $item['text'] ); ?>
                </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

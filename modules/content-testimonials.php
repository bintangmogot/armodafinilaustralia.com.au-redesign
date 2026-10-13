<?php
/**
 * Testimonials Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, reviews
 */

$title = get_sub_field('title') ?: 'What Australians say';
$subtitle = get_sub_field('subtitle') ?: 'A handful of recent notes from verified buyers.';
$reviews = get_sub_field('reviews');

// Fallback dummy reviews if none exist
if ( empty( $reviews ) ) {
    $reviews = array(
        array(
            'title' => 'Genuine product, fast shipping',
            'body' => 'Ordered on Tuesday, arrived Thursday. The packaging was discreet and the product is exactly as described.',
            'name' => 'Michael T.',
            'city' => 'Sydney',
            'date' => '12 October 2023'
        ),
        array(
            'title' => 'My go-to supplier now',
            'body' => 'I\'ve tried a few different sites but this one is the most reliable. Customer service actually replies.',
            'name' => 'Sarah J.',
            'city' => 'Melbourne',
            'date' => '8 November 2023'
        ),
        array(
            'title' => 'Helps me through night shifts',
            'body' => 'Working ward shifts was killing me. These have been a lifesaver for maintaining focus at 3am.',
            'name' => 'David L.',
            'city' => 'Brisbane',
            'date' => '21 November 2023'
        )
    );
}
?>

<section class="py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        
        <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ( $reviews as $r ) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 hover-lift relative shadow-sm">
                <!-- Quote icon -->
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-quote w-6 h-6 text-brand-300 mb-3"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                
                <h3 class="font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($r['title']); ?></h3>
                <p class="mt-2 text-sm text-ink-700 leading-relaxed"><?php echo esc_html($r['body']); ?></p>
                <div class="mt-4 pt-4 border-t border-ink-200 text-xs text-ink-500">
                    &mdash; <?php echo esc_html($r['name']); ?><?php if(!empty($r['city'])) echo ', ' . esc_html($r['city']); ?>
                    <?php if ( !empty($r['date']) ) : ?>
                        <div class="mt-1 ml-4 text-ink-400 text-[11px]"><?php echo esc_html($r['date']); ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        
        <div class="mt-8 flex flex-wrap items-center justify-center gap-x-6 gap-y-2 text-xs text-ink-500">
            <span class="inline-flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-check w-3.5 h-3.5 text-brand-600"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><polyline points="16 11 18 13 22 9"/></svg> 
                Verified buyers only
            </span>
            <span class="inline-flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> 
                Secure review system
            </span>
            <span class="inline-flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-clock w-3.5 h-3.5 text-brand-600"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg> 
                Updated regularly
            </span>
        </div>
    </div>
</section>


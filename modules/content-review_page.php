<?php
/**
 * Review Page Module Template
 */

$heading = get_sub_field('heading') ?: 'Customer Reviews';

// Fetch General Reviews (no linked product)
$reviews = get_posts([
    "post_type" => "review",
    "posts_per_page" => -1,
    "orderby" => "date",
    "order" => "DESC",
    "meta_query" => array(
        'relation' => 'OR',
        array(
            'key'     => 'linked_product',
            'compare' => 'NOT EXISTS'
        ),
        array(
            'key'     => 'linked_product',
            'value'   => '',
            'compare' => '='
        )
    )
]);

$review_count = count($reviews);
?>

<section class="py-16 md:py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
            <h2 class="font-serif text-3xl md:text-5xl font-semibold text-ink-900 mb-6">
                <?php echo esc_html($heading); ?>
            </h2>
            <?php if ($review_count > 0): ?>
                <div class="inline-flex items-center justify-center gap-3 bg-brand-50 rounded-full px-5 py-2">
                    <div class="flex items-center gap-1">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <div class="w-6 h-6 flex items-center justify-center rounded-[3px] text-white" style="background-color: #00B67A;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <span class="text-sm font-semibold text-brand-900">
                        5.0 out of 5 (<?php echo esc_html($review_count); ?> reviews)
                    </span>
                </div>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if ($reviews):
                foreach ($reviews as $r):
                    $post_id = $r->ID;
                    $title = get_the_title($post_id);
                    $body = get_post_field('post_content', $post_id);
                    $reviewer = get_field("name", $post_id) ?: $title;
                    $meta = get_field('reviewer_meta', $post_id) ?: "Verified Buyer";
                    $rating_val = get_field("rating", $post_id) ?: 5;
                    ?>
                    <div class="bg-white border border-ink-200 rounded-2xl p-6 md:p-8 flex flex-col hover-lift transition-shadow shadow-soft">
                        <div class="flex items-center gap-1 mb-5">
                            <?php for ($stars = 0; $stars < 5; $stars++): ?>
                                <div class="w-7 h-7 flex items-center justify-center rounded-[3px] text-white" style="background-color: <?php echo ($stars < $rating_val) ? '#00B67A' : '#E5E7EB'; ?>;">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor" stroke="none">
                                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                    </svg>
                                </div>
                            <?php endfor; ?>
                        </div>
                        
                        <?php if ($title && $title !== $reviewer): ?>
                            <h3 class="font-serif text-lg font-semibold text-ink-900 mb-3"><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>

                        <div class="text-ink-700 leading-relaxed flex-1">
                            <?php echo wp_kses_post(wpautop($body)); ?>
                        </div>
                        
                        <div class="mt-8 pt-5 border-t border-ink-100 flex flex-wrap items-center justify-between gap-3">
                            <div class="flex items-center gap-3">
                                <div>
                                    <div class="font-bold text-ink-900 text-[15px] leading-tight">
                                        <?php echo esc_html($reviewer); ?>
                                    </div>
                                    <?php if ($meta && stripos($meta, 'verified') === false && stripos($meta, 'buyer') === false): ?>
                                    <div class="text-xs text-ink-600 mt-0.5">
                                        <?php echo esc_html($meta); ?>
                                    </div>
                                    <?php endif; ?>
                                    <div class="text-xs text-ink-400 mt-1">
                                        <?php echo get_the_date('j F Y', $post_id); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1 px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded uppercase tracking-wide shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                                </svg>
                                VERIFIED
                            </div>
                        </div>
                    </div>
                <?php
                endforeach;
            else:
                ?>
                <div class="col-span-full py-16 text-center text-ink-500 bg-ink-50 rounded-2xl border border-ink-200 border-dashed">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-square w-8 h-8 mx-auto mb-3 text-ink-400"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <p class="text-lg font-medium">No reviews found.</p>
                    <p class="text-sm mt-1">Check back later for customer feedback.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

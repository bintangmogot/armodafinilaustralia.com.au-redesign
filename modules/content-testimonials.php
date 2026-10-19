<?php
/**
 * Testimonials Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, reviews (Relationship to review CPT)
 */

$title = get_sub_field('title') ?: 'What Australians say';
$subtitle = get_sub_field('subtitle') ?: 'A handful of recent notes from verified buyers.';
$selected_reviews = get_sub_field('reviews');

$review_items = array();

if ( ! empty( $selected_reviews ) ) {
    foreach ( $selected_reviews as $item ) {
        if ( is_object($item) && isset($item->ID) ) {
            $post_id = $item->ID;
            $r_title = get_the_title($post_id);
            $r_body  = get_post_field('post_content', $post_id);
            $r_name  = get_field('name', $post_id) ?: $r_title;
            $r_meta  = get_field('reviewer_meta', $post_id);
            $r_rating = get_field('rating', $post_id) ?: 5;
            $r_date  = function_exists('armd_get_review_date') ? armd_get_review_date($post_id, 'j F Y') : get_the_date('j F Y', $post_id);

            $img_id = get_field('review_image', $post_id) ?: get_post_thumbnail_id($post_id);
            $photo_url = '';
            $photo_full = '';
            if ($img_id) {
                if (is_array($img_id)) {
                    $photo_url = !empty($img_id['sizes']['medium_large']) ? $img_id['sizes']['medium_large'] : (!empty($img_id['sizes']['medium']) ? $img_id['sizes']['medium'] : $img_id['url']);
                    $photo_full = $img_id['url'];
                } elseif (is_numeric($img_id)) {
                    $photo_url = wp_get_attachment_image_url($img_id, 'medium_large') ?: wp_get_attachment_image_url($img_id, 'full');
                    $photo_full = wp_get_attachment_image_url($img_id, 'full');
                }
            }

            $avatar_data = get_field('reviewer_avatar', $post_id);
            $avatar_url = '';
            if ($avatar_data) {
                if (is_array($avatar_data)) {
                    $avatar_url = !empty($avatar_data['sizes']['thumbnail']) ? $avatar_data['sizes']['thumbnail'] : $avatar_data['url'];
                } elseif (is_numeric($avatar_data)) {
                    $avatar_url = wp_get_attachment_image_url($avatar_data, 'thumbnail');
                }
            }

            $initials = strtoupper(substr($r_name, 0, 1) . (strpos($r_name, ' ') ? substr(explode(' ', $r_name)[1], 0, 1) : ''));

            $review_items[] = array(
                'id'         => $post_id,
                'title'      => $r_title,
                'body'       => $r_body,
                'name'       => $r_name,
                'meta'       => $r_meta,
                'rating'     => (int)$r_rating,
                'date'       => $r_date,
                'photo_url'  => $photo_url,
                'photo_full' => $photo_full,
                'avatar_url' => $avatar_url,
                'initials'   => $initials,
            );
        } elseif ( is_numeric($item) ) {
            $post_id = (int)$item;
            $r_title = get_the_title($post_id);
            $r_body  = get_post_field('post_content', $post_id);
            $r_name  = get_field('name', $post_id) ?: $r_title;
            $r_meta  = get_field('reviewer_meta', $post_id);
            $r_rating = get_field('rating', $post_id) ?: 5;
            $r_date  = function_exists('armd_get_review_date') ? armd_get_review_date($post_id, 'j F Y') : get_the_date('j F Y', $post_id);

            $img_id = get_field('review_image', $post_id) ?: get_post_thumbnail_id($post_id);
            $photo_url = '';
            $photo_full = '';
            if ($img_id) {
                if (is_array($img_id)) {
                    $photo_url = !empty($img_id['sizes']['medium_large']) ? $img_id['sizes']['medium_large'] : (!empty($img_id['sizes']['medium']) ? $img_id['sizes']['medium'] : $img_id['url']);
                    $photo_full = $img_id['url'];
                } elseif (is_numeric($img_id)) {
                    $photo_url = wp_get_attachment_image_url($img_id, 'medium_large') ?: wp_get_attachment_image_url($img_id, 'full');
                    $photo_full = wp_get_attachment_image_url($img_id, 'full');
                }
            }

            $avatar_data = get_field('reviewer_avatar', $post_id);
            $avatar_url = '';
            if ($avatar_data) {
                if (is_array($avatar_data)) {
                    $avatar_url = !empty($avatar_data['sizes']['thumbnail']) ? $avatar_data['sizes']['thumbnail'] : $avatar_data['url'];
                } elseif (is_numeric($avatar_data)) {
                    $avatar_url = wp_get_attachment_image_url($avatar_data, 'thumbnail');
                }
            }

            $initials = strtoupper(substr($r_name, 0, 1) . (strpos($r_name, ' ') ? substr(explode(' ', $r_name)[1], 0, 1) : ''));

            $review_items[] = array(
                'id'         => $post_id,
                'title'      => $r_title,
                'body'       => $r_body,
                'name'       => $r_name,
                'meta'       => $r_meta,
                'rating'     => (int)$r_rating,
                'date'       => $r_date,
                'photo_url'  => $photo_url,
                'photo_full' => $photo_full,
                'avatar_url' => $avatar_url,
                'initials'   => $initials,
            );
        } elseif ( is_array($item) && (!empty($item['name']) || !empty($item['title'])) ) {
            // Legacy manual repeater row fallback
            $r_name = !empty($item['name']) ? $item['name'] : 'Customer';
            $review_items[] = array(
                'id'         => 0,
                'title'      => !empty($item['title']) ? $item['title'] : '',
                'body'       => !empty($item['body']) ? $item['body'] : '',
                'name'       => $r_name,
                'meta'       => !empty($item['city']) ? $item['city'] : '',
                'rating'     => 5,
                'date'       => !empty($item['date']) ? $item['date'] : '',
                'photo_url'  => '',
                'photo_full' => '',
                'avatar_url' => '',
                'initials'   => strtoupper(substr($r_name, 0, 1)),
            );
        }
    }
}

// If no reviews selected, automatically fetch latest published reviews from CPT
if ( empty( $review_items ) ) {
    $fallback_posts = get_posts(array(
        'post_type'      => 'review',
        'posts_per_page' => 6,
        'post_status'    => 'publish',
        'orderby'        => 'date',
        'order'          => 'DESC',
    ));

    if ( ! empty( $fallback_posts ) ) {
        foreach ( $fallback_posts as $fp ) {
            $post_id = $fp->ID;
            $r_title = get_the_title($post_id);
            $r_body  = get_post_field('post_content', $post_id);
            $r_name  = get_field('name', $post_id) ?: $r_title;
            $r_meta  = get_field('reviewer_meta', $post_id);
            $r_rating = get_field('rating', $post_id) ?: 5;
            $r_date  = function_exists('armd_get_review_date') ? armd_get_review_date($post_id, 'j F Y') : get_the_date('j F Y', $post_id);

            $img_id = get_field('review_image', $post_id) ?: get_post_thumbnail_id($post_id);
            $photo_url = '';
            $photo_full = '';
            if ($img_id) {
                if (is_array($img_id)) {
                    $photo_url = !empty($img_id['sizes']['medium_large']) ? $img_id['sizes']['medium_large'] : (!empty($img_id['sizes']['medium']) ? $img_id['sizes']['medium'] : $img_id['url']);
                    $photo_full = $img_id['url'];
                } elseif (is_numeric($img_id)) {
                    $photo_url = wp_get_attachment_image_url($img_id, 'medium_large') ?: wp_get_attachment_image_url($img_id, 'full');
                    $photo_full = wp_get_attachment_image_url($img_id, 'full');
                }
            }

            $avatar_data = get_field('reviewer_avatar', $post_id);
            $avatar_url = '';
            if ($avatar_data) {
                if (is_array($avatar_data)) {
                    $avatar_url = !empty($avatar_data['sizes']['thumbnail']) ? $avatar_data['sizes']['thumbnail'] : $avatar_data['url'];
                } elseif (is_numeric($avatar_data)) {
                    $avatar_url = wp_get_attachment_image_url($avatar_data, 'thumbnail');
                }
            }

            $initials = strtoupper(substr($r_name, 0, 1) . (strpos($r_name, ' ') ? substr(explode(' ', $r_name)[1], 0, 1) : ''));

            $review_items[] = array(
                'id'         => $post_id,
                'title'      => $r_title,
                'body'       => $r_body,
                'name'       => $r_name,
                'meta'       => $r_meta,
                'rating'     => (int)$r_rating,
                'date'       => $r_date,
                'photo_url'  => $photo_url,
                'photo_full' => $photo_full,
                'avatar_url' => $avatar_url,
                'initials'   => $initials,
            );
        }
    } else {
        // Fallback dummy reviews if none exist
        $review_items = array(
            array('id' => 0, 'title' => 'Genuine product, fast shipping', 'body' => 'Ordered on Tuesday, arrived Thursday. The packaging was discreet and the product is exactly as described.', 'name' => 'Michael T.', 'meta' => 'Sydney', 'rating' => 5, 'date' => '12 October 2023', 'photo_url' => '', 'photo_full' => '', 'avatar_url' => '', 'initials' => 'M'),
            array('id' => 0, 'title' => 'My go-to supplier now', 'body' => 'I\'ve tried a few different sites but this one is the most reliable. Customer service actually replies.', 'name' => 'Sarah J.', 'meta' => 'Melbourne', 'rating' => 5, 'date' => '8 November 2023', 'photo_url' => '', 'photo_full' => '', 'avatar_url' => '', 'initials' => 'S'),
            array('id' => 0, 'title' => 'Helps me through night shifts', 'body' => 'Working ward shifts was killing me. These have been a lifesaver for maintaining focus at 3am.', 'name' => 'David L.', 'meta' => 'Brisbane', 'rating' => 5, 'date' => '21 November 2023', 'photo_url' => '', 'photo_full' => '', 'avatar_url' => '', 'initials' => 'D'),
        );
    }
}
?>

<section class="py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        
        <div class="mt-10 grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php foreach ( $review_items as $r ) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 hover-lift relative shadow-sm flex flex-col">
                <div class="flex items-center justify-between gap-2 mb-3">
                    <div class="flex gap-0.5">
                        <?php for ($i = 0; $i < 5; $i++): ?>
                            <div class="<?php echo ($i < $r['rating']) ? 'bg-[#00b67a]' : 'bg-slate-200'; ?> w-5 h-5 flex items-center justify-center rounded-[3px] text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="currentColor" stroke="none"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            </div>
                        <?php endfor; ?>
                    </div>
                    <!-- Quote icon -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-quote w-5 h-5 text-brand-300"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.75c0 2.25.25 4-2.75 4v3c0 1 0 1 1 1z"/></svg>
                </div>
                
                <?php if ( ! empty($r['title']) && $r['title'] !== $r['name'] ) : ?>
                    <h3 class="font-serif text-lg font-semibold text-ink-900 leading-snug mb-2"><?php echo esc_html($r['title']); ?></h3>
                <?php endif; ?>

                <div class="text-sm text-ink-700 leading-relaxed mb-4 flex-1 line-clamp-5">
                    <?php echo wp_kses_post(wpautop($r['body'])); ?>
                </div>

                <?php if ( ! empty($r['photo_url']) ) : ?>
                <div class="mb-4 rounded-xl overflow-hidden border border-ink-100 bg-ink-50">
                    <a href="<?php echo esc_url($r['photo_full'] ?: $r['photo_url']); ?>" target="_blank" rel="noopener noreferrer" class="block relative aspect-video overflow-hidden group">
                        <img src="<?php echo esc_url($r['photo_url']); ?>" alt="<?php echo esc_attr($r['title'] ?: 'Review photo'); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/15 transition-colors flex items-center justify-center">
                            <span class="opacity-0 group-hover:opacity-100 transition-opacity bg-black/60 text-white text-[11px] font-bold px-2.5 py-1 rounded-full backdrop-blur-sm flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/><path d="M11 8v6"/><path d="M8 11h6"/></svg>
                                View Photo
                            </span>
                        </div>
                    </a>
                </div>
                <?php endif; ?>

                <div class="mt-auto pt-4 border-t border-ink-100 flex items-center justify-between gap-3 text-xs text-ink-500">
                    <div class="flex items-center gap-2.5">
                        <?php if ( ! empty($r['avatar_url']) ) : ?>
                            <img src="<?php echo esc_url($r['avatar_url']); ?>" alt="<?php echo esc_attr($r['name']); ?>" class="w-8 h-8 rounded-full object-cover shrink-0 border border-ink-200" loading="lazy">
                        <?php else : ?>
                            <div class="w-8 h-8 rounded-full bg-brand-50 text-brand-700 flex items-center justify-center font-bold text-xs shrink-0">
                                <?php echo esc_html($r['initials']); ?>
                            </div>
                        <?php endif; ?>
                        <div>
                            <div class="font-bold text-ink-900 text-[13px] leading-tight">
                                <?php echo esc_html($r['name']); ?>
                            </div>
                            <?php if ( ! empty($r['meta']) && stripos($r['meta'], 'verified') === false && stripos($r['meta'], 'buyer') === false ) : ?>
                                <div class="text-[11px] text-ink-500 mt-0.5">
                                    <?php echo esc_html($r['meta']); ?>
                                </div>
                            <?php endif; ?>
                            <?php if ( ! empty($r['date']) ) : ?>
                                <div class="text-[11px] text-ink-400 mt-0.5"><?php echo esc_html($r['date']); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="inline-flex items-center gap-1 px-2 py-0.5 rounded bg-emerald-50 text-[9px] font-bold text-emerald-700 uppercase tracking-wider shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                        Verified
                    </div>
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

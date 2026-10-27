<?php
/**
 * Conditions Grid Module Template
 */

$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$view_all_text = get_sub_field('view_all_text');
$view_all_url = get_sub_field('view_all_url');
$posts = get_sub_field('posts');

// Fallback if no posts selected
$has_posts = !empty($posts);
if (!$has_posts) {
    $posts = array();
}
?>

<section class="py-16 md:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between gap-4 flex-wrap">
            <div>
                <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900"><?php echo esc_html($title); ?></h2>
                <p class="mt-2 text-ink-500"><?php echo esc_html($subtitle); ?></p>
            </div>
            <a href="<?php echo esc_url($view_all_url); ?>" class="inline-flex items-center gap-1.5 text-brand-700 font-semibold hover:gap-2 transition-all">
                <?php echo esc_html($view_all_text); ?> 
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
            </a>
        </div>
        <div class="mt-8 grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php 
            foreach ( $posts as $p ) : 
                if ($has_posts) {
                    $p_id = $p->ID;
                    $p_title = get_the_title($p_id);
                    $p_excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt($p_id) ), 25, "..." );
                    $p_url = get_permalink($p_id);
                    $p_image = get_the_post_thumbnail_url($p_id, 'medium_large');
                } else {
                    $p_title = $p['title'];
                    $p_excerpt = $p['excerpt'];
                    $p_url = '#';
                    $p_image = '';
                }
            ?>
            <a href="<?php echo esc_url($p_url); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
<?php if ( $p_image ) : ?><img src="<?php echo esc_url($p_image); ?>" alt="<?php echo esc_attr($p_title); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" /><?php endif; ?>
                </div>
                <div class="p-5">
                    <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Guide</div>
                    <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php echo esc_html($p_title); ?></h3>
                    <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo esc_html($p_excerpt); ?></p>
                    <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                        Read guide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

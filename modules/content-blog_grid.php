<?php
/**
 * Blog Grid Module Template
 */

$title = get_sub_field('title') ?: 'Latest from the blog';
$subtitle = get_sub_field('subtitle') ?: 'Practical notes, dosing guides, and research summaries.';
$view_all_text = get_sub_field('view_all_text') ?: 'All articles';
$view_all_url = get_sub_field('view_all_url') ?: '/blog';
$posts = get_sub_field('posts');

// Fallback if no posts selected
$has_posts = !empty($posts);
if (!$has_posts) {
    $posts = array(
        array('title' => 'Modafinil vs Armodafinil', 'excerpt' => 'Understanding the half-life and duration differences.', 'date' => 'Oct 12', 'author' => 'Dr. Smith'),
        array('title' => 'Optimizing your dose', 'excerpt' => 'Why less is often more when it comes to focus.', 'date' => 'Oct 05', 'author' => 'Sarah J.'),
        array('title' => 'The science of wakefulness', 'excerpt' => 'How dopamine reuptake inhibition actually feels.', 'date' => 'Sep 28', 'author' => 'Dr. Smith')
    );
}
?>

<section class="py-16 md:py-20">
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
                    $raw = get_the_excerpt($p_id);
$raw = preg_replace('/1\.[^a-z]*Introduction[^a-z]*/i', '', $raw);
$p_excerpt = wp_trim_words( wp_strip_all_tags( $raw ), 25, "..." );
                    $p_url = get_permalink($p_id);
                    $p_date = get_the_date('M j', $p_id);
                    $p_author = get_the_author_meta('display_name', $p->post_author);
                    $p_image = get_the_post_thumbnail_url($p_id, 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Blog';
                } else {
                    $p_title = $p['title'];
                    $p_excerpt = $p['excerpt'];
                    $p_url = '#';
                    $p_date = $p['date'];
                    $p_author = $p['author'];
                    $p_image = 'https://placehold.co/600x400/e0f2fe/0369a1?text=Blog';
                }
            ?>
            <a href="<?php echo esc_url($p_url); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
                    <img src="<?php echo esc_url($p_image); ?>" alt="<?php echo esc_attr($p_title); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" />
                </div>
                <div class="p-5">
                    <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Article</div>
                    <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php echo esc_html($p_title); ?></h3>
                    <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo esc_html($p_excerpt); ?></p>
                    <div class="mt-4 flex items-center gap-4 text-xs text-ink-500">
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days w-3.5 h-3.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> 
                            <?php echo esc_html($p_date); ?>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2 w-3.5 h-3.5"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg> 
                            <?php echo esc_html($p_author); ?>
                        </span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
/**
 * Blog Archive Module Template
 */

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 10, // 1 featured + 9 regular
    'paged'          => $paged
);

$query = new WP_Query( $args );
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <?php if ( $query->have_posts() ) : 
        
        // First post is featured (only on page 1)
        if ( $paged == 1 ) {
            $query->the_post();
            $feat_id = get_the_ID();
            $feat_title = get_the_title();
            $raw_feat = get_the_excerpt();
$raw_feat = preg_replace('/1\.[^a-z]*Introduction[^a-z]*/i', '', $raw_feat);
$feat_excerpt = wp_trim_words( wp_strip_all_tags( $raw_feat ), 25, "..." );
            $feat_url = get_permalink();
            $feat_date = get_the_date('M j');
            $feat_author = get_the_author_meta('display_name');
            $feat_image = get_the_post_thumbnail_url($feat_id, 'large') ?: 'https://placehold.co/1200x800/e0f2fe/0369a1?text=Blog+Hero';
            $categories = get_the_category();
            $feat_cat = !empty($categories) ? $categories[0]->name : 'Article';
            ?>
            <a href="<?php echo esc_url($feat_url); ?>" class="grid lg:grid-cols-2 gap-8 items-center group mb-14">
                <div class="aspect-[16/10] rounded-2xl bg-brand-50 overflow-hidden">
                    <img src="<?php echo esc_url($feat_image); ?>" alt="<?php echo esc_attr($feat_title); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.02]" loading="lazy" />
                </div>
                <div>
                    <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($feat_cat); ?></div>
                    <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($feat_title); ?></h2>
                    <p class="mt-3 text-ink-700 leading-relaxed"><?php echo esc_html($feat_excerpt); ?></p>
                    <div class="mt-4 flex items-center gap-4 text-xs text-ink-500">
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-calendar-days w-3.5 h-3.5"><rect width="18" height="18" x="3" y="4" rx="2" ry="2"/><line x1="16" x2="16" y1="2" y2="6"/><line x1="8" x2="8" y1="2" y2="6"/><line x1="3" x2="21" y1="10" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg> 
                            <?php echo esc_html($feat_date); ?>
                        </span>
                        <span class="inline-flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user-2 w-3.5 h-3.5"><circle cx="12" cy="8" r="5"/><path d="M20 21a8 8 0 1 0-16 0"/></svg> 
                            <?php echo esc_html($feat_author); ?>
                        </span>
                    </div>
                    <span class="mt-5 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                        Read article <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                    </span>
                </div>
            </a>
            <?php
        }
        
        if ( $query->have_posts() ) : ?>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php while ( $query->have_posts() ) : $query->the_post(); 
                    $p_id = get_the_ID();
                    $categories = get_the_category();
                    $p_cat = !empty($categories) ? $categories[0]->name : 'Article';
                    $p_image = get_the_post_thumbnail_url($p_id, 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Blog';
                ?>
                    <a href="<?php the_permalink(); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                        <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
                            <img src="<?php echo esc_url($p_image); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" />
                        </div>
                        <div class="p-5">
                            <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($p_cat); ?></div>
                            <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php the_title(); ?></h3>
                            <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25, "..." ) ); ?></p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
            
            <div class="mt-12 flex justify-center">
                <?php 
                echo paginate_links( array(
                    'total' => $query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => '&larr; Prev',
                    'next_text' => 'Next &rarr;',
                    'class' => 'pagination-links flex gap-2'
                ) ); 
                ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="text-center text-ink-500">No articles found.</p>
    <?php endif; ?>
</div>

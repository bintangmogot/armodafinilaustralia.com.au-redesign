<?php
/**
 * Related Posts Template Part
 */

// Only show on single posts
if ( !is_single() || get_post_type() !== 'post' ) {
    return;
}

$categories = get_the_category();
if ( empty($categories) ) {
    return;
}

$cat_ids = wp_list_pluck($categories, 'term_id');

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
    'post__not_in' => array(get_the_ID()),
    'category__in' => $cat_ids,
    'orderby' => 'rand',
);

$related_query = new WP_Query($args);

if ( $related_query->have_posts() ) : ?>
    <section class="section-wash py-16 border-t border-ink-200 mt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 class="font-serif text-3xl font-semibold text-ink-900 mb-8 text-center">More from our blog</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php while ( $related_query->have_posts() ) : $related_query->the_post(); 
                    $img = get_the_post_thumbnail_url(get_the_ID(), 'medium_large') ?: 'https://placehold.co/800x600/e0f2fe/0369a1?text=Blog';
                ?>
                    <a href="<?php the_permalink(); ?>" class="group block bg-white rounded-2xl overflow-hidden border border-ink-200 hover-lift">
                        <div class="aspect-[4/3] bg-brand-50 overflow-hidden">
                            <img src="<?php echo esc_url($img); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                        </div>
                        <div class="p-6">
                            <h3 class="font-semibold text-lg text-ink-900 group-hover:text-brand-700 transition-colors line-clamp-2"><?php the_title(); ?></h3>
                            <p class="mt-2 text-sm text-ink-500 line-clamp-2"><?php echo wp_strip_all_tags(get_the_excerpt()); ?></p>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php 
endif; 
wp_reset_postdata(); 
?>

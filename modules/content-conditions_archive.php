<?php
/**
 * Conditions Archive Module Template
 */

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
    'post_type'      => 'condition',
    'post_status'    => 'publish',
    'posts_per_page' => 12,
    'paged'          => $paged
);

$query = new WP_Query( $args );
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <?php if ( $query->have_posts() ) : ?>
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-5">
            <?php while ( $query->have_posts() ) : $query->the_post(); 
                $p_id = get_the_ID();
                $p_image = get_the_post_thumbnail_url($p_id, 'medium_large') ?: 'https://placehold.co/600x400/e0f2fe/0369a1?text=Guide';
            ?>
                <a href="<?php the_permalink(); ?>" class="group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift block shadow-sm">
                    <div class="aspect-[16/9] bg-brand-50 overflow-hidden">
                        <img src="<?php echo esc_url($p_image); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-[1.03]" />
                    </div>
                    <div class="p-5">
                        <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold">Guide</div>
                        <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900 line-clamp-2"><?php the_title(); ?></h3>
                        <p class="mt-2 text-sm text-ink-700 leading-relaxed line-clamp-2"><?php echo esc_html( wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), 25, "..." ) ); ?></p>
                        <span class="mt-4 inline-flex items-center gap-1.5 text-sm font-semibold text-brand-700">
                            Read guide <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </span>
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
        <?php wp_reset_postdata(); ?>
    <?php else : ?>
        <p class="text-center text-ink-500">No conditions found.</p>
    <?php endif; ?>
</div>

<?php
/**
 * Layout: Reviews
 * Fields: heading (text) - queries 'reviews' CPT for display
 * Design: White bg, heading centered, review cards in 2-col grid with stars and names
 */
$heading = get_sub_field('heading');
$reviews = new WP_Query(array(
    'post_type'      => 'reviews',
    'posts_per_page' => 6,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'OR',
        array('key' => 'linked_product', 'compare' => 'NOT EXISTS'),
        array('key' => 'linked_product', 'value' => '', 'compare' => '=')
    )
));
?>
<section class="py-14 lg:py-20 px-6 lg:px-12 bg-white">
    <div class="max-w-5xl mx-auto">
        <?php if ($heading) : ?>
            <h2 class="text-2xl lg:text-3xl font-bold text-center text-primary-dark mb-10"><?php echo esc_html($heading); ?></h2>
        <?php endif; ?>
        <?php if ($reviews->have_posts()) : ?>
            <div class="grid md:grid-cols-2 gap-6">
                <?php while ($reviews->have_posts()) : $reviews->the_post(); 
                    $rating = get_field('rating');
                    $name   = get_field('name');
                ?>
                    <div class="bg-surface rounded-2xl p-6 border border-primary-dark/5 hover:shadow-md transition-shadow">
                        <?php if ($rating) : ?>
                            <div class="mb-3 text-xl leading-none tracking-[4px] text-accent">
                                <?php
                                $r = intval($rating);
                                echo str_repeat('', $r);
                                if (5 - $r > 0) {
                                    echo '<span class="text-gray-200">' . str_repeat('', 5 - $r) . '</span>';
                                }
                                ?>
                            </div>
                        <?php endif; ?>
                        <h4 class="text-base font-bold text-primary-dark mb-2"><?php echo esc_html( get_the_title() ); ?></h4>
                        <div class="text-base text-primary-dark/70 leading-relaxed mb-4"><?php the_content(); ?></div>
                        <?php if ($name) : ?>
                            <p class="text-base font-bold text-primary-dark"> -  <?php echo esc_html($name); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</section>

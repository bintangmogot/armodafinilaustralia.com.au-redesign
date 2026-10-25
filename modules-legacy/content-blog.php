<?php
/**
 * Layout: Blog
 * Fields: (none) - auto-displays latest blog posts
 */
$recent = new WP_Query(array('posts_per_page' => 6, 'post_type' => 'post', 'post_status' => 'publish'));
?>
<section class="py-12 px-4">
    <div class="max-w-7xl mx-auto">
        <?php if ($recent->have_posts()): ?>
            <div class="grid md:grid-cols-3 gap-6">
                <?php while ($recent->have_posts()):
                    $recent->the_post(); ?>
                    <?php get_template_part( 'template-parts/content' ); ?>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-gray-400 text-center italic">No blog posts found.</p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</section>
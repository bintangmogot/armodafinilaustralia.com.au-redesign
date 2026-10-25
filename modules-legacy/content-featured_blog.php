<?php
/**
 * Layout: Featured Blog
 * Fields: intro_content (wysiwyg) - displays featured blog posts
 */
$intro_content = get_sub_field('intro_content');
$recent = new WP_Query(array('posts_per_page' => 3, 'post_type' => 'post', 'post_status' => 'publish', 'tag' => 'featured'));
// Fallback to latest posts if no "featured" tag
if (!$recent->have_posts()) {
    $recent = new WP_Query(array('posts_per_page' => 3, 'post_type' => 'post', 'post_status' => 'publish'));
}
?>
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <?php if ($intro_content): ?>
            <div class="prose prose-lg max-w-4xl mx-auto mb-10 text-center"><?php echo armo_content($intro_content); ?>
            </div>
        <?php endif; ?>
        <?php if ($recent->have_posts()): ?>
            <div class="grid md:grid-cols-3 gap-6">
                <?php while ($recent->have_posts()):
                    $recent->the_post(); ?>
                    <?php get_template_part( 'template-parts/content' ); ?>
                <?php endwhile; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
    </div>
</section>
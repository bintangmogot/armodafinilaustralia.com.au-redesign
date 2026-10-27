<?php
$section_title = get_sub_field('grid_title');
$category_slug = get_sub_field('product_category'); // Fetching a category slug from ACF
?>

<section class="py-16 px-4 max-w-7xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-900 mb-8 border-b pb-2"><?php echo esc_html($section_title); ?></h2>
    
    <!-- We inject standard WooCommerce loop shortcuts via custom PHP -->
    <div class="custom-woo-products-grid">
        <?php echo do_shortcode('[products limit="4" columns="4" category="' . esc_attr($category_slug) . '"]'); ?>
    </div>
</section>
<?php
/**
 * Layout: Feature Product Inline
 * Fields: heading (text), feature_product (relationship, return=object, post_type=product), price_subtext (text)
 * Design: White bg, single product displayed inline with image on the left and summary on the right.
 */
$heading = get_sub_field('heading');
$products = get_sub_field('feature_product');
?>

<section class="py-10 lg:py-14 bg-white overflow-hidden">
    <div class="max-w-6xl mx-auto px-6 md:px-12 relative">
        <?php if ($heading): ?>
            <h2 class="text-2xl lg:text-3xl font-bold text-center mb-10 text-primary"><?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if ($products && is_array($products)): ?>
            <?php
            $module_price_subtext = get_sub_field('price_subtext');
            
            // Temporary hook to inject price subtext after the price
            $inject_subtext_fn = function() use ($module_price_subtext) {
                if ($module_price_subtext) {
                    echo '<div class="text-sm font-bold mb-3" style="color: #196C21;">' . esc_html($module_price_subtext) . '</div>';
                }
            };
            add_action('woocommerce_single_product_summary', $inject_subtext_fn, 11);

            foreach ($products as $prod):
                $post_id = is_object($prod) ? $prod->ID : $prod;
                $post_object = get_post($post_id);
                
                if (!$post_object || $post_object->post_type !== 'product') continue;

                global $post, $product;
                $post = $post_object;
                setup_postdata($post);
                $product = wc_get_product($post_id);

                // Prevent reviews anchor button from showing since the reviews section isn't on the blog page
                remove_action('woocommerce_single_product_summary', 'armo_custom_reviews_anchor_button', 27);
                // Prevent product meta (SKU, Categories, Tags) from showing
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                // Prevent theme's custom mobile layout from rendering inside the inline shortcode
                remove_action('woocommerce_single_product_summary', 'armo_mobile_box_open', 25);
                remove_action('woocommerce_single_product_summary', 'armo_mobile_product_image', 26);
                remove_action('woocommerce_single_product_summary', 'armo_mobile_box_close', 32);
                remove_action('woocommerce_single_product_summary', 'armo_display_feature_pills_mobile', 35);
                ?>
                <style>
                    .armo-inline-product-module ul li::before,
                    .armo-inline-product-module ul li::after {
                        display: none !important;
                        content: none !important;
                        background: none !important;
                    }
                    .armo-inline-product-module ul li {
                        background-image: none !important;
                        list-style: none !important;
                        padding-left: 0 !important;
                    }
                    .armo-inline-product-module img.wp-post-image {
                        margin: 0 !important;
                    }
                    .armo-inline-product-module .armo-table-wrapper {
                        margin-bottom: 16px !important;
                    }
                </style>
                <div class="woocommerce my-8 armo-inline-product-module">
                    <div id="product-<?php the_ID(); ?>" <?php wc_product_class('custom-product-layout flex flex-col mx-auto w-full', $product); ?>>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 md:gap-8 items-start">
                            <!-- Left Column: Image -->
                            <div class="product-gallery-column w-full">
                                <a href="<?php echo esc_url( $product->get_permalink() ); ?>" class="block w-full text-center hover:opacity-90 transition-opacity">
                                    <?php 
                                    $image_size = apply_filters( 'woocommerce_gallery_image_size', 'woocommerce_single' );
                                    echo $product->get_image( $image_size, array( 'class' => 'w-full h-auto object-contain rounded-lg inline-block' ) ); 
                                    ?>
                                </a>
                            </div>

                            <!-- Right Column: Summary -->
                            <div class="summary entry-summary">
                                <?php do_action('woocommerce_single_product_summary'); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                // Restore the action for other parts of the site
                add_action('woocommerce_single_product_summary', 'armo_custom_reviews_anchor_button', 27);
                add_action('woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40);
                add_action('woocommerce_single_product_summary', 'armo_mobile_box_open', 25);
                add_action('woocommerce_single_product_summary', 'armo_mobile_product_image', 26);
                add_action('woocommerce_single_product_summary', 'armo_mobile_box_close', 32);
                add_action('woocommerce_single_product_summary', 'armo_display_feature_pills_mobile', 35);
            endforeach; 
            wp_reset_postdata();
            remove_action('woocommerce_single_product_summary', $inject_subtext_fn, 11);
            ?>
        <?php else: ?>
            <p class="text-center text-gray-400 italic mt-6">No products selected.</p>
        <?php endif; ?>
    </div>
</section>

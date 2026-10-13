<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );
global $wp_query;

$shop_page_id = wc_get_page_id('shop');
$current_term = is_product_category() || is_product_tag() ? get_queried_object() : null;

$has_shop_modules = is_shop() && ! is_search() && have_rows('page_modules', $shop_page_id);
$has_cat_modules = $current_term && have_rows('page_modules', $current_term);

if ( $has_shop_modules || $has_cat_modules ) :
    $acf_id = $has_cat_modules ? $current_term : $shop_page_id;
    while( have_rows('page_modules', $acf_id) ) : the_row();
        $layout = get_row_layout();
        get_template_part('modules/content', $layout);
    endwhile;
else :
    // Fallback to standard WooCommerce layout if no modules defined
?>

<div class="bg-gradient-to-b from-brand-50/60 to-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-10 md:pt-12 md:pb-16">
        
        <?php
        // Fetch custom ACF fields
        $top_image = '';
        $bottom_content = '';
        if ( is_product_category() || is_product_tag() ) {
            $top_image = get_field('top_image', $current_term);
            $bottom_content = get_field('bottom_content', $current_term);
            $thumbnail_id = get_term_meta( $current_term->term_id, 'thumbnail_id', true );
            $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : '';
        } elseif ( is_shop() && ! is_search() ) {
            $bottom_content = get_field('bottom_content', $shop_page_id);
        }
        ?>

        <!-- Shop / Search Header -->
            <div class="text-center mb-10">
                <?php 
                $badge_text = 'Full catalogue';
                if ( is_shop() && ! is_search() ) {
                    $badge_text = get_field('shop_badge_text', $shop_page_id) ?: 'Full catalogue';
                } elseif ( is_product_category() ) {
                    $badge_text = get_field('shop_badge_text', get_queried_object()) ?: 'Products';
                }
                ?>
                <span class="text-xs uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5"><?php echo esc_html($badge_text); ?></span>
                <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900">
                    <?php 
                    if ( is_search() ) {
                        $sq = get_search_query();
                        if ( empty($sq) ) {
                            echo 'Products';
                        } else {
                            echo 'Search results: &ldquo;' . esc_html($sq) . '&rdquo;';
                        }
                    } else {
                        $custom_title = '';
                        if ( is_shop() && ! is_search() ) {
                            $custom_title = get_field('shop_custom_title', $shop_page_id);
                        } elseif ( is_product_category() ) {
                            $custom_title = get_field('shop_custom_title', get_queried_object());
                        }
                        
                        if ( ! empty($custom_title) ) {
                            echo wp_kses_post($custom_title);
                        } else {
                            woocommerce_page_title(); 
                        }
                    }
                    ?>
                </h1>
                <div class="mt-3 text-ink-700 max-w-none w-full mx-auto text-base">
                    <?php 
                    if ( is_product_category() || is_product_tag() ) {
                        $desc = term_description();
                        if ( ! empty( $desc ) ) {
                            echo wp_kses_post( $desc );
                        } else {
                            echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                        }
                    } else if ( is_shop() && ! is_search() ) {
                        $shop_desc = get_field('shop_description', $shop_page_id);
                        if ($shop_desc) {
                            echo wp_kses_post( wpautop($shop_desc) );
                        } else {
                            echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                        }
                    } else {
                        echo 'Compare prescription and OTC medicines by category, check ratings and prices in AUD, and add to cart in a few taps &mdash; shipped discreetly across Australia.';
                    }
                    ?>
                </div>
            </div>

    </div>
</div>

<?php 
// Load the archive products module manually for the standard layout
get_template_part('modules/content', 'archive_products'); 
?>

<?php if ( ! empty( $bottom_content ) ) : ?>
    <section class="bg-white pb-16 md:pb-24">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="prose prose-ink prose-brand prose-a:text-brand-600 hover:prose-a:text-brand-700 mx-auto">
                <?php echo wp_kses_post( $bottom_content ); ?>
            </div>
        </div>
    </section>
<?php endif; ?>

<?php endif; // End modules fallback check ?>

<style>
/* Clean up WC sorting dropdown */
.custom-sort-wrapper select {
    height: 2.5rem;
    border-radius: 9999px;
    border-color: #e2e8f0;
    padding-left: 1rem;
    padding-right: 2.5rem;
    font-size: 0.875rem;
    color: #334155;
    background-color: #fff;
    cursor: pointer;
    box-shadow: none;
    outline: none;
}
.custom-sort-wrapper select:focus {
    border-color: #0d9488;
    box-shadow: 0 0 0 1px #0d9488;
}
</style>

<?php
get_footer( 'shop' );


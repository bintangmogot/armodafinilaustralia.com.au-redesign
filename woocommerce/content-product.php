<?php
/**
 * The template for displaying product content within loops
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}
$link = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
$image = wp_get_attachment_image_src( $product->get_image_id(), 'medium_large' );
$img_url = $image ? $image[0] : 'https://placehold.co/400x400/e0f2fe/0369a1?text=Product';

$is_variable = $product->is_type( 'variable' );
$price_html = $product->get_price_html();


$reviews = get_posts([
    'post_type' => 'review',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key'     => 'linked_product',
            'value'   => $product->get_id(),
            'compare' => '='
        )
    )
]);
$review_count = count($reviews);
$total_rating = 0;
if ($review_count > 0) {
    foreach ($reviews as $r) {
        $val = (float)(get_field('rating', $r->ID) ?: 5.0);
        $total_rating += $val;
    }
    $rating = round($total_rating / $review_count, 1);
} else {
    $rating = 5.0; // Default if no reviews
}
?>
<div class="product group bg-white border border-ink-200 rounded-2xl overflow-hidden hover-lift flex flex-col relative" data-product-id="<?php echo $product->get_id(); ?>">
    
    <div class="aspect-square bg-white border-b border-ink-200 relative">
        <a href="<?php echo esc_url( $link ); ?>" target="_blank" class="block w-full h-full">
            <img src="<?php echo esc_url($img_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105 drop-shadow-sm" />
        </a>
        <span class="absolute top-3 left-3 text-[10px] font-bold uppercase tracking-wider text-brand-800 bg-brand-200/80 backdrop-blur-sm px-2.5 py-1 rounded-full pointer-events-none">
            <?php 
            $cats = wc_get_product_category_list($product->get_id(), ', ', '', ''); 
            echo strip_tags($cats) ?: 'Medicine';
            ?>
        </span>
    </div>
    
    <a href="<?php echo esc_url( $link ); ?>" target="_blank" class="p-5 border-t border-ink-100 flex flex-col flex-1 hover:no-underline">
        <h3 class="font-serif text-[15px] sm:text-lg font-semibold text-ink-900 group-hover:text-brand-700 transition-colors"><?php echo esc_html($product->get_name()); ?></h3>
        <div class="product-desc-wrapper mt-1">
            <p class="product-desc-text text-sm text-ink-500 line-clamp-2 transition-all duration-300">
                <?php 
                $shop_text = get_field('shop_page_text', $product->get_id());
                $desc_text = $shop_text ? $shop_text : $product->get_short_description();
                echo esc_html(wp_strip_all_tags($desc_text)); 
                ?>
            </p>
            <?php if ( strlen(wp_strip_all_tags($desc_text)) > 80 ) : // Only show toggle if text is reasonably long ?>
                <span role="button" tabindex="0" onclick="return toggleReadMore(event, this);" class="read-more-btn inline-block mt-1.5 text-xs italic text-ink-400 hover:text-brand-600 focus:outline-none transition-colors relative z-20 cursor-pointer">Read more >></span>
            <?php endif; ?>
        </div>
        
        <div class="mt-auto pt-3 sm:pt-4 flex flex-col-reverse gap-1.5 sm:flex-row sm:items-end sm:justify-between">
            <div class="flex items-center gap-1 self-start sm:self-auto shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star text-amber-500 sm:w-[14px] sm:h-[14px]"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span class="text-xs sm:text-sm font-medium text-ink-700"><?php echo number_format($rating, 1); ?></span>
                <span class="text-[11px] sm:text-xs text-ink-500 ml-0.5">(<?php echo $review_count; ?>)</span>
            </div>
            <div class="flex flex-col items-start sm:items-end w-full sm:w-auto min-w-0">
                <div class="text-[15px] sm:text-base font-semibold text-ink-900 leading-tight [&>span.amount]:!font-semibold [&>del]:text-ink-400 [&>del]:font-normal [&>del]:text-[13px] [&>ins]:no-underline whitespace-nowrap overflow-hidden text-ellipsis w-full max-w-full">
                    <?php echo str_replace(' - ', ' &ndash; ', $price_html); ?>
                </div>
                <?php if ( $price_per_unit = get_field('price_per_unit', $product->get_id()) ) : ?>
                    <div class="text-[10.5px] sm:text-[11px] font-medium text-brand-600 mt-0.5"><?php echo esc_html($price_per_unit); ?></div>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="mt-4 w-full h-10 inline-flex items-center justify-center rounded-xl bg-brand-600 text-white font-semibold text-sm group-hover:bg-brand-700 transition-colors">
            BUY NOW
        </div>
    </a>
</div>





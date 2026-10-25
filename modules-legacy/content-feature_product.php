<?php
/**
 * Layout: Feature Product
 * Fields: heading (text), feature_product (relationship, return=object, post_type=product)
 * Design: White bg, heading centered, product cards in 4-column grid with rounded corners, navy border around images only, "IN STOCK" badge
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
            <!-- 2-column grid on mobile, 4-column grid on desktop -->
            <div class="grid grid-cols-2 gap-4 lg:gap-6 gap-y-5 lg:gap-y-8 mt-8 lg:mt-10 lg:grid-cols-4">
                <?php
                foreach ($products as $product):
                    $post_id = is_object($product) ? $product->ID : $product;
                    $wc_product = wc_get_product($post_id);

                    if ($wc_product):
                        $permalink = esc_url(get_permalink($post_id));
                        $name = armo_content($wc_product->get_name());
                        $price_html = $wc_product->get_price_html();
                        $image_html = $wc_product->get_image('woocommerce_thumbnail', array(
                            'class' => 'w-full h-auto aspect-square object-cover rounded-xl'
                        ));

                        $in_stock = $wc_product->is_in_stock();
                        ?>
                        <div class="flex flex-col h-full">
                            <a href="<?php echo $permalink; ?>"
                                class="group block w-full no-underline text-inherit flex-grow flex flex-col">
                                <div
                                    class="bg-white border border-primary rounded-xl relative p-4 mb-4 flex items-center justify-center min-h-[160px] md:min-h-[180px] transition-all duration-300 group-hover:-translate-y-2 group-hover:shadow-[0_20px_40px_rgba(0,18,94,0.15)] group-hover:border-[#000a33]">

                                    <?php echo $image_html; ?>
                                </div>

                                <div class="text-center px-1 flex-grow flex flex-col">
                                    <h3 class="text-base md:text-lg font-bold text-[#1E1E1E] mb-1 leading-snug">
                                        <?php echo $name; ?>
                                    </h3>
                                    <?php
                                    $copy = get_field('shop_page_text', $post_id);
                                    if (empty($copy)) {
                                        $copy = get_field('shop_page_copy', $post_id);
                                    }
                                    if (empty($copy)) {
                                        $copy = get_post_field('post_excerpt', $post_id);
                                    }
                                    if (!empty($copy)):
                                        $copy_plain = wp_strip_all_tags(strip_shortcodes($copy));
                                        $length = mb_strlen($copy_plain);
                                        ?>
                                        <div class="product-excerpt text-xs md:text-sm text-gray-500 mt-1 mb-2 leading-snug px-1 text-center">
                                            <?php if ($length > 100): 
                                                $short_text = mb_strimwidth($copy_plain, 0, 100, '...');
                                                ?>
                                                 <span class="excerpt-short"><?php echo esc_html($short_text); ?></span>
                                                 <span class="excerpt-full hidden"><?php echo wp_kses_post($copy); ?></span>
                                                 <span class="read-more-toggle text-[11px] text-gray-500 italic hover:text-[#00125e] ml-1 cursor-pointer" onclick="event.preventDefault(); event.stopPropagation(); const p=this.closest('.product-excerpt'); const s=p.querySelector('.excerpt-short'); const f=p.querySelector('.excerpt-full'); if(f.classList.contains('hidden')){ f.classList.remove('hidden'); s.classList.add('hidden'); this.textContent='Read less <<'; }else{ f.classList.add('hidden'); s.classList.remove('hidden'); this.textContent='Read more >>'; }">Read more &gt;&gt;</span>
                                             <?php else: ?>
                                                <span><?php echo wp_kses_post($copy); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="text-base md:text-lg font-extrabold text-primary mb-1">
                                        <?php echo $price_html; ?>
                                    </div>
                                    <?php 
                                    $price_subtext = get_field('price_subtext', $post_id);
                                    if (empty($price_subtext)) $price_subtext = 'From $1.45/tab';
                                    if ($price_subtext): 
                                    ?>
                                        <div class="text-sm font-bold mb-3" style="color: #196C21;">
                                            <?php echo esc_html($price_subtext); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="mt-auto">
                                        <span
                                            class="inline-flex items-center justify-center gap-1 md:gap-2 bg-[#ff0000] text-white py-2 px-3 md:px-6 rounded shadow-md font-bold text-sm md:text-base text-center hover:bg-red-700 transition-colors whitespace-nowrap">
                                            Buy Now
                                            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                                </path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php
                    endif;
                endforeach;
                ?>
            </div>
        <?php else: ?>
            <p class="text-center text-gray-400 italic mt-6">No products selected.</p>
        <?php endif; ?>
    </div>
</section>
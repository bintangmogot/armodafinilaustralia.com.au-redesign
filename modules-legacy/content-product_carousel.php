<?php
/**
 * Layout: Product Carousel
 * Fields: heading (text), feature_product (relationship, return=object, post_type=product)
 * Design: Carousel of products with left/right arrows on desktop, navy border around images only, "IN STOCK" badge
 */
$heading = get_sub_field('heading');
$products = get_sub_field('feature_product');
// Generate a unique ID for this carousel instance
$carousel_id = 'carousel-' . uniqid();
?>

<section class="py-10 lg:py-14 pb-0 lg:pb-0 bg-white relative">
    <!-- removed overflow-hidden to prevent clipping the 4th item -->
    <div class="max-w-[1100px] mx-auto px-6 md:px-12 relative">
        <?php if ($heading): ?>
            <h2 class="text-2xl lg:text-3xl font-bold text-center mb-10 text-primary"><?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if ($products && is_array($products)): ?>
            <div class="relative group">
                <!-- Left Arrow -->
                <div id="<?php echo $carousel_id; ?>-prev" role="button"
                    class="carousel-arrow hidden md:flex absolute left-0 top-1/2 -mt-5 -ml-12 z-10 w-10 h-10 items-center justify-center text-primary hover:text-red-600 cursor-pointer"
                    aria-label="Previous">
                    <svg class="w-10 h-10 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>

                <!-- Carousel Container -->
                <div id="<?php echo $carousel_id; ?>-container"
                    class="grid grid-cols-2 gap-3 gap-y-5 md:flex md:overflow-x-auto md:gap-4 pb-4 md:snap-x md:snap-mandatory w-full md:scroll-smooth">
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
                            <div
                                class="w-full md:w-[calc(25%-14px)] md:flex-shrink-0 md:snap-start flex flex-col hover:bg-gray-100 pb-2 md:pb-6 h-full">
                                <a href="<?php echo $permalink; ?>"
                                    class="block w-full no-underline text-inherit flex-grow flex flex-col">
                                    <div
                                        class="bg-white border border-primary rounded-xl relative p-4 mb-4 flex items-center justify-center min-h-[160px] md:min-h-[180px]">

                                        <?php echo $image_html; ?>
                                    </div>

                                    <div class="text-center px-1 flex-grow flex flex-col">
                                        <h3 class="text-sm md:text-lg font-bold text-[#1E1E1E] mb-1 leading-snug">
                                            <?php echo $name; ?>
                                        </h3>
                                        <div class="text-sm md:text-lg font-extrabold text-primary mb-1">
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
                                                class="inline-flex items-center justify-center gap-1 md:gap-2 bg-[#ff0000] text-white py-2 px-3 md:px-6 rounded shadow-md font-bold text-sm md:text-base text-center hover:bg-red-600 transition-colors whitespace-nowrap">
                                                Buy Now
                                                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

                <!-- Right Arrow -->
                <div id="<?php echo $carousel_id; ?>-next" role="button"
                    class="carousel-arrow hidden md:flex absolute right-0 top-1/2 -mt-5 -mr-12 z-10 w-10 h-10 items-center justify-center text-primary hover:text-red-600 cursor-pointer"
                    aria-label="Next">
                    <svg class="w-10 h-10 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const container = document.getElementById('<?php echo $carousel_id; ?>-container');
                    const prevBtn = document.getElementById('<?php echo $carousel_id; ?>-prev');
                    const nextBtn = document.getElementById('<?php echo $carousel_id; ?>-next');

                    if (container && prevBtn && nextBtn && container.children.length > 0) {
                        prevBtn.addEventListener('click', () => {
                            // Calculate dynamically based on the first card's actual rendered width plus the gap (approx 16px)
                            const cardWidth = container.children[0].offsetWidth;
                            const gap = 16; // md:gap-4 is 16px
                            const scrollAmount = cardWidth + gap;
                            container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
                        });

                        nextBtn.addEventListener('click', () => {
                            const cardWidth = container.children[0].offsetWidth;
                            const gap = 16;
                            const scrollAmount = cardWidth + gap;

                            // Loop back to start if at the end
                            if (container.scrollLeft + container.clientWidth >= container.scrollWidth - 10) {
                                container.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                            }
                        });

                        // Auto-scroll every 5 seconds
                        let autoScroll = setInterval(() => {
                            if(window.innerWidth >= 768) nextBtn.click();
                        }, 5000);

                        // Pause auto-scroll when interacting
                        container.addEventListener('mouseenter', () => clearInterval(autoScroll));
                        container.addEventListener('mouseleave', () => {
                            autoScroll = setInterval(() => {
                                if(window.innerWidth >= 768) nextBtn.click();
                            }, 5000);
                        });
                        container.addEventListener('touchstart', () => clearInterval(autoScroll), { passive: true });
                    }
                });
            </script>
            <style>
                /* Desktop: Hide completely */
                @media (min-width: 768px) {
                    #<?php echo $carousel_id; ?>-container::-webkit-scrollbar {
                        display: none;
                    }

                    #<?php echo $carousel_id; ?>-container {
                        -ms-overflow-style: none;
                        scrollbar-width: none;
                    }
                }
            </style>
        <?php else: ?>
            <p class="text-center text-gray-400 italic mt-6">No products selected.</p>
        <?php endif; ?>
    </div>
</section>
    <?php
    /**
     * Layout: Reviews Carousel Grid
     * Fields: heading (text)
     * Design: White bg, heading centered, 3-column layout on desktop (1 on mobile, 2 on tablet).
     *         Light background cards, blue borders, flex-column inner layout.
     */
    $heading = get_sub_field('heading');
    if (!$heading) $heading = 'Trusted by Everyday Australian\'s';

    $reviews = new WP_Query(array(
        'post_type' => 'reviews',
        'posts_per_page' => 12,
        'post_status' => 'publish',
        'meta_query' => array(
            'relation' => 'OR',
            array('key' => 'linked_product', 'compare' => 'NOT EXISTS'),
            array('key' => 'linked_product', 'value' => '', 'compare' => '=')
        )
    ));

    // Generate a unique ID for this carousel instance
    $carousel_id = 'reviews-carousel-grid-' . uniqid();
    ?>
    <section class="py-12 lg:py-16 bg-white relative overflow-hidden">
        <div class="max-w-[1200px] mx-auto px-6 md:px-12 relative">
            <?php if ($heading): ?>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-center mb-10 text-[#173062]">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php endif; ?>

            <?php if ($reviews->have_posts()): ?>
            <!-- Reduced padding to px-8 md:px-12 so the arrows are closer to the content -->
            <div class="relative group px-8 md:px-12">
                <!-- Left Arrow -->
                <div id="<?php echo $carousel_id; ?>-prev" role="button"
                    class="carousel-arrow absolute left-0 top-1/2 -mt-5 z-10 w-10 h-10 flex items-center justify-center text-primary hover:text-[#FF0000] cursor-pointer"
                    aria-label="Previous">
                    <svg class="w-8 h-8 md:w-10 md:h-10 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>

                <!-- Carousel Container -->
                <!-- Removed 'gap' and reverted to padding inside cards so standard w-1/3 works -->
                <div id="<?php echo $carousel_id; ?>-container"
                    class="flex overflow-x-auto snap-x snap-mandatory hide-scrollbar w-full scroll-smooth py-4 <?php echo ($reviews->found_posts < 3) ? 'md:justify-center' : ''; ?>">
                    <?php while ($reviews->have_posts()):
                        $reviews->the_post();
                        $rating = get_field('rating') ? get_field('rating') : 5;
                        $name = get_field('name') ? get_field('name') : get_the_title();
                        $content = get_the_content();
                        ?>
                        <!-- Card Wrapper: standard 1/3 width, padding creates the gap -->
                        <div class="w-full md:w-1/2 lg:w-1/3 flex-shrink-0 snap-start px-3">
                            <!-- Card Content (Flex Column) -->
                            <div class="h-full bg-gradient-review p-6 md:p-8 flex flex-col items-center text-center shadow-lg" style="border-radius: 30px;">
                                
                                <!-- Name -->
                                <h3 class="text-lg font-bold text-white mb-1">
                                    <?php echo esc_html($name); ?>
                                </h3>

                                <!-- Verified Badge -->
                                <div class="flex items-center gap-1 text-xs text-[#EAA800] font-bold mb-2">
                                    <span>Verified</span>
                                    <svg class="w-4 h-4 text-green-400 fill-current" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                                <!-- Stars -->
                                <div class="text-xl leading-none tracking-[2px] text-[#EAA800] mb-5">
                                    <?php
                                    $r = intval($rating);
                                    echo str_repeat('', $r);
                                    if (5 - $r > 0) {
                                        echo '<span class="text-white/25">' . str_repeat('', 5 - $r) . '</span>';
                                    }
                                    ?>
                                </div>

                                <!-- Title -->
                                <h4 class="text-base font-bold text-white mb-3">
                                    <?php echo esc_html(get_the_title()); ?>
                                </h4>

                                <!-- Content -->
                                <!-- Added [&>p:last-child]:mb-0 to prevent WordPress from adding huge empty space at the bottom -->
                                <div class="text-white/90 text-sm md:text-base leading-relaxed [&>p:last-child]:mb-0">
                                    <?php echo wp_kses_post(wpautop($content)); ?>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Right Arrow -->
                <div id="<?php echo $carousel_id; ?>-next" role="button"
                    class="carousel-arrow absolute right-0 md:right-2 top-1/2 -mt-5 z-10 w-10 h-10 flex items-center justify-center text-primary hover:text-[#FF0000] cursor-pointer"
                    aria-label="Next">
                    <svg class="w-8 h-8 md:w-10 md:h-10 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                    </svg>
                </div>
            </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        const container = document.getElementById('<?php echo $carousel_id; ?>-container');
                        const prevBtn = document.getElementById('<?php echo $carousel_id; ?>-prev');
                        const nextBtn = document.getElementById('<?php echo $carousel_id; ?>-next');

                        if (container && container.children.length > 0) {
                            // Arrow click listeners
                            prevBtn.addEventListener('click', () => {
                                // Scroll by the width of one card
                                const cardWidth = container.children[0].offsetWidth;
                                container.scrollBy({ left: -cardWidth, behavior: 'smooth' });
                            });

                            nextBtn.addEventListener('click', () => {
                                const cardWidth = container.children[0].offsetWidth;
                                container.scrollBy({ left: cardWidth, behavior: 'smooth' });
                            });
                        }
                    });
                </script>

                <style>
                    /* Hide scrollbar for Chrome, Safari and Opera */
                    .hide-scrollbar::-webkit-scrollbar {
                        display: none;
                    }
                    /* Hide scrollbar for IE, Edge and Firefox */
                    .hide-scrollbar {
                        -ms-overflow-style: none; /* IE and Edge */
                        scrollbar-width: none; /* Firefox */
                    }
                </style>
            <?php else: ?>
                <p class="text-center text-gray-400 italic mt-6">No reviews found.</p>
            <?php endif; ?>
            <?php wp_reset_postdata(); ?>
        </div>
    </section>

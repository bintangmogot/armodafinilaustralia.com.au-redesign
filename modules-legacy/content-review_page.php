<?php
/**
 * Layout: Review Page
 * Fields: heading (text)
 * Design: Left column for aggregate score, Right column for stacked review cards.
 */

$heading = get_sub_field('heading');
if ( ! $heading ) {
    $heading = 'Customer Reviews';
}

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$reviews = new WP_Query(array(
    'post_type'      => 'reviews',
    'posts_per_page' => 5,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'OR',
        array('key' => 'linked_product', 'compare' => 'NOT EXISTS'),
        array('key' => 'linked_product', 'value' => '', 'compare' => '=')
    )
));

// Calculate average rating and total
$all_reviews = new WP_Query(array(
    'post_type'      => 'reviews',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'meta_query'     => array(
        'relation' => 'OR',
        array('key' => 'linked_product', 'compare' => 'NOT EXISTS'),
        array('key' => 'linked_product', 'value' => '', 'compare' => '=')
    )
));
$total_reviews = $all_reviews->found_posts;
$total_rating = 0;
$valid_ratings = 0;
if ($all_reviews->have_posts()) {
    while ($all_reviews->have_posts()) {
        $all_reviews->the_post();
        $r = get_field('rating');
        if ($r) {
            $total_rating += intval($r);
            $valid_ratings++;
        }
    }
    wp_reset_postdata();
}
$average_rating = $valid_ratings > 0 ? round($total_rating / $valid_ratings, 1) : 5.0;

// Pagination calculations
$start_count = ( ( $paged - 1 ) * 5 ) + 1;
$end_count   = min( $start_count + 5 - 1, $total_reviews );
?>
<section class="py-14 lg:py-20 px-6 lg:px-12">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl lg:text-4xl font-bold text-primary mb-12 pb-4 border-b border-primary/10">
            <?php echo esc_html( $heading ); ?>
        </h1>

        <div class="flex flex-col lg:flex-row gap-12 lg:gap-20">
            <!-- Left Side: Aggregate Score -->
            <div class="lg:w-1/4 flex flex-col">
                <div class="text-xs text-gray-500 mb-6 uppercase tracking-wider font-semibold" id="aggregate-count-display">
                    Showing <?php echo esc_html( $end_count ); ?> of <?php echo esc_html( $total_reviews ); ?> reviews
                </div>

                <div class="flex flex-row lg:flex-col items-center lg:items-start gap-4">
                    <div class="text-6xl font-bold text-primary leading-none">
                        <?php echo number_format($average_rating, 1); ?>
                    </div>
                    <div>
                        <div class="mb-2 text-2xl leading-none tracking-[4px] text-accent">
                            <?php
                            $r = intval(round($average_rating));
                            echo str_repeat('', $r);
                            if (5 - $r > 0) {
                                echo '<span class="text-gray-300">' . str_repeat('', 5 - $r) . '</span>';
                            }
                            ?>
                        </div>
                        <div class="text-base font-medium text-gray-600">
                            From <?php echo esc_html( $total_reviews ); ?> reviews
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Reviews List -->
            <div class="lg:w-3/4 flex flex-col gap-6" id="reviews-wrapper">
                <div id="reviews-container" class="flex flex-col gap-6">
                    <?php if ( $reviews->have_posts() ) : ?>
                        <?php while ( $reviews->have_posts() ) : $reviews->the_post(); 
                            $rating = get_field('rating') ? get_field('rating') : 5;
                            $name   = get_field('name') ? get_field('name') : get_the_title();
                            $content = get_the_content();
                        ?>
                            <div class="bg-gradient-review rounded-2xl p-4 md:p-8 shadow-md text-white">
                                <div class="grid grid-cols-1 md:grid-cols-[200px_auto_1fr] gap-4 md:gap-8 items-center">
                                    <!-- Left side: Name, Verified, Stars -->
                                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                                        <h3 class="text-lg md:text-xl font-bold text-white mb-1"><?php echo esc_html($name); ?></h3>
                                        
                                        <div class="flex items-center gap-1 text-xs text-accent font-bold mb-3">
                                            <span>Verified</span>
                                            <svg class="w-4 h-4 text-accent fill-current" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </div>
                                        
                                        <div class="text-xl leading-none tracking-[4px] text-accent">
                                            <?php
                                            $r = intval($rating);
                                            echo str_repeat('', $r);
                                            if (5 - $r > 0) {
                                                echo '<span class="text-white/25">' . str_repeat('', 5 - $r) . '</span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <!-- Divider (desktop only) -->
                                    <div class="hidden md:block w-[1px] h-20 bg-white/20 self-stretch"></div>
                                    
                                    <!-- Divider (mobile only) -->
                                    <div class="md:hidden w-full h-[1px] bg-white/20"></div>

                                    <!-- Right side: Title + Content -->
                                    <div class="text-white/90 text-sm md:text-base leading-relaxed text-center md:text-left">
                                        <h4 class="text-xl font-extrabold text-white mb-2"><?php echo esc_html( get_the_title() ); ?></h4>
                                        <?php echo armo_content(wpautop($content)); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else : ?>
                        <p class="text-gray-500 italic">No reviews found.</p>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>

                <!-- Pagination / Load More -->
                <div id="reviews-pagination" class="mt-8 flex flex-col items-center">
                    <div class="text-base text-gray-500 mb-4 font-semibold" data-end="<?php echo esc_attr($end_count); ?>" data-total="<?php echo esc_attr($total_reviews); ?>">
                        Showing <?php echo esc_html( $end_count ); ?> of <?php echo esc_html( $total_reviews ); ?> reviews
                    </div>
                    <?php if ( $reviews->max_num_pages > $paged ) : ?>
                        <a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>" id="load-more-btn" class="group inline-flex items-center gap-2 bg-[#FF0000] text-white font-bold py-4 px-10 rounded-full hover:bg-red-600 transition-colors">
                            Load More
                            <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const wrapper = document.getElementById('reviews-wrapper');
    if (!wrapper) return;

    wrapper.addEventListener('click', function(e) {
        const loadMoreBtn = e.target.closest('#load-more-btn');
        if (!loadMoreBtn) return;

        e.preventDefault();
        
        const nextUrl = loadMoreBtn.getAttribute('href');
        const originalHTML = loadMoreBtn.innerHTML;
        
        // Show loading state
        loadMoreBtn.innerHTML = 'Loading... <svg class="animate-spin w-5 h-5 ml-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
        loadMoreBtn.style.pointerEvents = 'none';

        fetch(nextUrl)
            .then(res => res.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Append the new reviews
                const newReviewsContainer = doc.getElementById('reviews-container');
                if (newReviewsContainer) {
                    document.getElementById('reviews-container').insertAdjacentHTML('beforeend', newReviewsContainer.innerHTML);
                }

                // Update the pagination section with the new button (or remove it if no more pages)
                const newPagination = doc.getElementById('reviews-pagination');
                if (newPagination) {
                    document.getElementById('reviews-pagination').innerHTML = newPagination.innerHTML;
                    
                    // Update the sidebar text to reflect the new count
                    const newCountElement = newPagination.querySelector('[data-end]');
                    if (newCountElement) {
                        const newEnd = newCountElement.getAttribute('data-end');
                        const total = newCountElement.getAttribute('data-total');
                        const aggregateDisplay = document.getElementById('aggregate-count-display');
                        if (aggregateDisplay) {
                            aggregateDisplay.innerHTML = 'Showing ' + newEnd + ' of ' + total + ' reviews';
                        }
                    }
                } else {
                    document.getElementById('reviews-pagination').innerHTML = '';
                }
            })
            .catch(err => {
                console.error('Error loading more reviews:', err);
                loadMoreBtn.innerHTML = originalHTML;
                loadMoreBtn.style.pointerEvents = 'auto';
            });
    });
});
</script>

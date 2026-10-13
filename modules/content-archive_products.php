<?php
global $wp_query;

if ( ! woocommerce_product_loop() ) {
    echo '<p class="text-center text-ink-500 py-12 bg-white">No products found matching your criteria.</p>';
    return;
}
?>
<section class="bg-white pb-16 md:pb-24 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="pt-4 md:pt-8 flex flex-col xl:flex-row xl:items-center gap-4 justify-between w-full min-w-0">
            <div class="flex overflow-x-auto pb-2 xl:pb-0 xl:flex-wrap gap-2 hide-scrollbar w-full min-w-0" style="scrollbar-width: none;">
                <!-- Categories filter -->
                <a href="<?php echo esc_url( wc_get_page_permalink('shop') ); ?>" class="shrink-0 text-sm font-medium px-4 h-9 rounded-full border transition-colors flex items-center <?php echo !is_product_category() && !is_search() ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600'; ?>">All categories</a>
                <?php
                $product_categories = get_terms( 'product_cat', array('hide_empty' => true) );
                if ( ! empty( $product_categories ) && ! is_wp_error( $product_categories ) ) {
                    foreach ( $product_categories as $cat ) {
                        $is_active = is_product_category( $cat->slug );
                        $class = $is_active ? 'bg-brand-600 text-white border-brand-600' : 'bg-white text-ink-700 border-ink-200 hover:border-brand-600';
                        echo '<a href="' . esc_url( get_term_link( $cat ) ) . '" class="shrink-0 text-sm font-medium px-4 h-9 flex items-center rounded-full border transition-colors ' . $class . '">' . esc_html( $cat->name ) . '</a>';
                    }
                }
                ?>
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="flex items-center bg-white border border-ink-200 rounded-full px-3 h-10 flex-1 md:w-72">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-search text-ink-500"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    <form role="search" method="get" class="flex-1 flex" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                        <input type="search" class="bg-transparent outline-none border-0 text-sm flex-1 mx-2" placeholder="Search products..." value="<?php echo get_search_query(); ?>" name="s" />
                        <input type="hidden" name="post_type" value="product" />
                    </form>
                </div>
                <!-- WooCommerce Native Sorting -->
                <div class="custom-sort-wrapper">
                    <?php woocommerce_catalog_ordering(); ?>
                </div>
            </div>
        </div>

        <p class="mt-6 text-xs text-ink-500" id="result-count-text">
            <?php
            $paged    = max( 1, $wp_query->get( 'paged' ) );
            $per_page = $wp_query->get( 'posts_per_page' );
            $total    = $wp_query->found_posts;
            $first    = ( $per_page * $paged ) - $per_page + 1;
            $last     = min( $total, $wp_query->get( 'posts_per_page' ) * $paged );
            echo esc_html( sprintf( _n( 'Showing %d of %d product', 'Showing %d-%d of %d products', $total, 'woocommerce' ), 1, $last, $total ) );
            ?>
        </p>

        <div id="products-grid" class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-5">
            <?php
            while ( have_posts() ) {
                the_post();
                do_action( 'woocommerce_shop_loop' );
                wc_get_template_part( 'content', 'product' );
            }
            ?>
        </div>

        <div id="load-more-wrapper" class="mt-12 flex justify-center">
            <?php
            $current_page = max(1, get_query_var('paged'));
            $total_pages = $wp_query->max_num_pages;
            if ($current_page < $total_pages) {
                $next_url = get_pagenum_link($current_page + 1);
                echo '<a href="' . esc_url($next_url) . '" id="load-more-btn" class="inline-flex items-center justify-center h-11 px-8 rounded-full bg-brand-50 text-brand-700 font-semibold hover:bg-brand-600 hover:text-white transition-colors">Load more</a>';
            }
            ?>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const productsGrid = document.getElementById('products-grid');
    const resultCount = document.getElementById('result-count-text');

    if (loadMoreBtn && productsGrid) {
        document.addEventListener('click', function(e) {
            if (e.target && (e.target.id === 'load-more-btn' || e.target.closest('#load-more-btn'))) {
                e.preventDefault();
                const btn = e.target.closest('#load-more-btn');
                const nextUrl = btn.getAttribute('href');
                if (!nextUrl) return;

                const originalText = btn.innerHTML;
                btn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Loading...';
                btn.style.pointerEvents = 'none';
                btn.style.opacity = '0.7';

                fetch(nextUrl)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        const newProducts = doc.getElementById('products-grid');
                        if (newProducts) {
                            productsGrid.insertAdjacentHTML('beforeend', newProducts.innerHTML);
                        }
                        
                        const newLoadMore = doc.getElementById('load-more-btn');
                        if (newLoadMore) {
                            btn.setAttribute('href', newLoadMore.getAttribute('href'));
                            btn.innerHTML = originalText;
                            btn.style.pointerEvents = 'auto';
                            btn.style.opacity = '1';
                        } else {
                            document.getElementById('load-more-wrapper').remove();
                        }

                        const newCount = doc.getElementById('result-count-text');
                        if (newCount && resultCount) {
                            resultCount.innerHTML = newCount.innerHTML;
                        }
                    })
                    .catch(error => {
                        console.error('Error loading products:', error);
                        window.location.href = nextUrl;
                    });
            }
        });
    }
});
</script>

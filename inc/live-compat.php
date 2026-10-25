<?php
/**
 * Behaviour carried over from the live theme (armodafinil-australia, cPanel main @3b71520)
 * that keeps URLs, redirects and the review forms working after the redesign.
 * Nothing in here outputs copy.
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * 301 redirects for old URLs (path => destination). Add pairs here or use the Redirection plugin.
 */
add_action( 'init', function () {
	$redirects = apply_filters( 'armo_legacy_redirects', array( '/shop-page' => '/shop' ) );
	if ( empty( $_SERVER['REQUEST_URI'] ) || is_admin() ) {
		return;
	}
	$path = '/' . trim( strtolower( (string) wp_parse_url( $_SERVER['REQUEST_URI'], PHP_URL_PATH ) ), '/' );
	foreach ( $redirects as $old => $new ) {
		$old = '/' . trim( strtolower( $old ), '/' );
		if ( $path === $old || strpos( $path, $old . '/' ) === 0 ) {
			wp_safe_redirect( home_url( str_replace( $old, $new, $path ) ), 301 );
			exit;
		}
	}
}, 1 );

add_filter('woocommerce_get_breadcrumb', 'armo_remove_categories_from_product_breadcrumb', 10, 2);
function armo_remove_categories_from_product_breadcrumb($crumbs, $breadcrumb)
{
    if (is_product()) {
        $new_crumbs = array();

        // 1. Always keep Home (first item)
        if (isset($crumbs[0])) {
            $new_crumbs[] = $crumbs[0];
        }

        // 2. Add Shop page manually
        $shop_page_id = wc_get_page_id('shop');
        if ($shop_page_id > 0) {
            $new_crumbs[] = array(get_the_title($shop_page_id), get_permalink($shop_page_id));
        }

        // 3. Always keep the Product Name (last item)
        $last_crumb = end($crumbs);
        if ($last_crumb) {
            $new_crumbs[] = $last_crumb;
        }

        return $new_crumbs;
    }

    return $crumbs;
}

/**
 * Force 301 redirect from /?post_type=product to /shop/ to clean up Google Index
 */
add_action('template_redirect', 'armo_force_shop_redirect_for_seo');
function armo_force_shop_redirect_for_seo()
{
    if (is_shop() && isset($_GET['post_type']) && $_GET['post_type'] === 'product') {
        $shop_url = wc_get_page_permalink('shop');
        if ($shop_url) {
            wp_redirect($shop_url, 301);
            exit;
        }

    }
}

/**
 * ══════════════════════════════════════════════════════════════════════
 * FIX: Product Permalink - Google Indexing Issues
 * ══════════════════════════════════════════════════════════════════════
 *
 * PROBLEM:
 * Products at /shop/waklert-50-mg-australia/ get "Indexing request
 * rejected" in Google Search Console because they share the /shop/
 * prefix with the shop archive page.
 *
 * ROOT CAUSE:
 * The WooCommerce product permalink base uses the same slug as the
 * Shop page ("shop"). WordPress internally resolves /shop/ as the
 * archive, but /shop/product-slug/ can confuse Google's crawler
 * because the shop page returns paginated product listings and
 * Google may see deep /shop/* URLs as soft-404 duplicates.
 *
 * FIX:
 * 1. Ensure product base uses a DIFFERENT slug than the shop page
 *    by using the "Custom Base" option: /shop/%product_cat%/
 *    This creates URLs like: /shop/armodafinil/waklert-50-mg-australia/
 *    which Google can clearly distinguish from the /shop/ archive.
 * 2. One-time rewrite flush to regenerate .htaccess rules
 * 3. Send explicit indexing headers on product pages
 * ══════════════════════════════════════════════════════════════════════
 */

/**
 * WooCommerce Product Permalink Structure
 *
 * Sets product URLs to: /shop/product-slug/
 * Clean, flat structure without category for better SEO.
 */
add_filter('option_woocommerce_permalinks', 'armo_fix_product_permalink_structure');
function armo_fix_product_permalink_structure($permalinks)
{
    if (!is_array($permalinks)) {
        $permalinks = array();
    }
    // Flat product URLs: /shop/product-slug/
    $permalinks['product_base'] = '/shop';
    return $permalinks;
}

/**
 * Send explicit X-Robots-Tag header on single product pages
 * to tell Google: "Yes, index this page."
 */
add_action('template_redirect', 'armo_product_indexing_headers', 5);
function armo_product_indexing_headers()
{
    if (is_product()) {
        header('X-Robots-Tag: index, follow', true);
    }
}

/**
 * One-time rewrite rules flush after permalink structure change.
 * This regenerates .htaccess so the new flat product URLs work.
 * The flag is stored in options so it only runs once.
 */
add_action('init', 'armo_flush_rewrite_rules_once');
function armo_flush_rewrite_rules_once()
{
    if (get_option('armo_permalinks_flushed_v5') !== 'yes') {
        flush_rewrite_rules();
        update_option('armo_permalinks_flushed_v5', 'yes');
    }
}

/**
 * 301 Redirect: Old category-based product URLs → new flat URLs
 *
 * Redirects /shop/shop-armodafinil/product-slug/ → /shop/product-slug/
 * This preserves SEO link equity from any indexed or bookmarked old URLs.
 */
add_action('template_redirect', 'armo_redirect_old_category_product_urls', 1);
function armo_redirect_old_category_product_urls()
{
    // Only run on 404s (old URLs will 404 since the structure changed)
    if (!is_404()) {
        return;
    }

    $request_uri = trim($_SERVER['REQUEST_URI'], '/');

    // Match pattern: shop/shop-armodafinil/product-slug/
    if (preg_match('#^shop/shop-armodafinil/([^/]+)/?$#i', $request_uri, $matches)) {
        $product_slug = $matches[1];
        $new_url = home_url('/shop/' . $product_slug . '/');

        wp_redirect($new_url, 301);
        exit;
    }
}

/**
 * Force AIOSEO to use the featured image as the default Open Graph and Twitter image.
 */
add_filter('aioseo_facebook_tags', 'armo_force_aioseo_og_image');
function armo_force_aioseo_og_image($facebookMeta)
{
    if (is_singular() && has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if ($image_url) {
            $facebookMeta['og:image'] = $image_url;
            $facebookMeta['og:image:secure_url'] = $image_url;
        }
    }
    return $facebookMeta;
}

add_filter('aioseo_twitter_tags', 'armo_force_aioseo_twitter_image');
function armo_force_aioseo_twitter_image($twitterMeta)
{
    if (is_singular() && has_post_thumbnail()) {
        $image_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
        if ($image_url) {
            $twitterMeta['twitter:image'] = $image_url;
        }
    }
    return $twitterMeta;
}


/**
 * AJAX handler: Load paginated product-specific reviews.
 *
 * Called by the "Load More" button on individual product review sections.
 * Accepts: product_id, page (pagination)
 * Returns: JSON with reviews HTML, has_more flag, shown count, total count
 */
function armo_load_product_reviews()
{
    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $per_page = 5;

    if (!$product_id) {
        wp_send_json_error(array('message' => 'Invalid product.'));
    }

    $reviews = new WP_Query(array(
        'post_type' => 'reviews',
        'posts_per_page' => $per_page,
        'paged' => $page,
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => 'linked_product',
                'value' => $product_id,
                'compare' => '=',
            ),
        ),
    ));

    $html = '';
    if ($reviews->have_posts()) {
        ob_start();
        while ($reviews->have_posts()) {
            $reviews->the_post();
            $rating = get_field('rating') ? get_field('rating') : 5;
            $name = get_field('name') ? get_field('name') : get_the_title();
            $content = get_the_content();
            ?>
            <div
                class="bg-gradient-review rounded-2xl p-4 md:p-8 shadow-md text-white shrink-0 snap-start w-[85%] md:w-[95%] lg:w-full max-w-full">
                <div class="grid grid-cols-1 md:grid-cols-[200px_auto_1fr] gap-4 md:gap-8 items-center">
                    <!-- Left side: Name, Verified, Stars -->
                    <div class="flex flex-col items-center md:items-start text-center md:text-left">
                        <h3 class="text-lg md:text-xl font-bold text-white mb-1"><?php echo esc_html($name); ?></h3>
                        <div class="flex items-center gap-1 text-xs text-accent font-bold mb-3">
                            <span>Verified</span>
                            <svg class="w-4 h-4 text-accent fill-current" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
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
                    <div class="hidden md:block w-px h-full bg-white/20 mx-auto"></div>

                    <!-- Right side: Content -->
                    <div class="text-white/90 text-sm md:text-base leading-relaxed text-center md:text-left">
                        <h4 class="text-xl font-extrabold text-white mb-2"><?php echo esc_html(get_the_title()); ?></h4>
                        <?php echo wp_kses_post(wpautop($content)); ?>
                    </div>
                </div>
            </div>
            <?php
        }
        $html = ob_get_clean();
        wp_reset_postdata();
    }

    $shown = min($page * $per_page, $reviews->found_posts);

    wp_send_json_success(array(
        'html' => $html,
        'has_more' => $page < $reviews->max_num_pages,
        'shown' => $shown,
        'total' => $reviews->found_posts,
    ));
}
add_action('wp_ajax_armo_load_product_reviews', 'armo_load_product_reviews');
add_action('wp_ajax_nopriv_armo_load_product_reviews', 'armo_load_product_reviews');

/**
 * Handle Review Form Submission via AJAX.
 *
 * =====================================================================
 *  PHP GUIDE:
 * =====================================================================
 * When a visitor submits the review form on the frontend, the form data
 * is sent here via AJAX. This function:
 * 1. Verifies the security nonce
 * 2. Sanitizes all input data
 * 3. Creates a new 'reviews' CPT post with status 'pending'
 * 4. Saves the rating and name as ACF fields
 *
 * The review will NOT appear on the site until the admin goes to
 * Reviews → All Reviews and changes the status from "Pending" to "Published".
 * =====================================================================
 */
function armo_handle_review_submission() {
    // Verify security nonce
    if ( ! isset( $_POST['armo_review_nonce'] ) || ! wp_verify_nonce( $_POST['armo_review_nonce'], 'armo_submit_review' ) ) {
        wp_send_json_error( array( 'message' => 'Security check failed. Please refresh the page and try again.' ) );
    }

    // Sanitize inputs
    $title      = isset( $_POST['review_title'] )      ? sanitize_text_field( $_POST['review_title'] )      : '';
    $content    = isset( $_POST['review_content'] )    ? sanitize_textarea_field( $_POST['review_content'] ) : '';
    $name       = isset( $_POST['review_name'] )       ? sanitize_text_field( $_POST['review_name'] )       : '';
    $email      = isset( $_POST['review_email'] )      ? sanitize_email( $_POST['review_email'] )           : '';
    $rating     = isset( $_POST['review_rating'] )     ? intval( $_POST['review_rating'] )                  : 5;
    $product_id = isset( $_POST['review_product_id'] ) ? intval( $_POST['review_product_id'] )              : 0;

    // Validate required fields
    if ( empty( $title ) || empty( $content ) || empty( $name ) || empty( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please fill in all required fields.' ) );
    }

    // Validate email
    if ( ! is_email( $email ) ) {
        wp_send_json_error( array( 'message' => 'Please enter a valid email address.' ) );
    }

    // Clamp rating to 1-5
    $rating = max( 1, min( 5, $rating ) );

    // Create the review post as 'pending' (requires admin approval)
    $post_id = wp_insert_post( array(
        'post_type'    => 'reviews',
        'post_title'   => $title,
        'post_content' => $content,
        'post_status'  => 'pending',
    ) );

    if ( is_wp_error( $post_id ) ) {
        wp_send_json_error( array( 'message' => 'Something went wrong. Please try again.' ) );
    }

    // Save ACF fields
    update_field( 'rating', $rating, $post_id );
    update_field( 'name', $name, $post_id );
    update_field( 'email', $email, $post_id );

    // Save linked product if submitted from a product page
    if ( $product_id > 0 ) {
        update_field( 'linked_product', $product_id, $post_id );
    }

    wp_send_json_success( array(
        'message' => 'Thank you for your review! It will appear on the site once approved.',
    ) );
}
// wp_ajax_ = for logged-in users, wp_ajax_nopriv_ = for visitors (not logged in)
add_action( 'wp_ajax_armo_submit_review', 'armo_handle_review_submission' );
add_action( 'wp_ajax_nopriv_armo_submit_review', 'armo_handle_review_submission' );

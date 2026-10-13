<?php
add_action('acf/init', function() {
    if( function_exists('acf_add_options_page') ) {

        acf_add_options_page(array(
            'page_title' => 'Theme General Settings', 
            'menu_title' => 'Theme Settings', 
            'menu_slug'  => 'theme-general-settings', 
            'capability' => 'manage_options', 
            'redirect'   => false,
            'position'   => 3,
            'icon_url'   => 'dashicons-admin-generic'
        ));
    }
});



/**
 * Theme functions and definitions
 *
 * @package Armodafinil_Australia_Direct
 */

if ( ! defined( '_S_VERSION' ) ) {
	define( '_S_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );
}

function armodafinil_australia_scripts() {
	wp_enqueue_style( 'armodafinil-australia-style', get_stylesheet_uri(), array(), _S_VERSION );
}
add_action( 'wp_enqueue_scripts', 'armodafinil_australia_scripts' );

// Add theme support
function armodafinil_australia_setup() {
    // Enable WordPress Menus
    add_theme_support('menus');
    register_nav_menus(array(
        'primary' => __('Primary Navigation (Desktop)', 'armodafinil-australia-direct'),
        'mobile'  => __('Mobile Navigation', 'armodafinil-australia-direct'),
        'footer_1'  => __('Footer Column 1', 'armodafinil-australia-direct'),
        'footer_2'  => __('Footer Column 2', 'armodafinil-australia-direct'),
        'footer_3'  => __('Footer Column 3', 'armodafinil-australia-direct'),
        'footer_4'  => __('Footer Column 4', 'armodafinil-australia-direct'),
        'footer_trending'  => __('Footer Trending Products', 'armodafinil-australia-direct'),
    ));

    add_theme_support( 'title-tag' );
    add_theme_support( 'post-thumbnails' );
    add_theme_support( 'editor-styles' );
    add_editor_style( 'editor-style.css' );
    add_theme_support( 'woocommerce' );
}
add_action( 'after_setup_theme', 'armodafinil_australia_setup' );

// TinyMCE loads editor styles inside its iframe and browsers cache that file
// independently from the WordPress admin page. Version the URL with the file's
// modification time so a normal refresh receives the current styles.
add_filter('mce_css', function($stylesheets) {
    $editor_style_path = get_template_directory() . '/editor-style.css';
    if (!file_exists($editor_style_path)) {
        return $stylesheets;
    }

    $editor_style_url = add_query_arg(
        'ver',
        (string) filemtime($editor_style_path),
        get_template_directory_uri() . '/editor-style.css'
    );

    $items = array_filter(array_map('trim', explode(',', (string) $stylesheets)));
    $items = array_values(array_filter($items, function($url) {
        return strpos($url, '/editor-style.css') === false;
    }));
    $items[] = $editor_style_url;

    return implode(',', array_unique($items));
}, 20);

add_filter( 'loop_shop_per_page', function() { return 20; }, 20 );

require get_template_directory() . '/inc/acf-fields.php';
require_once get_template_directory() . '/inc/cpt.php';
require_once get_template_directory() . '/inc/acf-options.php';
require_once get_template_directory() . '/inc/ajax-auth.php';
require_once get_template_directory() . '/inc/ajax-reviews.php';
require_once get_template_directory() . '/inc/ajax-search.php';
require_once get_template_directory() . '/inc/medical-reviewers.php';
require_once get_template_directory() . '/inc/email-routing.php';

add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3', 'footer_4', 'footer_trending'])) {
        // li classes for footer
        // No specific classes needed for li since space-y-2 is on ul
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3', 'footer_4', 'footer_trending'])) {
        $atts['class'] = 'hover:text-brand-300';
    }
    return $atts;
}, 10, 3);

add_action('wp_footer', function() {
?>
    <script>
    function toggleReadMore(e, btn) {
        e.preventDefault();
        e.stopPropagation();
        const text = btn.previousElementSibling;
        if (text.classList.contains('line-clamp-2')) {
            text.classList.remove('line-clamp-2');
            btn.innerHTML = 'Read less &gt;&gt;';
        } else {
            text.classList.add('line-clamp-2');
            btn.innerHTML = 'Read more &gt;&gt;';
        }
    }
    </script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const syncLoopWishlist = () => {
            document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
                const pid = btn.dataset.productId;
                const container = document.querySelector('.loop-wishlist-plugin-container[data-product-id="' + pid + '"]');
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                let isAdded = false;
                if (container.querySelector('.yith-wcwl-wishlistaddedbrowse.show, .yith-wcwl-wishlistexistsbrowse.show') || (yithBtn && yithBtn.classList.contains('added'))) {
                    isAdded = true;
                }
                if (tiBtn && (tiBtn.classList.contains('tinvwl-product-in-list') || tiBtn.classList.contains('in-wishlist'))) {
                    isAdded = true;
                }
                
                if (isAdded) {
                    btn.classList.add('text-brand-600');
                    btn.classList.remove('text-ink-400');
                    btn.querySelector('svg').classList.add('fill-brand-600');
                } else {
                    btn.classList.remove('text-brand-600');
                    btn.classList.add('text-ink-400');
                    btn.querySelector('svg').classList.remove('fill-brand-600');
                }
            });
        };

                syncLoopWishlist();
        setInterval(syncLoopWishlist, 500);

        document.querySelectorAll('.loop-wishlist-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                const pid = btn.dataset.productId;
                const container = document.querySelector('.loop-wishlist-plugin-container[data-product-id="' + pid + '"]');
                if(!container) return;
                
                const yithBtn = container.querySelector('.add_to_wishlist');
                const tiBtn = container.querySelector('.tinvwl_add_to_wishlist_button');
                
                if (yithBtn) {
                    yithBtn.click();
                } else if (tiBtn) {
                    tiBtn.click();
                } else {
                    alert('Wishlist plugin is not active.');
                }
            });
        });
    });
    </script>
<?php
});

// Add Tailwind classes to dynamic menu
add_filter("nav_menu_css_class", function($classes, $item, $args) { 
    if($args->theme_location === "primary") { 
        $classes[] = "flex items-center"; 
    } elseif($args->theme_location === "mobile") {
        $classes[] = "border-b border-ink-100 last:border-0";
    }
    return $classes; 
}, 10, 3);

add_filter("nav_menu_link_attributes", function($atts, $item, $args) { 
    if($args->theme_location === "primary") { 
        $atts["class"] = "px-3 py-2 rounded-md text-sm font-medium transition-colors text-ink-700 hover:text-brand-700 hover:bg-brand-50/60"; 
    } elseif($args->theme_location === "mobile") { 
        $atts["class"] = "block w-full text-left px-6 py-4 text-base font-medium text-ink-900 hover:bg-brand-50 transition-colors"; 
    } 
    return $atts; 
}, 10, 3);


add_filter('nav_menu_css_class', function($classes, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3', 'footer_4', 'footer_trending'])) {
        // li classes for footer
        // No specific classes needed for li since space-y-2 is on ul
    }
    return $classes;
}, 10, 3);

add_filter('nav_menu_link_attributes', function($atts, $item, $args) {
    if(in_array($args->theme_location, ['footer_1', 'footer_2', 'footer_3', 'footer_4', 'footer_trending'])) {
        $atts['class'] = 'hover:text-brand-300';
    }
    return $atts;
}, 10, 3);

?>

<?php

/**
 * Sticky Add to Cart Bar for Single Products
 */
add_action( 'wp_footer', 'aad_sticky_add_to_cart_bar' );
function aad_sticky_add_to_cart_bar() {
    if ( ! is_product() ) return;
    global $product;
    if ( ! $product ) return;
    ?>
    <style>
        .aad-sticky-bar {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background-color: #ffffff;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -10px 40px rgba(0,0,0,0.08);
            z-index: 9999;
            transform: translateY(100%);
            transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
            padding-bottom: env(safe-area-inset-bottom);
        }
        .aad-sticky-bar-inner {
            max-width: 80rem;
            margin: 0 auto;
            padding: 10px 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        @media (min-width: 640px) {
            .aad-sticky-bar-inner { padding: 16px 24px; }
        }
        @media (min-width: 1024px) {
            .aad-sticky-bar-inner { padding: 16px 32px; }
        }
        .aad-sticky-bar.is-visible {
            transform: translateY(0);
        }
                /* Mobile UX Fixes */
        @media (max-width: 767px) { .aad-sticky-bar-inner { padding-right: 80px !important; } }
        @media (max-width: 767px) {
            .aad-sticky-bar-left {
                display: none !important; /* Hide image and title on mobile to save space */
            }
            .aad-sticky-bar-right {
                width: 100% !important;
                justify-content: flex-start !important;
                gap: 12px !important;
                
            }
            .aad-sticky-price {
                font-size: 1.15rem !important; /* Smaller price on mobile to prevent wrapping */
                text-align: left !important;
                margin-right: auto;
            }
            .aad-sticky-btn {
                padding: 0 14px !important;
                height: 40px !important;
                font-size: 0.8rem !important;
            }
            .aad-sticky-btn svg {
                width: 16px !important;
                height: 16px !important;
            }
            .aad-sticky-btn span {
                display: none; /* Hide "Add to cart" text if needed, or keep it. Let's keep it but it might be tight. Actually let's keep it. */
            }
        }
        .aad-sticky-bar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 33%;
        }
        .aad-sticky-bar-img {
            width: 72px;
            height: 72px;
            min-width: 72px;
            border-radius: 12px;
            object-fit: cover;
            border: 1px solid #e2e8f0;
            object-fit: cover;
        }
        .aad-sticky-bar-right {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            gap: 16px;
        }
        @media (min-width: 768px) {
            .aad-sticky-bar-right {
                justify-content: flex-end;
                width: 66%;
            }
        }
        .aad-sticky-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1a4f48;
            text-align: right;
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }
        @media (min-width: 640px) {
            .aad-sticky-price { font-size: 1.75rem; }
        }
        .aad-sticky-price del {
            color: #94a3b8;
            font-size: 0.65em;
            font-weight: 500;
            text-decoration: line-through;
        }
        .aad-sticky-price ins {
            text-decoration: none;
            color: #1a4f48;
        }
        .aad-sticky-btn {
            height: 44px;
            padding: 0 24px;
            border-radius: 12px;
            background-color: #0f766e;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            gap: 8px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 4px 12px rgba(15, 118, 110, 0.2);
            white-space: nowrap;
        }
        @media (min-width: 640px) {
            .aad-sticky-btn {
                height: 48px;
                padding: 0 32px;
                font-size: 1rem;
            }
        }
        .aad-sticky-btn:hover {
            background-color: #115e59;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(15, 118, 110, 0.3);
        }
        .aad-sticky-btn:active {
            transform: scale(0.96);
        }
        
        body.has-sticky-bar-visible .whatsapp-float {
            transform: translateY(-70px) !important;
        }
    </style>

    <div id="sticky-add-to-cart" class="aad-sticky-bar">
        <div class="aad-sticky-bar-inner">
            <div class="aad-sticky-bar-left">
            <?php echo $product->get_image('thumbnail', ['class' => 'aad-sticky-bar-img']); ?>
            <div style="min-width:0;">
                <div style="font-family:serif; font-weight:700; color:#0f172a; line-height:1.2; font-size:15px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo esc_html($product->get_name()); ?></div>
                <div style="font-size:11px; color:#64748b; margin-top:2px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;"><?php echo esc_html(wp_strip_all_tags($product->get_short_description())); ?></div>
            </div>
        </div>
        
        <div class="aad-sticky-bar-right">
            <div class="aad-sticky-price sticky-price-target">
                <?php echo $product->get_price_html(); ?>
            </div>
            <button id="sticky-add-to-cart-btn" class="aad-sticky-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <span>Add to Cart</span>
            </button>
        </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stickyBar = document.getElementById('sticky-add-to-cart');
        const stickyBtn = document.getElementById('sticky-add-to-cart-btn');
        // Find the main add to cart button. Using the correct selector based on the theme HTML
        const mainAddToCartBtn = document.querySelector('button[name="add-to-cart"]');

        if (!stickyBar || !mainAddToCartBtn) {
            console.log('Sticky bar or main add to cart button not found', {stickyBar, mainAddToCartBtn});
            return;
        }

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    stickyBar.classList.remove('is-visible');
                    document.body.classList.remove('has-sticky-bar-visible');
                } else {
                    if (entry.boundingClientRect.top < 0) {
                        stickyBar.classList.add('is-visible');
                        document.body.classList.add('has-sticky-bar-visible');
                    }
                }
            });
        }, { threshold: 0 });

        observer.observe(mainAddToCartBtn);

        stickyBtn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const mainForm = mainAddToCartBtn.closest('form.cart');
            
            if (mainAddToCartBtn.classList.contains('disabled')) {
                if(mainForm) mainForm.scrollIntoView({ behavior: 'smooth', block: 'center' });
                // Note: table.variations might not exist if they use custom variant buttons
                const variantButtons = document.getElementById('variant-buttons');
                if(variantButtons) {
                    variantButtons.style.transition = 'transform 0.1s';
                    variantButtons.style.transform = 'scale(1.02)';
                    setTimeout(() => { variantButtons.style.transform = 'scale(1)'; }, 150);
                }
            } else {
                mainAddToCartBtn.click();
            }
        });
        
        // Listen to WooCommerce variation changes to update the sticky bar price dynamically
        if (typeof jQuery !== 'undefined') {
            jQuery('.variations_form').on('show_variation', function(event, variation) {
                if (variation.price_html) {
                    jQuery('.sticky-price-target').html(variation.price_html);
                }
            });
        }
    });
    </script>
    <?php
}

/**
 * Polyfill for _.pluck and _.contains which were removed in Underscore.js 1.8+
 * but are still used by WordPress core's wp-backbone and media-views scripts.
 * Needed when a plugin loads a newer Underscore.js that overwrites WP's bundled version.
 */



// Force default WooCommerce variable price range format (fixes From overrides from plugins)
add_filter( 'woocommerce_variable_price_html', 'aad_force_default_variable_price_range', 9999, 2 );
function aad_force_default_variable_price_range( $price, $product ) {
    $min_price = $product->get_variation_price( 'min', true );
    $max_price = $product->get_variation_price( 'max', true );
    if ( $min_price !== $max_price ) {
        $price = wc_format_price_range( $min_price, $max_price );
    } else {
        $price = wc_price( $min_price );
    }
    return $price;
}

// Add 'A' before '$' to make it clear it's AUD
add_filter('woocommerce_currency_symbol', 'aad_change_currency_symbol', 10, 2);
function aad_change_currency_symbol( $currency_symbol, $currency ) {
    if ( $currency === 'AUD' ) {
        return 'A$';
    }
    return $currency_symbol;
}
// Fix ACF WYSIWYG bookmark bug on backend


// Clean them out just in case before saving to DB
add_filter('acf/load_value/type=wysiwyg', 'aad_clean_acf_wysiwyg_bookmarks', 10, 3);
add_filter('acf/update_value/type=wysiwyg', 'aad_clean_acf_wysiwyg_bookmarks', 10, 3);
add_filter('acf/format_value/name=link', function($value, $post_id, $field) {
    if (is_string($value) && preg_match('/^mailto:support@/i', $value)) {
        return home_url('/contact/');
    }
    return $value;
}, 10, 3);
add_filter('content_save_pre', 'aad_clean_acf_wysiwyg_bookmarks', 10, 1);
add_filter('excerpt_save_pre', 'aad_clean_acf_wysiwyg_bookmarks', 10, 1);
function aad_clean_acf_wysiwyg_bookmarks($value, $post_id = null, $field = null) {
    if (!empty($value) && is_string($value)) {
        // Selection bookmarks are TinyMCE's temporary cursor markers. They must
        // never be stored in ACF content; accept both quote styles because pasted
        // HTML and older editor versions may use either one.
        $value = preg_replace('/<span\b[^>]*\bdata-mce-type\s*=\s*(["\'])bookmark\1[^>]*>(?:.*?<\/span>|)/is', '', $value);
    }
    return $value;
}

// Register ACF fields for Product Medical Disclaimers
add_action('acf/init', 'aad_register_product_disclaimer_fields');
function aad_register_product_disclaimer_fields() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_product_disclaimers',
        'title' => 'Product Medical Disclaimers',
        'fields' => array(
            array(
                'key' => 'field_usage_title',
                'label' => 'Important Usage Note Title',
                'name' => 'usage_note_title',
                'type' => 'text',
                'default_value' => 'Important Usage Note',
            ),
            array(
                'key' => 'field_usage_text',
                'label' => 'Important Usage Note Text',
                'name' => 'usage_note_text',
                'type' => 'textarea',
                'instructions' => 'Use {product_name} to dynamically insert the current product title.',
                'default_value' => '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener">Therapeutic Goods Administration (TGA)</a>.',
                'new_lines' => 'br',
            ),
            array(
                'key' => 'field_info_text',
                'label' => 'Informational Warning Text',
                'name' => 'informational_warning_text',
                'type' => 'textarea',
                'default_value' => 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer/">Read our full medical disclaimer</a>.',
                'new_lines' => 'br',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'theme-general-settings',
                ),
            ),
        ),
    ));

    endif;
}






// Hide default wishlist buttons on single product pages because we use a custom inline button
add_action('wp_head', function() {
    if (is_product()) {
        echo '<style>.single-product .yith-wcwl-add-to-wishlist, .single-product .tinv-wraper, .single-product .tinv-wishlist { display: none !important; }</style>';
    }
});




// AIOSEO Writing Assistant's watchClassicEditor() crashes on ACF's dynamically-
// created TinyMCE instances with "Cannot read properties of null (reading 'on')".
// This prevents every Visual editor tab from initialising properly.
// Dequeue the script; the SEO meta-box itself still works without it.
add_action('admin_enqueue_scripts', function($hook) {
    // If we are on the individual category edit screen (term.php), AIOSEO often crashes
    // because WordPress doesn't load TinyMCE by default on this screen, but AIOSEO expects it.
    // We force load it here so the AIOSEO Vue app doesn't fatally error and go blank.
    if ( $hook === 'term.php' ) {
        wp_enqueue_editor();
        return;
    }

    // Only dequeue on edit-tags.php (the category list screen where AJAX add crashes happen).
    if ( $hook !== 'edit-tags.php' ) return;

    // Attempt all known handles for the AIOSEO writing assistant to prevent TinyMCE crashes
    $handles = [
        'aioseo/js/src/vue/standalone/writing-assistant/main.js',
        'aioseoWritingAssistant',
        'aioseo-writing-assistant',
        'aioseo-src-vue-standalone-writing-assistant-main'
    ];
    foreach ($handles as $handle) {
        wp_dequeue_script($handle);
        wp_deregister_script($handle);
    }
}, 9999);

// Editor colours and typography are provided safely by editor-style.css.
// Do not inject quoted CSS through tiny_mce_before_init: WordPress prints that
// value inside an inline JavaScript string, where unescaped font-family quotes
// can prevent tinyMCEPreInit from being created and break every Visual editor.
add_filter('tiny_mce_before_init', function($init) {
    $readable_editor_style = 'body#tinymce,body.mce-content-body{color:#334155!important;background:#fff!important;}body#tinymce p,body#tinymce div,body#tinymce span,body#tinymce li,body#tinymce td,body#tinymce strong,body#tinymce em,body.mce-content-body p,body.mce-content-body div,body.mce-content-body span,body.mce-content-body li,body.mce-content-body td,body.mce-content-body strong,body.mce-content-body em{color:#334155!important;}body#tinymce h1,body#tinymce h2,body#tinymce h3,body#tinymce h4,body#tinymce h5,body#tinymce h6,body.mce-content-body h1,body.mce-content-body h2,body.mce-content-body h3,body.mce-content-body h4,body.mce-content-body h5,body.mce-content-body h6{color:#09152b!important;}body#tinymce a,body.mce-content-body a{color:#0f766e!important;}';
    $init['content_style'] = !empty($init['content_style'])
        ? $init['content_style'] . ' ' . $readable_editor_style
        : $readable_editor_style;
    return $init;
}, 20);

// InstaWP/browser caches can retain TinyMCE's iframe stylesheet even when the
// surrounding admin page is refreshed. Inject the readability rules into each
// editor document after TinyMCE initialises so they never depend on a cached
// external CSS response. This only affects the editing view; it is not saved
// into post or ACF content.
add_action('admin_print_footer_scripts', function() {
    $screen = function_exists('get_current_screen') ? get_current_screen() : null;
    if (!$screen || !in_array($screen->base, ['post', 'term'], true)) {
        return;
    }
    ?>
    <script id="aad-tinymce-readable-content">
    (function () {
        var css = [
            'html body.mce-content-body{color:#334155!important;background:#fff!important;}',
            'html body.mce-content-body p,html body.mce-content-body div,html body.mce-content-body span,html body.mce-content-body li,html body.mce-content-body td,html body.mce-content-body strong,html body.mce-content-body em{color:#334155!important;}',
            'html body.mce-content-body h1,html body.mce-content-body h2,html body.mce-content-body h3,html body.mce-content-body h4,html body.mce-content-body h5,html body.mce-content-body h6{color:#09152b!important;}',
            'html body.mce-content-body a{color:#0f766e!important;}',
            'html body.mce-content-body th{color:#fff!important;}'
        ].join('');

        function applyReadableStyle(editor) {
            if (!editor || !editor.getDoc) {
                return;
            }

            try {
                var doc = editor.getDoc();
            if (!doc || !doc.head || doc.getElementById('aad-tinymce-readable-style')) {
                return;
            }

            var style = doc.createElement('style');
                style.id = 'aad-tinymce-readable-style';
                style.textContent = css;
                doc.head.appendChild(style);
            } catch (e) {
                // Ignore iframe access errors
            }
        }

        function watchEditor(editor) {
            if (!editor || !editor.on) {
                return;
            }
            editor.on('init', function () {
                applyReadableStyle(editor);
            });
            if (editor.initialized) {
                applyReadableStyle(editor);
            }
        }

        function connect() {
            if (!window.tinymce || !window.tinymce.on) {
                window.setTimeout(connect, 50);
                return;
            }

            window.tinymce.on('AddEditor', function (event) {
                watchEditor(event.editor);
            });

            (window.tinymce.editors || []).forEach(watchEditor);
        }

        connect();
    }());
    </script>
    <?php
}, 100);





// Remove coupon form from checkout page
remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 );


// Make phone field mandatory on checkout



// Auto-select Priority Shipping by sorting it to the top
add_filter( 'woocommerce_package_rates', 'sort_shipping_methods_priority_first', 10, 2 );
function sort_shipping_methods_priority_first( $rates, $package ) {
    if ( ! $rates ) return $rates;
    $priority_rate = null;
    $other_rates = array();
    foreach ( $rates as $rate_id => $rate ) {
        if ( stripos( $rate->label, 'priority' ) !== false ) {
            $priority_rate = array( $rate_id => $rate );
        } else {
            $other_rates[ $rate_id ] = $rate;
        }
    }
    if ( $priority_rate ) {
        return $priority_rate + $other_rates;
    }
    return $rates;
}


add_filter( 'woocommerce_billing_fields', function( $fields ) {
    if ( isset($fields['billing_phone']) ) {
        $fields['billing_phone']['required'] = true;
    }
    return $fields;
}, 9999 );


// Fix Duplicate "Shipping Insurance (Shipping Insurance)" Fee Name
add_filter( 'gettext', function( $translated_text, $text, $domain ) {
    if ( 'shipping-insurance-manager' === $domain && 'Shipping Insurance (%s)' === $text ) {
        return '%s';
    }
    return $translated_text;
}, 10, 3 );

// Ultra-aggressive Phone Required Enforcement
add_filter( 'woocommerce_checkout_fields', function( $fields ) {
    if ( isset($fields['billing']['billing_phone']) ) {
        $fields['billing']['billing_phone']['required'] = true;
    }
    return $fields;
}, 99999 );
add_filter( 'woocommerce_billing_fields', function( $fields ) {
    if ( isset($fields['billing_phone']) ) {
        $fields['billing_phone']['required'] = true;
    }
    return $fields;
}, 99999 );
add_filter( 'woocommerce_form_field_args', function( $args, $key, $value ) {
    if ( $key === 'billing_phone' ) {
        $args['required'] = true;
    }
    return $args;
}, 99999, 3 );
add_action( 'woocommerce_checkout_process', function() {
    if ( empty( $_POST['billing_phone'] ) ) {
        wc_add_notice( __( 'Phone number is a required field.', 'woocommerce' ), 'error' );
    }
} );

// Aggressive Visual Fixes for Phone Optional and Double Insurance Text
add_action( 'wp_head', function() {
    if ( is_checkout() || is_cart() ) {
        echo '<style>
        /* Hide the duplicate h2 title in the WooCommerce Block for Shipping Insurance */
        .wc-block-components-shipping-rates-control h2.wc-block-components-title {
            display: none !important;
        }
        /* Hide the duplicate TH title in the standard WooCommerce layout for Shipping Insurance */
        .shipping-insurance th {
            display: none !important;
        }
        .shipping-insurance {
            display: block !important;
            padding-top: 0.25rem !important;
        }
        .shipping-insurance td {
            display: flex !important;
            flex-direction: column !important;
            gap: 0.375rem !important;
            color: #4b5563 !important;
            font-size: 0.875rem !important;
        }
        .shipping-insurance td br {
            display: none !important;
        }
        
        /* Visually force Phone to look required (Hide "optional", add red asterisk) */
        label[for="billing_phone"] .optional {
            display: none !important;
        }
        label[for="billing_phone"]::after {
            content: " *" !important;
            color: #e24c4b !important; /* Theme red or standard red */
        }
        </style>';
    }
} );

// Force Phone label to remove (optional) via JS for React Blocks
add_action( 'wp_footer', function() {
    if ( is_checkout() || is_cart() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to strip (optional) and add *
            function fixPhoneLabel() {
                var labels = document.querySelectorAll('label');
                labels.forEach(function(label) {
                    if (label.innerText.toLowerCase().includes('phone (optional)')) {
                        label.innerHTML = label.innerHTML.replace(/\(optional\)/i, '<span style="color:#e24c4b;">*</span>');
                    }
                });
                
                var inputs = document.querySelectorAll('input[type="tel"], input[name="billing_phone"]');
                inputs.forEach(function(input) {
                    input.required = true;
                });
            }
            
            fixPhoneLabel();
            
            // Re-run on DOM mutations because WooCommerce Blocks render via React!
            var observer = new MutationObserver(function(mutations) {
                fixPhoneLabel();
            });
            observer.observe(document.body, { childList: true, subtree: true });
        });
        </script>
        <?php
    }
} );

// Tidy up Shipping Insurance Layout by buffering and rewriting the HTML
add_action( 'woocommerce_review_order_before_order_total', function() { ob_start(); }, -9999 ); add_action( 'woocommerce_review_order_before_order_total', function() { $html = ob_get_clean(); if ( $html ) { $td_start = strpos($html, '<td'); $td_end = strrpos($html, '</td>'); if ($td_start !== false && $td_end !== false) { $td_start = strpos($html, '>', $td_start) + 1; $inner_content = substr($html, $td_start, $td_end - $td_start); $inner_content = str_replace('</label><br>', '</label>', $inner_content); $inner_content = preg_replace('/<\/label>\s*<br>/', '</label>', $inner_content); $html = '<div class="shipping-insurance-wrapper mt-4 pt-4 border-t border-ink-200"><div class="flex flex-col gap-1.5 text-sm text-ink-600">' . $inner_content . '</div></div>'; $selected_package = WC()->session ? WC()->session->get( 'shipping_insurance_package' ) : ''; if ( $selected_package === 'NO_INSURANCE' ) { $html = preg_replace( '/name="shipping_insurance_package"\s*value=""/is', 'name="shipping_insurance_package" value="NO_INSURANCE" checked="checked"', $html ); } else { $html = preg_replace( '/name="shipping_insurance_package"\s*value=""/is', 'name="shipping_insurance_package" value="NO_INSURANCE"', $html ); } } echo $html; } }, 9999 );







// Absolute Click Interceptor for Media Uploader to prevent full-page navigation
add_action('admin_print_footer_scripts', function() {
    ?>
    <script>
    jQuery(document).ready(function($) {
        // We use event delegation on document so it always fires, even after AJAX
        $(document).on('click', '#set-post-thumbnail, .add_product_images a', function(e) {
            // ALWAYS prevent the default navigation (which causes the full-page legacy uploader)
            e.preventDefault();
            
            var $el = $(this);
            var url = $el.attr('href');
            
            // Attempt 1: Modern wp.media popup
            try {
                if (typeof wp !== 'undefined' && wp.media) {
                    if ($el.attr('id') === 'set-post-thumbnail' && wp.media.featuredImage) {
                        var frame = wp.media.featuredImage.get();
                        if (!frame) {
                            wp.media.featuredImage.init();
                            frame = wp.media.featuredImage.get();
                        }
                        if (frame) {
                            frame.open();
                            return; // Success
                        }
                    } else if (typeof product_gallery_frame !== 'undefined') {
                        product_gallery_frame.open();
                        return; // Success
                    }
                }
            } catch (err) {
                console.error("wp.media failed, falling back to thickbox: ", err);
            }
            
            // Attempt 2: ThickBox popup (Legacy WordPress overlay)
            // If we reached here, wp.media crashed or wasn't available.
            // Rather than letting the browser navigate away, we force the ThickBox modal.
            if (typeof tb_show === 'function') {
                tb_show('Select Image', url);
            } else {
                // Absolute worst case: open in a new popup window so they don't lose their post edits
                window.open(url, 'WP_Media', 'width=800,height=600,resizable=yes,scrollbars=yes');
            }
        });
    });
    </script>
    <?php
}, 9999);

// INVINCIBLE Underscore.js Polyfill for WP Admin (With Chaining & thisArg Support)
// Fixes Lodash 4+ incompatibilities where 'thisArg' was removed from iterators (causing "reading 'type'" errors)
add_action('admin_print_scripts', function() {
    ?>
    <script>
    (function() {
        function applyPolyfill(underscoreObj) {
            if (!underscoreObj) return;
            
            var mixins = {};
            
            // 1. Missing Methods Polyfills
            if (typeof underscoreObj.pluck === 'undefined') {
                mixins.pluck = function(obj, key) { return underscoreObj.map(obj, underscoreObj.property(key)); };
            }
            if (typeof underscoreObj.contains === 'undefined') {
                mixins.contains = underscoreObj.includes || function(obj, item) { return underscoreObj.indexOf(obj, item) >= 0; };
            }
            if (typeof underscoreObj.object === 'undefined') {
                mixins.object = function(keys, vals) {
                    var result = {};
                    for (var i = 0, l = keys.length; i < l; i++) {
                        if (vals) result[keys[i]] = vals[i];
                        else result[keys[i][0]] = keys[i][1];
                    }
                    return result;
                };
            }
            if (typeof underscoreObj.any === 'undefined' && typeof underscoreObj.some !== 'undefined') {
                mixins.any = underscoreObj.some;
            }
            if (typeof underscoreObj.all === 'undefined' && typeof underscoreObj.every !== 'undefined') {
                mixins.all = underscoreObj.every;
            }
            if (typeof underscoreObj.invoke === 'undefined') {
                mixins.invoke = function(obj, method) {
                    var args = Array.prototype.slice.call(arguments, 2);
                    var isFunc = typeof method === 'function';
                    return underscoreObj.map(obj, function(value) {
                        var func = isFunc ? method : value[method];
                        return func == null ? func : func.apply(value, args);
                    });
                };
            }
            if (typeof underscoreObj.first === 'undefined' && typeof underscoreObj.head !== 'undefined') {
                mixins.first = underscoreObj.head;
            }
            if (typeof underscoreObj.findWhere === 'undefined') {
                mixins.findWhere = function(obj, attrs) {
                    return underscoreObj.find(obj, (underscoreObj.matcher || underscoreObj.matches)(attrs));
                };
            }
            if (typeof underscoreObj.where === 'undefined') {
                mixins.where = function(obj, attrs) {
                    return underscoreObj.filter(obj, (underscoreObj.matcher || underscoreObj.matches)(attrs));
                };
            }

            // 2. Wrap Iterators to support `thisArg` (Context) which Lodash 4 removed!
            // WP Core extensively uses _.map(arr, fn, this), which crashes if `this` is ignored.
            var iterators = ['map', 'each', 'forEach', 'filter', 'reject', 'every', 'some', 'any', 'all', 'find'];
            for (var i = 0; i < iterators.length; i++) {
                var methodName = iterators[i];
                var originalMethod = underscoreObj[methodName];
                
                // Only wrap if the original method exists and we haven't wrapped it yet
                if (originalMethod && !originalMethod._isAadWrapped) {
                    (function(name, orig) {
                        mixins[name] = function(collection, callback, thisArg) {
                            // If a thisArg is provided, bind the callback to it!
                            if (typeof thisArg !== 'undefined' && typeof callback === 'function') {
                                callback = callback.bind(thisArg);
                            }
                            return orig.call(underscoreObj, collection, callback);
                        };
                        mixins[name]._isAadWrapped = true;
                    })(methodName, originalMethod);
                }
            }

            // Apply all mixins
            if (Object.keys(mixins).length > 0) {
                if (typeof underscoreObj.mixin === 'function') {
                    underscoreObj.mixin(mixins);
                } else {
                    for (var key in mixins) {
                        underscoreObj[key] = mixins[key];
                    }
                }
            }
        }

        if (typeof window._ !== 'undefined') {
            applyPolyfill(window._);
        }

        var originalUnderscore = window._;
        Object.defineProperty(window, '_', {
            configurable: true,
            enumerable: true,
            get: function() {
                return originalUnderscore;
            },
            set: function(newValue) {
                originalUnderscore = newValue;
                applyPolyfill(originalUnderscore);
            }
        });

        var interval = setInterval(function() {
            if (typeof window._ !== 'undefined') applyPolyfill(window._);
        }, 50);
        setTimeout(function() { clearInterval(interval); }, 5000);
    })();
    </script>
    <?php
}, -9999);

// FORCE CLEAN AJAX RESPONSES
// This prevents ANY stray whitespace from plugins or config files from corrupting XML AJAX responses (like adding categories).
add_action('admin_init', function() {
    if ( defined('DOING_AJAX') && DOING_AJAX ) {
        $cleaner = function() {
            while (ob_get_level() > 0) {
                ob_end_clean();
            }
        };
        add_action('wp_ajax_add-meta', $cleaner, -9999);
        add_action('wp_ajax_add-category', $cleaner, -9999);
        add_action('wp_ajax_add-tag', $cleaner, -9999);
    }
});



// Smart ACF Excerpt Generator
add_filter('get_the_excerpt', function($excerpt, $post) {
    // 1. If user typed a manual excerpt, respect it, BUT still strip 1. Introduction in case AIOSEO auto-filled it
    if ( has_excerpt($post->ID) ) {
        $excerpt = preg_replace('/1\.[^a-z]*Introduction[^a-z]*/i', '', $excerpt);
        // We still return early so we don't overwrite manual excerpts with ACF intro
        return trim($excerpt);
    }
    
    // 2. Try to pull from ACF page_modules if it exists
    $modules = get_field('page_modules', $post->ID);
    if ( ! empty($modules) && is_array($modules) ) {
        foreach ( $modules as $module ) {
            // If they use Policy Page (TOC), use its 'intro' field
            if ( $module['acf_fc_layout'] === 'policy_page' && ! empty($module['intro']) ) {
                return wp_strip_all_tags($module['intro']);
            }
            // If they use standard text layout, we could pull from it, but let's stick to intro for now
        }
    }

    // 3. Fallback: Super aggressive strip of '1. Introduction' 
    $excerpt = wp_strip_all_tags($excerpt);
    $excerpt = html_entity_decode($excerpt);
    $excerpt = preg_replace('/1\.[^a-z]*Introduction[^a-z]*/i', '', $excerpt);
    $excerpt = trim($excerpt);
    return $excerpt;
}, 99, 2);


// Override AIOSEO Title for WooCommerce Categories (Bypass Free Version Restriction)
add_filter( 'aioseo_title', function( $title ) {
    if ( is_product_category() ) {
        $custom_title = get_field('custom_seo_title', get_queried_object());
        if ( ! empty($custom_title) ) {
            return wp_strip_all_tags($custom_title);
        }
    }
    return $title;
});

// Override AIOSEO Description for WooCommerce Categories (Bypass Free Version Restriction)
add_filter( 'aioseo_description', function( $description ) {
    if ( is_product_category() ) {
        $custom_desc = get_field('custom_seo_description', get_queried_object());
        if ( ! empty($custom_desc) ) {
            return wp_strip_all_tags($custom_desc);
        }
    }
    return $description;
});


// Hook Shipping Insurance onto Cart page as well
add_action( 'woocommerce_cart_totals_before_order_total', function() {
    if ( class_exists('Shipping_Insurance_Manager_Public') ) {
        $plugin_public = new Shipping_Insurance_Manager_Public( 'shipping-insurance-manager', '1.0.0' );
        $plugin_public->add_shipping_insurance_checkbox();
    }
} );

// Tidy up HTML for Cart page too
add_action( 'woocommerce_cart_totals_before_order_total', function() {
    ob_start();
}, -9999 );

add_action( 'woocommerce_cart_totals_before_order_total', function() {
    $html = ob_get_clean();
    if ( $html ) {
        // Rewrite the table structure to span both columns and maintain valid DOM
        $html = str_replace( '<tr class="shipping-insurance">', '<tr class="shipping-insurance"><td colspan="2" class="!p-0 !border-0 pb-2">', $html );
        // Remove the original TH
        $html = preg_replace( '/<th>.*?<\/th>/is', '', $html );
        // Replace TD with a flex div for vertical stacking
        $html = str_replace( '<td>', '<div class="flex flex-col gap-1.5 text-sm text-ink-600 mt-2">', $html );
        // Close the flex div and the TD
        $html = str_replace( '</td>', '</div></td>', $html );
        // Remove rogue BR tags between labels
        $html = preg_replace( '/<\/label>\s*<br>/', '</label>', $html );
        
        // [NO INSURANCE BUG FIX] Intercept the plugin's empty value and use a NO_INSURANCE sentinel
        $selected_package = WC()->session ? WC()->session->get( 'shipping_insurance_package' ) : '';
        if ( $selected_package === 'NO_INSURANCE' ) {
            $html = str_replace( 'value=""', 'value="NO_INSURANCE" checked="checked"', $html );
        } else {
            $html = str_replace( 'value=""', 'value="NO_INSURANCE"', $html );
        }
        echo $html;
    }
}, 9999 );

// AJAX Endpoint to save insurance selection immediately
add_action('wp_ajax_set_shipping_insurance', 'ajax_set_shipping_insurance');
add_action('wp_ajax_nopriv_set_shipping_insurance', 'ajax_set_shipping_insurance');
function ajax_set_shipping_insurance() {
    if ( isset($_POST['package']) ) {
        WC()->session->set('shipping_insurance_package', sanitize_text_field($_POST['package']));
        WC()->cart->calculate_totals();
    }
    wp_send_json_success();
}

// Add JavaScript to trigger the AJAX update on change
add_action('wp_footer', function() {
    if ( is_cart() || is_checkout() ) {
        ?>
        <script>
        jQuery(document).ready(function($) {
            $(document).on('change', 'input.shipping-insurance-radio', function() {
                var selectedPackage = $(this).val();
                
                if ( $('form.checkout').length ) {
                    // On checkout page, WooCommerce natively handles form serialization and updating
                    $('body').trigger('update_checkout');
                } else {
                    // Block the cart UI while updating
                    if ( $('div.cart_totals').length ) {
                        $('div.cart_totals').addClass('processing').block({
                            message: null,
                            overlayCSS: { background: '#fff', opacity: 0.6 }
                        });
                    }
                    
                    // On cart page, we need custom AJAX
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo admin_url('admin-ajax.php'); ?>',
                        data: {
                            action: 'set_shipping_insurance',
                            package: selectedPackage
                        },
                        success: function() {
                            $('button[name="update_cart"]').prop('disabled', false).trigger('click');
                            $('body').trigger('wc_update_cart');
                        },
                        error: function() {
                            // Unblock if it fails
                            $('div.cart_totals').removeClass('processing').unblock();
                        }
                    });
                }
            });
        });
        </script>
        <?php
    }
});
// [AUTO-CLEANUP] Remove all broken shipping insurance plugins
add_action('admin_init', function() {
    if ( isset($_GET['clean_insurance_plugins']) ) {
        $plugins_dir = WP_PLUGIN_DIR . '/';
        $folders_to_delete = glob($plugins_dir . '*shipping-insurance*');
        $deleted = [];
        foreach ($folders_to_delete as $folder) {
            if (is_dir($folder)) {
                // Delete recursively
                $files = new RecursiveIteratorIterator(
                    new RecursiveDirectoryIterator($folder, RecursiveDirectoryIterator::SKIP_DOTS),
                    RecursiveIteratorIterator::CHILD_FIRST
                );
                foreach ($files as $fileinfo) {
                    $todo = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
                    @$todo($fileinfo->getRealPath());
                }
                @rmdir($folder);
                $deleted[] = basename($folder);
            }
        }
        die('Cleaned up folders: ' . implode(', ', $deleted) . '. <br><a href="' . admin_url('plugins.php') . '">Go back to Plugins</a>');
    }
});
add_action( 'woocommerce_cart_totals_before_order_total', function() { ob_start(); }, -9999 );
add_action( 'woocommerce_cart_totals_before_order_total', function() { $html = ob_get_clean(); if ( $html ) { $td_start = strpos($html, '<td'); $td_end = strrpos($html, '</td>'); if ($td_start !== false && $td_end !== false) { $td_start = strpos($html, '>', $td_start) + 1; $inner_content = substr($html, $td_start, $td_end - $td_start); $inner_content = str_replace('</label><br>', '</label>', $inner_content); $inner_content = preg_replace('/<\/label>\s*<br>/', '</label>', $inner_content); $html = '<div class="shipping-insurance-wrapper mt-4 pt-4 border-t border-ink-200"><div class="flex flex-col gap-1.5 text-sm text-ink-600">' . $inner_content . '</div></div>'; $selected_package = WC()->session ? WC()->session->get( 'shipping_insurance_package' ) : ''; if ( $selected_package === 'NO_INSURANCE' ) { $html = preg_replace( '/name="shipping_insurance_package"\s*value=""/is', 'name="shipping_insurance_package" value="NO_INSURANCE" checked="checked"', $html ); } else { $html = preg_replace( '/name="shipping_insurance_package"\s*value=""/is', 'name="shipping_insurance_package" value="NO_INSURANCE"', $html ); } } echo $html; } }, 9999 );


// [SHIPPING INSURANCE FIX] Correctly apply default insurance session on first load
add_action('woocommerce_cart_calculate_fees', 'force_shipping_insurance_default', 1);
function force_shipping_insurance_default($cart) {
    if ( ! WC()->session ) return;
    $selected = WC()->session->get('shipping_insurance_package', 'NOT_SET');
    if ($selected === 'NOT_SET' || $selected === '') {
        $default_option = get_option('shipping_insurance_default_option', 'no_insurance');
        
        if ( in_array( $default_option, array( 'most_expensive', 'least_expensive' ), true ) ) {
            $packages = get_option( 'shipping_insurance_packages', array() );
            $default_index = '';
            $default_fee   = null;
            $cart_total = 0;
            // Get subtotal
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                $cart_total += $cart_item['line_total'];
            }
            
            foreach ( $packages as $index => $package ) {
                if ( isset( $package['enabled'] ) && 'yes' === $package['enabled'] ) {
                    $fee = 0;
                    if ( 'fixed' === $package['type'] ) { 
                        $fee = floatval($package['amount']); 
                    } elseif ( 'percentage' === $package['type'] ) { 
                        $fee = (floatval($package['amount']) / 100) * $cart_total; 
                    }
                    if ( 'most_expensive' === $default_option ) {
                        if ( is_null($default_fee) || $fee > $default_fee ) { 
                            $default_fee = $fee; $default_index = $index; 
                        }
                    } else {
                        if ( is_null($default_fee) || $fee < $default_fee ) { 
                            $default_fee = $fee; $default_index = $index; 
                        }
                    }
                }
            }
            if ($default_index !== '') {
                WC()->session->set('shipping_insurance_package', $default_index);
            } else {
                WC()->session->set('shipping_insurance_package', 'NO_INSURANCE');
            }
        } else {
            WC()->session->set('shipping_insurance_package', 'NO_INSURANCE');
        }
    }
}

// [AUTO-INJECT] Add specific JSON-LD Schema for Waklert 150mg
add_action('wp_head', function() {
    if ( function_exists('is_product') && is_product() && get_post_field('post_name', get_post()) === 'waklert-150mg' ) {
        ?>
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@graph": [
            {
              "@type": "Product",
              "@id": "https://armodafinildirect.com.au/product/waklert-150mg/#product",
              "name": "Waklert 150mg (Armodafinil)",
              "image": [
                "https://armodafinildirect.com.au/wp-content/uploads/waklert-150mg.jpg"
              ],
              "description": "Buy Waklert 150mg online in Australia for clean, long-lasting mental focus without the jitters. Formulated with pure Armodafinil by Sun Pharma.",
              "sku": "WAK-150",
              "brand": {
                "@type": "Brand",
                "name": "Sun Pharma"
              },
              "offers": {
                "@type": "AggregateOffer",
                "url": "https://armodafinildirect.com.au/product/waklert-150mg/",
                "priceCurrency": "AUD",
                "lowPrice": "150.00",
                "highPrice": "1180.00",
                "offerCount": "7",
                "priceValidUntil": "2027-12-31",
                "itemCondition": "https://schema.org/NewCondition",
                "availability": "https://schema.org/InStock",
                "seller": {
                  "@type": "Organization",
                  "name": "Armodafinil Direct"
                },
                "shippingDetails": {
                  "@type": "OfferShippingDetails",
                  "shippingRate": {
                    "@type": "MonetaryAmount",
                    "value": "0.00",
                    "currency": "AUD"
                  },
                  "shippingDestination": {
                    "@type": "DefinedRegion",
                    "addressCountry": "AU"
                  },
                  "deliveryTime": {
                    "@type": "ShippingDeliveryTime",
                    "handlingTime": {
                      "@type": "QuantitativeValue",
                      "minValue": 1,
                      "maxValue": 2,
                      "unitCode": "DAY"
                    },
                    "transitTime": {
                      "@type": "QuantitativeValue",
                      "minValue": 7,
                      "maxValue": 10,
                      "unitCode": "DAY"
                    }
                  }
                },
                "hasMerchantReturnPolicy": {
                  "@type": "MerchantReturnPolicy",
                  "applicableCountry": "AU",
                  "returnPolicyCategory": "https://schema.org/MerchantReturnFiniteReturnWindow",
                  "merchantReturnDays": 30,
                  "returnMethod": "https://schema.org/ReturnByMail",
                  "returnFees": "https://schema.org/FreeReturn"
                }
              },
              "aggregateRating": {
                "@type": "AggregateRating",
                "ratingValue": "4.7",
                "reviewCount": "10",
                "bestRating": "5",
                "worstRating": "1"
              },
              "review": [
                {
                  "@type": "Review",
                  "author": {
                    "@type": "Person",
                    "name": "Lucy D."
                  },
                  "datePublished": "2026-09-23",
                  "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                  },
                  "reviewBody": "Clean focus, no heart palpitations like caffeine gives me."
                },
                {
                  "@type": "Review",
                  "author": {
                    "@type": "Person",
                    "name": "Craig L."
                  },
                  "datePublished": "2026-08-20",
                  "reviewRating": {
                    "@type": "Rating",
                    "ratingValue": "5",
                    "bestRating": "5"
                  },
                  "reviewBody": "Much cleaner than pre-workouts or double-shot coffees. Keeps you locked in for hours without the afternoon slump at 3pm."
                }
              ]
            },
            {
              "@type": "FAQPage",
              "@id": "https://armodafinildirect.com.au/product/waklert-150mg/#faq",
              "mainEntity": [
                {
                  "@type": "Question",
                  "name": "Do I need a prescription to buy Waklert online in Australia?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Under the TGA Personal Importation Scheme, Australian residents can legally order up to a 3-month supply of prescription medicine from overseas for personal use without needing to upload a local prescription at checkout."
                  }
                },
                {
                  "@type": "Question",
                  "name": "How does Waklert 150mg feel compared to Modafinil 200mg?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Waklert uses pure Armodafinil (the longer-acting half of Modafinil). Most users notice a smoother, cleaner wave of focus that lasts 12 to 15 hours without the sharp mid-day peak or jittery crash sometimes felt with standard 200mg Modafinil."
                  }
                },
                {
                  "@type": "Question",
                  "name": "Will Waklert keep me awake at night?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "It can if you take it too late. Because Armodafinil stays active for up to 15 hours, take your dose early in the morning (ideally before 7:30 AM) or roughly 60 minutes before starting a night shift so it wears off naturally before you bed down."
                  }
                },
                {
                  "@type": "Question",
                  "name": "Can I split a Waklert tablet in half?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Yes. Every Sun Pharma Waklert 150mg tablet has a center score line down the middle, so you can easily break it into two 75mg halves for lighter work days or lower tolerance."
                  }
                },
                {
                  "@type": "Question",
                  "name": "How are orders packaged and delivered?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Orders are packed in plain, tough satchels with no product descriptions, logos, or pharmacy labels on the outside. We ship express via Australia Post with full tracking to your door or PO Box."
                  }
                },
                {
                  "@type": "Question",
                  "name": "What payment methods do you accept?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "We accept PayID and direct Australian bank transfers (EFT). Everything is billed in AUD, so you won't hit foreign exchange fees or international card surcharges."
                  }
                },
                {
                  "@type": "Question",
                  "name": "What happens if my delivery gets lost or delayed?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "If your order gets lost in the post or held up in transit, we send out a free reshipment—guaranteed."
                  }
                },
                {
                  "@type": "Question",
                  "name": "How should I store Waklert in hot Australian weather?",
                  "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Keep your blister strips in a cool, dry place like a pantry or drawer below 25°C. Keep them out of direct sunlight and hot cars to protect the active ingredients during summer."
                  }
                }
              ]
            }
          ]
        }
        </script>
        <?php
    }
});

// [AUTO-INJECT] Sync WooCommerce Email Header Image with Site Logo
add_filter('option_woocommerce_email_header_image_url', function($value) {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ( $custom_logo_id ) {
        $logo_url = wp_get_attachment_image_url($custom_logo_id, 'full');
        if ( $logo_url ) {
            return $logo_url;
        }
    }
    // Fallback to theme assets logo if no custom logo is set
    return get_template_directory_uri() . '/assets/logo.png';
});

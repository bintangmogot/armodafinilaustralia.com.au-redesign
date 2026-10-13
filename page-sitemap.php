<?php
/**
 * Template Name: HTML Sitemap
 */

get_header();

// Fetch all pages and categorize them
$all_pages = get_pages();
$legal_keywords = ['privacy', 'terms', 'conditions', 'policy', 'refund', 'shipping', 'disclaimer'];
$support_keywords = ['contact', 'faq', 'support', 'help', 'track', 'about'];

$exclude_keywords = ['dr. hamish', 'my account', 'wishlist'];
$legal_pages = [];
$support_pages = [];
$main_pages = [];

foreach ($all_pages as $p) {
    $title = strtolower($p->post_title);
    // Skip unwanted pages
    $skip = false;
    foreach ($exclude_keywords as $ex) {
        if (strpos($title, $ex) !== false) {
            $skip = true; break;
        }
    }
    if ($skip) continue;

    $is_legal = false;
    $is_support = false;
    
    foreach ($legal_keywords as $kw) {
        if (strpos($title, $kw) !== false) {
            $is_legal = true; break;
        }
    }
    if (!$is_legal) {
        foreach ($support_keywords as $kw) {
            if (strpos($title, $kw) !== false) {
                $is_support = true; break;
            }
        }
    }
    
    if ($is_legal) {
        $legal_pages[] = $p;
    } elseif ($is_support) {
        $support_pages[] = $p;
    } else {
        $main_pages[] = $p;
    }
}
?>

<style>
.sitemap-list ul { list-style: none; padding: 0; margin: 0; }
.sitemap-list li { margin-bottom: 0.85rem; }
.sitemap-list a { 
    color: #475569; 
    text-decoration: none; 
    transition: all 0.2s ease-in-out; 
    font-weight: 500; 
    display: inline-block; 
}
.sitemap-list a:hover { 
    color: #00B67A; 
    text-decoration: underline; 
    text-underline-offset: 4px; 
    transform: translateX(4px); 
}
.sitemap-list h2 {
    border-bottom: 1px solid #E2E8F0;
    padding-bottom: 0.75rem;
    margin-bottom: 1.5rem;
    font-weight: 600;
    color: #0F172A;
    font-size: 1.125rem;
}
</style>

<div class="bg-ink-50 py-16 md:py-24 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="font-serif text-4xl md:text-5xl font-semibold text-ink-900 mb-10 text-center">Site Map</h1>
        
        <div class="bg-white border border-ink-200 rounded-2xl p-8 md:p-12 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 sitemap-list">
                <?php if ( have_rows('sitemap_columns') ) : ?>
                    <?php while ( have_rows('sitemap_columns') ) : the_row(); ?>
                        <div>
                            <h2><?php echo esc_html(get_sub_field('column_title')); ?></h2>
                            <ul>
                                <?php if ( have_rows('links') ) : ?>
                                    <?php while ( have_rows('links') ) : the_row(); 
                                        $link = get_sub_field('link');
                                        if ( $link ) :
                                            $link_url = $link['url'];
                                            $link_title = $link['title'];
                                            $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                        <li><a href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a></li>
                                    <?php endif; endwhile; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                <!-- Main Pages -->
                <div>
                    <h2>Main Pages</h2>
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/shop">Shop</a></li>
                        <?php foreach($main_pages as $p): 
                            // Skip if it's the sitemap itself or front page
                            if ($p->ID == get_option('page_on_front') || strpos(strtolower($p->post_title), 'sitemap') !== false) continue;
                        ?>
                            <li><a href="<?php echo get_permalink($p->ID); ?>"><?php echo esc_html($p->post_title); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <!-- Shop Categories -->
                <div>
                    <h2>Shop Categories</h2>
                    <ul>
                        <?php
                        wp_list_categories(array(
                            'taxonomy' => 'product_cat',
                            'title_li' => '',
                            'hide_empty' => false,
                            'depth' => 1,
                        ));
                        ?>
                    </ul>
                </div>

                <!-- Support & Help -->
                <div>
                    <h2>Help & Support</h2>
                    <ul>
                        <?php if(empty($support_pages)): ?>
                            <li><a href="/contact">Contact Us</a></li>
                            <li><a href="/faq">FAQ</a></li>
                            <li><a href="/about">About Us</a></li>
                        <?php else: ?>
                            <?php foreach($support_pages as $p): ?>
                                <li><a href="<?php echo get_permalink($p->ID); ?>"><?php echo esc_html($p->post_title); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- Legal & Policies -->
                <div>
                    <h2>Legal & Policies</h2>
                    <ul>
                        <?php if(empty($legal_pages)): ?>
                            <li><a href="/privacy-policy">Privacy Policy</a></li>
                            <li><a href="/terms-and-conditions">Terms & Conditions</a></li>
                            <li><a href="/refund-policy">Refund Policy</a></li>
                        <?php else: ?>
                            <?php foreach($legal_pages as $p): ?>
                                <li><a href="<?php echo get_permalink($p->ID); ?>"><?php echo esc_html($p->post_title); ?></a></li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </ul>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>

<?php
get_footer();

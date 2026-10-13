<?php
add_action('wp_ajax_armodafinil_search', 'handle_armodafinil_search');
add_action('wp_ajax_nopriv_armodafinil_search', 'handle_armodafinil_search');

function handle_armodafinil_search() {
    $q = isset($_GET['q']) ? sanitize_text_field($_GET['q']) : '';
    $cat = isset($_GET['cat']) ? sanitize_text_field($_GET['cat']) : '';

    if (empty($q)) {
        wp_send_json_success(array());
    }

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => 10,
        's' => $q,
    );

    if (!empty($cat)) {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $cat,
            ),
        );
    }

    $query = new WP_Query($args);
    $results = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $product = wc_get_product(get_the_ID());
            
            if (!$product) continue;

            $results[] = array(
                'url' => get_permalink(),
                'image' => get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') ?: wc_placeholder_img_src(),
                'title' => get_the_title(),
                'price' => $product->get_price_html(),
                'price_per_unit' => get_field('price_per_unit', get_the_ID()),
            );
        }
    }
    wp_reset_postdata();

    wp_send_json_success($results);
}

<?php
// Register Custom Post Types

function armd_register_cpts() {
    // Conditions
    $labels = array(
        'name'                  => 'Conditions',
        'singular_name'         => 'Condition',
        'menu_name'             => 'Conditions',
        'name_admin_bar'        => 'Condition',
        'archives'              => 'Condition Archives',
        'all_items'             => 'All Conditions',
        'add_new_item'          => 'Add New Condition',
        'add_new'               => 'Add New',
        'new_item'              => 'New Condition',
        'edit_item'             => 'Edit Condition',
        'update_item'           => 'Update Condition',
        'view_item'             => 'View Condition',
        'search_items'          => 'Search Condition',
    );
    $args = array(
        'label'                 => 'Condition',
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields' ),
        'taxonomies'            => array(),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-book-alt',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',
        'show_in_rest'          => true,
        'rewrite'               => array('slug' => 'condition-guides'),
    );
    // register_post_type( 'condition', $args );

    // Reviews CPT
    $review_labels = array(
        'name'                  => 'Reviews',
        'singular_name'         => 'Review',
        'menu_name'             => 'Reviews',
        'name_admin_bar'        => 'Review',
        'add_new'               => 'Add New',
        'add_new_item'          => 'Add New Review',
        'new_item'              => 'New Review',
        'edit_item'             => 'Edit Review',
        'view_item'             => 'View Review',
        'all_items'             => 'All Reviews',
        'search_items'          => 'Search Reviews',
        'not_found'             => 'No reviews found.',
    );

    $review_args = array(
        'labels'             => $review_labels,
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'review' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-star-filled',
        'supports'           => array( 'title', 'editor', 'thumbnail' ),
    );

    register_post_type( 'review', $review_args );
}
add_action( 'init', 'armd_register_cpts', 0 );

// Add Custom Columns to Review CPT
add_filter("manage_review_posts_columns", function($columns) {
    $new_columns = [];
    foreach ($columns as $key => $title) {
        if ($key == 'title') {
            $new_columns['review_thumb'] = 'Image';
            $new_columns['title'] = $title;
            $new_columns['rating'] = 'Rating';
            $new_columns['linked_product'] = 'Linked Product';
        } else {
            $new_columns[$key] = $title;
        }
    }
    return $new_columns;
});

// Populate Custom Columns
add_action("manage_review_posts_custom_column", function($column, $post_id) {
    if ($column === "review_thumb") {
        $img_id = get_field("review_image", $post_id);
        if (!$img_id) {
            $img_id = get_field("reviewer_avatar", $post_id);
        }
        if (!$img_id) {
            $img_id = get_post_thumbnail_id($post_id);
        }
        if ($img_id) {
            $img_url = is_array($img_id) ? $img_id['url'] : wp_get_attachment_image_url($img_id, 'thumbnail');
            echo '<img src="' . esc_url($img_url) . '" style="width:44px;height:44px;object-fit:cover;border-radius:8px;border:1px solid #ddd;" />';
        } else {
            echo '<span style="color:#ccc;">—</span>';
        }
    } elseif ($column === "rating") {
        $rating = get_field("rating", $post_id) ?: 5;
        echo esc_html($rating) . ' &#9733;';
    } elseif ($column === "linked_product") {
        $product_id = get_field("linked_product", $post_id);
        if ($product_id) {
            echo '<a href="' . esc_url(get_edit_post_link($product_id)) . '">' . esc_html(get_the_title($product_id)) . '</a>';
        } else {
            echo '<span style="color:#999;">General Review</span>';
        }
    }
}, 10, 2);
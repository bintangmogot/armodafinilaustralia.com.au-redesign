<?php
// Handle product review submission via AJAX

add_action('wp_ajax_submit_product_review', 'handle_submit_product_review');
add_action('wp_ajax_nopriv_submit_product_review', 'handle_submit_product_review');

function handle_submit_product_review() {
    // Verify nonce
    if ( ! isset($_POST['review_nonce']) || ! wp_verify_nonce($_POST['review_nonce'], 'submit_review_nonce') ) {
        wp_send_json_error(array('message' => 'Security check failed. Please refresh and try again.'));
    }

    $product_id = isset($_POST['product_id']) ? intval($_POST['product_id']) : 0;
    $rating = isset($_POST['rating']) ? intval($_POST['rating']) : 5;
    $name = isset($_POST['reviewer_name']) ? sanitize_text_field($_POST['reviewer_name']) : '';
    $email = isset($_POST['reviewer_email']) ? sanitize_email($_POST['reviewer_email']) : '';
    $meta = isset($_POST['reviewer_meta']) && !empty($_POST['reviewer_meta']) ? sanitize_text_field($_POST['reviewer_meta']) : 'Verified Buyer';
    $title = isset($_POST['review_title']) ? sanitize_text_field($_POST['review_title']) : '';
    $content = isset($_POST['review_content']) ? sanitize_textarea_field($_POST['review_content']) : '';

    if ( ! $name || ! $email || ! $content ) {
        wp_send_json_error(array('message' => 'Please fill in all required fields.'));
    }

    // Create the review post
    $post_data = array(
        'post_title'   => $title ? $title : 'Review by ' . $name,
        'post_content' => $content,
        'post_status'  => 'draft', // Requires admin approval
        'post_type'    => 'review',
    );

    $post_id = wp_insert_post($post_data);

    if ( is_wp_error($post_id) ) {
        wp_send_json_error(array('message' => 'Failed to submit review. Please try again later.'));
    }

    // Save ACF fields
    if ( function_exists('update_field') ) {
        update_field('rating', $rating, $post_id);
        update_field('name', $name, $post_id);
        update_field('email', $email, $post_id);
        update_field('reviewer_meta', $meta, $post_id);
        if ( $product_id > 0 ) {
            update_field('linked_product', $product_id, $post_id);
        } else {
            update_field('linked_product', '', $post_id);
        }
    }

    // Optional: save email as post meta so admin can see who submitted
    update_post_meta($post_id, '_reviewer_email', $email);

    wp_send_json_success(array('message' => 'Thank you! Your review has been submitted and is pending approval.'));
}

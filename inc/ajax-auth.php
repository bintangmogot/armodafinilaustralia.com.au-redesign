<?php
/**
 * AJAX handler and processing for Magic Link Login
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// 1. Handle the AJAX request to generate and send the magic link
add_action( 'wp_ajax_nopriv_request_magic_link', 'handle_request_magic_link' );
add_action( 'wp_ajax_request_magic_link', 'handle_request_magic_link' );

function handle_request_magic_link() {
    // Verify nonce
    if ( ! isset( $_POST['security'] ) || ! wp_verify_nonce( $_POST['security'], 'magic_link_nonce' ) ) {
        wp_send_json_error( 'Security check failed. Please refresh the page.' );
    }

    // Validate email
    if ( empty( $_POST['email'] ) || ! is_email( $_POST['email'] ) ) {
        wp_send_json_error( 'Please enter a valid email address.' );
    }

    $email = sanitize_email( $_POST['email'] );
    $user = get_user_by( 'email', $email );
    
    // Create new customer account if they don't exist
    if ( ! $user ) {
        $username = sanitize_user( current( explode( '@', $email ) ), true );
        $append = 1;
        $o_username = $username;
        while ( username_exists( $username ) ) {
            $username = $o_username . $append;
            $append++;
        }

        $password = wp_generate_password( 24, true, true );
        $user_id = wp_create_user( $username, $password, $email );

        if ( is_wp_error( $user_id ) ) {
            wp_send_json_error( 'Could not create an account. Please try again or contact support.' );
        }
        $user = get_user_by( 'id', $user_id );
        $user->set_role( 'customer' );
    }

    // Generate secure token
    $token = wp_generate_password( 32, false, false );
    $expiration = time() + ( 15 * MINUTE_IN_SECONDS ); // 15 minutes

    update_user_meta( $user->ID, '_magic_link_token', wp_hash_password( $token ) );
    update_user_meta( $user->ID, '_magic_link_expiration', $expiration );

    // Generate login URL
    $login_url = add_query_arg( array(
        'magic_login' => 'yes',
        'u' => $user->ID,
        't' => $token
    ), wc_get_page_permalink( 'myaccount' ) );

    // Send Email
    $subject = 'Your secure login link for Armodafinil Australia';
    $message = "Hello,\n\n";
    $message .= "Click the link below to securely log into your account. This link will expire in 15 minutes.\n\n";
    $message .= $login_url . "\n\n";
    $message .= "If you did not request this, you can safely ignore this email.\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8');
    
    $sent = wp_mail( $email, $subject, $message, $headers );

    if ( $sent ) {
        wp_send_json_success( 'Check your inbox! We sent a secure link to log in.' );
    } else {
        // Fallback for staging/local environments where SMTP is not configured
        wp_send_json_error( 'Email failed to send (SMTP not configured on staging). <br><br><a href="' . esc_url($login_url) . '" class="underline font-bold text-brand-700">Click here to simulate login</a>' );
    }
}

// 2. Process the magic link when the user clicks it
add_action( 'template_redirect', 'process_magic_link_login' );

function process_magic_link_login() {
    if ( isset( $_GET['magic_login'] ) && $_GET['magic_login'] === 'yes' && isset( $_GET['u'] ) && isset( $_GET['t'] ) ) {
        
        // Prevent redirect loops and caching issues
        if ( is_user_logged_in() && get_current_user_id() == $_GET['u'] ) {
            wp_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }

        $user_id = absint( $_GET['u'] );
        $token = sanitize_text_field( $_GET['t'] );

        $stored_hash = get_user_meta( $user_id, '_magic_link_token', true );
        $expiration = get_user_meta( $user_id, '_magic_link_expiration', true );

        if ( ! $stored_hash || ! $expiration ) {
            wc_add_notice( 'Invalid or already used magic link. Please request a new one.', 'error' );
            wp_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }

        if ( time() > $expiration ) {
            wc_add_notice( 'Your magic link has expired. Please request a new one.', 'error' );
            wp_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }

        if ( wp_check_password( $token, $stored_hash, $user_id ) ) {
            // Success! Delete the token so it can't be reused.
            delete_user_meta( $user_id, '_magic_link_token' );
            delete_user_meta( $user_id, '_magic_link_expiration' );

            wp_set_auth_cookie( $user_id, true ); // Log the user in
            
            wc_add_notice( 'Successfully logged in!', 'success' );
            wp_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        } else {
            wc_add_notice( 'Invalid magic link.', 'error' );
            wp_redirect( wc_get_page_permalink( 'myaccount' ) );
            exit;
        }
    }
}


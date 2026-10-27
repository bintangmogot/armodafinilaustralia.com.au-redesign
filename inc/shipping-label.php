<?php
add_filter( 'woocommerce_cart_shipping_method_full_label', 'custom_format_shipping_label', 10, 2 );
function custom_format_shipping_label( $label, $method ) {
    $title = $method->get_label();
    
    // Extract text in parentheses (e.g. " (8-15 business days)")
    $description = '';
    if ( preg_match( '/\s*\(([^)]+)\)/', $title, $matches ) ) {
        $description = $matches[1];
        $title = str_replace( $matches[0], '', $title );
    }
    
    $price_html = '';
    $cost = $method->get_cost();
    if ( $cost > 0 ) {
        if ( WC()->cart->display_prices_including_tax() ) {
            $price_html = wc_price( $cost + $method->get_shipping_tax() );
        } else {
            $price_html = wc_price( $cost );
        }
    }
    
    $formatted_label = '<span class="shipping-title">' . esc_html( $title ) . '</span>';
    if ( $price_html ) {
        $formatted_label .= ' ' . $price_html;
    }
    if ( $description ) {
        $formatted_label .= '<span class="description">' . esc_html( $description ) . '</span>';
    }
    
    return $formatted_label;
}

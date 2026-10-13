<?php
/**
 * The template for displaying product content in the single-product.php template
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$product_id = $product->get_id();
$product_name = $product->get_name();
$product_image = wp_get_attachment_image_src( $product->get_image_id(), 'full' );
$product_image_url = $product_image ? $product_image[0] : 'https://placehold.co/600x600/e0f2fe/0369a1?text=Product';

$is_variable = $product->is_type( 'variable' );
$variations = [];
if ( $is_variable ) {
    $available_variations = $product->get_available_variations();
    foreach ( $available_variations as $var ) {
        $qty = 0;
        foreach($var['attributes'] as $key => $val) {
            $qty = $val;
            break;
        }
        $variations[] = array(
            'id' => $var['variation_id'],
            'qty' => $qty,
            'price' => $var['display_price'],
            'attributes_raw' => $var['attributes']
        );
    }
    // Naturally sort variations numerically by pack size/quantity
    usort( $variations, function( $a, $b ) {
        preg_match( '/\d+/', (string)$a['qty'], $mA );
        preg_match( '/\d+/', (string)$b['qty'], $mB );
        $numA = isset( $mA[0] ) ? (int)$mA[0] : null;
        $numB = isset( $mB[0] ) ? (int)$mB[0] : null;
        if ( $numA !== null && $numB !== null && $numA !== $numB ) {
            return $numA <=> $numB;
        }
        return strnatcasecmp( (string)$a['qty'], (string)$b['qty'] );
    });
} else {
    $variations[] = array(
        'id' => 0,
        'qty' => '1 Pack',
        'price' => wc_get_price_to_display( $product ),
        'attributes_raw' => []
    );
}

$currency = html_entity_decode(get_woocommerce_currency_symbol());

// Fetch Custom Reviews
$reviews = get_posts([
    'post_type' => 'review',
    'posts_per_page' => -1,
    'meta_query' => array(
        array(
            'key'     => 'linked_product',
            'value'   => $product_id,
            'compare' => '='
        )
    )
]);
$review_count = count($reviews);
$total_rating = 0;
if ($review_count > 0) {
    foreach ($reviews as $r) {
        $val = (float)(get_field('rating', $r->ID) ?: 5.0);
        $total_rating += $val;
    }
    $average_rating = round($total_rating / $review_count, 1);
} else {
    $average_rating = 5.0;
}

$full_description = apply_filters( 'the_content', $product->get_description() );
// Fix accidental copy-pasted layout wrappers from visual editor
$full_description = preg_replace('/<div class="woocommerce-product-gallery[^"]*"[^>]*>/i', '<div>', $full_description);
$full_description = preg_replace('/<div class="summary entry-summary"[^>]*>/i', '<div>', $full_description);
// Fallback for already processed ones
$full_description = preg_replace('/<div class="stripped-gallery-wrapper[^"]*"[^>]*>/i', '<div>', $full_description);

// Specs
$specs = array();
$attributes = $product->get_attributes();
foreach ( $attributes as $attribute ) {
    if ( $attribute->get_name() === 'package-size' && $is_variable ) continue; // Optionally hide the main variation attribute from specs if you want, but we'll leave it or format it.
    if ( $attribute->is_taxonomy() ) {
        $values = wc_get_product_terms( $product_id, $attribute->get_name(), array( 'fields' => 'names' ) );
        $specs[ wc_attribute_label( $attribute->get_name() ) ] = implode( ', ', $values );
    } else {
        $specs[ $attribute->get_name() ] = implode( ', ', $attribute->get_options() );
    }
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
    
    <!-- Breadcrumb -->
    <div class="border-b border-ink-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center text-xs text-ink-500 gap-2">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
            <span>/</span>
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="hover:text-brand-700">Products</a>
            <span>/</span>
            <span class="text-ink-900 truncate"><?php echo esc_html($product_name); ?></span>
        </div>
    </div>

    <div class="section-wash">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
            <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="inline-flex items-center gap-1.5 text-sm text-ink-700 hover:text-brand-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left w-4 h-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg> 
                All products
            </a>

            <div class="mt-6 grid lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                
                <!-- Gallery -->
                <div class="lg:sticky lg:top-24">
                    <div class="bg-white rounded-2xl border border-ink-200 overflow-hidden shadow-sm">
                        <div class="bg-white flex items-center justify-center">
                            <img src="<?php echo esc_url($product_image_url); ?>" alt="<?php echo esc_attr($product_name); ?>" class="w-full h-auto object-contain max-h-[500px]" />
                        </div>
                    </div>
                    <?php 
                    $text_under_img = get_field('text_under_product_image', $product_id);
                    if($text_under_img): 
                    ?>

                      <div class="mt-3 px-4 py-3 bg-brand-50 rounded-xl border border-brand-100" style="display:flex; align-items:flex-start; gap:10px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600" style="flex-shrink:0; margin-top:1px;"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                            <div class="text-xs text-brand-800 font-medium leading-relaxed [&>div]:m-0 [&>p]:m-0" style="flex:1; margin:0; text-align:left;"><?php echo strip_tags($text_under_img, '<b><strong><i><em><a><br><br/>'); ?></div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Info -->
                <div class="product-info-panel">
                    <div class="flex items-center gap-2">
                        <span class="text-xs font-semibold text-brand-700 bg-brand-100 rounded-full px-2.5 py-1">Best Seller</span>
                        <span class="inline-flex items-center gap-1 text-xs font-semibold text-brand-700 bg-brand-50 rounded-full px-2.5 py-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-badge-check w-3.5 h-3.5"><path d="M3.85 8.62a4 4 0 0 1 4.78-4.77 4 4 0 0 1 6.74 0 4 4 0 0 1 4.78 4.78 4 4 0 0 1 0 6.74 4 4 0 0 1-4.77 4.78 4 4 0 0 1-6.75 0 4 4 0 0 1-4.78-4.77 4 4 0 0 1 0-6.76Z"/><path d="m9 12 2 2 4-4"/></svg> 
                            In stock
                        </span>
                    </div>
                    
                    <h1 class="mt-3 font-serif text-3xl md:text-4xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($product_name); ?></h1>
                    
                    <div class="mt-3 flex items-center gap-2">
                        <?php for($i=0; $i<5; $i++): ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="<?php echo $i < round($average_rating) ? 'currentColor' : 'none'; ?>" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-star w-4 h-4 <?php echo $i < round($average_rating) ? 'text-brand-600' : 'text-ink-200'; ?>"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        <?php endfor; ?>
                        <span class="text-sm text-ink-500"><?php echo esc_html(number_format($average_rating, 1)); ?> &middot; <a href="#reviews" class="hover:text-brand-700 underline decoration-dotted">(<?php echo esc_html($review_count); ?> reviews)</a></span>
                    </div>

                    <div class="mt-5 flex items-baseline gap-3 flex-wrap">
                        <span class="text-4xl font-semibold text-ink-900" id="dynamic-price"><?php echo $currency . number_format($variations[0]['price'], 2); ?></span>
                        <span class="text-sm text-ink-500" id="dynamic-per-pill">
                            <?php 
                            $ppu = get_field('price_per_unit', $product_id);
                            if ( ! $is_variable && $ppu ) {
                                echo esc_html($ppu);
                            }
                            ?>
                        </span>
                    </div>
                      <?php 
                      $short_desc = apply_filters('woocommerce_short_description', $product->get_short_description());
                      if($short_desc): 
                      ?>
                          <div class="mt-5 p-5 bg-white rounded-xl border border-ink-200 shadow-sm text-[14px] text-ink-700 leading-relaxed prose prose-ink prose-a:text-brand-700 max-w-none">
                              <?php echo wp_kses_post($short_desc); ?>
                          </div>
                      <?php endif; ?>

                    <!-- Promo strip -->
                    <div class="mt-5 p-4 rounded-xl bg-amber-50 border border-amber-200 flex items-center gap-3">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info w-5 h-5 text-amber-600 shrink-0"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        <p class="text-sm text-amber-900 font-medium">Free shipping on orders above <b>$299</b></p>
                    </div>

                    <!-- Add to Cart Form -->
                    <form class="cart mt-6" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
                        
                        <?php if ( $is_variable ) : ?>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold text-ink-900">Tablets</span>
                                <span class="text-ink-500">Prices vary</span>
                            </div>
                            
                            <div class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-2" id="variant-buttons">
                                <?php foreach($variations as $i => $v): 
                                    // Serialize attributes for JS parsing
                                    $attrs_json = htmlspecialchars(json_encode($v['attributes_raw']), ENT_QUOTES, 'UTF-8');
                                ?>
                                    <button type="button" data-vid="<?php echo esc_attr($v['id']); ?>" data-price="<?php echo esc_attr($v['price']); ?>" data-qty="<?php echo esc_attr($v['qty']); ?>" data-attrs="<?php echo $attrs_json; ?>" class="variant-btn p-3 rounded-xl border text-left transition-colors <?php echo $i === 0 ? 'bg-brand-600 text-white border-brand-600 active' : 'bg-white text-ink-900 border-ink-200 hover:border-brand-500'; ?>">
                                        <div class="text-lg font-semibold"><?php 
    $display_qty = $v['qty'];
    preg_match("/[0-9]+/", $display_qty, $matches);
    if (!empty($matches)) {
        $display_qty = $matches[0] . " Tablets";
    } else {
        $display_qty = ucwords(str_replace("-", " ", $display_qty));
    }
    echo esc_html($display_qty); 
?></div>
                                        <div class="text-xs <?php echo $i === 0 ? 'text-white/80' : 'text-ink-500'; ?> price-label"><?php echo $currency . number_format($v['price'], 2); ?></div>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            
                            <input type="hidden" name="variation_id" class="variation_id" value="<?php echo esc_attr($variations[0]['id']); ?>" />
                            <div id="dynamic-attributes-container">
                                <?php foreach($variations[0]['attributes_raw'] as $key => $val): ?>
                                    <input type="hidden" name="<?php echo esc_attr($key); ?>" value="<?php echo esc_attr($val); ?>" />
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <!-- Buy Row -->
                        <div class="mt-6 flex flex-col xl:flex-row items-stretch xl:items-center gap-3">
                            <div class="flex items-center gap-3 w-full xl:w-auto">
                                <div class="inline-flex items-center border border-ink-200 rounded-full overflow-hidden bg-white shrink-0">
                                    <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="minus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus text-ink-700"><path d="M5 12h14"/></svg>
                                    </button>
                                    <input type="number" name="quantity" value="1" min="1" class="qty-input w-10 text-center text-sm font-semibold border-none p-0 outline-none" style="-moz-appearance: textfield;" />
                                    <button type="button" class="qty-btn w-10 h-11 grid place-items-center hover:bg-ink-100" data-action="plus">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus text-ink-700"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </button>
                                </div>

                                <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" class="flex-1 xl:flex-none inline-flex items-center justify-center gap-2 h-11 px-4 sm:px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart w-4 h-4"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg> 
                                    Add to Cart
                                </button>
                            </div>
                            
                            <div class="flex items-center gap-3 w-full xl:w-auto">
                                <button type="button" onclick="document.querySelector('form.cart').submit(); setTimeout(()=>window.location.href='/checkout/', 500);" class="flex-1 xl:flex-none inline-flex items-center justify-center gap-2 h-11 px-4 sm:px-6 rounded-full bg-ink-900 hover:bg-ink-800 text-white font-semibold transition-colors whitespace-nowrap">
                                    Buy now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                                </button>

                                <button type="button" aria-label="Share" class="w-11 h-11 shrink-0 grid place-items-center rounded-full border border-ink-200 hover:border-brand-500 hover:text-brand-600 text-ink-500 bg-white transition-colors" title="Share this product">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-share-2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" x2="15.42" y1="13.51" y2="17.49"/><line x1="15.41" x2="8.59" y1="6.51" y2="10.49"/></svg>
                                </button>
                            </div>
                        </div>
                        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
                    </form>
                    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

                    <!-- Trust row -->
                    <div class="mt-6 grid grid-cols-3 gap-3">
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-4 h-4 text-brand-600 shrink-0"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> <span>AU-wide dispatch</span></div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-4 h-4 text-brand-600 shrink-0"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> <span>Encrypted checkout</span></div>
                        <div class="p-3 rounded-lg bg-white border border-ink-200 flex flex-col sm:flex-row items-center justify-center sm:justify-start gap-1 sm:gap-2 text-[10px] sm:text-xs font-medium text-ink-700 text-center sm:text-left"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-4 h-4 text-brand-600 shrink-0"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> <span>Quality verified</span></div>
                    </div>

                    <!-- Product Specs Accordion -->
                    <?php
                    $custom_specs = get_field('custom_product_specs', $product_id);
                    $visible_attributes = 0;
                      foreach ($attributes as $attr) {
                          $attr_label = strtolower(wc_attribute_label($attr->get_name()));
                          if (!$attr->get_variation() && $attr_label !== 'quantity' && $attr_label !== 'tablets') {
                              $visible_attributes++;
                          }
                      }
                      $total_specs_count = $visible_attributes + (is_array($custom_specs) ? count($custom_specs) : 0);
                    if ($total_specs_count > 0):
                    ?>
                    <div class="mt-8 border border-ink-200 rounded-xl overflow-hidden bg-white">
                        <details class="group" open>
                            <summary class="flex items-center justify-between p-4 cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                                <div class="flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle-2 text-brand-600"><circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/></svg>
                                    <span class="font-medium text-ink-900">Product specs</span>
                                    <span class="text-ink-500 text-sm">(<?php echo $total_specs_count; ?>)</span>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down text-ink-500 transition-transform group-open:rotate-180"><path d="m6 9 6 6 6-6"/></svg>
                            </summary>
                            <div class="px-4 pb-4 border-t border-ink-100 text-sm pt-4">
                                <dl class="divide-y divide-ink-100">
                                    <?php if(is_array($custom_specs)): foreach($custom_specs as $spec): ?>
                                    <div class="py-3 flex justify-between gap-4">
                                        <dt class="text-ink-500 min-w-[120px]"><?php echo esc_html($spec['spec_name']); ?></dt>
                                        <dd class="text-ink-900 font-medium text-right"><?php echo esc_html($spec['spec_value']); ?></dd>
                                    </div>
                                    <?php endforeach; endif; ?>
                                    
                                                                          <?php foreach ( $attributes as $attribute ) :
                                          // Skip variation attributes (like Quantity, Tablets, etc.)
                                          if ( $attribute->get_variation() ) { continue; }
                                          
                                          // Extra safety check for explicitly named attributes we want to hide
                                          $attr_name = wc_attribute_label( $attribute->get_name() );
                                          if ( strtolower($attr_name) === 'quantity' || strtolower($attr_name) === 'tablets' ) { continue; }
                                          
                                          $values = array();
                                          if ( $attribute->is_taxonomy() ) {
                                              $attribute_taxonomy = $attribute->get_taxonomy_object();
                                              $attribute_values = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );
                                              foreach ( $attribute_values as $attribute_value ) {
                                                  $value_name = esc_html( $attribute_value->name );
                                                  if ( $attribute_taxonomy->attribute_public ) {
                                                      $values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
                                                  } else {
                                                      $values[] = $value_name;
                                                  }
                                              }
                                          } else {
                                              $values = $attribute->get_options();
                                              foreach ( $values as &$value ) {
                                                  $value = make_clickable( esc_html( $value ) );
                                              }
                                          }
                                          // Skip pack size attribute
                                          if($attribute->get_name() === 'pa_pack-size' || $attribute->get_name() === 'pack-size') continue;
                                      ?>
                                      <div class="py-3 flex justify-between gap-4">
                                          <dt class="text-ink-500 min-w-[120px]"><?php echo wc_attribute_label( $attribute->get_name() ); ?></dt>
                                          <dd class="text-ink-900 font-medium text-right"><?php echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values ); ?></dd>
                                      </div>
                                      <?php endforeach; ?>
                                  </dl>
                              </div>
                          </details>
                      </div>
                      <?php endif; ?>
                      
                  </div>
              </div>
        </div>
    </div>
    
    <div class="bg-white">
        <!-- Single Description Block -->
    <div class="bg-white">
        <?php $has_desc = !empty(trim(wp_strip_all_tags($full_description))); ?>
        <?php if($has_desc): ?>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-12" id="product-description-section">
              <div class="max-w-3xl prose prose-ink prose-headings:font-serif prose-headings:text-ink-900 prose-a:text-brand-700 max-w-none">
                    <div class="block clear-both after:content-[''] after:table after:clear-both">
                        <?php echo $full_description; ?>
                  </div>
              </div>
          </div>
        <?php endif; ?>
    </div>
<?php if( have_rows('page_modules', get_the_ID()) ): ?>
              <div class="bg-slate-50 py-8">
              <?php
                  while( have_rows('page_modules', get_the_ID()) ) : the_row();
                      $layout = get_row_layout();
                      get_template_part('modules/content', $layout);
                  endwhile;
              ?>
              </div>
              <?php endif; ?>
  
              <!-- Medical Disclaimer Block -->
              <?php
              // Pull fields, fallback to global options
              $usage_title = get_field('usage_note_title', get_the_ID()) ?: (get_field('usage_note_title', 'option') ?: 'Important Usage Note');
              $usage_text = get_field('usage_note_text', get_the_ID()) ?: get_field('usage_note_text', 'option');
              $info_text = get_field('informational_warning_text', get_the_ID()) ?: get_field('informational_warning_text', 'option');
                $doctor_id = get_field('medical_reviewer_post', get_the_ID());
                if ($doctor_id) {
                    $rev_name = get_the_title($doctor_id);
                    $rev_url = get_permalink($doctor_id);
                    $rev_title = get_field('medical_title', $doctor_id) ?: 'Physician';
                } else {
                    $rev_name = '';
                    $rev_url = '';
                    $rev_title = '';
                }
                $last_updated = get_the_modified_date('F Y');
              
              if ($usage_text) {
                  $usage_text = str_replace('{product_name}', get_the_title(), $usage_text);
              }
              
              // Only render the wrapper if AT LEAST ONE piece of content exists
              if (!empty($usage_text) || !empty($info_text) || !empty($rev_name)):
              ?>
              <div class="bg-white"><div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                  
                  <?php if (!empty($usage_text)): ?>
                  <div class="bg-amber-50 border border-amber-200 rounded-lg p-5 mb-6 flex gap-4">
                      <div class="flex-shrink-0 pt-0.5">
                          <svg class="w-5 h-5 text-amber-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                      </div>
                      <div>
                          <h4 class="text-[15px] font-bold text-ink-900 mb-1"><?php echo esc_html($usage_title); ?></h4>
                          <div class="text-[14px] text-ink-700 leading-relaxed [&_a]:text-brand-700 [&_a]:underline hover:[&_a]:text-brand-800">
                              <?php echo wp_kses_post($usage_text); ?>
                          </div>
                      </div>
                  </div>
                  <?php endif; ?>
  
                  <?php if (!empty($info_text)): ?>
                  <div class="bg-slate-50 border border-slate-200 rounded-lg p-5 mb-8 flex gap-4">
                      <div class="flex-shrink-0 pt-0.5">
                          <svg class="w-5 h-5 text-brand-600" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                      </div>
                      <div class="text-[14px] text-ink-700 leading-relaxed [&_a]:text-brand-700 [&_a]:underline hover:[&_a]:text-brand-800">
                          <?php echo wp_kses_post($info_text); ?>
                      </div>
                  </div>
                  <?php endif; ?>
  
                  <?php if (!empty($rev_name)): ?>
                  <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center text-[13px] text-ink-500 gap-4 w-full mt-2">
                      <div>
                          Medically reviewed by: <a href="<?php echo esc_url($rev_url ? $rev_url : '#'); ?>" class="font-bold text-teal-700 hover:text-teal-800 hover:underline"><?php echo esc_html($rev_name); ?></a> <?php if($rev_title) echo '(' . esc_html($rev_title) . ')'; ?>
                      </div>
                      <div>
                          Last updated: <?php echo esc_html($last_updated); ?>
                      </div>
                  </div>
                  <?php endif; ?>
              </div>
              </div>
              <?php endif; ?>

              <div class="bg-brand-50/30 border-t border-ink-100 py-12">
              <?php get_template_part('template-parts/product-reviews'); ?>
              </div>
  
              <!-- Frequently Bought Together -->
              <div class="bg-white py-12"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                  <h2 class="text-2xl font-bold text-ink-900 mb-8">Frequently Bought Together</h2>
                  <?php 
                  $related_products = wc_get_related_products(get_the_ID(), 4);
                  if (empty($related_products)) {
                      // Native WC Shortcode fallback
                      echo do_shortcode('[products limit="4" columns="4" orderby="rand" excludes="' . get_the_ID() . '"]');
                  } else {
                      add_filter( 'woocommerce_product_related_products_heading', '__return_empty_string' );
                      woocommerce_output_related_products(array(
                          'posts_per_page' => 4,
                          'columns'        => 4,
                          'orderby'        => 'rand'
                      )); 
                      remove_filter( 'woocommerce_product_related_products_heading', '__return_empty_string' );
                  }
                  ?>
              </div>
  
              <?php get_template_part('template-parts/order-cta'); ?>

</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Quantity logic
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            const input = e.currentTarget.parentElement.querySelector('input.qty-input');
            let v = parseInt(input.value) || 1;
            if (e.currentTarget.dataset.action === 'plus') v++;
            else if (v > 1) v--;
            input.value = v;
        });
    });

    // Variant Selection logic
    const buttons = document.querySelectorAll('.variant-btn');
    const inputVid = document.querySelector('.variation_id');
    const dynamicAttrsContainer = document.getElementById('dynamic-attributes-container');
    const dynamicPrice = document.getElementById('dynamic-price');
    const dynamicPerPill = document.getElementById('dynamic-per-pill');
    const currency = '<?php echo $currency; ?>';

    const updateUI = (btn) => {
        buttons.forEach(b => {
            b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600', 'active');
            b.classList.add('bg-white', 'text-ink-900', 'border-ink-200');
            b.querySelector('.price-label').classList.remove('text-white/80');
            b.querySelector('.price-label').classList.add('text-ink-500');
        });
        
        btn.classList.remove('bg-white', 'text-ink-900', 'border-ink-200');
        btn.classList.add('bg-brand-600', 'text-white', 'border-brand-600', 'active');
        btn.querySelector('.price-label').classList.remove('text-ink-500');
        btn.querySelector('.price-label').classList.add('text-white/80');

        const vid = btn.dataset.vid;
        const price = parseFloat(btn.dataset.price);
        const qty = parseInt(btn.dataset.qty.replace(/\D/g, '')) || 1;
        const attrs = JSON.parse(btn.dataset.attrs);

        if (inputVid) inputVid.value = vid;
        
        if (dynamicAttrsContainer) {
            dynamicAttrsContainer.innerHTML = '';
            for(const key in attrs) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = key;
                input.value = attrs[key];
                dynamicAttrsContainer.appendChild(input);
            }
        }

        dynamicPrice.innerText = currency + price.toFixed(2);
        if (qty > 1) {
            dynamicPerPill.innerText = currency + (price / qty).toFixed(2) + ' / tablet';
        } else {
            dynamicPerPill.innerText = '';
        }
    };

    if (buttons.length > 0) {
        buttons.forEach(btn => {
            btn.addEventListener('click', () => updateUI(btn));
        });
    }

    // AJAX Add to Cart
    const cartForm = document.querySelector('form.cart');
    if (cartForm) {
        cartForm.addEventListener('submit', function(e) {
            // If they clicked Buy Now (we can check if event submitter was buy now, but wait, buy now button uses onclick=submit(), so let's check if the submitter is Add To Cart)
            const submitter = e.submitter;
            if (submitter && submitter.textContent.includes('Buy now')) {
                return; // Let it submit normally (or redirect)
            }
            
            e.preventDefault();
            
            const btn = cartForm.querySelector('button[name="add-to-cart"]');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span class="animate-spin inline-block w-4 h-4 border-2 border-white/30 border-t-white rounded-full mr-2"></span> Adding...';
            btn.disabled = true;

            const formData = new FormData(cartForm);
            // Append the add-to-cart value which is required
            formData.append('add-to-cart', btn.value);

            fetch('<?php echo esc_url( wc_get_cart_url() ); ?>', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.text();
                }
                throw new Error('Network response was not ok.');
            })
            .then(html => {
                btn.innerHTML = 'Added!';
                setTimeout(() => {
                    btn.innerHTML = originalText;
                    btn.disabled = false;
                }, 2000);

                                // Trigger jQuery event for Side Cart plugin
                if (typeof jQuery !== 'undefined') {
                    // Fetch real fragments to pass to side cart
                    var fragUrl = (typeof wc_cart_fragments_params !== 'undefined') 
                        ? wc_cart_fragments_params.wc_ajax_url.toString().replace('%%endpoint%%', 'get_refreshed_fragments')
                        : '/?wc-ajax=get_refreshed_fragments';
                        
                    jQuery.ajax({
                        url: fragUrl,
                        type: 'POST',
                        success: function(data) {
                            if (data && data.fragments) {
                                jQuery(document.body).trigger('added_to_cart', [data.fragments, data.cart_hash, jQuery(btn)]);
                            } else {
                                jQuery(document.body).trigger('wc_fragment_refresh');
                            }
                        },
                        error: function() {
                            jQuery(document.body).trigger('wc_fragment_refresh');
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });
    }

    // Tabs logic removed
    // Share Integration
    const shareBtn = document.querySelector('button[aria-label="Share"]');
    if (shareBtn) {
        shareBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (navigator.share && window.isSecureContext) {
                navigator.share({
                    title: document.title,
                    url: window.location.href
                }).catch(console.error);
            } else {
                // Fallback: Copy to clipboard
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(window.location.href);
                    alert('Link copied to clipboard!');
                } else {
                    // Old school fallback for non-https local dev
                    const textArea = document.createElement('textarea');
                    textArea.value = window.location.href;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                        alert('Link copied to clipboard!');
                    } catch (err) {
                        console.error('Unable to copy', err);
                    }
                    document.body.removeChild(textArea);
                }
            }
        });
    }



    // Promo Copy Button Logic
    const copyBtns = document.querySelectorAll('.promo-copy-btn');
    copyBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const code = this.getAttribute('data-code');
            const originalContent = this.innerHTML;
            
                        
            const successState = () => {
                this.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check w-4 h-4"><path d="M20 6 9 17l-5-5"/></svg> <span>Copied!</span>';
                this.classList.add('bg-amber-100');
                setTimeout(() => {
                    this.innerHTML = originalContent;
                    this.classList.remove('bg-amber-100');
                }, 2000);
            };

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(code).then(successState).catch(err => {
                    console.error('Failed to copy: ', err);
                });
            } else {
                const textArea = document.createElement("textarea");
                textArea.value = code;
                textArea.style.position = "fixed";
                textArea.style.left = "-999999px";
                textArea.style.top = "-999999px";
                document.body.appendChild(textArea);
                textArea.focus();
                textArea.select();
                try {
                    document.execCommand('copy');
                    successState();
                } catch (err) {
                    console.error('Fallback: Oops, unable to copy', err);
                }
                document.body.removeChild(textArea);
            }
        });
    });

});
</script>


</div><!-- End product -->










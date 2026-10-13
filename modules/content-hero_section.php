<?php
/**
 * Hero Section Module Template
 * 
 * Data provided by ACF Sub Fields: eyebrow, title, subtitle, cta_label, cta_url, featured_product
 */

$eyebrow   = get_sub_field('eyebrow');
$title     = get_sub_field('title');
$subtitle  = get_sub_field('subtitle');
$cta_label = get_sub_field('cta_label');
$cta_url   = get_sub_field('cta_url');
$product_obj = get_sub_field('featured_product');

// Default product values in case none selected
$p_title = 'Armodafinil 250mg ÃƒÂ¢Ã¢â€šÂ¬Ã¢â‚¬Â Artvigil 250mg';
$p_image = 'https://placehold.co/800x450/e0f2fe/0369a1?text=Product+Image';
$p_price_html = '$185.00';
$p_stock = 'In stock';
$p_url   = '#';
$p_note  = 'Limit 1 per customer on first order.';
$p_id    = 0;
$is_variable = false;
$variations_json = '[]';
$attributes = array();
$default_price = 0;

if ( $product_obj ) {
    $product = wc_get_product( $product_obj->ID );
    if ( $product ) {
        $p_id    = $product->get_id();
        $p_title = $product->get_name();
        $p_price_html = $product->get_price_html();
        $p_url   = $product->get_permalink();
        
        $image_id = $product->get_image_id();
        if ( $image_id ) {
            $p_image = wp_get_attachment_image_url( $image_id, 'large' );
        }
        $p_stock = $product->is_in_stock() ? 'In stock' : 'Out of stock';

        if ( $product->is_type( 'variable' ) ) {
            $is_variable = true;
            $available_variations = $product->get_available_variations();
            $variations_json = wp_json_encode( $available_variations );
            $attributes = $product->get_variation_attributes();

            // Naturally sort attribute options numerically (e.g., 50, 100, 200, 300, 400, 500, 900)
            if ( is_array( $attributes ) ) {
                foreach ( $attributes as $attr_name => &$options_list ) {
                    if ( is_array( $options_list ) ) {
                        usort( $options_list, function( $a, $b ) {
                            preg_match( '/\d+/', (string)$a, $mA );
                            preg_match( '/\d+/', (string)$b, $mB );
                            $numA = isset( $mA[0] ) ? (int)$mA[0] : null;
                            $numB = isset( $mB[0] ) ? (int)$mB[0] : null;
                            if ( $numA !== null && $numB !== null && $numA !== $numB ) {
                                return $numA <=> $numB;
                            }
                            return strnatcasecmp( (string)$a, (string)$b );
                        });
                    }
                }
                unset( $options_list );
            }

            $default_price = $product->get_variation_price( 'min', true );
            $p_price_html = wc_price( $default_price ); // initial price
        }
    }
}
?>

<?php
$has_text_content = $eyebrow || $title || $subtitle || $cta_label || $cta_url;
$wrapper_classes = $has_text_content 
    ? 'max-w-7xl grid lg:grid-cols-2 gap-10 items-start' 
    : 'max-w-3xl flex flex-col items-center justify-center';
?>
<section class="section-wash">
    <div class="mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-14 md:pt-10 md:pb-20 <?php echo esc_attr($wrapper_classes); ?>">
        <?php if ( $has_text_content ) : ?>
        <div class="animate-fadeup w-full">
            <?php if ( $eyebrow ) : ?>
            <span class="inline-flex items-center gap-2 text-xs font-semibold uppercase tracking-[0.18em] text-brand-700 bg-brand-100 px-3 py-1.5 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                <?php echo esc_html( $eyebrow ); ?>
            </span>
            <?php endif; ?>

            <?php if ( $title ) : ?>
            <h1 class="mt-5 font-serif text-4xl md:text-6xl leading-[1.05] font-semibold text-ink-900">
                <?php echo wp_kses_post( $title ); ?>
            </h1>
            <?php endif; ?>

            <?php if ( $subtitle ) : ?>
            <p class="mt-5 text-lg text-ink-700 leading-relaxed max-w-xl">
                <?php echo wp_kses_post( $subtitle ); ?>
            </p>
            <?php endif; ?>

            <div class="mt-8 flex flex-wrap gap-3">
                <?php if ( $cta_url && $cta_label ) : ?>
                <a href="<?php echo esc_url( $cta_url ); ?>" class="inline-flex items-center gap-2 h-12 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors shadow-soft">
                    <?php echo esc_html( $cta_label ); ?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <?php endif; ?>
                
            </div>
        </div>
        <?php endif; ?>

        <div class="bg-white rounded-[24px] border border-ink-200 shadow-card animate-fadeup p-3 md:p-4 w-full" id="hero-product-<?php echo esc_attr($p_id); ?>">
            <!-- Image Box with border instead of full bleed -->
            <a href="<?php echo esc_url($p_url); ?>" target="_blank" class="block aspect-[16/9] bg-white rounded-2xl border border-ink-100 overflow-hidden relative group">
                <!-- Most Popular Badge -->
                <div class="absolute top-3 left-3 z-10 inline-flex items-center gap-1.5 bg-ink-900 text-white text-[10px] font-bold uppercase tracking-widest px-3 py-1.5 rounded-full shadow-md backdrop-blur-md">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-amber-400"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    Most Popular
                </div>
                <img src="<?php echo esc_url( $p_image ); ?>" alt="<?php echo esc_attr( $p_title ); ?>" class="w-full h-full object-contain group-hover:scale-105 transition-transform duration-500" />
            </a>
            
            <div class="p-3 md:p-4 pb-1">
                <div class="flex items-start justify-between gap-3">
                    <h3 class="font-serif text-2xl font-bold text-ink-900 leading-tight">
                        <a href="<?php echo esc_url($p_url); ?>" target="_blank" class="hover:text-brand-600 transition-colors"><?php echo esc_html( $p_title ); ?></a>
                    </h3>
                    <span class="shrink-0 text-[10px] font-bold uppercase tracking-wider text-emerald-700 bg-emerald-50 border border-emerald-200 px-2.5 py-1 rounded-full"><?php echo esc_html( $p_stock ); ?></span>
                </div>
                
                <?php if ( $is_variable && ! empty( $attributes ) ) : ?>
                    <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                    <div class="mt-5 attribute-selector">
                        <div class="text-[10px] uppercase tracking-widest font-bold text-ink-500 mb-2.5"><?php echo wc_attribute_label( $attribute_name ); ?></div>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ( $options as $index => $option ) : 
                                $is_selected = $index === 0;
                                $display_option = trim($option);
                                if ( is_numeric( $display_option ) ) {
                                    $display_option .= ' Tablets';
                                }
                            ?>
                                <button type="button" 
                                        data-attribute="<?php echo esc_attr( 'attribute_' . sanitize_title( $attribute_name ) ); ?>"
                                        data-value="<?php echo esc_attr( $option ); ?>"
                                        class="variation-btn text-xs font-bold px-3 py-2 rounded-lg border transition-all duration-200 <?php echo $is_selected ? 'bg-brand-600 text-white border-brand-600 shadow-md scale-[1.02]' : 'bg-white text-ink-600 border-ink-200 hover:border-brand-600 hover:text-brand-700 hover:bg-brand-50'; ?>">
                                    <?php echo esc_html( $display_option ); ?>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Promo Code Box -->
                <div class="mt-5 p-3 rounded-xl bg-slate-50 border border-slate-200 flex items-center gap-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600 shrink-0"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/></svg>
                    <div class="text-sm font-bold text-ink-900">Free shipping on orders above $299</div>
                </div>

                <!-- Removed limit notification -->

                <div class="mt-5 pt-5 border-t border-ink-100 flex flex-wrap items-end justify-between gap-4">
                    <div>
                        <div class="text-[11px] font-bold uppercase tracking-widest text-ink-400 mb-1">Total Price</div>
                        <div class="text-3xl font-bold text-brand-700 price-display tabular-nums tracking-tight">
                            <?php echo $p_price_html; ?>
                        </div>
                    </div>
                    
                    <form action="<?php echo esc_url( wc_get_cart_url() ); ?>" method="post" enctype='multipart/form-data' class="flex items-center gap-2.5 hero-add-to-cart-form">
                        <div class="inline-flex items-center border-2 border-ink-100 rounded-xl overflow-hidden bg-white h-12 shadow-sm">
                            <button type="button" onclick="this.nextElementSibling.stepDown()" class="w-10 h-full grid place-items-center hover:bg-ink-50 text-ink-500 hover:text-ink-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                            </button>
                            <input type="number" name="quantity" value="1" min="1" class="w-10 text-center text-sm font-bold border-0 p-0 focus:ring-0 text-ink-900 bg-transparent" style="-moz-appearance: textfield;" />
                            <button type="button" onclick="this.previousElementSibling.stepUp()" class="w-10 h-full grid place-items-center hover:bg-ink-50 text-ink-500 hover:text-ink-900 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                            </button>
                        </div>
                        
                        <?php if ( $is_variable ) : ?>
                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $p_id ); ?>" />
                            <input type="hidden" name="product_id" value="<?php echo esc_attr( $p_id ); ?>" />
                            <input type="hidden" name="variation_id" class="variation_id" value="" />
                            <?php foreach ( $attributes as $attribute_name => $options ) : ?>
                                <input type="hidden" name="attribute_<?php echo esc_attr( sanitize_title( $attribute_name ) ); ?>" class="attribute_hidden_field" value="<?php echo esc_attr( $options[0] ); ?>" />
                            <?php endforeach; ?>
                        <?php else : ?>
                            <input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $p_id ); ?>" />
                        <?php endif; ?>

                        <button type="submit" class="inline-flex items-center gap-2 h-12 px-6 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold transition-all hover:shadow-lg hover:shadow-brand-600/20 whitespace-nowrap">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                            Add to Cart
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ( $is_variable ) : ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const heroSection = document.getElementById('hero-product-<?php echo esc_attr($p_id); ?>');
    if (!heroSection) return;

    const variations = <?php echo $variations_json; ?>;
    const priceDisplay = heroSection.querySelector('.price-display');
    const variationIdInput = heroSection.querySelector('.variation_id');
    const addToCartForm = heroSection.querySelector('.hero-add-to-cart-form');
    
    // Find matching variation based on currently selected attributes
    function updateVariation() {
        // Collect current selections
        const currentSelections = {};
        heroSection.querySelectorAll('.attribute_hidden_field').forEach(input => {
            currentSelections[input.name] = input.value;
        });

        // Find match
        let matchedVariation = null;
        for (let i = 0; i < variations.length; i++) {
            let match = true;
            for (let attrName in currentSelections) {
                let val = currentSelections[attrName];
                if (variations[i].attributes[attrName] !== undefined && variations[i].attributes[attrName] !== '' && variations[i].attributes[attrName] !== val) {
                    match = false;
                    break;
                }
            }
            if (match) {
                matchedVariation = variations[i];
                break;
            }
        }

        if (matchedVariation) {
            priceDisplay.innerHTML = matchedVariation.price_html;
            variationIdInput.value = matchedVariation.variation_id;
        } else {
            variationIdInput.value = '';
        }
    }

    // Attach click events to variation buttons
    const buttons = heroSection.querySelectorAll('.variation-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const attrName = this.dataset.attribute;
            const attrValue = this.dataset.value;

            // Update UI styling for this group
            const group = this.closest('.attribute-selector');
            group.querySelectorAll('.variation-btn').forEach(b => {
                b.classList.remove('bg-brand-600', 'text-white', 'border-brand-600', 'shadow-md', 'scale-[1.02]');
                b.classList.add('bg-white', 'text-ink-600', 'border-ink-200');
            });
            this.classList.remove('bg-white', 'text-ink-600', 'border-ink-200');
            this.classList.add('bg-brand-600', 'text-white', 'border-brand-600', 'shadow-md', 'scale-[1.02]');

            // Update hidden input
            const hiddenInput = heroSection.querySelector(`input[name="${attrName}"]`);
            if (hiddenInput) {
                hiddenInput.value = attrValue;
            }

            // Recalculate match
            updateVariation();
        });
    });

    // Run once on load to set initial state
    updateVariation();
});
</script>
<?php endif; ?>

<script>
// Promo Copy Logic
document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.getElementById('promo-copy-btn');
    if (!copyBtn) return;
    
    copyBtn.addEventListener('click', function() {
        const textToCopy = 'ARM10';
        
        // Fallback for insecure contexts (HTTP) or older browsers
        const fallbackCopy = () => {
            const tempInput = document.createElement('input');
            tempInput.value = textToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            try {
                document.execCommand('copy');
                return true;
            } catch (err) {
                return false;
            } finally {
                document.body.removeChild(tempInput);
            }
        };

        const showSuccess = () => {
            const originalHTML = copyBtn.innerHTML;
            copyBtn.innerHTML = '<span class="text-emerald-600 tracking-wider font-bold">Copied!</span>';
            setTimeout(() => {
                copyBtn.innerHTML = originalHTML;
            }, 2000);
        };

        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(textToCopy).then(showSuccess).catch(() => {
                if (fallbackCopy()) showSuccess();
            });
        } else {
            if (fallbackCopy()) showSuccess();
        }
    });
});
</script>

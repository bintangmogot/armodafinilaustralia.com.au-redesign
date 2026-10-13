<?php
/**
 * Contact Module Template
 * 
 * Data provided by ACF Sub Fields: form_title, form_shortcode, methods
 */

$form_title = get_sub_field('form_title') ?: 'Send us a message';
$form_shortcode = get_sub_field('form_shortcode');
$methods = get_sub_field('methods');

if ( empty($methods) ) {
    $methods = array(
        array('icon' => 'mail', 'label' => 'Email', 'value' => 'support@armodafinilaustralia.com.au', 'link' => 'mailto:support@armodafinilaustralia.com.au'),
        array('icon' => 'phone', 'label' => 'Phone', 'value' => '+61 4 8999 5839', 'link' => 'tel:+61489995839'),
        array('icon' => 'map-pin', 'label' => 'Address', 'value' => 'Sydney, NSW, Australia', 'link' => ''),
    );
}

// Map of common Lucide icons
$icons = array(
    'message-circle' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-message-circle"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>',
    'mail' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>',
    'phone' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>',
    'map-pin' => '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map-pin"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>'
);
?>

<div class="max-w-6xl mx-auto px-4 py-12 grid lg:grid-cols-3 gap-8 lg:gap-6">
    
    <!-- Contact Information Cards -->
    <?php
    // Force Address to be the first row (first line)
usort($methods, function($a, $b) {
    $is_a_address = (stripos($a['label'], 'address') !== false) ? 1 : 0;
    $is_b_address = (stripos($b['label'], 'address') !== false) ? 1 : 0;
    return $is_b_address - $is_a_address;
});
    ?>
    <div class="lg:col-span-1 space-y-4 min-w-0">
        <?php foreach ($methods as $method) : 
            if (empty($method['label']) && empty($method['value'])) continue; // Skip empty rows
            
            $icon_name = strtolower(trim($method['icon']));
            $icon_svg = isset($icons[$icon_name]) ? $icons[$icon_name] : $icons['mail'];
        ?>
            <?php if (!empty($method['link'])) : ?>
                <a href="<?php echo esc_url($method['link']); ?>" class="flex items-start gap-3 p-4 bg-white border border-ink-200 rounded-2xl hover-lift min-w-0">
            <?php else : ?>
                <div class="flex items-start gap-3 p-4 bg-white border border-ink-200 rounded-2xl min-w-0">
            <?php endif; ?>
                
                <div class="w-10 h-10 rounded-lg bg-brand-100 text-brand-700 grid place-items-center shrink-0">
                    <?php echo $icon_svg; ?>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-xs uppercase tracking-widest text-ink-500 font-semibold"><?php echo esc_html($method['label']); ?></div>
                    <div class="mt-0.5 font-medium text-ink-900 break-words text-sm sm:text-[15px] tracking-tight leading-tight"><?php echo esc_html($method['value']); ?></div>
                </div>
                
            <?php if (!empty($method['link'])) : ?>
                </a>
            <?php else : ?>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    
    <!-- Contact Form -->
    <div class="lg:col-span-2 bg-white border border-ink-200 rounded-2xl p-6 md:p-8">
        <h2 class="font-serif text-2xl font-semibold text-ink-900 mb-6"><?php echo esc_html($form_title); ?></h2>
        
        <?php if (!empty($form_shortcode)) : ?>
            <div class="gf_browser_chrome gform_wrapper">
                <!-- Apply some structural tailwind styles to standard Gravity Form elements if needed -->
                <style>
                    .gform_wrapper input[type="text"], .gform_wrapper input[type="email"], .gform_wrapper input[type="tel"], .gform_wrapper textarea {
                        width: 100% !important; border-radius: 0.5rem !important; border: 1px solid #e2e8f0 !important; padding: 0.5rem 0.75rem !important; outline: none !important; transition: border-color 0.2s !important; box-shadow: none !important;
                    }
                    .gform_wrapper input[type="text"]:focus, .gform_wrapper input[type="email"]:focus, .gform_wrapper input[type="tel"]:focus, .gform_wrapper textarea:focus {
                        border-color: #0d9488;
                    }
                    .gform_wrapper input[type="submit"] {
                        height: 2.75rem !important; padding: 0 1.5rem !important; border-radius: 9999px !important; background-color: #0d9488 !important; color: white !important; font-weight: 600 !important; cursor: pointer !important; transition: background-color 0.2s !important; border: none !important;
                    }
                    .gform_wrapper input[type="submit"]:hover { background-color: #0f766e; }
                    .gform_wrapper .gfield_label { font-size: 0.875rem; color: #334155; margin-bottom: 0.25rem; display: block; }
                    .gform_wrapper .gfield { margin-bottom: 0 !important; }
                    .gform_wrapper .gform_fields { row-gap: 1rem !important; margin-bottom: 1rem !important; }
                </style>
                <?php echo do_shortcode($form_shortcode); ?>
            </div>
        <?php else : ?>
            <!-- Fallback Demo Form -->
            <form class="space-y-4" onsubmit="event.preventDefault(); this.querySelector('.success-msg').style.display = 'block';">
                <div class="grid sm:grid-cols-2 gap-4">
                    <label class="block"><span class="text-sm text-ink-700">Full name</span>
                        <input required class="mt-1 w-full h-11 rounded-lg border border-ink-200 px-3 outline-none focus:border-brand-600" />
                    </label>
                    <label class="block"><span class="text-sm text-ink-700">Email</span>
                        <input type="email" required class="mt-1 w-full h-11 rounded-lg border border-ink-200 px-3 outline-none focus:border-brand-600" />
                    </label>
                </div>
                <label class="block"><span class="text-sm text-ink-700">Subject</span>
                    <input class="mt-1 w-full h-11 rounded-lg border border-ink-200 px-3 outline-none focus:border-brand-600" />
                </label>
                <label class="block"><span class="text-sm text-ink-700">Message</span>
                    <textarea required rows="5" class="mt-1 w-full rounded-lg border border-ink-200 px-3 py-2 outline-none focus:border-brand-600"></textarea>
                </label>
                <button type="submit" class="h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">Send message</button>
                <p class="success-msg text-sm text-brand-700 hidden mt-2">Thanks — we'll reply within one business day.</p>
            </form>
        <?php endif; ?>
    </div>
</div>




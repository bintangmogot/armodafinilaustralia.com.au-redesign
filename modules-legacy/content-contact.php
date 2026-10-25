<?php
/**
 * Layout: Contact
 * Fields: form (wysiwyg), email (text), phone (text), address (wysiwyg), map (textarea)
 */
$form = get_sub_field('form');
$email = get_sub_field('email');
$phone = get_sub_field('phone');
$address = get_sub_field('address');
$map = get_sub_field('map');
?>
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto grid lg:grid-cols-2 gap-6 md:gap-4 lg:gap-8">
        <!-- Contact Details -->
        <div
            class="space-y-6 bg-[#f4f6f9] p-8 lg:p-10 rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.04)] border border-black/5 h-fit">
            <?php if ($email): ?>
                <div>
                    <h3 class="font-bold text-primary text-xl mb-1">Email</h3>
                    <a href="mailto:<?php echo esc_attr($email); ?>"
                        class="text-gray-600 text-lg hover:text-primary transition-colors font-medium flex items-center gap-2">
                        <?php echo esc_html($email); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($phone): ?>
                <div>
                    <h3 class="font-bold text-primary text-xl mb-1">Phone</h3>
                    <a href="tel:<?php echo esc_attr($phone); ?>"
                        class="text-gray-600 text-lg hover:text-primary transition-colors font-medium flex items-center gap-2">
                        <?php echo esc_html($phone); ?>
                    </a>
                </div>
            <?php endif; ?>

            <?php if ($address): ?>
                <div>
                    
                    <div class="text-gray-600 text-lg leading-relaxed"><?php echo armo_content($address); ?></div>
                </div>
            <?php endif; ?>

            <?php if ($map): ?>
                <div class="rounded-xl overflow-hidden shadow-sm border border-gray-200 mt-4 h-[250px] lg:h-[300px]">
                    <div class="w-full h-full [&>iframe]:w-full [&>iframe]:h-full">
                        <?php echo $map; // Raw HTML for iframe embed ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <!-- Contact Form -->
        <div>
            <?php if ($form): ?>
                <div class="prose max-w-none"><?php echo armo_content($form); ?></div>
            <?php else: ?>
                <p class="text-gray-400 italic">[ Contact form - add shortcode or content in ACF ]</p>
            <?php endif; ?>
        </div>
    </div>
</section>
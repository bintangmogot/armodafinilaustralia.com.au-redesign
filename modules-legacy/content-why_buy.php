<?php
/**
 * Layout: Why Buy From Us
 * Fields: heading (text), intro (wysiwyg), features (repeater: icon (image), title (text), content (textarea))
 * Design: White background section with a 3x2 grid of light blue cards.
 */

$heading = get_sub_field('heading');
$intro = get_sub_field('intro');
?>
<section class="py-16 px-6 lg:px-12 bg-white">
    <div class="max-w-7xl mx-auto">
        <!-- Section Header -->
        <div class="w-full mb-12">
            <?php if ($heading): ?>
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4 leading-tight">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php else: ?>
                <h2 class="text-3xl lg:text-4xl font-bold text-primary mb-4 leading-tight">
                    Why Buy From Armodafinil Australia?
                </h2>
            <?php endif; ?>

            <?php if ($intro): ?>
                <div class="prose prose-lg text-primary/80 leading-relaxed max-w-none">
                    <?php echo armo_content($intro); ?>
                </div>
            <?php else: ?>
                <!-- <div class="text-primary/80 text-base md:text-lg leading-relaxed">
                    <p class="mb-2">Looking to buy Armodafinil online in Australia without the stress?</p>
                    <p>Thousands of Australians choose Armodafinil Australia for premium Armodafinil tablets, fast
                        Australia-wide shipping, discreet packaging, and trusted customer support.</p>
                </div> -->
            <?php endif; ?>
        </div>

        <!-- Cards Grid -->
        <?php if (have_rows('features')): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <?php while (have_rows('features')):
                    the_row();
                    $icon = get_sub_field('icon');
                    $title = get_sub_field('title');
                    $content = get_sub_field('content');

                    $icon_url = '';
                    if ($icon) {
                        if (is_array($icon) && isset($icon['url'])) {
                            $icon_url = $icon['url'];
                        } elseif (is_numeric($icon)) {
                            $icon_url = wp_get_attachment_image_url($icon, 'thumbnail');
                        } elseif (is_string($icon)) {
                            $icon_url = $icon;
                        }
                    }
                    ?>
                    <div
                        class="bg-surface rounded-2xl p-6 lg:p-8 text-primary hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                        <?php if ($icon_url): ?>
                            <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0">
                                <img src="<?php echo esc_url($icon_url); ?>" alt="" class="h-full w-auto object-contain">
                            </div>
                        <?php endif; ?>

                        <div>
                            <?php if ($title): ?>
                                <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">
                                    <?php echo esc_html($title); ?>
                                </h3>
                            <?php endif; ?>

                            <?php if ($content): ?>
                                <p class="text-primary/80 text-base md:text-lg leading-relaxed">
                                    <?php echo esc_html($content); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <!-- Fallback content if ACF fields are empty -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 text-primary">

                <!-- Card 1 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/australia.svg" alt="Australia-Focused Service" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Australia-Focused Service
                        </h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">We built our platform specifically
                            for Australian customers. Pricing, support, shipping, and product selections are tailored for
                            Australia-wide delivery.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/shipped%20in%20discreet%201.svg" alt="Discreet Shipping" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Discreet Shipping</h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">All orders are packed discreetly
                            for privacy and convenience.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/premium.svg" alt="Premium Quality Products" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Premium Quality Products
                        </h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">We stock trusted Armodafinil
                            brands sourced from reputable manufacturers with strong global reputations.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/fast%20delivery.svg" alt="Fast Dispatch" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Fast Dispatch</h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">Orders are processed quickly to
                            minimise delays and keep delivery times consistent.</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/secure.svg" alt="Secure Ordering Process" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Secure Ordering Process
                        </h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">Our checkout process is simple,
                            secure, and designed to make ordering stress-free.</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div
                    class="bg-surface rounded-2xl p-6 lg:p-8 hover:shadow-lg hover:shadow-primary/5 hover:scale-[1.01] transition-all duration-300 flex flex-col items-start gap-4">
                    <div class="w-12 h-12 lg:w-14 lg:h-14 flex items-center justify-start flex-shrink-0 text-primary">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Support.svg" alt="Responsive Support Team" class="w-full h-full object-contain">
                    </div>
                    <div>
                        <h3 class="text-lg lg:text-xl font-bold text-primary mb-2 leading-snug">Responsive Support Team
                        </h3>
                        <p class="text-primary/80 text-base md:text-lg leading-relaxed">We stock trusted Armodafinil
                            brands sourced from reputable manufacturers with strong global reputations.</p>
                    </div>
                </div>

            </div>
        <?php endif; ?>
    </div>
</section>
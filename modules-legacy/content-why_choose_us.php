<?php
/**
 * Layout: Why Choose Us
 * Fields: heading (text), features (repeater: title (text), content (textarea)), image (image), button_text (text), button_link (text)
 * Design: Split screen. Dark blue background on left, full-height image of smiling worker on right.
 */

$heading = get_sub_field('heading');
$features = get_sub_field('features');
$image = get_sub_field('image');
$button_text = get_sub_field('button_text');
$button_link = get_sub_field('button_link');

// Retrieve Image URL
$image_url = '';
if ($image) {
    if (is_array($image) && isset($image['url'])) {
        $image_url = $image['url'];
    } elseif (is_numeric($image)) {
        $image_url = wp_get_attachment_image_url($image, 'large');
    } elseif (is_string($image)) {
        $image_url = $image;
    }
}
?>
<section class="relative overflow-hidden bg-secondary">
    <div class="flex flex-col md:flex-row min-h-[580px]">
        <!-- Image Side (Top on mobile, Right on desktop) -->
        <div class="w-full md:w-1/2 relative h-[400px] md:h-auto order-1 md:order-2">
            <?php if ($image_url): ?>
                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($heading); ?>"
                    class="absolute inset-0 w-full h-full object-cover">
            <?php else: ?>
                <div class="absolute inset-0 bg-primary-dark/20 flex items-center justify-center text-white italic">[ Side
                    Image ]</div>
            <?php endif; ?>
        </div>

        <!-- Text Content Side (Bottom on mobile, Left on desktop) -->
        <div class="w-full md:w-1/2 bg-gradient-review flex items-center justify-end px-6 py-14 lg:py-20 order-2 md:order-1">
            <div class="max-w-xl w-full md:pr-10 lg:pr-16 text-white flex flex-col items-start">

                <?php if ($heading): ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-8 leading-tight">
                        <?php echo esc_html($heading); ?>
                    </h2>
                <?php else: ?>
                    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-8 leading-tight">
                        Why Australians Choose Armodafinil 
                    </h2>
                <?php endif; ?>

                <?php if (have_rows('features')): ?>
                    <div class="space-y-8 mb-10 w-full">
                        <?php while (have_rows('features')):
                            the_row();
                            $title = get_sub_field('title');
                            $content = get_sub_field('content');
                            ?>
                            <div class="flex gap-4 items-start">
                                <!-- Yellow circle with white checkmark -->
                                <div class="flex-shrink-0 mt-1">
                                    <div class="w-6 h-6 bg-[#FFC700] rounded-full flex items-center justify-center">
                                        <svg class="w-3.5 h-3.5 text-secondary" fill="none" stroke="currentColor"
                                            stroke-width="4.5" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                        </svg>
                                    </div>
                                </div>
                                <div>
                                    <?php if ($title): ?>
                                        <h3 class="text-xl font-bold text-white mb-1.5 leading-snug"><?php echo esc_html($title); ?>
                                        </h3>
                                    <?php endif; ?>
                                    <?php if ($content): ?>
                                        <p class="text-white/85 text-base md:text-lg leading-relaxed">
                                            <?php echo esc_html($content); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <!-- Fallback content if ACF fields are empty -->
                    <div class="space-y-8 mb-10 w-full">
                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 bg-[#FFC700] rounded-full flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-secondary" fill="none" stroke="currentColor"
                                        stroke-width="4.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1.5 leading-snug">Longer Lasting Mental Clarity
                                </h3>
                                <p class="text-white/85 text-base md:text-lg leading-relaxed">Armodafinil is widely known
                                    for its extended duration compared to standard Modafinil. Many users report feeling
                                    focused and mentally switched on for longer periods throughout the day.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 bg-[#FFC700] rounded-full flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-secondary" fill="none" stroke="currentColor"
                                        stroke-width="4.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1.5 leading-snug">Ideal for Busy Australian
                                    Lifestyles</h3>
                                <p class="text-white/85 text-base md:text-lg leading-relaxed">Whether you’re balancing work,
                                    study, business, travel, or demanding schedules, Armodafinil has become increasingly
                                    popular among Australians who need reliable daytime alertness.</p>
                            </div>
                        </div>

                        <div class="flex gap-4 items-start">
                            <div class="flex-shrink-0 mt-1">
                                <div class="w-6 h-6 bg-[#FFC700] rounded-full flex items-center justify-center">
                                    <svg class="w-3.5 h-3.5 text-secondary" fill="none" stroke="currentColor"
                                        stroke-width="4.5" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-white mb-1.5 leading-snug">Trusted by Professionals &
                                    Students</h3>
                                <p class="text-white/85 text-base md:text-lg leading-relaxed">From office workers and
                                    tradies working long shifts to university students preparing for exams, Armodafinil is
                                    often chosen for improved focus and productivity.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Shop Now Button -->
                <?php
                $btn_text = $button_text ? $button_text : 'Shop Now';
                $btn_link = $button_link ? $button_link : '/shop/';
                ?>
                <a href="<?php echo esc_url($btn_link); ?>"
                    class="inline-flex items-center gap-3 bg-[#FFC700] text-primary font-bold py-4 px-8 rounded-lg hover:bg-[#EAA800] transition-colors group shadow-md">
                    <span><?php echo esc_html($btn_text); ?></span>
                    <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                        stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>

            </div>
        </div>
    </div>
</section>
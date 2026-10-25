<?php
/**
 * Layout: Final Thoughts
 * 
 * Expected ACF Fields:
 * - background_image (Image array)
 * - title (Text)
 * - description (Textarea)
 * - list_items (Repeater)
 *   - item_text (Text)
 * - bottom_text (Text)
 * - cta_text (Text)
 * - cta_link (URL)
 */

$bg_image    = get_sub_field('background_image');
$title       = get_sub_field('title');
$description = get_sub_field('description');
$bottom_text = get_sub_field('bottom_text');
$cta_text    = get_sub_field('cta_text');
$cta_link    = get_sub_field('cta_link');

// Use placeholder image if none provided
$bg_url = $bg_image ? esc_url($bg_image['url']) : 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?q=80&w=2070&auto=format&fit=crop';
?>
<section class="relative py-16 lg:py-20 px-6 lg:px-12 overflow-hidden" 
    style="width: 100vw; left: 50%; transform: translateX(-50%);">
    
    <!-- Full width background image -->
    <div class="absolute inset-0 bg-gray-900 bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo $bg_url; ?>');"></div>
    
    <!-- Dark overlay to ensure text readability against the background image -->
    <div class="absolute inset-0 bg-black/80"></div>
    
    <div class="relative z-10 max-w-6xl mx-auto">
        
        <!-- Top Section: Title, Description, and List -->
        <div class="max-w-4xl">
            <?php if ($title): ?>
                <h2 class="text-3xl lg:text-4xl font-bold text-accent mb-4">
                    <?php echo esc_html($title); ?>
                </h2>
            <?php endif; ?>
            
            <?php if ($description): ?>
                <div class="text-white text-base lg:text-lg leading-relaxed mb-8">
                    <?php echo wp_kses_post(nl2br($description)); ?>
                </div>
            <?php endif; ?>
            
            <?php if (have_rows('list_items')): ?>
                <div class="flex flex-col gap-3 mb-4">
                    <?php while (have_rows('list_items')): the_row(); ?>
                        <div class="inline-flex items-center gap-3 w-fit max-w-full">
                            <span class="armo-yellow-tick flex-shrink-0 !m-0 !w-5 !h-5 !bg-[length:60%]"></span>
                            <span class="bg-[#1b4f93]/90 px-3 py-1.5 rounded shadow-sm text-white font-medium text-sm lg:text-base leading-tight">
                                <?php echo esc_html(get_sub_field('item_text')); ?>
                            </span>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Bottom CTA Section -->
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6 pt-4">
            <?php if ($bottom_text): ?>
                <h3 class="text-xl lg:text-2xl font-bold text-white max-w-lg leading-snug">
                    <?php echo esc_html($bottom_text); ?>
                </h3>
            <?php endif; ?>
            
            <?php if ($cta_text && $cta_link): ?>
                <a href="<?php echo esc_url($cta_link); ?>" class="bg-[#ff0000] hover:bg-[#cc0000] text-white font-semibold text-base lg:text-lg px-6 py-4 rounded-lg shadow-lg flex items-center gap-4 transition-colors max-w-sm w-full md:w-auto">
                    <span class="flex-grow leading-tight"><?php echo esc_html($cta_text); ?></span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 flex-shrink-0 font-bold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            <?php endif; ?>
        </div>
        
    </div>
</section>

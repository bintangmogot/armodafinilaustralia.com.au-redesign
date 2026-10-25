<?php
/**
 * Call to Action Button Module
 */

$button_text = get_sub_field('button_text');
$button_link = get_sub_field('button_link');

if (!$button_text) {
    $button_text = 'Click Here';
}
if (!$button_link) {
    $button_link = '#';
}
?>
<section class="pt-8 pb-8 lg:pt-12 lg:pb-12 bg-transparent flex justify-center">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 text-center w-full">
        <!-- Mobile Button Wrapper -->
        <div class="block md:hidden">
            <a href="<?php echo esc_url($button_link); ?>" class="group inline-flex justify-center items-center gap-2 bg-[#FF0000] hover:bg-[#dc0000] text-white font-bold text-base px-4 py-3 rounded-full no-underline transition-all hover:shadow-lg hover:shadow-black/30">
                <span class="whitespace-nowrap"><?php echo esc_html($button_text); ?></span>
                <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 28 28">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <!-- Desktop Button Wrapper -->
        <div class="hidden md:inline-block">
            <a href="<?php echo esc_url($button_link); ?>" class="group inline-flex items-center justify-center gap-2 bg-[#FF0000] hover:bg-[#dc0000] text-white font-bold text-base lg:text-lg px-6 lg:px-10 py-3 lg:py-4 rounded-full no-underline transition-all hover:shadow-lg hover:shadow-black/30">
                <span class="whitespace-nowrap"><?php echo esc_html($button_text); ?></span>
                <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 28 28">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</section>

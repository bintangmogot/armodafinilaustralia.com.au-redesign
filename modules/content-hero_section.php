<?php
/**
 * Hero Section Module Template
 * 
 * Sub Fields: badge, title, subtitle, description, cta_label, cta_url, background_image
 */

$badge = get_sub_field('badge');
$title = get_sub_field('title');
$subtitle = get_sub_field('subtitle');
$description = get_sub_field('description');
$cta_label = get_sub_field('cta_label');
$cta_url = get_sub_field('cta_url');
$bg_image_id = get_sub_field('background_image');

$bg_image_url   = '';
$bg_image_title = '';

if ($bg_image_id) {
    if (is_array($bg_image_id)) {
        $bg_image_url   = $bg_image_id['url'] ?? '';
        $bg_image_title = $bg_image_id['title'] ?? '';
        $att_id         = $bg_image_id['ID'] ?? ($bg_image_id['id'] ?? 0);
    } else {
        $att_id         = (int) $bg_image_id;
        $bg_image_url   = wp_get_attachment_image_url($att_id, 'full');
        $bg_image_title = get_the_title($att_id);
    }
    if (!$bg_image_title && !empty($att_id)) {
        $bg_image_title = get_the_title($att_id);
    }
}
if (!$bg_image_url) {
    $bg_image_url   = get_theme_file_uri('/assets/images/homepage-armodafinil-direct.png');
}
if (!$bg_image_title) {
    $bg_image_title = get_bloginfo('name');
}

$has_text_content = $badge || $title || $subtitle || $description || $cta_label || $cta_url;
?>
<section
    class="relative w-full overflow-hidden bg-[#dffff9] flex items-center min-h-[185px] xs:min-h-[210px] sm:min-h-[300px] md:min-h-[440px] lg:min-h-[500px] group"
    style="background-color: #dffff9;"
    title="<?php echo esc_attr($bg_image_title); ?>">
    <!-- Background Hero Landscape Image -->
    <div class="absolute inset-0 w-full h-full pointer-events-auto cursor-default bg-no-repeat bg-right bg-cover"
        style="background-image: url('<?php echo esc_url($bg_image_url); ?>'); background-position: right center; background-size: cover;"
        title="<?php echo esc_attr($bg_image_title); ?>"
        aria-label="<?php echo esc_attr($bg_image_title); ?>"
        role="img">
    </div>

    <!-- Seamless Left Gradient Blend for Crystal-Clear Legibility -->
    <div
        class="absolute inset-y-0 left-0 w-[52%] sm:w-[48%] md:w-[45%] bg-gradient-to-r from-[#dffff9] via-[#dffff9]/95 to-transparent pointer-events-none z-[1]">
    </div>

    <?php if ($bg_image_title): ?>
    <!-- Media Title Chip on Hover -->
    <div class="absolute bottom-3 right-4 z-[8] hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-900/80 backdrop-blur-sm border border-white/20 text-white text-[11px] font-medium tracking-wide opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none shadow-sm"
        aria-hidden="true">
        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="opacity-75">
            <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
            <circle cx="9" cy="9" r="2"/>
            <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
        </svg>
        <span><?php echo esc_html($bg_image_title); ?></span>
    </div>
    <?php endif; ?>

    <!-- Content Container -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 xs:py-4 sm:py-8 md:py-12 lg:py-16">
        <?php if ($has_text_content): ?>
            <div
                class="w-[48%] xs:w-[47%] sm:w-[46%] md:w-[44%] lg:w-[42%] max-w-xs sm:max-w-md md:max-w-lg lg:max-w-xl text-left animate-fadeup flex flex-col justify-center">

                <?php if ($badge): ?>
                    <div class="mb-1 xs:mb-1.5 sm:mb-2 md:mb-3">
                        <span
                            class="inline-flex items-center gap-1 sm:gap-1.5 text-[7px] xs:text-[8px] sm:text-[11px] md:text-xs font-bold uppercase tracking-[0.08em] sm:tracking-[0.14em] text-brand-800 bg-white/90 backdrop-blur-xs border border-brand-300/60 px-1.5 xs:px-2 sm:px-2.5 md:px-3 py-0.5 sm:py-1 rounded-full shadow-2xs">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24"
                                fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="w-1.5 h-1.5 xs:w-2 xs:h-2 sm:w-3 sm:h-3 text-brand-600 shrink-0">
                                <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2" />
                            </svg>
                            <span class="truncate"><?php echo esc_html($badge); ?></span>
                        </span>
                    </div>
                <?php endif; ?>

                <?php if ($title): ?>
                    <h1
                        class="font-serif text-[11px] xs:text-[13px] sm:text-2xl md:text-3xl lg:text-4xl xl:text-5xl leading-[1.12] sm:leading-[1.1] font-bold text-brand-700 tracking-tight">
                        <?php echo wp_kses_post($title); ?>
                    </h1>
                <?php endif; ?>

                <?php if ($subtitle): ?>
                    <h2
                        class="mt-0.5 xs:mt-1 sm:mt-2 md:mt-3 font-bold text-base md:text-md lg:text-[22px] xl:text-2xl text-brand-700 leading-snug sm:leading-relaxed line-clamp-3 sm:line-clamp-none">
                        <strong><?php echo wp_kses_post($subtitle); ?></strong>
                    </h2>
                <?php endif; ?>

                <?php if ($description): ?>
                    <p
                        class="hidden sm:block mt-1 sm:mt-2 md:mt-3 text-xs md:text-sm lg:text-base text-ink-600 leading-relaxed">
                        <?php echo wp_kses_post($description); ?>
                    </p>
                <?php endif; ?>

                <?php if ($cta_url && $cta_label): ?>
                    <div class="mt-1 xs:mt-1.5 sm:mt-3 md:mt-5">
                        <a href="<?php echo esc_url($cta_url); ?>"
                            class="inline-flex items-center gap-1 sm:gap-2 h-5 xs:h-6 sm:h-9 md:h-11 px-2 xs:px-2.5 sm:px-4 md:px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white text-[7.5px] xs:text-[9px] sm:text-xs md:text-sm font-semibold transition-all shadow-soft hover:shadow-md">
                            <span><?php echo esc_html($cta_label); ?></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"
                                class="w-2 h-2 xs:w-2.5 xs:h-2.5 sm:w-3 sm:h-3 md:w-3.5 md:h-3.5">
                                <path d="M5 12h14" />
                                <path d="m12 5 7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        <?php endif; ?>
    </div>
</section>

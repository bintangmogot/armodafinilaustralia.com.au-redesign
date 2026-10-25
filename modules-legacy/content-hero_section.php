<?php
$image       = get_sub_field('image');
$title       = get_sub_field('title');
$subtitle    = get_sub_field('subtitle');
$tagline     = get_sub_field('tagline');
$button_text = get_sub_field('button_text');
$button_link = get_sub_field('button_link');

// Make the first word of the title yellow
$title_html = '';
if ( $title ) {
    $words = explode( ' ', $title );
    if ( !empty( $words ) ) {
        $words[0] = '<span class="text-accent">' . esc_html($words[0]) . '</span>';
        $title_html = implode( ' ', $words );
    } else {
        $title_html = esc_html($title);
    }
}
?>
<section class="hero relative overflow-hidden md:min-h-[600px] lg:h-[80vh] max-h-[964px]">
    <?php if ($image) : ?>
        <!-- Desktop Image -->
        <img src="<?php echo esc_url($image); ?>" alt="" class="hidden md:block absolute inset-0 w-full h-full object-cover object-bottom">
        <!-- Mobile Image -->
        <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/mobile-hero-image.png" alt="" class="block md:hidden absolute inset-0 w-full h-full object-cover object-right">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark/90 via-primary-dark/20 to-transparent lg:hidden"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/20 to-transparent lg:hidden"></div>
    <?php endif; ?>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 h-full flex items-start lg:items-center min-h-[inherit]">
        <div class="w-full pt-28 pb-6 md:pt-32 md:pb-16 lg:pt-36 lg:pb-20 text-white">
            <div class="w-[70%] sm:w-[80%] md:w-full lg:w-[75%] xl:w-[70%]">
                <?php if ($title_html) : ?>
                    <h1 class="max-w-5xl text-4xl md:text-5xl font-extrabold text-white leading-[1.2] mb-3 lg:mb-4" data-aos="fade-up">
                        <?php echo $title_html; ?>
                    </h1>
                <?php endif; ?>

                <?php if ($subtitle) : ?>
                    <p class="md:w-[80%] lg:w-full text-lg md:text-2xl lg:text-3xl font-semibold text-white/90 leading-snug mb-2 lg:mb-3" data-aos="fade-up" data-aos-delay="100">
                        <?php echo esc_html($subtitle); ?>
                    </p>
                <?php endif; ?>

                <?php if ($tagline) : ?>
                    <p class="text-base lg:text-xl text-accent italic mb-6 lg:mb-8" data-aos="fade-up" data-aos-delay="200">
                        <?php echo esc_html($tagline); ?>
                    </p>
                <?php endif; ?>

                <?php if ( have_rows('features') ) : ?>
                    <ul class="space-y-3 mb-6 lg:mb-8" data-aos="fade-up" data-aos-delay="300">
                        <?php while ( have_rows('features') ) : the_row(); ?>
                            <?php $feature_text = get_sub_field('feature_text'); ?>
                            <?php if ( $feature_text ) : ?>
                                <li class="flex items-center gap-3 text-base lg:text-xl text-white/90">
                                    <img src="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/assets/images/check.png" alt="Check" class="w-6 h-6 flex-shrink-0 object-contain">
                                    <span><?php echo esc_html($feature_text); ?></span>
                                </li>
                            <?php endif; ?>
                        <?php endwhile; ?>
                    </ul>
                <?php endif; ?>
            </div>

            <?php if ($button_text && $button_link) : ?>
                <!-- Mobile Button Wrapper -->
                <div class="mt-5 block md:hidden" data-aos="fade-up" data-aos-delay="400">
                    <a href="<?php echo esc_url($button_link); ?>" class="group inline-flex justify-center items-center gap-2 bg-[#FF0000] hover:bg-[#dc0000] text-white font-bold text-base px-4 py-3 rounded-full no-underline transition-all hover:shadow-lg hover:shadow-black/30">
                        <span class="whitespace-nowrap"><?php echo esc_html($button_text); ?></span>
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 28 28">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
                <!-- Desktop Button Wrapper -->
                <div class="mt-6 hidden md:block" data-aos="fade-up" data-aos-delay="400">
                    <a href="<?php echo esc_url($button_link); ?>" class="group inline-flex items-center gap-2 bg-[#FF0000] hover:bg-[#dc0000] text-white font-bold text-base lg:text-lg px-4 lg:px-8 py-2.5 lg:py-3.5 rounded-full no-underline transition-all hover:shadow-lg hover:shadow-black/30">
                        <span class="whitespace-nowrap"><?php echo esc_html($button_text); ?></span>
                        <svg class="w-5 h-5 flex-shrink-0 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 28 28">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

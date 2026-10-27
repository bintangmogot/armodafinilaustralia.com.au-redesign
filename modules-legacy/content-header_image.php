<?php
$image   = get_sub_field('image');
$content = get_sub_field('content');
?>
<section class="hero relative overflow-hidden md:min-h-[600px] lg:min-h-[800px]">
    <?php if ($image) : ?>
        <img src="<?php echo esc_url($image); ?>" alt="" class="absolute inset-0 w-full h-full object-cover object-right">
        <div class="absolute inset-0 bg-gradient-to-r from-primary-dark/90 via-primary-dark/20 to-transparent lg:hidden"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-primary-dark/20 to-transparent lg:hidden"></div>
    <?php endif; ?>

    <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-12 h-full flex items-end lg:items-center min-h-[inherit]">
        <div class="w-full lg:w-1/2 pt-28 pb-12 md:pt-32 md:pb-16 lg:pt-36 lg:pb-20">
            <?php if ($content) : ?>
                <div class="hero-content"><?php echo armo_content($content); ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>

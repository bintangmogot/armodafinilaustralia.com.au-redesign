<?php
/**
 * Layout: Safety Notice
 * Fields: title (text), content (wysiwyg)
 */
$safety_title = get_sub_field('title') ?: get_sub_field('safety_title'); 
$safety_text = get_sub_field('content') ?: get_sub_field('safety_text');
?>
<?php if ($safety_title || $safety_text) : ?>
<section class="bg-surface py-10 px-6">
    <div class="max-w-5xl mx-auto">
        <div class="flex flex-col items-start gap-1 mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="w-7 h-7 mb-1">
                <path fill="#ffcc00" d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32z"/>
                <path fill="#00125E" d="M232 184v112c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24s-24 10.7-24 24zm24 232a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/>
            </svg>
            <?php if ($safety_title) : ?>
                <h3 class="text-lg md:text-xl font-bold text-primary"><?php echo esc_html($safety_title); ?></h3>
            <?php endif; ?>
        </div>
        <?php if ($safety_text) : ?>
            <div class="text-primary text-base md:text-lg leading-relaxed max-w-4xl prose prose-primary">
                <?php echo armo_content($safety_text); ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

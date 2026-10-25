<?php
/**
 * Layout: Why Choose (actually labeled "Location" in ACF)
 * Fields: intro (wysiwyg), location (repeater: title (text), link (text))
 */
$intro = get_sub_field('intro');
?>
<section class="py-12 px-4 bg-gray-50">
    <div class="max-w-7xl mx-auto">
        <?php if ($intro) : ?>
            <div class="prose prose-lg max-w-4xl mx-auto mb-10"><?php echo armo_content($intro); ?></div>
        <?php endif; ?>
        
        <?php if (have_rows('location')) : ?>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <?php while (have_rows('location')) : the_row();
                    $title = get_sub_field('title');
                    $link  = get_sub_field('link');
                ?>
                    <?php if ($link) : ?>
                        <a href="<?php echo esc_url($link); ?>" class="block bg-white border border-gray-200 rounded-lg p-4 text-center hover:shadow-md hover:border-blue-300 transition-all">
                            <span class="font-medium text-gray-900"><?php echo esc_html($title); ?></span>
                        </a>
                    <?php else : ?>
                        <div class="bg-white border border-gray-200 rounded-lg p-4 text-center">
                            <span class="font-medium text-gray-900"><?php echo esc_html($title); ?></span>
                        </div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ Location module - add locations in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

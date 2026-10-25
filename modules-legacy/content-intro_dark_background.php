<?php
/**
 * Layout: Intro Dark Background
 * TODO: Build this module's design
 */
$content = get_sub_field('content');
?>
<section class="bg-gray-900 text-white py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <?php if ($content) : ?>
            <div class="prose prose-invert"><?php echo armo_content($content); ?></div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ Intro Dark Background module - add content in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

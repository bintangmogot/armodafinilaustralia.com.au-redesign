<?php
/**
 * Layout: Intro Black Background
 * TODO: Build this module's design
 */
$content = get_sub_field('content');
?>
<section class="bg-black text-white py-16 px-4">
    <div class="max-w-4xl mx-auto">
        <?php if ($content) : ?>
            <div class="prose prose-invert"><?php echo armo_content($content); ?></div>
        <?php else : ?>
        <?php endif; ?>
    </div>
</section>

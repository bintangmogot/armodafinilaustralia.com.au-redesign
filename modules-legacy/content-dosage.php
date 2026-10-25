<?php
/**
 * Layout: Dosage
 * Fields: intro (wysiwyg), dosage (repeater: title (text), amount (text), content (textarea), recommend (true_false))
 */
$intro = get_sub_field('intro');
?>
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <?php if ($intro) : ?>
            <div class="prose prose-lg mb-10"><?php echo armo_content($intro); ?></div>
        <?php endif; ?>
        
        <?php if (have_rows('dosage')) : ?>
            <div class="space-y-4">
                <?php while (have_rows('dosage')) : the_row();
                    $title     = get_sub_field('title');
                    $amount    = get_sub_field('amount');
                    $content   = get_sub_field('content');
                    $recommend = get_sub_field('recommend');
                ?>
                    <div class="border rounded-lg p-5 <?php echo $recommend ? 'border-blue-400 bg-surface ring-2 ring-blue-200' : 'border-gray-200 bg-white'; ?>">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="font-semibold text-gray-900 text-lg"><?php echo esc_html($title); ?></h3>
                            <?php if ($recommend) : ?>
                                <span class="bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">RECOMMENDED</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($amount) : ?>
                            <p class="text-blue-600 font-medium mb-2"><?php echo esc_html($amount); ?></p>
                        <?php endif; ?>
                        <?php if ($content) : ?>
                            <p class="text-gray-600 text-base"><?php echo esc_html($content); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <p class="text-gray-400 text-center italic">[ Dosage module - add dosage info in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

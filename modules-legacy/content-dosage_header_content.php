<?php
/**
 * Layout: Dosage Header Content
 */
$content = get_sub_field('content');
?>
<section class="py-12 px-4 bg-surface">
    <div class="max-w-4xl mx-auto prose prose-lg">
        <?php echo $content ? armo_content($content) : ''; ?>
    </div>
</section>

<?php
/**
 * Layout: Video
 * Fields: video (file, return=array), content (wysiwyg)
 */
$video   = get_sub_field('video');   // Returns array with url, filename, etc.
$content = get_sub_field('content');
?>
<section class="py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <?php if ($video) : ?>
            <div class="aspect-video rounded-lg overflow-hidden shadow-lg mb-6">
                <video controls class="w-full h-full object-cover" preload="metadata">
                    <source src="<?php echo esc_url($video['url']); ?>" type="<?php echo esc_attr($video['mime_type']); ?>">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endif; ?>
        
        <?php if ($content) : ?>
            <div class="prose prose-lg max-w-3xl mx-auto"><?php echo armo_content($content); ?></div>
        <?php endif; ?>
        
        <?php if (!$video && !$content) : ?>
            <p class="text-gray-400 text-center italic">[ Video module - upload a video file in ACF ]</p>
        <?php endif; ?>
    </div>
</section>

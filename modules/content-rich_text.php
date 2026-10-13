<?php
$content = get_sub_field('content');
$width = get_sub_field('width') ?: 'default';

if ( ! $content ) return;

$max_width_class = 'max-w-7xl'; // default
if ( $width === 'narrow' ) {
    $max_width_class = 'max-w-4xl';
} elseif ( $width === 'full' ) {
    $max_width_class = 'w-full';
}
?>
<section class="py-12 md:py-16 bg-white">
    <div class="<?php echo esc_attr($max_width_class); ?> mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose max-w-none prose-ink prose-brand prose-a:text-brand-600 hover:prose-a:text-brand-700 mx-auto">
            <?php echo wp_kses_post($content); ?>
        </div>
    </div>
</section>

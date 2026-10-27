<?php
// We fetch the custom data input by the client in the Classic Editor
$title       = get_sub_field('hero_title');
$description = get_sub_field('hero_description');
$bg_image    = get_sub_field('hero_background');
?>

<!-- Now write pure HTML combined with your Tailwind CSS styles -->
<section class="relative bg-cover bg-center py-24 px-6 md:px-12 text-white" style="background-image: url('<?php echo esc_url($bg_image); ?>');">
    <div class="max-w-4xl mx-auto text-center bg-black/50 p-8 rounded-lg backdrop-blur-sm">
        <h1 class="text-4xl md:text-6xl font-bold tracking-tight mb-4"><?php echo esc_html($title); ?></h1>
        <p class="text-lg md:text-xl text-gray-200"><?php echo esc_html($description); ?></p>
    </div>
</section>
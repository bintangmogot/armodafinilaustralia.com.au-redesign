<?php
/**
 * Layout: Info With Image
 * Fields: image (image), content (wysiwyg)
 * Design: Image pulled left, light blue background extending to the right, custom green checkmarks for lists.
 */
$image = get_sub_field('image');
$content = get_sub_field('content');
?>
<section class="py-5 lg:py-16 relative overflow-hidden bg-white">
    <!-- Light Blue Background extending to the right edge of the screen -->
    <div
        class="absolute bottom-0 left-0 right-0 top-32 md:top-0 md:bottom-0 md:left-auto md:right-0 md:w-5/6 lg:w-3/4 bg-surface z-0">
    </div>

    <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="flex flex-col md:flex-row items-start gap-6 lg:gap-12">

            <!-- Image Side -->
            <div class="w-full md:w-1/2 lg:w-5/12">
                <?php
                $image_url = '';
                if ($image) {
                    if (is_array($image) && isset($image['url'])) {
                        $image_url = $image['url'];
                    } elseif (is_numeric($image)) {
                        $image_url = wp_get_attachment_image_url($image, 'large');
                    } elseif (is_string($image)) {
                        $image_url = $image;
                    }
                }
                ?>
                <?php if ($image_url): ?>
                    <img src="<?php echo esc_url($image_url); ?>" alt=""
                        class="w-full h-auto object-cover rounded-2xl shadow-xl">
                <?php else: ?>
                    <div
                        class="bg-gray-200 rounded-2xl h-[400px] flex items-center justify-center text-gray-500 italic shadow-xl">
                        [ Image - add in ACF ]
                    </div>
                <?php endif; ?>
            </div>

            <!-- Text Content Side -->
            <div class="w-full md:w-1/2 lg:w-7/12 py-6 pb-3 md:py-0">
                <div
                    class="module-info-content prose prose-lg md:prose-xl text-[#2A3342] max-w-none leading-relaxed text-lg [&_h1]:text-3xl [&_h2]:text-3xl [&_h3]:text-3xl">
                    <?php if ($content): ?>
                        <?php echo armo_content($content); ?>
                    <?php else: ?>
                        <h2 class="text-primary font-bold text-4xl">What Is Armodafinil?</h2>
                        <p>Armodafinil is a popular wakefulness-support medication commonly used by adults looking to
                            improve alertness, focus, concentration, and mental performance during long working hours or
                            demanding schedules.</p>
                        <p>Many Australians choose Armodafinil because it is known for:</p>
                        <ul>
                            <li>Long-lasting wakefulness support</li>
                            <li>Smoother focus throughout the day</li>
                            <li>Reduced mental fatigue</li>
                            <li>Improved productivity</li>
                            <li>Better concentration during study or work</li>
                        </ul>
                        <p>Armodafinil is commonly preferred by professionals, shift workers, university students, business
                            owners, remote workers, gamers, developers, and creatives who need sustained mental clarity
                            without the heavy crash associated with traditional stimulants.</p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</section>

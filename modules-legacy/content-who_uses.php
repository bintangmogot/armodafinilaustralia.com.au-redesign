<?php
/**
 * Layout: Who Uses Armodafinil
 * Fields: heading (text), intro (wysiwyg), users (repeater: title (text), description (textarea), image (image))
 * Design: Solid blue background, grid of light blue cards (4 cols on desktop, 2 cols on mobile) with white borders.
 */

$heading = get_sub_field('heading');
$intro   = get_sub_field('intro');
?>
<section class="py-16 px-6 lg:px-12 bg-gradient-review text-white">
    <div class="max-w-7xl mx-auto">
        
        <!-- Section Header -->
        <div class="max-w-3xl mb-5 md:mb-6">
            <?php if ($heading) : ?>
                <h2 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                    <?php echo esc_html($heading); ?>
                </h2>
            <?php else : ?>
                <h2 class="text-3xl lg:text-4xl font-bold mb-4 leading-tight">
                    Who Uses Armodafinil in Australia?
                </h2>
            <?php endif; ?>

            <?php if ($intro) : ?>
                <div class="module-who-uses-content text-white text-opacity-90 leading-relaxed max-w-none">
                    <?php echo armo_content($intro); ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Cards Grid -->
        <?php if (have_rows('users')) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <?php while (have_rows('users')) : the_row(); 
                    $title       = get_sub_field('title');
                    $description = get_sub_field('description') ?: (get_sub_field('text') ?: get_sub_field('content'));
                    $image       = get_sub_field('image');

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
                    <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg hover:shadow-white/5 hover:scale-[1.02] transition-all duration-300">
                        <?php if ($image_url) : ?>
                            <div class="w-full aspect-[4/3] overflow-hidden rounded-xl bg-primary/5">
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-cover">
                            </div>
                        <?php else : ?>
                            <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">
                                [ Add Image ]
                            </div>
                        <?php endif; ?>

                        <div class="flex flex-col gap-2 flex-grow">
                            <?php if ($title) : ?>
                                <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">
                                    <?php echo esc_html($title); ?>
                                </h3>
                            <?php endif; ?>
                            
                            <?php if ($description) : ?>
                                <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">
                                    <?php echo esc_html($description); ?>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <!-- Fallback content if ACF fields are empty -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                
                <!-- Card 1 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Shift Workers & Emergency Staff</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Nurses, emergency doctors, paramedics, and rotating shift workers staying sharp during irregular hours.</p>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">FIFO & Mine Workers</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Fly-in fly-out personnel managing long shifts, roster rotations, and harsh operational conditions.</p>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Business Owners & Executives</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Entrepreneurs and corporate leaders requiring sustained cognitive clarity and strategic decision making.</p>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">University & Postgraduate Students</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Academics tackling intensive research, thesis writing, and heavy examination study schedules.</p>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Designers & Creatives</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Visual artists, architects, and copywriters working through intense creative bursts and deadlines.</p>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Long-Distance Truck Drivers</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Interstate transport drivers maintaining unwavering road vigilance and concentration on long routes.</p>
                    </div>
                </div>

                <!-- Card 7 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Remote & Digital Workers</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Global freelancers and remote contractors coordinating across multiple international time zones.</p>
                    </div>
                </div>

                <!-- Card 8 -->
                <div class="bg-surface-dark border-2 border-white rounded-2xl p-4 md:p-5 flex flex-col gap-3 text-primary shadow-lg">
                    <div class="w-full aspect-[4/3] bg-primary/10 rounded-xl flex items-center justify-center text-primary/40 italic text-xs">[ Image ]</div>
                    <div class="flex flex-col gap-2 flex-grow">
                        <h3 class="text-base md:text-lg font-bold leading-snug text-primary text-center">Software Developers & Engineers</h3>
                        <p class="text-xs md:text-sm text-primary/80 leading-relaxed text-center">Programmers seeking deep work flow states for complex problem-solving and bug fixing sprints.</p>
                    </div>
                </div>

            </div>
        <?php endif; ?>

    </div>
</section>

<style>
.module-who-uses-content p {
    color: rgba(255, 255, 255, 0.8) !important;
}
</style>

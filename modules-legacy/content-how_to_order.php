<?php
/**
 * Layout: How to Order
 * Fields: heading (text), steps (repeater: title, description), safety_title (text), safety_text (wysiwyg)
 */

$heading = get_sub_field('heading');
$safety_title = get_sub_field('safety_title');
$safety_text = get_sub_field('safety_text');
?>
<?php if (have_rows('steps') || $heading || $safety_text) : ?>
<section class="bg-white">
    <div class="max-w-7xl mx-auto px-6 pb-12 lg:pb-20">
        
        <?php if ($heading) : ?>
            <h2 class="text-2xl md:text-3xl font-bold text-center text-primary mb-12">
                <?php echo esc_html($heading); ?>
            </h2>
        <?php endif; ?>

        <?php if (have_rows('steps')) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-12">
                <?php 
                $count = 1;
                while (have_rows('steps')) : the_row(); 
                    $title = get_sub_field('title');
                    $description = get_sub_field('description');
                    if (!$title && !$description) continue;
                ?>
                    <div class="relative bg-gradient-review rounded-xl shadow-lg pt-10 pb-6 px-4 text-center">
                        <div class="absolute -top-6 left-1/2 -translate-x-1/2 w-16 h-16 bg-accent rounded-full flex items-center justify-center text-primary text-xl font-bold shadow-md">
                            <?php echo $count; ?>
                        </div>
                        <h3 class="text-white text-lg md:text-xl font-semibold mb-3">
                            <?php echo esc_html($title); ?>
                        </h3>
                        <p class="text-white/90 text-base md:text-lg leading-relaxed">
                            <?php echo esc_html($description); ?>
                        </p>
                    </div>
                <?php 
                $count++;
                endwhile; ?>
            </div>
        <?php endif; ?>

    </div>


</section>
<?php endif; ?>

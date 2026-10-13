<?php
/**
 * How It Works Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, steps
 */

$title = get_sub_field('title') ?: 'How it works';
$subtitle = get_sub_field('subtitle') ?: 'A gentle, predictable curve across your day.';
$steps = get_sub_field('steps');

if ( empty( $steps ) ) {
    $steps = array(
        array('step_number' => 1, 'time' => '15–30 mins', 'title' => 'Rapid Absorption', 'desc' => 'Fast-acting profile begins its work within the first half hour of the dose.'),
        array('step_number' => 2, 'time' => '1–2 hours', 'title' => 'Neural Activation', 'desc' => 'Supports dopamine and norepinephrine pathways for cleaner cognitive throughput.'),
        array('step_number' => 3, 'time' => '2–4 hours', 'title' => 'Peak Focus', 'desc' => 'Attention and mental stamina reach their strongest window.'),
        array('step_number' => 4, 'time' => '12+ hours', 'title' => 'Extended Clarity', 'desc' => 'Comfortable mental energy through the rest of the day — no abrupt drop.'),
    );
}
?>

<section class="py-16 md:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        
        <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ( $steps as $h ) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 hover-lift relative shadow-sm">
                <div class="w-10 h-10 rounded-full bg-brand-600 text-white grid place-items-center font-semibold text-lg"><?php echo esc_html($h['step_number']); ?></div>
                <div class="mt-4 text-[11px] uppercase tracking-widest font-semibold text-ink-500"><?php echo esc_html($h['time']); ?></div>
                <h3 class="mt-1 font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($h['title']); ?></h3>
                <p class="mt-2 text-sm text-ink-700 leading-relaxed"><?php echo esc_html($h['desc']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

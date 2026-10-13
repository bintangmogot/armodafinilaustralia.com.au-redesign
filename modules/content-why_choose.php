<?php
/**
 * Why Choose Module Template
 * 
 * Data provided by ACF Sub Fields: title, features
 */

$title = get_sub_field('title') ?: 'Why high-achievers choose us';
$features = get_sub_field('features');

// Fallback dummy data if none exist
if ( empty( $features ) ) {
    $features = array(
        array(
            'icon' => 'ShieldCheck',
            'title' => 'Pharmaceutical Grade',
            'desc' => 'Verified sourcing, transparent product notes, and a supply chain focused on integrity.',
            'tag' => 'Clinically informed'
        ),
        array(
            'icon' => 'FlaskConical',
            'title' => 'Evidence-Led',
            'desc' => 'Backed by peer-reviewed studies on wakefulness and sustained cognition.',
            'tag' => 'Research aligned'
        ),
        array(
            'icon' => 'Lock',
            'title' => 'Private & Safe',
            'desc' => 'Neutral packaging and encrypted checkout keep your details confidential.',
            'tag' => 'Confidential'
        )
    );
}
?>

<section class="py-16 md:py-20 bg-stone-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        
        <div class="mt-10 grid md:grid-cols-3 gap-5">
            <?php foreach ( $features as $f ) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-7 hover-lift text-center shadow-sm">
                <div class="mx-auto w-14 h-14 rounded-2xl bg-brand-100 text-brand-700 grid place-items-center mb-5">
                    <?php if ( strtolower($f['icon']) === 'flaskconical' || strtolower($f['icon']) === 'flask' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-flask-conical w-6 h-6"><path d="M10 2v7.31"/><path d="M14 9.3V1.99"/><path d="M8.5 2h7"/><path d="M14 9.3a6.5 6.5 0 1 1-4 0"/><path d="M5.52 16h12.96"/></svg>
                    <?php elseif ( strtolower($f['icon']) === 'lock' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-6 h-6"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                    <?php else : // default to ShieldCheck ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-6 h-6"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg>
                    <?php endif; ?>
                </div>
                <h3 class="font-serif text-xl font-semibold text-ink-900"><?php echo esc_html($f['title']); ?></h3>
                <p class="mt-2 text-sm text-ink-700 leading-relaxed"><?php echo esc_html($f['desc']); ?></p>
                <?php if ( !empty($f['tag']) ) : ?>
                <span class="mt-4 inline-block text-[11px] uppercase tracking-widest font-semibold text-brand-700 bg-brand-100 rounded-full px-3 py-1">
                    <?php echo esc_html($f['tag']); ?>
                </span>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
/**
 * Audience Grid Module Template
 * 
 * Data provided by ACF Sub Fields: title, subtitle, audiences
 */

$title = get_sub_field('title') ?: 'Built for your goals';
$subtitle = get_sub_field('subtitle') ?: 'Choose the profile that fits your day — we’ll guide the rest.';
$audiences = get_sub_field('audiences');

if ( empty( $audiences ) ) {
    $audiences = array(
        array('icon' => 'GraduationCap', 'title' => 'Students & Learners', 'desc' => 'Sit longer sessions with clean, comfortable focus during exams and deep-work blocks.', 'badge' => '12-hour focused learning', 'cta_text' => 'For Students', 'cta_url' => '/product'),
        array('icon' => 'Briefcase', 'title' => 'Busy Professionals', 'desc' => 'Handle back-to-back meetings and complex tasks with steadier mental energy.', 'badge' => 'All-day mental clarity', 'cta_text' => 'For Professionals', 'cta_url' => '/product'),
        array('icon' => 'Moon', 'title' => 'Shift Workers & Night Owls', 'desc' => 'Stay alert through irregular hours without the mid-shift dip in performance.', 'badge' => 'Fatigue-resistant', 'cta_text' => 'For Shift Workers', 'cta_url' => '/product'),
        array('icon' => 'Gamepad2', 'title' => 'Competitive Players', 'desc' => 'Sharper reactions and cleaner concentration when every decision counts.', 'badge' => 'Faster reaction time', 'cta_text' => 'For Competitors', 'cta_url' => '/product'),
    );
}
?>

<section class="py-16 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl md:text-4xl font-serif font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
        <p class="mt-2 text-center text-ink-500"><?php echo esc_html($subtitle); ?></p>
        
        <div class="mt-10 grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
            <?php foreach ( $audiences as $a ) : ?>
            <div class="group bg-white border border-ink-200 rounded-2xl p-6 hover-lift flex flex-col shadow-sm">
                <div class="w-11 h-11 rounded-xl bg-brand-100 text-brand-700 grid place-items-center mb-4">
                    <?php if ( strtolower($a['icon']) === 'graduationcap' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-graduation-cap w-5 h-5"><path d="M21.42 10.922a2 2 0 0 0-.019-3.838L12.83 4.3a2 2 0 0 0-1.66 0L2.6 7.08a2 2 0 0 0 0 3.832l8.57 3.208a2 2 0 0 0 1.66 0z"/><path d="M22 10v6"/><path d="M6 12.5V16a6 3 0 0 0 12 0v-3.5"/></svg>
                    <?php elseif ( strtolower($a['icon']) === 'briefcase' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-briefcase w-5 h-5"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                    <?php elseif ( strtolower($a['icon']) === 'moon' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-moon w-5 h-5"><path d="M12 3a6 6 0 0 0 9 9 9 9 0 1 1-9-9Z"/></svg>
                    <?php elseif ( strtolower($a['icon']) === 'gamepad2' ) : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-gamepad-2 w-5 h-5"><line x1="6" x2="10" y1="12" y2="12"/><line x1="8" x2="8" y1="10" y2="14"/><line x1="15" x2="15.01" y1="13" y2="13"/><line x1="18" x2="18.01" y1="11" y2="11"/><rect width="20" height="12" x="2" y="6" rx="2"/></svg>
                    <?php else : ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-user w-5 h-5"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <?php endif; ?>
                </div>
                <h3 class="font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($a['title']); ?></h3>
                <p class="mt-2 text-sm text-ink-700 leading-relaxed flex-1"><?php echo esc_html($a['desc']); ?></p>
                <div class="mt-4 text-xs font-semibold text-brand-700 bg-brand-50 rounded-full px-3 py-1.5 self-start"><?php echo esc_html($a['badge']); ?></div>
                <?php if ( !empty($a['cta_url']) ) : ?>
                <a href="<?php echo esc_url($a['cta_url']); ?>" class="mt-5 text-sm font-semibold text-ink-900 inline-flex items-center gap-1.5 group-hover:text-brand-700 transition-colors">
                    <?php echo esc_html($a['cta_text']); ?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

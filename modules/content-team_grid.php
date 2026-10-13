<?php
$title = get_sub_field('title');
$team = get_sub_field('team');
if (!empty($team)) :
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-16">
    <?php if ($title) : ?>
        <h2 class="font-serif text-3xl md:text-4xl font-semibold text-ink-900 text-center"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>
    
    <div class="mt-10 grid md:grid-cols-3 gap-5">
        <?php foreach ($team as $t) : 
            $initials = '';
            $parts = explode(' ', trim($t['name']));
            if (count($parts) >= 2) {
                $initials = strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
            } elseif (count($parts) == 1) {
                $initials = strtoupper(substr($parts[0], 0, 2));
            }
        ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 text-center hover-lift">
                <div class="w-16 h-16 rounded-full bg-brand-100 text-brand-700 grid place-items-center mx-auto font-serif text-2xl font-semibold">
                    <?php echo esc_html($initials); ?>
                </div>
                <h3 class="mt-4 font-serif text-lg font-semibold text-ink-900"><?php echo esc_html($t['name']); ?></h3>
                <div class="text-xs uppercase tracking-widest text-brand-700 font-semibold"><?php echo esc_html($t['role']); ?></div>
                <p class="mt-2 text-sm text-ink-700"><?php echo esc_html($t['bio']); ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

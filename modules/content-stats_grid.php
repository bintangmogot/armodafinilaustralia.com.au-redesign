<?php
$stats = get_sub_field('stats');
if (!empty($stats)) :
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <?php foreach ($stats as $s) : ?>
            <div class="bg-white border border-ink-200 rounded-2xl p-6 text-center">
                <div class="font-serif text-3xl font-semibold text-ink-900"><?php echo esc_html($s['n']); ?></div>
                <div class="mt-1 text-xs uppercase tracking-widest text-ink-500"><?php echo esc_html($s['l']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

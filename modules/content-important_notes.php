<?php
/**
 * Page Module: Important Usage & Disclaimer
 */

$important_note = get_sub_field('important_usage_note');
$disclaimer = get_sub_field('medical_disclaimer_text');
$doctor_id = get_sub_field('medical_reviewer_post') ?: get_field('medical_reviewer_post', get_the_ID());
if ($doctor_id) {
    $reviewed_by = get_the_title($doctor_id);
    $rev_url = get_permalink($doctor_id);
    $rev_title = get_field('medical_title', $doctor_id) ?: 'Physician';
} else {
    $reviewed_by = get_sub_field('medically_reviewed_by');
    $rev_url = get_sub_field('reviewer_url');
    $rev_title = 'Physician';
}
if (!$important_note) {
    $important_note = get_field('usage_note_text', 'option');
    if (!$important_note) {
        $important_note = '{product_name} is a Schedule 4 (prescription-only) medicine in Australia. Effects, dosage, and possible side effects can differ from person to person. Taking this medicine without a doctor\'s advice may be harmful. This website does not encourage self-medication. For official Australian prescription-medicine guidance, see the <a href="https://www.tga.gov.au/" target="_blank" rel="noopener" class="text-brand-700 hover:underline">Therapeutic Goods Administration (TGA)</a>.';
    }
}
if (!$disclaimer) {
    $disclaimer = get_field('informational_warning_text', 'option');
    if (!$disclaimer) {
        $disclaimer = 'This website is for informational purposes only and does not constitute medical advice. Always consult a qualified healthcare professional before starting, stopping, or changing any medication. <a href="/medical-disclaimer" class="font-semibold text-brand-800 hover:underline">Read our full medical disclaimer.</a>';
    }
}


$product_name = '';
if (is_product()) {
    global $product;
    if ($product) {
        $product_name = $product->get_name();
    }
} else {
    $product_name = get_the_title();
}

$important_note = str_replace('{product_name}', '<span class="font-semibold">' . esc_html($product_name) . '</span>', $important_note);
?>
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="space-y-4">
        <!-- Important Usage Note -->
        <div class="rounded-xl border border-amber-200 bg-amber-50 p-4 sm:p-5 flex items-start gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-alert text-amber-600 shrink-0 mt-0.5"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            <div>
                <h4 class="font-bold text-amber-900 text-sm mb-1">Important Usage Note</h4>
                <div class="text-[13px] text-amber-900/90 leading-relaxed [&_a]:text-brand-700 [&_a]:hover:underline [&_a]:font-semibold">
                    <?php echo wp_kses_post($important_note); ?>
                </div>
            </div>
        </div>

        <!-- Informational Disclaimer -->
        <div class="rounded-xl border border-slate-200 bg-slate-50 p-4 sm:p-5 flex items-start gap-3 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-triangle-alert text-brand-700 shrink-0 mt-0.5"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
            <div>
                <div class="text-[13px] text-slate-700 leading-relaxed [&_a]:text-brand-800 [&_a]:hover:underline [&_a]:font-semibold">
                    <?php echo wp_kses_post($disclaimer); ?>
                </div>
            </div>
        </div>
        
        <!-- Medically reviewed by -->
          <?php if (!empty($reviewed_by)): ?>
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs text-slate-500 pt-2 px-1">
                <div>Medically reviewed by: <a href="<?php echo esc_url($rev_url ? $rev_url : '#'); ?>" class="font-semibold text-teal-700 hover:text-teal-800 hover:underline"><?php echo esc_html($reviewed_by); ?></a> (<?php echo esc_html($rev_title); ?>)</div>
                <div>Last updated: <?php echo date('F Y'); ?></div>
            </div>
            <?php endif; ?>
    </div>
</div>









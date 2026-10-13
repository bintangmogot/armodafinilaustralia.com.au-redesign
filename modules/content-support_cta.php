<?php
$title = get_sub_field('title') ?: 'Prefer help while you order?';
$desc = get_sub_field('desc') ?: 'Our support team answers WhatsApp and email during Australian business hours — usually within minutes.';
$chat_btn_text = get_sub_field('chat_btn_text') ?: 'Chat now';
$chat_btn_url = get_sub_field('chat_btn_url') ?: '#';
$chat_btn_url = str_replace('wa.me/', 'api.whatsapp.com/send?phone=', $chat_btn_url);
$email_btn_text = get_sub_field('email_btn_text') ?: 'Email us';
$email_btn_url = get_sub_field('email_btn_url') ?: 'mailto:support@armodafinilaustralia.com.au';
?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-6 pb-16">
    <div class="p-6 md:p-8 rounded-2xl bg-white border border-ink-200 flex items-start gap-4 flex-wrap shadow-soft">
        <div class="w-11 h-11 rounded-xl bg-brand-100 text-brand-700 grid place-items-center shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-5 h-5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
        </div>
        <div class="flex-1 min-w-[220px]">
            <h3 class="font-serif text-xl font-semibold text-ink-900"><?php echo esc_html($title); ?></h3>
            <p class="mt-1 text-sm text-ink-700"><?php echo esc_html($desc); ?></p>
        </div>
        <?php if ( $chat_btn_text ) : ?>
        <a href="<?php echo esc_url($chat_btn_url); ?>" class="inline-flex items-center gap-2 h-11 px-5 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg>
            <?php echo esc_html($chat_btn_text); ?>
        </a>
        <?php endif; ?>
        
        <?php if ( $email_btn_text ) : ?>
        <a href="<?php echo esc_url($email_btn_url); ?>" class="inline-flex items-center gap-2 h-11 px-5 rounded-full border border-ink-200 hover:border-brand-500 text-ink-900 font-semibold transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            <?php echo esc_html($email_btn_text); ?>
        </a>
        <?php endif; ?>
    </div>
</div>

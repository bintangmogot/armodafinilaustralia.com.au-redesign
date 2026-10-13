<?php
/**
 * Login Form
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

do_action( 'woocommerce_before_customer_login_form' ); ?>

<div class="max-w-md mx-auto py-12 px-4 sm:px-6">
    <div class="mb-6">
        <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="inline-flex items-center text-ink-500 hover:text-ink-900 transition-colors font-medium text-sm gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
            Back to shop
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-soft border border-ink-200 p-8 sm:p-10 text-center relative overflow-hidden">
        
        <!-- Icon -->
        <div class="w-16 h-16 bg-brand-50 rounded-2xl border border-brand-100 flex items-center justify-center mx-auto mb-6 text-brand-600 shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
        </div>

        <h1 class="font-serif text-3xl font-bold text-ink-900 mb-2">Sign in</h1>
        <p class="text-ink-500 mb-6">Magic link to your inbox. No password needed.</p>

        <div class="flex items-center justify-center gap-4 mb-8">
            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-ink-600 bg-ink-50 px-2.5 py-1 rounded-md border border-ink-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                Secure
            </span>
            <span class="inline-flex items-center gap-1.5 text-xs font-medium text-ink-600 bg-ink-50 px-2.5 py-1 rounded-md border border-ink-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Passwordless
            </span>
        </div>

        <form id="magic-link-form" class="text-left" method="post">
            <div class="mb-4">
                <label for="magic_email" class="block text-sm font-semibold text-ink-900 mb-1.5">Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-ink-400">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                    </div>
                    <input type="email" name="email" id="magic_email" required class="block w-full pl-10 pr-3 py-3 border border-ink-200 rounded-xl text-ink-900 focus:ring-2 focus:ring-brand-600/20 focus:border-brand-600 outline-none transition-all" placeholder="your@email.com">
                </div>
            </div>

            <div id="magic-message" class="hidden mb-4 text-sm px-4 py-3 rounded-lg font-medium"></div>

            <button type="submit" id="magic-btn" class="w-full bg-brand-600 hover:bg-brand-700 text-white font-semibold py-3.5 px-4 rounded-xl shadow-sm transition-colors flex items-center justify-center gap-2">
                <span>Send magic link</span>
            </button>
            <?php wp_nonce_field( 'magic_link_nonce', 'magic_security' ); ?>
        </form>

        <div class="mt-8 pt-6 border-t border-ink-100 flex items-center justify-center gap-4 text-sm text-ink-500">
            <a href="mailto:<?php echo esc_attr(get_field('support_email', 'option') ?: 'support@armodafinil-australia-direct.com'); ?>" class="hover:text-brand-600 transition-colors">Need help?</a>
            <span class="text-ink-300">&bull;</span>
            <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="hover:text-brand-600 transition-colors">Shop as guest</a>
        </div>
    </div>
    
    <p class="text-center text-ink-400 text-xs mt-6">
        Armodafinil Australia. Discreet delivery Australia-wide.
    </p>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById('magic-link-form');
    var btn = document.getElementById('magic-btn');
    var msg = document.getElementById('magic-message');

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        var email = document.getElementById('magic_email').value;
        var security = document.querySelector('input[name="magic_security"]').value;
        
        // Disable button and show loading state
        btn.disabled = true;
        btn.style.opacity = '0.7';
        btn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Sending...';
        msg.classList.add('hidden');

        var formData = new FormData();
        formData.append('action', 'request_magic_link');
        formData.append('email', email);
        formData.append('security', security);

        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            msg.classList.remove('hidden', 'bg-red-50', 'text-red-600', 'border-red-100', 'bg-brand-50', 'text-brand-700', 'border-brand-100');
            msg.classList.add('border');
            
            if (data.success) {
                msg.classList.add('bg-brand-50', 'text-brand-700', 'border-brand-100');
                msg.innerHTML = '<div class="flex gap-2"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg> Check your inbox! We sent a secure link to log in.</div>';
                btn.innerHTML = 'Sent!';
            } else {
                msg.classList.add('bg-red-50', 'text-red-600', 'border-red-100');
                msg.innerHTML = data.data || 'Something went wrong. Please try again.';
                btn.disabled = false;
                btn.style.opacity = '1';
                btn.innerHTML = 'Send magic link';
            }
        })
        .catch(error => {
            msg.classList.remove('hidden');
            msg.classList.add('bg-red-50', 'text-red-600', 'border-red-100', 'border');
            msg.innerText = 'Network error. Please try again.';
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.innerHTML = 'Send magic link';
        });
    });
});
</script>

<?php do_action( 'woocommerce_after_customer_login_form' ); ?>

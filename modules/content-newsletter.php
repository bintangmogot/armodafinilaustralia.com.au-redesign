<?php
/**
 * Newsletter Module Template
 */

$title = get_sub_field('title') ?: 'Stay in the loop';
$subtitle = get_sub_field('subtitle') ?: 'Focus tips, dosage explainers, and exclusive Australian-only offers — straight to your inbox. Unsubscribe anytime.';
$shortcode = get_sub_field('shortcode');
?>

<section class="py-16 md:py-20">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-ink-900 text-white p-8 md:p-12 relative overflow-hidden shadow-2xl">
            <!-- Glow effect -->
            <div class="absolute -top-20 -right-20 w-72 h-72 rounded-full bg-brand-600/30 blur-3xl"></div>
            
            <div class="relative">
                <h2 class="font-serif text-3xl md:text-4xl font-semibold"><?php echo esc_html($title); ?></h2>
                <p class="mt-2 text-ink-100/70 max-w-xl"><?php echo esc_html($subtitle); ?></p>
                
                <div class="mt-6 max-w-lg">
                    <?php if ( $shortcode ) : ?>
                        <?php echo do_shortcode($shortcode); ?>
                    <?php else : ?>
                        <!-- Fallback visual form if no shortcode provided -->
                        <form class="flex flex-col sm:flex-row gap-3">
                            <input type="email" required placeholder="your@email.com" class="flex-1 h-12 rounded-full bg-white/10 border border-white/20 px-5 text-white placeholder:text-white/50 outline-none focus:border-brand-300 transition-colors" />
                            <button type="button" class="inline-flex items-center justify-center gap-2 h-12 px-6 rounded-full bg-brand-600 hover:bg-brand-700 font-semibold transition-colors">
                                Subscribe 
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-send w-4 h-4"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
                
                <p class="mt-4 text-xs text-white/50">Protected by reCAPTCHA. No spam, ever.</p>
            </div>
        </div>
    </div>
</section>

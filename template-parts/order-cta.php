<?php
/**
 * Order CTA template part (used in archives and single posts)
 */
?>
<section class="py-14 md:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 bg-white border border-ink-200 rounded-2xl p-8 md:p-10 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-brand-100 blur-3xl" aria-hidden="true"></div>
                <div class="relative">
                    <span class="text-xs uppercase tracking-widest font-semibold text-brand-700">Get started</span>
                    <h2 class="mt-2 font-serif text-3xl md:text-4xl font-semibold text-ink-900">Ready to order with confidence?</h2>
                    <p class="mt-3 text-ink-700 max-w-xl">Pick your pack size, complete a secure checkout in minutes, and track your discreet parcel anywhere in Australia.</p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a href="<?php echo esc_url(site_url('/shop')); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors">
                            Order now <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="<?php echo esc_url(site_url('/faq')); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors">
                            How ordering works
                        </a>
                    </div>
                    <div class="mt-6 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-ink-500">
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shield-check w-3.5 h-3.5 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> Verified pharmacy</span>
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-lock w-3.5 h-3.5 text-brand-600"><rect width="18" height="11" x="3" y="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg> Secure checkout</span>
                        <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-truck w-3.5 h-3.5 text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> AU-wide delivery</span>
                    </div>
                </div>
            </div>
            <div class="bg-ink-900 text-white rounded-2xl p-8 md:p-10 relative overflow-hidden">
                <div class="absolute -bottom-10 -left-10 w-48 h-48 rounded-full bg-brand-600/30 blur-3xl" aria-hidden="true"></div>
                <div class="relative">
                    <span class="text-xs uppercase tracking-widest text-brand-300 font-semibold">Speak with our team</span>
                    <h3 class="mt-2 font-serif text-2xl font-semibold">Australian support</h3>
                    <p class="mt-2 text-ink-100/70 text-sm leading-relaxed">Need help with your order or product? We're here 24/7.</p>
                    <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" class="mt-5 inline-flex items-center gap-2 h-10 px-5 rounded-full bg-white text-ink-900 text-sm font-semibold hover:bg-brand-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-headphones w-4 h-4"><path d="M3 14h3a2 2 0 0 1 2 2v3a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-7a9 9 0 0 1 18 0v7a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3"/></svg> 
                        Contact support
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

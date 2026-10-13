<?php
$eyebrow = get_sub_field('eyebrow') ?: 'Legal';
$title = get_sub_field('title');
$intro = get_sub_field('intro');
$updated = get_sub_field('updated') ?: date('F Y');
$sections = get_sub_field('sections');
?>
<article class="policy-page-module">
    <!-- Breadcrumb -->
    <div class="border-b border-ink-200 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center text-xs text-ink-500 gap-2">
            <a href="<?php echo esc_url(site_url('/')); ?>" class="hover:text-brand-700">Home</a>
            <span>/</span>
            <?php if (is_single()) : 
                $blog_page = get_option('page_for_posts');
                $blog_url = $blog_page ? get_permalink($blog_page) : site_url('/blog/');
            ?>
                <a href="<?php echo esc_url($blog_url); ?>" class="hover:text-brand-700">Blog</a>
                <span>/</span>
            <?php endif; ?>
            <span class="text-ink-900 truncate"><?php echo esc_html($title); ?></span>
        </div>
    </div>

    <!-- Hero -->
    <div class="section-wash">
        <div class="max-w-4xl mx-auto px-4 py-14 md:py-20">
            <?php
            $back_url = site_url('/');
            $back_text = 'Back to home';
            if (is_single()) {
                $blog_page = get_option('page_for_posts');
                $back_url = $blog_page ? get_permalink($blog_page) : site_url('/blog/');
                $back_text = 'Back to blog';
            }
            ?>
            <div class="flex items-center gap-4 mb-6">
                <a href="<?php echo esc_url($back_url); ?>" class="inline-flex items-center gap-1.5 text-sm text-ink-700 hover:text-brand-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
                <?php echo esc_html($back_text); ?>
            </a>
                <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5 inline-block"><?php echo esc_html($eyebrow); ?></div>
            </div>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($title); ?></h1>
            <?php if ($intro) : ?>
                <p class="mt-4 text-lg text-ink-700 leading-relaxed max-w-3xl"><?php echo esc_html($intro); ?></p>
            <?php endif; ?>
            <p class="mt-5 text-xs text-ink-500">Last updated <?php echo esc_html($updated); ?></p>
        </div>
    </div>

    <!-- Body with sticky TOC -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-12 grid lg:grid-cols-[260px_1fr] gap-10">
        <?php if (!empty($sections)) : ?>
            <aside class="hidden lg:block relative">
                <div class="sticky top-24">
                    <div class="text-xs uppercase tracking-widest text-brand-700 font-semibold mb-3">On this page</div>
                    <ol class="space-y-1 text-sm" id="policy-toc">
                        <?php foreach ($sections as $i => $s) : 
                            $id = 'section-' . sanitize_title($s['title']);
                        ?>
                            <li>
                                <a href="#<?php echo esc_attr($id); ?>" data-target="<?php echo esc_attr($id); ?>" class="toc-link flex gap-2 items-baseline py-1.5 px-2 rounded border-l-2 transition-colors border-transparent text-ink-700 hover:text-brand-700">
                                    <span class="text-xs text-ink-400 tabular-nums w-6"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></span>
                                    <span class="flex-1 leading-snug"><?php echo esc_html($s['title']); ?></span>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ol>

                    <?php
                    $support_email = get_field('support_email', 'option');
                    $whatsapp_number = get_field('whatsapp_number', 'option');
                    if ( $support_email || $whatsapp_number ) :
                    ?>
                    <div class="mt-8 p-5 rounded-2xl bg-white border border-ink-200">
                        <div class="text-xs uppercase tracking-widest text-ink-500 font-semibold mb-2">Need help?</div>
                        <p class="text-sm text-ink-700">Our team usually replies within one business day.</p>
                        <?php if ( $support_email ) : ?>
                        <a href="mailto:<?php echo esc_attr($support_email); ?>" class="mt-3 inline-flex items-center gap-2 h-9 px-3 rounded-full bg-brand-600 hover:bg-brand-700 text-white text-xs font-semibold transition-colors"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> Email support</a>
                        <?php endif; ?>
                        <?php if ( $whatsapp_number ) : ?>
                        <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $whatsapp_number)); ?>" class="mt-2 inline-flex items-center gap-2 h-9 px-3 rounded-full border border-ink-200 hover:border-brand-500 text-ink-900 text-xs font-semibold transition-colors" target="_blank" rel="noopener noreferrer"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/></svg> WhatsApp</a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </aside>

            <div class="space-y-10 policy-content-wrap">
                <?php if (is_single() && has_post_thumbnail()) : ?>
                    <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-brand-50 border border-ink-200 mb-10">
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'full')); ?>" alt="Featured Image" class="w-full h-full object-cover" />
                    </div>
                <?php endif; ?>

                <?php foreach ($sections as $i => $s) : 
                    $id = 'section-' . sanitize_title($s['title']);
                ?>
                    <section id="<?php echo esc_attr($id); ?>" class="policy-section scroll-mt-24">
                        <div class="text-[11px] uppercase tracking-widest text-ink-400 font-semibold tabular-nums"><?php echo str_pad($i + 1, 2, '0', STR_PAD_LEFT); ?></div>
                        <h2 class="mt-1 font-serif text-2xl md:text-3xl font-semibold text-ink-900"><?php echo esc_html($s['title']); ?></h2>
                        <div class="mt-4 text-ink-700 leading-relaxed prose prose-ink prose-a:text-brand-700 max-w-none">
                            <?php echo apply_filters('the_content', $s['content']); ?>
                        </div>
                    </section>
                <?php endforeach; ?>

                <div class="pt-4 flex flex-wrap items-center gap-x-5 gap-y-2 text-xs text-ink-500 border-t border-ink-200">
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-brand-600"><path d="M20 13c0 5-3.5 7.5-7.66 8.95a1 1 0 0 1-.67-.01C7.5 20.5 4 18 4 13V6a1 1 0 0 1 1-1c2 0 4.5-1.2 6.24-2.72a1.17 1.17 0 0 1 1.52 0C14.51 3.81 17 5 19 5a1 1 0 0 1 1 1z"/><path d="m9 12 2 2 4-4"/></svg> Verified pharmacy</span>
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-brand-600"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg> Secure checkout</span>
                    <span class="inline-flex items-center gap-1.5"><svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5 text-brand-600"><path d="M14 18V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v11a1 1 0 0 0 1 1h2"/><path d="M15 18H9"/><path d="M19 18h2a1 1 0 0 0 1-1v-3.65a1 1 0 0 0-.22-.624l-3.48-4.35A1 1 0 0 0 17.52 8H14"/><circle cx="17" cy="18" r="2"/><circle cx="7" cy="18" r="2"/></svg> AU-wide delivery</span>
                </div>
            </div>
        <?php endif; ?>
    </div>
</article>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const sections = document.querySelectorAll('.policy-section');
    const navLinks = document.querySelectorAll('.toc-link');
    
    if (sections.length === 0 || navLinks.length === 0) return;

    function onScroll() {
        let currentId = sections[0].id;
        const scrollY = window.scrollY + 140; // offset

        sections.forEach(sec => {
            if (sec.offsetTop <= scrollY) {
                currentId = sec.id;
            }
        });

        navLinks.forEach(link => {
            if (link.getAttribute('data-target') === currentId) {
                link.classList.remove('border-transparent', 'text-ink-700');
                link.classList.add('border-brand-600', 'text-brand-700', 'bg-brand-50');
            } else {
                link.classList.remove('border-brand-600', 'text-brand-700', 'bg-brand-50');
                link.classList.add('border-transparent', 'text-ink-700');
            }
        });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll(); // initial state
});
</script>


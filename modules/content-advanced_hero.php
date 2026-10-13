<?php
$badge = get_sub_field('badge');
$title = get_sub_field('title');
$desc = get_sub_field('desc');
$buttons = get_sub_field('buttons');
?>
<div class="section-wash border-b border-ink-200">
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
            <span class="text-ink-900"><?php echo esc_html($title); ?></span>
        </div>
    </div>
    
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
            <?php if ($badge) : ?>
                <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100 rounded-full px-3 py-1.5 inline-block">
                <?php echo esc_html($badge); ?>
            </div>
            <?php endif; ?>
        </div>
        
        <?php if ($title) : ?>
            <h1 class="mt-4 font-serif text-4xl md:text-5xl font-semibold text-ink-900 leading-tight"><?php echo esc_html($title); ?></h1>
        <?php endif; ?>
        
        <?php if ($desc) : ?>
            <p class="mt-4 text-lg text-ink-700 leading-relaxed max-w-2xl"><?php echo esc_html($desc); ?></p>
        <?php endif; ?>
        
        <?php if (!empty($buttons)) : ?>
            <div class="mt-6 flex flex-wrap gap-3">
                <?php foreach ($buttons as $btn) : 
                    $is_primary = ($btn['style'] === 'primary');
                    $classes = $is_primary 
                        ? 'inline-flex items-center gap-2 h-11 px-5 rounded-full bg-brand-600 hover:bg-brand-700 text-white font-semibold transition-colors' 
                        : 'inline-flex items-center gap-2 h-11 px-5 rounded-full border border-ink-200 hover:border-brand-600 text-ink-900 font-semibold transition-colors';
                ?>
                    <a href="<?php echo esc_url($btn['link']); ?>" class="<?php echo esc_attr($classes); ?>">
                        <?php echo esc_html($btn['text']); ?>
                        <?php if ($is_primary) : ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-4 h-4"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <p class="mt-6 text-xs text-ink-500">Last updated <?php echo date('F Y'); ?></p>
    </div>
</div>

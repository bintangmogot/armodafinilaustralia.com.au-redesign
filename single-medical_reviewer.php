<?php
/**
 * Single Medical Reviewer Template
 */
get_header(); 
?>

<main id="primary" class="site-main bg-white">
    <?php while ( have_posts() ) : the_post(); 
        $image = get_the_post_thumbnail_url(get_the_ID(), 'full') ?: 'https://placehold.co/400x400/e0f2fe/0369a1?text=Doctor';
    ?>
    <article>
        <!-- Breadcrumb & Back Button -->
        <div class="border-b border-ink-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-12 flex items-center justify-between text-xs text-ink-500">
                <div class="flex items-center gap-2">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-brand-700">Home</a>
                    <span>/</span>
                    <span class="text-ink-900 truncate"><?php the_title(); ?></span>
                </div>
                <a href="<?php echo esc_url( wp_get_referer() ? wp_get_referer() : home_url( '/shop/' ) ); ?>" class="flex items-center gap-1.5 font-medium text-brand-700 hover:text-brand-800 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                    Go Back
                </a>
            </div>
        </div>
        
        <!-- Breadcrumb & Back Button -->
        

        <!-- Wash Header Profile -->
        <div class="section-wash border-b border-ink-200" style="padding-top: 5rem; padding-bottom: 5rem;">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                
                <div class="flex flex-col md:flex-row items-center md:items-start gap-8 md:gap-12">
                    
                    <!-- Fixed Size Avatar -->
                    <div class="w-48 h-48 md:w-56 md:h-56 flex-shrink-0 relative">
                        <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" class="w-full h-full object-cover rounded-3xl shadow-lg border-4 border-white bg-white" />
                        <div class="absolute -bottom-3 -right-3 bg-white p-2.5 rounded-full shadow-md border border-ink-100" title="Verified Medical Professional">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#0f766e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/></svg>
                        </div>
                    </div>

                    <!-- Header Info -->
                    <div class="flex-1 text-center md:text-left mt-2 md:mt-4">
                        <div class="text-[11px] uppercase tracking-widest text-brand-700 font-semibold bg-brand-100/50 rounded-full px-3 py-1.5 inline-block mb-3 border border-brand-200">
                            Medical Team
                        </div>
                        <h1 class="font-serif text-4xl md:text-5xl font-bold text-ink-900 leading-tight mb-2">
                            <?php the_title(); ?>
                        </h1>
                        <p class="text-xl text-ink-600 font-medium mb-6">
                            <?php echo esc_html(get_field('medical_title') ?: 'Physician'); ?>
                        </p>
                        
                        <div class="inline-flex items-center gap-2 text-sm text-teal-800 bg-teal-50 px-4 py-2 rounded-lg border border-teal-100">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                            <strong>Verified</strong> Medical Content Reviewer
                        </div>
                    </div>

                </div>
                
            </div>
        </div>

        <!-- Bio Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="bg-white rounded-2xl p-8 sm:p-10 shadow-sm border border-ink-200">
                <h2 class="text-xl font-bold text-ink-900 mb-6 flex items-center gap-2 border-b border-ink-100 pb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-600"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                    About <?php the_title(); ?>
                </h2>
                <div class="prose prose-ink prose-lg max-w-none text-ink-700 leading-relaxed">
                    <?php the_content(); ?>
                </div>

                <div class="mt-12 pt-8 border-t border-ink-100 bg-slate-50 p-6 rounded-xl">
                    <div class="text-xs font-bold uppercase tracking-widest text-ink-500 mb-3 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                        Medical Disclaimer
                    </div>
                    <p class="text-sm text-ink-600 italic leading-relaxed m-0">
                        <?php echo esc_html(get_the_title()); ?> serves strictly as an independent medical reviewer for educational purposes, ensuring clinical accuracy across Armodafinil Direct. This content does not constitute professional medical advice, diagnosis, or treatment.
                    </p>
                </div>
            </div>
        </div>

        <!-- Dynamic Page Modules -->
        <?php 
        if( have_rows('page_modules') ) {
            while( have_rows('page_modules') ) {
                the_row();
                $layout = get_row_layout();
                get_template_part('modules/content', $layout);
            }
        } 
        ?>

    </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>









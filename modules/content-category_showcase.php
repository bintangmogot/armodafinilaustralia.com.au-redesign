<?php
if ( ! have_rows('sections') ) {
    if ( current_user_can('edit_posts') ) {
        echo '<div class="max-w-7xl mx-auto px-4 py-8 text-center bg-brand-50 text-brand-700 border border-brand-200 rounded-2xl mb-8"><strong>Category Showcase Module:</strong> Please add at least one section in the page editor.</div>';
    }
    return;
}
?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-16">
    <?php while ( have_rows('sections') ) : the_row(); 
        
        $parent_cat = get_sub_field('parent_category');
        
        // Normalize term if it's returning an ID/Array due to ACF cache
        if ( is_numeric($parent_cat) ) {
            $parent_cat = get_term( $parent_cat, 'product_cat' );
        } elseif ( is_array($parent_cat) && isset($parent_cat['term_id']) ) {
            $parent_cat = get_term( $parent_cat['term_id'], 'product_cat' );
        }

        if ( ! $parent_cat || is_wp_error($parent_cat) ) {
            continue;
        }

        $title = $parent_cat->name;
        $subtitle = term_description( $parent_cat->term_id, 'product_cat' );
        $link_url = get_term_link( $parent_cat );
        $link_text = 'Browse category';
        
        // Icon logic: Try custom ACF 'top_image', fallback to Woo thumbnail
        $icon_url = '';
        $top_image = get_field('top_image', $parent_cat);
        if ( $top_image ) {
            $icon_url = is_array($top_image) ? $top_image['url'] : $top_image;
        } else {
            $thumbnail_id = get_term_meta( $parent_cat->term_id, 'thumbnail_id', true );
            if ( $thumbnail_id ) {
                $icon_url = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );
            }
        }

        // Fetch all sub-categories of this parent automatically
        $sub_categories = get_terms( array(
            'taxonomy'   => 'product_cat',
            'parent'     => $parent_cat->term_id,
            'hide_empty' => false,
        ) );
        
        $product_count = $parent_cat->count;
    ?>
    <section class="scroll-mt-24" id="<?php echo esc_attr(sanitize_title($title)); ?>">
        
        <!-- Header Card -->
        <div class="bg-[#F8FDFB] border border-brand-100 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row md:items-center gap-6 justify-between mb-8">
            
            <style>
                .showcase-header-icon { width: 64px; height: 64px; flex-shrink: 0; }
                @media (min-width: 768px) { .showcase-header-icon { width: 72px; height: 72px; } }
            </style>
            <div class="flex items-start md:items-center gap-5">
                <?php if ( $icon_url ) : ?>
                    <div class="showcase-header-icon rounded-[1.25rem] bg-white shadow-[0_2px_10px_-4px_rgba(0,169,157,0.1)] flex items-center justify-center p-2 md:p-3 border border-ink-100">
                        <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>" class="w-full h-full object-contain" />
                    </div>
                <?php else : ?>
                    <!-- Default Icon -->
                    <div class="shrink-0 w-[72px] h-[72px] rounded-[1.25rem] bg-white shadow-[0_2px_10px_-4px_rgba(0,169,157,0.1)] flex items-center justify-center text-brand-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-box"><path d="M21 8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16Z"/><path d="m3.3 7 8.7 5 8.7-5"/><path d="M12 22V12"/></svg>
                    </div>
                <?php endif; ?>
                
                <div>
                    <div class="flex flex-wrap items-center gap-4">
                        <h2 class="font-serif text-3xl font-bold text-ink-900 tracking-tight"><?php echo esc_html($title); ?></h2>
                        <span class="text-xs font-semibold text-brand-700 bg-brand-100 rounded-full px-3 py-1"><?php echo esc_html($product_count); ?> products</span>
                    </div>
                    <?php if ( $subtitle ) : ?>
                        <div class="mt-2.5 text-ink-700 text-sm md:text-base max-w-3xl prose prose-sm prose-ink"><?php echo wp_kses_post($subtitle); ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="shrink-0">
                <a href="<?php echo esc_url($link_url); ?>" class="inline-flex items-center gap-2 h-11 px-6 rounded-full bg-white border border-ink-200 hover:border-brand-600 hover:text-brand-700 text-ink-900 text-sm font-semibold transition-colors">
                    <?php echo esc_html($link_text); ?> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
        </div>

        <!-- Sub-category Grid -->
        <?php if ( ! empty( $sub_categories ) && ! is_wp_error($sub_categories) ) : ?>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                <?php
                foreach ( $sub_categories as $sub_cat ) {
                    $link = get_term_link($sub_cat);
                    $name = $sub_cat->name;
                    $thumbnail_id = get_term_meta( $sub_cat->term_id, 'thumbnail_id', true );
                    $image_url = $thumbnail_id ? wp_get_attachment_image_url( $thumbnail_id, 'medium_large' ) : 'https://placehold.co/600x450/e0f2fe/0369a1?text=' . urlencode($name);
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="group bg-white border border-ink-200 rounded-3xl overflow-hidden hover-lift flex flex-col transition-shadow hover:shadow-lg">
                        <div class="aspect-[4/3] bg-brand-50 overflow-hidden relative flex items-center justify-center p-6 md:p-8">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($name); ?>" class="w-full h-full object-contain transition-transform duration-500 group-hover:scale-105 mix-blend-multiply" />
                        </div>
                        <div class="p-5 md:p-6 flex-1 flex flex-col justify-center bg-white z-10 relative">
                            <h3 class="font-serif text-lg font-bold text-ink-900 group-hover:text-brand-700 transition-colors line-clamp-1"><?php echo esc_html($name); ?></h3>
                            <div class="mt-1 text-sm text-ink-500 flex items-center gap-1 group-hover:text-brand-600 transition-colors">
                                Explore <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-right"><path d="m9 18 6-6-6-6"/></svg>
                            </div>
                        </div>
                    </a>
                    <?php
                }
                ?>
            </div>
        <?php else : ?>
            <?php if ( current_user_can('edit_posts') ) : ?>
                <div class="p-6 border border-dashed border-ink-300 rounded-2xl text-center text-ink-500 text-sm">
                    No sub-categories found for <?php echo esc_html($title); ?>. Go to Products > Categories and add some!
                </div>
            <?php endif; ?>
        <?php endif; ?>

    </section>
    <?php endwhile; ?>
</div>


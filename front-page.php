<?php
/**
 * The front page template file
 *
 * @package Armodafinil_Australia_Direct
 */

get_header(); ?>

<main id="primary" class="site-main">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) :
            the_post();
            
            // Output normal content if any
            the_content();
            
            // Loop through flexible content modules
            if ( have_rows('page_modules') ) :
                while ( have_rows('page_modules') ) : the_row();
                    // Include the specific module template
                    $layout = get_row_layout();
                    get_template_part('modules/content', $layout);
                endwhile;
            endif;
            
        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();

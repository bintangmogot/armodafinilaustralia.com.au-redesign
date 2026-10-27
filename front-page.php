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
            
            armo_render_modules();

        endwhile;
    endif;
    ?>
</main>

<?php
get_footer();

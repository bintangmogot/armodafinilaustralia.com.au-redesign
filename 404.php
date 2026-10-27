<?php
/**
 * 404 page. Wording comes from Theme Settings > Interface Labels.
 *
 * @package Armodafinil_Australia
 */

get_header();
$title = armo_label( 'label_404_title' ) ?: get_the_title( (int) get_option( 'page_on_front' ) );
$text  = armo_label( 'label_404_text' );
$back  = armo_label( 'label_back_home' );
?>
<main id="primary" class="site-main">
	<section class="section bg-secondary">
		<div class="container-site mx-auto max-w-2xl py-10 text-center">
			<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( $title ); ?></h1>
			<?php if ( $text ) : ?><p class="section-lead"><?php echo esc_html( $text ); ?></p><?php endif; ?>
			<?php if ( $back ) : ?><div class="mt-8"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-primary"><?php echo esc_html( $back ); ?></a></div><?php endif; ?>
		</div>
	</section>
</main>
<?php
get_footer();

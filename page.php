<?php
/**
 * Template for pages. Prints the page's ACF modules; pages without modules print the editor
 * content. Every page gets exactly one H1: when no module prints one, the page title is used.
 *
 * @package Armodafinil_Australia
 */

get_header();

$page_id    = get_the_ID();
$is_commerce = function_exists( 'is_cart' ) && ( is_cart() || is_checkout() || is_account_page() );

// The blog index uses the page chosen in Settings > Reading.
if ( is_home() && get_option( 'page_for_posts' ) ) {
	$page_id = (int) get_option( 'page_for_posts' );
}

ob_start();
$has_modules = armo_render_modules( $page_id );
$body        = ob_get_clean();

if ( ! $has_modules ) {
	ob_start();
	while ( have_posts() ) {
		the_post();
		if ( $is_commerce ) {
			the_content();
		} else {
			echo '<section class="section bg-white"><div class="container-site"><div class="armo-prose mx-auto max-w-4xl">';
			the_content();
			echo '</div></div></section>';
		}
	}
	$body = ob_get_clean();
}
?>
<main id="primary" class="site-main">
	<?php if ( ! $is_commerce && false === stripos( $body, '<h1' ) ) : ?>
		<header class="border-b border-border bg-secondary">
			<div class="container-site py-10 md:py-14">
				<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( get_the_title( $page_id ) ); ?></h1>
			</div>
		</header>
	<?php endif; ?>
	<?php echo $body; // phpcs:ignore WordPress.Security.EscapeOutput -- assembled from escaped templates above. ?>
</main>
<?php
get_footer();

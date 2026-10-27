<?php
/**
 * Shop and product category pages.
 *
 * The shop page is built from its own ACF modules (modules and page_modules). Category and tag
 * archives print a heading band, the products and any bottom content entered on the term.
 *
 * @package Armodafinil_Australia
 */

defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

$shop_page_id = (int) wc_get_page_id( 'shop' );
$term         = ( is_product_category() || is_product_tag() ) ? get_queried_object() : null;
?>
<main id="primary" class="site-main">
<?php
if ( is_shop() && ! is_search() && $shop_page_id > 0 ) :
	ob_start();
	$has_modules = armo_render_modules( $shop_page_id );
	$body        = ob_get_clean();
	if ( $has_modules && false === stripos( $body, '<h1' ) ) :
		?>
		<header class="border-b border-border bg-secondary"><div class="container-site py-10 md:py-14"><h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary"><?php echo esc_html( get_the_title( $shop_page_id ) ); ?></h1></div></header>
		<?php
	endif;
	echo $body; // phpcs:ignore WordPress.Security.EscapeOutput -- escaped inside the module templates.
endif;

if ( ! is_shop() || is_search() || ! $has_modules ) :
	$description = $term ? term_description() : '';
	?>
	<header class="border-b border-border bg-secondary">
		<div class="container-site py-10 text-center md:py-14">
			<h1 class="font-heading text-[clamp(2rem,1.5rem+2.5vw,3.25rem)] font-bold leading-[1.1] text-primary">
				<?php
				if ( is_search() ) {
					$template = armo_label( 'label_search_results' );
					echo esc_html( $template ? str_replace( '{query}', get_search_query(), $template ) : get_search_query() );
				} else {
					woocommerce_page_title();
				}
				?>
			</h1>
			<?php if ( $description ) : ?><div class="section-lead"><?php echo wp_kses_post( $description ); ?></div><?php endif; ?>
		</div>
	</header>

	<section class="section bg-white">
		<div class="container-site">
			<?php if ( woocommerce_product_loop() ) : ?>
				<div class="mb-6 flex flex-wrap items-center justify-between gap-3 text-sm text-muted-foreground [&_select]:h-10 [&_select]:rounded-lg [&_select]:border-border [&_select]:bg-white [&_select]:px-3 [&_select]:text-sm [&_select]:text-primary">
					<?php woocommerce_result_count(); ?>
					<?php woocommerce_catalog_ordering(); ?>
				</div>
				<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 lg:gap-6">
					<?php
					while ( have_posts() ) {
						the_post();
						wc_get_template_part( 'content', 'product' );
					}
					?>
				</div>
				<div class="mt-10 [&_.page-numbers]:inline-flex [&_.page-numbers]:h-10 [&_.page-numbers]:min-w-10 [&_.page-numbers]:items-center [&_.page-numbers]:justify-center [&_.page-numbers]:rounded-lg [&_.page-numbers]:border [&_.page-numbers]:border-border [&_.page-numbers]:px-3 [&_.page-numbers.current]:bg-primary [&_.page-numbers.current]:text-white [&_ul]:flex [&_ul]:list-none [&_ul]:justify-center [&_ul]:gap-2 [&_ul]:p-0">
					<?php woocommerce_pagination(); ?>
				</div>
			<?php else : ?>
				<?php do_action( 'woocommerce_no_products_found' ); ?>
			<?php endif; ?>
		</div>
	</section>

	<?php
	$bottom = $term ? get_field( 'bottom_content', $term ) : '';
	if ( $bottom ) :
		?>
		<section class="section bg-secondary"><div class="container-site"><div class="armo-prose mx-auto max-w-3xl"><?php echo wp_kses_post( $bottom ); ?></div></div></section>
	<?php endif; ?>
<?php endif; ?>
</main>
<?php
get_footer( 'shop' );

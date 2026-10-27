<?php
/**
 * Site search dialog. Labels come from Theme Settings > Search; categories are the
 * WooCommerce top-level product categories. Behaviour lives in assets/js/search.js.
 *
 * @package Armodafinil_Australia
 */

if ( ! get_field( 'header_search_label', 'option' ) ) {
	return;
}

$placeholder = get_field( 'header_search_label', 'option' );
$all_label   = get_field( 'search_all_label', 'option' );
$empty_title = get_field( 'search_empty_title', 'option' );
$empty_text  = get_field( 'search_empty_text', 'option' );
$pop_label   = get_field( 'search_popular_label', 'option' );
$popular     = get_field( 'search_popular_terms', 'option' );
$no_results  = get_field( 'search_no_results_text', 'option' );
$categories  = taxonomy_exists( 'product_cat' ) ? get_terms( array( 'taxonomy' => 'product_cat', 'parent' => 0, 'hide_empty' => true, 'exclude' => array( (int) get_option( 'default_product_cat' ) ) ) ) : array();
?>
<div id="search-dialog" class="fixed inset-0 z-[100] hidden items-start justify-center px-4 pt-16 sm:pt-24" role="dialog" aria-modal="true" aria-label="<?php echo esc_attr( $placeholder ); ?>" data-ajax="<?php echo esc_url( admin_url( 'admin-ajax.php' ) ); ?>" data-no-results="<?php echo esc_attr( $no_results ); ?>">
	<div class="absolute inset-0 bg-primary/50" data-search-close></div>
	<div class="relative flex max-h-[80vh] w-full max-w-2xl flex-col overflow-hidden rounded-2xl border border-border bg-white">
		<div class="border-b border-border p-4">
			<div class="flex h-12 items-center gap-2 rounded-lg border border-border px-3 focus-within:border-primary">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="shrink-0 text-muted-foreground" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				<input type="search" id="search-input" class="h-full flex-1 border-0 bg-transparent text-base text-foreground outline-none placeholder:text-muted-foreground" placeholder="<?php echo esc_attr( $placeholder ); ?>" autocomplete="off">
				<button type="button" class="inline-flex h-8 w-8 items-center justify-center rounded-md text-muted-foreground hover:bg-secondary" data-search-close aria-label="<?php echo esc_attr__( 'Close', 'woocommerce' ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M18 6 6 18M6 6l12 12"/></svg>
				</button>
			</div>
			<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
				<div class="mt-3 flex flex-wrap gap-2">
					<?php if ( $all_label ) : ?>
						<button type="button" class="search-cat is-active rounded-full border border-border px-3 py-1 text-xs font-semibold text-primary" data-cat=""><?php echo esc_html( $all_label ); ?></button>
					<?php endif; ?>
					<?php foreach ( $categories as $category ) : ?>
						<button type="button" class="search-cat rounded-full border border-border px-3 py-1 text-xs font-semibold text-primary" data-cat="<?php echo (int) $category->term_id; ?>"><?php echo esc_html( $category->name ); ?></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="overflow-y-auto p-3">
			<div id="search-start" class="px-4 py-10 text-center">
				<?php if ( $empty_title ) : ?><p class="font-heading text-lg font-semibold text-primary"><?php echo esc_html( $empty_title ); ?></p><?php endif; ?>
				<?php if ( $empty_text ) : ?><p class="mt-1 text-sm text-muted-foreground"><?php echo esc_html( $empty_text ); ?></p><?php endif; ?>
				<?php if ( ! empty( $popular ) ) : ?>
					<div class="mt-6 flex flex-wrap items-center justify-center gap-2">
						<?php if ( $pop_label ) : ?><span class="text-xs font-medium text-muted-foreground"><?php echo esc_html( $pop_label ); ?></span><?php endif; ?>
						<?php foreach ( $popular as $row ) : ?>
							<?php if ( empty( $row['term'] ) ) { continue; } ?>
							<button type="button" class="search-popular rounded-full border border-border px-3 py-1 text-xs font-semibold text-primary hover:bg-secondary"><?php echo esc_html( $row['term'] ); ?></button>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
			<ul id="search-results" class="m-0 hidden list-none p-0"></ul>
			<p id="search-empty" class="hidden px-4 py-10 text-center text-sm text-muted-foreground"></p>
		</div>
	</div>
</div>

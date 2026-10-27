<?php
/**
 * Site header: announcement bar, sticky header, mobile drawer, feature bar.
 * Every visible word comes from Theme Settings or Appearance > Menus.
 *
 * @package Armodafinil_Australia
 */

$is_checkout   = function_exists( 'is_checkout' ) && is_checkout() && ! is_wc_endpoint_url( 'order-received' );
$logo_id       = (int) get_theme_mod( 'custom_logo' );
$logo_alt      = get_field( 'header_logo_alt', 'option' ) ?: get_bloginfo( 'name' );
$wa_url        = armo_whatsapp_url();
$wa_label      = get_field( 'header_whatsapp_label', 'option' );
$search_label  = get_field( 'header_search_label', 'option' );
$cart_count    = ( function_exists( 'WC' ) && WC()->cart ) ? WC()->cart->get_cart_contents_count() : 0;
$feature_items = get_field( 'enable_feature_bar', 'option' ) ? get_field( 'feature_bar_items', 'option' ) : array();
$svg_allowed   = array(
	'svg'    => array( 'class' => true, 'xmlns' => true, 'width' => true, 'height' => true, 'viewbox' => true, 'fill' => true, 'stroke' => true, 'stroke-width' => true, 'aria-hidden' => true, 'focusable' => true ),
	'path'   => array( 'd' => true, 'fill' => true, 'stroke' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'stroke-width' => true, 'fill-rule' => true, 'clip-rule' => true ),
	'circle' => array( 'cx' => true, 'cy' => true, 'r' => true, 'fill' => true, 'stroke' => true ),
	'rect'   => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'fill' => true, 'stroke' => true ),
);
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class( 'bg-background text-foreground' ); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

<?php if ( $is_checkout ) : ?>
	<header class="sticky top-0 z-40 border-b border-border bg-white">
		<div class="container-site flex h-16 items-center justify-between">
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-primary hover:bg-secondary" aria-label="<?php echo esc_attr__( 'Cart', 'woocommerce' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m15 18-6-6 6-6"/></svg>
			</a>
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex shrink-0 items-center">
				<?php if ( $logo_id ) : ?>
					<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => $logo_alt, 'class' => 'site-logo', 'loading' => 'eager', 'decoding' => 'async' ) ); ?>
				<?php else : ?>
					<span class="font-heading text-lg font-bold text-primary"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</a>
			<span class="inline-flex h-10 w-10 items-center justify-center text-success" aria-hidden="true">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="11" x="3" y="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
			</span>
		</div>
	</header>
<?php else : ?>

	<?php if ( get_field( 'enable_announcement_bar', 'option' ) && ( $announcement = get_field( 'announcement_text', 'option' ) ) ) : ?>
		<div class="bg-primary text-white">
			<p class="container-site py-2 text-center text-[13px] font-medium"><?php echo esc_html( $announcement ); ?></p>
		</div>
	<?php endif; ?>

	<header id="site-header" class="sticky top-0 z-40 border-b border-border bg-white/95 backdrop-blur transition-shadow">
		<div class="container-site flex h-[68px] items-center gap-3">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="mr-2 flex shrink-0 items-center">
				<?php if ( $logo_id ) : ?>
					<?php echo wp_get_attachment_image( $logo_id, 'medium', false, array( 'alt' => $logo_alt, 'class' => 'site-logo', 'loading' => 'eager', 'decoding' => 'async', 'fetchpriority' => 'high' ) ); ?>
				<?php else : ?>
					<span class="font-heading text-xl font-bold text-primary"><?php bloginfo( 'name' ); ?></span>
				<?php endif; ?>
			</a>

			<nav class="hidden flex-1 items-center justify-center gap-1 lg:flex" aria-label="<?php echo esc_attr__( 'Menu', 'woocommerce' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'container'      => false,
					'items_wrap'     => '<ul class="m-0 flex list-none items-center gap-1 p-0">%3$s</ul>',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
				?>
			</nav>
			<div class="flex-1 lg:hidden"></div>

			<?php if ( $search_label ) : ?>
				<button type="button" id="header-search-trigger" class="hidden h-10 w-64 items-center gap-2 rounded-lg border border-border bg-secondary/60 px-3 text-left text-sm text-muted-foreground transition-colors hover:border-primary/30 md:flex xl:w-72" aria-label="<?php echo esc_attr( $search_label ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
					<span class="truncate"><?php echo esc_html( $search_label ); ?></span>
				</button>
				<button type="button" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-primary hover:bg-secondary md:hidden" data-search-open aria-label="<?php echo esc_attr( $search_label ); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				</button>
			<?php endif; ?>

			<?php if ( $wa_url && $wa_label ) : ?>
				<a href="<?php echo esc_url( $wa_url ); ?>" class="btn-outline btn-sm hidden sm:inline-flex" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $wa_label ); ?></a>
			<?php endif; ?>

			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="xoo-wsc-cart-trigger relative inline-flex h-10 w-10 items-center justify-center rounded-lg text-primary hover:bg-secondary" aria-label="<?php echo esc_attr__( 'Cart', 'woocommerce' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
				<?php if ( $cart_count > 0 ) : ?>
					<span class="absolute -right-0.5 -top-0.5 grid h-4 min-w-4 place-items-center rounded-full bg-accent px-1 text-[10px] font-bold text-primary"><?php echo (int) $cart_count; ?></span>
				<?php endif; ?>
			</a>

			<button type="button" id="mobile-menu-btn" class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-primary hover:bg-secondary lg:hidden" aria-expanded="false" aria-controls="mobile-drawer" aria-label="<?php echo esc_attr__( 'Menu', 'woocommerce' ); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
			</button>
		</div>

		<div id="mobile-drawer" class="hidden border-t border-border bg-white lg:hidden">
			<nav class="container-site py-2" aria-label="<?php echo esc_attr__( 'Menu', 'woocommerce' ); ?>">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'mobile',
					'container'      => false,
					'items_wrap'     => '<ul class="m-0 list-none p-0">%3$s</ul>',
					'fallback_cb'    => false,
					'depth'          => 1,
				) );
				?>
				<?php if ( $wa_url && $wa_label ) : ?>
					<a href="<?php echo esc_url( $wa_url ); ?>" class="btn-outline mb-3 mt-3 w-full" target="_blank" rel="noopener noreferrer"><?php echo esc_html( $wa_label ); ?></a>
				<?php endif; ?>
			</nav>
		</div>
	</header>

	<?php if ( ! empty( $feature_items ) ) : ?>
		<div class="border-b border-border bg-secondary">
			<ul class="container-site m-0 flex list-none items-center gap-x-8 gap-y-2 overflow-x-auto whitespace-nowrap py-2.5 text-[13px] font-medium text-primary md:justify-center">
				<?php foreach ( $feature_items as $item ) : ?>
					<?php if ( empty( $item['text'] ) ) { continue; } ?>
					<li class="flex shrink-0 items-center gap-2">
						<?php if ( ! empty( $item['icon'] ) ) : ?>
							<span class="inline-flex h-5 w-5 items-center justify-center text-brand-500 [&>svg]:h-5 [&>svg]:w-5" aria-hidden="true"><?php echo wp_kses( $item['icon'], $svg_allowed ); ?></span>
						<?php endif; ?>
						<span><?php echo esc_html( $item['text'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
<?php endif; ?>

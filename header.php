<?php
/**
 * The header for our theme
 *
 * @package Armodafinil_Australia_Direct
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">

	<?php if ( function_exists('is_checkout') && is_checkout() && empty( is_wc_endpoint_url('order-received') ) ) : ?>
    <header class="sticky top-0 z-40 bg-white border-b border-ink-100 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="flex items-center gap-1.5 text-sm font-medium text-ink-500 hover:text-ink-900 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="m15 18-6-6 6-6"/></svg> Cart
            </a>
            
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center shrink-0 min-w-0">
                <img src="<?php $custom_logo_id = get_theme_mod("custom_logo"); echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>" alt="Armodafinil Direct" style="height: 32px !important; width: auto !important; max-width: 200px; object-fit: contain;">
            </a>

            <div class="flex items-center gap-1.5 text-brand-700 text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="!fill-none"><path style="fill:none !important;" d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path style="fill:none !important;" d="m9 12 2 2 4-4"/></svg> Secure
            </div>
        </div>
    </header>
<?php else: ?>
	<!-- TopBar -->
	    <div class="w-full bg-ink-900 text-white text-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-9 flex items-center justify-between gap-4">
            <p class="opacity-90 font-medium tracking-wide"><?php echo ($t = get_field("topbar_left", "option")) ? esc_html(trim(str_ireplace("dispatch", "", $t))) : ""; ?></p>
            <?php if ( $topbar_center = get_field('topbar_center', 'option') ) : ?>
            <p class="opacity-90 hidden md:block"><?php echo esc_html($topbar_center); ?></p>
            <?php endif; ?>
            <?php 
            $support_phone = get_field('whatsapp_number', 'option') ?: '0488 841 833';
            $clean_phone = preg_replace('/[^0-9]/', '', $support_phone);
            // Convert Australian 04... format to 614... for WhatsApp
            $wa_phone = (strpos($clean_phone, '0') === 0) ? '61' . substr($clean_phone, 1) : $clean_phone;
            ?>
            <a href="tel:+<?php echo esc_attr($wa_phone); ?>" class="inline-flex items-center gap-1.5 text-brand-300 hover:text-brand-200 whitespace-nowrap shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-phone-call"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/><path d="M14.05 2a9 9 0 0 1 8 7.94"/><path d="M14.05 6A5 5 0 0 1 18 10"/></svg> <?php echo esc_html($support_phone); ?>
            </a>
        </div>
    </div>

	<!-- Navbar -->
	<header class="sticky top-0 z-40 bg-white/85 backdrop-blur border-b border-ink-200">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center gap-2 sm:gap-4">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="flex items-center shrink-0 min-w-0">
                <img src="<?php $custom_logo_id = get_theme_mod("custom_logo"); echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>" alt="Armodafinil Direct" style="height: 44px !important; width: auto !important; max-width: 250px; object-fit: contain;">
			</a>

			<nav class="hidden lg:flex items-center gap-1 ml-4">
				<?php
				wp_nav_menu( array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'items_wrap'     => '%3$s', // Strip ul wrapper for tailwind flexibility, though WP uses LI. Better to style LI.
					'fallback_cb'    => false,
					// Custom walker can be added here for perfect Tailwind classes on <li> and <a>
				) );
				?>
                </nav>

			<div class="flex-1"></div>

						<!-- Search Trigger Button -->
			<button id="header-search-trigger" aria-label="Open Search" class="hidden md:flex items-center bg-ink-50 hover:bg-ink-100 transition-colors rounded-full px-4 h-[42px] w-80 border border-ink-200 shadow-sm cursor-text text-left group">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-ink-400 group-hover:text-brand-600 transition-colors shrink-0"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
				<span class="flex-1 mx-3 text-[13px] text-ink-500 font-medium truncate">Search products, strengths, brands...</span>
				<span class="text-[10px] font-semibold text-ink-500 bg-white border border-ink-200 rounded px-1.5 py-0.5 shadow-sm shrink-0">Ctrl K</span>
			</button>

			<!-- Cart -->
			<a href="<?php echo wc_get_cart_url(); ?>" class="xoo-wsc-cart-trigger relative w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" aria-label="Cart">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart text-ink-700"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
				    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 grid place-items-center text-[10px] font-semibold text-white bg-brand-600 rounded-full"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                <?php endif; ?>
			</a>

			<!-- Shop Button -->
			<a href="/shop" class="hidden md:inline-flex items-center h-10 px-4 rounded-full bg-brand-600 text-white text-sm font-semibold hover:bg-brand-700 transition-colors">
				Shop
			</a>

			<!-- Mobile Menu Button -->
			<button class="lg:hidden w-10 h-10 grid place-items-center rounded-full hover:bg-ink-100" id="mobile-menu-btn" aria-label="Menu">
				<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/></svg>
			</button>
		</div>
		</header>
    <?php endif; ?>



<?php
/**
 * The footer for our theme
 *
 * @package Armodafinil_Australia_Direct
 */
?>

	<footer class="mt-24 bg-ink-900 text-ink-100">
		<style>
	@media (min-width: 1024px) {
		.lg-grid-cols-6-fix { grid-template-columns: repeat(6, minmax(0, 1fr)) !important; }
	}
</style>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 lg-grid-cols-6-fix gap-8">
			<div class="col-span-2 lg:col-span-2">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="inline-block bg-white px-3 py-2 rounded-xl mb-1">
                    <img src="<?php $custom_logo_id = get_theme_mod("custom_logo"); echo $custom_logo_id ? esc_url(wp_get_attachment_image_url($custom_logo_id, "full")) : esc_url(get_template_directory_uri() . "/assets/logo.png"); ?>" alt="Armodafinil Direct" style="height: 36px !important; width: auto !important; max-width: 220px; object-fit: contain;">
				</a>
				<?php if ( $footer_desc = get_field('footer_description', 'option') ) : 
					$footer_desc = str_replace('Legal Disclaimer:', '<br><br><span class="opacity-50 uppercase tracking-widest text-[10px] font-bold block mb-1">Legal Disclaimer:</span>', $footer_desc);
				?>
				<p class="mt-3 text-sm text-ink-100/70 max-w-sm"><?php echo wp_kses_post($footer_desc); ?></p>
				<?php endif; ?>
				<div class="mt-5 flex items-center gap-3 text-brand-300">
					<?php if(get_field('facebook_link', 'option')): ?>
					<a href="<?php echo esc_url(get_field('facebook_link', 'option')); ?>" aria-label="Facebook" target="_blank" rel="noopener noreferrer" class="w-9 h-9 grid place-items-center rounded-full bg-white/5 hover:bg-white/10">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-facebook"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
					</a>
					<?php endif; ?>
					
					<?php if(get_field('instagram_link', 'option')): ?>
					<a href="<?php echo esc_url(get_field('instagram_link', 'option')); ?>" aria-label="Instagram" target="_blank" rel="noopener noreferrer" class="w-9 h-9 grid place-items-center rounded-full bg-white/5 hover:bg-white/10">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-instagram"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
					</a>
					<?php endif; ?>
				</div>
			</div>

			<div>
				<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Shop</div>
				<?php wp_nav_menu(array('theme_location' => 'footer_1', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
                
                <div class="text-white font-semibold mt-8 mb-3 text-sm uppercase tracking-widest">Trending Products</div>
                <?php wp_nav_menu(array('theme_location' => 'footer_trending', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
			</div>
			<div>
				<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Help</div>
				<?php wp_nav_menu(array('theme_location' => 'footer_2', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
			</div>
			<div>
				<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Company</div>
				<?php wp_nav_menu(array('theme_location' => 'footer_3', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
			</div>
			<div>
				<div class="text-white font-semibold mb-3 text-sm uppercase tracking-widest">Areas Delivered in Australia</div>
				<?php wp_nav_menu(array('theme_location' => 'footer_4', 'menu_class' => 'space-y-2 text-sm text-ink-100/80', 'fallback_cb' => false)); ?>
			</div>
		</div>

		<div class="border-t border-white/10">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex flex-col md:flex-row gap-3 items-start md:items-center justify-between text-xs text-ink-100/60">
				<div class="flex flex-wrap items-center gap-4">
					<!-- Trust Badges with simple SVGs -->
					<?php if ( $ssl_text = get_field('ssl_text', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg> <?php echo esc_html($ssl_text); ?></span>
					<?php endif; ?>
					<?php if ( $dispatch_text = get_field('dispatch_text', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><rect width="16" height="8" x="2" y="10" rx="2"/><path d="M2 14h16"/><path d="M22 14v-4l-4-4H6"/><path d="M6 6v4"/></svg> <?php echo esc_html($dispatch_text); ?></span>
					<?php endif; ?>
					<?php if ( $checkout_text = get_field('checkout_text', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg> <?php echo esc_html($checkout_text); ?></span>
					<?php endif; ?>
					<?php if ( $location_text = get_field('location_text', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg> <?php echo esc_html($location_text); ?></span>
					<?php endif; ?>
					<?php if ( $support_email = get_field('support_email', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg> <?php echo esc_html($support_email); ?></span>
					<?php endif; ?>
					<?php if ( $support_phone = get_field('whatsapp_number', 'option') ) : ?>
					<span class="inline-flex items-center gap-1.5"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-brand-300"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg> <?php echo esc_html($support_phone); ?></span>
					<?php endif; ?>
				</div>
				<div class="flex flex-wrap items-center gap-4 mt-4 md:mt-0">
					<?php if ( $copyright_text = get_field('copyright_text', 'option') ) : ?>
					<div><?php echo wp_kses_post($copyright_text); ?></div>
					<?php endif; ?>
					<span class="hidden md:inline text-white/20">|</span>
					<a href="/sitemap/" class="hover:text-white transition-colors underline underline-offset-2 decoration-white/20">Sitemap</a>
				</div>
			</div>
		</div>
	</footer>

	

</div><!-- #page -->

<!-- Mobile Menu Drawer (Bottom Sheet) -->
		<style>
		.mobile-drawer-backdrop {
			position: fixed; top: 0; left: 0; right: 0; bottom: 0;
			background-color: rgba(9, 21, 37, 0.6);
			z-index: 9998;
			opacity: 0;
			transition: opacity 0.3s ease;
			pointer-events: none;
		}
		.mobile-drawer-backdrop.is-active {
			opacity: 1;
			pointer-events: auto;
		}
		.mobile-drawer {
			position: fixed; left: 0; right: 0; bottom: 0;
			background-color: #ffffff;
			z-index: 9999;
			border-radius: 24px 24px 0 0;
			box-shadow: 0 -10px 40px rgba(0,0,0,0.1);
			transform: translateY(100%);
			transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1);
			display: flex; flex-direction: column;
			max-height: 85vh;
		}
		.mobile-drawer.is-active {
			transform: translateY(0);
		}
		</style>
		<div id="mobile-menu-backdrop" class="mobile-drawer-backdrop lg:hidden" aria-hidden="true"></div>
		
        <div id="mobile-menu" class="mobile-drawer lg:hidden">
			<div class="p-5 flex items-center justify-between border-b border-ink-100">
				<span class="font-serif font-semibold text-xl text-ink-900">Menu</span>
				<button id="mobile-menu-close" class="w-10 h-10 grid place-items-center rounded-full bg-ink-50 text-ink-500 hover:bg-ink-100 hover:text-ink-900 transition-colors" aria-label="Close menu">
					<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
				</button>
			</div>
            <nav class="flex flex-col overflow-y-auto pb-8">
                <?php
                wp_nav_menu( array(
                    'theme_location' => 'mobile',
                    'menu_id'        => 'mobile-menu-items',
                    'container'      => false,
                    'items_wrap'     => '%3$s',
                    'fallback_cb'    => false,
                ) );
                ?>
            </nav>
        </div>
		
	
	<!-- Mobile menu toggle script -->
	<script>
		const menuBtn = document.getElementById('mobile-menu-btn');
		const menuClose = document.getElementById('mobile-menu-close');
		const menu = document.getElementById('mobile-menu');
		const backdrop = document.getElementById('mobile-menu-backdrop');

		if (menuBtn && menuClose && menu && backdrop) {
			function openMenu() {
				backdrop.classList.add('is-active');
				menu.classList.add('is-active');
				document.body.style.overflow = 'hidden';
			}

			function closeMenu() {
				backdrop.classList.remove('is-active');
				menu.classList.remove('is-active');
				document.body.style.overflow = '';
			}

			menuBtn.addEventListener('click', openMenu);
			menuClose.addEventListener('click', closeMenu);
			backdrop.addEventListener('click', closeMenu);
		}
	</script>
<?php wp_footer(); ?>

<?php get_template_part( 'template-parts/search-modal' ); ?>
</body>
</html>






<?php
/**
 * Front-end scripts, font preload and Google Analytics.
 *
 * Styles are enqueued in functions.php (style.css, built from input.css).
 *
 * @package Armodafinil_Australia
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'wp_enqueue_scripts', function () {
	$dir = get_template_directory();
	$uri = get_template_directory_uri();

	wp_enqueue_script( 'armo-site', $uri . '/assets/js/site.js', array(), (string) filemtime( $dir . '/assets/js/site.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );
	wp_enqueue_script( 'armo-search', $uri . '/assets/js/search.js', array(), (string) filemtime( $dir . '/assets/js/search.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );

	wp_enqueue_script( 'armo-product-card', $uri . '/assets/js/product-card.js', array(), (string) filemtime( $dir . '/assets/js/product-card.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );

	wp_enqueue_script( 'armo-reviews', $uri . '/assets/js/reviews.js', array(), (string) filemtime( $dir . '/assets/js/reviews.js' ), array( 'in_footer' => true, 'strategy' => 'defer' ) );

	if ( function_exists( 'is_product' ) && ( is_product() || is_cart() ) ) {
		wp_enqueue_script( 'armo-product-total', $uri . '/assets/js/product-total.js', array( 'jquery' ), (string) filemtime( $dir . '/assets/js/product-total.js' ), true );
	}
} );

/**
 * Preload the heading font so the first paint does not wait for it.
 */
add_action( 'wp_head', function () {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_template_directory_uri() . '/assets/fonts/poppins-latin-700-normal.woff2' )
	);
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_template_directory_uri() . '/assets/fonts/inter-latin-wght-normal.woff2' )
	);
}, 1 );

/**
 * Google Analytics, ID from Theme Settings > Tracking. Loaded after the page is idle so it
 * never competes with the first paint.
 */
add_action( 'wp_footer', function () {
	$id = trim( (string) get_field( 'ga_measurement_id', 'option' ) );
	if ( '' === $id || ! preg_match( '/^[A-Za-z0-9-]+$/', $id ) || is_user_logged_in() ) {
		return;
	}
	?>
	<script>
	window.dataLayer = window.dataLayer || [];
	function gtag(){dataLayer.push(arguments);}
	gtag('js', new Date());
	gtag('config', <?php echo wp_json_encode( $id ); ?>);
	(function () {
		var loaded = false;
		function load() {
			if (loaded) { return; }
			loaded = true;
			var s = document.createElement('script');
			s.async = true;
			s.src = 'https://www.googletagmanager.com/gtag/js?id=' + encodeURIComponent(<?php echo wp_json_encode( $id ); ?>);
			document.head.appendChild(s);
		}
		['scroll', 'pointerdown', 'keydown'].forEach(function (name) {
			window.addEventListener(name, load, { once: true, passive: true });
		});
		window.addEventListener('load', function () { setTimeout(load, 3000); });
	})();
	</script>
	<?php
}, 99 );

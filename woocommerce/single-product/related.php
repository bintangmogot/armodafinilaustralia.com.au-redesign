<?php
/**
 * Related Products
 */
if ( ! defined( 'ABSPATH' ) ) exit;
if ( $related_products ) : ?>
	<section class="related products mt-0">
		<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
			<?php foreach ( $related_products as $related_product ) : ?>
					<?php
					$post_object = get_post( $related_product->get_id() );
					setup_postdata( $GLOBALS['post'] =& $post_object );
					wc_get_template_part( 'content', 'product' );
					?>
			<?php endforeach; ?>
		</div>
	</section>
<?php
endif;
wp_reset_postdata();

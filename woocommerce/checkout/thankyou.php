<?php
/**
 * Thank you page. Wording comes from Theme Settings > Thank You; payment instructions (bank
 * details) come from the payment gateway through WooCommerce hooks.
 *
 * @package Armodafinil_Australia
 * @var WC_Order $order
 */

defined( 'ABSPATH' ) || exit;

$title      = armo_label( 'label_thankyou_title' );
$intro      = armo_label( 'label_thankyou_text' );
$id_label   = armo_label( 'label_thankyou_order_id' );
$next_title = armo_label( 'label_thankyou_next_title' );
$steps      = get_field( 'thankyou_steps', 'option' );
$shop_label = armo_label( 'label_continue_shopping' );
$home_label = armo_label( 'label_back_home' );
?>
<section class="section bg-secondary/50 woocommerce-order">
	<div class="container-site mx-auto max-w-3xl">
	<?php if ( $order ) : ?>
		<?php do_action( 'woocommerce_before_thankyou', $order->get_id() ); ?>

		<?php if ( $order->has_status( 'failed' ) ) : ?>
			<p class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-900"><?php esc_html_e( 'Unfortunately your order cannot be processed as the originating bank/merchant has declined your transaction. Please attempt your purchase again.', 'woocommerce' ); ?></p>
			<p class="flex flex-wrap gap-3">
				<a href="<?php echo esc_url( $order->get_checkout_payment_url() ); ?>" class="btn-buy"><?php esc_html_e( 'Pay', 'woocommerce' ); ?></a>
				<?php if ( is_user_logged_in() ) : ?>
					<a href="<?php echo esc_url( wc_get_page_permalink( 'myaccount' ) ); ?>" class="btn-outline"><?php esc_html_e( 'My account', 'woocommerce' ); ?></a>
				<?php endif; ?>
			</p>
		<?php else : ?>
			<div class="space-y-6">
				<div class="rounded-2xl border border-border bg-white p-6 text-center md:p-8">
					<span class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-success/10 text-success" aria-hidden="true">
						<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
					</span>
					<?php if ( $title ) : ?><h1 class="font-heading text-3xl font-bold text-primary"><?php echo esc_html( $title ); ?></h1><?php endif; ?>
					<?php if ( $intro ) : ?>
						<p class="mx-auto mt-3 max-w-lg leading-relaxed text-muted-foreground"><?php echo esc_html( str_replace( array( '{name}', '{email}' ), array( $order->get_billing_first_name(), $order->get_billing_email() ), $intro ) ); ?></p>
					<?php endif; ?>
					<p class="mt-5 inline-flex items-center gap-2 rounded-lg border border-border bg-secondary px-4 py-2 font-mono text-sm font-semibold text-primary">
						<?php echo $id_label ? esc_html( $id_label ) . ' ' : ''; ?><?php echo esc_html( $order->get_order_number() ); ?>
					</p>
				</div>

				<?php if ( ! empty( $steps ) ) : ?>
					<div class="rounded-2xl border border-border bg-white p-6 md:p-8">
						<?php if ( $next_title ) : ?><h2 class="mb-5 font-heading text-xl font-semibold text-primary"><?php echo esc_html( $next_title ); ?></h2><?php endif; ?>
						<ol class="m-0 list-none space-y-4 p-0 text-sm text-foreground">
							<?php foreach ( $steps as $index => $step ) : ?>
								<li class="flex gap-4">
									<span class="inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-primary text-xs font-bold text-white"><?php echo (int) $index + 1; ?></span>
									<span class="leading-relaxed"><?php echo ! empty( $step['title'] ) ? '<strong class="text-primary">' . esc_html( $step['title'] ) . '</strong> ' : ''; ?><?php echo esc_html( $step['text'] ?? '' ); ?></span>
								</li>
							<?php endforeach; ?>
						</ol>
					</div>
				<?php endif; ?>

				<div class="woocommerce-thankyou-hooks space-y-6">
					<?php do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
					<?php do_action( 'woocommerce_thankyou', $order->get_id() ); ?>
				</div>

				<div class="flex flex-wrap justify-center gap-3 pt-2">
					<?php if ( $shop_label ) : ?><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary"><?php echo esc_html( $shop_label ); ?></a><?php endif; ?>
					<?php if ( $home_label ) : ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn-outline"><?php echo esc_html( $home_label ); ?></a><?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	<?php else : ?>
		<div class="rounded-2xl border border-border bg-white p-8 text-center">
			<h1 class="mb-3 font-heading text-3xl font-bold text-primary"><?php echo esc_html( $title ?: __( 'Order received', 'woocommerce' ) ); ?></h1>
			<?php if ( $shop_label ) : ?><a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="btn-primary mt-4"><?php echo esc_html( $shop_label ); ?></a><?php endif; ?>
		</div>
	<?php endif; ?>
	</div>
</section>

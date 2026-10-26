<?php
/**
 * Module: hero_section (modules field).
 * Fields: image (url), title, subtitle, tagline, button_text, button_link, features (repeater: feature_text)
 *
 * @package Armodafinil_Australia
 */

$image       = get_sub_field( 'image' );
$title       = get_sub_field( 'title' );
$subtitle    = get_sub_field( 'subtitle' );
$tagline     = get_sub_field( 'tagline' );
$button_text = get_sub_field( 'button_text' );
$button_link = get_sub_field( 'button_link' );

if ( ! $title && ! $subtitle && ! $image ) {
	return;
}

$image_id = 0;
if ( is_numeric( $image ) ) {
	$image_id = (int) $image;
} elseif ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( $image ) {
	$image_id = (int) attachment_url_to_postid( $image );
}

// The first word of the title picks up the accent colour.
$title_html = '';
if ( $title ) {
	$words      = explode( ' ', $title, 2 );
	$title_html = '<span class="text-accent">' . esc_html( $words[0] ) . '</span>' . ( isset( $words[1] ) ? ' ' . esc_html( $words[1] ) : '' );
}
?>
<section class="relative isolate overflow-hidden bg-primary text-white">
	<?php if ( $image_id ) : ?>
		<?php
		echo wp_get_attachment_image(
			$image_id,
			'full',
			false,
			array(
				'alt'           => '',
				'class'         => 'absolute inset-0 -z-20 h-full w-full object-cover object-[70%_center] md:object-bottom',
				'loading'       => 'eager',
				'fetchpriority' => 'high',
				'decoding'      => 'async',
				'sizes'         => '100vw',
			)
		);
		?>
	<?php elseif ( $image ) : ?>
		<img src="<?php echo esc_url( $image ); ?>" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover object-[70%_center] md:object-bottom" fetchpriority="high" decoding="async">
	<?php endif; ?>
	<div class="absolute inset-0 -z-10 bg-gradient-to-r from-primary via-primary/85 to-primary/20 md:via-primary/70"></div>

	<div class="container-site flex min-h-[520px] items-center py-14 md:min-h-[600px] md:py-20">
		<div class="max-w-[680px]">
			<?php if ( $title_html ) : ?>
				<h1 class="font-heading text-[clamp(2.25rem,1.6rem+3vw,3.75rem)] font-bold leading-[1.1] text-white"><?php echo wp_kses( $title_html, array( 'span' => array( 'class' => true ) ) ); ?></h1>
			<?php endif; ?>

			<?php if ( $subtitle ) : ?>
				<p class="mt-4 text-lg font-semibold leading-snug text-white/90 md:text-2xl"><?php echo esc_html( $subtitle ); ?></p>
			<?php endif; ?>

			<?php if ( $tagline ) : ?>
				<p class="mt-3 text-base text-white/80 md:text-lg"><?php echo esc_html( $tagline ); ?></p>
			<?php endif; ?>

			<?php if ( have_rows( 'features' ) ) : ?>
				<ul class="m-0 mt-6 list-none space-y-2.5 p-0">
					<?php while ( have_rows( 'features' ) ) : the_row(); ?>
						<?php $feature_text = get_sub_field( 'feature_text' ); ?>
						<?php if ( $feature_text ) : ?>
							<li class="flex items-start gap-3 text-base text-white/90 md:text-lg">
								<span class="mt-0.5 inline-flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-accent text-primary" aria-hidden="true">
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
								</span>
								<span><?php echo esc_html( $feature_text ); ?></span>
							</li>
						<?php endif; ?>
					<?php endwhile; ?>
				</ul>
			<?php endif; ?>

			<?php if ( $button_text && $button_link ) : ?>
				<div class="mt-8">
					<a href="<?php echo esc_url( $button_link ); ?>" class="btn-buy h-14 px-7 text-base">
						<?php echo esc_html( $button_text ); ?>
						<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m9 18 6-6-6-6"/></svg>
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

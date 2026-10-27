<?php
/**
 * Module: breadcrumb (modules field). No fields; built from the page hierarchy.
 *
 * @package Armodafinil_Australia
 */

$home_label = armo_label( 'label_home' );
$trail      = array();
if ( $home_label ) {
	$trail[] = array( $home_label, home_url( '/' ) );
}
foreach ( array_reverse( get_post_ancestors( get_the_ID() ) ) as $ancestor ) {
	$trail[] = array( get_the_title( $ancestor ), get_permalink( $ancestor ) );
}
$chevron = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" class="shrink-0 text-muted-foreground"><path d="m9 18 6-6-6-6"/></svg>';
?>
<nav class="border-b border-border bg-secondary" aria-label="<?php echo esc_attr( $home_label ?: get_bloginfo( 'name' ) ); ?>">
	<ol class="container-site m-0 flex list-none flex-wrap items-center gap-1.5 py-3 text-sm text-muted-foreground">
		<?php foreach ( $trail as $crumb ) : ?>
			<li class="flex items-center gap-1.5"><a href="<?php echo esc_url( $crumb[1] ); ?>" class="hover:text-primary hover:underline"><?php echo esc_html( $crumb[0] ); ?></a><?php echo $chevron; // phpcs:ignore ?></li>
		<?php endforeach; ?>
		<li class="font-medium text-primary" aria-current="page"><?php the_title(); ?></li>
	</ol>
</nav>

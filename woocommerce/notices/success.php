<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $notices ) {
	return;
}
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 woocommerce-notices-custom-wrapper">
    <?php foreach ( $notices as $notice ) : ?>
        <div class="p-4 mb-4 rounded-xl bg-green-50 text-green-900 border border-green-200 flex items-center gap-3 shadow-sm" <?php echo wc_get_notice_data_attr( $notice ); ?> role="alert">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor" class="text-green-600 shrink-0"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/></svg>
            <div class="flex-1 text-sm font-medium leading-relaxed">
                <?php echo wc_kses_notice( $notice['notice'] ); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>


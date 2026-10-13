<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! $notices ) {
	return;
}
?>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6 woocommerce-notices-custom-wrapper">
    <div class="p-4 mb-4 rounded-xl bg-red-50 text-red-900 border border-red-200 shadow-sm" role="alert">
        <ul class="space-y-2 !m-0 !p-0 list-none">
            <?php foreach ( $notices as $notice ) : ?>
                <li class="flex items-start gap-3 !m-0" <?php echo wc_get_notice_data_attr( $notice ); ?>>
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#dc2626" class="shrink-0 mt-0.5"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm5 13.59L15.59 17 12 13.41 8.41 17 7 15.59 10.59 12 7 8.41 8.41 7 12 10.59 15.59 7 17 8.41 13.41 12 17 15.59z"/></svg>
                    <div class="flex-1 text-sm font-medium leading-relaxed">
                        <?php echo wc_kses_notice( $notice['notice'] ); ?>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


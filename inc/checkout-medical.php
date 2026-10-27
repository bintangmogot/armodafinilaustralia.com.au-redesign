<?php
/**
 * Checkout - Medical Conditions Section
 *
 * Renders the "Medical Conditions" form on the right column of the
 * checkout page, saves the data to the order meta, and displays
 * the values in WP-Admin order details.
 *
 * @package Armodafinil_Australia
 * @since   2.1.0
 */

defined( 'ABSPATH' ) || exit;

/* ─────────────────────────────────────────────
 * 1. RENDER THE MEDICAL CONDITIONS FORM
 * ───────────────────────────────────────────── */
add_action( 'armo_custom_checkout_medical_conditions', 'armo_render_medical_conditions', 10 );

function armo_render_medical_conditions() {
	$text_fields = array(
		'medical_physician_name'      => armo_label( 'label_med_physician' ),
		'medical_physician_phone'     => armo_label( 'label_med_physician_phone' ),
		'medical_drug_allergies'      => armo_label( 'label_med_allergies' ),
		'medical_current_medications' => armo_label( 'label_med_medications' ),
		'medical_current_treatments'  => armo_label( 'label_med_treatments' ),
	);
	$yes_no_fields = array(
		'medical_smoke' => armo_label( 'label_med_smoke' ),
		'medical_drink' => armo_label( 'label_med_drink' ),
	);
	$title         = armo_label( 'label_med_title' );
	$yes           = armo_label( 'label_med_yes' );
	$no            = armo_label( 'label_med_no' );
	$certification = (string) get_field( 'medical_certification', 'option' );
	$upload_title  = armo_label( 'label_med_upload_title' );
	$upload_text   = armo_label( 'label_med_upload_text' );
	$choose_file   = armo_label( 'label_med_choose_file' );
	$selected      = armo_label( 'label_med_selected' );
	?>
	<div class="medical-condition-fields">
	<?php if ( $title ) : ?>
		<h3><?php echo esc_html( $title ); ?></h3>
	<?php endif; ?>

	<div class="medical-conditions-body p-6">
		<?php foreach ( $text_fields as $name => $label ) : ?>
			<?php if ( ! $label ) { continue; } ?>
			<div class="medical-row">
				<label for="<?php echo esc_attr( $name ); ?>"><?php echo esc_html( $label ); ?></label>
				<div class="medical-input-wrap">
					<input type="text" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" class="input-text" autocomplete="off" />
				</div>
			</div>
		<?php endforeach; ?>

		<?php if ( $yes && $no ) : ?>
			<div class="medical-radio-row">
				<?php foreach ( $yes_no_fields as $name => $label ) : ?>
					<?php if ( ! $label ) { continue; } ?>
					<div class="medical-radio-group">
						<p class="medical-radio-label"><?php echo esc_html( $label ); ?></p>
						<ul>
							<li><label><input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $no ); ?>" checked /> <span><?php echo esc_html( $no ); ?></span></label></li>
							<li><label><input type="radio" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $yes ); ?>" /> <span><?php echo esc_html( $yes ); ?></span></label></li>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<?php if ( $certification ) : ?>
			<div class="medical-certification-box"><p><?php echo esc_html( $certification ); ?></p></div>
		<?php endif; ?>

		<?php if ( $upload_title ) : ?>
			<div class="medical-upload-section">
				<h4 class="medical-upload-title"><?php echo esc_html( $upload_title ); ?></h4>
				<div class="medical-upload-dropzone" id="medical_dropzone" data-selected="<?php echo esc_attr( $selected ); ?>">
					<svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0-12L8 8m4-4l4 4"/></svg>
					<p><?php echo esc_html( $upload_text ); ?> <?php if ( $choose_file ) : ?><label for="medical_prescription" class="choose-file-link"><?php echo esc_html( $choose_file ); ?></label><?php endif; ?></p>
					<input type="file" id="medical_prescription" name="medical_prescription" accept=".jpg,.jpeg,.png,.pdf,.webp" />
				</div>
			</div>
		<?php endif; ?>
	</div>
	</div>
	<?php
}


/* ─────────────────────────────────────────────
 * 2. VALIDATE (optional - fields are not required)
 * ───────────────────────────────────────────── */
// If you later need required fields, add validation here:
// add_action( 'woocommerce_checkout_process', 'armo_validate_medical_fields' );


/* ─────────────────────────────────────────────
 * 3. SAVE DATA TO ORDER META
 * ───────────────────────────────────────────── */
add_action( 'woocommerce_checkout_update_order_meta', 'armo_save_medical_fields' );

function armo_save_medical_fields( $order_id ) {
    $fields = array(
        'medical_physician_name',
        'medical_physician_phone',
        'medical_drug_allergies',
        'medical_current_medications',
        'medical_current_treatments',
        'medical_smoke',
        'medical_drink',
    );

    foreach ( $fields as $field ) {
        if ( ! empty( $_POST[ $field ] ) ) {
            update_post_meta( $order_id, '_' . $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
        }
    }

    // Handle file upload
    if ( ! empty( $_FILES['medical_prescription']['name'] ) ) {
        require_once ABSPATH . 'wp-admin/includes/file.php';
        require_once ABSPATH . 'wp-admin/includes/media.php';
        require_once ABSPATH . 'wp-admin/includes/image.php';

        $attachment_id = media_handle_upload( 'medical_prescription', 0 );
        if ( ! is_wp_error( $attachment_id ) ) {
            update_post_meta( $order_id, '_medical_prescription', $attachment_id );
        }
    }
}


/* ─────────────────────────────────────────────
 * 4. DISPLAY IN WP-ADMIN ORDER DETAILS
 * ───────────────────────────────────────────── */
add_action( 'woocommerce_admin_order_data_after_billing_address', 'armo_display_medical_fields_admin', 10, 1 );

function armo_display_medical_fields_admin( $order ) {
    $order_id = $order->get_id();

    $fields = array(
        'medical_physician_name'      => 'Physician\'s Name',
        'medical_physician_phone'     => 'Physician\'s Phone',
        'medical_drug_allergies'      => 'Drug Allergies',
        'medical_current_medications' => 'Current Medications',
        'medical_current_treatments'  => 'Current Treatments',
        'medical_smoke'               => 'Smoker',
        'medical_drink'               => 'Drinks Alcohol',
    );

    echo '<div class="medical-admin-fields" style="margin-top:20px;">';
    echo '<h3 style="color:#00125E;">Medical Conditions</h3>';

    foreach ( $fields as $key => $label ) {
        $value = get_post_meta( $order_id, '_' . $key, true );
        if ( $value ) {
            echo '<p><strong>' . esc_html( $label ) . ':</strong> ' . esc_html( $value ) . '</p>';
        }
    }

    $prescription_id = get_post_meta( $order_id, '_medical_prescription', true );
    if ( $prescription_id ) {
        $url = wp_get_attachment_url( $prescription_id );
        echo '<p><strong>Prescription:</strong> <a href="' . esc_url( $url ) . '" target="_blank">View File</a></p>';
    }

    echo '</div>';
}

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
    ?>
    <!-- Medical Conditions header -->
    <h3>Medical Conditions</h3>

    <div class="medical-conditions-body p-6">
        <!-- Physician's Name -->
        <div class="medical-row">
            <label for="medical_physician_name">Your Physician's Name</label>
            <div class="medical-input-wrap">
                <input type="text" id="medical_physician_name" name="medical_physician_name"
                       class="input-text" autocomplete="off" />
            </div>
        </div>

        <!-- Physician's Telephone No -->
        <div class="medical-row">
            <label for="medical_physician_phone">Physician's Telephone No:</label>
            <div class="medical-input-wrap">
                <input type="text" id="medical_physician_phone" name="medical_physician_phone"
                       class="input-text" autocomplete="off" />
            </div>
        </div>

        <!-- Drug Allergies -->
        <div class="medical-row">
            <label for="medical_drug_allergies">Drug Allergies:</label>
            <div class="medical-input-wrap">
                <input type="text" id="medical_drug_allergies" name="medical_drug_allergies"
                       class="input-text" autocomplete="off" />
            </div>
        </div>

        <!-- Current Medications -->
        <div class="medical-row">
            <label for="medical_current_medications">Current Medications:</label>
            <div class="medical-input-wrap">
                <input type="text" id="medical_current_medications" name="medical_current_medications"
                       class="input-text" autocomplete="off" />
            </div>
        </div>

        <!-- Current Treatments -->
        <div class="medical-row">
            <label for="medical_current_treatments">Current Treatments:</label>
            <div class="medical-input-wrap">
                <input type="text" id="medical_current_treatments" name="medical_current_treatments"
                       class="input-text" autocomplete="off" />
            </div>
        </div>

        <!-- Smoke / Drink row -->
        <div class="medical-radio-row">
            <div class="medical-radio-group">
                <p class="medical-radio-label">Do you Smoke?</p>
                <ul>
                    <li>
                        <label>
                            <input type="radio" name="medical_smoke" value="No" checked />
                            <span>No</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="medical_smoke" value="Yes" />
                            <span>Yes</span>
                        </label>
                    </li>
                </ul>
            </div>
            <div class="medical-radio-group">
                <p class="medical-radio-label">Do you drink Alcohol?</p>
                <ul>
                    <li>
                        <label>
                            <input type="radio" name="medical_drink" value="No" checked />
                            <span>No</span>
                        </label>
                    </li>
                    <li>
                        <label>
                            <input type="radio" name="medical_drink" value="Yes" />
                            <span>Yes</span>
                        </label>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Certification disclaimer -->
        <div class="medical-certification-box">
            <p>
                I certify that I am 'over 18 years' and that I am under the
                supervision of a doctor. The ordered medication is for my
                own personal use and is strictly not meant for a re-sale.
                I also accept that I am taking the medicine at my own
                risk and that I am duly aware of all the effects / side effects
                of the medicine. I acknowledge that the drugs are as
                per the norms of the country of destination.
            </p>
        </div>

        <!-- Upload Prescription -->
        <div class="medical-upload-section">
            <h4 class="medical-upload-title">Upload Prescription</h4>
            <div class="medical-upload-dropzone" id="medical_dropzone">
                <svg class="upload-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M12 4v12m0-12L8 8m4-4l4 4"/>
                </svg>
                <p>Drag &amp; Drop or <label for="medical_prescription" class="choose-file-link">Choose file</label> to upload</p>
                <input type="file" id="medical_prescription" name="medical_prescription"
                       accept=".jpg,.jpeg,.png,.pdf,.webp" />
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var dropzone = document.getElementById('medical_dropzone');
        var fileInput = document.getElementById('medical_prescription');
        
        if (!dropzone || !fileInput) return;
        
        var fileNameDisplay = document.createElement('p');
        fileNameDisplay.style.color = '#00125E';
        fileNameDisplay.style.fontWeight = 'bold';
        fileNameDisplay.style.marginTop = '10px';
        dropzone.appendChild(fileNameDisplay);

        dropzone.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.style.borderColor = '#00125E';
            dropzone.style.backgroundColor = '#f8fafc';
        });

        dropzone.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.style.borderColor = '';
            dropzone.style.backgroundColor = '';
        });

        dropzone.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            dropzone.style.borderColor = '';
            dropzone.style.backgroundColor = '';
            
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                fileInput.files = e.dataTransfer.files;
                fileNameDisplay.textContent = 'Selected: ' + fileInput.files[0].name;
            }
        });
        
        // Allow clicking the entire dropzone to open the file dialog
        dropzone.addEventListener('click', function(e) {
            // Prevent triggering if the user clicked the label or the input directly
            if (e.target !== fileInput && e.target.tagName !== 'LABEL') {
                fileInput.click();
            }
        });

        fileInput.addEventListener('change', function() {
            if (fileInput.files && fileInput.files.length > 0) {
                fileNameDisplay.textContent = 'Selected: ' + fileInput.files[0].name;
            }
        });
    });
    </script>
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

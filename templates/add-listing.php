<div class="directorist-form-group directorist-form-multi-address-field">

    <label class="directorist-form-label" for="addresses"><?php echo $data['label'];?></label>

    <!-- Holder for all address items -->
    <div class="address_field_holder">
        <?php 
        $addresses = $args['addresses'] ?? [];
        if ( ! empty( $addresses ) ) :
            foreach ( $addresses as $index => $address ) :
        ?>
        <div class="address_item">
            <!-- First line: full-width Address -->
            <div class="address_line">
                <label>Address:</label>
                <input type="text" class="google_addresses" name="addresses[]" placeholder="Enter address">
            </div>

            <!-- Second line: Extra Fields -->
            <div class="branch_line">
                <div class="branch_label_wrapper">
                    <label>Optional Branch Label:</label>
                    <input type="text" name="branch_label[]" class="branch_label" placeholder="Enter branch label">
                </div>
                <div class="branch_phone_wrapper">
                    <label>Optional Phone:</label>
                    <input type="text" name="branch_phone[]" class="branch_phone" placeholder="Enter phone number">
                </div>
            </div>

            <!-- Hidden inputs -->
            <input type="hidden" class="google_addresses_lat" name="latitude[]" value="">
            <input type="hidden" class="google_addresses_lng" name="longitude[]" value="">

            <!-- Remove button -->
            <button type="button" class="remove_address_btn">X</button>
        </div>

        <?php endforeach;
        else: ?>
        <div class="address_item">
            <div class="address_line">
                <label>Address:</label>
                <input type="text" class="google_addresses" name="addresses[]" placeholder="Enter address">
            </div>
            <div class="branch_line">
                <div class="branch_label_wrapper">
                    <label>Optional Branch Label:</label>
                    <input type="text" name="branch_label[]" class="branch_label" placeholder="Enter branch label">
                </div>
                <div class="branch_phone_wrapper">
                    <label>Optional Phone:</label>
                    <input type="text" name="branch_phone[]" class="branch_phone" placeholder="Enter phone number">
                </div>
            </div>
            <input type="hidden" class="google_addresses_lat" name="latitude[]" value="">
            <input type="hidden" class="google_addresses_lng" name="longitude[]" value="">
            <button type="button" class="remove_address_btn" style="display:none;">X</button>
        </div>
        <?php endif; ?>
    </div>

    <!-- Add new address button -->
    <button type="button" class="add_address_btn">+ Add Address</button>

    <!-- Hidden JSON field -->
    <input type="hidden" name="<?php echo esc_attr( $data['field_key'] ); ?>" class="google_addresses_json" value="<?php echo esc_attr( $data['value'] ); ?>">

</div>

<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 7.0.5.6
 */


if ( ! defined( 'ABSPATH' ) ) exit;
?>

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
            <!-- Address input -->
            <div>
                <label>Address:</label>
                <input type="text" autocomplete="off" name="addresses[]" class="google_addresses" placeholder="Enter address" value="<?php echo esc_attr( $address['address'] ?? '' ); ?>">
            </div>

            <!-- Branch label -->
            <div>
                <label>Optional Branch Label:</label>
                <input type="text" name="branch_label[]" class="branch_label" placeholder="Enter branch label">
            </div>

            <!-- Phone -->
            <div>
                <label>Optional Phone:</label>
                <input type="text" name="branch_phone[]" class="branch_phone" placeholder="Enter phone number">
            </div>

            <!-- Hidden latitude & longitude -->
            <input type="hidden" class="google_addresses_lat" name="latitude[]" value="<?php echo esc_attr( $address['latitude'] ?? '' ); ?>">
            <input type="hidden" class="google_addresses_lng" name="longitude[]" value="<?php echo esc_attr( $address['longitude'] ?? '' ); ?>">

            <!-- Remove button -->
            <button type="button" class="remove_address_btn" <?php echo $index === 0 ? 'style="display:none;"' : ''; ?>>X</button>
        </div>
        <?php endforeach; 
        else: ?>
        <div class="address_item">
            <div>
                <label>Address:</label>
                <input type="text" autocomplete="off" name="addresses[]" class="google_addresses" placeholder="Enter address">
            </div>
            <div>
                <label>Optional Branch Label:</label>
                <input type="text" name="branch_label[]" class="branch_label" placeholder="Enter branch label">
            </div>
            <div>
                <label>Optional Phone:</label>
                <input type="text" name="branch_phone[]" class="branch_phone" placeholder="Enter phone number">
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


<?php

/**
 * Add your custom php code here
 */

/**
 * Get multi-location data for a listing.
 *
 * @param int $listing_id Listing ID.
 * @return array Array of locations with lat, lng, title, address, phone, image.
 */
function get_listing_multi_locations( $listing_id = 0 ) {

	if ( empty( $listing_id ) ) {
		$listing_id = get_the_ID();
	}
    if ( ! $listing_id ) {
        return [];
    }

    $result = [];

    // 1️⃣ Get main address first
    $main_address = get_post_meta( $listing_id, '_address', true );
    if ( ! empty( $main_address ) ) {
        $result[] = [
            'lat'     => 0, // Optional: if you have default latitude
            'lng'     => 0, // Optional: if you have default longitude
            'title'   => 'Main Location',
            'address' => $main_address,
            'phone'   => get_post_meta( $listing_id, '_phone', true ) ?: '',
        ];
    }

    // 2️⃣ Get multilocation addresses
    $multilocations = get_post_meta( $listing_id, '_multilocation', true );
    if ( ! empty( $multilocations ) ) {
        $locations = json_decode( $multilocations, true );
        if ( is_array( $locations ) ) {
            foreach ( $locations as $loc ) {
                $result[] = [
                    'lat'     => ! empty( $loc['latitude'] ) ? floatval( $loc['latitude'] ) : 0,
                    'lng'     => ! empty( $loc['longitude'] ) ? floatval( $loc['longitude'] ) : 0,
                    'title'   => ! empty( $loc['branch_label'] ) ? $loc['branch_label'] : '',
                    'address' => ! empty( $loc['address'] ) ? $loc['address'] : '',
                    'phone'   => ! empty( $loc['phone'] ) ? $loc['phone'] : '',
                ];
            }
        }
    }

    return $result;
}


<?php
/**
 * Single Listing Map Template
 *
 * Supports multiple service locations per listing.
 *
 * @package Directorist
 * @since 7.7.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

echo "map";

// $listing should be the current listing object
    // $map_data = $listing->map_data();
    // $id = $listing->id();

// var_dump( $args['listing']['id'] );

//     $service_locations = get_post_meta($id, '_multilocation', true);
//     $service_locations = !empty($service_locations) ? json_decode($service_locations, true) : [];

//     // fallback to single location if empty
//     if (empty($service_locations)) {
//         $service_locations = [
//             [
//                 'address'  => get_post_meta($id, '_address', true),
//                 'latitude' => get_post_meta($id, '_manual_lat', true),
//                 'longitude'=> get_post_meta($id, '_manual_lng', true),
//                 'branch_label' => ''
//             ]
//         ];
//     }

//     $locations_data = [];

//     foreach ($service_locations as $loc) {
//         // Use branch_label if exists, otherwise listing title
//         $title = !empty($loc['branch_label']) ? esc_html($loc['branch_label']) : get_the_title($id);

//         // Use provided latitude/longitude or fallback
//         $lat = !empty($loc['latitude']) ? $loc['latitude'] : get_post_meta($id, '_manual_lat', true);
//         $lng = !empty($loc['longitude']) ? $loc['longitude'] : get_post_meta($id, '_manual_lng', true);

//         $info_content  = '<div class="map-info-wrapper map-listing-card-single">';
//         $info_content .= '<h3>' . $title . '</h3>';
//         $info_content .= '<p>' . esc_html($loc['address']) . '</p>';
//         $info_content .= '</div>';

//         $locations_data[] = [
//             'manual_lat'     => $lat,
//             'manual_lng'     => $lng,
//             'info_content'   => $info_content,
//             'map_zoom_level' => get_directorist_option('map_zoom_level', 16),
//         ];
//     }
// ?>




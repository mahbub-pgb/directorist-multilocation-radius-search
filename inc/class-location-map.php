<?php

/**
 * Multi Location Map extending Directorist Listings
 */

// Exit if accessed directly.
defined('ABSPATH') || die('Direct access is not allowed.');

use Directorist\Directorist_Listings;
use Directorist\Helper;

if ( ! class_exists( 'Multi_Location_Map' ) ) :

class Multi_Location_Map extends Directorist_Listings {

    protected $listing_id;

    public function __construct( $listing_id = 0 ) {
        $this->listing_id = $listing_id;
        
        // Initialize parent class with listing ID
        $atts = ['ids' => $listing_id];
        parent::__construct( $atts, 'listing' );
    }

    /**
     * Get multi locations and decode JSON
     */
    public function get_multi_locations() {
        $locations = get_post_meta( $this->listing_id, '_multilocation', true );
        
        // If it's a JSON string, decode it
        if ( is_string( $locations ) && ! empty( $locations ) ) {
            $decoded = json_decode( $locations, true );
            return is_array( $decoded ) ? $decoded : [];
        }
        
        // If it's already an array, return it
        if ( is_array( $locations ) ) {
            return $locations;
        }
        
        // Return empty array as fallback
        return [];
    }

    public function get_listing_id() {
        return $this->listing_id;
    }

    /**
     * Override parent method to handle multiple locations
     */
    public function openstreet_map_card_data() {
        $opt = $this->get_map_options();
        $map_data = [];
        
        // Get multi locations for this listing
        $multi_locations = $this->get_multi_locations();
        
        // If no multi locations, fall back to parent behavior
        if ( empty( $multi_locations ) ) {
            return parent::openstreet_map_card_data();
        }

        $listings = $this->query_results;

        if ( ! empty( $listings->ids ) ) :
            // Prime caches to reduce future queries.
            if ( ! empty( $listings->ids ) && is_callable( '_prime_post_caches' ) ) {
                _prime_post_caches( $listings->ids );
            }

            $original_post = ! empty( $GLOBALS['post'] ) ? $GLOBALS['post'] : '';

            foreach ( $listings->ids as $listings_id ) :
                $GLOBALS['post'] = get_post( $listings_id );
                setup_postdata( $GLOBALS['post'] );
                $this->set_loop_data();

                // Get multi locations for current listing
                $current_multi_locations = get_post_meta( $listings_id, '_multilocation', true );
                
                // Decode if JSON string
                if ( is_string( $current_multi_locations ) && ! empty( $current_multi_locations ) ) {
                    $current_multi_locations = json_decode( $current_multi_locations, true );
                }

                // If this listing has multi locations, add them all
                if ( ! empty( $current_multi_locations ) && is_array( $current_multi_locations ) ) {
                    
                    foreach ( $current_multi_locations as $location ) {
                        // Skip if missing required data
                        if ( empty( $location['lat'] ) || empty( $location['lng'] ) ) {
                            continue;
                        }

                        $ls_data = [];
                        
                        // Use location-specific data
                        $ls_data['manual_lat']      = $location['lat'];
                        $ls_data['manual_lng']      = $location['lng'];
                        $ls_data['address']         = $location['address'] ?? get_post_meta( $listings_id, '_address', true );
                        
                        // Use listing data (same for all locations)
                        $ls_data['listing_img']     = directorist_get_listing_gallery_images( $listings_id );
                        $ls_data['listing_prv_img'] = directorist_get_listing_preview_image( $listings_id );
                        $ls_data['phone']           = get_post_meta( $listings_id, '_phone', true );
                        $ls_data['font_type']       = $this->options['font_type'];
                        $ls_data['listings']        = $this;

                        $lat_lon = [
                            'lat' => $ls_data['manual_lat'],
                            'lon' => $ls_data['manual_lng']
                        ];

                        $ls_data['lat_lon'] = $lat_lon;

                        if ( ! empty( $ls_data['listing_prv_img'] ) ) {
                            $ls_data['prv_image'] = atbdp_get_image_source( $ls_data['listing_prv_img'], 'large' );
                        }

                        $listing_type               = directorist_get_listing_directory( $listings_id );
                        $ls_data['default_image']   = Helper::default_preview_image_src( $listing_type );

                        if ( ! empty( $ls_data['listing_img'][0] ) ) {
                            $ls_data['gallery_img'] = atbdp_get_image_source( $ls_data['listing_img'][0], 'medium' );
                        }

                        $cat_icon = directorist_icon( $this->loop_map_cat_icon(), false );
                        $ls_data['cat_icon'] = $cat_icon;

                        $opt['ls_data'] = $ls_data;

                        $map_data[] = [
                            'content'   => Helper::get_template_contents( 'archive/fields/openstreet-map', $opt ),
                            'latitude'  => $location['lat'],
                            'longitude' => $location['lng'],
                            'cat_icon'  => $cat_icon,
                        ];
                    }
                    
                } else {
                    // Fall back to single location from meta
                    $ls_data = [];
                    
                    $ls_data['manual_lat']      = get_post_meta( $listings_id, '_manual_lat', true );
                    $ls_data['manual_lng']      = get_post_meta( $listings_id, '_manual_lng', true );
                    $ls_data['listing_img']     = directorist_get_listing_gallery_images( $listings_id );
                    $ls_data['listing_prv_img'] = directorist_get_listing_preview_image( $listings_id );
                    $ls_data['address']         = get_post_meta( $listings_id, '_address', true );
                    $ls_data['phone']           = get_post_meta( $listings_id, '_phone', true );
                    $ls_data['font_type']       = $this->options['font_type'];
                    $ls_data['listings']        = $this;

                    $lat_lon = [
                        'lat' => $ls_data['manual_lat'],
                        'lon' => $ls_data['manual_lng']
                    ];

                    $ls_data['lat_lon'] = $lat_lon;

                    if ( ! empty( $ls_data['listing_prv_img'] ) ) {
                        $ls_data['prv_image'] = atbdp_get_image_source( $ls_data['listing_prv_img'], 'large' );
                    }

                    $listing_type               = directorist_get_listing_directory( $listings_id );
                    $ls_data['default_image']   = Helper::default_preview_image_src( $listing_type );

                    if ( ! empty( $ls_data['listing_img'][0] ) ) {
                        $ls_data['gallery_img'] = atbdp_get_image_source( $ls_data['listing_img'][0], 'medium' );
                    }

                    $cat_icon = directorist_icon( $this->loop_map_cat_icon(), false );
                    $ls_data['cat_icon'] = $cat_icon;

                    $opt['ls_data'] = $ls_data;

                    $map_data[] = [
                        'content'   => Helper::get_template_contents( 'archive/fields/openstreet-map', $opt ),
                        'latitude'  => get_post_meta( $listings_id, '_manual_lat', true ),
                        'longitude' => get_post_meta( $listings_id, '_manual_lng', true ),
                        'cat_icon'  => $cat_icon,
                    ];
                }

            endforeach;

            $GLOBALS['post'] = $original_post;
            wp_reset_postdata();
        endif;

        return $map_data;
    }

    /**
     * Override render_map to use multi-location data
     */
    public function render_map() {
        if ( 'google' == $this->select_listing_map ) {
            $this->load_google_map();
        } else {
            $this->load_openstreet_map();
        }
    }
}

endif;
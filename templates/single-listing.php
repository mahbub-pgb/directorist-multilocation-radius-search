<?php
/**
 * Multi Location Single Listing Template
 *
 * @package Directorist
 * @since 1.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// Make sure $args['addresses'] exists and is an array
$addresses = isset( $args['addresses'] ) && is_array( $args['addresses'] ) ? $args['addresses'] : [];
?>

<div class="directorist-single-info directorist-single-info-address">

    <!-- Label -->
    <div class="directorist-single-info__label">
        <span class="directorist-single-info__label-icon">
            <?php if ( isset( $data['icon'] ) ) directorist_icon( $data['icon'] ); ?>
        </span>
        <span class="directorist-single-info__label__text">
            <?php echo isset( $data['label'] ) ? esc_html( $data['label'] ) : esc_html__( 'Locations', 'directorist' ); ?>
        </span>
    </div>

    <!-- Table -->
    <?php if ( ! empty( $addresses ) ) : ?>
        <table class="directorist-branch-table">
            <thead>
                <tr>
                    <th><?php esc_html_e( 'Branch Name', 'directorist' ); ?></th>
                    <th><?php esc_html_e( 'Phone', 'directorist' ); ?></th>
                    <th><?php esc_html_e( 'Address', 'directorist' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $addresses as $address ) : 
                    $location = ! empty( $address['address'] ) ? esc_html( $address['address'] ) : '—';
                    $branch   = ! empty( $address['branch_label'] )  ? esc_html( $address['branch_label'] )  : '—';
                    $phone    = ! empty( $address['phone'] )   ? esc_html( $address['phone'] )   : '—';
                ?>
                <tr>
                    <td><?php echo $location; ?></td>
                    <td><?php echo $branch; ?></td>
                    <td><?php echo $phone; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p><?php esc_html_e( 'No locations added.', 'directorist' ); ?></p>
    <?php endif; ?>

</div>

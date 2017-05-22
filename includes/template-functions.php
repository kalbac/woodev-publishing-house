<?php
/**
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 13:39
 * Project: woodev-publishing-house
 */

add_action( 'woocommerce_single_product_summary', 'add_publishing_house_to_product', 45 );
function add_publishing_house_to_product() {
    global $product;
    $publishing_house = get_post_meta( $product->get_id(), 'publishing_house', true );
    if( ! empty( $publishing_house ) && ( $house  = get_post( $publishing_house ) ) ) {
        printf('<div class="product-pub-house"><p>Publishing House: <a href="%s">%s</a></p></div>', get_permalink( $house ), get_the_title( $house ) );
    }
}

add_filter( 'the_content', 'add_product_list_on_pub_house' );

function add_product_list_on_pub_house( $content ) {
    if( is_singular( 'publishing_house' ) ) {
        global $wpdb;

        $found_products = wp_list_pluck( $wpdb->get_results( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key = 'publishing_house' AND meta_value = %d", get_the_ID() ), ARRAY_A ), 'post_id');

        if( $found_products && count( $found_products ) > 0 ) {
            $product_item = '';
            foreach ( $found_products as $item ) {
                $_product = wc_get_product( $item );
                $product_item .= sprintf('<li><a href="%s">%s</a></li>', $_product->get_permalink(), $_product->get_title() );
            }
            if( ! empty( $product_item ) ) {
                $content = $content . sprintf('<div class="house-sticky-product"><ul class="house-sticky-product__list">%s</ul></div>', $product_item );
            }
        }
    }
    return $content;
}
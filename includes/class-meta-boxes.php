<?php

/**
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 12:50
 * Project: woodev-publishing-house
 */
class WD_Publishing_House_Meta_Boxes {

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
        add_action( 'save_post', array( $this, 'save_meta_boxes' ), 1, 2 );
        add_action( 'woocommerce_process_product_meta', array( $this, 'show_town_list_save' ), 30, 2 );
    }

    public function add_meta_boxes() {
        add_meta_box( 'publishing-house-town', 'Город Publishing House', array( $this, 'show_town_list' ), 'publishing_house', 'normal' );
        add_meta_box( 'publishing-house-list', 'Publishing House', array( $this, 'show_town_list_view' ), 'product', 'side', 'low' );
    }

    public function show_town_list() {

        woocommerce_wp_select( array(
            'id'            => 'publishing_house_town',
            'label'         => 'Город',
            'description'   => 'Выберите город к которому относится данный дом.',
            'options'       => apply_filters( 'default_publishing_house_towns', array(
                'Москва'        => 'Москва',
                'Питер'         => 'Питер',
                'Барнаул'       => 'Барнаул',
                'Казань'        => 'Казань'
            ) )
        ) );
    }

    public function show_town_list_view() {
        woocommerce_wp_select( array(
            'id'            => 'publishing_house',
            'label'         => '',
            'options'       => wp_list_pluck( get_posts( array( 'post_type' => 'publishing_house', 'numberposts' => -1 ) ), 'post_title', 'ID' )
        ) );
    }

    public static function show_town_list_save( $post_id ) {
        update_post_meta( $post_id, 'publishing_house', esc_attr( $_POST['publishing_house'] ) );
    }

    public function save_meta_boxes( $post_id, $post ) {
        if ( empty( $post_id ) || empty( $post ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) || is_int( wp_is_post_revision( $post ) ) || is_int( wp_is_post_autosave( $post ) ) )
            return $post_id;

        if ( 'publishing_house' == $post->post_type && ! current_user_can( 'edit_publishing_house', $post_id ) ) {
            return $post_id;
        } elseif( ! current_user_can( 'edit_publishing_house', $post_id ) ) {
            return $post_id;
        }

        if ( ! isset( $_POST['publishing_house_town'] ) )
            return;

        update_post_meta( $post_id, 'publishing_house_town', esc_attr( $_POST['publishing_house_town'] ) );
    }
}

new WD_Publishing_House_Meta_Boxes();
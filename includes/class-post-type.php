<?php

/**
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 10:42
 * Project: woodev-publishing-house
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class WD_Register_Post_Type {

    public static function init() {
        add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
        add_action( 'woocommerce_flush_rewrite_rules', array( __CLASS__, 'flush_rewrite_rules' ) );
    }

    public static function register_post_types() {

        register_post_type( 'publishing_house', array(
            'labels'              => array(
                'name'                  => 'Publishing House',
                'singular_name'         => 'Publishing Houses',
                'menu_name'             => 'Publishing House',
                'add_new'               => 'Добавить Publishing House',
                'add_new_item'          => 'Добавить новый Publishing House',
                'edit'                  => 'Редактировать',
                'edit_item'             => 'Редактировать Publishing House',
                'new_item'              => 'Новый Publishing House',
                'view'                  => 'Посмотреть',
                'view_item'             => 'Посмотреть',
                'search_items'          => 'Найти Publishing House',
                'not_found'             => 'Нет найденных Publishing House',
                'not_found_in_trash'    => 'В корзине нету Publishing House',
                'parent'                => 'Родительский Publishing House',
                'featured_image'        => 'Изображение',
                'set_featured_image'    => 'Задать изображение для Publishing House',
                'remove_featured_image' => 'Удалить изображение',
                'use_featured_image'    => 'Использовать как изображение Publishing House',
                'insert_into_item'      => 'Вставить в Publishing House',
                'uploaded_to_this_item' => 'Скачать Publishing House',
                'filter_items_list'     => 'Вильтровать Publishing House',
                'items_list_navigation' => 'Навигация Publishing House',
                'items_list'            => 'Список Publishing House',
            ),
            'public'              => true,
            'show_ui'             => true,
            'capability_type'     => 'publishing_house',
            'map_meta_cap'        => true,
            'publicly_queryable'  => true,
            'exclude_from_search' => false,
            'hierarchical'        => false,
            'rewrite'             => array( 'slug' => 'houses', 'with_front' => false, 'feeds' => true ),
            'query_var'           => true,
            'supports'            => array( 'title', 'thumbnail' ),
            'has_archive'         => 'publishing_houses',
            'show_in_nav_menus'   => true,
            'show_in_rest'        => false,
        ) );
    }

    public static function flush_rewrite_rules() {
        flush_rewrite_rules();
    }
}

WD_Register_Post_Type::init();
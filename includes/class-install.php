<?php

/**
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 09:24
 * Project: woodev-publishing-house
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WD_Publishing_House_Install {

	public static function init() {

		add_action( 'init', array( __CLASS__, 'check_version' ), 5 );
	}

	public static function check_version() {
		if ( ! defined( 'IFRAME_REQUEST' ) && WC()->version >= 3 ) {
			self::install();
		}
	}

	public static function install() {

		self::create_roles();

		WD_Register_Post_Type::register_post_types();
	}

	public static function create_roles() {

		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$capabilities = self::get_core_capabilities();

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->add_cap( 'administrator', $cap );
			}
		}
	}

	public static function remove_roles() {
		global $wp_roles;

		if ( ! class_exists( 'WP_Roles' ) ) {
			return;
		}

		if ( ! isset( $wp_roles ) ) {
			$wp_roles = new WP_Roles();
		}

		$capabilities = self::get_core_capabilities();

		foreach ( $capabilities as $cap_group ) {
			foreach ( $cap_group as $cap ) {
				$wp_roles->remove_cap( 'administrator', $cap );
			}
		}
	}

	private static function get_core_capabilities() {
		$capabilities = array();

		$capabilities['core'] = array(
			'publishing_house'
		);

		$capability_types = array( 'publishing_house' );

		foreach ( $capability_types as $capability_type ) {

			$capabilities[ $capability_type ] = array(
				"edit_{$capability_type}",
				"read_{$capability_type}",
				"delete_{$capability_type}",
				"edit_{$capability_type}s",
				"edit_others_{$capability_type}s",
				"publish_{$capability_type}s",
				"read_private_{$capability_type}s",
				"delete_{$capability_type}s",
				"delete_private_{$capability_type}s",
				"delete_published_{$capability_type}s",
				"delete_others_{$capability_type}s",
				"edit_private_{$capability_type}s",
				"edit_published_{$capability_type}s",
				"manage_{$capability_type}_terms",
				"edit_{$capability_type}_terms",
				"delete_{$capability_type}_terms",
				"assign_{$capability_type}_terms",
			);
		}

		return $capabilities;
	}
}

WD_Publishing_House_Install::init();
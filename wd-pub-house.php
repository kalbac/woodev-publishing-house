<?php

/**
 * Plugin Name: Publishing House
 * Plugin URI: https://github.com/kalbac/woodev-publishing-house/
 * Description: Test task.
 * Version: 1.0
 * Author URI: https://woodev.ru/
 * Requires at least: 4.4
 * Tested up to: 4.7
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 09:16
 * Project: woodev-publishing-house
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WD_Publishing_House {

	protected static $_instance = null;


	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	public function __clone() {}


	public function __wakeup() {}

	public function __construct() {

		if ( $this->is_woocommerce_active() ) {
			$this->includes();
			$this->init_hooks();
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
			add_action( 'admin_init', array( $this, 'action_deactivate' ) );

		}
	}

	public function is_woocommerce_active() {
		return in_array(
			'woocommerce/woocommerce.php',
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) )
		);
	}

	public function action_deactivate() {
		deactivate_plugins( plugin_basename( __FILE__ ) );
	}

	private function init_hooks() {

		register_activation_hook( __FILE__, array( 'WD_Publishing_House_Install', 'install' ) );
	}

	public function includes() {

		include_once( 'includes/class-install.php' );
		include_once( 'includes/class-post-type.php' );
		include_once( 'includes/template-functions.php' );

		if( is_admin() ) {
			include_once( 'includes/class-meta-boxes.php' );
		}
	}

	public function woocommerce_missing_notice() {
		echo '<div class="error"><p>' . sprintf( 'Для работы плагина Publishing House необходимо установить %s', '<a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a>' ) . '</p></div>';

		return true;
	}
}

return WD_Publishing_House::instance();
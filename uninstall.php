<?php
/**
 * Created by PhpStorm.
 * Author: Maksim Martirosov
 * Date: 22.05.2017
 * Time: 10:13
 * Project: woodev-publishing-house
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

include_once( dirname( __FILE__ ) . '/includes/class-install.php' );

WD_Publishing_House_Install::remove_roles();
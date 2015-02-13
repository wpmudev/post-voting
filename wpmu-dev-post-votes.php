<?php
/*
Plugin Name: Post Voting
Plugin URI: http://premium.wpmudev.org/project/post-voting-plugin/
Description: Gauge the popularity of your site's content by letting your visitors or users vote on that content. Sort of like your own personal Digg or Reddit, and it's packed with features!
Version: 2.2.2
Text Domain: wdpv
Author: WPMU DEV
Author URI: http://premium.wpmudev.org
WDP ID: 231

Copyright 2009-2014 Incsub (http://incsub.com)
Author - Scribu
Contributors - Ve Bailovity, Ignacio Cruz

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License (Version 2 - GPLv2) as published by
the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

define( 'WDPV_PLUGIN_SELF_DIRNAME', basename( dirname( __FILE__ ) ), true );

//Setup proper paths/URLs and load text domains
define( 'WDPV_PLUGIN_BASE_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WDPV_PLUGIN_URL', untrailingslashit( plugin_dir_url( __FILE__ ) ) );
//$textdomain_handler('wdpv', false, WDPV_PLUGIN_SELF_DIRNAME . '/languages/');

global $wpmudev_notices;
$wpmudev_notices[] = array( 'id' => 231, 'name' => 'Post Voting', 'screens' => array( 'settings_page_wdpv-network', 'settings_page_wdpv' ) );
if ( file_exists( WDPV_PLUGIN_BASE_DIR . '/lib/externals/wpmudev-dash-notification.php' ) ) { require_once WDPV_PLUGIN_BASE_DIR . '/lib/externals/wpmudev-dash-notification.php'; }


require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_installer.php';
Wdpv_Installer::check();

require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_options.php';
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_model.php';
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_codec.php';
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_plugins_handler.php';
require_once WDPV_PLUGIN_BASE_DIR . '/lib/wdpv_template_tags.php';

Wdpv_PluginsHandler::init();

// Widgets
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wpdv_widget_voting.php';
add_action( 'widgets_init', create_function( '', "register_widget('Wdpv_WidgetVoting');" ) );
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wpdv_widget_popular.php';
add_action( 'widgets_init', create_function( '', "register_widget('Wdpv_WidgetPopular');" ) );
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wpdv_widget_network_popular.php';
add_action( 'widgets_init', create_function( '', "register_widget('Wdpv_WidgetNetworkPopular');" ) );


if ( is_admin() ) {
	require_once WDPV_PLUGIN_BASE_DIR . '/lib/class-admin.php';
	new Wdpv_Admin();
}
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_public_pages.php';
Wdpv_PublicPages::serve();


if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
	require_once WDPV_PLUGIN_BASE_DIR . '/lib/class-wdpv-ajax.php';
	new Wdpv_Ajax();
}


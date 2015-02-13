<?php
/**
 * Handles options access.
 */
class Wdpv_Options {
	var $timeframes;


	function __construct () {
		$this->timeframes = array(
			'this_week' => __( 'This week', 'wdpv' ),
			'last_week' => __( 'Last week', 'wdpv' ),
			'this_month' => __( 'This month', 'wdpv' ),
			'last_month' => __( 'Last month', 'wdpv' ),
			'this_year' => __( 'This year', 'wdpv' ),
			'last_year' => __( 'Last year', 'wdpv' ),
		);
	}

	/**
	 * Gets a single option from options storage.
	 */
	function get_option ($key) {
		//$opts = WP_ALLOW_MULTISITE ? get_site_option('wdpv') : get_option('wdpv');
		$opts = get_option( 'wdpv' );
		return @$opts[$key];
	}

	/**
	 * Sets all stored options.
	 */
	function set_options ($opts) {
		return WP_NETWORK_ADMIN ? update_site_option( 'wdpv', $opts ) : update_option( 'wdpv', $opts );
	}

	/**
	 * Populates options key for storage.
	 *
	 * @static
	 */
	public static function populate () {}

}

function wdpv_get_options() {
	$settings = get_site_option( 'wdpv', array() );

	if ( is_multisite() && ! is_network_admin() ) {
		$settings = get_option( 'wdpv', array() );
	}

	$options = wp_parse_args( $settings, wdpv_get_default_options() );
	return $options;
}

function wdpv_update_options( $options ) {
	if ( is_multisite() && is_network_admin() ) {
		update_site_option( 'wdpv', $options ); }
	else {
		update_option( 'wdpv', $options ); }
}


function wdpv_get_default_options() {
	$defaults = array(
		'allow_voting' => true,
		'allow_visitor_voting' => false,
		'use_ip_check' => true,
		'show_login_link' => false,
		'skip_post_types' => array(),
		'voting_position' => 'top',
		'voting_appearance' => 'icomoon',
		'voting_positive' => false,
		'front_page_voting' => true,
		'disable_siteadmin_changes' => false,
		'color_up' => '#6CA96C',
		'color_down' => '#D04C4C'
	);

	$defaults = apply_filters( 'wdpv_default_options', $defaults );
	return $defaults;
}

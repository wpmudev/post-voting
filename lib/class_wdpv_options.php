<?php
/**
 * Handles access to plugin options.
 *
 * @package WPMUDEV_Post_Voting
 */

/**
 * Manages Post Voting options.
 *
 * @since 1.0.0
 */
class Wdpv_Options {

	/**
	 * Available translated timeframes.
	 *
	 * The array is populated after the WordPress `init` action
	 * to avoid triggering translation loading too early.
	 *
	 * @since 1.0.0
	 *
	 * @var array<string, string>
	 */
	public $timeframes = array();

	/**
	 * Initializes the options handler.
	 *
	 * Translations are intentionally not loaded in the constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->timeframes = array();
	}

	/**
	 * Retrieves translated timeframe labels.
	 *
	 * Returns an empty array before the `init` action has fired.
	 *
	 * @return array<string, string> Translated timeframe labels.
	 */
	public function get_timeframes() {
		if ( ! did_action( 'init' ) ) {
			return array();
		}

		if ( empty( $this->timeframes ) ) {
			$this->timeframes = array(
				'this_week'  => __( 'This week', 'wdpv' ),
				'last_week'  => __( 'Last week', 'wdpv' ),
				'this_month' => __( 'This month', 'wdpv' ),
				'last_month' => __( 'Last month', 'wdpv' ),
				'this_year'  => __( 'This year', 'wdpv' ),
				'last_year'  => __( 'Last year', 'wdpv' ),
			);
		}

		return $this->timeframes;
	}

	/**
	 * Retrieves a single option from the plugin options.
	 *
	 * @since 1.0.0
	 *
	 * @param string $key Option key.
	 * @return mixed|null Option value, or null if the key does not exist.
	 */
	public function get_option( $key ) {
		$options = get_option( 'wdpv' );

		if ( ! is_array( $options ) || ! array_key_exists( $key, $options ) ) {
			return null;
		}

		return $options[ $key ];
	}

	/**
	 * Updates the plugin options.
	 *
	 * Uses site options in the network administration context
	 * and regular options otherwise.
	 *
	 * @since 1.0.0
	 *
	 * @param array $options Options to save.
	 * @return bool True if the value was updated, false otherwise.
	 */
	public function set_options( $options ) {
		if ( is_multisite() && is_network_admin() ) {
			return update_site_option( 'wdpv', $options );
		}

		return update_option( 'wdpv', $options );
	}

	/**
	 * Populates the plugin options in the options table.
	 *
	 * Merges site-level options with regular options.
	 * Values from regular options take precedence.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public static function populate() {
		$site_options = get_site_option( 'wdpv' );
		$site_options = is_array( $site_options ) ? $site_options : array();

		$options = get_option( 'wdpv' );
		$options = is_array( $options ) ? $options : array();

		$merged_options = array_merge( $site_options, $options );

		update_option( 'wdpv', $merged_options );
	}
}

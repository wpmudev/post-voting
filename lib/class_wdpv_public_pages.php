<?php
/**
 * Handles public functionality.
 */
class Wdpv_PublicPages {
	var $model;
	var $data;
	var $codec;

	function __construct () {
		$this->model = new Wdpv_Model;
		$this->data = new Wdpv_Options;
		$this->codec = new Wdpv_Codec;


	}
	function Wdpv_PublicPages () { $this->__construct(); }

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	public static function serve () {
		$me = new Wdpv_PublicPages;
		$me->add_hooks();
	}

	function js_set_up_globals () {
		printf(
			'<script type="text/javascript">var _wdpv_root_url="%s"; var _wdpv_ajax_url="%s";</script>',
			WDPV_PLUGIN_URL, admin_url('admin-ajax.php')
		);
	}

	function js_load_scripts () {
		if ( $this->data->get_option('allow_voting') )
			wp_enqueue_script( 'wdpv_voting', WDPV_PLUGIN_URL . '/js/wdpv_voting.js', array( 'jquery' ) );
	}
	function css_load_styles () {
		if ( ! current_theme_supports( 'wdpv_voting_style' ) && $this->data->get_option('allow_voting') ) {
			wp_enqueue_style('wdpv_voting_general_style', WDPV_PLUGIN_URL . '/css/wdpv_voting_general.css');
			if ( $this->data->get_option('voting_appearance') != 'icomoon' ) {
				wp_enqueue_style('wdpv_voting_general_img', WDPV_PLUGIN_URL . '/css/wdpv_voting_img.css');
			}
		}
		
		if ( $this->data->get_option('allow_voting') && $this->data->get_option('voting_appearance') == 'icomoon' ) {
			wdpv_enqueue_icomoon_fonts();
		}
	}

	function inject_voting_buttons ($body) {
		$inject = apply_filters( "automatically_inject_voting_buttons", true );

		$do_not_show  = $this->data->get_option( 'skip_post_types' );
		$front_page_voting  = $this->data->get_option( 'front_page_voting' );
		$is_front_page = is_home() || is_front_page();

		if (
			( $is_front_page && ! $front_page_voting )
			|| ( ! $is_front_page && ! is_singular() )
			|| ! $inject
		) {
			return $body;
		}

		if ( is_singular() && isset( $do_not_show[ get_post_type() ] ) && $do_not_show[ get_post_type() ] ) {
			return $body;
		}

		if ( $this->codec->has_wdpv_shortcode( 'no_auto', $body ) )
			return $body;

		$position = $this->data->get_option('voting_position');
		if ('top' == $position || 'both' == $position) {
			$body = do_shortcode($this->codec->get_code('vote_widget')) . ' ' . $body;
		}
		if ('bottom' == $position || 'both' == $position) {
			$body .= " " . do_shortcode($this->codec->get_code('vote_widget'));
		}

		return $body;
	}

	function bp_show_recent_votes () {
		global $bp;
		$user = $bp->displayed_user;
		$username = $user->fullname ? $user->fullname : $user->userdata->user_nicename;
		$recent_votes = $this->model->get_recent_votes_by($user->id);
		include(WDPV_PLUGIN_BASE_DIR . '/lib/forms/bp_profile.php');
	}

	function add_hooks () {

		add_action('wp_head', array($this, 'js_set_up_globals'));
		add_action('wp_enqueue_scripts', array($this, 'js_load_scripts'));
		add_action('wp_enqueue_scripts', array($this, 'css_load_styles'));

		// Automatic Voting buttons
		if ('manual' != $this->data->get_option('voting_position')) {
			add_filter('the_content', array($this, 'inject_voting_buttons'), 15); // , 5);
			if (class_exists('bbpress') && !(defined('WDPV_SKIP_BBPRESS_COMPAT_FILTER') && WDPV_SKIP_BBPRESS_COMPAT_FILTER)) add_filter('bbp_get_reply_content', array($this, 'inject_voting_buttons'), 5);
		}

		// Optional hooks for BuddyPress
		if (defined('BP_VERSION')) {
			if ($this->data->get_option('bp_profile_votes')) {
				add_action('bp_after_profile_content', array($this, 'bp_show_recent_votes'));
			}
		}

		$this->codec->register();
	}
}
<?php
/**
 * Handles public functionality.
 */
class Wdpv_PublicPages {
	var $model;
	var $data;
	var $codec;

	function __construct () {
		$this->model = wdpv_get_model();
		$this->data = new Wdpv_Options;
		$this->codec = new Wdpv_Codec;
		add_action( 'plugins_loaded', array(  $this, 'render_colors_stylesheet' ) );

		
	}

	function render_colors_stylesheet() {
		if ( isset( $_GET['wdpv-colors'] ) ) {
			header( 'Content-type: text/css' );

			$options = wdpv_get_options();
			?>
				.wdpv_vote_down i.wdpv-icon:after {
				   color:<?php echo $options['color_down']; ?>
				}
				.wdpv_vote_up i.wdpv-icon:after {
				   color:<?php echo $options['color_up']; ?>
				}
			<?php
			exit;
		}
	}

	/**
	 * Main entry point.
	 *
	 * @static
	 */
	public static function serve () {
		$me = new Wdpv_PublicPages;
		$me->add_hooks();
	}


	function js_load_scripts () {
		if ( $this->data->get_option( 'allow_voting' ) ) {
			wp_enqueue_script( 'wdpv_voting', WDPV_PLUGIN_URL . '/js/wdpv_voting.js', array( 'jquery' ) ); 
			$l10n = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			);
			wp_localize_script( 'wdpv_voting', 'wdpv_i18n', $l10n );
		}
	}
	function css_load_styles () {
		if ( ! current_theme_supports( 'wdpv_voting_style' ) && $this->data->get_option( 'allow_voting' ) ) {
			wp_enqueue_style( 'wdpv_voting_general_style', WDPV_PLUGIN_URL . '/css/wdpv_voting.css' );
			wdpv_enqueue_icomoon_fonts();
			wp_enqueue_style( 'wdpv_voting_colors', add_query_arg( 'wdpv-colors', 'true', home_url() ) );
		}
	}


	function inject_voting_buttons ($body) {
		$inject = apply_filters( 'automatically_inject_voting_buttons', true );

		if (
			(is_home() && ! $this->data->get_option( 'front_page_voting' ))
			||
			( ! is_home() && ! is_singular())
			||
			! $inject
		) { return $body; }
		if ( $this->codec->has_wdpv_shortcode( 'no_auto', $body ) ) { return $body; }
		$position = $this->data->get_option( 'voting_position' );

		if ( 'top' == $position || 'both' == $position ) {
			$body = do_shortcode( $this->codec->wdpv_render_vote_box( array( 'echo' => false ) ) ) . ' ' . $body;
		}
		if ( 'bottom' == $position || 'both' == $position ) {
			$body .= ' ' . do_shortcode( $this->codec->wdpv_render_vote_box( array( 'echo' => false ) ) );
		}
		return $body;
	}

	function bp_show_recent_votes () {
		global $bp;
		$user = $bp->displayed_user;
		$username = $user->fullname ? $user->fullname : $user->userdata->user_nicename;
		$recent_votes = $this->model->get_recent_votes_by( $user->id );
		include(WDPV_PLUGIN_BASE_DIR . '/lib/forms/bp_profile.php');
	}

	function add_hooks () {

		add_action( 'wp_enqueue_scripts', array($this, 'js_load_scripts') );
		add_action( 'wp_enqueue_scripts', array($this, 'css_load_styles') );

		// Automatic Voting buttons
		if ( 'manual' != $this->data->get_option( 'voting_position' ) ) {
			add_filter( 'the_content', array($this, 'inject_voting_buttons'), 15 ); // , 5);
			if ( class_exists( 'bbpress' ) && ! (defined( 'WDPV_SKIP_BBPRESS_COMPAT_FILTER' ) && WDPV_SKIP_BBPRESS_COMPAT_FILTER) ) { add_filter( 'bbp_get_reply_content', array($this, 'inject_voting_buttons'), 5 ); }
		}

		// Optional hooks for BuddyPress
		if ( defined( 'BP_VERSION' ) ) {
			if ( $this->data->get_option( 'bp_profile_votes' ) ) {
				add_action( 'bp_after_profile_content', array($this, 'bp_show_recent_votes') );
			}
		}

		$this->codec->register();
	}
}

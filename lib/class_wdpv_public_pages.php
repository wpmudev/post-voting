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

		// LOad integrations
		if ( class_exists( 'BuddyPress' ) )
			include_once( 'integration/buddypress/class-buddypress.php' );

		if ( class_exists( 'bbpress' ) ) {
			include_once( 'integration/bbpress/class-bbpress.php' );
		}
		
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


	public static function inject_voting_buttons ($body) {
		$inject = apply_filters( 'automatically_inject_voting_buttons', true );

		$options = wdpv_get_options();
		$codec = new Wdpv_Codec();
		if (
			( is_home() && ! $options['front_page_voting'] )
			||
			( ! is_home() && ! is_singular())
			||
			! $inject
		) { return $body; }
		if ( $codec->has_wdpv_shortcode( 'no_auto', $body ) ) { return $body; }
		$position = $options['voting_position'];

		$shortcode = '[wdpv_vote';
		if ( $post_id = get_the_ID() )
			$shortcode .= ' post_id="' . $post_id . '"';
		if ( $blog_id = get_current_blog_id() )
			$shortcode .= ' blog_id="' . $blog_id . '"';
		$shortcode .= ']';

		if ( 'top' == $position || 'both' == $position )
			$body = do_shortcode( $shortcode ) . ' ' . $body;

		if ( 'bottom' == $position || 'both' == $position )
			$body .= ' ' . do_shortcode( $shortcode );

		return $body;
	}


	function add_hooks () {

		add_action( 'wp_enqueue_scripts', array($this, 'js_load_scripts') );
		add_action( 'wp_enqueue_scripts', array($this, 'css_load_styles') );

		// Automatic Voting buttons
		if ( 'manual' != $this->data->get_option( 'voting_position' ) ) {
			add_filter( 'the_content', array( $this, 'inject_voting_buttons' ), 15 ); // , 5);
		}

		$this->codec->register();
	}
}


function wdpv_inject_voting_buttons( $body = '' ) {
	$body = Wdpv_PublicPages::inject_voting_buttons( $body );	
	return $body;
}

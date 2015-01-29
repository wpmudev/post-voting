<?php
/**
 * Handles all Admin access functionality.
 */
class Wdpv_AdminPages {
	var $model;
	var $data;

	function __construct () {
		$this->model = wdpv_get_model();
		$this->data = new Wdpv_Options;

		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

		add_filter( 'wdpv_register_settings', array( $this, 'set_fields' ), 1 );
		add_filter( 'wdpv_register_sections', array( $this, 'set_sections' ), 1 );

		// Step0: Register options and menu
		add_action( 'admin_init', array( $this, 'register_settings' ) );

		if ( is_network_admin() )
			add_action( 'network_admin_menu', array( $this, 'create_site_admin_menu_entry' ) );
		else
			add_action( 'admin_menu', array( $this, 'create_blog_admin_menu_entry' ) );

	}

	function enqueue_scripts() {
		wdpv_enqueue_icomoon_fonts();
	}


	/**
	 * Adds the menu for a single blog
	 */
	function create_blog_admin_menu_entry () {
		$settings_perms = $this->data->get_option('disable_siteadmin_changes') ? 'manage_network_options' : 'manage_options';
		$settings_page_id = add_options_page('Post Voting', 'Post Voting', $settings_perms, 'wdpv', array($this, 'render_settings_page'));
		add_dashboard_page(__( 'Voting Stats', 'wdpv' ), 'Voting Stats', 'manage_options', 'wdpv_stats', array($this, 'render_stats_page'));

		add_action( 'load-' . $settings_page_id, array( $this, 'on_load_settings_page' ) );
	}

	/**
	 * Adds the menu for the netowrk admin
	 */
	function create_site_admin_menu_entry () {
		$settings_page_id = add_submenu_page( 'settings.php', 'Post Voting', 'Post Voting', 'manage_network_options', 'wdpv', array( $this, 'render_settings_page' ) );
		add_dashboard_page( 'Voting Stats', __( 'Voting Stats', 'wdpv' ), 'manage_network_options', 'wdpv_stats', array( $this, 'render_stats_page' ) );

		add_action( 'load-' . $settings_page_id, array( $this, 'on_load_settings_page' ) );
	}

	/**
	 * Executed when the Settings page is being loaded
	 */
	public function on_load_settings_page() {
		if ( isset( $_GET['wdpv_deactivate_plugin'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'deactivate-plugin' ) ) {
			$status = Wdpv_PluginsHandler::deactivate_plugin( $_GET['plugin_id'] );
			$url = remove_query_arg( array( 'wdpv_deactivate_plugin', 'plugin_id', '_wpnonce' ) );
			$url = add_query_arg( 'updated', 'true', $url );
			wp_redirect( $url );
			exit;
		}

		if ( isset( $_GET['wdpv_activate_plugin'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'activate-plugin' ) ) {
			$status = Wdpv_PluginsHandler::activate_plugin( $_GET['plugin_id'] );
			$url = remove_query_arg( array( 'wdpv_activate_plugin', 'plugin_id', '_wpnonce' ) );
			$url = add_query_arg( 'updated', 'true', $url );
			wp_redirect( $url );
			exit;
		}
	}

	function set_fields( $settings ) {
		$form = new Wdpv_AdminFormRenderer;

		$new_settings = array(
			'wdpv_allow_voting' => array(
				'title' => __('Allow post voting', 'wdpv'),
				'callback' => array($form, 'create_allow_voting_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_allow_visitor_voting' => array(
				'title' => __('Allow voting for unregistered users', 'wdpv'),
				'callback' => array($form, 'create_allow_visitor_voting_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_use_ip_check_link' => array(
				'title' => __('Use IP check', 'wdpv'),
				'callback' => array($form, 'create_use_ip_check_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_show_login_link' => array(
				'title' => __('Show login link for visitors', 'wdpv'),
				'callback' => array($form, 'create_show_login_link_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_skip_post_types' => array(
				'title' => __('Do <strong>NOT</strong> show voting for these types', 'wdpv'),
				'callback' => array($form, 'create_skip_post_types_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_voting_position' => array(
				'title' => __('Voting box position', 'wdpv'),
				'callback' => array($form, 'create_voting_position_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_voting_appearance' => array(
				'title' => __('Appearance', 'wdpv'),
				'callback' => array($form, 'create_voting_appearance_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_voting_positive' => array(
				'title' => __('Prevent negative voting', 'wdpv'),
				'callback' => array($form, 'create_voting_positive_box'),
				'section' => 'wdpv_voting'
			),
			'wdpv_front_page_voting' => array(
				'title' => __('Voting on Front Page', 'wdpv'),
				'callback' => array($form, 'create_front_page_voting_box'),
				'section' => 'wdpv_voting'
			)
		);

		if ( is_multisite() && is_network_admin() ) {
			$new_settings['wdpv_disable_siteadmin_changes'] = array(
				'title' => __('Prevent Site Admins from making changes?', 'wdpv'),
				'callback' => array( $form, 'create_disable_siteadmin_changes_box' ),
				'section' => 'wdpv_voting'
			);
		}

		if ( defined( 'BP_VERSION' ) ) {
			$new_settings['wdpv_bp_publish_activity'] = array(
				'title' => __('Publish votes to activity stream', 'wdpv'),
				'callback' => array( $form, 'create_bp_publish_activity_box' ),
				'section' => 'wdpv_bp'
			);
			$new_settings['wdpv_bp_profile_votes'] = array(
				'title' => __('Show recent votes on user profile page', 'wdpv'),
				'callback' => array( $form, 'create_bp_profile_votes_box' ),
				'section' => 'wdpv_bp'
			);
		}

		if ( ! is_multisite() || ( is_multisite() && is_network_admin() ) ) {
			$new_settings['wdpv_plugins_all_plugins'] = array(
				'title' => __('All add-ons', 'wdpv'),
				'callback' => array( $form, 'create_plugins_box' ),
				'section' => 'wdpv_plugins'
			);
		}

		return array_merge( $settings, $new_settings );
	}

	function set_sections( $sections ) {
		$new_sections = array(
			'wdpv_voting' => array(
				'title' => '',
				'callback' => null
			)
		);

		if ( defined( 'BP_VERSION' ) ) {
			$new_sections['wdpv_bp'] = array(
				'title' => __('BuddyPress integration', 'wdpv'),
				'callback' => null
			);
		}

		if ( ! is_multisite() || ( is_multisite() && is_network_admin() ) ) {
			$new_sections['wdpv_plugins'] = array(
				'title' => __( 'Post Voting add-ons', 'wdpv' ),
				'callback' => null
			);
		}

		return array_merge( $sections, $new_sections );
	}

	function register_settings() {
		
		$page = 'wdpv_options_page';

		register_setting( 'wdpv', 'wdpv' );

		$sections = apply_filters( 'wdpv_register_sections', array() );
		$settings = apply_filters( 'wdpv_register_settings', array() );

		foreach ( $sections as $section_id => $section ) {
			add_settings_section( $section_id, $section['title'], $section['callback'], $page );
			$_settings = wp_list_filter( $settings, array( 'section' => $section_id ) );
			foreach ( $_settings as $setting_id => $setting ) {
				add_settings_field( $setting_id, $setting['title'], $setting['callback'], $page, $section_id );
			}
		}

		$form = new Wdpv_AdminFormRenderer;
		do_action( 'wdpv-options-plugins_options', $form );
	}


	/**
	 * Displays the Admin menu page.
	 */
	function render_settings_page() {
		?>
			<div class="wrap">
				<h2><?php echo esc_html( get_admin_page_title() ); ?></h2>

				<?php if ( is_multisite() && is_network_admin() ): ?>
					<form action="settings.php" method="post">
				<?php else: ?>
					<form action="options.php" method="post">
				<?php endif; ?>
					
					<?php settings_fields( 'wdpv' ); ?>
					<?php do_settings_sections( 'wdpv_options_page' ); ?>		

					<?php submit_button(); ?>

				</form>
			</div>
		<?php
	}

	/**
	 * Creates Admin Stats page.
	 *
	 * @access private
	 */
	function render_stats_page() {
		$limit = 2000;
		$overall = is_network_admin() ? $this->model->get_popular_on_network($limit) : $this->model->get_popular_on_current_site($limit);
		include(WDPV_PLUGIN_BASE_DIR . '/lib/forms/plugin_stats.php');
	}


	

}
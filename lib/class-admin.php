<?php

require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_admin_form_renderer.php';
require_once WDPV_PLUGIN_BASE_DIR . '/lib/class_wdpv_admin_pages.php';

class Wdpv_Admin {

	public $model = null;
	public $data = null;

	public function __construct() {
		new Wdpv_AdminPages();

		$this->init_tiny_mce_button();

		$this->model = wdpv_get_model();
		$this->data = new Wdpv_Options;

		// Cleanup
		add_action( 'deleted_post', array( $this, 'clear_orphaned_data' ) );

		

		// Optional hooks for BuddyPress
		if ( defined( 'BP_VERSION' ) ) {
			if ( $this->data->get_option( 'bp_profile_votes' ) ) {
				//add_action('bp_before_profile_content', array($this, 'bp_show_recent_votes'));
				add_action( 'wdpv_voted', array($this, 'bp_record_vote_activity'), 10, 4 );
			}
		}
	}

	function clear_orphaned_data ($post_id) {
		$this->model->remove_votes_for_post( $post_id );
	}

	

	function bp_record_vote_activity ($site_id, $blog_id, $post_id, $vote) {
		if ( ! bp_loggedin_user_id() ) { return false; }

		$username = bp_get_loggedin_user_fullname();
		$username = $username ? $username : bp_get_loggedin_user_username();
		if ( ! $username ) { return false; }

		$user_link = bp_get_loggedin_user_link();
		$link = get_blog_permalink( $blog_id, $post_id );

		$post = get_blog_post( $blog_id, $post_id );
		$title = $post->post_title;

		$args = array (
			'action' => sprintf(
				__( '<a href="%s">%s</a> voted on <a href="%s">%s</a>', 'wdpv' ),
				$user_link, $username, $link, $title
			),
			'component' => 'wdpv_post_vote',
			'type' => 'wdpv_post_vote',
			'item_id' => $blog_id,
			'secondary_item_id' => $post_id,
			'hide_sitewide' => $this->data->get_option( 'bp_publish_activity_local' ),
		);
		$res = bp_activity_add( $args );
		return $res;
	}

	// TinyMCE buttons ( Thanks to Woocommerce Shortcodes plugin: https://wordpress.org/plugins/woocommerce-shortcodes/)
	function init_tiny_mce_button() {
		if ( apply_filters( 'wdpv_add_editor_shortcodes', true ) ) {
			add_action( 'admin_head', array( $this, 'add_shortcode_button' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_editor_admin_scripts' ) );
		}
	}

	function add_shortcode_button() {
		if ( 'true' == get_user_option( 'rich_editing' ) ) {
			add_filter( 'mce_external_plugins', array( $this, 'add_shortcode_tinymce_plugin' ) );
			add_filter( 'mce_buttons', array( $this, 'register_shortcode_button' ) );
			add_filter( 'mce_external_languages', array( $this, 'add_tinymce_i18n' ) );
		}
	}

	public function add_shortcode_tinymce_plugin( $plugins ) {
		$plugins['wdpv_shortcodes'] = WDPV_PLUGIN_URL . '/js/editor-shortcodes.js';
		return $plugins;
	}

	public function register_shortcode_button( $buttons ) {
		array_push( $buttons, '|', 'wdpv_shortcodes' );
		return $buttons;
	}

	public function enqueue_editor_admin_scripts() {
		wp_enqueue_style( 'wdpv-shortcodes', WDPV_PLUGIN_URL . '/css/editor-shortcodes.css' );
	}

	public function add_tinymce_i18n( $i18n ) {
		$i18n['wdpv_shortcodes'] = WDPV_PLUGIN_BASE_DIR . '/lib/tinymce-shortcodes-i18n.php';

		return $i18n;
	}
}
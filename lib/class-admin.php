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

		// Step1: add AJAX hooks
		if ( $this->data->get_option( 'allow_voting' ) ) {
			// Step1a: add AJAX hooks for visitors
			if ( $this->data->get_option( 'allow_visitor_voting' ) ) {
				add_action( 'wp_ajax_nopriv_wdpv_record_vote', array($this, 'json_record_vote') );
				add_action( 'wp_ajax_nopriv_wdpv_vote_results', array($this, 'json_vote_results') );
			}
			// Step1b: add AJAX hooks for registered users
			add_action( 'wp_ajax_wdpv_record_vote', array($this, 'json_record_vote') );
			add_action( 'wp_ajax_wdpv_vote_results', array($this, 'json_vote_results') );
		}

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

	function json_record_vote () {
		$status = false;
		if ( isset($_POST['wdpv_vote']) && isset($_POST['post_id']) ) {
			$vote = (int)$_POST['wdpv_vote'];
			$post_id = (int)$_POST['post_id'];
			$blog_id = (int)@$_POST['blog_id'];
			$status = $this->model->update_post_votes( $blog_id, $post_id, $vote );
		}
		header( 'Content-type: application/json' );
		echo json_encode(array(
			'status' => (int)$status,
		));
		exit();
	}

	function json_vote_results () {
		$data = false;
		if ( isset($_POST['post_id']) ) {
			$data = $this->model->get_votes_total( (int)$_POST['post_id'], false, (int)@$_POST['blog_id'] );
		}
		header( 'Content-type: application/json' );
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
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
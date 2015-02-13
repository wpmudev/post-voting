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

	}

	function clear_orphaned_data ($post_id) {
		$this->model->remove_votes_for_post( $post_id );
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
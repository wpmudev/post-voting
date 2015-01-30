<?php

$strings = 'tinyMCE.addI18n({' . _WP_Editors::$mce_locale . ': {
	wdpv_shortcodes: {
		vote_boxes_menu_title: "' . esc_js( __( 'Vote boxes', 'wdpv' ) ) . '",
		vote_box_menu_title: "' . esc_js( __( 'Vote full box', 'wdpv' ) ) . '",
		vote_up_box_menu_title: "' . esc_js( __( 'Vote up', 'wdpv' ) ) . '",
		vote_down_box_menu_title: "' . esc_js( __( 'Vote down', 'wdpv' ) ) . '",
		vote_results_box_menu_title: "' . esc_js( __( 'Only voting results', 'wdpv' ) ) . '",
		vote_popular_box_menu_title: "' . esc_js( __( 'Popular posts', 'wdpv' ) ) . '",
		shortcode_title: "' . esc_js( __( 'Post Voting', 'wdpv' ) ) . '"
	}
}});';
<?php

// Vote up
function wdpv_get_vote_up_ms ( $standalone='deprecated', $blog_id=false, $post_id=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'show_down' => false, 'post_id' => $post_id, 'blog_id' => $blog_id ) );
}

function wdpv_get_vote_up ($standalone= 'deprecated', $post_id = false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'show_down' => false, 'post_id' => $post_id ) );
}

function wdpv_vote_up ($standalone=true) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true, 'show_down' => false ) );
}

// Vote down
function wdpv_get_vote_down_ms ($standalone= 'deprecated', $blog_id=false, $post_id=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true, 'show_up' => false, 'post_id' => $post_id, 'blog_id' => $blog_id ) );
}

function wdpv_get_vote_down ($standalone= 'deprecated', $post_id=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true, 'show_up' => false, 'post_id' => $post_id ) );
}

function wdpv_vote_down ($standalone= 'deprecated') {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true, 'show_up' => false ) );
}

// Full voting widgets

function wdpv_get_vote_ms ($standalone='deprecated', $blog_id=false, $post_id=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'post_id' => $post_id, 'blog_id' => $blog_id ) );
}

function wdpv_get_vote( $standalone= 'deprecated', $post_id = false ) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'post_id' => $post_id ) );
}

function wdpv_vote() {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true ) );
}

// Vote results
function wdpv_get_vote_result_ms ($standalone=true, $blog_id=false, $post_id=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'show_up' => false, 'show_down' => false, 'post_id' => $post_id, 'blog_id' => $blog_id ) );
}

function wdpv_get_vote_result ( $standalone = 'deprecated', $post_id = false ) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	return Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => false, 'show_up' => false, 'show_down' => false, 'post_id' => $post_id ) );
}

function wdpv_vote_result ($standalone= 'deprecated' ) {
	if ( ! class_exists( 'Wdpv_Codec' ) )
		return '';

	Wdpv_Codec::wdpv_render_vote_box( array( 'echo' => true, 'show_up' => false, 'show_down' => false ) );
}

// Popular
function wdpv_get_popular ($limit=5, $network=false) {
	if ( ! class_exists( 'Wdpv_Codec' ) ) { return false; }

	$codec = new Wdpv_Codec;
	return $codec->process_popular_code( array('limit' => $limit, 'network' => $network) );
}

function wdpv_popular ($limit=5, $network=false) {
	echo wdpv_get_popular( $limit, $network );
}

function wdpv_get_popular_within ($timespan, $limit=5) {
	if ( ! class_exists( 'Wdpv_Codec' ) ) { return false; }

	$codec = new Wdpv_Codec;
	return $codec->process_popular_code( array('limit' => $limit, 'voted_within' => $timespan) );
}

function wdpv_popular_within ($timespan, $limit=5) {
	echo wdpv_get_popular_within( $timespan, $limit );
}

function wdpv_query_within ($timespan, $limit=5, $query=array()) {
	return Wdpv_Query::spawn( $limit, false, $timespan, $query );
}

/**
 * Compatibility layer.
 */
if ( ! is_multisite() ) {
	if ( ! function_exists( 'get_blog_permalink' ) ) {
		function get_blog_permalink ($blog_id, $post_id) {
			return get_permalink( $post_id );
		}
	}
	if ( ! function_exists( 'get_blog_post' ) ) {
		function get_blog_post ($blog_id, $post_id) {
			return get_post( $post_id );
		}
	}
}

function wdpv_enqueue_icomoon_fonts() {
	wp_enqueue_style( 'wdpv_icomoon', WDPV_PLUGIN_URL . '/css/icomoon.css' );
}


<?php

class Wdpv_BuddyPress_Integration {
	public function __construct() {
		add_filter( 'wdpv_default_options', array( $this, 'add_default_options' ) );
		add_filter( 'wdpv_register_sections', array( $this, 'add_settings_section' ) );
		add_filter( 'wdpv_register_settings', array( $this, 'add_settings_fields' ) );

		$options = wdpv_get_options();
		if ( $options['bp_publish_activity'] ) {
			add_action( 'wdpv_voted', array($this, 'bp_record_vote_activity'), 10, 4 );
		}

		if ( $options['bp_profile_votes'] ) {
			add_action( 'bp_after_profile_content', array( $this, 'bp_show_recent_votes' ) );
		}

		add_filter( 'automatically_inject_voting_buttons', array( $this, 'avoid_vote_boxes_on_buddypress' ) );
		
	}

	public function avoid_vote_boxes_on_buddypress( $inject ) {
		if ( is_buddypress() )
			return false;

		return $inject;
	} 

	public function add_default_options( $options ) {
		$options['bp_publish_activity'] = false;
		$options['bp_publish_activity_local'] = false;
		$options['bp_profile_votes'] = false;
		$options['bp_profile_votes_limit'] = 0;
		$options['bp_profile_votes_period'] = 1;
		$options['bp_profile_votes_unit'] = 'month';
		return $options;
	}

	public function add_settings_section( $sections ) {
		$sections['wdpv_bp'] = array(
			'title' => __( 'BuddyPress integration', 'wdpv' ),
			'callback' => null
		);

		return $sections;
	}

	public function add_settings_fields( $fields ) {
		$fields['wdpv_bp_publish_activity'] = array(
			'title' => __( 'Publish votes to activity stream', 'wdpv' ),
			'callback' => array( $this, 'create_bp_publish_activity_box' ),
			'section' => 'wdpv_bp'
		);
		$fields['wdpv_bp_profile_votes'] = array(
			'title' => __( 'Show recent votes on user profile page', 'wdpv' ),
			'callback' => array( $this, 'create_bp_profile_votes_box' ),
			'section' => 'wdpv_bp'
		);

		return $fields;

	}

	function create_bp_publish_activity_box() {
		$opt = wdpv_get_options();

		$publish_activity = $opt[ 'bp_publish_activity' ];
		$publish_activity_local = $opt[ 'bp_publish_activity_local' ];

		include( 'views/settings-publish-activity.php' );

	}

	function create_bp_profile_votes_box() {
		$opt = wdpv_get_options();

		$profile_votes = $opt[ 'bp_profile_votes' ];
		$profile_votes_limit = $opt[ 'bp_profile_votes_limit' ];
		$profile_votes_period = $opt[ 'bp_profile_votes_period' ];
		$profile_votes_unit = $opt[ 'bp_profile_votes_unit' ];

		include( 'views/settings-profile.php' );

	}

	public function bp_record_vote_activity ( $site_id, $blog_id, $post_id, $vote ) {
		if ( ! bp_loggedin_user_id() )
			return false;

		$username = bp_get_loggedin_user_fullname();
		$username = $username ? $username : bp_get_loggedin_user_username();
		if ( ! $username ) { return false; }

		$options = wdpv_get_options();

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
			'hide_sitewide' => $options['bp_publish_activity_local'],
		);
		$res = bp_activity_add( $args );
		return $res;
	}

	function bp_show_recent_votes() {
		global $bp;
		$model = wdpv_get_model();
		$user = $bp->displayed_user;
		$username = $user->fullname ? $user->fullname : $user->userdata->user_nicename;
		$recent_votes = $model->get_recent_votes_by( $user->id );
		include( 'views/bp_profile.php');
	}
}

new Wdpv_BuddyPress_Integration();
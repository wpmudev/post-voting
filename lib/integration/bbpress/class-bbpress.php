<?php

class Wdpv_bbPress {
	public function __construct() {	
		$options = wdpv_get_options();	
		$not_post_types = $options['skip_post_types'];
		if ( ! in_array( 'reply', $not_post_types ) )
			add_filter( 'bbp_get_reply_content', 'wdpv_inject_voting_buttons', 5 ); 

		if ( ! in_array( 'forum', $not_post_types ) )
			add_filter( 'bbp_get_forum_content', 'wdpv_inject_voting_buttons', 5 ); 
		
		if ( ! in_array( 'topic', $not_post_types ) )
			add_filter( 'bbp_get_topic_content', 'wdpv_inject_voting_buttons', 5 ); 
		
	}
}

new Wdpv_bbPress();
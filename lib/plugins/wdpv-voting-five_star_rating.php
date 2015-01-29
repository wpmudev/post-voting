<?php
/*
Plugin Name: Five-star rating
Description: Activating this add-on will convert up/down voting into 5-star rating system.
Plugin URI: http://premium.wpmudev.org/project/post-voting-plugin
Version: 1.0
Author: WPMU DEV
*/

class Wdpv_Voting_FiveStarRating {
	
	private $_data;
	private $_model;
	
	private function __construct () {
		$this->_data = new Wdpv_Options;
		$this->_model = wdpv_get_model();
	}
	
	public static function serve () {
		$me = new self;
		$me->_add_hooks();
	}
	
	private function _add_hooks () {
		add_filter('wdpv-output-before_vote_widget', array($this, 'output_voting_widget'), 10, 4);
		add_filter('wdpv-output-vote_result', array($this, 'output_voting_result'), 10, 4);
		add_filter('wdpv-output-vote_down', '__return_false');
		add_filter('wdpv-output-vote_up', '__return_false');
		
		add_filter('wdpv-output-personal_vote_result', array($this, 'output_personal_voting_widget'), 10, 4);
		
		add_action('wp_ajax_wdpv_rating_results', array($this, 'json_rating_results'));
		add_action('wp_ajax_nopriv_wdpv_rating_results', array($this, 'json_rating_results'));

		add_action('wp_ajax_wdpv_personal_rating_results', array($this, 'json_personal_rating_results'));
		add_action('wp_ajax_nopriv_wdpv_personal_rating_results', array($this, 'json_personal_rating_results'));
	}
	
	function output_voting_widget ($ret, $args, $blog_id, $post_id) {
		$total = $this->_model->get_votes_total($post_id, false, $blog_id);
		
		$count = $this->_model->get_votes_count($post_id, false, $blog_id);
		$count = $count ? $count : 1;
		
		$avg = $total/$count;
		
		// Round the result to .5 increments
		$result = (int)$avg; // Get the lower int part
		$tmp = $avg - $result;
		$result += round($tmp) ? .5 : 0;
		
		$offset = $result * 10;
		
		return "<div class='wdpv_voting wdpv_five_stars'>" .
			"<div class='wdpv_rating wdpv_dev_stars wdpv_{$offset}_offset'>" .
				"<input type='hidden' class='wdpv_blog_id' value='{$blog_id}' />" . 
				"<input type='hidden' value='{$post_id}' />" . 
			"</div>" .
		"</div>";
	}
	
	function output_personal_voting_widget ($ret, $args, $blog_id, $post_id) {
		global $current_user;
		$avg = $this->_model->get_user_votes_total($current_user->id, $post_id, false, $blog_id);
		// Round the result to .5 increments
		$result = (int)$avg; // Get the lower int part
		$tmp = $avg - $result;
		$result += round($tmp) ? .5 : 0;
		
		$offset = $result * 10;
		
		return $this->_user_voted($current_user->id, $post_id, $blog_id) 
			? "<div class='wdpv_voting wdpv_five_stars'>" .
				"<div class='wdpv_rating wdpv_personal_rating wdpv_static wdpv_dev_stars wdpv_{$offset}_offset'>" .
					"<span class='wdpv_rating_result'>{$result}</span>" . 
				"</div>" .
			"</div>"
			: "<div class='wdpv_voting wdpv_five_stars'>" .
				"<div class='wdpv_rating wdpv_personal_rating wdpv_dev_stars wdpv_{$offset}_offset'>" .
					"<input type='hidden' class='wdpv_blog_id' value='{$blog_id}' />" . 
					"<input type='hidden' value='{$post_id}' />" . 
				"</div>" .
			"</div>"
		;
	}

	function output_voting_result ($ret, $args, $blog_id, $post_id) {
		$total = $this->_model->get_votes_total($post_id, false, $blog_id);
		
		$count = $this->_model->get_votes_count($post_id, false, $blog_id);
		$count = $count ? $count : 1;
		
		$avg = $total/$count;
		
		// Round the result to .5 increments
		$result = (int)$avg; // Get the lower int part
		$tmp = $avg - $result;
		$result += round($tmp) ? .5 : 0;
		
		$offset = $result * 10;
	
		return "<div class='wdpv_voting wdpv_five_stars' itemprop='rating' itemscope itemtype='http://data-vocabulary.org/Rating'>" .
			"<div class='wdpv_rating wdpv_static wdpv_dev_stars wdpv_{$offset}_offset'>" .
				"<span class='wdpv_rating_result' itemprop='value'>{$result}</span>" .
				'<meta itemprop="best" content="5" />' .
			"</div>" .
		"</div>";
	}
	
	private function _user_voted ($user_id, $post_id, $blog_id) {
		global $wpdb;
		$where = apply_filters('wdpv-sql-where-user_id_check', "WHERE user_id={$user_id} AND blog_id={$blog_id} AND post_id={$post_id}");
		$result = $wpdb->get_var("SELECT COUNT(*) FROM " . $wpdb->base_prefix . "wdpv_post_votes {$where}");
		return $result;
	}
	
	function json_rating_results () {
		$data = false;
		if (isset($_POST['post_id'])) {
			$total = $this->_model->get_votes_total((int)$_POST['post_id'], false, (int)@$_POST['blog_id']);
			$count = $this->_model->get_votes_count((int)$_POST['post_id'], false, (int)@$_POST['blog_id']);
			$count = $count ? $count : 1;
			
			$avg = $total/$count;
		
			// Round the result to .5 increments
			$result = (int)$avg; // Get the lower int part
			$tmp = $avg - $result;
			$result += round($tmp) ? .5 : 0;
			
			$data = $result * 10;
		}
		header('Content-type: application/json');
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
	}
	
	function json_personal_rating_results () {
		global $current_user;
		$data = false;
		if (isset($_POST['post_id'])) {
			$avg = $this->_model->get_user_votes_total($current_user->id, (int)$_POST['post_id'], false, (int)@$_POST['blog_id']);
			// Round the result to .5 increments
			$result = (int)$avg; // Get the lower int part
			$tmp = $avg - $result;
			$result += round($tmp) ? .5 : 0;
			
			$data = $result * 10;
		}
		
		header('Content-type: application/json');
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
	}
}



function wdpv_result_average ($post_id=false) {
	global $blog_id, $post;
	$post_id = $post_id ? $post_id : $post->ID;
	return apply_filters('wdpv-output-vote_result', '', array(), $blog_id, $post_id);
}

function wdpv_current_user_vote ($post_id=false) {
	global $blog_id, $post;
	$post_id = $post_id ? $post_id : $post->ID;
	return apply_filters('wdpv-output-personal_vote_result', '', array(), $blog_id, $post_id);
}

Wdpv_Voting_FiveStarRating::serve();

<?php
/**
 * Handles shortcode creation and replacement.
 */
class Wdpv_Codec {

	var $shortcodes = array(
		'vote_up' => 'wdpv_vote_up',
		'vote_down' => 'wdpv_vote_down',
		'vote_result' => 'wdpv_vote_result',
		'vote_widget' => 'wdpv_vote',
		'popular' => 'wdpv_popular',
		'no_auto' => 'wdpv_no_auto',
	);

	var $model;
	var $data;

	function __construct () {
		$this->model = new Wdpv_Model;
		$this->data = new Wdpv_Options;
	}
	function Wdpv_Codec () { $this->__construct(); }

	function _generate_login_link () {
		$post_id = get_the_ID();
		$blog_id = $this->_get_blog_id($args['blog_id']);
		$count = $this->model->get_votes_total($post_id, false, $blog_id);
 		return sprintf(
			__('<div class="wdpv_login">This post has %s votes. <a href="%s">Log in now</a> to vote</div>', 'wdpv'),
			$count, site_url('wp-login.php')
		);
	}

	function _check_voting_display_restrictions ($post_id) {
		if (!$post_id) return false;

		$type = get_post_type($post_id);
		if (!$type) return false;

		$skip_types = $this->data->get_option('skip_post_types');
		if (!is_array($skip_types)) return true; // No restrictions, we're good

		return (!in_array($type, $skip_types));
	}

	function process_no_auto_code ($args=array()) {
		return '';
	}

	function process_popular_code ($args=array()) {
		$args = extract(shortcode_atts(array(
			'limit' => 5,
			'network' => false,
			'posted_within' => false,
			'voted_within' => false,
		), $args));

		$model = new Wdpv_Model;
		$posts = $network ? $model->get_popular_on_network($limit) : $model->get_popular_on_current_site($limit, $posted_within, $voted_within);

		$ret = '';
		if (is_array($posts)) {
			$ret .= '<ul class="wdpv_popular_posts ' . ($network ? 'wdpv_network_popular' : '') . '">';
			foreach ($posts as $post) {
				if ($network) {
					$data = get_blog_post($post['blog_id'], $post['post_id']);
					if (!$data) continue;
				}
				$title = apply_filters('the_title', $network ? $data->post_title : $post['post_title']);
				$permalink = $network ? get_blog_permalink($post['blog_id'], $post['post_id']) : get_permalink($post['ID']);

				$ret .= "<li>" .
					"<a href='{$permalink}'>{$title}</a> " .
					sprintf(__('<span class="wdpv_vote_count">(%s votes)</span>', 'wdpv'), $post['total']) .
				"</li>";
			}
			$ret .= '</ul>';
		}
		return $ret;
	}

	function process_vote_up_code ($args=array()) {
		if (!$this->data->get_option('allow_voting')) return '';

		$user_id = $this->model->get_user_id();
		if (!$user_id && !$this->data->get_option('allow_visitor_voting')) {
			if ($this->data->get_option('show_login_link')) {
				return $this->_generate_login_link();
			}
			return '';
		}
		$args = shortcode_atts(array(
			'standalone' => false,
			'blog_id' => false,
			'post_id' => false,
		), $args);
		$standalone = ('no' != $args['standalone']) ? true : false;
		$skin = $this->data->get_option('voting_appearance');

		$post_id = $args['post_id'] ? $args['post_id'] : get_the_ID();
		$blog_id = $this->_get_blog_id($args['blog_id']);
		if (!$this->_check_voting_display_restrictions($post_id)) return '';

		$class = 'wdpv_vote_up';
		if ( $this->data->get_option('voting_appearance') == 'icomoon' )
			$class .= ' wdpv-icon-thumbs-up';
		$ret = "<div class='wdpv_vote_up {$skin}'><input type='hidden' value='{$post_id}' /><input type='hidden' class='wdpv_blog_id' value='{$blog_id}' /></div>";
		$ret .= $standalone ? '<div class="wdpv_clear"></div>' : '';
		return apply_filters('wdpv-output-vote_up', $ret, $args, $blog_id, $post_id);
	}

	function process_vote_down_code ($args=array()) {
		if (!$this->data->get_option('allow_voting')) return '';

		$user_id = $this->model->get_user_id();
		if (!$user_id && !$this->data->get_option('allow_visitor_voting')) {
			if ($this->data->get_option('show_login_link')) {
				return $this->_generate_login_link();
			}
			return '';
		}
		$args = shortcode_atts(array(
			'standalone' => false,
			'blog_id' => false,
			'post_id' => false,
		), $args);
		$standalone = ('no' != $args['standalone']) ? true : false;
		$skin = $this->data->get_option('voting_appearance');

		$post_id = $args['post_id'] ? $args['post_id'] : get_the_ID();
		$blog_id = $this->_get_blog_id($args['blog_id']);
		if (!$this->_check_voting_display_restrictions($post_id)) return '';

		$ret = "<div class='wdpv_vote_down {$skin}'><input type='hidden' value='{$post_id}' /><input type='hidden' class='wdpv_blog_id' value='{$blog_id}' /></div>";
		$ret .= $standalone ? '<div class="wdpv_clear"></div>' : '';
		return apply_filters('wdpv-output-vote_down', $ret, $args, $blog_id, $post_id);
	}

	function process_vote_result_code ($args=array()) {
		if (!$this->data->get_option('allow_voting')) return '';

		$args = shortcode_atts(array(
			'standalone' => false,
			'blog_id' => false,
			'post_id' => false,
		), $args);
		$standalone = ('no' != $args['standalone']) ? true : false;
		$post_id = $args['post_id'] ? $args['post_id'] : get_the_ID();
		$blog_id = $this->_get_blog_id($args['blog_id']);
		$count = $this->model->get_votes_total($post_id, false, $blog_id);
		$ret = "<div class='wdpv_vote_result'><span class='wdpv_vote_result_output'>{$count}</span><input type='hidden' value='{$post_id}' /><input type='hidden' class='wdpv_blog_id' value='{$blog_id}' /></div>";				 	   	     	
		$ret .= $standalone ? '<div class="wdpv_clear"></div>' : '';
		return apply_filters('wdpv-output-vote_result', $ret, $args, $blog_id, $post_id);
	}

	function process_vote_widget_code ($args=array()) {
		if (!$this->data->get_option('allow_voting')) return '';

		$user_id = $this->model->get_user_id();
		if (!$user_id && !$this->data->get_option('allow_visitor_voting')) {
			if ($this->data->get_option('show_login_link')) {
				return $this->_generate_login_link();
			}
			return '';
		}

		$args = shortcode_atts( array(
			'standalone' => false,
			'blog_id' => false,
			'post_id' => false,
		), $args );
		$standalone = ('no' != $args['standalone'] ) ? true : false;

		$post_id = $args['post_id'] ? $args['post_id'] : get_the_ID();
		$blog_id = $this->_get_blog_id($args['blog_id']);
		if ( ! $this->_check_voting_display_restrictions( $post_id ) )
			return '';

		$ret = apply_filters( 'wdpv-output-before_vote_widget', '', $args, $blog_id, $post_id );
		if ( ! $ret ) {
			$ret = $this->get_code( 'vote_up', false, $blog_id, $post_id ) . ' ' . $this->get_code( 'vote_result', false, $blog_id, $post_id ) . ' ';
			$ret .= ( $this->data->get_option('voting_positive' ) ) ? '' : $this->get_code( 'vote_down', false, $blog_id, $post_id );
			$ret = do_shortcode("<div class='wdpv_voting'>{$ret}</div>");
		}

		$ret .= $standalone ? '<div class="wdpv_clear"></div>' : '';
		return apply_filters('wdpv-output-vote_widget', $ret, $args, $blog_id, $post_id);
	}

	function get_code ($key, $standalone=true, $blog_id=false, $post_id=false) {
		$standalone = $standalone ? 'yes' : 'no';
		$post_id = $post_id ? "post_id='{$post_id}'" : '';
		$blog_id = $blog_id ? "blog_id='{$blog_id}'" : '';
		return '[' . $this->shortcodes[$key] . ' standalone="' . $standalone . '" ' . $post_id . ' ' . $blog_id . ']';
	}

	/**
	 * Registers shortcode handlers.
	 */
	function register () {
		foreach ($this->shortcodes as $key=>$shortcode) {
			//var_export("process_{$key}_code");
			add_shortcode($shortcode, array($this, "process_{$key}_code"));
		}
	}

	function _get_blog_id ($bid=false) {
		$bid = (int)$bid;
		return $bid ? $bid : get_current_blog_id();
	}

	function has_wdpv_shortcode ($shortcode, $body) {
		$shortcode = !empty($this->shortcodes[$shortcode])
			? $this->shortcodes[$shortcode]
			: false
		;
		if (!$shortcode) return false;
		return $this->_has_shortcode($shortcode, $body);
	}

	private function _has_shortcode ($shortcode, $body) {
		$shortcode_rx = preg_quote("[{$shortcode}", '/');
		return preg_match("/{$shortcode_rx}/i", $body);
	}
}
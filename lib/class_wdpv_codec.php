<?php
/**
 * Handles shortcode creation and replacement.
 */
class Wdpv_Codec {

	var $shortcodes = array(
		'wdpv_vote_up',
		'wdpv_vote_down',
		'wdpv_vote_result',
		'wdpv_vote',
		'wdpv_popular',
		'wdpv_no_auto',
	);

	var $model;
	var $data;

	function __construct () {
		$this->model = wdpv_get_model();
		$this->data = new Wdpv_Options;
	}

	function _generate_login_link () {
		$post_id = get_the_ID();
		$count = $this->model->get_votes_total( $post_id );
		return sprintf(
			__( '<div class="wdpv_login">This post has %s votes. <a href="%s">Log in now</a> to vote</div>', 'wdpv' ),
			$count, site_url( 'wp-login.php' )
		);
	}

	function _check_voting_display_restrictions ($post_id) {
		if ( ! $post_id ) { return false; }

		$type = get_post_type( $post_id );
		if ( ! $type ) { return false; }

		$skip_types = $this->data->get_option( 'skip_post_types' );
		if ( ! is_array( $skip_types ) ) { return true; // No restrictions, we're good
		}
		return ( ! in_array( $type, $skip_types ));
	}

	function process_wdpv_no_auto_code ($args=array()) {
		return '';
	}

	function process_wdpv_popular_code( $args = array() ) {
		$args = extract(shortcode_atts(array(
			'limit' => 5,
			'network' => false,
			'posted_within' => false,
			'voted_within' => false,
		), $args));

		$model = wdpv_get_model();
		$posts = $network ? $model->get_popular_on_network( $limit ) : $model->get_popular_on_current_site( $limit, $posted_within, $voted_within );

		$ret = '';
		if ( is_array( $posts ) ) {
			$ret .= '<ul class="wdpv_popular_posts ' . ($network ? 'wdpv_network_popular' : '') . '">';
			foreach ( $posts as $post ) {
				if ( $network ) {
					$data = get_blog_post( $post['blog_id'], $post['post_id'] );
					if ( ! $data ) { continue; }
				}
				$title = apply_filters( 'the_title', $network ? $data->post_title : $post['post_title'] );
				$permalink = $network ? get_blog_permalink( $post['blog_id'], $post['post_id'] ) : get_permalink( $post['ID'] );

				$ret .= '<li>' .
					"<a href='{$permalink}'>{$title}</a> " .
					sprintf( __( '<span class="wdpv_vote_count">(%s votes)</span>', 'wdpv' ), $post['total'] ) .
				'</li>';
			}
			$ret .= '</ul>';
		}
		return $ret;
	}

	/**
	 * Registers shortcode handlers.
	 */
	function register () {
		foreach ( $this->shortcodes as $shortcode ) {
			add_shortcode( $shortcode, array($this, "process_{$shortcode}_code") );
		}
	}

	public function process_wdpv_vote_code( $args = array() ) {
		$args = shortcode_atts( array(
			'blog_id' => 'false',
			'post_id' => 'false',
			'up' => 'true',
			'down' => 'true',
			'results' => 'true'
		), $args, 'wdpv_vote' );

		$box_args = array(
			'show_up' => $args['up'] === 'true' ? true : false,
			'show_down' => $args['down'] === 'true' ? true : false,
			'show_votes' => $args['results'] === 'true' ? true : false,
			'post_id' => $args['post_id'] === 'true' ? true : false,
			'blog_id' => $args['blog_id'] === 'true' ? true : false,
			'echo' => false
		);

		return self::wdpv_render_vote_box( $box_args );
	}

	public function process_wdpv_vote_up_code( $args = array() ) {
		return $this->process_wdpv_vote_code( array( 'down' => 'false' ) );
	}

	public function process_wdpv_vote_down_code( $args = array() ) {
		return $this->process_wdpv_vote_code( array( 'up' => 'false' ) );
	}

	public function process_wdpv_vote_result_code( $args = array() ) {
		return $this->process_wdpv_vote_code( array( 'up' => 'false', 'down' => 'false' ) );
	}


	function has_wdpv_shortcode ($shortcode, $body) {
		$shortcode = ! empty($this->shortcodes[$shortcode])
			? $this->shortcodes[$shortcode]
			: false
		;
		if ( ! $shortcode ) { return false; }
		return $this->_has_shortcode( $shortcode, $body );
	}

	private function _has_shortcode ($shortcode, $body) {
		$shortcode_rx = preg_quote( "[{$shortcode}", '/' );
		return preg_match( "/{$shortcode_rx}/i", $body );
	}

	public static function wdpv_render_vote_box( $args = array() ) {
		$defaults = array(
			'show_up' => true,
			'show_down' => true,
			'show_votes' => true,
			'post_id' => false,
			'blog_id' => false,
			'echo' => true
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_id'] = $args['post_id'] ? $args['post_id'] : get_the_ID();

		if ( ! $args['blog_id'] ) {
			$args['blog_id'] = is_multisite() ? get_current_blog_id() : 1;
		}
		
		$custom_vote_box = apply_filters( 'wdpv_vote_box', false, $args );
		if ( $custom_vote_box ) {
			// Custom content instead
			if ( $args['echo'] ) {
				echo $custom_vote_box;
				return;
			}

			return $custom_vote_box;
		}

		$model = wdpv_get_model();

		$class = '';
		if ( ! $args['show_up'] )
			$class .= 'wdpv-up-hidden';
		if ( ! $args['show_down'] )
			$class .= 'wdpv-down-hidden';
		if ( ! $args['show_votes'] )
			$class .= 'wdpv-votes-hidden';

		if ( ! $args['echo'] )
			ob_start();
		?>
			<div class="wdpv_voting <?php echo $class; ?>">
		<?php

		if ( $args['show_up'] )
			self::wdpv_render_vote_up_box( $args );

		if ( $args['show_votes'] )
			self::wdpv_render_vote_votes_box( $args );

		if ( $args['show_down'] )
			self::wdpv_render_vote_down_box( $args );

		?>
			</div>
		<?php

		if ( ! $args['echo'] )
			return ob_get_clean();
	}

	private static function wdpv_render_vote_down_box( $args = array() ) {
		$defaults = array(
			'post_id' => false,
			'blog_id' => is_multisite() ? get_current_blog_id() : 1,
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_id'] = $args['post_id'] ? $args['post_id'] : get_the_ID();

		?>
			<div class="wdpv_vote_down icomoon">
				<i class="wdpv-icon"></i>
				<input type="hidden" value="<?php echo $args['post_id']; ?>">
				<input type="hidden" class="wdpv_blog_id" value="<?php echo $args['blog_id']; ?>">
			</div> 
		<?php

	}

	private static function wdpv_render_vote_up_box( $args = array() ) {
		$defaults = array(
			'post_id' => false,
			'blog_id' => is_multisite() ? get_current_blog_id() : 1,
			'echo' => true
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_id'] = $args['post_id'] ? $args['post_id'] : get_the_ID();

		?>
			<div class="wdpv_vote_up icomoon">
				<i class="wdpv-icon"></i>
				<input type="hidden" value="<?php echo $args['post_id']; ?>">
				<input type="hidden" class="wdpv_blog_id" value="<?php echo $args['blog_id']; ?>">
			</div> 
		<?php

	}

	private static function wdpv_render_vote_votes_box( $args = array() ) {
		$defaults = array(
			'post_id' => false,
			'blog_id' => is_multisite() ? get_current_blog_id() : 1,
			'echo' => true
		);

		$args = wp_parse_args( $args, $defaults );

		$args['post_id'] = $args['post_id'] ? $args['post_id'] : get_the_ID();

		$model = wdpv_get_model();
		$count = $model->get_votes_total( $args['post_id'], false, $args['blog_id'] );

		?>
			<div class="wdpv_vote_result">
				<span class="wdpv_vote_result_output"><?php echo $count; ?></span>
				<input type="hidden" value="<?php echo $args['post_id']; ?>">
				<input type="hidden" class="wdpv_blog_id" value="<?php echo $args['blog_id']; ?>">
			</div>
		<?php

	}

}

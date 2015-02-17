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
		add_filter( 'wdpv_vote_box', array($this, 'output_voting_widget'), 10, 2 );
		add_filter( 'wdpv-output-before_vote_widget', array($this, 'output_voting_widget'), 10, 4 );

		add_filter( 'wdpv-output-vote_result', array($this, 'output_voting_result'), 10, 4 );
		add_filter( 'wdpv-output-vote_down', '__return_false' );
		add_filter( 'wdpv-output-vote_up', '__return_false' );

		add_filter( 'wdpv-output-personal_vote_result', array($this, 'output_personal_voting_widget'), 10, 4 );

		add_action( 'wp_ajax_wdpv_rating_results', array($this, 'json_rating_results') );
		add_action( 'wp_ajax_nopriv_wdpv_rating_results', array($this, 'json_rating_results') );

		add_action( 'wp_ajax_wdpv_personal_rating_results', array($this, 'json_personal_rating_results') );
		add_action( 'wp_ajax_nopriv_wdpv_personal_rating_results', array($this, 'json_personal_rating_results') );

		// We need Dashicons for the stars
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_dashicons' ) );

		// Use our own styles and JS
		$public_pages = Wdpv_PublicPages::serve();
		remove_action( 'wp_enqueue_scripts', array( $public_pages, 'js_load_scripts' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'load_scripts' ) );
		remove_action( 'plugins_loaded', array( $public_pages, 'render_colors_stylesheet' ) );
		add_action( 'plugins_loaded', array(  $this, 'render_colors_stylesheet' ) );

	}

	public function load_scripts() {
		$options = wdpv_get_options();
		if ( $options['allow_voting'] ) {
			wp_enqueue_script( 'wdpv_voting', WDPV_PLUGIN_URL . '/lib/plugins/five-star/five-star.js', array( 'jquery' ) ); 
			$l10n = array(
				'ajaxurl' => admin_url( 'admin-ajax.php' )
			);
			wp_localize_script( 'wdpv_voting', 'wdpv_i18n', $l10n );
		}
	}

	function render_colors_stylesheet() {
		if ( isset( $_GET['wdpv-colors'] ) ) {
			header( 'Content-type: text/css' );

			$options = wdpv_get_options();
			?>
				.wdpv_voting {
					direction:rtl;
					text-align:left;
				}
				.wdpv_star {
					display:inline-block;
					position: relative;
					
				}
				.wdpv_star:after {
					font-family:'dashicons';
					font-size:18px;
					color:<?php echo $options['color_up']; ?>;
					cursor:pointer;
				}
				.wdpv_star_full:after {
					content: "\f155";
				}
				.wdpv_star_half:after {
					content: "\f459";
				}
				.wdpv_star_empty:after {
					content: "\f154";
				}

				.wdpv_vote_star > span.wdpv_star:hover:after,
				.wdpv_vote_star > span.wdpv_star:hover ~ span.wdpv_star:after {
					content: "\f155";
					color:black;
					color:<?php echo $options['color_down']; ?>;
				}

				.wdpv_star_selected:after {
					color:<?php echo $options['color_down']; ?>;
				}
			<?php
			exit;
		}
	}

	public function enqueue_dashicons() {
		wp_enqueue_style( 'dashicons' );
	}

	function output_voting_widget( $ret, $args ) {
		$post_id = $args['post_id'];
		$blog_id = $args['blog_id'];

		$count = $this->_model->get_votes_count( $post_id, false, $blog_id );
		$count = $count ? $count : 1;

		$positives = $this->_model->get_votes_positives( $post_id, false, $blog_id );
		
		$rating = round( ( $positives / $count ) * 10 );

		$ratings = array();
		if ( $rating )
			$ratings = array_fill( 0, $rating, 1 );

		$stars = array();
		for ( $i = 0; $i < 10; $i = $i + 2 ) {
			if ( isset( $ratings[ $i + 1 ] ) && isset( $ratings[ $i + 1 ] ) )
				$stars[] = 'full';
			elseif ( isset( $ratings[ $i ] ) )
				$stars[] = 'half';
			else
				$stars[] = 'empty';
		}

		$stars = array_reverse( $stars );
		$ajax_nonce = wp_create_nonce( 'wdpv-vote' );

		$options = wdpv_get_options();
		ob_start();

		$i = 5;
		?>
			<div class="wdpv_voting">
				<div class="wdpv_vote_star">
					<?php foreach ( $stars as $star ): ?>
						<span class="wdpv_star wdpv_star_<?php echo $i; ?> wdpv_star_<?php echo $star; ?>" data-rating="<?php echo $i; ?>" data-blog-id=<?php echo $args['blog_id']; ?> data-post-id=<?php echo $args['post_id']; ?> data-nonce="<?php echo esc_attr( $ajax_nonce ); ?>"></span>
						<?php $i--; ?>
					<?php endforeach; ?>
				</div>
			</div>
		<?php
		return ob_get_clean();
	}

	function output_personal_voting_widget ($ret, $args, $blog_id, $post_id) {
		global $current_user;
		$avg = $this->_model->get_user_votes_total( $current_user->id, $post_id, false, $blog_id );
		// Round the result to .5 increments
		$result = (int)$avg; // Get the lower int part
		$tmp = $avg - $result;
		$result += round( $tmp ) ? .5 : 0;

		$offset = $result * 10;

		return $this->_user_voted( $current_user->id, $post_id, $blog_id )
			? "<div class='wdpv_voting wdpv_five_stars'>" .
				"<div class='wdpv_rating wdpv_personal_rating wdpv_static wdpv_dev_stars wdpv_{$offset}_offset'>" .
					"<span class='wdpv_rating_result'>{$result}</span>" .
				'</div>' .
			'</div>'
			: "<div class='wdpv_voting wdpv_five_stars'>" .
				"<div class='wdpv_rating wdpv_personal_rating wdpv_dev_stars wdpv_{$offset}_offset'>" .
					"<input type='hidden' class='wdpv_blog_id' value='{$blog_id}' />" .
					"<input type='hidden' value='{$post_id}' />" .
				'</div>' .
			'</div>'
		;
	}

	function output_voting_result ($ret, $args, $blog_id, $post_id) {
		$total = $this->_model->get_votes_total( $post_id, false, $blog_id );

		$count = $this->_model->get_votes_count( $post_id, false, $blog_id );
		$count = $count ? $count : 1;

		$avg = $total / $count;

		// Round the result to .5 increments
		$result = (int)$avg; // Get the lower int part
		$tmp = $avg - $result;
		$result += round( $tmp ) ? .5 : 0;

		$offset = $result * 10;

		return "<div class='wdpv_voting wdpv_five_stars' itemprop='rating' itemscope itemtype='http://data-vocabulary.org/Rating'>" .
			"<div class='wdpv_rating wdpv_static wdpv_dev_stars wdpv_{$offset}_offset'>" .
				"<span class='wdpv_rating_result' itemprop='value'>{$result}</span>" .
				'<meta itemprop="best" content="5" />' .
			'</div>' .
		'</div>';
	}

	private function _user_voted ($user_id, $post_id, $blog_id) {
		global $wpdb;
		$where = apply_filters( 'wdpv-sql-where-user_id_check', "WHERE user_id={$user_id} AND blog_id={$blog_id} AND post_id={$post_id}" );
		$result = $wpdb->get_var( 'SELECT COUNT(*) FROM ' . $wpdb->base_prefix . "wdpv_post_votes {$where}" );
		return $result;
	}

	function json_rating_results () {
		$data = false;
		if ( isset($_POST['post_id']) ) {
			$total = $this->_model->get_votes_total( (int)$_POST['post_id'], false, (int)@$_POST['blog_id'] );
			$count = $this->_model->get_votes_count( (int)$_POST['post_id'], false, (int)@$_POST['blog_id'] );
			$count = $count ? $count : 1;

			$avg = $total / $count;

			// Round the result to .5 increments
			$result = (int)$avg; // Get the lower int part
			$tmp = $avg - $result;
			$result += round( $tmp ) ? .5 : 0;

			$data = $result * 10;
		}
		header( 'Content-type: application/json' );
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
	}

	function json_personal_rating_results () {
		global $current_user;
		$data = false;
		if ( isset($_POST['post_id']) ) {
			$avg = $this->_model->get_user_votes_total( $current_user->id, (int)$_POST['post_id'], false, (int)@$_POST['blog_id'] );
			// Round the result to .5 increments
			$result = (int)$avg; // Get the lower int part
			$tmp = $avg - $result;
			$result += round( $tmp ) ? .5 : 0;

			$data = $result * 10;
		}

		header( 'Content-type: application/json' );
		echo json_encode(array(
			'status' => ($data ? 1 : 0),
			'data' => (int)$data,
		));
		exit();
	}
}


Wdpv_Voting_FiveStarRating::serve();

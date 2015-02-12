<?php

class Wdpv_Ajax {
	public function __construct() {
		$this->model = wdpv_get_model();
		$this->data = new Wdpv_Options;

		// Step1: add AJAX hooks
		if ( $this->data->get_option( 'allow_voting' ) ) {
			// Step1a: add AJAX hooks for visitors
			if ( $this->data->get_option( 'allow_visitor_voting' ) ) {
				add_action( 'wp_ajax_nopriv_wdpv_record_vote', array($this, 'json_record_vote') );
			}
			// Step1b: add AJAX hooks for registered users
			add_action( 'wp_ajax_wdpv_record_vote', array($this, 'json_record_vote') );
		}
	}

	function json_record_vote () {
		$status = false;
		$data = false;
		if ( isset($_POST['wdpv_vote']) && isset($_POST['post_id']) ) {
			$vote = (int)$_POST['wdpv_vote'];
			$post_id = (int)$_POST['post_id'];
			$blog_id = (int)@$_POST['blog_id'];
			$status = $this->model->update_post_votes( $blog_id, $post_id, $vote );	
			$data = $this->model->get_votes_total( (int)$_POST['post_id'], false, (int)@$_POST['blog_id'] );
		}

		wp_send_json( array( 'status' => $status, 'votes' => $data ) );
		exit();
	}


	function render_colors_stylesheet() {
		if ( isset( $_GET['wdpv-colors'] ) ) {
			header( 'Content-type: text/css' );

			$options = wdpv_get_options();
			?>
				.wdpv_vote_down i.wdpv-icon:after {
				   color:<?php echo $options['color_down']; ?>
				}
				.wdpv_vote_up i.wdpv-icon:after {
				   color:<?php echo $options['color_up']; ?>
				}
			<?php
			exit;
		}
	}
}
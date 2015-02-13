<?php
/**
 * Shows "Vote" box with number of votes.
 */
class Wdpv_WidgetVoting extends WP_Widget {

	function Wdpv_WidgetVoting () {
		$widget_ops = array('classname' => __CLASS__, 'description' => __( 'Shows "Vote" box for current post/page with number of votes.', 'wdpv' ));
		parent::WP_Widget( __CLASS__, __( 'Voting Widget', 'wdpv' ), $widget_ops );
	}

	function form($instance) {
		$defaults = array(
			'title' => '',
			'show_vote_up' => false,
			'show_vote_down' => false,
			'show_vote_result' => false,
		);

		$instance = wp_parse_args( $instance, $defaults );

		$title = esc_attr( $instance['title'] );
		$show_vote_up = $instance['show_vote_up'];
		$show_vote_down = $instance['show_vote_down'];
		$show_vote_result = $instance['show_vote_result'];

		// Set defaults
		// ...

		$html = '<p>';
		$html .= '<label for="' . $this->get_field_id( 'title' ) . '">' . __( 'Title', 'wdpv' ) . '</label>';
		$html .= '<input type="text" name="' . $this->get_field_name( 'title' ) . '" id="' . $this->get_field_id( 'title' ) . '" class="widefat" value="' . $title . '"/>';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<input type="checkbox" name="' . $this->get_field_name( 'show_vote_up' ) . '" id="' . $this->get_field_id( 'show_vote_up' ) . '" value="1" ' . checked( $show_vote_up, true, false ) . ' />';
		$html .= '<label for="' . $this->get_field_id( 'show_vote_up' ) . '">' . __( 'Show "Vote up" button', 'wdpv' ) . '</label>';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<input type="checkbox" name="' . $this->get_field_name( 'show_vote_down' ) . '" id="' . $this->get_field_id( 'show_vote_down' ) . '" value="1" ' . checked( $show_vote_down, true, false ) . ' />';
		$html .= '<label for="' . $this->get_field_id( 'show_vote_down' ) . '">' . __( 'Show "Vote down" button', 'wdpv' ) . '</label>';
		$html .= '</p>';

		$html .= '<p>';
		$html .= '<input type="checkbox" name="' . $this->get_field_name( 'show_vote_result' ) . '" id="' . $this->get_field_id( 'show_vote_result' ) . '" value="1" ' . checked( $show_vote_result, true, false ) . ' />';
		$html .= '<label for="' . $this->get_field_id( 'show_vote_result' ) . '">' . __( 'Show voting results', 'wdpv' ) . '</label>';
		$html .= '</p>';

		echo $html;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_vote_up'] = strip_tags( $new_instance['show_vote_up'] );
		$instance['show_vote_down'] = strip_tags( $new_instance['show_vote_down'] );
		$instance['show_vote_result'] = strip_tags( $new_instance['show_vote_result'] );

		return $instance;
	}

	function widget($args, $instance) {
		global $post;
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$show_vote_up = (int)@$instance['show_vote_up'];
		$show_vote_up = $show_vote_up ? true : false;

		$show_vote_down = (int)@$instance['show_vote_down'];
		$show_vote_down = $show_vote_down ? true : false;

		$show_vote_result = (int)@$instance['show_vote_result'];
		$show_vote_result = $show_vote_result ? true : false;

		if ( is_singular() ) { // Show widget only on votable pages
			echo $before_widget;
			if ( $title ) { echo $before_title . $title . $after_title; }

			Wdpv_Codec::wdpv_render_vote_box(
				array(
					'show_up' => $show_vote_up,
					'show_down' => $show_vote_down,
					'show_votes' => $show_vote_result,
					'echo' => true
				)
			);

			echo $after_widget;
		}
	}
}

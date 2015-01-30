<?php
/**
 * Renders form elements for admin settings pages.
 */
class Wdpv_AdminFormRenderer {
	function _get_option () {
		return WP_NETWORK_ADMIN ? get_site_option( 'wdpv' ) : get_option( 'wdpv' );
	}

	function _create_checkbox ($name) {
		$opt = $this->_get_option();
		$value = @$opt[$name];
		$disabled = (@$opt['disable_siteadmin_changes'] && ! current_user_can( 'manage_network_options' )) ? 'disabled="disabled"' : '';
		return
			"<input {$disabled} type='radio' name='wdpv[{$name}]' id='{$name}-yes' value='1' " . ((int)$value ? 'checked="checked" ' : '') . ' /> ' .
				"<label for='{$name}-yes'>" . __( 'Yes', 'wdpv' ) . '</label>' .
			'<br />' .
			"<input {$disabled} type='radio' name='wdpv[{$name}]' id='{$name}-no' value='0' " . ( ! (int)$value ? 'checked="checked" ' : '') . ' /> ' .
				"<label for='{$name}-no'>" . __( 'No', 'wdpv' ) . '</label>' .
		'';
	}

	function create_allow_voting_box () {
		$opt = wdpv_get_options();

		$slug = 'allow_voting';
		$checked = $opt[ $slug ];

		include( 'views/settings-checkbox.php' );
	}

	function create_allow_visitor_voting_box () {
		$opt = wdpv_get_options();

		$slug = 'allow_visitor_voting';
		$checked = $opt[ $slug ];

		include( 'views/settings-checkbox.php' );
	}
	function create_use_ip_check_box () {
		$opt = wdpv_get_options();

		$slug = 'use_ip_check';
		$checked = $opt[ $slug ];

		$description = '<p class="description">' . __( 'By default, visitors are tracked by IP too in order to prevent multiple voting. However, this can be problematic in certain cases (e.g. multiple users behind a single router).', 'wdpv' ) . '</p>';
		$description .= '<p class="description">' . __( 'Set this to "No" if you don\'t want to use this measure.', 'wdpv' ) . '</p>';

		include( 'views/settings-checkbox.php' );
	}

	function create_show_login_link_box () {
		$opt = wdpv_get_options();

		$slug = 'show_login_link';
		$checked = $opt[ $slug ];

		$description = '<p class="description">' . __( 'By default, if visitor voting is not allowed, voting will not be shown at all.', 'wdpv' ) . '</p>';
		$description .= '<p class="description">' . __( 'Set this to "Yes" if you wish to have the login link instead.', 'wdpv' ) . '</p>';

		include( 'views/settings-checkbox.php' );
	}
	function create_voting_position_box () {
		$opt = wdpv_get_options();

		$slug = 'voting_position';
		$opt = $opt[ $slug ];

		include( 'views/settings-position.php' );
	}

	function create_front_page_voting_box () {
		$opt = wdpv_get_options();

		$slug = 'front_page_voting';
		$checked = $opt[ $slug ];

		$description = '<p class="description">' . __( 'By default, voting will be shown only on singular pages.', 'wdpv' ) . '</p>';
		$description .= '<p class="description">' . __( 'Set this option to "Yes" to add voting to all posts on the front page.', 'wdpv' ) . '</p>';

		include( 'views/settings-checkbox.php' );
	}
	function create_voting_appearance_box () {
		$skins = array (
			'icomoon' => __( 'Default', 'wdpv' ),
			'arrows' => __( 'Arrows', 'wdpv' ),
			'plusminus' => __( 'Plus/Minus', 'wdpv' ),
			'whitearrow' => __( 'Alternative arrows', 'wdpv' ),
			'qa' => __( 'Q&amp;A arrows', 'wdpv' ),
		);

		$opt = wdpv_get_options();

		include_once( 'views/settings-appearance.php' );
	}

	function create_voting_colors_box() {
		$opt = wdpv_get_options();

		$color_up = $opt['color_up'];
		$color_down = $opt['color_down'];
		include_once( 'views/settings-colors.php' );
	}

	function create_voting_positive_box () {
		$opt = wdpv_get_options();

		$slug = 'voting_positive';
		$checked = $opt[ $slug ];

		$description = '<p class="description">' . __( 'If checked, this option will prevent negative votes by showing only positive voting link.', 'wdpv' ) . '</p>';

		include( 'views/settings-checkbox.php' );
	}
	function create_disable_siteadmin_changes_box () {
		$opt = wdpv_get_options();

		$slug = 'disable_siteadmin_changes';
		$checked = $opt[ $slug ];

		$description = '<p class="description">' . __( 'By default, Site Admins are allowed to access plugin settings and make changes.', 'wdpv' ) . '</p>';
		$description .= '<p class="description">' . __( 'Set this option to "Yes" to prevent them from making changes to plugin settings.', 'wdpv' ) . '</p>';

		include( 'views/settings-checkbox.php' );
	}

	function create_skip_post_types_box () {
		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$opt = $this->_get_option();
		$skip_types = is_array( @$opt['skip_post_types'] ) ? @$opt['skip_post_types'] : array();

		foreach ( $post_types as $tid => $post_type_object ) {
			$checked = in_array( $tid, $skip_types ) ? 'checked="checked"' : '';
			echo
				"<input type='hidden' name='wdpv[skip_post_types][{$tid}]' value='0' />" . // Override for checkbox
				"<input {$checked} type='checkbox' name='wdpv[skip_post_types][{$tid}]' id='skip_post_types-{$tid}' value='{$tid}' /> " .
				"<label for='skip_post_types-{$tid}'>" . ucfirst( $post_type_object->labels->name ) . '</label>' .
			'<br />';
		}
		_e(
			'<p>Voting will <strong><em>not</em></strong> be shown for selected types.</p>',
			'wdpv'
		);
	}

	// BuddyPress

	function create_bp_publish_activity_box () {
		echo $this->_create_checkbox( 'bp_publish_activity' );
		echo '<div><small>' . __( 'Activities will be recorded only for your logged in users', 'wdpv' ) . '</small></div>';
		echo __( 'Hide from sitewide activity stream:', 'wdpv' ) . ' ';
		echo $this->_create_checkbox( 'bp_publish_activity_local' );
		echo '<div><small>' . __( 'Recorded activities will be hidden from your sitewide activity stream', 'wdpv' ) . '</small></div>';
	}

	function create_bp_profile_votes_box () {
		$opt = $this->_get_option();
		echo $this->_create_checkbox( 'bp_profile_votes' );
		echo '<br />';

		// Set defaults
		$opt['bp_profile_votes_limit'] = @$opt['bp_profile_votes_limit'] ? $opt['bp_profile_votes_limit'] : 0;
		$opt['bp_profile_votes_period'] = @$opt['bp_profile_votes_period'] ? $opt['bp_profile_votes_period'] : 1;
		$opt['bp_profile_votes_unit'] = @$opt['bp_profile_votes_unit'] ? $opt['bp_profile_votes_unit'] : 'month';

		echo __( 'Show', 'wdpv' ) . ' ';
		echo '<select name="wdpv[bp_profile_votes_limit]">';
		for ( $i = 0; $i <= 20; $i++ ) {
			$title = $i ? $i : __( 'all', 'wdpv' );
			$selected = ($i == @$opt['bp_profile_votes_limit']) ? 'selected="selected"' : '';
			echo "<option value='{$i}' {$selected}>{$title}</option>";
		}
		echo '</select> ';

		echo __( 'vote(s) within last', 'wdpv' ) . ' ';
		echo '<select name="wdpv[bp_profile_votes_period]">';
		for ( $i = 1; $i <= 24; $i++ ) {
			$selected = ($i == @$opt['bp_profile_votes_period']) ? 'selected="selected"' : '';
			echo "<option value='{$i}' {$selected}>{$i}</option>";
		}
		echo '</select> ';
		echo '<select name="wdpv[bp_profile_votes_unit]">';
		foreach ( array('hour', 'day', 'week', 'month', 'year') as $unit ) {
			$selected = ($unit == @$opt['bp_profile_votes_unit']) ? 'selected="selected"' : '';
			$title = ucfirst( $unit ) . '(s)';
			echo "<option value='{$unit}' {$selected}>{$title}</option>";
		}
		echo '</select> ';

	}

	function create_plugins_box () {
		$all = Wdpv_PluginsHandler::get_all_plugins();
		$active = Wdpv_PluginsHandler::get_active_plugins();

		include( 'views/settings-plugins.php' );
	}
}

<p>
	<label for="bp_profile_votes-yes">
		<input type="radio" name="wdpv[bp_profile_votes]" id="bp_profile_votes-yes" value="1" <?php checked( $profile_votes ); ?>>
		<?php _e( 'Yes', 'wdpv' ); ?>
	</label>&nbsp;&nbsp;
	<label for="bp_profile_votes-no">
		<input type="radio" name="wdpv[bp_profile_votes]" id="bp_profile_votes-no" value="0" <?php checked( ! $profile_votes ); ?>>
		<?php _e( 'No', 'wdpv' ); ?>
	</label>
	<br/>
</p>
<br/>

<p>
	<?php _e( 'Show', 'wdpv' ); ?> 
	<select name="wdpv[bp_profile_votes_limit]">
		<?php for ( $i = 0; $i <= 20; $i++ ): ?>
			<?php $title = $i ? $i : __( 'all', 'wdpv' ); ?>
			<option value="<?php echo $i; ?>" <?php selected( $profile_votes_limit, $i ); ?>><?php echo $title; ?></option>
		<?php endfor; ?>
	</select>
	<?php _e( 'vote(s) within last', 'wdpv' ); ?> 
	<select name="wdpv[bp_profile_votes_period]">
		<?php for ( $i = 0; $i <= 24; $i++ ): ?>
			<option value="<?php echo $i; ?>" <?php selected( $profile_votes_period, $i ); ?>><?php echo $i; ?></option>
		<?php endfor; ?>
	</select>
	<select name="wdpv[bp_profile_votes_unit]">
		<?php foreach ( array('hour', 'day', 'week', 'month', 'year') as $unit ): ?>
			<?php $title = ucfirst( $unit ) . '(s)'; ?>
			<option value="<?php echo $unit; ?>" <?php selected( $profile_votes_unit, $unit ); ?>><?php echo $title; ?></option>
		<?php endforeach; ?>
	</select>
</p>
<p>
	<label for="bp_publish_activity-yes">
		<input type="radio" name="wdpv[bp_publish_activity]" id="bp_publish_activity-yes" value="1" <?php checked( $publish_activity ); ?>>
		<?php _e( 'Yes', 'wdpv' ); ?>
	</label>&nbsp;&nbsp;
	<label for="bp_publish_activity-no">
		<input type="radio" name="wdpv[bp_publish_activity]" id="bp_publish_activity-no" value="0" <?php checked( ! $publish_activity ); ?>>
		<?php _e( 'No', 'wdpv' ); ?>
	</label>
	<br/>
	<span class="description"><?php _e( 'Activities will be recorded only for your logged in users', 'wdpv' ); ?></span>
</p>
<br/>
<p><?php _e( 'Hide from sitewide activity stream:', 'wdpv' ); ?></p>
<p>
	<label for="bp_publish_activity_local-yes">
		<input type="radio" name="wdpv[bp_publish_activity_local]" id="bp_publish_activity_local-yes" value="1" <?php checked( $publish_activity_local ); ?>>
		<?php _e( 'Yes', 'wdpv' ); ?>
	</label>
	&nbsp;&nbsp;
	<label for="bp_publish_activity_local-no">
		<input type="radio" name="wdpv[bp_publish_activity_local]" id="bp_publish_activity_local-no" value="0" <?php checked( ! $publish_activity_local ); ?>>
		<?php _e( 'No', 'wdpv' ); ?>
	</label>
	<br/>
	<span class="description"><?php _e( 'Recorded activities will be hidden from your sitewide activity stream', 'wdpv' ); ?></span>
</p>
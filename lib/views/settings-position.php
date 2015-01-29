<label for="voting_position-top">
	<input type="radio" name="wdpv[voting_position]" id="voting_position-top" value="top"  <?php checked( $opt === 'top' ); ?>> 
	<?php _e( 'Before the post', 'wdpv' ); ?>
</label>
<br>

<label for="voting_position-bottom">
	<input type="radio" name="wdpv[voting_position]" id="voting_position-bottom" value="bottom" <?php checked( $opt === 'bottom' ); ?>> 
	<?php _e( 'After the post', 'wdpv' ); ?>
</label>
<br>

<label for="voting_position-both">
	<input type="radio" name="wdpv[voting_position]" id="voting_position-both" value="both" <?php checked( $opt === 'both' ); ?>> 
	<?php _e( 'Both before and after the post', 'wdpv' ); ?>
</label>
<br>

<label for="voting_position-manual">
	<input type="radio" name="wdpv[voting_position]" id="voting_position-manual" value="manual" <?php checked( $opt === 'manual' ); ?>> 
	<?php _e( 'Manually position the box using shortcode or widget', 'wdpv' ); ?>
</label>
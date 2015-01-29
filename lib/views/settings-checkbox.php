<label for="<?php echo esc_attr( $slug ); ?>-yes">
	<input type="radio" name="wdpv[<?php echo esc_attr( $slug ); ?>]" id="<?php echo esc_attr( $slug ); ?>-yes" value="1" <?php checked( $checked ); ?>>
	<?php _e( 'Yes', 'wdpv' ); ?>
</label>
<br/>
<label for="<?php echo esc_attr( $slug ); ?>-no">
	<input type="radio" name="wdpv[<?php echo esc_attr( $slug ); ?>]" id="<?php echo esc_attr( $slug ); ?>-no" value="0" <?php checked( ! $checked ); ?>>
	<?php _e( 'No', 'wdpv' ); ?>
</label>

<?php if ( ! empty( $description ) ): ?>
	<?php echo $description; ?>
<?php endif; ?>

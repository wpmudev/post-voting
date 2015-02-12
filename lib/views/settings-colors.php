<input type="text" name="wdpv[color_down]" value="<?php echo $color_down; ?>" data-type="down" class="color-field" />
<input type="text" name="wdpv[color_up]" value="<?php echo $color_up; ?>" data-type="up" class="color-field" />

<script>
	jQuery(document).ready(function($) {
		$( '.color-field' ).wpColorPicker({
			change: function( event, ui ) {
				var type = $(event.target).data('type');
				$( 'i.' + type ).css( 'color', ui.color.toString() );			
				
			}
		});
	});
</script>
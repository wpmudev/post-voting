<?php foreach ( $skins as $skin => $label ): ?>
	
	<label class="wdpv-voting-appereance-label" for="voting_appearance-<?php echo esc_attr( $skin ); ?>">
		<input type="radio" name='wdpv[voting_appearance]' id="voting_appearance-<?php echo esc_attr( $skin ); ?>" value="<?php echo esc_attr( $skin ); ?>" <?php checked( $opt['voting_appearance'] == $skin ); ?> />
		<div><?php echo $label; ?> <i class="<?php echo esc_attr( $skin ); ?> up"></i> <i class="<?php echo esc_attr( $skin ); ?> down"></i></div>
	</label>

<?php endforeach; ?>

<style>
	.wdpv-voting-appereance-label {
		display:block;
		margin-bottom:10px;
	}
	.wdpv-voting-appereance-label>div {
		border:1px solid #999;
		padding:3px 5px;
		display:inline-block;
		border-radius: 3px;
		width:15%;
	}
	.wdpv-voting-appereance-label i {
		float:right;
	}
	.wdpv-voting-appereance-label:last-child {
		margin-bottom:0;
	}

	.wdpv-voting-appereance-label i:after {
		font-family: 'icomoon';
		speak: none;
		font-style: normal;
		font-weight: normal;
		font-variant: normal;
		text-transform: none;
		line-height: 1;
		font-size:16px;

		/* Better Font Rendering =========== */
		-webkit-font-smoothing: antialiased;
		-moz-osx-font-smoothing: grayscale;

		padding-left:5px;
	}
	.wdpv-voting-appereance-label i.icomoon.up:after {
		content: "\f164";
	}
	.wdpv-voting-appereance-label i.icomoon.down:after {
		content: "\f165";
	}
	.wdpv-voting-appereance-label i.arrows.up:after {
		content: "\ea32";
	}
	.wdpv-voting-appereance-label i.arrows.down:after {
		content: "\ea36";
	}
	.wdpv-voting-appereance-label i.plusminus.up:after {
		content: "\ea0a";
	}
	.wdpv-voting-appereance-label i.plusminus.down:after {
		content: "\ea0b";
	}
	.wdpv-voting-appereance-label i.whitearrow.up:after {
		content: "\ea41";
	}
	.wdpv-voting-appereance-label i.whitearrow.down:after {
		content: "\ea43";
	}
	.wdpv-voting-appereance-label i.qa.up:after {
		content: "\e601";
	}
	.wdpv-voting-appereance-label i.qa.down:after {
		content: "\e600";
	}

	.wdpv-voting-appereance-label i.up {
		color:<?php echo $opt['color_up']; ?>
	}
	.wdpv-voting-appereance-label i.down {
		color:<?php echo $opt['color_down']; ?>
	}


</style>
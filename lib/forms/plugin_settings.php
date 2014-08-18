<div class="wrap">
	<?php include_once( WDPV_PLUGIN_BASE_DIR . '/lib/forms/plugin_tabs.php'); ?>

<?php if ( is_network_admin() ) { ?>
	<form action="settings.php" method="post">
<?php } else { ?>
	<form action="options.php" method="post">
<?php } ?>

	<?php settings_fields('wdpv'); ?>
	<?php do_settings_sections('wdpv_options_page'); ?>
	<p class="submit">
		<?php submit_button(); ?>
	</p>
	</form>


<style type="text/css">
dl.item {
	margin-bottom: 2em;
}
dt.tag {
	font-weight: bold;
}
dt.attributes, dt.examples {
	font-style: italic;
}
dd.notes {
	font-style: italic;
	color: #666;
}
</style>

</div>
<h2 class="nav-tab-wrapper">
	<?php foreach ( $this->tabs as $key => $name ): ?>
		<a href="?page=wdpv&tab=<?php echo $key; ?>" class="nav-tab <?php echo $tab == $key ? 'nav-tab-active' : ''; ?>"><?php echo $name; ?></a>
	<?php endforeach; ?>
</h2>
<table class="wp-list-table widefat wdpv-plugins">
	<thead>
		<tr>
			<th scope="col" width="30%" class="manage-column"><?php _e('Add-on name', 'wdpv' ); ?></th>
			<th><?php _e( 'Add-on description', 'wdpv' ); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<th scope="col" width="30%" class="manage-column"><?php _e( 'Add-on name', 'wdpv' ); ?></th>
			<th><?php _e( 'Add-on description', 'wdpv' ); ?></th>
		</tr>
	</tfoot>
	<tbody>
		<?php foreach ( $all as $plugin ): ?>
			<?php 
				$plugin_data = Wdpv_PluginsHandler::get_plugin_info( $plugin ); 
				if ( empty( $plugin_data['Name'] ) ) 
					continue; // Require the name

				$activate_url = add_query_arg( 
					array( 
						'wdpv_activate_plugin' => 'true',
						'plugin_id' => $plugin
					)
				);
				$activate_url = wp_nonce_url( $activate_url, 'activate-plugin' );

				$deactivate_url = add_query_arg( 
					array( 
						'wdpv_deactivate_plugin' => 'true',
						'plugin_id' => $plugin
					)
				);
				$deactivate_url = wp_nonce_url( $deactivate_url, 'deactivate-plugin' );
				$is_active = in_array($plugin, $active);
			?>
			<tr>
				<td class="plugin-title">
					<strong><?php echo esc_html( $plugin_data['Name'] ); ?></strong>
					<div class="row-actions visible">
						<?php if ( ! $is_active ): ?>
							<span class="activate"><a href="<?php echo esc_url( $activate_url ); ?>" title="<?php esc_attr_e( 'Activate this Add-on', 'wdpv' ); ?>"><?php _e( 'Activate', 'wdpv' ); ?></a></span>
						<?php else: ?>
							<span class="activate"><a href="<?php echo esc_url( $deactivate_url ); ?>" title="<?php esc_attr_e( 'Dectivate this Add-on', 'wdpv' ); ?>"><?php _e( 'Dectivate', 'wdpv' ); ?></a></span>
						<?php endif; ?>
					</div>
				</td>
				
				<td>
					<div class="plugin-description">
						<p><?php echo $plugin_data['Description']; ?></p>
						<div class="inactive second plugin-version-author-uri">
							<?php printf( __( 'Version %s', 'wdpv' ), $plugin_data['Version'] ); ?>
							 | 
							<a href="<?php echo esc_url( $plugin_data['PluginURI'] ); ?>"><?php echo $plugin_data['Author']; ?></a>

						</div>
					</div>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<style>
	.wdpv-plugins th {
		padding:8px 10px;
	}
</style>
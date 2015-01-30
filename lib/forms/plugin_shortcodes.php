<?php include_once( WDPV_PLUGIN_BASE_DIR . '/lib/forms/plugin_tabs.php'); ?>

<p><?php _e( 'Regardless of your <em>Voting box position settings</em>, you can always use the shortcodes to insert post voting in your content (as long as you have post voting allowed, obviously).', 'wdpv' ); ?></p>

<p><?php _e( 'There are several shortcodes that offer a fine-grained control over what is displayed.', 'wdpv' ); ?></p>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>[wdpv_vote]</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt> <dd><?php _ex( 'none', 'Attributes (none)', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This is the main voting shortcode. It will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>[wdpv_vote]</code> - <?php _e( 'will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, only the results will be displayed.', 'wdpv' ); ?></dd>
</dl>

<p><?php _e( 'If you wish to customize the gadget appearance, you may want to use one or more of the other shortcodes listed below.', 'wdpv' ); ?></p>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>[wdpv_vote_up]</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt> <dd><?php _ex( 'none', 'Attributes (none)', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the "Vote up" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>[wdpv_vote_up]</code> - <?php _e( 'will display just the "Vote up" link.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be displayed.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>[wdpv_vote_down]</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt> <dd><?php _ex( 'none', 'Attributes (none)', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the "Vote down" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Example', 'wdpv' ); ?>:</dt>
			<dd><code>[wdpv_vote_down]</code> - <?php _e( 'will display just the "Vote down" link.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be displayed.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>[wdpv_vote_result]</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt> <dd><?php _ex( 'none', 'Attributes (none)', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the voting results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>[wdpv_vote_result]</code> - <?php _e( 'will display just the voting results.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be displayed even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>[wdpv_popular]</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>
				<dl>
					<dt><code>limit</code></dt>
					<dd><?php _e( '<em>(optional)</em> Show only this many posts. Defaults to 5', 'wdpv' ); ?></dd>
					<dt><code>network</code></dt>
					<dd><?php printf( __( '<em>(optional)</em> Show posts from entire network. Set to %s if you wish to display posts from entire network.', 'wdpv' ), '<code>yes</code>' ); ?></dd>
				</dl>
			</dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display the list of posts with highest number of votes.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>[wdpv_popular]</code> - <?php _e( 'will display 5 highest rated posts on the current blog.', 'wdpv' ); ?></dd>
			<dd><code>[wdpv_popular limit="3"]</code> - <?php _e( 'will display 3 highest rated posts on the current blog.', 'wdpv' ); ?></dd>
			<dd><code>[wdpv_popular network="yes"]</code> - <?php _e( 'will display 5 highest rated posts on entire network.', 'wdpv' ); ?></dd>
			<dd><code>[wdpv_popular limit="10" network="yes"]</code> - <?php _e( 'will display 10 highest rated posts on entire network.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> popular posts will be displayed even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>


<h3><?php _e( 'Template tags', 'wdpv' ); ?></h3>

<p><?php _e( 'Template tags can be used in your themes within The Loop, regardless of your <em>Voting box position settings</em>', 'wdpv' ); ?>.</p>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_vote()</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd><?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This is the main voting template tag. It will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_vote(); ?&gt;</code> - <?php _e( 'will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_vote(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, only the results will be displayed.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_vote_up()</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd><?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the "Vote up" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_vote_up(); ?&gt;</code> - <?php _e( 'will display just the "Vote up" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_vote_up(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be displayed.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_vote_down()</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd><?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the "Vote down" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_vote_down(); ?&gt;</code> - <?php _e( 'will display just the "Vote down" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_vote_down(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be displayed.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_vote_result()</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd><?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display just the voting results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_vote_result(); ?&gt;</code> - <?php _e( 'will display just the voting results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_vote_result(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be displayed even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_popular()</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>int <code>limit</code> - <?php _e( '<em>(optional)</em> Show only this many posts. Defaults to 5', 'wdpv' ); ?></dd>
			<dd>bool <code>network</code> - <?php _e( '<em>(optional)</em> Show posts from entire network. Set to <code>true</code> if you wish to display posts from entire network.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will display the list of posts with highest number of votes.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_popular(); ?&gt;</code> - <?php _e( 'will display 5 highest rated posts on the current blog.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_popular(3); ?&gt;</code> - <?php _e( 'will display 3 highest rated posts on the current blog.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_popular(5, true); ?&gt;</code> - <?php _e( 'will display 5 highest rated posts on entire network.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_popular(10, true); ?&gt;</code> - <?php _e( 'will display 10 highest rated posts on entire network.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> popular posts will be displayed even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>


<h3><?php _e( 'Custom post variations', 'wdpv' ); ?></h3>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote($standalone, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This is the main voting template tag. It will <em>return</em> all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote(); ?&gt;</code> - <?php _e( 'will <em>return</em> all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote(true, 12); ?&gt;</code> - <?php _e( 'will return all parts of voting gadget for your post with ID of 12.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, only the results will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_up($standalone, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will <em>return</em> just the "Vote up" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_up(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the "Vote up" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_up(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_up(true, 12); ?&gt;</code> - <?php _e( 'will return "Vote up" link for your post with ID of 12.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_down($standalone, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will <em>return</em> just the "Vote down" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_down(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the "Vote down" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_down(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_down(true, 12); ?&gt;</code> - <?php _e( 'will return "Vote down" link for your post with ID of 12.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_result($standalone, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will <em>return</em> just the voting results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_result(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the voting results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_result(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_result(true, 12); ?&gt;</code> - <?php _e( 'will return voting results for your post with ID of 12.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be returned even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>


<h3><?php _e( 'Multisite variations', 'wdpv' ); ?></h3>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_ms($standalone, $blog_id, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>blog_id</code> - <?php _e( 'Your blog ID', 'wdpv' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This is the main voting template tag. It will <em>return</em> all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_ms(); ?&gt;</code> - <?php _e( 'will <em>return</em> all parts of voting gadget - "Vote up" link, "Vote down" link and results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_ms(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_ms(true, 4, 12); ?&gt;</code> - <?php _e( 'will return all parts of voting gadget for your post with ID of 12 from the blog on your network with ID of 4.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, only the results will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_up_ms($standalone, $blog_id, $post_id)</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
			<dd>int <code>blog_id</code> - <?php _e( 'Your blog ID', 'wdpv' ); ?></dd>
			<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will <em>return</em> just the "Vote up" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_up(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the "Vote up" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_up(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_up(true, 4, 12); ?&gt;</code> - <?php _e( 'will return "Vote up" link for your post with ID of 12 from the blog on your network with ID of 4.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_down_ms($standalone, $blog_id, $post_id)</code></dt>
	<dd>
			<dl>
				<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
				<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
				<dd>int <code>blog_id</code> - <?php _e( 'Your blog ID', 'wdpv' ); ?></dd>
				<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
			</dl>
		</dd>
	<dd><?php _e( 'This will <em>return</em> just the "Vote down" link.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_down(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the "Vote down" link.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_down(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_down(true, 4, 12); ?&gt;</code> - <?php _e( 'will return "Vote down" link for your post with ID of 12 from the blog on your network with ID of 4.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> if you don\'t allow voting, nothing will be returned.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_vote_result_ms($standalone, $blog_id, $post_id)</code></dt>
	<dd>
			<dl>
				<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
				<dd>bool <code>standalone</code> - <?php printf( __( 'Clear the floats, %s or %s. Defaults to %s', 'wdpv' ), '<code>true</code>', '<code>false</code>', '<code>true</code>' ); ?></dd>
				<dd>int <code>blog_id</code> - <?php _e( 'Your blog ID', 'wdpv' ); ?></dd>
				<dd>int <code>post_id</code> - <?php _e( 'Your post ID', 'wdpv' ); ?></dd>
			</dl>
		</dd>
	<dd><?php _e( 'This will <em>return</em> just the voting results.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_vote_result(); ?&gt;</code> - <?php _e( 'will <em>return</em> just the voting results.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_result(false); ?&gt;</code> - <?php _e( 'same as above, without clearing the floats.', 'wdpv' ); ?></dd>
			<dd><code>&lt;?php wdpv_get_vote_result(true, 4, 12); ?&gt;</code> - <?php _e( 'will return voting results for your post with ID of 12 from the blog on your network with ID of 4.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be returned even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>


<h3><?php _e( 'Period-sensitive Variations', 'wdpv' ); ?></h3>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_get_popular_within($timespan, $limit=5)</code></dt>
	<dd>
			<dl>
				<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
				<dd>string <code>timespan</code> - <?php _e( 'One of recognized timespans', 'wdpv' ); ?> - <code>this_week</code>, <code>last_week</code>, <code>this_month</code>, <code>last_month</code>, <code>last_year</code>, <code>this_year</code></dd>
				<dd>int <code>limit</code> - <?php _e( 'Limit the returned results to this many.', 'wdpv' ); ?></dd>
			</dl>
		</dd>
	<dd><?php _e( 'This will <em>return</em> just the voting results within the selected timespan.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_get_popular_within('this_week'); ?&gt;</code> - <?php _e( 'will <em>return</em> just the top 5 popular results this week.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be returned even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>
<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_popular_within($timespan, $limit=5)</code></dt>
	<dd>
			<dl>
				<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
				<dd>string <code>timespan</code> - <?php _e( 'One of recognized timespans', 'wdpv' ); ?> - <code>this_week</code>, <code>last_week</code>, <code>this_month</code>, <code>last_month</code>, <code>last_year</code>, <code>this_year</code></dd>
				<dd>int <code>limit</code> - <?php _e( 'Limit the returned results to this many.', 'wdpv' ); ?></dd>
			</dl>
		</dd>
	<dd><?php _e( 'This will <em>output</em> the voting results within the selected timespan.', 'wdpv' ); ?></dd>
	<dd>
		<dl>
			<dt class="examples"><?php _e( 'Examples', 'wdpv' ); ?>:</dt>
			<dd><code>&lt;?php wdpv_popular_within('this_week'); ?&gt;</code> - <?php _e( 'will <em>output</em> just the top 5 popular results this week.', 'wdpv' ); ?></dd>
		</dl>
	</dd>
</dl>

<h3><?php _e( 'Advanced', 'wdpv' ); ?></h3>

<dl class="item">
	<dt class="tag"><?php _ex( 'Tag', 'Shortcode title', 'wdpv' ); ?>: <code>wdpv_query_within($timespan, $limit=5, $query=array())</code></dt>
	<dd>
		<dl>
			<dt class="attributes"><?php _e( 'Attributes', 'wdpv' ); ?>:</dt>
			<dd>string <code>timespan</code> - <?php _e( 'One of recognized timespans', 'wdpv' ); ?> - <code>this_week</code>, <code>last_week</code>, <code>this_month</code>, <code>last_month</code>, <code>last_year</code>, <code>this_year</code></dd>
			<dd>int <code>limit</code> - <?php _e( 'Limit the returned results to this many.', 'wdpv' ); ?></dd>
			<dd>array <code>query</code> - <?php printf( __( 'Additional %s arguments.', 'wdpv' ), '<code>WP_Query</code>' ); ?></dd>
		</dl>
	</dd>
	<dd><?php _e( 'This will spawn and <em>return</em> a <code>WP_Query</code> instance populated with the popular posts for a given timespan.', 'wdpv' ); ?></dd>
	<dd><?php _e( 'You can then use the returned result to construct custom loops within your theme.', 'wdpv' ); ?></dd>
	<dd class="notes"><?php _e( '<strong>Note:</strong> results will be returned even if you don\'t allow voting.', 'wdpv' ); ?></dd>
</dl>

</div>
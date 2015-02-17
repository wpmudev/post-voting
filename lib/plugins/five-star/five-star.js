jQuery(document).ready(function($) {
	var wpmudev_post_voting = {
		is_voting: false,
		init: function() {
			$('.wdpv_star').on( 'click', this.vote );	
		},
		vote: function( event ) {
			if ( wpmudev_post_voting.is_voting )
				return;

			var $this = $(this);

			wpmudev_post_voting.is_voting = true;
			var rating = $this.data('rating' );

			var vote = rating > 2 ? '+1' : '-1';

			for ( var i = 1; i <= rating; i++ ) {
				$this.closest( '.wdpv_star_' + i ).addClass( 'wdpv_star_selected' );
				$this.siblings( '.wdpv_star_' + i ).addClass( 'wdpv_star_selected' );
			}

			wpmudev_post_voting.is_voting = false;

			$.ajax({
				url: wdpv_i18n.ajaxurl,
				type: 'post',
				data: { 
					"action": "wdpv_record_vote", 
					"wdpv_vote": vote, 
					"blog_id": $this.data( 'blog-id' ), 
					"post_id": $this.data( 'post-id' ), 
					'security': $this.data( 'nonce' ) 
				},
			})
			.done(function(resp) {
				console.log(resp);
			})
			.fail(function(error) {
				//console.log(error);
			})
			.always(function(result) {
				wpmudev_post_voting.is_voting = false;
			});
		}
	}

	wpmudev_post_voting.init();
});
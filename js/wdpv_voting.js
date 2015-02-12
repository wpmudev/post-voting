jQuery(document).ready(function($) {
	var wpmudev_post_voting = {
		is_voting: false,
		init: function() {
			$('.wdpv_vote_up').on( 'click', { type:'up' }, this.vote );
			$('.wdpv_vote_down').on( 'click', { type:'down' }, this.vote );
		},
		vote: function( event ) {
			if ( wpmudev_post_voting.is_voting )
				return;

			wpmudev_post_voting.is_voting = true;

			var element = $(this);	

			if ( element.hasClass( 'wdpv-disabled' ) )
				return;

			var resultContainer = element.siblings('.wdpv_vote_result' ).first();
			var results = resultContainer.find('.wdpv_vote_result_output');
			var spinner = resultContainer.find('.wdpv-spinner');
			if ( results ) {
				results.css( 'display', 'none' );
				spinner.css( 'display', 'inline-block' );
			}

			var all_elements = element.siblings('.wdpv_vote_result, .wdpv_vote_up, .wdpv_vote_down').addClass( 'wdpv-disabled' );
			element.addClass( 'wdpv-disabled' );

			var vote = event.data.type === 'up' ? '+1' : '-1';

			$.ajax({
				url: wdpv_i18n.ajaxurl,
				type: 'post',
				data: { "action": "wdpv_record_vote", "wdpv_vote": vote, "blog_id": element.data( 'blog-id' ), "post_id": element.data( 'post-id' ) },
			})
			.done(function(resp) {
				if ( resp.votes !== false )
					results.text( resp.votes );
			})
			.fail(function(error) {
				//console.log(error);
			})
			.always(function(result) {
				wpmudev_post_voting.is_voting = false;
				results.css( 'display', 'inline' );
				spinner.css( 'display', 'none' );
			});
			
		},
	};

	wpmudev_post_voting.init();
});
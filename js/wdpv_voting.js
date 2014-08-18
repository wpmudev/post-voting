(function ($) {

function getPostId ($el) {
	return parseInt($el.find('input:hidden:not(.wdpv_blog_id)').val(), 10);
}
function getBlogId ($el) {
	return parseInt($el.find('input:hidden.wdpv_blog_id').val(), 10);
}

function updateResultBoxes (bid, pid) {
	$.post(_wdpv_ajax_url, {"action": "wdpv_vote_results", "blog_id": bid, "post_id": pid}, function (result) {
		$('.wdpv_vote_result').each(function () {
			var $me = $(this),
				mpid = getPostId($me),
				mbid = getBlogId($me)
			;
			if (pid == mpid && bid == mbid) { // If we have what we need, use that 
				$me.find('.wdpv_vote_result_output')
					.html(result.data)
					.removeClass('wdpv_waiting')
				;
			}
			// If we got here, we're on multiple posts page. Request update.
			$.post(_wdpv_ajax_url, {"action": "wdpv_vote_results", "blog_id": mbid, "post_id": mpid}, function (result) {
				$me.find('.wdpv_vote_result_output')
					.html(result.data)
					.removeClass('wdpv_waiting')
				;
			});
		});
	});
}

function doVote ($me, vote) {
	var pid = getPostId($me),
		blog_id = getBlogId($me),
		oldBg = $me.css('background-image')
	;

	// Disable all voting buttons for this post
	$('.wdpv_vote_up, .wdpv_vote_down').each(function () {
		var $obj = $(this);
		if (getPostId($obj) == pid && getBlogId($obj) == blog_id) {
			$obj
				.unbind('click')
				.addClass('wdpv_disabled')
			;
		}
	});

	// Show loader on all result containers while we load the response
	$('.wdpv_vote_result').each(function () {
		var $me = $(this),
			mpid = getPostId($me),
			mbid = getBlogId($me)
		;
		if (pid == mpid && blog_id == mbid) { // If we have what we need, use that 
			$me.find('.wdpv_vote_result_output')
				.empty()
				.addClass('wdpv_waiting')
			;
		}
	});

	var data = {"action": "wdpv_record_vote", "wdpv_vote": vote, "blog_id": blog_id, "post_id": pid};

	$.ajax({
		url: _wdpv_ajax_url,
		type: 'post',
		data: data,
	})
	.done(function(resp) {
		$(document).trigger('wdpv-voting-vote_complete', [blog_id, pid, vote]);
		updateResultBoxes(blog_id, pid);
	})
	.fail(function(error) {
		console.log(error);
	})
	.always(function() {
	});
	
}

function voteUp () {
    if( !$(this).hasClass("wdpv_disabled") ){
        doVote($(this), "+1");
    }
	return false;
}
function voteDown () {
    if( !$(this).hasClass("wdpv_disabled") ) {
        doVote($(this), "-1");
    }
	return false;
}


$(function () {

$(document).on("click", '.wdpv_vote_up', voteUp);
$(document).on("click", '.wdpv_vote_down', voteDown);

/* ----- Rating ----- */

var _old_class = false;
$(".wdpv_rating:not(.wdpv_static)")
	.mouseover(function () {
		var $me = $(this);
		_old_class = $me.attr('class').match(/\bwdpv_\d\d?_offset\b/);
		$me.attr('class', $me.attr('class').replace(/\bwdpv_\d\d?_offset\b/, ''));
	})
	.mousemove(function (e) {
		if (!_old_class) return;
		var $me = $(this),
			cls = $me.attr('class').replace(/\bwdpv_\d\d?_offset\b/, '')
		;

		var elpos = $me.offset(),
			mouse = e.pageX - elpos.left,
			offset = parseInt((mouse / $me.width() + 0.2) * 5, 10) * 10
		;
		$me.attr('class', cls + ' ' + 'wdpv_' + offset + '_offset');
	})
	.click(function (e) {
		if (!_old_class) return;
		var $me = $(this),
			elpos = $me.offset(),
			mouse = e.pageX - elpos.left,
			offset = parseInt((mouse / $me.width() + 0.2) * 5, 10)
		;
		doVote($me, offset);
		$me
			.trigger('mouseout')
			.unbind('click')
			.unbind('mousemove')
			.unbind('mouseover')
			.unbind('mouseout')
		;
	})
	.mouseout(function () {
		var $me = $(this);
		$me.attr('class', $me.attr('class').replace(/\bwdpv_\d\d?_offset\b/, ''));
		var cls = $me.attr('class');
		$me.attr('class', cls + ' ' + _old_class);
		_old_class = false;
	})
;

$(document).bind('wdpv-voting-vote_complete', function (e, blog_id, pid) {
	$.post(_wdpv_ajax_url, {"action": "wdpv_rating_results", "blog_id": blog_id, "post_id": pid}, function (result) {
		blog_id = isNaN(blog_id) ? 0 : blog_id;
		$(".wdpv_rating:not(.wdpv_personal_rating)").each(function () {
			var $me = $(this),
				mpid = getPostId($me),
				mbid = getBlogId($me)
			;
			mbid = isNaN(mbid) ? 0 : mbid;
			if (pid == mpid && blog_id == mbid) { // If we have what we need, use that 
				$me.attr('class', $me.attr('class').replace(/\bwdpv_\d\d?_offset\b/, ''));
				var cls = $me.attr('class');
				$me.attr('class', cls + ' ' + 'wdpv_' + result.data + '_offset');
			}
		});
	});
	$.post(_wdpv_ajax_url, {"action": "wdpv_personal_rating_results", "blog_id": blog_id, "post_id": pid}, function (result) {
		blog_id = isNaN(blog_id) ? 0 : blog_id;
		$(".wdpv_rating.wdpv_personal_rating").each(function () {
			var $me = $(this),
				mpid = getPostId($me),
				mbid = getBlogId($me)
			;
			mbid = isNaN(mbid) ? 0 : mbid;
			if (pid == mpid && blog_id == mbid) { // If we have what we need, use that 
				$me.attr('class', $me.attr('class').replace(/\bwdpv_\d\d?_offset\b/, ''));
				var cls = $me.attr('class');
				$me.attr('class', cls + ' ' + 'wdpv_' + result.data + '_offset');
			}
		});
	});
});

});
})(jQuery);
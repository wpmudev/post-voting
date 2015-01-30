( function () {
	tinymce.PluginManager.add( 'wdpv_shortcodes', function ( editor ) {
		var ed = tinymce.activeEditor;

		var wdpv_menu = [
			{
				text: ed.getLang( 'wdpv_shortcodes.vote_boxes_menu_title' ),
				menu: [
					{
						text: ed.getLang( 'wdpv_shortcodes.vote_box_menu_title' ),
						onclick: function () {
							editor.insertContent( '[wdpv_vote]' );
						}
					},
					{
						text: ed.getLang( 'wdpv_shortcodes.vote_up_box_menu_title' ),
						onclick: function () {
							editor.insertContent( '[wdpv_vote_up]' );
						}
					},
					{
						text: ed.getLang( 'wdpv_shortcodes.vote_down_box_menu_title' ),
						onclick: function () {
							editor.insertContent( '[wdpv_vote_down]' );
						}
					},
					{
						text: ed.getLang( 'wdpv_shortcodes.vote_results_box_menu_title' ),
						onclick: function () {
							editor.insertContent( '[wdpv_vote_result]' );
						}
					}
				]
			},
			{
				text: ed.getLang( 'wdpv_shortcodes.vote_popular_box_menu_title' ),
				onclick: function () {
					editor.insertContent( '[wdpv_popular]' );
				}
			}
		];



		editor.addButton( 'wdpv_shortcodes', {
			text: ed.getLang( 'wdpv_shortcodes.shortcode_title' ),
			icon: 'mce-i-wdpv-vote',
			type: 'menubutton',
			menu: wdpv_menu			
		});
	});
})();
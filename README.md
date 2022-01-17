# Post Voting


**INACTIVE NOTICE: This plugin is unsupported by WPMUDEV, we've published it here for those technical types who might want to fork and maintain it for their needs.**

## Translations

Translation files can be found at https://github.com/wpmudev/translations

## About

Give users a way to throw your content a thumbs-up. Post Voting Plugin lets you track the content your users love...and hate.

![icon-vote-735x470](https://premium.wpmudev.org/wp-content/uploads/2011/05/icon-vote-735x470-583x373.jpg)

 Add Digg functionality to WordPress.

### One-Click Feedback

Capture user feedback by letting them cast a vote with a click. Use a simple thumbs up or down, +1 or 5 star rating system. Track site and network-wide voting from the included dashboard Voting Statistics screen.

 

### Voting with Style

Choose from 6 voting icon styles to perfectly fit the look and feel of your site. Automatically insert voting icons above or below your post or use shortcodes for custom integration.

![5-star-735x470](https://premium.wpmudev.org/wp-content/uploads/2011/05/5-star-735x470-583x373.jpg)

 Integrate a trackable 5 star rating system.

### Built For Multisite

Post Voting plugin is fully Multisite compatible including global vote sharing, the ability to share top-voted posts from across your network and network-wide stat tracking. 

![vote-post-type-735x470](https://premium.wpmudev.org/wp-content/uploads/2011/05/vote-post-type-735x470-583x373.jpg)

 Limit voting to the post types of your choice.

### Custom Fit

Post Voting Plugin looks amazing out-of-the-box with any well coded WordPress theme. Plus, our full shortcode library and 3 built-in widgets provide a simple way to create a completely custom look and feel.

## Usage

For help with installing plugins please see our [Plugin installation guide](https://wpmudev.com/docs/using-wordpress/installing-wordpress-plugins/)

Login to your admin panel for WordPress or Multisite and activate the plugin:

*   On regular WordPress installs – visit Plugins and Activate the plugin.
*   For WordPress Multisite installs – Activate it site-by-site (say if you wanted to make it a Pro Sites premium plugin), or visit Network Admin -> Plugins and Network Activate the plugin.

#### Getting Started

Once activated, you'll see a new menu item in your dashboard: _Settings > Post Voting_. 

![Post Voting Menu](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Menu.png)

 Let's get started by configuring the settings. Click to go to _Settings > Post Voting_. You'll see a couple of tabs at the top of the page, one for _Settings_ and one for _Shortcodes_.

##### Voting Settings

The default settings are the most commonly used and will suit most scenarios. We'll go through the options one by one to see what they do. 

![Post Voting - Settings](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Settings.png)

 The _Allow post voting_ option lets you enable or disable the plugin's features. Tick the _Allow voting for unregistered users_ option to allow logged out users (visitors) to vote. This can be very handy for engaging your site's visitors but could also possibly lead to less than optimal voting stats. The _Use IP check_ option is incredibly helpful when allowing visitors to vote, it will track votes by IP and disallow more than one vote per item from the same IP. Encourage signups using the _Show login link for visitors_ option. The _Do NOT show voting for these types_ option lets you choose which post types to not to show voting options on. If you have an e-commerce solution for example, you could allow voting on the Products post type but not on regular Posts. The _Voting box position_ option lets you choose where you want the voting options to appear. The available options are as follows:

*   Before the post
*   After the post
*   Both before and after the post
*   Manually position the box using shortcode or widget

Choose from a number of included voting images with the _Appearance_ option. You can choose to disable negative votes by ticking the _Prevent negative voting_ option. This can help to avoid abuse from users who might try and take advantage by down-voting others. The _Voting on Front Page_ option lets you show the voting options within each post on your blog front page. Otherwise, the plugin will just display the voting options within single post listings. When used in Multisite, the _Prevent Site Admins from making changes?_ option will be present which lets you limit the options to the Network Admin page. Site Admins wouldn't be able to change these options.

##### Add-ons

Just below all the general settings is an Add-ons sub-section where you'll find some nifty add-ons that you can activate/deactivate to extend the plugin's features. The add-ons currently included with the plugin are as follows:

Allow daily voting

Activate this add-on to allow your visitors to vote once a day, instead of voting once for all.

Five-star rating

Activating this add-on will convert up/down voting into 5-star rating system.

You can simply click the _Activate_ or _Deactivate_ links under the add-on names. 

![Post Voting - Add-ons - Activate](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Add-ons-Activate.png)

 Be sure to click the _Save Changes_ button to save the settings once done. 

![Post Voting - Save Changes](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Save-Changes.png)

##### Shortcodes

Let's take a quick look at the _Shortcodes_ tab. Post Voting provides extensive shortcodes and template tags to help you use and integrate it with your site. Here you'll find detailed instructions on how to use them. 

![Post Voting - Shortcodes](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Shortcodes.png)

 The following shortcodes can be used in any post, page or text widget:

*   _[wdpv_vote_ - will display all parts of voting gadget - "Vote up" link, "Vote down" link and results.
*   _[wdpv_vote_up]_ - will display just the "Vote up" link.
*   _[wpdpv_vote_down]_ - will display just the "Vote down" link.
*   _[wpdpv_vote_result]_ - will display just the voting results.

You can include the _post_id_ parameter in the above shortcodes if you want to display the voting widget for a particular post. For example, to prompt your users to vote for a post with an ID of 25, simply add a text widget to your sidebar with this in it:

Vote for this post!
[wdpv_vote post_id="25"]

The following shortcode can also be used to display a list of posts with highest number of votes. _[wdpv_popular]_ There are 2 parameters that can used with this one: _limit_ and _network_. For example:

*   _[wpdpv_popular]_ - will display the 5 highest rated posts on the current blog.
*   _[wpdpv_popular limit="3"]_ - will display the 3 highest rated posts on the current blog.
*   _[wpdpv_popular network="yes"]_ - will display the 5 highest rated posts on the entire network.
*   _[wpdpv_popular limit="10" network="yes"]_ - will display the 10 highest rated posts on the entire network.

There are a number of template tags detailed in the Shortcodes tab as well. These provide an easy way to integrate the plugin with your theme, especially great for theme developers or those looking for extensive customization features.

##### Let the users vote!

Here are a few examples of how users will see the voting options in the front end. 

![Post Voting - Example](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Example.png)

 Example of default voting options with Twenty Twelve theme

 

![Post Voting - Example - Star Rating](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Example-Star-Rating.png)

 Example of voting options when using Star Rating add-on in Twenty Fourteen theme

##### Voting Stats

Voting Stats for all posts can be checked in **Dashboard > Voting Stats** in the site admin dashboard. 

![Post Voting - Voting Stats](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Voting-Stats.png)

##### Widgets

Post Voting also provides a number of widgets, these can be added via **Appearance > Widgets**. 

![Post Voting Widgets](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Widgets.png)

 1\. Top voted Posts on Network (for Multisite)  

2\. Top voted Posts  

3\. Voting Widget

 

![Post Voting - Top voted Posts Widget](https://premium.wpmudev.org/wp-content/uploads/2011/05/Post-Voting-Top-voted-Posts-Widget.png)

 Top voted Posts widget in front-end using Twenty Twelve theme

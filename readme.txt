=== WordPress Mailing List Builder ===
Contributors: msafi
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=7663346
Tags: mailing list, online marketing, getresponse, subscription form
Requires at least: 2.7
Tested up to: 2.8.4
Stable tag: 0.9.11

Build a huge list. This plugin allows you to effortlessly and rapidly build a segmented and targeted list of subscribers...AUTOMATICALLY!

== Description ==

> *Development and support for this plugin have been discontinued. For great alternatives, check out this guide on the best [WordPress mailing list subscription form plugin](http://winkpress.com/newsletter/subscribe/).*

Build a huge list. This plugin allows you to effortlessly and rapidly build a segmented and targeted list of subscribers. You need a [GetResponse account](http://msafi.com/a/mlb/) to use it, however.

#### Easy, Yet Extremely Targeted Subscription Forms

This plugin allows you to easily insert [GetResponse](http://msafi.com/a/mlb/) subscription forms into your WordPress content. You simply type in `[mlb /]`. But you can also specify a Call to Action by doing `[mlb]Subscribe to Receive More Cool Articles About This Topic[/mlb]`. You can see a [live example here](http://msafi.com/post/wordpress-mailing-list-builder/).

#### The Plugin Will Automatically Segment Your Subscribers for You

The plugin doesn't only allow you to easily capture subscribers on your blog. It also segments them for you. It inserts subscribers into your GetResponse account with additional information. It basically takes your WordPress Post tags and considers them "interest" for the subscribers. So, when you see your subscribers from your GetResponse control panel, you'll see that each subscriber has an "interest" field with a list of tags next to them. The tags will come from the post from which they subscribed. This helps you know which subscribers are interested in what, so that you can then [group them](http://faq.getresponse.com/questions/35/How+do+I+define+a+group+of+contacts%3F) in different ways to increase the quality of your list, newsletters and marketing.

#### And Perks

*Sidebar Widget*

If you'd like to have a subscription form in the sidebar as well, this plugin allows you to easily configure a sidebar subscription form independent of the form that appears within your content.

*Fully Ajaxed*

The form submission and validation is done completely through Ajax. That means, your visitor doesn't have to leave your page when they subscribe. They see a nice "Thank You" message and they continue on browsing your site.

*Custom Campaigns and Tracking Codes*

In your GetResponse account you may have several "campaigns". This plugin allows you to specify the campaign for each form, like `[mlb c="mycampaign"]Call to Action[/mlb]` or leave it off and a default campaign will be used.

Similarly, if you're used to inserting tracking codes with your subscription form, you can do `[mlb r="mysidebar"]Call to Action[/mlb]`

== Installation ==

Put the plugin zip file in the plugins folder of WordPress. Then, simply activate the plugin from WordPress's administration panel.

When you have the plugin successfully activated, you'll see a new menu on the left-hand side, "Mailing List...". Click on it, and enter your GetResponse API key. You must have at least one campaign in your GetResponse account.

Then, add a new post or page and type the `[mlb \]` tag within your post or page content and the form will simply appear where you typed the tag. 

#### Supported Tags (Aka Shortcodes)

To integrate with GetResponse and display your form properly, MLB requires that you have at least one default GetResponse campaign in your account. In addition to that, you also can specify a default call to action message and a tracking code. MLB uses this information everytime you insert the `[mlb /]` tag in your content. You have variety of options in these tags:

*Self Closing Tag, [mlb /]*

This is the quickest way to insert a form in your content. If you just put in `[mlb /]` and nothing else, MLB will use your default campaign, default call to action message, and default tracking code.

*Enclosing Tag, [mlb]Some Call to Action Line[/mlb]*

To specify a call to action message within your content, use the enclosing tags as shown above.

*Attributes*

Within the first tag, you can have one or the two attributes that MLB supports. The two attributes are c, for campaign, and r, for reference or tracking code. For example, you could do `[mlb c="my_second_campaign" /]` or `[mlb r="my_top_form"]Call to Action[/mlb]`. These attributes overwrite the defaults.

== Frequently Asked Questions ==

= Can I use a free GetResponse account with the plugin? =

To use the plugin, you need an API key from GetResponse. And an API key is only available to paid accounts.

= How can I find my GetResponse API key? =

Make sure that you are logged-in to your GetResponse account, then go to this page.

= Can I use this plugin with another email marketing provider, such as Aweber or iContact? =

Not yet. I may make plugins for those in the future...depending on how this one goes...

== Changelog ==

= 0.9.11 =
* Forgot to remove debugging lines from the JavaScript files. Now they're removed. 

= 0.9.1 =
* The plugin directory name was hardcoded, so scripts and styles failed to enqueue. This bug is fixed in this version.

= 0.9 =
* Initial release

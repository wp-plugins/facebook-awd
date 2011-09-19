=== Facebook AWD All in one ===
Contributors: AHWEBDEV 
Donate link: http://www.ahwebdev.fr/plugins/facebook-awd.html
Tags: facebook, oauth2, like button,opengraph, open graph, comments, connect, likebox, activity box, all in one, fb connect, fb comments, facebook comments
Requires at least: 3.1
Tested up to: 3.2.1
Stable tag: 0.9.7.7
Facebook AWD is an all in one Facebook capabilities for wordpress.
Add like button, like box, activity box, FB Comments, Open Graph and FB connect

== Description ==
Facebook AWD is an all in one Facebook capabilities for wordpress.  
Add Socials plugins, OpenGraph, Comments and FB connect.
Easy to install and setup. Use Iframe or Xfbml
Add Like button and comments to pages, posts and custom posts types, at top, bottom or both.
Widgets and Shortcodes available for each Facebook socials plugins.
Use post thumbnail for openGraph, Fix like button with url linter, use pattern to defined custom openGraph meta, etc...
Use both SDK's PHP v.3.1.1 AND JS v3

Warning: You should set that your app Facebook is migrated to OAuth2 in settings of your Facebook Appllication. (you should read FAQ)
 
= Socials plugins iframe or xfbml: =

*   [Like Button]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/utiliser-le-bouton-like.html")
*   Like Box
*   Activity Box
*   Login Button
*   Comments

= Langs: =

*   EN (en_US)
*   FR (fr_FR)

= OpenGraph protocol: =
Customise Open Graph Tags for each type of posts (custom post support), archives, categories and taxonomies, attachements  
You can redefine global settings for all posts or pages or custom post type

= FB connect: =
if FB connect enable, you can ask special permissions, and link Facebook user with your site.
When a user logging in to your site using Facebook, this plugin will auto register user. If user unregister from Facebook, his account will be not remove.
If you are a developer you can use the API of facebook and opengraph api directly from your themes and plugins. Simply use defined objects set by this plugin. (Javascript SDK AND PHP SDK) 

= Widget And Shortcodes: =
You can use widgets and shotcodes to display Facebook socials plugins

* [Like Button]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/utiliser-le-bouton-like.html") [AWD_likebutton]
* Like Box [AWD_likebox]
* Activity Box [AWD_activitybox]
* Login Button [AWD_loginbutton]

= Multisite compatible: =
This plugin is compatible with Wordpress multisite.

== Installation ==
Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.

Need PHP 5.*

== Frequently Asked Questions ==

[Create an Application on Facebook]("http://developers.facebook.com/apps/")

= My site is always reloading when i'am connected to facebook =
1. Verify that your are not using cache system
2. Your Facebook app must be migrated to Oauth2 in facebook settings
3. Clear all cookies and cache from your browser (to prevent old cookies formats.)
4. Desactivate each plugin one by one, and try more tests (sometimes, plugins create confilcts.) 

= I have a fatal error with CURL extension =
Facebook API cannot work without CURL php extension on your server.
You should install it.

= I have a fatal error with CURL extension =
Facebook API cannot work without CURL php extension on your server.
You should install it.

= I can't manage my fb:comments (moderator view) =
You should activate OpenGraph in settings, and set your facebook admin ID or Facebook app_id.

= How can i get my Facebook ID and My Facebook App Api info =
[Search here]("http://developers.facebook.com/apps/") 

= The like button does not work, i have javascript error =
You must set an locale option in settings, as "en_US" or "fr_FR" etc...

= Like box does not work =
Verify that url you enter is an url form a Facebook Page and not from a website.

= API Error Code: 191 =
This error come from facebook.
In your App settings, on facebook, you should go to the connect tab, and you should set an url, and a domain for the connect api.



= The plugin is not working after update 0.9.7 =
Warning: You should set that your app Facebook is migrated to OAuth2 in settings of your Facebook Appllication. Because this plugin use the new version of the Facebook SDK.

= Shortcodes: =
`[AWD_likebutton]`

Options:

* url
* send
* width
* colorscheme
* faces
* fonts
* action
* layout
* height
* xfbml

`[AWD_likebox]`
Options:

* url
* width
* colorscheme
* faces
* height
* xfbml
* stream
* header

`[AWD_activitybox]`
Options:

* domain
* width
* colorscheme
* faces
* height
* xfbml
* fonts
* border_color
* header
* recommendations


`[AWD_loginbutton]`
Options:

* profile_picture
* width
* faces
* maxrow
* logout_value
* logout_url
* login_url

`[AWD_comments]`
Options:

* url
* nb
* width
* colorscheme

= API hook Actions: (doc soon) =
* AWD_facebook_plugins_init
* AWD_facebook_oauth
* AWD_facebook_plugins_menu
* AWD_facebook_plugins_form
* AWD_facebook_custom_metabox
* AWD_facebook_redirect_login
* AWD_facebook_js_not_authorized
* AWD_facebook_js_authorized
* AWD_facebook_get_admin_fbuid

= API hook Filters: (doc soon) =
* AWD_facebook_options
* AWD_facebook_og_tags
* AWD_facebook_og_types
* AWD_facebook_og_attachement_field

== Screenshots ==
1. Plugin Facebook AWD settings General tab
2. Plugins Facebook settings General tab
3. Open Graph settings General tab
4. Open Graph settings General tab detailed
5. Open Graph settings on each post or page or custom post type
6. Widget Login button / profile
7. Widget Like button
8. Widget Like box
9. Widget Activity box

== Changelog ==
= 0.9.6 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-6.html")
= 0.9.7 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7.html")
= 0.9.7.3 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7-3.html")
Special update API Facebook PHP and JS to V3.1.1
= 0.9.7.4 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7-4.html")
= 0.9.7.5 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7-5.html")
= 0.9.7.6 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7-6.html")
= 0.9.7.7 =
[view changes]("http://www.ahwebdev.fr/plugins/documentation/facebook-awd/change-log/version-0-9-7-7.html")
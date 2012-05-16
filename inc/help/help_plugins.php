<?php
/*
*
* Help Plugins Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
?>
<div id="header_AWD_lightbox" class="hidden">
	<div class="header_lightbox_help">
		<div class="header_lightbox_help_text"><img style="vertical-align:middle;" src="<?php echo $this->plugin_url_images; ?>facebook-mini.png" alt="facebook logo"/> <?php _e('Help',$this->plugin_text_domain); ?></div>
	</div>
</div>

<div id="lightbox_help_like_button_url" class="hidden">
	<p><?php
	_e("The url to like, in XFBML, defaults to the current page",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_fbml" class="hidden">
	<p><?php
	_e("The XFBML is available only on sites that use the JavaScript SDK.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_send" class="hidden">
	<p><?php
	_e("Include a Send button. The Send Button is available only on sites that use the JavaScript SDK.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_layout" class="hidden">
	<p><?php
	_e("Determines the size and amount of social context next to the button.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_width" class="hidden">
	<p><?php
	_e("The width of the plugin, in pixels.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_height" class="hidden">
	<p><?php
	_e("The height of the plugin, in pixels.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_faces" class="hidden">
	<p><?php
	_e("Show profile pictures below the button.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_action" class="hidden">
	<p><?php
	_e("The verb to display in the button. Currently only 'like' and 'recommend' are supported.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_colorscheme" class="hidden">
	<p><?php
	_e("The color scheme of the plugin",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_font" class="hidden">
	<p><?php
	_e("The font of the plugin",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_button_font" class="hidden">
	<p><?php
	_e("The font of the plugin",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_domain" class="hidden">
	<p><?php
	_e("The domain to show activity for e.g. 'www.example.com'. In XFBML, defaults to the domain the plugin is on.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_show_header" class="hidden">
	<p><?php
	_e("Show the Facebook header on the plugin.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_type" class="hidden">
	<p><?php
	_e("The type of button, xfbml,html5 or iframe",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_max_age" class="hidden">
	<p><?php
	_e("The maximum age of a URL to show in the plugin. The default is 0 (we don’t take age into account). Otherwise the valid values are 1-180, which specifies the number of days. For example, if you specify '7' the plugin will only show URLs which were created in the past week",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_linktarget" class="hidden">
	<p><?php
	_e("This specifies the context in which content links are opened. By default all links within the plugin will open a new window. If you want the content links to open in the same window, you can set this parameter to _top or _parent. Links to Facebook URLs will always open in a new window.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_filter" class="hidden">
	<p><?php
	_e("Allows you to filter which URLs are shown in the plugin. The plugin will only include URLs which contain the filter string in the first two path parameters of the URL. If nothing in the first two path parameters of the URL matches the filter, the URL will not be included. For example, if the 'site' parameter is set to 'www.example.com' and the 'filter' parameter was set to '/section1/section2' then only pages which matched 'http://www.example.com/section1/section2/*' would be included in the activity feed section of this plugin. The filter parameter does not apply to any recommendations which may appear in this plugin (see above); Recommendations are based only on 'site' parameter.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_ref" class="hidden">
	<p><?php
	_e("Must be a comma separated list, consisting of at most 5 distinct items, each of length at least 1 and at most 15 characters drawn from the set '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_'. Specifying a value for the ref attribute adds the 'fb_ref' parameter to the any links back to your site which are clicked from within the plugin. Using different values for the ref parameter for different positions and configurations of this plugin within your pages allows you to track which instances are performing the best",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_recommendation" class="hidden">
	<p><?php
	_e("Show recommendations.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_activity_border" class="hidden">
	<p><?php
	_e("The border color of the box. Use hexadecimal value ex: #ff0000 for red border",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_display_on_login_page" class="hidden">
	<p><?php
	_e("Will display the login button after the login form on WP login page",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_css" class="hidden">
	<p><?php
	_e("Add custom css for the login button.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_logout" class="hidden">
	<p><?php
	_e("The sentence in logout link",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_maxrow" class="hidden">
	<p><?php
	_e("The maximum number of rows of profile pictures to show.",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_faces" class="hidden">
	<p><?php
	_e("Show pictures of the user's friends who have joined your site",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_login_button_profile_picture" class="hidden">
	<p><?php
	_e("Show pictures of the user when connected",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_box_stream" class="hidden">
	<p><?php
	_e("Show the profile stream for the public profile",$this->plugin_text_domain); 
	?></p>
</div>
<div id="lightbox_help_like_box_type" class="hidden">
	<p><?php
	_e("The type of box, xfbml,html5 or iframe",$this->plugin_text_domain); 
	?></p>
</div>
<div id="lightbox_help_like_button_type" class="hidden">
	<p><?php
	_e("The type of button, xfbml,html5 or iframe",$this->plugin_text_domain); 
	?></p>
</div>
<div id="lightbox_help_like_box_force_wall" class="hidden">
	<p><?php
	_e("For Places, specifies whether the stream contains posts from the Place's wall or just checkins from friends. Default value: No",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_like_box_border" class="hidden">
	<p><?php
	_e("The border color of the box. Use hexadecimal value ex: #ff0000 for red border",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_comments_url" class="hidden">
	<p><?php
	_e("The default Url to comment on ex:http://www.ahwebdev.fr",$this->plugin_text_domain); 
	?></p>
</div>
<div id="lightbox_help_comments_nb" class="hidden">
	<p><?php
	_e("The number of comments to display",$this->plugin_text_domain); 
	?></p>
</div>
<div id="lightbox_help_comments_type" class="hidden">
	<p><?php
	_e("The type of box, xfbml or html5",$this->plugin_text_domain); 
	?></p>
</div>

<div id="lightbox_help_comments_type" class="hidden">
	<p><?php
	_e("Whether to show the mobile-optimized version. Default: auto-detect",$this->plugin_text_domain); 
	?></p>
</div>




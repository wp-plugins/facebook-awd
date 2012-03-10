<?php
/*
*
* Help settings Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
/**
* Help app id
*/
?>
<div id="header_AWD_lightbox" class="hidden">
	<div class="header_lightbox_help">
		<div class="header_lightbox_help_text"><img style="vertical-align:middle;" src="<?php echo $this->plugin_url_images; ?>facebook-mini.png" alt="facebook logo"/> <?php _e('Help',$this->plugin_text_domain); ?></div>
	</div>
</div>
<div id="lightbox_help_app_id" class="hidden">
	<p>
	<?php
	printf(__("This is the id of your application on Facebook, if you have not yet an application, you can create one %shere%s.",$this->plugin_text_domain),'<a href="https://www.facebook.com/developers/createapp.php" target="_blank">','</a>'); 
	?>
	</p>
</div>
<div id="lightbox_help_xfbml" class="hidden">
	<p>
	<?php
	printf(__("Use xfbml parsing, Visit %sthis page%s",$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/reference/fbml/" target="_blank">','</a>');
	
	?>
	<br /><i><?php _e('If you set this option to "No" you will never be able to use xfbml',$this->plugin_text_domain); ?></i>
	</p>
</div>

<div id="lightbox_help_open_graph" class="hidden">
	<p>
	<?php
	printf(__("The Open Graph Protocol enables you to integrate your Web pages into the social graph. It is currently designed for Web pages representing profiles of real-world things — things like movies, sports teams, celebrities, and restaurants. Including Open Graph tags on your Web page, makes your page equivalent to a Facebook Page. This means when a user clicks a Like button on your page, a connection is made between your page and the user. Your page will appear in the ”Likes and Interests” section of the user’s profile, and you have the ability to publish updates to the user. Your page will show up in the same places that Facebook pages show up around the site (e.g. search), and you can target ads to people who like your content. The structured data you provide via the Open Graph Protocol defines how your page will be represented on Facebook. %sRead more%s",$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/opengraph/" target="_blank">','</a>'); 
	?>
	</p>
</div>
<div id="lightbox_help_connect" class="hidden">
	<p>
	<?php
	printf(__("Facebook helps you simplify and enhance user registration and sign-in by using Facebook as your login system. Users no longer need to fill in yet another registration form or remember another username and password to use your site. As long as the user is signed into Facebook, they are automatically signed into your site as well. Using Facebook for login provides you with all the information you need to create a social, personalized experience from the moment the user visits your site in their browser. %sRead more%s",$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/guides/web/#login" target="_blank">','</a>'); 
	?>
	</p>
</div>
<div id="lightbox_help_locale" class="hidden">
	<p>
	<?php
	_e("Lang to use with Facebook (default to en_US, or equal to WPLANG Constant if set in wp-config.php)",$this->plugin_text_domain);
	?>
	</p>
</div>
<div id="lightbox_help_permissions" class="hidden">
	<p>
	<?php
	printf(__('Facebook Connect permissions (example: publish_stream,user_photos,user_status) %sSee%s the list of permissions ',$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/authentication/permissions/" target="_blank">',"</a>");
	?>
	</p>
</div>
<div id="lightbox_help_timeout" class="hidden">
	<p>
	<?php _e('This value represents the maximum time in seconds to connect to the Facebook API. If your server is slow, increase this value, then try again',$this->plugin_text_domain); ?>
	</p>
</div>
<div id="lightbox_help_page_sync" class="hidden">
	<p>
	<?php _e('The plugin can publish on your facebook pages and on your facebook profile when you edit a post, to allow the app to make call to the Facebook api, please ask for custom permissions by clicking on the related\'s button dialog (Stream publish and Manage pages). Then, you will be able to choose which pages you want to sync with your blog by selecting them. After you saved settings, a dedicated web form will appear in post editor to manage published\'s actions',$this->plugin_text_domain); ?>
	<?php echo sprintf(__('Learn more on %sWiki%s',$this->plugin_text_domain),'<a href="http://trac.ahwebdev.fr/projects/facebook-awd/wiki/How_to_sync_posts_with_facebook_Pages_and_profile" target="_blank">','</a>'); ?>
	</p>
</div>
<div id="lightbox_help_custom_actions" class="hidden">
	<p>
	<?php echo sprintf(__('Learn more on %sWiki%s',$this->plugin_text_domain),'<a href="http://trac.ahwebdev.fr/projects/facebook-awd/wiki/How_to_use_Custom_OpenGraph_Objects_and_OpenGraph_Objects_Actions" target="_blank">','</a>'); ?>
	</p>
</div>

<?php
/*
*
* Help Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
?><?php
/**
* Help app id
*/
?>
<div id="message_help_app_id" class="hidden">
	<?php
	echo "<b>".__("App ID",$this->plugin_text_domain).':</b><br />';
	printf(__("This is the id of your application on Facebook, if you have not yet an application, you can create one %shere%s.",$this->plugin_text_domain),'<a href="https://www.facebook.com/developers/createapp.php" target="_blank">','</a>'); 
	?>
</div>
<?php
/**
* Help xfbml
*/
?>
<div id="message_help_xfbml" class="hidden">
	<?php
	echo "<b>".__("XFBML",$this->plugin_text_domain).':</b><br />';
	printf(__("Use xfbml parsing, Only for old applications. Visit %sthis page%s",$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/reference/fbml/" target="_blank">','</a>'); 
	?>
</div>
<?php
/**
* Help xfbml
*/
?>
<div id="message_help_open_graph" class="hidden">
	<?php
	echo "<b>".__("Open Graph",$this->plugin_text_domain).':</b><br />';
	printf(__("The Open Graph Protocol enables you to integrate your Web pages into the social graph. 
	It is currently designed for Web pages representing profiles of real-world things — things like movies, 
	sports teams, celebrities, and restaurants. Including Open Graph tags on your Web page, 
	makes your page equivalent to a Facebook Page. This means when a user clicks a Like button on your page, 
	a connection is made between your page and the user. Your page will appear in the ”Likes and Interests” 
	section of the user’s profile, and you have the ability to publish updates to the user. 
	Your page will show up in the same places that Facebook pages show up around the site (e.g. search), 
	and you can target ads to people who like your content. The structured data you provide via the Open Graph Protocol 
	defines how your page will be represented on Facebook. %sRead more%s",$this->plugin_text_domain),
	'<a href="https://developers.facebook.com/docs/opengraph/" target="_blank">','</a>'); 
	?>
</div>
<?php
/**
* FBconnect xfbml
*/
?>
<div id="message_help_connect" class="hidden">
	<?php
	echo "<b>".__("Open Graph",$this->plugin_text_domain).':</b><br />';
	printf(__("Facebook helps you simplify and enhance user registration and sign-in by 
	using Facebook as your login system. Users no longer need to fill in yet another 
	registration form or remember another username and password to use your site. 
	As long as the user is signed into Facebook, they are automatically signed into your site as well. 
	Using Facebook for login provides you with all the information you need to create a social, 
	personalized experience from the moment the user visits your site in their browser. 
	%sRead more%s",$this->plugin_text_domain),
	'<a href="https://developers.facebook.com/docs/guides/web/#login" target="_blank">','</a>'); 
	?>
</div>




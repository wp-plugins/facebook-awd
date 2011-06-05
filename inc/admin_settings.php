<?php
/*
*
* Options Admin AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
?>
<div id="div_options_content">
	<form method="POST" action="">
		<div id="div_options_content_tabs">
			<ul class="tabs_ul">
				<li><a href="#settings"><?php _e('App Settings',$this->plugin_text_domain); ?></a></li>
			</ul>
			<?php
			/**
			* Settings
			*/
			?>
			<div id="settings">
				<p>
					<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>parse_xfbml"><?php _e('Activate XFBML parsing ?',$this->plugin_text_domain); ?><span class="help" id="help_xfbml"><img src="<?php echo $this->plugin_url_images; ?>info.png" /></span></label>
					<input type="radio" name="<?php echo $this->plugin_option_pref; ?>parse_xfbml" value="1" <?php if($this->plugin_option['parse_xfbml'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
					<input type="radio" name="<?php echo $this->plugin_option_pref; ?>parse_xfbml" value="0" <?php if($this->plugin_option['parse_xfbml'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					<i><?php _e('If you set this option to "No" you will never be able to use xfbml',$this->plugin_text_domain); ?></i>
				</p>
				<p>
					<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>app_id"><?php _e('App ID',$this->plugin_text_domain); ?><span class="help" id="help_app_id"><img src="<?php echo $this->plugin_url_images; ?>info.png" /></span></label>
					<input type="text" name="<?php echo $this->plugin_option_pref; ?>app_id" value="<?php echo $this->plugin_option['app_id']; ?>" size="30" />
				</p>
				<p>
					<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>open_graph_enable"><?php _e('Activate Open Graph ?',$this->plugin_text_domain); ?><span class="help" id="help_open_graph"><img src="<?php echo $this->plugin_url_images; ?>info.png" /></span></label>
					<input type="radio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" value="1" <?php if($this->plugin_option['open_graph_enable'] == '1') echo 'checked="checked"'; ?>  /> <?php echo __('Yes',$this->plugin_text_domain).' '.__('(recommended)',$this->plugin_text_domain);; ?> 
					<input type="radio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" value="0" <?php if($this->plugin_option['open_graph_enable'] == '0') echo 'checked="checked"'; ?>  /> <?php _e('No',$this->plugin_text_domain); ?>
				</p>
				<p>
					<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>connect_enable"><?php _e('Activate FB Connect ?',$this->plugin_text_domain); ?><span class="help" id="help_connect"><img src="<?php echo $this->plugin_url_images; ?>info.png" /></span></label>
					<input type="radio" id="<?php echo $this->plugin_option_pref; ?>connect_enable_on" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="1" <?php if($this->plugin_option['connect_enable'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#connect_options').slideDown('fast');"  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
					<input type="radio" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="0" <?php if($this->plugin_option['connect_enable'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#connect_options').slideUp('fast');" /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
				</p>
				<div id="connect_options" class="hidden">
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>app_secret_key"><?php _e('App SECRET KEY',$this->plugin_text_domain); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>app_secret_key" value="<?php echo $this->plugin_option['app_secret_key']; ?>" size="30" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>perms"><?php printf(__('Facebook Connect permissions (example: publish_stream,user_photos,user_status) %sSee%s the list of permissions ',$this->plugin_text_domain),'<a href="https://developers.facebook.com/docs/authentication/permissions/" target="_blank">',"</a>");  __('(Default:none)',$this->plugin_text_domain);?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>perms" value="<?php echo $this->plugin_option['perms']; ?>" size="100%" />
					</p>
				</div>
			</div><?php //end settings ?>
			<br />
			<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		</div>
		<br />
		<div style="text-align:right;"><input type="submit"  name="<?php echo $this->plugin_option_pref; ?>submit" id="<?php echo $this->plugin_option_pref; ?>submit" value="<?php _e('Save all settings',$this->plugin_text_domain); ?>" /></div>
	</form>
</div>
<?php
/**
* Javascript for admin
*/
?>
<script type="text/javascript">
	jQuery(document).ready( function(){
		hide_state("#<?php echo $this->plugin_option_pref; ?>connect_enable_on","#connect_options");
	});
</script>
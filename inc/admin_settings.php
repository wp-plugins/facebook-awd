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
	<form method="post" action="" id="<?php echo $this->plugin_slug; ?>_form_settings">
		<?php
		/**
		* Settings
		*/
		?>
		<div id="settings" class="uiForm">
			<table class="AWD_form_table">
				<tr class="dataRow">
					<th class="label"><?php _e('Activate XFBML',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('xfbml'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>parse_xfbml" id="<?php echo $this->plugin_option_pref; ?>parse_xfbml_on" value="1" <?php if($this->plugin_option['parse_xfbml'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>parse_xfbml_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>parse_xfbml" id="<?php echo $this->plugin_option_pref; ?>parse_xfbml_off" value="0" <?php if($this->plugin_option['parse_xfbml'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>parse_xfbml_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br />
					</td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('App ID (facebook)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('app_id'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>app_id" value="<?php echo $this->plugin_option['app_id']; ?>" size="30"/></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Admins IDs (facebook)',$this->plugin_text_domain); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>admins" value="<?php echo $this->plugin_option['admins']; ?>" size="30" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Page Admin ID (facebook)',$this->plugin_text_domain); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>page_id" value="<?php echo $this->plugin_option['page_id']; ?>" size="30" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('locale',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('locale'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>locale" value="<?php echo $this->plugin_option['locale']; ?>" size="6" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Activate Open Graph ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('open_graph'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" id="<?php echo $this->plugin_option_pref; ?>open_graph_enable_on" value="1" <?php if($this->plugin_option['open_graph_enable'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>open_graph_enable_on"><?php echo __('Yes',$this->plugin_text_domain).' '.__('(recommended)',$this->plugin_text_domain);; ?></label><br />
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" id="<?php echo $this->plugin_option_pref; ?>open_graph_enable_off" value="0" <?php if($this->plugin_option['open_graph_enable'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>open_graph_enable_off"><?php _e('No',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Activate FB Connect ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('connect'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_enable_on" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="1" <?php if($this->plugin_option['connect_enable'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('.connect_options').fadeIn();"  /> <label for="<?php echo $this->plugin_option_pref; ?>connect_enable_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_enable_off" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="0" <?php if($this->plugin_option['connect_enable'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('.connect_options').fadeOut();" /> <label for="<?php echo $this->plugin_option_pref; ?>connect_enable_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('App SECRET KEY',$this->plugin_text_domain); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>app_secret_key" value="<?php echo $this->plugin_option['app_secret_key']; ?>" size="30" /></td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('Replace Wordpress avatar by Fb avatar ?',$this->plugin_text_domain); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_on" name="<?php echo $this->plugin_option_pref; ?>connect_fbavatar" value="1" <?php if($this->plugin_option['connect_fbavatar'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_off" name="<?php echo $this->plugin_option_pref; ?>connect_fbavatar" value="0" <?php if($this->plugin_option['connect_fbavatar'] == '0') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('Facebook Connect permissions',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('permissions'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>perms" value="<?php echo $this->plugin_option['perms']; ?>" size="30" /></td>
				</tr>
			</table>
		</div><?php //end settings ?>
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<div style="text-align:center;">
			<a href="#" id="submit_settings" class="uiButton uiButtonSubmit"><?php _e('Save all settings',$this->plugin_text_domain); ?></a>
		</div>
	</form>
</div>
<?php
/**
* Javascript for admin
*/
?>
<script type="text/javascript">
	jQuery(document).ready( function(){
		jQuery('#submit_settings').click(function(){
			jQuery("body").css("cursor", "progress");
			jQuery('#<?php echo $this->plugin_slug; ?>_form_settings').submit();
			return false;
		});
		hide_state("#<?php echo $this->plugin_option_pref; ?>connect_enable_on",".connect_options");
	});
</script>
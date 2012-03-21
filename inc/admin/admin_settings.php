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
					<th class="label" colspan="2"><h3 class="center"><?php _e('General',$this->plugin_text_domain);?></h3></th>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('App ID (facebook)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('app_id'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>app_id" value="<?php echo $this->options['app_id']; ?>" size="30"/></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('App SECRET KEY',$this->plugin_text_domain); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>app_secret_key" value="<?php echo $this->options['app_secret_key']; ?>" size="30" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Admins IDs (facebook)',$this->plugin_text_domain); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>admins" value="<?php echo $this->options['admins']; ?>" size="30" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('locale',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('locale'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>locale" value="<?php echo $this->options['locale']; ?>" size="6" /></td>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Activate Mode Debug ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('debug_enable'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>debug_enable" id="<?php echo $this->plugin_option_pref; ?>debug_enable_on" value="1" <?php if($this->options['debug_enable'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>debug_enable_on"><?php echo __('Yes',$this->plugin_text_domain); ?></label><br />
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>debug_enable" id="<?php echo $this->plugin_option_pref; ?>debug_enable_off" value="0" <?php if($this->options['debug_enable'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>debug_enable_off"><?php _e('No',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow">
					<th class="label" colspan="2"><h3 class="center"><?php _e('Open Graph',$this->plugin_text_domain);?></h3></th>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Activate Open Graph ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('open_graph'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" id="<?php echo $this->plugin_option_pref; ?>open_graph_enable_on" value="1" <?php if($this->options['open_graph_enable'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>open_graph_enable_on"><?php echo __('Yes',$this->plugin_text_domain).' '.__('(recommended)',$this->plugin_text_domain); ?></label><br />
						<input type="radio" class="uiRadio" name="<?php echo $this->plugin_option_pref; ?>open_graph_enable" id="<?php echo $this->plugin_option_pref; ?>open_graph_enable_off" value="0" <?php if($this->options['open_graph_enable'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>open_graph_enable_off"><?php _e('No',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow">
					<th class="label" colspan="2"><h3 class="center"><?php _e('Facebook Connect',$this->plugin_text_domain);?></h3></th>
				</tr>
				<tr class="dataRow">
					<th class="label"><?php _e('Activate FB Connect ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('connect'); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_enable_on" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="1" <?php if($this->options['connect_enable'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('.connect_options').fadeIn();"  /> <label for="<?php echo $this->plugin_option_pref; ?>connect_enable_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_enable_off" name="<?php echo $this->plugin_option_pref; ?>connect_enable" value="0" <?php if($this->options['connect_enable'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('.connect_options').fadeOut();" /> <label for="<?php echo $this->plugin_option_pref; ?>connect_enable_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('Timeout Facebook connect API',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('timeout'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>timeout" value="<?php echo $this->options['timeout']; ?>" size="4" /></td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('Add FB avatar choice in Wordpress discussion settings ?',$this->plugin_text_domain); ?></th>
					<td class="data">
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_on" name="<?php echo $this->plugin_option_pref; ?>connect_fbavatar" value="1" <?php if($this->options['connect_fbavatar'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
						<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_off" name="<?php echo $this->plugin_option_pref; ?>connect_fbavatar" value="0" <?php if($this->options['connect_fbavatar'] == '0') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>connect_fbavatar_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
					</td>
				</tr>
				<tr class="dataRow hidden connect_options">
					<th class="label"><?php _e('Facebook Connect permissions (Users)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('permissions'); ?></th>
					<td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>perms" value="<?php echo $this->options['perms']; ?>" size="30" /></td>
				</tr>
				
				<tr class="dataRow connect_options">
					<th class="label" colspan="2"><h3 class="center"><?php _e('Manage Pages',$this->plugin_text_domain);?> <?php echo $this->get_the_help('page_sync'); ?></h3></th>
				</tr>
				<tr class="dataRow hidden connect_options">
					<td class="data" colspan="2">
						<?php if($this->current_facebook_user_can('publish_stream')){ ?>
							<p class="AWD_button_succes"><?php _e('Publish Stream is enabled',$this->plugin_text_domain); ?></p>
						<?php }else{ ?>
							<a href="#" data-scope="email,publish_stream" class="get_permissions floatright uiButton uiButtonNormal"><?php _e('Authorize App to publish on your pages',$this->plugin_text_domain); ?></a>
						<?php } ?>
					</td>
				</tr>
				
				
				<tr class="dataRow hidden connect_options">
					<td class="data" colspan="2">
						<?php if($this->current_facebook_user_can('manage_pages')){ ?>
							<span class="AWD_button_succes"><?php _e('Pages can be managed by this plugin.',$this->plugin_text_domain); ?></span> <a href="#" id="toogle_list_pages" class="floatright uiButton uiButtonNormal"><?php _e('Select pages to link with Wordpress',$this->plugin_text_domain); ?></a>
						<?php }else{ ?>
							<a href="#" data-scope="email,manage_pages" class="get_permissions floatright uiButton uiButtonNormal"><?php _e('Authorize App to access your pages',$this->plugin_text_domain); ?></a>
						<?php } ?>
					</td>
				</tr>

				<?php if($this->current_facebook_user_can('manage_pages')){ ?>
					<tr class="dataRow hidden connect_options">
						<td class="data" colspan="2">
							<div class="toogle_fb_pages hidden">
								<p class="center"><label><?php _e('Check the page you want to sync with your blog.',$this->plugin_text_domain); ?></label></p>
								<?php
								$fb_pages = $this->me['pages'];
								if(is_array($fb_pages) AND count($fb_pages)){
									echo '<div class="list_fb_pages">';
										echo '<ul>';
										foreach($fb_pages as $fb_page){
											echo '<li><input value="1" type="checkbox" '.($this->options['fb_publish_to_pages'][$fb_page['id']] == 1 ? 'checked="checked";' : '').' name="'.$this->plugin_option_pref.'fb_publish_to_pages['.$fb_page['id'].']" id="fb_publish_to_pages'.$fb_page['id'].'" /><label for="fb_publish_to_pages'.$fb_page['id'].'" title="ID: '.$fb_page['id'].' | Category: '.$fb_page['category'].'"> <img class="fb_pages_picto" src="http://graph.facebook.com/'.$fb_page['id'].'/picture" width="30" height="30" />'.$fb_page['name'].' <span class="xlittle_text awd_grey">(ID: '.$fb_page['id'].' | '.$fb_page['category'].')</span></label></li>';
										}
										echo '</ul>';
									echo '</div>';
								}
								?>
							</div>
						</td>
					</tr>
					
					
					<?php if($this->current_facebook_user_can('publish_stream')){ ?>
						<?php if($this->current_facebook_user_can('manage_pages')){ ?>
							<tr class="dataRow hidden connect_options">
								<th class="label"><?php _e('Auto publish post on Facebook pages ?',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>publish_to_pages_on" name="<?php echo $this->plugin_option_pref; ?>publish_to_pages" value="1" <?php if($this->options['publish_to_pages'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_pages_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>publish_to_pages_off" name="<?php echo $this->plugin_option_pref; ?>publish_to_pages" value="0" <?php if($this->options['publish_to_pages'] == '0') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_pages_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
						<?php } ?>
						<tr class="dataRow">
							<th class="label"><?php _e('Auto publish post on Facebook profile ?',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>publish_to_profile_on" name="<?php echo $this->plugin_option_pref; ?>publish_to_profile" value="1" <?php if($this->options['publish_to_profile'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_profile_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>publish_to_profile_off" name="<?php echo $this->plugin_option_pref; ?>publish_to_profile" value="0" <?php if($this->options['publish_to_profile'] == '0') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>publish_to_profile_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Default link action Text',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="text" class="uiText" id="<?php echo $this->plugin_option_pref; ?>publish_read_more_text" name="<?php echo $this->plugin_option_pref; ?>publish_read_more_text" value="<?php echo $this->options['publish_read_more_text']; ?>" maxlengh="25" />
							</td>
						</tr>
					<?php } ?>
					
					
				<?php } ?>
				
				
				<tr class="dataRow connect_options">
					<th class="label" colspan="2"><h3 class="center"><?php _e('Advanced Actions (BETA)',$this->plugin_text_domain);?> <?php echo $this->get_the_help('custom_actions'); ?></h3></th>
				</tr>
				<tr class="dataRow hidden connect_options">
					<td class="data" colspan="2">
						<?php if($this->current_facebook_user_can('publish_actions')){ ?>
							<p class="AWD_button_succes"><?php _e('Actions can be posted on your timeline wall',$this->plugin_text_domain); ?></p>
						<?php }else{ ?>
							<!--<a href="#" id="get_permissions" data-scope="publish_actions" class="get_permissions floatright uiButton uiButtonNormal"><?php _e('Authorize App to publish actions on your timeline',$this->plugin_text_domain); ?></a>-->
						<?php } ?>
					</td>
				</tr>
			</table>
		</div><?php //end settings ?>
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<div style="text-align:center;">
			<a href="#" id="submit_settings" class="uiButton uiButtonSubmit"><?php _e('Save all settings',$this->plugin_text_domain); ?></a>
			<a href="#" id="reset_settings" class="floatright uiButton uiButtonNormal"><?php _e('Restore defaults settings',$this->plugin_text_domain); ?></a>
			<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=ZQ2VL33YXHJLC" target="_blank" title="Please help me by making a donation. This will contribute to support this free plugin." class="floatright uiButton uiButtonNormal"><?php _e('Make a donation!',$this->plugin_text_domain); ?></a>
		</div>
	</form>
	<form method="post" action="" id="<?php echo $this->plugin_slug; ?>_reset_settings">
		<?php wp_nonce_field($this->plugin_slug.'_reset_options',$this->plugin_option_pref.'_nonce_reset_options'); ?>
	</form>
</div>
<?php
/**
* Javascript for admin
*/
?>
<script type="text/javascript">
	jQuery(document).ready( function($){
		$('#submit_settings').click(function(e){
			e.preventDefault();
			$('#<?php echo $this->plugin_slug; ?>_form_settings').submit();
		});
		$('#reset_settings').click(function(e){
			e.preventDefault();
			if(confirm('<?php _e("Do you really want to reset all settings ? (AWD plugins and openGraph settings will be reset too)",$this->plugin_text_domain); ?>')){
				$('#<?php echo $this->plugin_slug; ?>_reset_settings').submit();
			}
		});
		$('.get_permissions').live('click',function(e){
			e.preventDefault();
			var $this = $(this);
			var scope = $this.data('scope');
			FB.login(function(response)
			{
				if(response.authResponse) {
					console.log(response);
				    $('#<?php echo $this->plugin_slug; ?>_form_settings').submit();
				}
			},{scope: scope});
		});
		
		hide_state("#<?php echo $this->plugin_option_pref; ?>connect_enable_on",".connect_options");
		$('#toogle_list_pages').live('click',function(e){
			e.preventDefault();
			$('.toogle_fb_pages').slideToggle();
		});
	});
</script>
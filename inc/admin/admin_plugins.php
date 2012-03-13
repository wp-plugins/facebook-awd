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
	<form method="POST" action="" id="<?php echo $this->plugin_slug; ?>_form_settings">
		<div id="div_options_content_tabs">
			<ul class="tabs_ul">			
				<li><a href="#like_button_settings"><?php _e('Like Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#activity_settings"><?php _e('Activity Feed',$this->plugin_text_domain); ?></a></li>
				<li><a href="#login_button_settings"><?php _e('Login Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#like_box_settings"><?php _e('Like Box',$this->plugin_text_domain); ?></a></li>
				<li><a href="#comments_settings"><?php _e('Comments',$this->plugin_text_domain); ?></a></li>

				<!--<li><a href="#"><?php _e('Live Stream',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Recommendations',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Send Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Facepile',$this->plugin_text_domain); ?></a></li>-->
				<?php do_action('AWD_facebook_plugins_menu'); ?>
			</ul>
			<?php
			/**
			* Like button Settings
			*/
			?>
			<div id="like_button_settings">
				<p><i><?php _e('All that settings are defaults, you can redefine them in shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></i></p>
				<div class="uiForm">
					<table class="AWD_form_table">
						<tr class="dataRow">
							<th class="label" colspan="2"><h3 class="center"><?php _e('Design',$this->plugin_text_domain); ?></h3></th>
						</tr>
						<tr class="dataRow">
							<td class="data" colspan="2">
								<table>
									<tr>
										<td>
											<?php _e('Fonts of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_font'); ?><br />
											<select id="<?php echo $this->plugin_option_pref; ?>like_button_font" name="<?php echo $this->plugin_option_pref; ?>like_button_font"  onchange="onchange_uiSelect(this.id);">
												<option value="arial" <?php if($this->options['like_button_font'] == "arial") echo 'selected="selected"'; ?> >Arial</option>
												<option value="lucida grande" <?php if($this->options['like_button_font'] == "lucida grande") echo 'selected="selected"'; ?> >Lucida grande</option>
												<option value="segoe ui" <?php if($this->options['like_button_font'] == "segoe ui") echo 'selected="selected"'; ?> >Segoe ui</option>
												<option value="tahoma" <?php if($this->options['like_button_font'] == "tahoma") echo 'selected="checked"'; ?> >Tahoma</option>
												<option value="trebuchet ms" <?php if($this->options['like_button_font'] == "trebuchet ms") echo 'selected="selected"'; ?> >Trebuchet ms</option>
												<option value="verdana" <?php if($this->options['like_button_font'] == "verdana") echo 'selected="selected"'; ?> >Verdana</option>
											</select>
										</td>
										<td>
											<?php _e('Action',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_action'); ?><br />
											<select id="<?php echo $this->plugin_option_pref; ?>like_button_action" name="<?php echo $this->plugin_option_pref; ?>like_button_action">
												<option value="like" <?php if($this->options['like_button_action'] == "like") echo 'selected="selected"'; ?> ><?php echo __("Like",$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></option>
												<option value="recommend" <?php if($this->options['like_button_action'] == "recommend") echo 'selected="selected"'; ?> ><?php echo __("Recommend",$this->plugin_text_domain); ?></option>
											</select>
										</td>
										<td>
											<?php _e('Layout style',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_layout'); ?><br />
											<select id="<?php echo $this->plugin_option_pref; ?>like_button_layout" name="<?php echo $this->plugin_option_pref; ?>like_button_layout"  onchange="onchange_uiSelect(this.id);">
												<option value="standard" <?php if($this->options['like_button_layout'] == "standard") echo 'selected="selected"'; ?> ><?php echo __("Standard",$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></option>
												<option value="button_count" <?php if($this->options['like_button_layout'] == "button_count") echo 'selected="selected"'; ?> ><?php echo __("Button Count",$this->plugin_text_domain); ?></option>
												<option value="box_count" <?php if($this->options['like_button_layout'] == "box_count") echo 'selected="selected"'; ?> ><?php echo __("Box Count",$this->plugin_text_domain); ?></option>
											</select>
										</td>
									</tr>
								</table>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_type'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_xfbml" name="<?php echo $this->plugin_option_pref; ?>like_button_type" value="xfbml" <?php if($this->options['like_button_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_xfbml"><?php echo __('XFBML',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_iframe" name="<?php echo $this->plugin_option_pref; ?>like_button_type" value="iframe" <?php if($this->options['like_button_type'] == 'iframe') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_iframe"><?php echo __('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_html5" name="<?php echo $this->plugin_option_pref; ?>like_button_type" value="html5" <?php if($this->options['like_button_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_html5"><?php echo __('HTML5',$this->plugin_text_domain);?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php printf(__('Enable "Send" button ? %s(xfbml or html5 only)%s',$this->plugin_text_domain),'<i>','</i>'); ?> <?php echo $this->get_the_help('like_button_send'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_send_on" name="<?php echo $this->plugin_option_pref; ?>like_button_send" value="1" <?php if($this->options['like_button_send'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_send_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_send_off" name="<?php echo $this->plugin_option_pref; ?>like_button_send" value="0" <?php if($this->options['like_button_send'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_send_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
                            <th class="label"><?php _e('Ref',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_ref'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>like_button_ref" name="<?php echo $this->plugin_option_pref; ?>like_button_ref" value="<?php echo $this->options['like_button_ref']; ?>" size="30"/>
                            </td>
                        </tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Colorscheme of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme_on" name="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme" value="light" <?php if($this->options['like_button_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme_on"><?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme_off" name="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme" value="dark" <?php if($this->options['like_button_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme_off"><?php _e('Dark',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_faces_on" name="<?php echo $this->plugin_option_pref; ?>like_button_faces" value="1" <?php if($this->options['like_button_faces'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_faces_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_faces_off" name="<?php echo $this->plugin_option_pref; ?>like_button_faces" value="0" <?php if($this->options['like_button_faces'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_faces_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Width of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_width" value="<?php echo $this->options['like_button_width']; ?>" size="6" />
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Height of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_height" <?php if($this->options['like_button_xfbml'] == 1){ echo 'disabled="disabled"'; } ?> value="<?php echo $this->options['like_button_height']; ?>" size="6" />
							</td>
						</tr>
						<tr class="dataRow">
							<td>&nbsp;</td>
						</tr>
						<tr class="dataRow">
							<th class="label" colspan="2"><h3 class="center"><?php _e('Display',$this->plugin_text_domain); ?></h3></th>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Default Url to like',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_url'); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_url" value="<?php echo $this->options['like_button_url']; ?>" size="30" />
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Add "Like" button to pages',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_pages_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_pages" value="1" <?php if($this->options['like_button_on_pages'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_pages').fadeIn();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_pages_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_pages_off" name="<?php echo $this->plugin_option_pref; ?>like_button_on_pages" value="0" <?php if($this->options['like_button_on_pages'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_pages').fadeOut();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_pages_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow hidden_state" id="start_or_end_pages">
							<th class="label"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_1" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="top" <?php if($this->options['like_button_place_on_pages'] == 'top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_1"><?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_2" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="bottom" <?php if($this->options['like_button_place_on_pages'] == 'bottom') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_2"><?php _e('Bottom',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_3" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="both" <?php if($this->options['like_button_place_on_pages'] == 'both') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages_3"><?php _e('Both',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Add "Like" button to posts',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_posts_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_posts" value="1" <?php if($this->options['like_button_on_posts'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_posts').fadeIn();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_posts_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_posts_off" name="<?php echo $this->plugin_option_pref; ?>like_button_on_posts" value="0" <?php if($this->options['like_button_on_posts'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_posts').fadeOut();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_posts_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow hidden_state" id="start_or_end_posts">
							<th class="label"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_1" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="top" <?php if($this->options['like_button_place_on_posts'] == 'top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_1"><?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_2" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="bottom" <?php if($this->options['like_button_place_on_posts'] == 'bottom') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_2"><?php _e('Bottom',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_3" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="both" <?php if($this->options['like_button_place_on_posts'] == 'both') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts_3"><?php _e('Both',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow">
							<th class="label"><?php _e('Add "Like" button to custom post types',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types" value="1" <?php if($this->options['like_button_on_custom_post_types'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_custom_post_types').fadeIn();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
								<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_off" name="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types" value="0" <?php if($this->options['like_button_on_custom_post_types'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_custom_post_types').fadeOut();"/> <label for="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_off"><?php _e('No',$this->plugin_text_domain); ?></label>
							</td>
						</tr>
						<tr class="dataRow hidden_state" id="start_or_end_custom_post_types">
							<th class="label"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_1" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="top" <?php if($this->options['like_button_place_on_custom_post_types'] == 'top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_1"><?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br /> 
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_2" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="bottom" <?php if($this->options['like_button_place_on_custom_post_types'] == 'bottom') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_2"><?php _e('Bottom',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_3" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="both" <?php if($this->options['like_button_place_on_custom_post_types'] == 'both') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types_3"><?php _e('Both',$this->plugin_text_domain); ?></label>
							</td>
						</tr>	
						<tr class="dataRow">
							<th class="label"><?php _e('Exclude Post types (for custom post_type, example: post,page,etc...)',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_type" value="<?php echo $this->options['like_button_exclude_post_type']; ?>" size="30" />
							</td>
						</tr>	
						<tr class="dataRow">
							<th class="label"><?php _e('Exclude Categories or other terms (slug or id example: photos,34,50)',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_terms_slug" value="<?php echo $this->options['like_button_exclude_terms_slug']; ?>" size="30" />
							</td>
						</tr>	
						<tr class="dataRow">
							<th class="label"><?php _e('Exclude Posts or Pages ID (example: 12,46,234)',$this->plugin_text_domain); ?></th>
							<td class="data">
								<input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_id" value="<?php echo $this->options['like_button_exclude_post_id']; ?>" size="30" />
							</td>
						</tr>
						<tr class="dataRow">
							<td>&nbsp;</td>
						</tr>
						<tr class="dataRow">
							<th class="label" colspan="2"><h3 class="center"><?php _e('Preview',$this->plugin_text_domain);?></h3></th>
						</tr>
						<tr class="dataRow">
							<td class="data center" colspan="2">
								<?php echo $this->get_the_like_button(); ?>	
								<br />
								<div class="awd_pre" style="text-align:left;">
									<strong>Shorcode: [AWD_likebutton]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_likebutton').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
									<br />
									<div id="egoptions_likebutton"  class="hidden">
                                        Options:<br />
                                        * url (string)<br />
                                        * send (0 or 1)<br />
                                        * width (number)<br />
                                        * colorscheme (light or dark)<br />
                                        * faces (0 or 1)<br />
                                        * fonts (string)<br />
                                        * action (like or recommend)<br />
                                        * layout (standard, box_count or button_count)<br />
                                        * height (number)<br />
                                        * type (xfbml or iframe or html5)<br />
                                        * ref (string)<br />
									</div>
								</div>
							</td>
						</tr>
					</table>
				</div>
			</div>
			<?php
			/**
			* Like box settings
			*/
			?>
			<div id="like_box_settings">
				<p><i><?php _e('The like box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></i></p>
			    <div class="uiForm">
                    <table class="AWD_form_table">
                        <tr class="dataRow">
							<th class="label"><?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_type'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_xfbml" name="<?php echo $this->plugin_option_pref; ?>like_box_type" value="xfbml" <?php if($this->options['like_box_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_xfbml"><?php echo __('XFBML',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_iframe" name="<?php echo $this->plugin_option_pref; ?>like_box_type" value="iframe" <?php if($this->options['like_box_type'] == 'iframe') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_iframe"><?php echo __('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_html5" name="<?php echo $this->plugin_option_pref; ?>like_box_type" value="html5" <?php if($this->options['like_box_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_html5"><?php echo __('HTML5',$this->plugin_text_domain);?></label>
							</td>
						</tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Url of the page',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_url'); ?></th>
						    <td class="data"><input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_box_url" value="<?php echo $this->options['like_box_url']; ?>" size="30"/></td>
					    </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Colorscheme of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></th>
						    <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme_on" name="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme" value="light" <?php if($this->options['like_box_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme_on"><?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br /> 
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme_off" name="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme" value="dark" <?php if($this->options['like_box_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme_off"><?php _e('Dark',$this->plugin_text_domain); ?></label>
						    </td>
					    </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></th>
						    <td class="data">
                                <input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_box_width" value="<?php echo $this->options['like_box_width']; ?>" size="6" />
						    </td>
					    </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Height of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></th>
						    <td class="data">
						        <input type="text" class="uiTextbox" name="<?php echo $this->plugin_option_pref; ?>like_box_height" <?php if($this->options['like_box_xfbml'] == 1){ echo 'disabled="disabled"'; } ?> value="<?php echo $this->options['like_box_height']; ?>" size="6" />
						    </td>
					    </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Border color',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_border'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>like_box_border_color" name="<?php echo $this->plugin_option_pref; ?>like_box_border_color" value="<?php echo $this->options['like_box_border_color']; ?>" size="10" />
                            </td>
                        </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></th>
						    <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_faces_on" name="<?php echo $this->plugin_option_pref; ?>like_box_faces" value="1" <?php if($this->options['like_box_faces'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_faces_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_faces_off" name="<?php echo $this->plugin_option_pref; ?>like_box_faces" value="0" <?php if($this->options['like_box_faces'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_faces_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
						    </td>
					    </tr>       
					    <tr class="dataRow">
                            <th class="label"><?php _e('Show Stream ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_stream'); ?></th>
						    <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_stream_on" name="<?php echo $this->plugin_option_pref; ?>like_box_stream" value="1" <?php if($this->options['like_box_stream'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_stream_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_stream_off" name="<?php echo $this->plugin_option_pref; ?>like_box_stream" value="0" <?php if($this->options['like_box_stream'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_stream_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
						    </td>
					    </tr>
					    <tr class="dataRow">
                            <th class="label"><?php _e('Show Header ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('show_header'); ?></th>
						    <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_header_on" name="<?php echo $this->plugin_option_pref; ?>like_box_header" value="1" <?php if($this->options['like_box_header'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_header_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_header_off" name="<?php echo $this->plugin_option_pref; ?>like_box_header" value="0" <?php if($this->options['like_box_header'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_header_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
						    </td>
					    </tr>
					     <tr class="dataRow">
                            <th class="label"><?php _e('Force Wall ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_force_wall'); ?></th>
						    <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_force_wall_on" name="<?php echo $this->plugin_option_pref; ?>like_box_force_wall" value="light" <?php if($this->options['like_box_force_wall'] == 'light') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_force_wall_on"><?php echo __('Yes',$this->plugin_text_domain); ?></label><br /> 
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>like_box_force_wall_off" name="<?php echo $this->plugin_option_pref; ?>like_box_force_wall" value="dark" <?php if($this->options['like_box_force_wall'] == 'dark') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>like_box_force_wall_off"><?php _e('No',$this->plugin_text_domain); ?></label>
						    </td>
					    </tr>
					    <tr class="dataRow">
							<td>&nbsp;</td>
						</tr>
						<tr class="dataRow">
							<th class="label" colspan="2"><h3 class="center"><?php _e('Preview',$this->plugin_text_domain);?></h3></th>
						</tr>
						<tr class="dataRow">
							<td class="data center" colspan="2">
						        <?php echo $this->get_the_like_box(); ?>
								<br />
								<div class="awd_pre" style="text-align:left;">
									<strong>Shorcode: [AWD_likebox]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_likebox').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
									<br />
									<div id="egoptions_likebox"  class="hidden">
                                        Options:<br />
                                        * url (string)<br />
                                        * width (number)<br />
                                        * colorscheme (light or dark)<br />
                                        * faces (0 or 1)<br />
                                        * height (number)<br />
                                        * xfbml (0 or 1)<br />
                                        * border_color (ex: #ffffff for white)<br />
                                        * stream (0 or 1)<br />
                                        * header (0 or 1)<br />
                                        * force_wall (0 or 1)<br />
                                    </div>
								</div>
							</td>
						</tr>
                    </table>
				</div>
			</div>
			<div id="activity_settings">
			    <p><i><?php _e('The activity box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></i></p>
				<div class="uiForm">
                    <table class="AWD_form_table">
                    	<tr class="dataRow">
							<th class="label"><?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_type'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_xfbml" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="xfbml" <?php if($this->options['activity_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_xfbml"><?php echo __('XFBML',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_iframe" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="iframe" <?php if($this->options['activity_type'] == 'iframe') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_iframe"><?php echo __('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_html5" name="<?php echo $this->plugin_option_pref; ?>activity_type" value="html5" <?php if($this->options['activity_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_html5"><?php echo __('HTML5',$this->plugin_text_domain);?></label>
							</td>
						</tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Domain',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_domain'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_domain" name="<?php echo $this->plugin_option_pref; ?>activity_domain" value="<?php echo $this->options['activity_domain']; ?>" size="30"/>
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Filter',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_filter'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_filter" name="<?php echo $this->plugin_option_pref; ?>activity_filter" value="<?php echo $this->options['activity_filter']; ?>" size="30"/>
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Ref',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_ref'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_ref" name="<?php echo $this->plugin_option_pref; ?>activity_ref" value="<?php echo $this->options['activity_ref']; ?>" size="30"/>
                            </td>
                        </tr>
                         <tr class="dataRow">
                            <th class="label"><?php _e('Max Age',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_max_age'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_max_age" name="<?php echo $this->plugin_option_pref; ?>activity_max_age" value="<?php echo $this->options['activity_max_age']; ?>" size="30"/>
                            </td>
                        </tr>
                        <tr class="dataRow">
							<th class="label"><?php echo _e('Link target',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_linktarget'); ?></th>
							<td class="data">
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_blank" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_blank" <?php if($this->options['activity_linktarget'] == '_blank') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_blank"><?php echo __('Blank',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);; ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_top" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_top" <?php if($this->options['activity_linktarget'] == '_top') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_top"><?php echo __('Top',$this->plugin_text_domain); ?></label><br />
								<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_linktarget_parent" name="<?php echo $this->plugin_option_pref; ?>activity_linktarget" value="_parent" <?php if($this->options['activity_linktarget'] == '_parent') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_linktarget_parent"><?php echo __('Parent',$this->plugin_text_domain);?></label>
							</td>
						</tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_width" name="<?php echo $this->plugin_option_pref; ?>activity_width" value="<?php echo $this->options['activity_width']; ?>" size="6" />
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Height of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_height" name="<?php echo $this->plugin_option_pref; ?>activity_height" value="<?php echo $this->options['activity_height']; ?>" size="6" />
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Show Header ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('show_header'); ?></th>
                            <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_header_on" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="1" <?php if($this->options['activity_header'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_header_on"><?php echo __('Yes',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);  ?></label><br /> 
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_header_off" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="0" <?php if($this->options['activity_header'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_header_off"><?php echo _e('No',$this->plugin_text_domain);?></label>
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Colorscheme of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></th>
                            <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_on" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="light" <?php if($this->options['activity_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_on"><?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br />
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_off" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="dark" <?php if($this->options['activity_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_colorscheme_off"><?php _e('Dark',$this->plugin_text_domain); ?></label>
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Font',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_font'); ?></th>
                            <td class="data">
                                <select id="<?php echo $this->plugin_option_pref; ?>activity_font" name="<?php echo $this->plugin_option_pref; ?>activity_font"  onchange="onchange_uiSelect(this.id);">
                                    <option value="arial" <?php if($this->options['activity_font'] == "arial") echo 'selected="selected"'; ?> >Arial</option>
                                    <option value="lucida grande" <?php if($this->options['activity_font'] == "lucida grande") echo 'selected="selected"'; ?> >Lucida grande</option>
                                    <option value="segoe ui" <?php if($this->options['activity_font'] == "segoe ui") echo 'selected="selected"'; ?> >Segoe ui</option>
                                    <option value="tahoma" <?php if($this->options['activity_font'] == "tahoma") echo 'selected="checked"'; ?> >Tahoma</option>
                                    <option value="trebuchet ms" <?php if($this->options['activity_font'] == "trebuchet ms") echo 'selected="selected"'; ?> >Trebuchet ms</option>
                                    <option value="verdana" <?php if($this->options['activity_font'] == "verdana") echo 'selected="selected"'; ?> >Verdana</option>
                                </select>
                           </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Border color',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_border'); ?></th>
                            <td class="data">
						        <input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>activity_border_color" name="<?php echo $this->plugin_option_pref; ?>activity_border_color" value="<?php echo $this->options['activity_border_color']; ?>" size="10" />
                            </td>
                        </tr>
                        <tr class="dataRow">
                            <th class="label"><?php _e('Show Recommendations ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_recommendation'); ?></th>
                            <td class="data">
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_recommendations_on" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="1" <?php if($this->options['activity_recommendations'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_recommendations_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
                                <input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>activity_recommendations_off" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="0" <?php if($this->options['activity_recommendations'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>activity_recommendations_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
                            </td>
                        </tr>
						<tr class="dataRow">
							<td>&nbsp;</td>
						</tr>
						<tr class="dataRow">
							<th class="label" colspan="2"><h3 class="center"><?php _e('Preview',$this->plugin_text_domain);?></h3></th>
						</tr>
						<tr class="dataRow">
							<td class="data center" colspan="2">
						        <?php echo $this->get_the_activity_box(); ?>
								<br />
								<div class="awd_pre" style="text-align:left;">
									<strong>Shorcode: [AWD_activitybox]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_activity').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
									<br />
									<div id="egoptions_activity"  class="hidden">
                                        Options:<br />
                                        * domain (string)<br />
                                        * width (number)<br />
                                        * colorscheme (light or dark)<br />
                                        * faces (0 or 1)<br />
                                        * height (number)<br />
                                        * type (xfbml or iframe or html5)<br />
                                        * font (string)<br />
                                        * border_color (ex: #ffffff for white)<br />
                                        * header (0 or 1)<br />
                                        * recommendations (0 or 1)<br />
                                        * ref (string)<br />
                                        * filter (string)<br />
                                        * max_age (number 1-180)<br />
                                    </div>
								</div>
							</td>
						</tr>
                    </table>					
				</div>
			</div>
			<?php
			/**
			* login button settings
			*/
			?>
			<div id="login_button_settings">
				<?php
				//if FB connect enable
				if($this->options['connect_enable'] == 1){
				?>
					<div class="uiForm">
						<table class="AWD_form_table">
							<tr class="dataRow">
								<th class="label"><?php _e('Display the button on the login page (wp-login.php) ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_display_on_login_page'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_on" name="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page" value="1" <?php if($this->options['login_button_display_on_login_page'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_off" name="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page" value="0" <?php if($this->options['login_button_display_on_login_page'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_display_on_login_page_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Show Profile picture ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_profile_picture'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_on" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="1" <?php if($this->options['login_button_profile_picture'] == '1') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_off" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="0" <?php if($this->options['login_button_profile_picture'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Width of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_width" name="<?php echo $this->plugin_option_pref; ?>login_button_width" value="<?php echo $this->options['login_button_width']; ?>" size="6" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_faces_on" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="1" <?php if($this->options['login_button_faces'] == '1') echo 'checked="checked"'; ?> /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_faces_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br /> 
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>login_button_faces_off" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="0" <?php if($this->options['login_button_faces'] == '0') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>login_button_faces_off"><?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Max Rows (only if show faces = Yes)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_maxrow'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_maxrow" name="<?php echo $this->plugin_option_pref; ?>login_button_maxrow" value="<?php echo $this->options['login_button_maxrow']; ?>" size="6" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Logout Phrase',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_logout'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_logout_value" name="<?php echo $this->plugin_option_pref; ?>login_button_logout_value" value="<?php echo $this->options['login_button_logout_value']; ?>" size="30" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Redirect url after login',$this->plugin_text_domain); ?>. <?php _e('You can use pattern %BLOG_URL%. Default: current url',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_login_url" name="<?php echo $this->plugin_option_pref; ?>login_button_login_url" value="<?php echo $this->options['login_button_login_url']; ?>" size="30" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Redirect url after logout',$this->plugin_text_domain); ?>. <?php _e('You can use pattern %BLOG_URL%. Default: current url',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_logout_url" name="<?php echo $this->plugin_option_pref; ?>login_button_logout_url" value="<?php echo $this->options['login_button_logout_url']; ?>" size="30" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Button Image',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>login_button_image" name="<?php echo $this->plugin_option_pref; ?>login_button_image" value="<?php echo $this->options['login_button_image']; ?>" size="30" /><img id="<?php echo $this->plugin_option_pref; ?>login_button_upload_image" src="<?php echo $this->plugin_url_images; ?>upload_image.png" alt="<?php _e('Upload',$this->plugin_text_domain); ?>" class="AWD_button_media"/>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Custom Css',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_css'); ?></th>
								<td class="data">
									<textarea rows="10" class="uiTextarea" cols="35" id="<?php echo $this->plugin_option_pref; ?>login_button_css" name="<?php echo $this->plugin_option_pref; ?>login_button_css"><?php echo $this->options['login_button_css']; ?></textarea>
								</td>
							</tr>
							<tr class="dataRow">
								<td>&nbsp;</td>
							</tr>
							<tr class="dataRow">
								<th class="label" colspan="2"><h3 class="center"><?php _e('Preview',$this->plugin_text_domain);?></h3></th>
							</tr>
							<tr class="dataRow">
								<td class="data center" colspan="2">
									<?php 
									//echo the button or profile
									$fcbk_content = '';
									$fcbk_content = $this->get_the_login_button();
									echo $fcbk_content;
									?>										
									<br />
									<div class="awd_pre" style="text-align:left;">
										<strong>Shorcode: [AWD_loginbutton]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_loginbutton').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
										<br />
										<div id="egoptions_loginbutton"  class="hidden">
											Options:<br />
											* profile_picture (0 or 1)<br />
											* width (number)<br />
											* faces (0 or 1)<br />
											* maxrow (number)<br />
											* logout_value (string)<br />
											* logout_url (string)
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
					<?php
				}else{
					echo '<div class="ui-state-error">'.__('You must enable FB Connect and set parameters in settings of the plugins',$this->plugin_text_domain).'</div>';
				}
				?>
			</div>
			<?php
			/**
			* Comments settings
			*/
			?>
			<div id="comments_settings">
					<p><i><?php _e('All that settings are defaults, you can redefine them in shortcodes, and themes functions',$this->plugin_text_domain); ?></i></p>
					<p><i><?php _e('Note: Your themes must use the action "do_action("comment_form_after");" or the function "commnent_form();" to work. (look in your theme, in comments.php file)',$this->plugin_text_domain); ?></i></p>
					<div class="uiForm">
						<table class="AWD_form_table">
							<tr class="dataRow">
								<th class="label"><?php _e('URL to comment on',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_url'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>comments_url" name="<?php echo $this->plugin_option_pref; ?>comments_url" value="<?php echo $this->options['comments_url']; ?>" size="30" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php echo _e('Type',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_type'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_xfbml" name="<?php echo $this->plugin_option_pref; ?>comments_type" value="xfbml" <?php if($this->options['comments_type'] == 'xfbml') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>comments_xfbml"><?php echo __('XFBML',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_html5" name="<?php echo $this->plugin_option_pref; ?>comments_type" value="html5" <?php if($this->options['comments_type'] == 'html5') echo 'checked="checked"'; ?>  /> <label for="<?php echo $this->plugin_option_pref; ?>comments_html5"><?php echo __('HTML5',$this->plugin_text_domain);?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Number of posts',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_nb'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>comments_nb" name="<?php echo $this->plugin_option_pref; ?>comments_nb" value="<?php echo $this->options['comments_nb']; ?>" size="6" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Mobile version ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('comments_mobile'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_mobile_on" name="<?php echo $this->plugin_option_pref; ?>comments_mobile" value="1" <?php if($this->options['comments_mobile'] == '1') echo 'checked="checked"'; ?> /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_mobile_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_mobile_off" name="<?php echo $this->plugin_option_pref; ?>comments_mobile" value="0" <?php if($this->options['comments_mobile'] == '0') echo 'checked="checked"'; ?> /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_mobile_off"><?php _e('No',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Add Comments Box to pages',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_pages_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_pages" value="1" <?php if($this->options['comments_on_pages'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_pages').slideDown('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_pages_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_pages_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_pages" value="0" <?php if($this->options['comments_on_pages'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_pages').slideUp('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_pages_off"><?php _e('No',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Add Comments Box to posts',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_posts_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_posts" value="1" <?php if($this->options['comments_on_posts'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_posts').slideDown('fast');" /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_posts_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_posts_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_posts" value="0" <?php if($this->options['comments_on_posts'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_posts').slideUp('fast');" /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_posts_off"><?php _e('No',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Add Comments Box to custom post types',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_on" name="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types" value="1" <?php if($this->options['comments_on_custom_post_types'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_custom_post_types').slideDown('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_on"><?php _e('Yes',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_off" name="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types" value="0" <?php if($this->options['comments_on_custom_post_types'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_comments_custom_post_types').slideUp('fast');"/> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_on_custom_post_types_off"><?php _e('No',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Exclude Posts or Pages ID (example: 12,46,234)',$this->plugin_text_domain); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>comments_exclude_post_id" name="<?php echo $this->plugin_option_pref; ?>comments_exclude_post_id" value="<?php echo $this->options['comments_exclude_post_id']; ?>" size="30" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></th>
								<td class="data">
									<input type="text" class="uiTextbox" id="<?php echo $this->plugin_option_pref; ?>comments_width" name="<?php echo $this->plugin_option_pref; ?>comments_width" value="<?php echo $this->options['comments_width']; ?>" size="6" />
								</td>
							</tr>
							<tr class="dataRow">
								<th class="label"><?php _e('Color Scheme',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></th>
								<td class="data">
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_1" name="<?php echo $this->plugin_option_pref; ?>comments_colorscheme" value="light" <?php if($this->options['comments_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_1"><?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></label><br />
									<input type="radio" class="uiRadio" id="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_2" name="<?php echo $this->plugin_option_pref; ?>comments_colorscheme" value="dark" <?php if($this->options['comments_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <label class="up_label" for="<?php echo $this->plugin_option_pref; ?>comments_colorscheme_2"><?php _e('Dark',$this->plugin_text_domain); ?></label>
								</td>
							</tr>
							<tr class="dataRow">
								<td>&nbsp;</td>
							</tr>
							<tr class="dataRow">
								<th class="label" colspan="2"><h3 class="center"><?php _e('Preview',$this->plugin_text_domain);?></h3></th>
							</tr>
							<tr class="dataRow">
								<td class="data center" colspan="2">
									<?php 
									//echo the comments box
									$fcbk_content = '';
									$fcbk_content = $this->get_the_comments_box("",array("comments_width"=>"420"));
									echo $fcbk_content;
									?>										
									<br />
									<div class="awd_pre" style="text-align:left;">
										<strong>Shorcode: [AWD_comments]</strong> <a href="#" style="float:right;" onclick="jQuery('#egoptions_comments').toggle(300); return false;"><?php _e('-show options-',$this->plugin_text_domain); ?></a>
										<br />
										<div id="egoptions_comments"  class="hidden">
											Options:<br />
											* url (string)<br />
 											* nb (number)<br />
											* width (number)<br />
											* colorscheme (light or dark)<br />
											* mobile (light or dark)<br />
											* type (xfbml or html5)<br />
										</div>
									</div>
								</td>
							</tr>
						</table>
					</div>
			</div>
			
			<?php do_action("AWD_facebook_plugins_form"); ?>

			<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		</div>
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<div class="center">
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
		jQuery("#<?php echo $this->plugin_option_pref; ?>login_button_upload_image").click(function() {
			var formfield = jQuery("#<?php echo $this->plugin_option_pref; ?>login_button_image").attr('name');
			tb_show("<?php echo __('Button Image',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?type=image&amp;TB_iframe=true');
			
			window.send_to_editor = function(html) {
				var imgurl = jQuery('img',html).attr('src');
				jQuery("#<?php echo $this->plugin_option_pref; ?>login_button_image").val(imgurl);
				tb_remove();
			}
			return false;
		});

		jQuery('#submit_settings').click(function(){
			jQuery('#<?php echo $this->plugin_slug; ?>_form_settings').submit();
			jQuery("body").css("cursor", "progress");
			return false;
		});
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_on","#start_or_end_custom_post_types");
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_pages_on","#start_or_end_pages");
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_posts_on","#start_or_end_posts");
	});
</script>
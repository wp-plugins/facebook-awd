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
				<li><a href="#like_button_settings"><?php _e('Like Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#activity_settings"><?php _e('Activity Feed',$this->plugin_text_domain); ?></a></li>
				<li><a href="#login_button_settings"><?php _e('Login Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#like_box_settings"><?php _e('Like Box',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Comments',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Live Stream',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Recommendations',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Send Button',$this->plugin_text_domain); ?></a></li>
				<li><a href="#"><?php _e('Facepile',$this->plugin_text_domain); ?></a></li>
			</ul>
			<?php
			/**
			* Like button Settings
			*/
			?>
			<div id="like_button_settings">
				<div class="block_50">
					<p><i><?php _e('All that settings are defaults, you can redefine them in shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></i></p>
					<?php
					//if FB connect enable change the message
					if($this->plugin_option['parse_xfbml'] == 1){
						$label_xfbml = __('Iframe Or xfbml:',$this->plugin_text_domain);
					}else{
						$label_xfbml = sprintf(__('Iframe Or %sxfbml%s (%snot active%s):',$this->plugin_text_domain),'<s>','</s>','<i>','</i>');
					}
			
					?>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_url"><?php _e('Default Url to like',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_url'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_url" value="<?php echo $this->plugin_option['like_button_url']; ?>" size="30" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_xfbml"><?php echo $label_xfbml; ?> <?php echo $this->get_the_help('like_button_fbml'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_xfbml" value="1" <?php if($this->plugin_option['parse_xfbml'] == 0){ echo 'disabled="disabled"'; }elseif($this->plugin_option['like_button_xfbml'] == '1') echo 'checked="checked"'; ?>  /> <?php echo __('XFBML',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_xfbml" value="0" <?php if($this->plugin_option['like_button_xfbml'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_on_pages"><?php _e('Add "Like" button to pages',$this->plugin_text_domain); ?></label>
						<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_pages_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_pages" value="1" <?php if($this->plugin_option['like_button_on_pages'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_pages').slideDown('fast');"/> <?php _e('Yes',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_on_pages" value="0" <?php if($this->plugin_option['like_button_on_pages'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_pages').slideUp('fast');"/> <?php _e('No',$this->plugin_text_domain); ?>
					</p>
					<p id="start_or_end_pages" class="hidden_state">
						<label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="top" <?php if($this->plugin_option['like_button_place_on_pages'] == 'top') echo 'checked="checked"'; ?>  /> <?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="bottom" <?php if($this->plugin_option['like_button_place_on_pages'] == 'bottom') echo 'checked="checked"'; ?>  /> <?php _e('Bottom',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_pages" value="both" <?php if($this->plugin_option['like_button_place_on_pages'] == 'both') echo 'checked="checked"'; ?>  /> <?php _e('Both',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_on_posts"><?php _e('Add "Like" button to posts',$this->plugin_text_domain); ?></label>
						<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_posts_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_posts" value="1" <?php if($this->plugin_option['like_button_on_posts'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_posts').slideDown('fast');" /> <?php _e('Yes',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_on_posts" value="0" <?php if($this->plugin_option['like_button_on_posts'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_posts').slideUp('fast');" /> <?php _e('No',$this->plugin_text_domain); ?>
					</p>
					<p id="start_or_end_posts" class="hidden_state">
						<label for="<?php echo $this->plugin_option_pref; ?>plugin_option_like_button_place_on_posts"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="top" <?php if($this->plugin_option['like_button_place_on_posts'] == 'top') echo 'checked="checked"'; ?>/> <?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="bottom" <?php if($this->plugin_option['like_button_place_on_posts'] == 'bottom') echo 'checked="checked"'; ?>/> <?php _e('Bottom',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_posts" value="both" <?php if($this->plugin_option['like_button_place_on_posts'] == 'both') echo 'checked="checked"'; ?>/> <?php _e('Both',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types"><?php _e('Add "Like" button to custom post types',$this->plugin_text_domain); ?></label>
						<input type="radio" id="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_on" name="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types" value="1" <?php if($this->plugin_option['like_button_on_custom_post_types'] == '1') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_custom_post_types').slideDown('fast');"/> <?php _e('Yes',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types" value="0" <?php if($this->plugin_option['like_button_on_custom_post_types'] == '0') echo 'checked="checked"'; ?> onclick="jQuery('#start_or_end_custom_post_types').slideUp('fast');"/> <?php _e('No',$this->plugin_text_domain); ?>
					</p>
					<p id="start_or_end_custom_post_types" class="hidden_state">
						<label for="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types"><?php _e('Where do you want to place "Like" button ?',$this->plugin_text_domain); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="top" <?php if($this->plugin_option['like_button_place_on_custom_post_types'] == 'top') echo 'checked="checked"'; ?>  /> <?php echo __('Top',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="bottom" <?php if($this->plugin_option['like_button_place_on_custom_post_types'] == 'bottom') echo 'checked="checked"'; ?>  /> <?php _e('Bottom',$this->plugin_text_domain); ?>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_place_on_custom_post_types" value="both" <?php if($this->plugin_option['like_button_place_on_custom_post_types'] == 'both') echo 'checked="checked"'; ?>  /> <?php _e('Both',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_type"><?php _e('Exclude Post types (for custom post_type, example: post,page,etc...)',$this->plugin_text_domain); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_type" value="<?php echo $this->plugin_option['like_button_exclude_post_type']; ?>" size="30" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_exclude_terms_slug"><?php _e('Exclude Categories or other terms (slug or id example: photos,34,50)',$this->plugin_text_domain); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_terms_slug" value="<?php echo $this->plugin_option['like_button_exclude_terms_slug']; ?>" size="30" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_id"><?php _e('Exclude Posts or Pages ID (example: 12,46,234)',$this->plugin_text_domain); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_exclude_post_id" value="<?php echo $this->plugin_option['like_button_exclude_post_id']; ?>" size="30" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_send"><?php printf(__('Enable "Send" button ? %s(xfbml only)%s',$this->plugin_text_domain),'<i>','</i>'); ?> <?php echo $this->get_the_help('like_button_send'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_send" value="1" <?php if($this->plugin_option['like_button_xfbml'] == 0){ echo 'disabled="disabled"';}elseif($this->plugin_option['like_button_send'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_send" value="0" <?php if($this->plugin_option['like_button_send'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme"><?php _e('Colorscheme of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme" value="light" <?php if($this->plugin_option['like_button_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_colorscheme" value="dark" <?php if($this->plugin_option['like_button_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <?php _e('Dark',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_faces"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_faces" value="1" <?php if($this->plugin_option['like_button_faces'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_button_faces" value="0" <?php if($this->plugin_option['like_button_faces'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_width"><?php _e('Width of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_width" value="<?php echo $this->plugin_option['like_button_width']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_height"><?php _e('Height of button (only for iframe)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_button_height" <?php if($this->plugin_option['like_button_xfbml'] == 1){ echo 'disabled="disabled"'; } ?> value="<?php echo $this->plugin_option['like_button_height']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_fonts"><?php _e('Fonts of button',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_fonts'); ?></label>
						<select name="<?php echo $this->plugin_option_pref; ?>like_button_fonts">
							<option value="arial" <?php if($this->plugin_option['like_button_fonts'] == "arial") echo 'selected="selected"'; ?> >Arial</option>
							<option value="lucida grande" <?php if($this->plugin_option['like_button_fonts'] == "lucida grande") echo 'selected="selected"'; ?> >Lucida grande</option>
							<option value="segoe ui" <?php if($this->plugin_option['like_button_fonts'] == "segoe ui") echo 'selected="selected"'; ?> >Segoe ui</option>
							<option value="tahoma" <?php if($this->plugin_option['like_button_fonts'] == "tahoma") echo 'selected="checked"'; ?> >Tahoma</option>
							<option value="trebuchet ms" <?php if($this->plugin_option['like_button_fonts'] == "trebuchet ms") echo 'selected="selected"'; ?> >Trebuchet ms</option>
							<option value="verdana" <?php if($this->plugin_option['like_button_fonts'] == "verdana") echo 'selected="selected"'; ?> >Verdana</option>
						</select>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_action"><?php _e('Action',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_action'); ?></label>
						<select name="<?php echo $this->plugin_option_pref; ?>like_button_action">
							<option value="like" <?php if($this->plugin_option['like_button_action'] == "like") echo 'selected="selected"'; ?> ><?php echo __("Like",$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></option>
							<option value="recommend" <?php if($this->plugin_option['like_button_action'] == "recommend") echo 'selected="selected"'; ?> ><?php echo __("Recommend",$this->plugin_text_domain); ?></option>
						</select>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_button_layout"><?php _e('Layout style',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_layout'); ?></label>
						<select name="<?php echo $this->plugin_option_pref; ?>like_button_layout">
							<option value="standard" <?php if($this->plugin_option['like_button_layout'] == "standard") echo 'selected="selected"'; ?> ><?php echo __("Standard",$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?></option>
							<option value="button_count" <?php if($this->plugin_option['like_button_layout'] == "button_count") echo 'selected="selected"'; ?> ><?php echo __("Button Count",$this->plugin_text_domain); ?></option>
							<option value="box_count" <?php if($this->plugin_option['like_button_layout'] == "box_count") echo 'selected="selected"'; ?> ><?php echo __("Box Count",$this->plugin_text_domain); ?></option>
						</select>
					</p>
					
				</div>
				<div class="block_50">
					<div id="#preview_like_button" class="awd_preview" style="text-align:center;">
						<h2><?php _e('Preview',$this->plugin_text_domain);?></h2>
						<?php echo $this->get_the_like_button(); ?>
					</div>

				
				
				</div>
				<div class="clear"></div>
			</div>
			<?php
			/**
			* Like box settings
			*/
			?>
			<div id="like_box_settings">
				<div class="block_50">
			    	<p><i><?php _e('The like box is added via shortcodes, widgets, and themes functions',$this->plugin_text_domain); ?></i></p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_xfbml"><?php echo '<br />'.$label_xfbml; ?> <?php echo $this->get_the_help('like_button_fbml'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_xfbml" value="1" <?php if($this->plugin_option['parse_xfbml'] == 0){ echo 'disabled="disabled"'; }elseif($this->plugin_option['like_box_xfbml'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('XFBML',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_xfbml" value="0" <?php if($this->plugin_option['like_box_xfbml'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('IFRAME',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_url"><?php _e('Url of the page',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_url'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_box_url" value="<?php echo $this->plugin_option['like_box_url']; ?>" size="30"/>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme"><?php _e('Colorscheme of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme" value="light" <?php if($this->plugin_option['like_box_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_colorscheme" value="dark" <?php if($this->plugin_option['like_box_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <?php _e('Dark',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_width"><?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_box_width" value="<?php echo $this->plugin_option['like_box_width']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_height"><?php _e('Height of box (only for iframe)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>like_box_height" <?php if($this->plugin_option['like_box_xfbml'] == 1){ echo 'disabled="disabled"'; } ?> value="<?php echo $this->plugin_option['like_box_height']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_faces"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_faces" value="1" <?php if($this->plugin_option['like_box_faces'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_faces" value="0" <?php if($this->plugin_option['like_box_faces'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_stream"><?php _e('Show Stream ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_box_stream'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_stream" value="1" <?php if($this->plugin_option['like_box_stream'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_stream" value="0" <?php if($this->plugin_option['like_box_stream'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>like_box_header"><?php _e('Show Header ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('show_header'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_header" value="1" <?php if($this->plugin_option['like_box_header'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>like_box_header" value="0" <?php if($this->plugin_option['like_box_header'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
				</div>
				<div class="block_50">
					<div id="#preview_like_box" class="awd_preview" style="text-align:center;">
						<h2><?php _e('Preview',$this->plugin_text_domain);?></h2>
						<?php echo $this->get_the_like_box(); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div id="activity_settings">
				<div class="block_50">
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_domain"><?php _e('Domain',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_domain'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>activity_domain" value="<?php echo $this->plugin_option['activity_domain']; ?>" size="30"/>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_width"><?php _e('Width of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_width'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>activity_width" value="<?php echo $this->plugin_option['activity_width']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_height"><?php _e('Height of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_height'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>activity_height" value="<?php echo $this->plugin_option['activity_height']; ?>" size="6" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_header"><?php _e('Show Header ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('show_header'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="1" <?php if($this->plugin_option['activity_header'] == '1') echo 'checked="checked"'; ?>  /> <?php echo __('Yes',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain);  ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_header" value="0" <?php if($this->plugin_option['activity_header'] == '0') echo 'checked="checked"'; ?>  /> <?php echo _e('No',$this->plugin_text_domain);?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_colorscheme"><?php _e('Colorscheme of box',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_colorscheme'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="light" <?php if($this->plugin_option['activity_colorscheme'] == 'light') echo 'checked="checked"'; ?>  /> <?php echo __('Light',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_colorscheme" value="dark" <?php if($this->plugin_option['activity_colorscheme'] == 'dark') echo 'checked="checked"'; ?>  /> <?php _e('Dark',$this->plugin_text_domain); ?>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_fonts"><?php _e('Font',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_fonts'); ?></label>
						<select name="<?php echo $this->plugin_option_pref; ?>activity_fonts">
							<option value="arial" <?php if($this->plugin_option['activity_fonts'] == "arial") echo 'selected="selected"'; ?> >Arial</option>
							<option value="lucida grande" <?php if($this->plugin_option['activity_fonts'] == "lucida grande") echo 'selected="selected"'; ?> >Lucida grande</option>
							<option value="segoe ui" <?php if($this->plugin_option['activity_fonts'] == "segoe ui") echo 'selected="selected"'; ?> >Segoe ui</option>
							<option value="tahoma" <?php if($this->plugin_option['activity_fonts'] == "tahoma") echo 'selected="checked"'; ?> >Tahoma</option>
							<option value="trebuchet ms" <?php if($this->plugin_option['activity_fonts'] == "trebuchet ms") echo 'selected="selected"'; ?> >Trebuchet ms</option>
							<option value="verdana" <?php if($this->plugin_option['activity_fonts'] == "verdana") echo 'selected="selected"'; ?> >Verdana</option>
						</select>
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_border_color"><?php _e('Border color',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_border'); ?></label>
						<input type="text" name="<?php echo $this->plugin_option_pref; ?>activity_border_color" value="<?php echo $this->plugin_option['activity_border_color']; ?>" size="10" />
					</p>
					<p>
						<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>activity_recommendations"><?php _e('Show Recommendations ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('activity_recommendation'); ?></label>
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="1" <?php if($this->plugin_option['activity_recommendations'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
						<input type="radio" name="<?php echo $this->plugin_option_pref; ?>activity_recommendations" value="0" <?php if($this->plugin_option['activity_recommendations'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
					</p>
				</div>
				<div class="block_50">
					<div id="#preview_activity" class="awd_preview" style="text-align:center;">
						<h2><?php _e('Preview',$this->plugin_text_domain);?></h2>
						<?php echo $this->get_the_activity_box(); ?>
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<?php
			/**
			* login button settings
			*/
			?>
			<div id="login_button_settings">
				<?php
				//if FB connect enable
				if($this->plugin_option['connect_enable'] == 1){
					//if FB parse xfbml
					if($this->plugin_option['parse_xfbml'] == 1){
					?>
						<div class="block_50">
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_faces"><?php _e('Show Faces ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('like_button_faces'); ?></label>
								<input type="radio" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="1" <?php if($this->plugin_option['login_button_faces'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
								<input type="radio" name="<?php echo $this->plugin_option_pref; ?>login_button_faces" value="0" <?php if($this->plugin_option['login_button_faces'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
							</p>
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture"><?php _e('Show Profile picture ?',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_profile_picture'); ?></label>
								<input type="radio" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="1" <?php if($this->plugin_option['login_button_profile_picture'] == '1') echo 'checked="checked"'; ?>  /> <?php _e('Yes',$this->plugin_text_domain); ?> 
								<input type="radio" name="<?php echo $this->plugin_option_pref; ?>login_button_profile_picture" value="0" <?php if($this->plugin_option['login_button_profile_picture'] == '0') echo 'checked="checked"'; ?>  /> <?php echo __('No',$this->plugin_text_domain).' '.__('(default)',$this->plugin_text_domain); ?>
							</p>
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_width"><?php _e('Width of button',$this->plugin_text_domain); ?>  <?php echo $this->get_the_help('like_button_width'); ?></label>
								<input type="text" name="<?php echo $this->plugin_option_pref; ?>login_button_width" value="<?php echo $this->plugin_option['login_button_width']; ?>" size="6" />
							</p>
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_maxrow"><?php _e('Max Rows (faces)',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_maxrow'); ?></label>
								<input type="text" name="<?php echo $this->plugin_option_pref; ?>login_button_maxrow" value="<?php echo $this->plugin_option['login_button_maxrow']; ?>" size="6" />
							</p>
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_logout_value"><?php _e('Logout Phrase',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_logout'); ?></label>
								<input type="text" name="<?php echo $this->plugin_option_pref; ?>login_button_logout_value" value="<?php echo $this->plugin_option['login_button_logout_value']; ?>" size="30" />
							</p>
							<p>
								<label class="up_label" for="<?php echo $this->plugin_option_pref; ?>login_button_css"><?php _e('Custom Css',$this->plugin_text_domain); ?> <?php echo $this->get_the_help('login_button_css'); ?></label>
								<textarea rows="10" cols="35" name="<?php echo $this->plugin_option_pref; ?>login_button_css"><?php echo $this->plugin_option['login_button_css']; ?></textarea>
							</p>
						</div>
						<div class="block_50">
							<div id="#preview_login_button" class="awd_preview">
								<h2 style="text-align:center;"><?php _e('Preview',$this->plugin_text_domain);?></h2>
								<?php 
								//echo the button or profile
								$fcbk_content = $this->get_the_login_button();
								echo $fcbk_content;
								//echo the code for custom css
								echo '<br /><hr /><h2>'.__("Code html to help in css",$this->plugin_text_domain).'</h2><div class="awd_pre left">'.str_replace("/n","<br />",htmlentities($fcbk_content)).'</div>';
								?>
							</div>
						</div>
						<div class="clear"></div>
					<?php
					}else{
						echo '<div class="ui-state-error">'.__('You must enable XFBML parsing, in settings of the plugin',$this->plugin_text_domain).'</div>';
	
					}
				}else{
					echo '<div class="ui-state-error">'.__('You must enable FB Connect and set parameters in settings of the plugins',$this->plugin_text_domain).'</div>';
				}
				?>
			</div>
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
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_pages_on","#start_or_end_pages");
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_posts_on","#start_or_end_posts");
		hide_state("#<?php echo $this->plugin_option_pref; ?>like_button_on_custom_post_types_on","#start_or_end_custom_post_types");
	});
</script>
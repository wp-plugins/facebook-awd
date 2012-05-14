<?php
$prefix = $this->plugin_option_pref.'ogtags_';
if(is_array($metabox)){
	if(is_array($metabox['args'])){
		$prefix = $metabox['args']['prefix'];
		//custom is the name of the array of option
		$customTemp = $metabox['args']['custom'];
		$custom = $this->options[$customTemp];
		//reconstruct the arry to be compatible with this function and args metabox
		if($customTemp){
			foreach($this->options as $option=>$value)
				if(preg_match('@'.$customTemp.'@',$option))
					$custom[str_ireplace($customTemp.'_',"",$prefix).$option][0] = $value;
		}
		//use h4 or other
		$custom_header = $metabox['args']['header'];
		$custom_help = $metabox['args']['help'];
	}
}

if($custom_header =='')
	$custom_header ='h4';
if(is_object($post))
	$custom = get_post_custom($post->ID);
elseif(!$custom)
	$custom = array();
?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$("#<?php echo $prefix.'disable_off';?>").click(function(){
			$(".ui_ogtags_allform<?php echo $customTemp;?>").slideDown();
		});
		$("#<?php echo $prefix.'disable_on';?>").click(function(){
			$(".ui_ogtags_allform<?php echo $customTemp;?>").slideUp();
		});
		$("#<?php echo $prefix.'redefine_on';?>").click(function(){
			$(".ui_ogtags_form<?php echo $customTemp;?>").slideDown();
		});
		$("#<?php echo $prefix.'redefine_off';?>").click(function(){
			$(".ui_ogtags_form<?php echo $customTemp;?>").slideUp();
		});
	});
</script>
<p>
	<?php 
	//if post or global form
	if(is_object($post)){ ?>
		<label class="up_label"><?php _e('Disable Tags for this page ?',$this->plugin_text_domain); ?></label>
		<?php 
	}else{
		?>
		<label class="up_label"><?php _e('Disable Tags for this type ? ',$this->plugin_text_domain); ?> <i><?php _e('You can override settings on each page individually',$this->plugin_text_domain); ?></i></label>
		<?php
	}
	?>
	<input type="radio" name="<?php echo $prefix.'disable';?>" <?php if($custom[$prefix.'disable'][0] == 1 OR ($custom[$prefix.'disable'][0] == '' && !is_object($post))){echo 'checked="checked"';} ?> id="<?php echo $prefix.'disable_on';?>" value="1"/> <?php _e('Yes',$this->plugin_text_domain); ?>
	<input type="radio" name="<?php echo $prefix.'disable';?>" <?php if($custom[$prefix.'disable'][0] == "0" OR (is_object($post) && $custom[$prefix.'disable'][0]=='')){echo 'checked="checked"';} ?> id="<?php echo $prefix.'disable_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
</p>
<div class="ui_ogtags_allform<?php echo $customTemp; ?> <?php if($custom[$prefix.'disable'][0] == 1 OR ($custom[$prefix.'disable'][0] == '' && !is_object($post))){echo 'hidden';} ?>">
<?php 
//if post or global form
if(is_object($post)){ ?>	
<p>
	<label class="up_label"><?php _e('Redefine Tags for this page ?',$this->plugin_text_domain); ?></label>
	<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 1){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_on';?>" value="1"/> <?php _e('Yes',$this->plugin_text_domain); ?>
	<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 0){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
</p>
<?php }	?>
<div class="ui_ogtags_form ui_ogtags_form<?php echo $customTemp; ?> <?php if($custom[$prefix.'redefine'][0]!= 1 && is_object($post)){echo 'hidden';} ?>">
	<?php echo $this->get_the_help_box($custom_help); ?>
	<<?php echo $custom_header; ?>><a href="#"><?php _e('Tags',$this->plugin_text_domain); ?></a></<?php echo $custom_header; ?>>
	<div>
	<div class="uiForm">
		<table class="AWD_form_table">
		<?php
		$this->og_tags = apply_filters('AWD_facebook_og_tags', $this->og_tags);
		foreach($this->og_tags as $tag=>$tag_infos){
			$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix);	
			if($tag_infos['name']){
				?>
				<tr class="dataRow">
					<th class="label"><?php echo $tag_infos['name']; ?></th>
					<td class="data">
						<?php echo $input; ?>
					</td>
				</tr>
				<?php
			}
		}
		?>
		</table>
	</div>
	</div>
	<?php
	$this->og_attachement_field = apply_filters('AWD_facebook_og_attachement_fields', $this->og_attachement_field);
	foreach($this->og_attachement_field as $type=>$tag_fields){
		switch($type){
			//video form
			case 'video':
				echo '<'.$custom_header.'><a href="#">'.__('Video Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
				echo '
				<div>
				<i>'.__('Facebook supports embedding video in SWF format only. File ith extension ".swf"',$this->plugin_text_domain).'</i>
				<div class="uiForm">
					<div id="'.$prefix.'message_video" class="ui-state-highlight hidden">'.__('You must include a valid Image for your video in Tags section to be displayed in the news feed.',$this->plugin_text_domain).'</div>
					<table class="AWD_form_table">';
					foreach($tag_fields as $tag=>$tag_infos){
						$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix);	
						if($tag != 'video:type' && $tag != 'video:type_html' && $tag != 'video:type_mp4'):
						?>
						<tr class="dataRow">
							<th class="label"><?php echo $tag_infos['name']; ?></th>
							<td class="data">
								<?php echo $input; ?>
							</td>
						</tr>
						<?php
						endif;
					}
				echo '</table>
				</div>
				</div>';
			break;
			//audio form
			case 'audio':
				echo '<'.$custom_header.'><a href="#">'.__('Audio Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
				echo '
				<div>
					<i>'.__('In a similar fashion to Video you can add an audio file to your markup',$this->plugin_text_domain).'</i>
					<div class="uiForm">
						<table class="AWD_form_table">';
						foreach($tag_fields as $tag=>$tag_infos){
							$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix);
							if($tag != 'audio:type'){ 
								?>
								<tr class="dataRow">
									<th class="label"><?php echo $tag_infos['name']; ?></th>
									<td class="data">
										<?php echo $input; ?>
									</td>
								</tr>
								<?php 
							}
						}
				echo '</table>
				</div>
				</div>';
			break;
			//isbn and upc code
			case 'isbn':
			case 'upc':
				foreach($tag_fields as $tag=>$tag_name){
					$prefixtag = $prefix.$tag;
					$custom_value = $custom[$prefixtag][0];
					echo '<'.$custom_header.'><a href="#">'.strtoupper($type).' '.__('code',$this->plugin_text_domain).'</a></'.$custom_header.'>';
					echo '
					<div>
					<div class="uiForm">
						<table class="AWD_form_table">
							<tr class="dataRow">
								<th class="label">'.__('For products which have a UPC code or ISBN number',$this->plugin_text_domain).'</th>
								<td class="data"><input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /></td>
							</tr>
						</table>
					</div>
					</div>';
				}
			break;
			//contact form
			case 'contact':
				echo '<'.$custom_header.'><a href="#">'.__('Contact infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
				echo '<div>';
					echo '<i>'.__('Consider including contact information if your page is about an entity that can be contacted.',$this->plugin_text_domain).'</i>
					<div class="uiForm">
						<table class="AWD_form_table">';
						foreach($tag_fields as $tag=>$tag_infos){
							$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix); 
							?>
							<tr class="dataRow">
								<th class="label"><?php echo $tag_infos['name']; ?></th>
								<td class="data">
									<?php echo $input; ?>
								</td>
							</tr>
							<?php
						}
				echo '</table>
				</div>
				</div>';
			break;
			//location form
			case 'location':
				echo '<'.$custom_header.'><a href="#">'.__('Location infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
				echo '<div>';
					echo '<i>'.__('This is useful if your pages is a business profile or about anything else with a real-world location. You can specify location via latitude and longitude, a full address, or both.',$this->plugin_text_domain).'</i>
					<div class="uiForm">
						<table class="AWD_form_table">';
						foreach($tag_fields as $tag=>$tag_infos){
							$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix);
							?>
							<tr class="dataRow">
								<th class="label"><?php echo $tag_infos['name']; ?></th>
								<td class="data">
									<?php echo $input; ?>
								</td>
							</tr>
							<?php
						}
				echo '</table>
				</div>
				</div>';
			break;
			
		}
	}
	$this->og_custom_fields = apply_filters('AWD_facebook_og_custom_fields', $this->og_custom_fields);
	foreach($this->og_custom_fields as $type=>$tag_fields){
		echo '<'.$custom_header.'><a href="#">'.__('Customs fields',$this->plugin_text_domain).'</a></'.$custom_header.'>
		<div>
			<div class="uiForm">';
			if(count($tag_fields)){
				echo '<table class="AWD_form_table">';
				foreach($tag_fields as $tag=>$tag_infos){
					$input = $this->get_input_html_from_type($tag_infos['type'], $tag, $custom, $prefix); 
					?>
					<tr class="dataRow">
						<th class="label"><?php echo $tag_infos['name']; ?></th>
						<td class="data">
							<?php echo $input; ?>
						</td>
					</tr>
					<?php
				}
				echo '</table>';
			}else{
				echo "<p><i>".__('Learn more how to add custom fields for openGraph',$this->plugin_text_domain)."</i></p>";
			}
			echo'
			</div>
		</div>';
	}
	?>
	</div>
</div>
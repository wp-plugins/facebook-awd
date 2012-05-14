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
	<form method="POST" action="" id="<?php echo $this->plugin_slug; ?>_form_opg">
		<div id="div_options_content_tabs">
			<ul class="tabs_ul">
				<li><a href="#ogtags_frontpage"><?php _e('Frontpage',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_pages"><?php _e('Pages',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_posts"><?php _e('Posts',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_archives"><?php _e('Archives',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_author"><?php _e('Authors',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_custom_posts"><?php _e('Custom Post types (Advanced)',$this->plugin_text_domain); ?></a></li>
				<li><a href="#ogtags_taxonomies"><?php _e('Taxonomies (Advanced)',$this->plugin_text_domain); ?></a></li>
			</ul>
			<?php
			/**
			* Open graph settings
			*/
			?>
			<div id="ogtags_frontpage">
				<?php 
				$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_frontpage_';
				//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
				$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
				$meta['args']['help'] = 'frontpage';
				$this->open_graph_post_metas_form('',$meta);
				?>
			</div>
			<?php
			/**
			* Open graph pages settings
			*/
			?>
			<div id="ogtags_pages">
				<?php 
				$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_page_';
				//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
				$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
				$meta['args']['help'] = 'page';
				$this->open_graph_post_metas_form('',$meta);
				?>
			</div>
			<?php
			/**
			* Open graph posts settings
			*/
			?>
			<div id="ogtags_posts">
				<?php 
				$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_post_';
				//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
				$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
				$meta['args']['help'] = 'post';
				$this->open_graph_post_metas_form('',$meta);
				?>
			</div>
			<?php
			/**
			* Open graph posts settings
			*/
			?>
			<div id="ogtags_archives">
				<?php 
				$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_archive_';
				//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
				$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
				$meta['args']['help'] = 'archive';
				$this->open_graph_post_metas_form('',$meta);
				?>
			</div>
			<?php
			/**
			* Open graph Author settings
			*/
			?>
			<div id="ogtags_author">
				<?php 
				$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_author_';
				//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
				$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
				$meta['args']['help'] = 'author';
				$this->open_graph_post_metas_form('',$meta);
				?>
			</div>
			<?php
			/**
			* Open graph custom posts settings
			*/
			$postypes_media = get_post_types(array('label'=>'Media'),'objects');
			$postypes = get_post_types(array('show_ui'=>true),'objects');
			//if find attachement
			if(is_object($postypes_media['attachment']))
					$postypes['attachment'] = $postypes_media['attachment'];
							//remove page and post form custom
			unset($postypes['post']);
			unset($postypes['page']);
			?>
			<div id="ogtags_custom_posts">
				<?php 
				if(!empty($postypes)){
					foreach($postypes as $postypes_name=>$type_values){
						$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_custom_post_types_'.$postypes_name.'_';
						//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
						$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
						$meta['args']['help'] = 'custom_post_types';
						//to not call the accordion ui jquery
						$meta['args']['header'] = 'h3 class="tabs_in_tab"';
						echo '<h4><a href="#">'.$type_values->label.' ('.$type_values->name.')</a></h4>';
						echo '<div>';
							$this->open_graph_post_metas_form('',$meta);
						echo '</div>';
					}
				}else{
					echo '<div class="ui-state-highlight AWD_message"><p>'.__('There is no custom post types',$this->plugin_text_domain).'</p></div>';
				}
				?>
			</div>
			<?php
			/**
			* Open graph custom posts settings
			*/
			$taxonomies = get_taxonomies(array('public'=> true,'show_ui'=>true),'objects');
			?>
			<div id="ogtags_taxonomies">
				<?php 
				if(!empty($taxonomies)){
					foreach($taxonomies as $taxonomie_name=>$tax_values){
						$meta['args']['prefix'] = $this->plugin_option_pref.'ogtags_taxonomies_'.$taxonomie_name.'_';
						//we have to construct the array correctly for this function work in post and admin plugin (compatibylity)
						$meta['args']['custom'] = rtrim(str_replace($this->plugin_option_pref,"",$meta['args']['prefix']),'_');
						$meta['args']['help'] = 'taxonomies';
						//to not call the accordion ui jquery
						$meta['args']['header'] = 'h3 class="tabs_in_tab"';
						echo '<h4><a href="#">'.$tax_values->label.' ('.$tax_values->name.')</a></h4>';
						echo '<div>';
							$this->open_graph_post_metas_form('',$meta);
						echo '</div>';
					}
				}else{
					echo '<div class="ui-state-highlight AWD_message"><p>'.__('There is no Taxonomies',$this->plugin_text_domain).'</p></div>';
				}
				?>
			</div>

			
		</div><?php //tabs ?>	
		<br />
		<?php wp_nonce_field($this->plugin_slug.'_update_options',$this->plugin_option_pref.'_nonce_options_update_field'); ?>
		<br />
		<div class="center">
			<a href="#" id="submit_opg" class="uiButton uiButtonSubmit"><?php _e('Save all settings',$this->plugin_text_domain); ?></a>
		</div>
	</form>
</div>
<?php
/*
* Javascript for admin
*/
?>
<script type="text/javascript">
	jQuery(document).ready( function(){
		jQuery('#submit_opg').click(function(){
			jQuery('#<?php echo $this->plugin_slug; ?>_form_opg').submit();
			jQuery("body").css("cursor", "progress");
			return false;
		});
	});
</script>
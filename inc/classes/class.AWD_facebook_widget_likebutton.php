<?php
/*
*
* WIDGET LIKE BUTTON AWD Facebook
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
class AWD_facebook_widget_likebutton extends WP_Widget {

	/*
	 * Init widget
	 */
	function AWD_facebook_widget_likebutton(){
		//globalise plugin object
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
		//load translation fro widgets
		load_plugin_textdomain($this->AWD_facebook->plugin_text_domain,false,dirname(dirname( plugin_basename( __FILE__ ) ) ) . '/langs/');

		$like_button_widjet_info = array('description' => __('Add a Facebook Like Button. Customise the code, or use predefined Like button in settings',$this->AWD_facebook->plugin_text_domain));
        parent::WP_Widget(false, $name=__('Facebook Like Button',$this->AWD_facebook->plugin_text_domain) , $like_button_widjet_info);	
    }
    /*
	 * form admin widget
	 */
	function form($instance) {
		$title = esc_attr($instance['like_button_title']);
		
		//define settings to defaults, if empty only...
		$like_button['like_button_url'] = (esc_attr($instance['like_button_url']) == '' ? $this->AWD_facebook->options['like_button_url'] : $instance['like_button_url']);
		$like_button['like_button_colorscheme'] = (esc_attr($instance['like_button_colorscheme']) == '' ? $this->options['like_button_url'] : $instance['like_button_colorscheme']);
		$like_button['like_button_width'] =(esc_attr($instance['like_button_width']) == '' ? $this->AWD_facebook->options['like_button_width'] : $instance['like_button_width']);
		$like_button['like_button_height'] = (esc_attr($instance['like_button_height']) == '' ? $this->AWD_facebook->options['like_button_height'] : $instance['like_button_height']);
		$like_button['like_button_faces'] = (esc_attr($instance['like_button_faces']) == '' ? $this->AWD_facebook->options['like_button_faces'] : $instance['like_button_faces']);
		$like_button['like_button_send'] = (esc_attr($instance['like_button_send']) == '' ? $this->AWD_facebook->options['like_button_send'] : $instance['like_button_send']);
		$like_button['like_button_font'] = (esc_attr($instance['like_button_font']) == '' ? $this->AWD_facebook->options['like_button_font'] : $instance['like_button_font']);
		$like_button['like_button_type'] = (esc_attr($instance['like_button_type']) == '' ? $this->AWD_facebook->options['like_button_type'] : $instance['like_button_type']);
		$like_button['like_button_ref'] = (esc_attr($instance['like_button_ref']) == '' ? $this->AWD_facebook->options['like_button_ref'] : $instance['like_button_ref']);
		$like_button['like_button_action'] = (esc_attr($instance['like_button_action']) == '' ? $this->AWD_facebook->options['like_button_action'] : $instance['like_button_action']);
		$like_button['like_button_content'] = (esc_attr($instance['like_button_content']) == '' ? $this->AWD_facebook->options['like_button_content'] : $instance['like_button_content']);
		$like_button['like_button_use_content'] = (esc_attr($instance['like_button_use_content']) == '' ? 0 : $instance['like_button_use_content']);
		$like_button['like_button_layout'] = (esc_attr($instance['like_button_layout']) == '' ? 0 : $instance['like_button_layout']);
	
	    echo '<h2 style="text-align:center;color:#04ADD1;border:1px solid #ccc; padding:5px;"><img style="vertical-align:middle;" src="'.$this->AWD_facebook->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.__('Facebook Like Button',$this->AWD_facebook->plugin_text_domain).'</h2><br />
		<p>
			<label for="'.$this->get_field_id('like_button_title').'">'.__('Title',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('like_button_title').'" name="'.$this->get_field_name('like_button_title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_type').'">'.__('Type:',$this->AWD_facebook->plugin_text_domain);
		echo ' 
				<select class="widefat" id="'.$this->get_field_id('like_button_type').'" name="'.$this->get_field_name('like_button_type').'">
					<option value="xfbml" '.($like_button['like_button_type'] == 'xfbml' ? 'selected="selected"':'').'>'.__('XFBML',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="iframe" '.($like_button['like_button_type'] == 'iframe' ? 'selected="selected"':'').'>'.__('IFRAME',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="html5" '.($like_button['like_button_type'] == 'html5' ? 'selected="selected"':'').'>'.__('HTML5',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_url').'">'.__('Url of the page',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('like_button_url').'" name="'.$this->get_field_name('like_button_url').'" type="text" value="'.$like_button['like_button_url'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_ref').'">'.__('Ref',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('like_button_ref').'" name="'.$this->get_field_name('like_button_ref').'" type="text" value="'.$like_button['like_button_ref'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_layout').'">'.__('Layout style',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_button_layout').'" name="'.$this->get_field_name('like_button_layout').'">
					<option value="standard" '.($like_button['like_button_layout'] == 'standard' ? 'selected="selected"':'').'>'.__('Standard',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="button_count" '.($like_button['like_button_layout'] == 'button_count' ? 'selected="selected"':'').'>'.__('Button Count',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="box_count" '.($like_button['like_button_layout'] == 'box_count' ? 'selected="selected"':'').'>'.__('Box Count',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_colorscheme').'">'.__('Colorscheme of button',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_button_colorscheme').'" name="'.$this->get_field_name('like_button_colorscheme').'">
					<option value="light" '.($like_button['like_button_colorscheme'] == 'light' ? 'selected="selected"':'').'>'.__('Light',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="dark" '.($like_button['like_button_colorscheme'] == 'dark' ? 'selected="selected"':'').'>'.__('Dark',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_width').'">'.__('Width of button',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('like_button_width').'" name="'.$this->get_field_name('like_button_width').'" type="text" value="'.$like_button['like_button_width'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_height').'">'.__('Height of button (only for iframe)',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('like_button_height').'" name="'.$this->get_field_name('like_button_height').'"  '.($this->AWD_facebook->options['like_button_xfbml'] == 1 ? 'disabled="disabled"' : '').' type="text" value="'.$like_button['like_button_height'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_faces').'">'.__('Show Faces ?',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_button_faces').'" name="'.$this->get_field_name('like_button_faces').'">
					<option value="1" '.($like_button['like_button_faces'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_button['like_button_faces'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_send').'">'.sprintf(__('Enable "Send" button ? %s(xfbml only)%s',$this->AWD_facebook->plugin_text_domain),'<i>','</i>').' 
				<select class="widefat" id="'.$this->get_field_id('like_button_send').'" name="'.$this->get_field_name('like_button_send').'">
					<option value="1" '.($this->AWD_facebook->options['like_button_xfbml'] == 0 ? 'disabled="disabled"' : '').' '.($like_button['like_button_send'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_button['like_button_send'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_action').'">'.__('Action',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('faces').'" name="'.$this->get_field_name('like_button_action').'">
					<option value="like" '.($like_button['like_button_action'] == 'like' ? 'selected="selected"':'').'>'.__('Like',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="recommend" '.($like_button['like_button_action'] == 'recommend' ? 'selected="selected"':'').'>'.__('Recommend',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_font').'">'.__('Font',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_button_font').'" name="'.$this->get_field_name('like_button_font').'">
					<option value="arial" '.($activity['like_button_font'] == "arial" ? 'selected="selected"' :'').' >Arial</option>
					<option value="lucida grande" '.($activity['like_button_font'] == "lucida grande" ? 'selected="selected"' :'').' >Lucida grande</option>
					<option value="segoe ui" '.($activity['like_button_font'] == "segoe ui" ? 'selected="selected"' :'').' >Segoe ui</option>
					<option value="tahoma" '.($activity['like_button_font'] == "tahoma" ? 'selected="selected"' :'').' >Tahoma</option>
					<option value="trebuchet ms" '.($activity['like_button_font'] == "trebuchet ms" ? 'selected="selected"' :'').' >Trebuchet ms</option>
					<option value="verdana" '.($activity['like_button_font'] == "verdana" ? 'selected="selected"' :'').' >Verdana</option>
				</select>
			</label>
		</p>';
		
		
		
		echo '<h2 style="text-align:center;font-weight:bold;">'.__('OR',$this->AWD_facebook->plugin_text_domain).'</h2>';
		echo '
		<p>
			<label for="'.$this->get_field_id('like_button_content').'">
			<input type="checkbox" '.($like_button['like_button_use_content'] == '1' ? 'checked="checked"':'').' value="1" id="'.$this->get_field_id('like_button_use_content').'" name="'.$this->get_field_name('like_button_use_content').'" /> '.__('Use code instead settings ?',$this->AWD_facebook->plugin_text_domain).'
			'.__('Paste',$this->AWD_facebook->plugin_text_domain).' '.$label.'<br />'.__('if you paste code, settings will be ignored',$this->AWD_facebook->plugin_text_domain).'
			<textarea rows="12" class="widefat" id="'.$this->get_field_id('like_button_content').'" name="'.$this->get_field_name('like_button_content').'">'.$like_button['like_button_content'].'</textarea>
			</label>
		</p>
		';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['like_button_url'] = stripslashes($new_instance['like_button_url']);
		$instance['like_button_title'] = strip_tags($new_instance['like_button_title']);
		$instance['like_button_colorscheme'] = $new_instance['like_button_colorscheme'];
		$instance['like_button_width'] = stripslashes($new_instance['like_button_width']);
		$instance['like_button_height'] = stripslashes($new_instance['like_button_height']);
		$instance['like_button_faces'] = $new_instance['like_button_faces'];
		$instance['like_button_font'] = $new_instance['like_button_font'];
		$instance['like_button_ref'] = $new_instance['like_button_ref'];
		$instance['like_button_type'] = $new_instance['like_button_type'];
		$instance['like_button_send'] = $new_instance['like_button_send'];
		$instance['like_button_layout'] = $new_instance['like_button_layout'];
		$instance['like_button_content'] = stripslashes($new_instance['like_button_content']);
		//set use content to 0 if checkbutton was not send
		$instance['like_button_use_content'] = ($new_instance['like_button_use_content'] == '' ? 0 : $new_instance['like_button_use_content']);
		
        return $instance;
        	
	}
	/*
	 * Global return content
	 */
	function widget($args, $instance) {
        extract($args);
       	$instance['like_button_title'] = apply_filters('widget_title', $instance['like_button_title']);
		$instance['like_button_content'] = html_entity_decode($instance['like_button_content']);
		$instance['like_button_use_content'] = html_entity_decode($instance['like_button_use_content']);
       	echo $before_widget;
       	if($instance['like_button_title'])
        	echo $before_title . $instance['like_button_title'] . $after_title;
        
        //if widget content set, and use enable
		if($instance['like_button_content'] && $instance['like_button_use_content'] == 1)
			echo '<div id="AWD_like_button">'.$instance['like_button_content'].'</div>';
		//else get button with settings
		else
			echo $this->AWD_facebook->get_the_like_button('',$instance);
		
        echo $after_widget; 
    }
}
?>
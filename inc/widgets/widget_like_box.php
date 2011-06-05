<?php
/*
*
* WIDGET LIKE BOX AWD Facebook
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
class AWD_facebook_like_box extends WP_Widget {
	
	/*
	 * Init widget
	 */
	function AWD_facebook_like_box(){
		//globalise plugin object
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
		$like_box_widjet_info = array('description' => __('Add a Facebook Like Box. Customise the code, or use predefined Like box in settings',$this->AWD_facebook->plugin_text_domain));
        parent::WP_Widget(false, $name='Facebook Like Box' , $like_box_widjet_info);	
    }
    /*
	 * form admin widget
	 */
	function form($instance) {
		$title = esc_attr($instance['like_box_title']);
		
		//define settings to defaults, if empty only...
		$like_box['like_box_url'] = (esc_attr($instance['like_box_url']) == '' ? $this->AWD_facebook->plugin_option['like_box_url'] : $instance['like_box_url']);
		$like_box['like_box_colorscheme'] = (esc_attr($instance['like_box_colorscheme']) == '' ? $this->plugin_option['like_box_colorscheme'] : $instance['like_box_colorscheme']);
		$like_box['like_box_width'] =(esc_attr($instance['like_box_width']) == '' ? $this->AWD_facebook->plugin_option['like_box_width'] : $instance['like_box_width']);
		$like_box['like_box_height'] = (esc_attr($instance['like_box_height']) == '' ? $this->AWD_facebook->plugin_option['like_box_height'] : $instance['like_box_height']);
		$like_box['like_box_faces'] = (esc_attr($instance['like_box_faces']) == '' ? $this->AWD_facebook->plugin_option['like_box_faces'] : $instance['like_box_faces']);
		$like_box['like_box_stream'] = (esc_attr($instance['like_box_stream']) == '' ? $this->AWD_facebook->plugin_option['like_box_stream'] : $instance['like_box_stream']);
		$like_box['like_box_xfbml'] = (esc_attr($instance['like_box_xfbml']) == '' ? $this->AWD_facebook->plugin_option['like_box_xfbml'] : $instance['like_box_xfbml']);
		$like_box['like_box_header'] = (esc_attr($instance['like_box_header']) == '' ? $this->AWD_facebook->plugin_option['like_box_header'] : $instance['like_box_header']);
		$like_box['like_box_content'] = (esc_attr($instance['like_box_content']) == '' ? $this->AWD_facebook->plugin_option['like_box_content'] : $instance['like_box_content']);
		$like_box['like_box_use_content'] = (esc_attr($instance['like_box_use_content']) == '' ? 0 : $instance['like_box_use_content']);
	
	
	    echo '<h2 style="text-align:center;color:#627AAD;border:1px solid #ccc; padding:5px;"><img style="vertical-align:middle;" src="'.$this->AWD_facebook->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.__('Facebook Like Box',$this->AWD_facebook->plugin_text_domain).'</h2><br />';

	
		//if paser xfbml enable change the message
		if($this->AWD_facebook->plugin_option['parse_xfbml'] == 1){
			$label = __('Iframe Or xfbml:',$this->AWD_facebook->plugin_text_domain);
		}else{
			$label = sprintf(__('Iframe Or %sxfbml%s %s(not active)%s:',$this->AWD_facebook->plugin_text_domain),'<s>','</s>','<i>','</i>');
		}
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_title').'">'._e('Title',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('like_box_title').'" name="'.$this->get_field_name('like_box_title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_xfbml').'">'.$label.' 
				<select class="widefat" id="'.$this->get_field_id('like_box_xfbml').'" name="'.$this->get_field_name('like_box_xfbml').'">
					<option value="1" '.($like_box['like_box_xfbml'] == '1' ? 'selected="selected"':'').' '.($this->plugin_option['parse_xfbml'] == 0 ? 'disabled="disabled"' : '').'>'.__('XFBML',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_box['like_box_xfbml'] == '0' ? 'selected="selected"':'').'>'.__('IFRAME',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_url').'">'._e('Url of the page',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('like_box_url').'" name="'.$this->get_field_name('like_box_url').'" type="text" value="'.$like_box['like_box_url'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_colorscheme').'">'._e('Colorscheme of box',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_box_colorscheme').'" name="'.$this->get_field_name('like_box_colorscheme').'">
					<option value="light" '.($like_box['like_box_colorscheme'] == 'light' ? 'selected="selected"':'').'>'.__('Light',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="dark" '.($like_box['like_box_colorscheme'] == 'dark' ? 'selected="selected"':'').'>'.__('Dark',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_width').'">'._e('Width of box',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('like_box_width').'" name="'.$this->get_field_name('like_box_width').'" type="text" value="'.$like_box['like_box_width'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_height').'">'._e('Height of box (only for iframe)',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('like_box_height').'" name="'.$this->get_field_name('like_box_height').'"  '.($this->plugin_option['like_button_xfbml'] == 1 ? 'disabled="disabled"' : '').' type="text" value="'.$like_box['like_box_height'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_faces').'">'._e('Show Faces ?',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_box_faces').'" name="'.$this->get_field_name('like_box_faces').'">
					<option value="1" '.($like_box['like_box_faces'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_box['like_box_faces'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_stream').'">'._e('Show Stream ?',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('like_box_stream').'" name="'.$this->get_field_name('like_box_stream').'">
					<option value="1" '.($like_box['like_box_stream'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_box['like_box_stream'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_header').'">'._e('Show Header ?',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('faces').'" name="'.$this->get_field_name('like_box_header').'">
					<option value="1" '.($like_box['like_box_header'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($like_box['like_box_header'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '<h2 style="text-align:center;font-weight:bold;">'.__('OR',$this->AWD_facebook->plugin_text_domain).'</h2>';
		echo '
		<p>
			<label for="'.$this->get_field_id('like_box_content').'">
			<input type="checkbox" '.($like_box['like_box_use_content'] == '1' ? 'checked="checked"':'').' value="1" id="'.$this->get_field_id('like_box_use_content').'" name="'.$this->get_field_name('like_box_use_content').'" /> '.__('Use code instead settings ?',$this->AWD_facebook->plugin_text_domain).'
			'.__('Paste',$this->AWD_facebook->plugin_text_domain).' '.$label.'<br />'.__('if you paste code, settings will be ignored',$this->AWD_facebook->plugin_text_domain).'
			<textarea rows="12" class="widefat" id="'.$this->get_field_id('like_box_content').'" name="'.$this->get_field_name('like_box_content').'">'.$like_box['like_box_content'].'</textarea>
			</label>
		</p>
		';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['like_box_url'] = stripslashes($new_instance['like_box_url']);
		$instance['like_box_title'] = strip_tags($new_instance['like_box_title']);
		$instance['like_box_colorscheme'] = $new_instance['like_box_colorscheme'];
		$instance['like_box_width'] = stripslashes($new_instance['like_box_width']);
		$instance['like_box_height'] = stripslashes($new_instance['like_box_height']);
		$instance['like_box_faces'] = $new_instance['like_box_faces'];
		$instance['like_box_stream'] = $new_instance['like_box_stream'];
		$instance['like_box_xfbml'] = $new_instance['like_box_xfbml'];
		$instance['like_box_header'] = $new_instance['like_box_header'];
		$instance['like_box_content'] = stripslashes($new_instance['like_box_content']);
		//set use content to 0 if checkbox was not send
		$instance['like_box_use_content'] = ($new_instance['like_box_use_content'] == '' ? 0 : $new_instance['like_box_use_content']);
		
        return $instance;
	}
	/*
	 * Global return content
	 */
	function widget($args, $instance) {
        extract($args);
       	$instance['like_box_title'] = apply_filters('widget_title', $instance['like_box_title']);
		$instance['like_box_content'] = html_entity_decode($instance['like_box_content']);
		$instance['like_box_use_content'] = html_entity_decode($instance['like_box_use_content']);
       	echo $before_widget;
       	if($instance['like_box_title'])
        	echo $before_title . $instance['like_box_title'] . $after_title;
        
        //if widget content set, and use enable
		if($instance['like_box_content'] && $instance['like_box_use_content'] == 1)
			echo '<div id="AWD_like_box">'.$instance['like_box_content'].'</div>';
		//else get button with settings
		else
			echo $this->AWD_facebook->get_the_like_box($instance);

		
        echo $after_widget; 
    }
}
?>
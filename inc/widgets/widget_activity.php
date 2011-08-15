<?php
/*
*
* WIDGET LIKE BOX AWD Facebook
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
class AWD_facebook_activity extends WP_Widget {
	
	/*
	 * Init widget
	 */
	function AWD_facebook_activity(){
		//globalise plugin object
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
		//load translation fro widgets
		load_plugin_textdomain($this->AWD_facebook->plugin_text_domain,false,dirname(dirname( plugin_basename( __FILE__ ) ) ) . '/langs/');

		$activity_widjet_info = array('description' => __('Add a Facebook Activity Box. Customise the code, or use predefined Activity box in settings',$this->AWD_facebook->plugin_text_domain));
        parent::WP_Widget(false, $name=__('Facebook Activity Box',$this->AWD_facebook->plugin_text_domain) , $activity_widjet_info);	
    }
    /*
	 * form admin widget
	 */
	function form($instance) {
		$title = esc_attr($instance['activity_title']);
		
		//define settings to defaults, if empty only...
		$activity['activity_domain'] = (esc_attr($instance['activity_domain']) == '' ? $this->AWD_facebook->plugin_option['activity_domain'] : $instance['activity_domain']);
		$activity['activity_colorscheme'] = (esc_attr($instance['activity_colorscheme']) == '' ? $this->plugin_option['activity_colorscheme'] : $instance['activity_colorscheme']);
		$activity['activity_width'] =(esc_attr($instance['activity_width']) == '' ? $this->AWD_facebook->plugin_option['activity_width'] : $instance['activity_width']);
		$activity['activity_height'] = (esc_attr($instance['activity_height']) == '' ? $this->AWD_facebook->plugin_option['activity_height'] : $instance['activity_height']);
		$activity['activity_fonts'] = (esc_attr($instance['activity_fonts']) == '' ? $this->AWD_facebook->plugin_option['activity_fonts'] : $instance['activity_fonts']);
		$activity['activity_border_color'] = (esc_attr($instance['activity_border_color']) == '' ? $this->AWD_facebook->plugin_option['activity_border_color'] : $instance['activity_border_color']);
		$activity['activity_xfbml'] = (esc_attr($instance['activity_xfbml']) == '' ? $this->AWD_facebook->plugin_option['activity_xfbml'] : $instance['activity_xfbml']);
		$activity['activity_header'] = (esc_attr($instance['activity_header']) == '' ? $this->AWD_facebook->plugin_option['activity_header'] : $instance['activity_header']);
		$activity['activity_content'] = (esc_attr($instance['activity_content']) == '' ? $this->AWD_facebook->plugin_option['activity_content'] : $instance['activity_content']);
		$activity['activity_use_content'] = (esc_attr($instance['activity_use_content']) == '' ? 0 : $instance['activity_use_content']);
	
	
	    echo '<h2 style="text-align:center;color:#627AAD;border:1px solid #ccc; padding:5px;"><img style="vertical-align:middle;" src="'.$this->AWD_facebook->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.__('Facebook Activity Box',$this->AWD_facebook->plugin_text_domain).'</h2><br />';

	
		//if paser xfbml enable change the message
		if($this->AWD_facebook->plugin_option['parse_xfbml'] == 1){
			$label = __('Iframe Or xfbml:',$this->AWD_facebook->plugin_text_domain);
		}else{
			$label = sprintf(__('Iframe Or %sxfbml%s %s(not active)%s:',$this->AWD_facebook->plugin_text_domain),'<s>','</s>','<i>','</i>');
		}
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_title').'">'._e('Title',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('activity_title').'" name="'.$this->get_field_name('activity_title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_xfbml').'">'.$label.' 
				<select class="widefat" id="'.$this->get_field_id('activity_xfbml').'" name="'.$this->get_field_name('activity_xfbml').'">
					<option value="1" '.($activity['activity_xfbml'] == '1' ? 'selected="selected"':'').' '.($this->plugin_option['parse_xfbml'] == 0 ? 'disabled="disabled"' : '').'>'.__('XFBML',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($activity['activity_xfbml'] == '0' ? 'selected="selected"':'').'>'.__('IFRAME',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_domain').'">'._e('Domain (ex: mysite.com)',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('activity_domain').'" name="'.$this->get_field_name('activity_domain').'" type="text" value="'.$activity['activity_domain'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_colorscheme').'">'._e('Colorscheme of box',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('activity_colorscheme').'" name="'.$this->get_field_name('activity_colorscheme').'">
					<option value="light" '.($activity['activity_colorscheme'] == 'light' ? 'selected="selected"':'').'>'.__('Light',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="dark" '.($activity['activity_colorscheme'] == 'dark' ? 'selected="selected"':'').'>'.__('Dark',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_width').'">'._e('Width of box',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('activity_width').'" name="'.$this->get_field_name('activity_width').'" type="text" value="'.$activity['activity_width'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_height').'">'._e('Height of box',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('activity_height').'" name="'.$this->get_field_name('activity_height').'"  type="text" value="'.$activity['activity_height'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_fonts').'">'._e('Font',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('activity_fonts').'" name="'.$this->get_field_name('activity_fonts').'">
					<option value="arial" '.($activity['activity_fonts'] == "arial" ? 'selected="selected"' :'').' >Arial</option>
					<option value="lucida grande" '.($activity['activity_fonts'] == "lucida grande" ? 'selected="selected"' :'').' >Lucida grande</option>
					<option value="segoe ui" '.($activity['activity_fonts'] == "segoe ui" ? 'selected="selected"' :'').' >Segoe ui</option>
					<option value="tahoma" '.($activity['activity_fonts'] == "tahoma" ? 'selected="selected"' :'').' >Tahoma</option>
					<option value="trebuchet ms" '.($activity['activity_fonts'] == "trebuchet ms" ? 'selected="selected"' :'').' >Trebuchet ms</option>
					<option value="verdana" '.($activity['activity_fonts'] == "verdana" ? 'selected="selected"' :'').' >Verdana</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_border_color').'">'._e('Border color',$this->plugin_text_domain).' 
				#<input size="10" id="'.$this->get_field_id('activity_border_color').'" name="'.$this->get_field_name('activity_border_color').'" type="text" value="'.$activity['activity_border_color'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_header').'">'._e('Show Header ?',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('faces').'" name="'.$this->get_field_name('activity_header').'">
					<option value="1" '.($activity['activity_header'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($activity['activity_header'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '<h2 style="text-align:center;font-weight:bold;">'.__('OR',$this->AWD_facebook->plugin_text_domain).'</h2>';
		echo '
		<p>
			<label for="'.$this->get_field_id('activity_content').'">
			<input type="checkbox" '.($activity['activity_use_content'] == '1' ? 'checked="checked"':'').' value="1" id="'.$this->get_field_id('activity_use_content').'" name="'.$this->get_field_name('activity_use_content').'" /> '.__('Use code instead settings ?',$this->AWD_facebook->plugin_text_domain).'
			'.__('Paste',$this->AWD_facebook->plugin_text_domain).' '.$label.'<br />'.__('if you paste code, settings will be ignored',$this->AWD_facebook->plugin_text_domain).'
			<textarea rows="12" class="widefat" id="'.$this->get_field_id('activity_content').'" name="'.$this->get_field_name('activity_content').'">'.$activity['activity_content'].'</textarea>
			</label>
		</p>
		';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['activity_domain'] = stripslashes($new_instance['activity_domain']);
		$instance['activity_title'] = strip_tags($new_instance['activity_title']);
		$instance['activity_colorscheme'] = $new_instance['activity_colorscheme'];
		$instance['activity_width'] = stripslashes($new_instance['activity_width']);
		$instance['activity_height'] = stripslashes($new_instance['activity_height']);
		$instance['activity_fonts'] = $new_instance['activity_fonts'];
		$instance['activity_border_color'] = $new_instance['activity_border_color'];
		$instance['activity_xfbml'] = $new_instance['activity_xfbml'];
		$instance['activity_header'] = $new_instance['activity_header'];
		$instance['activity_content'] = stripslashes($new_instance['activity_content']);
		//set use content to 0 if checkbox was not send
		$instance['activity_use_content'] = ($new_instance['activity_use_content'] == '' ? 0 : $new_instance['activity_use_content']);
		
        return $instance;
	}
	/*
	 * Global return content
	 */
	function widget($args, $instance) {
        extract($args);
       	$instance['activity_title'] = apply_filters('widget_title', $instance['activity_title']);
		$instance['activity_content'] = html_entity_decode($instance['activity_content']);
		$instance['activity_use_content'] = html_entity_decode($instance['activity_use_content']);
       	echo $before_widget;
       	if($instance['activity_title'])
        	echo $before_title . $instance['activity_title'] . $after_title;
        
        //if widget content set, and use enable
		if($instance['activity_content'] && $instance['activity_use_content'] == 1)
			echo '<div id="AWD_activity">'.$instance['activity_content'].'</div>';
		//else get button with settings
		else
			echo $this->AWD_facebook->get_the_activity_box($instance);

		
        echo $after_widget; 
    }
}
?>
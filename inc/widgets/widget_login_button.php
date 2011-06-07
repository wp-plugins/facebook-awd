<?php
/*
*
* WIDGET LOGIN BUTTON AWD Facebook
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
class AWD_facebook_login_button extends WP_Widget {
	
	/*
	 * Init widget
	 */
	function AWD_facebook_login_button(){
		//globalise plugin object
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
		$login_button_widjet_info = array('description' => __('Add a Facebook Login Button. Customise the code, or use predefined Login button in settings',$this->AWD_facebook->plugin_text_domain));
        parent::WP_Widget(false, $name='Facebook Login Button' , $login_button_widjet_info);	
    }
    /*
	 * form admin widget
	 */
	function form($instance) {
		$title = esc_attr($instance['login_button_title']);
		
		//define settings to defaults, if empty only...
		$login_button['login_button_width'] =(esc_attr($instance['login_button_width']) == '' ? $this->AWD_facebook->plugin_option['login_button_width'] : $instance['login_button_width']);
		$login_button['login_button_faces'] = (esc_attr($instance['login_button_faces']) == '' ? $this->AWD_facebook->plugin_option['login_button_faces'] : $instance['login_button_faces']);
		$login_button['login_button_profile_picture'] = (esc_attr($instance['login_button_profile_picture']) == '' ? $this->AWD_facebook->plugin_option['login_button_profile_picture'] : $instance['login_button_profile_picture']);
		$login_button['login_button_maxrow'] = (esc_attr($instance['login_button_maxrow']) == '' ? $this->AWD_facebook->plugin_option['login_button_maxrow'] : $instance['login_button_maxrow']);
		$login_button['login_button_logout_value'] = (esc_attr($instance['login_button_logout_value']) == '' ? '' : $instance['login_button_logout_value']);
		$login_button['login_button_css'] = (esc_attr($instance['login_button_css']) == '' ? '' : $instance['login_button_css']);
	
	    echo '<h2 style="text-align:center;color:#627AAD;border:1px solid #ccc; padding:5px;"><img style="vertical-align:middle;" src="'.$this->AWD_facebook->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.__('Facebook Login Button',$this->AWD_facebook->plugin_text_domain).'</h2><br />';
	
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_title').'">'._e('Title',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('login_button_title').'" name="'.$this->get_field_name('login_button_title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_faces').'">'._e('Show Faces ?',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('login_button_faces').'" name="'.$this->get_field_name('login_button_faces').'">
					<option value="1" '.($login_button['login_button_faces'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($login_button['login_button_faces'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_profile_picture').'">'._e('Show Profile picture ?',$this->AWD_facebook->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('login_button_faces').'" name="'.$this->get_field_name('login_button_profile_picture').'">
					<option value="1" '.($login_button['login_button_profile_picture'] == '1' ? 'selected="selected"':'').'>'.__('Yes',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="0" '.($login_button['login_button_profile_picture'] == '0' ? 'selected="selected"':'').'>'.__('No',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_width').'">'._e('Width of button',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('login_button_width').'" name="'.$this->get_field_name('login_button_width').'" type="text" value="'.$login_button['login_button_width'].'" size="6" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_maxrow').'">'._e('Max Rows (faces)',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('login_button_maxrow').'" name="'.$this->get_field_name('login_button_maxrow').'" type="text" value="'.$login_button['login_button_maxrow'].'" size="6" />
			</label>
		</p>';
		
				echo '
		<p>
			<label for="'.$this->get_field_id('login_button_logout_value').'">'._e('Logout Phrase',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('login_button_logout_value').'" name="'.$this->get_field_name('login_button_logout_value').'" type="text" value="'.$login_button['login_button_logout_value'].'"/>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('login_button_css').'">'._e('Custom Css',$this->AWD_facebook->plugin_text_domain).'
			<textarea rows="12" class="widefat" id="'.$this->get_field_id('login_button_css').'" name="'.$this->get_field_name('login_button_css').'">'.$login_button['login_button_css'].'</textarea>
			</label>
		</p>
		';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['login_button_title'] = strip_tags($new_instance['login_button_title']);
		$instance['login_button_faces'] = $new_instance['login_button_faces'];
		$instance['login_button_profile_picture'] = $new_instance['login_button_profile_picture'];
		$instance['login_button_width'] = stripslashes($new_instance['login_button_width']);
		$instance['login_button_maxrow'] = $new_instance['login_button_maxrow'];
		$instance['login_button_logout_value'] = $new_instance['login_button_logout_value'];
		$instance['login_button_css'] = $new_instance['login_button_css'];
		
        return $instance;
	}
	/*
	 * Global return content
	 */
	function widget($args, $instance) {
        extract($args);
       	$instance['login_button_title'] = apply_filters('widget_title', $instance['login_button_title']);
		$instance['login_button_css'] = html_entity_decode($instance['login_button_css']);
       	echo $before_widget;
       	if($instance['login_button_title'])
        	echo $before_title . $instance['login_button_title'] . $after_title;
        if($instance['login_button_css']!='')
			echo '<style type="text/css">'.$instance['login_button_css'].'</style>';
			
		echo $this->AWD_facebook->get_the_login_button($instance);

        echo $after_widget; 
    }
}
?>
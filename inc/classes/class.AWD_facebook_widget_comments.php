<?php
/*
*
* WIDGET LIKE BOX AWD Facebook
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
class AWD_facebook_widget_comments extends WP_Widget {
	
	/*
	 * Init widget
	 */
	function AWD_facebook_widget_comments(){
		//globalise plugin object
		global $AWD_facebook;
		$this->AWD_facebook = $AWD_facebook;
		//load translation fro widgets
		load_plugin_textdomain($this->AWD_facebook->plugin_text_domain,false,dirname(dirname( plugin_basename( __FILE__ ) ) ) . '/langs/');

		$comments_widjet_info = array('description' => __('Add a Facebook Comments Box. Customise the code, or use predefined Comments box in settings',$this->AWD_facebook->plugin_text_domain));
        parent::WP_Widget(false, $name=__('Facebook Comments Box',$this->AWD_facebook->plugin_text_domain) , $comments_widjet_info);	
    }
    /*
	 * form admin widget
	 */
	function form($instance) {
		$title = esc_attr($instance['comments_title']);
		
		//define settings to defaults, if empty only...
		$comments['comments_href'] = (esc_attr($instance['comments_href']) == '' ? $this->AWD_facebook->options['comments_href'] : $instance['comments_href']);
		$comments['comments_colorscheme'] = (esc_attr($instance['comments_colorscheme']) == '' ? $this->options['comments_colorscheme'] : $instance['comments_colorscheme']);
		$comments['comments_width'] =(esc_attr($instance['comments_width']) == '' ? $this->AWD_facebook->options['comments_width'] : $instance['comments_width']);
		$comments['comments_type'] = (esc_attr($instance['comments_type']) == '' ? $this->AWD_facebook->options['comments_type'] : $instance['comments_type']);
		$comments['comments_nb'] = (esc_attr($instance['comments_nb']) == '' ? $this->AWD_facebook->options['comments_nb'] : $instance['comments_nb']);
		$comments['comments_mobile'] = (esc_attr($instance['comments_mobile']) == '' ? $this->AWD_facebook->options['comments_mobile'] : $instance['comments_mobile']);
		
	    echo '<h2 style="text-align:center;color:#627AAD;border:1px solid #ccc; padding:5px;"><img style="vertical-align:middle;" src="'.$this->AWD_facebook->plugin_url_images.'facebook-mini.png" alt="facebook logo"/> '.__('Facebook Comments Box',$this->AWD_facebook->plugin_text_domain).'</h2><br />';

		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_title').'">'.__('Title',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('comments_title').'" name="'.$this->get_field_name('comments_title').'" type="text" value="'.$title.'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_type').'">'.__('Type',$this->AWD_facebook->plugin_text_domain).'
				<select class="widefat" id="'.$this->get_field_id('comments_type').'" name="'.$this->get_field_name('comments_type').'">
					<option value="xfbml" '.($comments['comments_type'] == 'xfbml' ? 'selected="selected"':'').'>'.__('XFBML',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="html5" '.($comments['comments_type'] == 'html5' ? 'selected="selected"':'').'>'.__('HTML5',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_url').'">'.__('URL to comment on',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('comments_url').'" name="'.$this->get_field_name('comments_url').'" type="text" value="'.$comments['comments_url'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_nb').'">'.__('Number of posts',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('comments_nb').'" name="'.$this->get_field_name('comments_nb').'" type="text" value="'.$comments['comments_nb'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_mobile').'">'.__('Mobile version ?',$this->AWD_facebook->plugin_text_domain).' 
				<input class="widefat" id="'.$this->get_field_id('comments_mobile').'" name="'.$this->get_field_name('comments_mobile').'" type="text" value="'.$comments['comments_mobile'].'" />
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_colorscheme').'">'.__('Colorscheme of box',$this->plugin_text_domain).' 
				<select class="widefat" id="'.$this->get_field_id('comments_colorscheme').'" name="'.$this->get_field_name('comments_colorscheme').'">
					<option value="light" '.($comments['comments_colorscheme'] == 'light' ? 'selected="selected"':'').'>'.__('Light',$this->AWD_facebook->plugin_text_domain).'</option>
					<option value="dark" '.($comments['comments_colorscheme'] == 'dark' ? 'selected="selected"':'').'>'.__('Dark',$this->AWD_facebook->plugin_text_domain).'</option>
				</select>
			</label>
		</p>';
		
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_width').'">'.__('Width of box',$this->AWD_facebook->plugin_text_domain).' 
				<input id="'.$this->get_field_id('comments_width').'" name="'.$this->get_field_name('comments_width').'" type="text" value="'.$comments['comments_width'].'" size="6" />
			</label>
		</p>';

		
		echo '<h2 style="text-align:center;font-weight:bold;">'.__('OR',$this->AWD_facebook->plugin_text_domain).'</h2>';
		echo '
		<p>
			<label for="'.$this->get_field_id('comments_content').'">
			<input type="checkbox" '.($comments['comments_use_content'] == '1' ? 'checked="checked"':'').' value="1" id="'.$this->get_field_id('comments_use_content').'" name="'.$this->get_field_name('comments_use_content').'" /> '.__('Use code instead settings ?',$this->AWD_facebook->plugin_text_domain).'
			'.__('Paste',$this->AWD_facebook->plugin_text_domain).' '.$label.'<br />'.__('if you paste code, settings will be ignored',$this->AWD_facebook->plugin_text_domain).'
			<textarea rows="12" class="widefat" id="'.$this->get_field_id('comments_content').'" name="'.$this->get_field_name('comments_content').'">'.$comments['comments_content'].'</textarea>
			</label>
		</p>
		';
	}
	/*
	 * update
	 */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['comments_href'] = stripslashes($new_instance['comments_domain']);
		$instance['comments_title'] = strip_tags($new_instance['comments_title']);
		$instance['comments_colorscheme'] = stripslashes($new_instance['comments_colorscheme']);
		$instance['comments_width'] = stripslashes($new_instance['comments_width']);
		$instance['comments_type'] = stripslashes($new_instance['comments_type']);
		$instance['comments_nb'] = stripslashes($new_instance['comments_nb']);
		$instance['comments_mobile'] = stripslashes($new_instance['comments_mobile']);
		$instance['comments_content'] = stripslashes($new_instance['comments_content']);
		//set use content to 0 if checkbox was not send
		$instance['comments_use_content'] = ($new_instance['comments_use_content'] == '' ? 0 : $new_instance['comments_use_content']);
		
        return $instance;
	}
	/*
	 * Global return content
	 */
	function widget($args, $instance) {
        extract($args);
       	$instance['comments_title'] = apply_filters('widget_title', $instance['comments_title']);
		$instance['comments_content'] = html_entity_decode($instance['comments_content']);
		$instance['comments_use_content'] = html_entity_decode($instance['comments_use_content']);
       	echo $before_widget;
       	if($instance['comments_title'])
        	echo $before_title . $instance['comments_title'] . $after_title;
        
        //if widget content set, and use enable
		if($instance['comments_content'] && $instance['comments_use_content'] == 1)
			echo '<div id="AWD_comments">'.$instance['comments_content'].'</div>';
		//else get button with settings
		else
			echo $this->AWD_facebook->get_the_comments_box('',$instance);

		
        echo $after_widget; 
    }
}
?>
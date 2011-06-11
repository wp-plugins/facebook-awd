<?php
/*
Plugin Name: AWD Facebook
Plugin URI: http://www.ahwebdev.fr
Description: This plugin integrates Facebook open graph
Version: 0.9.4.3
Author: AH WEB DEV
Author URI: http://www.ahwebdev.fr
License: Copywrite AH WEB DEV
Text Domain: AWD_facebook
Domain Path: /lang
*/

/* Class Parent LIB */
if(!class_exists('AHWEBDEV_wpplugin'))
    require_once(dirname(__FILE__).'/inc/classes/class.ahwebdev_wpplugin.php');

Class AWD_facebook extends AHWEBDEV_wpplugin{
    
    
    //****************************************************************************************
	//	VARS
	//****************************************************************************************
    /*
    * public
    * Name of the plugin
    */
    public $plugin_name = 'Facebook';
    /*
    * public
    * slug of the plugin
    */
    public $plugin_slug = 'awd_fcbk';
    /*
    * private
    * preffix blog option
    */
    private $plugin_option_pref = 'awd_fcbk_option_';
    /*
    * public
    * preffix blog option
    */
    public $plugin_page_admin_name = 'Facebook Admin';
    /*
    * public
    * preffix blog option
    */
    public $plugin_text_domain = 'AWD_facebook';
    /*
    * private
    * position of the menu in admin
    */
    private $blog_admin_hook_position;
    /*
    * private
    * hook admin
    */
    public $blog_admin_page_hook;
    /*
    * public
    * Debug this object
    */
    public $debug_active = false;
    /*
    * public
    * Debug and add list of debug in this array
    * if $debug_active == true, so we write $debug_echo in footer
    */
    public $debug_echo = array();
    
	
	//****************************************************************************************
	//	INIT
	//****************************************************************************************
	/*
	 * plugin construct
	 */
	public function __construct(){		
		/* Class FCBK */
		if(!class_exists('Facebook'))
			require_once(dirname(__FILE__).'/inc/classes/facebook.php');
		add_action('init',array(&$this,'initial'),11);//11 start init later to be comatible with custom post types
		//like box widget register
		add_action('widgets_init',  array(&$this,'register_AWD_facebook_widgets'));
	}
	/*
	 * plugin init
	 */
	public function initial(){
		global $wpdb;
		include_once(dirname(__FILE__).'/inc/init.php');
		
	}
	/*
	 * plugin version
	 */
	public function get_version(){
		if (!function_exists('get_plugins'))
	    	require_once(ABSPATH.'wp-admin/includes/plugin.php');
	    $plugin_folder = get_plugins('/'.plugin_basename( dirname( __FILE__ )));
	    $plugin_file = basename( ( __FILE__ ) );
	    return $plugin_folder[$plugin_file]['Version'];
	}
	/*
	* missing config notices
	*/
	public function missing_config(){
		?>
		<div class="error">
			<p><?php printf( __( 'Facebook Connect plugin is almost ready. To start using Facebook <strong>you need to set your Facebook Application API ID and Faceook Application secret key</strong>. You can do that in <a href="%1s">Facebook Connect settings page</a>. (Notification from Facebook AWD)', $this->plugin_text_domain), admin_url( 'admin.php?page='.$this->plugin_slug)); ?></p>
		</div> 
		<?php	
	}
	/*
	* missing config notices
	*/
	public function message_register_disabled(){
		?>
		<div class="error">
			<p><?php _e('Users can not register, please enable registration account in blog settings before using FB Connect. (Notification from Facebook AWD)', $this->plugin_text_domain); ?></p>
		</div> 
		<?php	
	}
	
	
	//****************************************************************************************
	//	ADMIN
	//****************************************************************************************
	/*
	 * Admin plugin init
	 * call form init.php
	 */
	public function admin_menu(){
		//admin hook

		$this->blog_admin_page_hook = add_menu_page($this->plugin_page_admin_name, __($this->plugin_name,$this->plugin_text_domain), 'administrator', $this->plugin_slug, array($this,'admin_content'), $this->plugin_url_images.'facebook-mini.png',$this->blog_admin_hook_position);
		$this->blog_admin_settings_hook = add_submenu_page($this->plugin_slug, __('Settings',$this->plugin_text_domain), __('Settings',$this->plugin_text_domain), 'administrator', $this->plugin_slug);
		$this->blog_admin_plugins_hook = add_submenu_page($this->plugin_slug, __('Plugins',$this->plugin_text_domain), __('Plugins',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_plugins', array($this,'admin_content'));
		if($this->plugin_option['open_graph_enable'] == 1)
			$this->blog_admin_opengraph_hook = add_submenu_page($this->plugin_slug, __('Open Graph',$this->plugin_text_domain), __('Open Graph',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_open_graph', array($this,'admin_content'));
		//$this->blog_admin_insights_hook = add_submenu_page($this->plugin_slug, __('Insights',$this->plugin_text_domain), __('Insights',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_insights', array($this,'admin_content'));
		//$this->blog_admin_faq_hook = add_submenu_page($this->plugin_slug, __('FAQ',$this->plugin_text_domain), __('FAQ',$this->plugin_text_domain), 'administrator', $this->plugin_slug.'_faq', array($this,'admin_content'));
		
	}
	public function admin_initialisation(){
		
		//sidebar boxes
		add_meta_box($this->plugin_slug."_meta",  __('My Facebook',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'fcbk_content'),  $this->plugin_slug.'_box' , 'side', 'core');
		add_meta_box($this->plugin_slug."_info",  __('Informations',$this->plugin_text_domain), array(&$this,'infos_content'),  $this->plugin_slug.'_box' , 'side', 'core');
		add_meta_box($this->plugin_slug."_activity",  __('Activity on your site',$this->plugin_text_domain), array(&$this,'activity_content'),  $this->plugin_slug.'_box' , 'side', 'core');
		
		//plugins boxes
		add_meta_box($this->plugin_slug."_plugins", __('Plugins Settings',$this->plugin_text_domain), array(&$this,'plugins_content'),  $this->plugin_slug.'_plugins_box' , 'normal', 'core');
		add_meta_box($this->plugin_slug."_settings", __('Settings',$this->plugin_text_domain), array(&$this,'settings_content'), $this->plugin_slug.'_settings_box' , 'normal', 'core');
		
		//open graph meta box
		if($this->plugin_option['open_graph_enable'] == 1)
			add_meta_box($this->plugin_slug."_open_graph", __('Open Graph',$this->plugin_text_domain), array(&$this,'open_graph_content'),  $this->plugin_slug.'_open_graph_box' , 'normal', 'core');
		
		//add post page and custom post type box opengraph meta
		if($this->plugin_option['open_graph_enable'] == 1){
			$post_types = get_post_types();
			foreach($post_types as $type){
				add_meta_box($this->plugin_slug."_open_graph_post_metas_form", __('Open Graph Metas',$this->plugin_text_domain).' <img style="vertical-align:middle;" src="'.$this->plugin_url_images.'facebook-mini.png" alt="facebook logo"/>', array(&$this,'open_graph_post_metas_form'),  $type , 'normal', 'core',array("prefix"=>$this->plugin_option_pref.'ogtags_'));
			}
			add_action('save_post', array(&$this,'save_options_post_editor'));
		}
		
		//if xfbml show comment box for ths plugin
		if($this->plugin_option['parse_xfbml'] == 1){
			add_meta_box($this->plugin_slug."_comment",  __('Comments',$this->plugin_text_domain), array(&$this,'AWD_comments_content'),  $this->plugin_slug.'_box' , 'side', 'core');
		}
		
		//js hook for admin fcbk		
		add_action('admin_enqueue_scripts', array(&$this,'admin_enqueue_js'));
		add_action('admin_enqueue_scripts', array(&$this,'admin_enqueue_css'));
		/*add_action('load-'.$this->blog_admin_page_hook, array(&$this,'admin_enqueue_js'));
		if($this->plugin_option['open_graph_enable'] == 1)
			add_action('load-'.$this->blog_admin_opengraph_hook, array(&$this,'admin_enqueue_js'));
		add_action('load-'.$this->blog_admin_insights_hook, array(&$this,'admin_enqueue_js'));
		add_action('admin_print_styles-'.$this->blog_admin_page_hook, array(&$this,'admin_enqueue_css'));
		if($this->plugin_option['open_graph_enable'] == 1)
			add_action('admin_print_styles-'.$this->blog_admin_opengraph_hook, array(&$this,'admin_enqueue_css'));
		add_action('admin_print_styles-'.$this->blog_admin_insights_hook, array(&$this,'admin_enqueue_css'));
		*/
	}
	/*
	* Get help box
	*/
	public function get_the_help_box($type){
		$html = '<p><u>'.__('You can use Pattern code in fields, paste it where you need:',$this->plugin_text_domain).'</u></p>';
		switch($type){
			case 'taxonomies':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%TERM_TITLE%</b> - '.__('Use term name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%TERM_DESCRIPTION%</b> - '.__('Use term description',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'frontpage':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'archive':
				$html .= '<div class="awd_pre">';
				 	$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%ARCHIVE_TITLE%</b> - '.__('Use archive name',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'author':
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_TITLE%</b> - '.__('Use title of post',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_IMAGE%</b> - '.__('Use excerpt',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%AUTHOR_DESCRIPTION%</b> - '.__('Use featured image (if activated)',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
			break;
			case 'custom_post_types':
			case 'post':
			case 'page':
			default:
				$html .= '<div class="awd_pre">';
					$html .= '<p><b>%BLOG_TITLE%</b> - '.__('Use blog name',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_DESCRIPTION%</b> - '.__('Use blog description',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%BLOG_URL%</b> - '.__('Use blog url',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_TITLE%</b> - '.__('Use title of post',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_EXCERPT%</b> - '.__('Use excerpt',$this->plugin_text_domain).'</p>';
					$html .= '<p><b>%POST_IMAGE%</b> - '.__('Use featured image (if activated)',$this->plugin_text_domain).'</p>';
				$html .= '</div>';
		}
		return $html;
	}
	/*
	* Open Graph meta form in post and custom post type
	* used both in open graph settings
	*/
	public function open_graph_post_metas_form($post="",$metabox=""){
		//prefix defined from args,
		//custom take value from custom args if set...
		$prefix = $this->plugin_option_pref.'ogtags_';
		if(is_array($metabox)){
			if(is_array($metabox['args'])){
				$prefix = $metabox['args']['prefix'];
				//custom is the name of the array of option
				$customTemp = $metabox['args']['custom'];
				$custom = $this->plugin_option[$customTemp];
				//reconstruct the arry to be compatible with this function and args metabox
				if($customTemp){
					foreach($this->plugin_option as $option=>$value)
						if(ereg($customTemp,$option))
							$custom[str_ireplace($customTemp.'_',"",$prefix).$option][0] = $value;
				}
				//use h4 or other
				$custom_header = $metabox['args']['header'];
				$custom_help = $metabox['args']['help'];
			}
		}
		
		if($custom_header =='')
			$custom_header ='h4';
		//if post get custom from post
		//else get custom from $vars
		if(is_object($post))
			$custom = get_post_custom($post->ID);
		elseif(!$custom)
			$custom = array();
		?>
		<script type="text/javascript">
			jQuery(document).ready(function(){
				var icons = {
					header: "ui-icon-circle-arrow-e",
					headerSelected: "ui-icon-circle-arrow-s"
				};
				jQuery(".ui_ogtags_form").accordion({
					header: "h4",
					autoHeight: false,
					icons:icons,
					collapsible: true,
					active: false
				});
			
				jQuery("#<?php echo $prefix.'upload_image'; ?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'image'; ?>").attr('name');
					tb_show("<?php echo __('Image',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?type=image&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var imgurl = jQuery('img',html).attr('src');
						jQuery("#<?php echo $prefix.'image'; ?>").val(imgurl);
						tb_remove();
					}
					return false;
				});
				
				//audio  
				jQuery("#<?php echo $prefix.'upload_mp3';?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'audio'; ?>").attr('name');
					tb_show("<?php echo __('Mp3 song',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?type=audio&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var src = jQuery(html).attr('href');
						var title = jQuery(html).html();
						jQuery("#<?php echo $prefix.'audio'; ?>").val(src);
						jQuery("#<?php echo $prefix.'audio_title'; ?>").val(title);
						tb_remove();
					}
					return false;
				});
				
				//onload verify state of message video if empty image
				<?php echo str_replace("-","_",$prefix); ?>set_the_message_video();
				//display error to say that we nedd image if image field is empty
				//on click every where in body
				jQuery('body').click(function(){
					<?php echo str_replace("-","_",$prefix); ?>set_the_message_video();
				});
				//video swf  
				jQuery("#<?php echo $prefix.'upload_video';?>").click(function() {
					var formfield = jQuery("#<?php echo $prefix.'video'; ?>").attr('name');
					tb_show("<?php echo __('Video',$this->plugin_text_domain).' '.$this->plugin_name; ?>", 'media-upload.php?post_id=<?php echo $post->ID; ?>&amp;type=video&amp;TB_iframe=true');
					
					window.send_to_editor = function(html) {
						var src = jQuery(html).attr('href');
						jQuery("#<?php echo $prefix.'video'; ?>").val(src);
						tb_remove();
					}
					return false;
				});
				
				//active default open graph checkbox status
  				jQuery("#<?php echo $prefix.'disable_off';?>").click(function(){
  					jQuery(".ui_ogtags_allform<?php echo $customTemp;?>").slideDown();
  				});
  				jQuery("#<?php echo $prefix.'disable_on';?>").click(function(){
  					jQuery(".ui_ogtags_allform<?php echo $customTemp;?>").slideUp();
  				});
  				jQuery("#<?php echo $prefix.'redefine_on';?>").click(function(){
  					jQuery(".ui_ogtags_form<?php echo $customTemp;?>").slideDown();
  				});
  				jQuery("#<?php echo $prefix.'redefine_off';?>").click(function(){
  					jQuery(".ui_ogtags_form<?php echo $customTemp;?>").slideUp();
  				});
			});
			function <?php echo str_replace("-","_",$prefix); ?>set_the_message_video(){
				if(jQuery("#<?php echo $prefix.'image';?>").val() ==''){
					jQuery("#<?php echo $prefix.'message_video';?>").show();
				}else{
					jQuery("#<?php echo $prefix.'message_video';?>").slideUp();
				}
			}
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
			<input type="radio" name="<?php echo $prefix.'disable';?>" <?php if($custom[$prefix.'disable'][0] == 0 && $custom[$prefix.'disable'][0] != ''){echo 'checked="checked"';} ?> id="<?php echo $prefix.'disable_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
		</p>
		<div class="ui_ogtags_allform<?php echo $customTemp; ?> <?php if($custom[$prefix.'disable'][0] == 1 OR $custom[$prefix.'disable'][0] == ''){echo 'hidden';} ?>">
		<?php 
	    //if post or global form
        if(is_object($post)){ ?>	
		<p>
			<label class="up_label"><?php _e('Redefine Tags for this page ?',$this->plugin_text_domain); ?></label>
			<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 1){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_on';?>" value="1"/> <?php _e('Yes',$this->plugin_text_domain); ?>
			<input type="radio" name="<?php echo $prefix.'redefine';?>" <?php if($custom[$prefix.'redefine'][0] == 0){echo 'checked="checked"';} ?> id="<?php echo $prefix.'redefine_off';?>" value="0"/> <?php _e('No',$this->plugin_text_domain); ?>
		</p>
		<?php }	?>
		<div class="ui_ogtags_form ui_ogtags_form<?php echo $customTemp; ?> <?php if(is_object($post)){if($custom[$prefix.'redefine'][0] == 0){echo 'hidden';}} ?>">
			<?php echo $this->get_the_help_box($custom_help); ?>
			<<?php echo $custom_header; ?>><a href="#"><?php _e('Tags',$this->plugin_text_domain); ?></a></<?php echo $custom_header; ?>>
			<div>
				<?php
				foreach($this->og_tags as $tag=>$tag_name){
					$prefixtag = $prefix.$tag;
					$custom_value = $custom[$prefixtag][0];
					switch($tag){
						case 'url':
							$input ='';
							$tag_name = '';//'<br /><input class="widefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : get_permalink($post->ID)).'" />';
						break;
						case 'title':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $post->post_title).'" />';
						break;
						case 'site_name':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : get_bloginfo('name')).'" />';
						break;
						case 'type':
							$input ='<select name="'.$prefixtag.'" id="'.$prefixtag.'">';
							foreach($this->og_types as $globaltype=>$types){
								$input .='<optgroup label="'.strtoupper($globaltype).'">';
								foreach($types as $type=>$type_name)
									$input .='<option '.($custom_value == $type ? 'selected="selected"':'').' value="'.$type.'">'.$type_name.'</option>';
								$input .='</optgroup>';
							}
							$input .= '</select>';
						break;
						case 'description':
							$input = '<textarea class="widefat" id="'.$prefixtag.'" name="'.$prefixtag.'">'.($custom_value != '' ? $custom_value : $post->excerpt).'</textarea>';
						break;
						case 'app_id':
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : $this->plugin_option['app_id']).'" /> <i>'.__('Use custom value instead default',$this->plugin_text_domain).'</i>';
						break;
						case 'image':
							$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_image" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
						break;
						default:
							$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.$custom_value.'" />';
					}
					if($tag_name){
						?>
						<p><label class="up_label"><?php echo $tag_name; ?></label><?php echo $input; ?></p>
						<?php
					}
				}
				?>
			</div>
			<?php
			foreach($this->og_attachement_field as $type=>$tag_fields){
				switch($type){
					//video form
					case 'video':
						echo '<'.$custom_header.'><a href="#">'.__('Video Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('Facebook supports embedding video in SWF format only. File ith extension ".swf"',$this->plugin_text_domain).'</i>';
							echo '<div id="'.$prefix.'message_video" class="ui-state-highlight hidden">'.__('You must include a valid Image for your video in Tags section to be displayed in the news feed.',$this->plugin_text_domain).'</div>';
							foreach($tag_fields as $tag=>$tag_name){
								$prefixtag = $prefix.$tag;
								$custom_value = $custom[$prefixtag][0];
								switch($tag){
									case 'video':
										$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_video" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
									break;
									case 'video_type':
										$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'application/x-shockwave-flash').'" />';
									break;
									default:
										$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
								}
								?>
								<p><label class="up_label"><?php echo $tag_name; ?></label><?php echo $input; ?></p>
								<?php
							}
						echo '</div>';//fin toogle
					break;
					//audio form
					case 'audio':
						echo '<'.$custom_header.'><a href="#">'.__('Audio Attachement',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('In a similar fashion to Video you can add an audio file to your markup',$this->plugin_text_domain).'</i>';
							foreach($tag_fields as $tag=>$tag_name){
								$prefixtag = $prefix.$tag;
								$custom_value = $custom[$prefixtag][0];
								switch($tag){
									case 'audio':
										$input = '<input class="ogwidefat" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" /><img id="'.$prefix.'upload_mp3" src="'.$this->plugin_url_images.'upload_image.png" alt="'.__('Upload',$this->plugin_text_domain).'" class="AWD_button_media"/>';
									break;
									case 'audio_type':
										$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" readonly="readonly" value="'.($custom_value != '' ? $custom_value : 'application/mp3').'" />';
									break;
									default:
										$input = '<input  id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
								}
								?>
								<p><label class="up_label"><?php echo $tag_name; ?></label><?php echo $input; ?></p>
								<?php
							}
						echo '</div>';//fin toogle
					break;
					//isbn and upc code
					case 'isbn':
					case 'upc':
						foreach($tag_fields as $tag=>$tag_name){
							$prefixtag = $prefix.$tag;
							$custom_value = $custom[$prefixtag][0];
								echo '<'.$custom_header.'><a href="#">'.strtoupper($type).' '.__('code',$this->plugin_text_domain).'</a></'.$custom_header.'>';
								echo '<div>';
								echo '<label class="up_label">'.__('For products which have a UPC code or ISBN number',$this->plugin_text_domain).'</label>';
								echo '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
							echo '</div>';
						}
					break;
					//contact form
					case 'contact':
						echo '<'.$custom_header.'><a href="#">'.__('Contact infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('Consider including contact information if your page is about an entity that can be contacted.',$this->plugin_text_domain).'</i>';
							foreach($tag_fields as $tag=>$tag_name){
								$prefixtag = $prefix.$tag;
								$custom_value = $custom[$prefixtag][0];
								switch($tag){
									default:
										$input = '<input id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
								}
								?>
								<p><label class="up_label"><?php echo $tag_name; ?></label><?php echo $input; ?></p>
								<?php
							}
						echo '</div>';
					break;
					//location form
					case 'location':
						echo '<'.$custom_header.'><a href="#">'.__('Location infos',$this->plugin_text_domain).'</a></'.$custom_header.'>';
						echo '<div>';
							echo '<i>'.__('This is useful if your pages is a business profile or about anything else with a real-world location. You can specify location via latitude and longitude, a full address, or both.',$this->plugin_text_domain).'</i>';
							foreach($tag_fields as $tag=>$tag_name){
								$prefixtag = $prefix.$tag;
								$custom_value = $custom[$prefixtag][0];
								switch($tag){
									default:
										$input = '<input size="25" id="'.$prefixtag.'" name="'.$prefixtag.'" type="text" value="'.($custom_value != '' ? $custom_value : '').'" />';
								}
								?>
								<p><label class="up_label"><?php echo $tag_name; ?></label><?php echo $input; ?></p>
								<?php
							}
						echo '</div>';
					break;
				}
			}
			?>
			</div>
		</div>
		<?php //fin start fucntion div
	}
	/*
	* Admin content
	*/
	public function admin_content(){
		global $message;
		$page = $_GET['page'];
		//add_filter('screen_layout_columns', array(&$this, 'screen_layout'));
      	?>
		<div class="AWD_facebook_wrap" id="AWD_facebook_wrap">
			<?php 
			if($this->message){
				echo $this->message;
				unset($this->message); 
			}
			
			?>
			<div id="poststuff" class="metabox-holder has-right-sidebar">
				<form method="post">
					<div id="side-info-column" class="inner-sidebar">
						<div class="header_AWD_facebook_wrap">
							<h2 style="color:#627AAD;margin-top:0px;">
								<img style="vertical-align:middle;" src="<?php echo $this->plugin_url_images; ?>facebook.png" alt="facebook logo" class="AWD_button_media" /><?php _e($this->plugin_page_admin_name,$this->plugin_text_domain); ?>
								<sup style="color:#627AAD;font-size:0.6em;">v<?php echo $this->get_version(); ?></sup>
							</h2>
						</div>
			
						<?php
							//side bar always here
							do_meta_boxes($this->plugin_slug.'_box','side',null);
						?>
					</div>
					<div id="post-body" class="has-sidebar">
						<div id="post-body-content" class="has-sidebar-content">
							<?php 
							if($page == $this->plugin_slug)
								do_meta_boxes($this->plugin_slug.'_settings_box','normal',null);
							elseif($page == $this->plugin_slug.'_open_graph')
								do_meta_boxes($this->plugin_slug.'_open_graph_box','normal',null);
							elseif($page == $this->plugin_slug.'_plugins')
								do_meta_boxes($this->plugin_slug.'_plugins_box','normal',null);
							?>
					   </div>
					</div>
				</form>
			</div>
			<script type="text/javascript">
				//<![CDATA[
				jQuery(document).ready( function($) {
					// close postboxes that should be closed
					$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
					// postboxes setup
					postboxes.add_postbox_toggles('<?php echo $this->blog_admin_page_hook; ?>');
				});
				//]]>
			</script>
		</div>
		<div class="clear"></div>
		<?php
	}
	/*
	* Open graph admin
	*/
	public function open_graph_content(){
		include_once(dirname(__FILE__).'/inc/admin_open_graph.php');
	}
	/*
	* Comments on plugins contents 
	*/
	public function AWD_comments_content(){
		?>
		<fb:comments href="http://www.ahwebdev.fr/plugins/facebook-awd.html" num_posts="5" width="258"></fb:comments>
		<?php
	}
	/*
	* Activity contents
	*/
	public function activity_content(){
		$url = str_replace('http://','',home_url());
		if($this->plugin_option['parse_xfbml'] == 1){
			?>
			<fb:activity site="<?php echo $url; ?>" width="258" height="200" header="false" font="lucida grande" border_color="#F9F9F9" recommendations="true"></fb:activity>
		<?php }else{ ?>
			<iframe src="http://www.facebook.com/plugins/activity.php?site=<?php echo $url; ?>&amp;width=258&amp;height=300&amp;header=false&amp;colorscheme=light&amp;font=lucida+grande&amp;border_color=%23F9F9F9&amp;recommendations=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:258px; height:200px;" allowTransparency="true"></iframe>
			<?php 
		}
	}
	/*
	* plugin Options
	*/
	public function plugins_content(){
		include_once(dirname(__FILE__).'/inc/admin_plugins.php');
	}
	/*
	* Settings Options
	*/
	public function settings_content(){
		include_once(dirname(__FILE__).'/inc/admin_settings.php');
		include_once(dirname(__FILE__).'/inc/help/help_settings.php');
	}
	/*
	* Admin fcbk info content
	*/
	public function fcbk_content(){
		$options = array();
		$options['login_button_width'] = 200;
		$options['login_button_profile_picture'] = 1;
		$options['login_button_faces'] = 'false';
		$options['login_button_maxrow'] = 1;
		$options['login_button_logout_value'] = __("Logout",$this->plugin_text_domain);
		$this->print_the_login_button($options);
	}
	/*
	* return the html for login button
	*/
	public function get_the_login_button($options=array()){
		
		$width = ($options['login_button_width'] == '' ? $this->plugin_option['login_button_width'] : $options['login_button_width']);
		$show_profile_picture = ($options['login_button_profile_picture'] == '' ? $this->plugin_option['login_button_profile_picture'] : $options['login_button_profile_picture']);
		$show_faces = (($options['login_button_faces'] == '' ? $this->plugin_option['login_button_faces'] : $options['login_button_faces']) == 1 ? 'true' : 'false');
		$maxrow = ($options['login_button_maxrow'] == '' ? $this->plugin_option['login_button_maxrow'] : $options['login_button_maxrow']);
		$logout_value = ($options['login_button_logout_value'] == '' ? $this->plugin_option['login_button_logout_value'] : $options['login_button_logout_value']);
		$login_button = '<fb:login-button perms="email,'.$this->plugin_option['perms'].'" show-faces="'.$show_faces.'" width="'.$width.'" max-rows="'.$maxrow.'" size="medium" ></fb:login-button>';
		
		//if some options defined
		if(empty($options['case'])){
			if($this->me)
				$case = 'profile';
			//user not connected but he can in xfbml...
			else if($this->plugin_option['connect_enable'] == 1 && $this->plugin_option['parse_xfbml'] == 1)
				$case = 'login_xfbml';
			//or via the php sdk...
			else if($this->plugin_option['connect_enable'] == 1)
				$case = 'login';
			//no fb connect
			else 
				$case = 'message_connect_active';
		}else{
			$case = $options['case'];
		}
		
		switch($case){
			case 'profile':
				$html = '';
				$html .= '<div class="AWD_profile">'."\n";
				if($show_profile_picture == 1 && $show_faces == 'false'){
					$html .= '<div class="AWD_profile_image"><a href="'.$this->me['link'].'" target="_blank"><img src="https://graph.facebook.com/'.$this->uid.'/picture"></a></div>'."\n";
				}
				$html .='<div class="AWD_right">'."\n";
					if($show_faces == 'true'){
						$html .='<div class="AWD_faces">'.$login_button.'</div>'."\n";
					}else{
						$html .='<div class="AWD_name"><a href="'.$this->me['link'].'" target="_blank">'.$this->me['name'].'</a></div>'."\n";
					}
						$html .='<div class="AWD_logout"><a href="'.wp_logout_url().'">'.$logout_value.'</a></div>'."\n";
				$html .='</div>'."\n";
				$html .='<div class="clear"></div>'."\n";
				$html .='</div>'."\n";
				return $html;
			break;	
		
			case 'login_xfbml':
				return '
				<div class="AWD_facebook_login">'.$login_button.'</div>'."\n";;
			break;
			
			case 'login':
				return '
				<div class="AWD_facebook_login">
					<a href="'.$this->login_url.'" ><img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif"></a>
				</div>'."\n";
			break;
		
			case 'message_connect_active':
				if(is_admin())
				return '
				<div class="ui-state-highlight">'.sprintf(__('You should enable FB connect in %sApp settings%s to use Login buttons',$this->plugin_text_domain),'<a href="admin.php?page='.$this->blog_admin_page_hook.'">','</a>').'</div>';
			break;
		}
		?>
		<div class="clear"></div>
		<?php
	}
	/*
	* print the content off the login/logut
	*/
	public function print_the_login_button($options=array()){
		echo $this->get_the_login_button($options);
	}
	/*
	 * Admin css
	 */
	public function admin_enqueue_css(){
		wp_enqueue_style($this->plugin_slug.'-admin', $this->plugin_url.'/css/admin_styles.css',array($this->plugin_slug.'-jquery-ui'));
		wp_enqueue_style($this->plugin_slug.'-jquery-ui', $this->plugin_url.'/css/jquery-ui-1.8.12.custom.css');
		wp_enqueue_style('thickbox'); 
	}
	/*
	 * JS all admin
	 */
	public function admin_enqueue_js(){
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('common');
		wp_enqueue_script('wp-list');
		wp_enqueue_script('postbox');
		wp_enqueue_script($this->plugin_slug.'-jquery-ui',$this->plugin_url.'/js/jquery-ui-1.8.12.custom.min.js',array('jquery'));
		wp_enqueue_script($this->plugin_slug.'-js',$this->plugin_url.'/js/facebook_awd.js',array('jquery'));
	}
	/*
	 * FBJS every where
	 */
	public function enqueue_fbjs(){
		//facebook script
		if( defined('WPLANG') )
			if(WPLANG==''){
				$connect_lang = "en_US";
			}else{
				$connect_lang = WPLANG;
			}
		wp_enqueue_script( 'AWD_facebook_js', 'http://connect.facebook.net/'.$connect_lang.'/all.js'.($this->plugin_option['parse_xfbml'] == 1 ? '#xfbml=1' : ''));
	}
	/*
	 * options metabox columns etc...
	 */
	public function screen_layout($columns, $screen) {
		if ($screen == $this->$blog_admin_page_hook) {
			$columns[$this->$blog_admin_page_hook] = 2;
		}
		return $columns;
	}
	/*
	* Save the post custom from open graph form
	*/
	public function save_options_post_editor($post_id){
		foreach($_POST as $__post=>$val){
			//should have ogtags in prefix present to be saved
			if(ereg('ogtags_',$__post) AND trim($val) !=''){
				update_post_meta($post_id, $__post, $val);
			}
		}
	}
	/*
	* if some option were saved via post
	*/
	public function hook_post_from_plugin_options(){		
		if($_POST[$this->plugin_option_pref.'submit'] AND wp_verify_nonce($_POST[$this->plugin_option_pref.'_nonce_options_update_field'],$this->plugin_slug.'_update_options')){
			//unset submit to not be stored
			unset($_POST[$this->plugin_option_pref.'submit']);
			unset($_POST[$this->plugin_option_pref.'_nonce_options_update_field']);
			unset($_POST['_wp_http_referer']);
			if($this->update_options_from_post())
				$this->message = '<div id="message" class="updated"><p>'.__('Options updated',$this->plugin_text_domain).'</p></div>';
			else
				$this->message = '<div id="message" class="error"><p>'.__('Options not updated there is an error...',$this->plugin_text_domain).'</p></div>';
		}
	}
	/*
	* function to catch firest image in html
	*/
	function catch_that_image() {
  		global $post, $posts;
  		$first_img = '';
  		ob_start();
  		ob_end_clean();
  		$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  		$first_img = $matches [1] [0];
  		if(empty($first_img)){ //Defines a default image
    		//$first_img = "/images/default.jpg";
  		}
  		return $first_img;
	}
	//****************************************************************************************
	//	FRONT AND CONTENT
	//****************************************************************************************
	/*
	* INIT fcbk
	*/
	public function init_php(){
		$this->fcbk = new Facebook(array(
			'appId'  => $this->plugin_option['app_id'],
			'secret' => $this->plugin_option['app_secret_key'],
			'cookie' => true,
		));
		
		//we need to update api call fucntion in facebook class. 01/05/2011 (add stripslashes() in validateSessionObject function)
		$this->session = $this->fcbk->getSession();
		$this->me = null;
		// Session based API call.
		if($this->session){
			try{
				$this->uid = $this->fcbk->getUser();
				$this->me = $this->fcbk->api('/me');
				$updated = date("l, F j, Y", strtotime($me['updated_time']));
			}catch(FacebookApiException $e){
				error_log($e);
			}
		}
		// login or logout url will be needed depending on current user state.
		if($this->me){
			$this->logout_url = $this->fcbk->getLogoutUrl();
			//modify logout url
			add_filter('logout_url', array(&$this,'logout_url'));
		}else{
			$this->login_url = $this->fcbk->getLoginUrl();
		}
	}
	/*
	* login user with facebook account
	*/
	public function login_user(){
		include_once(dirname(__FILE__).'/inc/login_process.php');
	}
	/*
	* Change logout url for users connected with Facebook
	*/
	public function logout_url($url,$redirect=""){
		if($this->session)
			//here we can use $this->logout_url;
			//but that's better to use FBJS to logout
			return "javascript:FB.logout(function(){location.href='" .$url."'})";
		else
			return $url;
	}
	/*
	* filter the content
	*/
	public function the_content($content){
		global $post;
		$exclude_post_type = explode(",",$this->plugin_option['like_button_exclude_post_type']);
		$exclude_post_page_id = explode(",",$this->plugin_option['like_button_exclude_post_id']);
		$exclude_terms_slug = explode(",",$this->plugin_option['like_button_exclude_terms_slug']);
		
		//get the all terms for the post
		$taxonomies=get_taxonomies($args,'objects'); 
		$terms = array();
		if($taxonomies){
			foreach ($taxonomies  as $taxonomy) {
				$temp_terms = get_the_terms($post->id, $taxonomy->name);
				if($temp_terms)
				foreach ($temp_terms  as $temp_term)
					if($temp_term){
						$terms[] = $temp_term->slug;
						$terms[] = $temp_term->term_id;
					}
			}
		}  
		//say if we need to exclude this post for terms
		$is_term_to_exclude = false;
		if($terms)
			foreach($terms as $term){
				if(in_array($term,$exclude_terms_slug))
					$is_term_to_exclude = true;
			}
		
		if(!in_array($post->post_type,$exclude_post_type) && !in_array($post->ID,$exclude_post_page_id) && !$is_term_to_exclude){
			$like_button = $this->get_the_like_button($post);
			if(is_page() && $this->plugin_option['like_button_on_pages'])
				if($this->plugin_option['like_button_place_on_pages'] == 'bottom')
					return $content.$like_button;
				else
					return $like_button.$content;
	
			if(is_single() && $this->plugin_option['like_button_on_posts'])
				if($this->plugin_option['like_button_place_on_posts'] == 'bottom')
					return $content.$like_button;
				else
					return $like_button.$content;
		}
		return $content;
	}
	/*
	* Add Js init fcbk to footer  ADMIN AND FRONT 
	* Print debug if active here
	*/
	public function connect_footer(){
		?>
		<div id="fb-root"></div>
		<script type="text/javascript">
			jQuery(document).ready( function($) {
				FB.init({
					appId   : '<?php echo  $this->plugin_option["app_id"]; ?>',
				//	session : '<?php echo json_encode($this->session); ?>', // don't refetch the session when PHP already has it
					status  : true, // check login status
					cookie  : true, // enable cookies to allow the server to access the session
					xfbml   : <?php echo ($this->plugin_option['parse_xfbml'] == 1 ? 'true' : 'false'); ?>// parse XFBML
				});
				FB.Event.subscribe('auth.login', function(response) {
	      			//user connect just reload the page
	      			if(response.session){
	      				window.location.reload();
	      			}
	  			});
			});
		</script>
	<?php
	}
	/*
	* generate the open graph tags
	* option array() 
	*/
	public function get_the_open_graph_tags($options=array()){
		if(!empty($options)){
			foreach($options as $tag=>$tag_value){
				$html .= '<meta property="'.$tag.'" content="'.$tag_value.'"/>'."\n";
			}
		}else{
			$html .= '<!-- '.__('Error No tags...',$this->plugin_text_domain).' -->'."\n";
		}
		return $html;
	}
	/*
	* construct the open graph tags
	* prefix string
	* array_pattern array() list of pattern to replace
	* array_replace array() list of value to replace
	* custom_post object post if exist
	*/
	public function construct_open_graph_tags($prefix_option,$array_pattern,$array_replace,$custom_post=array()){
		$og_tags = $this->og_tags;
		//define all tags we need to display
		foreach($this->og_attachement_field as $type=>$tag_fields){
			foreach($tag_fields as $tag=>$tag_name){
				$tag_attachment_fields[$tag] = $tag_name;
			}
		}
		//add attachment fields to global fields for display
		$og_tags_final = array_merge($og_tags,$tag_attachment_fields);
		//foreach tags, set value
		foreach($og_tags_final as $tag=>$tag_name){
			$option_value = '';
			//if tags is empty because not set in plugin for retro actif on post and page
			if($custom_post[$this->plugin_option_pref.'ogtags_disable'][0] == '')
				$custom_post[$this->plugin_option_pref.'ogtags_disable'][0] = 0;
 			//if tags is enable from editor
 			if($custom_post[$this->plugin_option_pref.'ogtags_disable'][0] == 0){
				//if general settings of this type is enable
				if($this->plugin_option[$prefix_option.'disable'] == 0 && $this->plugin_option[$prefix_option.'disable'] != ''){
					//if choose to redefine from post
					if($custom_post[$this->plugin_option_pref.'ogtags_redefine'][0] == 1){
						$option_value = $custom_post[$this->plugin_option_pref.'ogtags_'.$tag][0];
						$audio = $custom_post[$this->plugin_option_pref.'ogtags_audio'][0];
						$video = $custom_post[$this->plugin_option_pref.'ogtags_video'][0];
						$image = $custom_post[$this->plugin_option_pref.'ogtags_image'][0];
					//else use general settings
					}else{
						$option_value = $this->plugin_option[$prefix_option.$tag];
						$audio = $this->plugin_option[$prefix_option.'audio'];
						$video = $this->plugin_option[$prefix_option.'video'];
						$image = $this->plugin_option[$prefix_option.'image'];
					}
					//set url with a pattern
					if($tag == 'url')
						$option_value = '%CURRENT_URL%';
					//proces the patern replace
					$option_value = str_ireplace($array_pattern,$array_replace,$option_value);
					//clean the \r\n value and replace by space
					$option_value = str_replace("\n"," ",$option_value);
					$option_value = str_replace("\r","",$option_value);
					$option_value = str_replace("\t","",$option_value);
					//for video	and audio
					//if video src or audio src is null so don't display tags
					if(ereg('audio',$tag) && $audio =='')
						continue;
					elseif(ereg('video',$tag) && $video =='')
						continue;
					//need image for video to work
					elseif(ereg('video',$tag) && $image =='')
						continue;
					elseif(($tag == 'app_id' || $tag == 'admins' || $tag == 'page_id') && $option_value!='')
						$options['fb:'.$tag] = $option_value;
					elseif($option_value !='')
						$options['og:'.$tag] = $option_value;
				}
			
			
				
		
			}
		
		}
		return $options;
	}
	/*
	* echo the open graph tags
	* option array() 
	*/
	public function define_open_graph_tags_header(){
		$current_post_type = get_post_type();
		$options = array();
		$blog_name = get_bloginfo('name');
		$blog_description = str_replace(array("\n","\r"),"",get_bloginfo('description'));
		$home_url = home_url();
	
		switch(1){
			//for posts
			case is_front_page():
			case is_home():
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%",'%CURRENT_URL%');
				$array_replace = array($blog_name,$blog_description,$home_url,$home_url);
				$options = $this->construct_open_graph_tags('ogtags_frontpage_',$array_pattern,$array_replace);
			break;
			//for all type of post
			case is_page():
			case is_single():
				global $post;
				$custom_post = get_post_custom($post->ID);
				$postypes_media = get_post_types(array('label'=>'Media'),'objects');
				$postypes = get_post_types(array('show_ui'=>true),'objects');
				//if find attachement type
				if(is_object($postypes_media['attachment']))
					$postypes['attachment'] = $postypes_media['attachment'];				
				//post types
				//change name of prefix for post type and post page
				if($current_post_type == 'post') $prefix_option = 'ogtags_post_';
				elseif($current_post_type == 'page') $prefix_option = 'ogtags_page_';
				else
					foreach($postypes as $postypes_name=>$type_values){
						if($current_post_type == $postypes_name){
						 	$prefix_option = 'ogtags_custom_post_types_'.$postypes_name.'_';						 	
							$type = $type_values->label;
						}
					}
				//thumbnails if thumb support and has one
				if(current_theme_supports('post-thumbnails') && has_post_thumbnail()) {
                	$thumbURL = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID),'');
                	$img = $thumbURL[0];
                }else{
                    unset($img);
                    if($wpzoom_cf_use == 'Yes'){
                    	$img = get_post_meta($post->ID, $wpzoom_cf_photo, true);
                	}else{
                    	if(!$img){
                    		$img = $this->catch_that_image($post->ID);
                   		}
                	}
                }
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%POST_TITLE%","%POST_EXCERPT%","%POST_IMAGE%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,$post->post_title,$post->post_excerpt,$img,get_permalink($post->ID));
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace,$custom_post);
			break;
			//for tag archives
			case is_author():
				global $wp_query;
				$author_slug = $wp_query->query_vars['author_name'];
				$current_author = get_user_by('slug',$author_slug);
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Authors';
				//get avatar for replace in pattern
				$avatar = get_avatar($current_author->ID, '50', '','');
				//get the url of avatar
				$gravatar_attributes = simplexml_load_string($avatar);
				if(!empty($gravatar_attributes['src']))
					$gravatar_url = $gravatar_attributes['src'];
				$prefix_option = 'ogtags_author_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%AUTHOR_TITLE%","%AUTHOR_IMAGE%","%AUTHOR_DESCRIPTION%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),$gravatar_url,$current_author->description,$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
			case is_tag():
			case is_date():
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Archives';
				$prefix_option = 'ogtags_archive_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%ARCHIVE_TITLE%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
			//for taxonomies register public
			case is_tax():
				global $wp_query;
				$taxonomy_slug = $wp_query->query_vars['taxonomy'];
				$taxonomy_name = get_term_by('slug',$value,$taxonomy_slug);
				$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
				$type =  'Taxonomies';
				$prefix_option = 'ogtags_taxonomies_'.$taxonomy_slug.'_';
				$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%TERM_TITLE%","%TERM_DESCRIPTION%","%CURRENT_URL%");
				$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),term_description(),$current_archive_url);
				$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
				$type = 'TAX';
			break;
			//for categories
			case is_category():
					$current_archive_url = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
					$type =  'Categories';
					$prefix_option = 'ogtags_taxonomies_category_';
					$array_pattern = array("%BLOG_TITLE%","%BLOG_DESCRIPTION%","%BLOG_URL%","%TERM_TITLE%","%TERM_DESCRIPTION%","%CURRENT_URL%");
					$array_replace = array($blog_name,$blog_description,$home_url,trim(wp_title('',false)),category_description(),$current_archive_url);
					$options = $this->construct_open_graph_tags($prefix_option,$array_pattern,$array_replace);
			break;
		}
		//if no options, no tags
		if(!empty($options)){
			echo "\n".'<!-- '.$this->plugin_name.' [v'.$this->get_version().'] START Open Graph Tags for '.$type.' -->'."\n";
			echo $this->get_the_open_graph_tags($options);
			if(empty($options['og:image']))
				echo '<!-- '.__("WARNING Image is emtpy", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:title']))
				echo '<!-- '.__("WARNING Title is empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['og:site_name']))
				echo '<!-- '.__("WARNING Site Name is empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			if(empty($options['fb:admins']) AND empty($options['fb:app_id']))
				echo '<!-- '.__("WARNING Admins id or app ID are empty", $this->plugin_text_domain).' | '.$this->plugin_name.' -->'."\n";
			echo '<!-- '.$this->plugin_name.' END Open Graph Tags -->'."\n";
		}
	}
	
	
	//****************************************************************************************
	//	LIKE BUTTON
	//****************************************************************************************
	/*
	* Return the like button
	*/
	public function get_the_like_button($post="",$options=''){
		$href = get_permalink($post->ID);
		if(is_object($post))
		    $href = get_permalink($post->ID);
		else    
            $href =($options['like_button_url'] == '' ? $this->plugin_option['like_button_url'] : $options['like_button_url']);
		
		$send = (($options['like_button_send'] == '' ? $this->plugin_option['like_button_send'] : $options['like_button_send']) == 1 ? 'true' : 'false');
		$width = ($options['like_button_width'] == '' ? $this->plugin_option['like_button_width'] : $options['like_button_width']);
		$colorscheme = ($options['like_button_colorscheme'] == '' ? $this->plugin_option['like_button_colorscheme'] : $options['like_button_colorscheme']);
		$show_faces = (($options['like_button_faces'] == '' ? $this->plugin_option['like_button_send'] : $options['like_button_faces']) == 1 ? 'true' : 'false');
		$fonts = ($options['like_button_fonts'] == '' ? $this->plugin_option['like_button_fonts'] : $options['like_button_fonts']);
		$action = ($options['like_button_action'] == '' ? $this->plugin_option['like_button_action'] : $options['like_button_action']);
		$layout = ($options['like_button_layout'] == '' ? $this->plugin_option['like_button_layout'] : $options['like_button_layout']);
		$height = ($options['like_button_height'] == '' ? $this->plugin_option['like_button_height'] : $options['like_button_height']);
		$xfbml = (($options['like_button_xfbml'] == '' ? $this->plugin_option['like_button_xfbml'] : $options['like_button_xfbml']) == 1 ? true : false);
		if($height == ''){
			if($layout == 'box_count')
				$height = '90';
			elseif($layout == 'button_count')
				$height = '21';
			else
				$height = '35';
		}

		if($this->plugin_option['like_button_content'] !='')
			return $this->plugin_option['like_button_content'];
		else if($xfbml && $this->plugin_option['parse_xfbml'] == 1){
			return '<div id="AWD_like_button"><fb:like href="'.$href.'" send="'.$send.'" width="'.$width.'" colorscheme="'.$colorscheme.'" layout='.$layout.' show_faces="'.$show_faces.'" font="'.$fonts.'" action="'.$action.'"></fb:like></div>';
		}else if(!$xfbml || $this->plugin_option['parse_xfbml'] == 0){
			return '<div id="AWD_like_button"><iframe src="http://www.facebook.com/plugins/like.php?href='.urlencode($href).'&amp;send='.$send.'&amp;layout='.$layout.'&amp;width='.$width.'&amp;show_faces='.$show_faces.'&amp;action='.$action.'&amp;colorscheme='.$colorscheme.'&amp;font='.$fonts.'&amp;height='.$height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;" allowTransparency="true"></iframe></div>';
		}else
			return '<div style="color:red;">'.__("There is an error, please verify the settings for the Like Button URL",$this->plugin_text_domain).'</div>';
		
	}
	/*
	* Print the like button
	*/
	public function print_the_like_button(){
		echo $this->get_the_like_button();
	}
	//****************************************************************************************
	//	LIKE BOX 
	//****************************************************************************************
	/*
	* Return the like button
	*/
	public function get_the_like_box($options=''){
		$href = ($options['like_box_url'] == '' ? $this->plugin_option['like_box_url'] : $options['like_box_url']);
		$width = ($options['like_box_width'] == '' ? $this->plugin_option['like_box_width'] : $options['like_box_width']);
		$colorscheme = ($options['like_box_colorscheme'] == '' ? $this->plugin_option['like_box_colorscheme'] : $options['like_box_colorscheme']);
		$show_faces = (($options['like_box_faces'] == '' ? $this->plugin_option['like_box_faces'] : $options['like_box_faces']) == 1 ? 'true' : 'false');
		$show_stream = (($options['like_box_stream'] == '' ? $this->plugin_option['like_box_stream'] : $options['like_box_stream']) == 1 ? 'true' : 'false');
		$show_header = (($options['like_box_header'] == '' ? $this->plugin_option['like_box_header'] : $options['like_box_header']) == 1 ? 'true' : 'false');
		$height = ($options['like_box_height'] == '' ? $this->plugin_option['like_box_height'] : $options['like_box_height']);
		$xfbml = (($options['like_box_xfbml'] == '' ? $this->plugin_option['like_box_xfbml'] : $options['like_box_xfbml']) == 1 ? true : false);
		
		if($height == ''){
			if($show_stream == 'true' AND $show_faces == 'true')
				$height = '600';
			else if($show_stream == 'true')
				$height = '427';
			else
				$height = '62';
		}
		
		if($this->plugin_option['like_box_url'] == '' && $href == '')
			return '<div style="color:red;">'.__("There is an error, please verify the settings for the Like Box URL",$this->plugin_text_domain).'</div>';
		else if($xfbml && $this->plugin_option['parse_xfbml'] == 1){
			return '<div id="AWD_like_box"><fb:like-box href="'.$href.'" width="'.$width.'" colorscheme="'.$colorscheme.'" show_faces="'.$show_faces.'" stream="'.$show_stream.'" header="'.$show_header.'"></fb:like-box></div>';
		}else if(!$xfbml || $this->plugin_option['parse_xfbml'] == 0){
			return '<div id="AWD_like_box"><iframe src="http://www.facebook.com/plugins/likebox.php?href='.urlencode($href).'&amp;width='.$width.'&amp;colorscheme='.$colorscheme.'&amp;show_faces='.$show_faces.'&amp;stream='.$show_stream.'&amp;header='.$show_header.'&amp;height='.$height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;" allowTransparency="true"></iframe></div>';
		}else
			return '<div style="color:red;">'.__("There is an error, please verify the settings for the Like Box URL",$this->plugin_text_domain).'</div>';
	}
	//****************************************************************************************
	//	ACTIVITY BOX 
	//****************************************************************************************
	/*
	* Return the activity button
	*/
	public function get_the_activity_box($options=''){
		$domain = ($options['activity_domain'] == '' ? $this->plugin_option['activity_domain'] : $options['activity_domain']);
		$width = ($options['activity_width'] == '' ? $this->plugin_option['activity_width'] : $options['activity_width']);
		$height = ($options['activity_height'] == '' ? $this->plugin_option['activity_height'] : $options['activity_height']);
		$show_header = (($options['activity_header'] == '' ? $this->plugin_option['activity_header'] : $options['activity_header']) == 1 ? 'true' : 'false');
		$colorscheme = ($options['activity_colorscheme'] == '' ? $this->plugin_option['activity_colorscheme'] : $options['activity_colorscheme']);
		$fonts = ($options['activity_fonts'] == '' ? $this->plugin_option['activity_fonts'] : $options['activity_fonts']);
		$border_color = ($options['activity_border_color'] == '' ? $this->plugin_option['activity_border_color'] : $options['activity_border_color']);
		$xfbml = (($options['activity_xfbml'] == '' ? $this->plugin_option['activity_xfbml'] : $options['activity_xfbml']) == 1 ? true : false);
		$recommendations = (($options['activity_recommendations'] == '' ? $this->plugin_option['activity_recommendations'] : $options['activity_recommendations']) == 1 ? 'true' : 'false');

		
		if($this->plugin_option['activity_domain'] == '' && $domain == '')
			return '<div style="color:red;">'.__("There is an error, please verify the settings for the Acivity Box DOMAIN",$this->plugin_text_domain).'</div>';
		else if($xfbml && $this->plugin_option['parse_xfbml'] == 1){
			return '<div id="AWD_activity"><fb:activity site="'.$domain.'" width="'.$width.'" height="'.$height.'" header="'.$show_header.'" font="'.$fonts.'" border_color="#'.$border_color.'" recommendations="'.$recommendations.'"></fb:activity></div>';
		}else if(!$xfbml || $this->plugin_option['parse_xfbml'] == 0){
			return '<div id="AWD_activity"><iframe src="http://www.facebook.com/plugins/activity.php?site='.$domain.'&amp;width='.$width.'&amp;height='.$height.'&amp;header='.$show_header.'&amp;colorscheme='.$colorscheme.'&amp;font='.$fonts.'&amp;border_color=%23'.$border_color.'&amp;recommendations='.$recommendations.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$width.'px; height:'.$height.'px;" allowTransparency="true"></iframe></div>';
		}else
			return '<div style="color:red;">'.__("There is an error, please verify the settings for the Acivity Box DOMAIN",$this->plugin_text_domain).'</div>';
	}
	
	//****************************************************************************************
	//	REGISTER WIDGET
	//****************************************************************************************
	/*
	* Like box register widgets
	*/
	public function register_AWD_facebook_widgets(){
		 register_widget("AWD_facebook_like_button");
		 register_widget("AWD_facebook_like_box");
		 register_widget("AWD_facebook_login_button");
		 register_widget("AWD_facebook_activity");
	}
	
	//****************************************************************************************
	//	DEBUG AND DEV
	//****************************************************************************************
	/*
	* Debug
	*/
	public function debug_content(){
		$this->Debug(array('$AWD_facebook->fcbk'=>$this->fcbk,"$AWD_facebook->me"=>$this->me,"DEBUG FCBK"=>$this->debug_echo));
		echo "
		<h2>To DO 12/05/2011</h2>
		- add widget login, like button and <s>like box</s><br>
		- <s>add design for different like, and rest of design for other box</s><br>
		- add fb-comment possibility...<br>
		- add shortcode<br>
		- add shortcode button for editor<br>
		- <s>add a generator in admin for template (same as shortcode? iframe ?)</s><br>
		- finish other tabs...
		";
	}

}


$AWD_facebook = new AWD_facebook();

//****************************************************************************************
//	WIDGET LIKE BOX include
//****************************************************************************************
include_once(dirname(__FILE__).'/inc/widgets/widget_like_box.php');
include_once(dirname(__FILE__).'/inc/widgets/widget_login_button.php');
include_once(dirname(__FILE__).'/inc/widgets/widget_like_button.php');
include_once(dirname(__FILE__).'/inc/widgets/widget_activity.php');

?>
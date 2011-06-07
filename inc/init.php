<?php
/*
*
* init AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/

/*
TODO 
We need to call options from database qith sql and not get_option, because it's a lot of requests...
*/


$this->plugin_option = array();

//check post and save
$this->hook_post_from_plugin_options();
$this->wpdb = $wpdb;
$this->plugin_url = plugins_url("",dirname(__FILE__));
$this->plugin_url_images = $this->plugin_url."/css/images/";



//****************************************************************************************
//  Objects lib
//****************************************************************************************
$this->og_tags = array(
	'url'=> __('Url',$this->plugin_text_domain),
	'title'=> __('Title',$this->plugin_text_domain),
	'type'=> __('Type',$this->plugin_text_domain),
	'description'=> __('Description',$this->plugin_text_domain),
	'image'=> __('Image url (50x50 is better)',$this->plugin_text_domain),
	'admins' => __('Admin ids',$this->plugin_text_domain),
	'app_id' => __('App ID',$this->plugin_text_domain),
	'site_name'=> __('Site Name',$this->plugin_text_domain)
);
$this->og_types = array(
    'activities' => array(
        'activity'=>__('Activity',$this->plugin_text_domain),
        'sport'=>__('Sport',$this->plugin_text_domain)
     ),
     'businesses' => array(
        'bar'=>__('Bar',$this->plugin_text_domain),
        'company'=>__('Company',$this->plugin_text_domain),
        'cafe'=>__('Cafe',$this->plugin_text_domain),
        'hotel'=>__('Hotel',$this->plugin_text_domain),
        'restaurant'=>__('Restaurant',$this->plugin_text_domain)
     ),
     'groups' => array(
        'cause'=>__('Cause',$this->plugin_text_domain),
        'sports_league'=>__('Sports league',$this->plugin_text_domain),
        'sports_team'=>__('Sports team',$this->plugin_text_domain)
     ),
     'organizations' => array(
        'band'=>__('Band',$this->plugin_text_domain),
        'government'=>__('Government',$this->plugin_text_domain),
        'non_profit'=>__('Non profit',$this->plugin_text_domain),
        'school'=>__('School',$this->plugin_text_domain),
        'university'=>__('University',$this->plugin_text_domain)
     ),
     'people' => array(
        'actor'=>__('Actor',$this->plugin_text_domain),
        'athlete'=>__('Athlete',$this->plugin_text_domain),
        'director'=>__('Director',$this->plugin_text_domain),
        'musician'=>__('Musician',$this->plugin_text_domain),
        'politician'=>__('Politician',$this->plugin_text_domain),
        'public_figure'=>__('Public figure',$this->plugin_text_domain)
     ),
     'places' => array(
        'city'=>__('City',$this->plugin_text_domain),
        'country'=>__('Country',$this->plugin_text_domain),
        'landmark'=>__('Landmark',$this->plugin_text_domain),
        'state_province'=>__('State province',$this->plugin_text_domain)
     ),
     'products' => array(
        'album'=>__('Album',$this->plugin_text_domain),
        'book'=>__('Book',$this->plugin_text_domain),
        'drink'=>__('Drink',$this->plugin_text_domain),
        'food'=>__('Food',$this->plugin_text_domain),
        'game'=>__('Game',$this->plugin_text_domain),
        'product'=>__('Product',$this->plugin_text_domain),
        'song'=>__('Song',$this->plugin_text_domain),
        'movie'=>__('Movie',$this->plugin_text_domain),
        'tv_show'=>__('Tv show',$this->plugin_text_domain)
     ),
     'websites' => array(
        'blog'=>__('Blog',$this->plugin_text_domain),
        'website'=>__('Website',$this->plugin_text_domain),
        'article'=>__('Article',$this->plugin_text_domain)
     )
);
//attachement
$this->og_attachement_field = array(
	'video' => array(
		'video'=>__('Video src (swf only) ',$this->plugin_text_domain),
		'video_width'=>__('Width (max: 398px)',$this->plugin_text_domain),
		'video_height'=>__('Height (max: 460px)',$this->plugin_text_domain),
		'video_type'=>__('Type',$this->plugin_text_domain)
	),
	'audio' => array(
		'audio'=>__('Audio src (mp3 only)',$this->plugin_text_domain),
		'audio_title'=>__('Title',$this->plugin_text_domain),
		'audio_artist'=>__('Artist',$this->plugin_text_domain),
		'audio_album'=>__('Album',$this->plugin_text_domain),
		'audio_type'=>__('Type',$this->plugin_text_domain)
	),
	'contact' => array(
		'contact_email'=>__('Email',$this->plugin_text_domain),
		'contact_phone_number'=>__('Phone number',$this->plugin_text_domain),
		'contact_fax_number'=>__('Fax number',$this->plugin_text_domain),
	)
	,
	'location' => array(
		'location_latitude'=>__('Latitude',$this->plugin_text_domain),
		'location_longitude'=>__('Longitude',$this->plugin_text_domain),
		'location_street-address'=>__('Street address',$this->plugin_text_domain),
		'location_locality'=>__('Locality',$this->plugin_text_domain),
		'location_region'=>__('Region',$this->plugin_text_domain),
		'location_postal-code'=>__('Postal code',$this->plugin_text_domain),
		'location_country-name'=>__('Country name',$this->plugin_text_domain),
	),
	'isbn' => array(
		'isbn'=>__('Isbn',$this->plugin_text_domain)
	),
	'upc' => array(
		'upc'=>__('Upc',$this->plugin_text_domain)
	)
);

//****************************************************************************************
//  Settings
//****************************************************************************************
$AWD_options = $this->wpdb->get_results("SELECT option_name,option_value FROM ".$this->wpdb->options." WHERE option_name LIKE '%".$this->plugin_option_pref."%'",'OBJECT');
foreach($AWD_options as $options=>$object){
	$this->plugin_option[str_ireplace($this->plugin_option_pref,"",$object->option_name)] = $object->option_value;
}
//end settings vars


//Define Default Vars if not set
if($this->plugin_option['connect_enable'] == '')
	$this->plugin_option['connect_enable'] = 0;
if($this->plugin_option['open_graph_enable'] == '')
	$this->plugin_option['open_graph_enable'] = 1;


//****************************************************************************************
//  like button
//****************************************************************************************
if($this->plugin_option['like_button_on_pages'] == '')
	$this->plugin_option['like_button_on_pages'] = 0;
if($this->plugin_option['like_button_place_on_pages'] == '')
	$this->plugin_option['like_button_place_on_pages'] = 'top'; 
if($this->plugin_option['like_button_on_posts'] == '')
	$this->plugin_option['like_button_on_posts'] = 0;
if($this->plugin_option['like_button_place_on_posts'] == '')
	$this->plugin_option['like_button_place_on_posts'] = 'top';
if($this->plugin_option['like_button_colorscheme'] == '')
	$this->plugin_option['like_button_colorscheme'] = 'light';
if($this->plugin_option['like_button_send'] == '' || $this->plugin_option['like_button_xfbml'] == 0)
	$this->plugin_option['like_button_send'] = 0;
if($this->plugin_option['like_button_height'] == '')
	$this->plugin_option['like_button_height'] = 40;
if($this->plugin_option['like_button_height'] == '')
	$this->plugin_option['like_button_height'] = 35;
if($this->plugin_option['like_button_faces'] == '')
	$this->plugin_option['like_button_faces'] = 0;
if($this->plugin_option['like_button_xfbml'] == '')
	$this->plugin_option['like_button_xfbml'] = 0;
if($this->plugin_option['like_button_action'] == '')
	$this->plugin_option['like_button_action'] = 'like';
if($this->plugin_option['like_button_layout'] == '')
	$this->plugin_option['like_button_layout'] = 'standard';

//****************************************************************************************
//  like box
//****************************************************************************************
if($this->plugin_option['like_box_url'] == '')
	$this->plugin_option['like_box_url'] = '';
if($this->plugin_option['like_box_colorscheme'] == '')
	$this->plugin_option['like_box_colorscheme'] = 'light';
if($this->plugin_option['like_box_width'] == '')
	$this->plugin_option['like_box_width'] = 292;
if($this->plugin_option['like_box_height'] == '')
	$this->plugin_option['like_box_height'] = 427;
if($this->plugin_option['like_box_faces'] == '')
	$this->plugin_option['like_box_faces'] = '1';
if($this->plugin_option['like_box_stream'] == '')
	$this->plugin_option['like_box_stream'] = '1';
if($this->plugin_option['like_box_xfbml'] == '')
	$this->plugin_option['like_box_xfbml'] = '0';
if($this->plugin_option['like_box_header'] == '')
	$this->plugin_option['like_box_header'] = '1';

//****************************************************************************************
//  activity
//****************************************************************************************
if($this->plugin_option['activity_colorscheme'] == '')
	$this->plugin_option['activity_colorscheme'] = 'light';
if($this->plugin_option['activity_width'] == '')
	$this->plugin_option['activity_width'] = 292;
if($this->plugin_option['activity_height'] == '')
	$this->plugin_option['activity_height'] = 427;
if($this->plugin_option['activity_recommendations'] == '')
	$this->plugin_option['activity_recommendations'] = '0';
if($this->plugin_option['activity_xfbml'] == '')
	$this->plugin_option['activity_xfbml'] = '0';
if($this->plugin_option['activity_header'] == '')
	$this->plugin_option['activity_header'] = '1';


//****************************************************************************************
//  Login button
//****************************************************************************************
if($this->plugin_option['login_button_width'] == '')
	$this->plugin_option['login_button_width'] = 200;
if($this->plugin_option['login_button_maxrow'] == '')
	$this->plugin_option['login_button_maxrow'] = 1;
if($this->plugin_option['login_button_faces'] == '')
	$this->plugin_option['login_button_faces'] = 0;
if($this->plugin_option['login_button_logout_value'] == '')
	$this->plugin_option['login_button_logout_value'] = __('Logout',$this->plugin_text_domain);




//****************************************************************************************
//  defaults values
//****************************************************************************************
//$this->Debug($this->plugin_option);
//set defaults values 
foreach($this->plugin_option as $option=>$value){
	$set_var='';
	if($value == '' && $value !='0'){
		switch($option){
			//title default
			case 'ogtags_frontpage_title':
			case 'ogtags_frontpage_site_name':
			case 'ogtags_categories_site_name':
			case 'ogtags_archives_site_name':
			case 'ogtags_page_site_name':
			case 'ogtags_post_site_name':
				$set_var = '%BLOG_TITLE%';
			break;
			case 'ogtags_page_disable':
			case 'ogtags_post_disable':
			case 'ogtags_archives_disable':
			case 'ogtags_frontpage_disable':
			case 'ogtags_taxonomies_category_disable':
			    $set_var = 1;
			break;

			//types default
			case 'ogtags_frontpage_type':
				$set_var = 'website';
			break;
			case 'ogtags_categories_type':
			case 'ogtags_archive_type':
			case 'ogtags_page_type':
			case 'ogtags_author_type':
				$set_var = 'blog';
			break;
			case 'ogtags_post_type':
				$set_var = 'article';
			break;
		
			//default site name
			case 'ogtags_frontpage_site_name':
			case 'ogtags_page_site_name':
			case 'ogtags_post_site_name':
			case 'ogtags_archive_site_name':
			case 'ogtags_author_site_name':
				$set_var = '%BLOG_TITLE%';
			break;
			
			case 'ogtags_taxonomies_category_title':
				$set_var = '%TERM_TITLE%';
			break;
			case 'ogtags_taxonomies_category_description':
				$set_var = '%TERM_DESCRIPTION%';
			break;
			
			case 'ogtags_page_title':
			case 'ogtags_post_title':
				$set_var = '%POST_TITLE%';
			break;
			case 'ogtags_archive_title':
				$set_var = '%ARCHIVE_TITLE%';
			break;
			
			case 'ogtags_author_title':
				$set_var = '%AUTHOR_TITLE%';
			break;
			case 'ogtags_author_image':
				$set_var = '%AUTHOR_IMAGE%';
			break;
			case 'ogtags_author_description':
				$set_var = '%AUTHOR_DESCRIPTION%';
			break;
			
			//description default
			case 'ogtags_frontpage_description':
			case 'ogtags_archive_description':
				$set_var = '%BLOG_DESCRIPTION%';
			break;
			
			case 'ogtags_post_description':
			case 'ogtags_page_description':
				$set_var = '%POST_EXCERPT%';
			break;
		}
		$this->plugin_option[$option] = $set_var;
	}
}
//****************************************************************************************

//****************************************************************************************
//  Desactive all xfbml
//****************************************************************************************
if($this->plugin_option['parse_xfbml'] == '' || $this->plugin_option['parse_xfbml'] == 0){
	$this->plugin_option['parse_xfbml'] = 0;
	$this->plugin_option['like_button_xfbml'] = 0;
	$this->plugin_option['like_button_send'] = 0;
	$this->plugin_option['like_box_xfbml'] = 0;
	$this->plugin_option['activity_xfbml'] = 0;
}
//define current user in this object
$this->current_user();
//call the api facebook init (php) if connect enable
if($this->plugin_option['connect_enable'] == 1 && $this->plugin_option['app_id'] !='' && $this->plugin_option['app_secret_key'] !=''){
	if(get_option('users_can_register') == 0){
		add_action('admin_notices',array(&$this,'message_register_disabled'));
	}
	//init OAuth SDK php
	$this->init_php();
	//perform login process
	$this->login_user();
}else{
	add_action('admin_notices',array(&$this,'missing_config'));
}

//init admin
add_action('admin_menu', array(&$this,'admin_menu'));
add_action('admin_init', array(&$this,'admin_initialisation'));

//js fcbk loggin and start session in footer if connect enable
if($this->plugin_option['connect_enable'] == 1){
	add_action('admin_print_footer_scripts',array(&$this,'connect_footer'));
	add_action('wp_footer',array(&$this,'connect_footer'));
}
//js in front lib fcbk
add_action('wp_print_scripts', array(&$this,'enqueue_fbjs'));
add_action('admin_print_scripts', array(&$this,'enqueue_fbjs'));

//filter for button post
add_filter('the_content', array(&$this,'the_content'));

//add action to get button like
add_action('AWD_facebook_like_button', array(&$this,'print_the_like_button'));

//call the open tags in header
add_action('wp_head',array(&$this,'define_open_graph_tags_header'));

if($this->debug_active)
	add_action('wp_footer',array(&$this,'debug_content'));
?>
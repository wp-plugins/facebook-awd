<?php
//Define Default Vars if not set
if($options['connect_enable'] == '')
    $options['connect_enable'] = 0;
if($options['open_graph_enable'] == '')
    $options['open_graph_enable'] = 1;
if($options['connect_fbavatar'] == '')
    $options['connect_fbavatar'] == 0;
//****************************************************************************************
//  like button
//****************************************************************************************
if($options['like_button_on_pages'] == '')
    $options['like_button_on_pages'] = 0;
if($options['like_button_place_on_pages'] == '')
    $options['like_button_place_on_pages'] = 'top'; 
if($options['like_button_on_posts'] == '')
    $options['like_button_on_posts'] = 0;
if($options['like_button_place_on_posts'] == '')
    $options['like_button_place_on_posts'] = 'top';
if($options['like_button_place_on_custom_post_types'] == '')
    $options['like_button_place_on_custom_post_types'] = 'top';
if($options['like_button_on_custom_post_types'] == '')
    $options['like_button_on_custom_post_types'] = 0;
if($options['like_button_colorscheme'] == '')
    $options['like_button_colorscheme'] = 'light';
if($options['like_button_send'] == '' || $options['like_button_xfbml'] == 0)
    $options['like_button_send'] = 0;
if($options['like_button_height'] == '')
    $options['like_button_height'] = 40;
if($options['like_button_height'] == '')
    $options['like_button_height'] = 35;
if($options['like_button_faces'] == '')
    $options['like_button_faces'] = 0;
if($options['like_button_xfbml'] == '')
    $options['like_button_xfbml'] = 0;
if($options['like_button_action'] == '')
    $options['like_button_action'] = 'like';
if($options['like_button_layout'] == '')
    $options['like_button_layout'] = 'standard';
if($options['like_button_url'] == '')
    $options['like_button_url'] = get_bloginfo('url');

//****************************************************************************************
//  like box
//****************************************************************************************
if($options['like_box_url'] == '')
    $options['like_box_url'] = '';
if($options['like_box_colorscheme'] == '')
    $options['like_box_colorscheme'] = 'light';
if($options['like_box_width'] == '')
    $options['like_box_width'] = 292;
if($options['like_box_height'] == '')
    $options['like_box_height'] = 427;
if($options['like_box_faces'] == '')
    $options['like_box_faces'] = '1';
if($options['like_box_stream'] == '')
    $options['like_box_stream'] = '1';
if($options['like_box_xfbml'] == '')
    $options['like_box_xfbml'] = '0';
if($options['like_box_header'] == '')
    $options['like_box_header'] = '1';

//****************************************************************************************
//  activity
//****************************************************************************************

if($options['activity_colorscheme'] == '')
    $options['activity_colorscheme'] = 'light';
if($options['activity_width'] == '')
    $options['activity_width'] = 292;
if($options['activity_height'] == '')
    $options['activity_height'] = 427;
if($options['activity_recommendations'] == '')
    $options['activity_recommendations'] = '0';
if($options['activity_xfbml'] == '')
    $options['activity_xfbml'] = '0';
if($options['activity_header'] == '')
    $options['activity_header'] = '1';


//****************************************************************************************
//  Login button
//****************************************************************************************
if($options['login_button_display_on_login_page'] == '')
    $options['login_button_display_on_login_page'] = 0;
if($options['login_button_width'] == '')
    $options['login_button_width'] = 200;
if($options['login_button_maxrow'] == '')
    $options['login_button_maxrow'] = 1;
if($options['login_button_faces'] == '')
    $options['login_button_faces'] = 0;
if($options['login_button_logout_value'] == '')
    $options['login_button_logout_value'] = __('Logout',$this->plugin_text_domain);
if($options['login_button_image'] == '')
    $options['login_button_image'] = $this->plugin_url_images.'f-connect.png';
    
//****************************************************************************************
// comments
//****************************************************************************************
if($options['comments_url'] == '')
    $options['comments_url'] = get_bloginfo('url');
if($options['comments_colorscheme'] == '')
    $options['comments_colorscheme'] = 'light';
if($options['comments_width'] == '')
    $options['comments_width'] = 500;
if($options['comments_nb'] == '')
    $options['comments_nb'] = 10;


//****************************************************************************************
//  defaults values
//****************************************************************************************
//$this->Debug($options);
//set defaults values 
foreach($options as $option=>$value){
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
        $options[$option] = $set_var;
    }
}
//get the fbuid of admins
$fbadmin_uid = do_action("AWD_facebook_get_admin_fbuid");

if($options['admins'] == '')
    $options['admins'] = $fbadmin_uid;
//try here to set the comments notifications uid from 
if($options['comments_send_notification_uid']== '')
    $options['comments_send_notification_uid'] = $fbadmin_uid;

//langs
if($options['locale']==''){
    if(defined('WPLANG')){
        if(WPLANG==''){
            $options['locale'] = "en_US";
        }else{
            $options['locale'] = WPLANG;
        }
    }
}
//Desactive all xfbml if xfbml is set to 0
if($options['parse_xfbml'] == '' || $options['parse_xfbml'] == 0){
    $options['parse_xfbml'] = 0;
    $options['like_button_xfbml'] = 0;
    $options['like_button_send'] = 0;
    $options['like_box_xfbml'] = 0;
    $options['activity_xfbml'] = 0;
}
//Define the perms with always email
$array_perms = explode(",",$options['perms']);
if(!in_array('email',$array_perms))
    $options['perms'] = rtrim('email,'.$options['perms'],',');

?>
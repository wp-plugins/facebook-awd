<?php
/*
*
* login AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*/

/*
* Version for PHP SDK 3.1.1
*/
if($this->uid){
	//if user is logged in, then we just need to associate FB account with WordPress account
	if(is_user_logged_in()){
		
		$step = 'logged';

	}else{	
		//check if user has account in the website. get id 
		$existing_user = $this->wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $this->uid . '" ) OR user_email = "' . $fcbk_user_infos['email'] . '" OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $fcbk_user_infos['email'] . '" )  LIMIT 1 ');
		//if the user exists - set cookie, do wp_login, redirect and exit
		if($existing_user > 0){
			$step = 'sync';
		//if user don't exist - create one and do all the same stuff: cookie, wp_login, redirect, exit
		}else{
			$step = 'register';
		}	    	
	}

	switch($step){
		
		/*********************************************/
		// User logged in
		/*********************************************/
		case 'logged':
			$fb_uid = get_user_meta($this->current_user->ID,'fb_uid', true);
			$fb_email = get_user_meta($this->current_user->ID,'fb_email', true);
			if(!$fb_uid OR $fb_email == '' OR count($this->me)==0){
				$this->me = $this->fcbk->api('/me');
				update_user_meta($this->current_user->ID,'fb_uid',$this->uid);//refetch data form Facebook api
				update_user_meta($this->current_user->ID,'fb_email',$this->me['email']);//refetch data form Facebook api
				update_user_meta($this->current_user->ID,'fb_user_infos',$this->me);
			}			
			$this->debug_echo[] = "User connected";
			return true;
		break;
		
		
		/*********************************************/
		// User sync and logged in (After Log in process)
		/*********************************************/
		case 'sync':
			$fb_uid = get_user_meta($existing_user, 'fb_uid', true);
			$fb_email = get_user_meta($existing_user, 'fb_email', true);
			//update user fb infos
			$this->me = $this->fcbk->api('/me');
			update_user_meta($this->current_user->ID,'fb_user_infos',$this->me);
			
			if(!$fb_uid)
				update_user_meta($existing_user, 'fb_uid', $this->uid );
			if(!$fb_uid){
				update_user_meta($existing_user, 'fb_uid', $this->me['email'] );
			}
			
			//get user infos
			$user_info = get_userdata($existing_user);

			//connect the user
			$this->connect_the_user($user_info);
			$this->debug_echo[] = "User login";
			$current_url = $this->get_current_url();
			if(preg_match('@wp-login.php@',$current_url))
				if($_REQUEST['redirect_to'] !='')
					wp_redirect($_REQUEST['redirect_to']);
				else
					wp_redirect(home_url());
			else
				wp_redirect($current_url);
			exit();
		break;
		
		
		/*********************************************/
		// User register
		/*********************************************/
		case 'register':
			$this->me = $this->fcbk->api('/me');
			//sanitize username
			$username = sanitize_user($this->me['first_name'], true);
			//check if username is taken
			//if so - add something in the end and check again 
			$i='';
			while(username_exists($username . $i)){
				$i=absint($i);
				$i++;
			}

			//this will be new user login name
			$username = $username.$i;
			//test if we get email, if not call WP die to prevent empty user.
			if($this->me['email'] ==''){
				return false;
				wp_die(__('Fb connect need email permission to work. You should logout from facebook and try again, then accept email permission',$this-plugin_text_domain));
			}
			//put everything in nice array
			$userdata = array(
				'user_pass'		=>	wp_generate_password(),
				'user_login'	=>	$username,
				'user_nicename'	=>	$username,
				'user_email'	=>	$this->me['email'],
				'display_name'	=>	$this->me['name'],
				'nickname'		=>	$username,
				'first_name'	=>	$this->me['first_name'],
				'last_name'		=>	$this->me['last_name'],
				'role'			=>	get_option('default_role')
			);
			//create new user
			$new_user = wp_insert_user($userdata);
			
			if($new_user->errors){
				wp_die($this->Debug($new_user->errors));
			}elseif(is_int($new_user)){
				//add user meta fb_uid
				update_user_meta( $new_user, 'fb_uid', $this->uid );
				$user_info = get_userdata($new_user);
				//send email new registration
				wp_new_user_notification($user_info->ID, $userdata['user_pass']);
				//connnect the user
				$this->connect_the_user($user_info);
				//do_action('wp_login', $user_info->user_login);
				$this->debug_echo[] = "User register and was logged in";
				if(preg_match('@wp-login.php@',$current_url))
                    if($_REQUEST['redirect_to'] !='')
                        wp_redirect($_REQUEST['redirect_to']);
                    else
                        wp_redirect(home_url());
				else
                    wp_redirect($this->get_current_url());
                exit();
			}
		break;
		default :
		break;
	}//end switch
}


?>
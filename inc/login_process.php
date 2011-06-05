<?php
/*
*
* login AWD FCBK
* (C) 2011 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/
if($this->session){
	//if user is logged in, then we just need to associate FB account with WordPress account
	if(is_user_logged_in()){
		$fb_uid = get_user_meta($this->current_user->ID,'fb_uid', true);
		if($fb_uid == $this->user->id){
			$this->debug_echo[] = "User connected AND nothing else to do";
			return true;
		}
			
		//if FB email is the same as WP email we don't need to do anything.
		if($user->email == $this->current_user->user_email){					
			if(!$fb_uid)
				update_user_meta($this->current_user->ID,'fb_uid',$this->user->id);
				
			$this->debug_echo[] = "User already connected and syncronized";
			return true;
		}else{
		//else we need to set fb_uid in user meta, this will be used to identify this user
			if(!$fb_uid){
				update_user_meta($this->current_user->ID,'fb_uid',$this->user->id);
				$fb_email = get_user_meta($this->current_user->ID, 'fb_email', true);
				update_user_meta($this->current_user->ID,'fb_email',$this->user->email);
				$this->debug_echo[] = "User already logged in and re-syncronized => fb_uid add in database";
			}
			//that's it, we don't need to do anything else, because the user is already logged in.
			return true;
		}
	}else{
		//check if user has account in the website. get id
		$existing_user = $this->wpdb->get_var( 'SELECT DISTINCT `u`.`ID` FROM `' . $this->wpdb->users . '` `u` JOIN `' . $this->wpdb->usermeta . '` `m` ON `u`.`ID` = `m`.`user_id`  WHERE (`m`.`meta_key` = "fb_uid" AND `m`.`meta_value` = "' . $this->user->id . '" ) OR user_email = "' . $this->user->email . '" OR (`m`.`meta_key` = "fb_email" AND `m`.`meta_value` = "' . $this->user->email . '" )  LIMIT 1 ');
		//if the user exists - set cookie, do wp_login, redirect and exit
		if($existing_user > 0){
			$fb_uid = get_user_meta($existing_user, 'fb_uid', true);
			if(!$fb_uid)
				update_user_meta($existing_user, 'fb_uid', $this->user->id );
			
			$user_info = get_userdata($existing_user);
			wp_set_auth_cookie($existing_user, true, false);
			do_action('wp_login', $user_info->user_login);
			$this->debug_echo[] = "User was logged in and re-syncronized => fb_uid add in database";
			if(wp_get_referer()){
				wp_redirect(wp_get_referer());
			}else{
				wp_redirect($_SERVER['REQUEST_URI']);
			}
			exit();
		//if user don't exist - create one and do all the same stuff: cookie, wp_login, redirect, exit
		}else{
			//sanitize username
			$username = sanitize_user($this->user->first_name, true);
			//check if username is taken
			//if so - add something in the end and check again 
			$i='';
			while(username_exists($username . $i)){
				$i=absint($i);
				$i++;
			}

			//this will be new user login name
			$username = $username.$i;

			//put everything in nice array
			$userdata = array(
				'user_pass'		=>	wp_generate_password(),
				'user_login'	=>	$username,
				'user_nicename'	=>	$username,
				'user_email'	=>	$this->user->email,
				'display_name'	=>	$this->user->name,
				'nickname'		=>	$username,
				'first_name'	=>	$this->user->first_name,
				'last_name'		=>	$this->user->last_name,
				'role'			=>	'subscriber'
			);
			//create new user
			$new_user = absint(wp_insert_user($userdata));
			//if user created succesfully - log in and reload
			if($new_user > 0){
				update_user_meta( $new_user, 'fb_uid', $this->user->id );
				$user_info = get_userdata($new_user);
				wp_set_auth_cookie($new_user, true, false);
				do_action('wp_login', $user_info->user_login);
				$this->debug_echo[] = "User was logged in and an account in wp was created";
				if(wp_get_referer()){
					wp_redirect(wp_get_referer());
				}else{
					wp_redirect($_SERVER['REQUEST_URI']);
				}
				exit();
			}else{
				wp_die('Facebook Connect: Error creating new user!');
			}
		}	    	
	}
}
?>
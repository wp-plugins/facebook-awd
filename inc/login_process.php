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

//if user is logged in, then we just need to associate FB account with WordPress account
if(is_user_logged_in()){
	$step = 'logged';
}else{	
    $step = 'do_register';
	//first try to check if an email exist in wordpress,
	$existing_user = $this->get_existing_user_from_facebook();
	//if the user exists - set cookie, do wp_login, redirect and exit
	if($existing_user > 0){
		$step = 'do_sync';
	}   	
}

switch($step){
	
	/*********************************************/
	// User logged in Wordpress
	/*********************************************/
	case 'logged':
		$fb_uid = get_user_meta($this->current_user->ID,'fb_uid', true);
		$fb_email = get_user_meta($this->current_user->ID,'fb_email', true);
		//the user is logged in, if datas were not yet get on facebook, get it now.
		if($_SESSION[$this->plugin_slug]['fetched_user_data'] == false OR !$fb_uid OR !$fb_email){
		    $this->get_facebook_user_data();
    		update_user_meta($existing_user, 'fb_uid', $this->uid );
    		update_user_meta($existing_user, 'fb_email', $this->me['email']);
    		update_user_meta($existing_user,'fb_user_infos',$this->me);
    		//say that the data are in memory
    		$_SESSION[$this->plugin_slug]['fetched_user_data'] = true;
		}	
		$this->debug_echo[] = "User connected";
		return true;
	break;
	
	
	/*********************************************/
	// User sync and logged in (After Log in process)
	/*********************************************/
	case 'do_sync':
		//update user fb infos
		$this->get_facebook_user_data();
		update_user_meta($existing_user, 'fb_uid', $this->uid );
		update_user_meta($existing_user, 'fb_email', $this->me['email']);
		update_user_meta($existing_user,'fb_user_infos',$this->me);
		
		//connect the user
		$user_info = get_userdata($existing_user);
		$this->connect_the_user($user_info);
		$this->debug_echo[] = "User login";
		
		$current_url = $this->get_current_url();
        //if we come from the wp-login page, and we get redirect to, use it.
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
	case 'do_register':
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
		    $this->get_facebook_user_data();
		    update_user_meta($new_user, 'fb_uid', $this->uid );
		    update_user_meta($new_user, 'fb_email', $this->me['email']);
		    update_user_meta($new_user,'fb_user_infos',$this->me);
			$user_info = get_userdata($new_user);
			//send email new registration
			wp_new_user_notification($user_info->ID, $userdata['user_pass']);
			//connnect the user
			$this->connect_the_user($user_info);
			$this->debug_echo[] = "User register and was logged in";
			//call action user_register for other plugins and wordpress core
			do_action('user_register', $new_user);
			
			//if we come from the wp-login page, and we get redirect to, use it.
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



?>
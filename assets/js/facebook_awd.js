/*
*
* JS AWD FCBK
* (C) 2012 AH WEB DEV
* Hermann.alexandre@ahwebdev.fr
*
*/

var AWD_facebook = {
	
	FBEventHandler : function ()
	{
		if(awd_fcbk.FBEventHandler.callbacks){
			jQuery.each(awd_fcbk.FBEventHandler.callbacks,function(index,value){
				var AWD_actions_callback = window[this];
				if(jQuery.isFunction(AWD_actions_callback))
					AWD_actions_callback(this);
			});
		}
	},
	
	callbackLogin : function(response,redirect_url)
	{
		
		var redirect = '';
		if(response.authResponse){
			if(!redirect_url){
				window.location.href = awd_fcbk.loginUrl;
			}else{
				redirect = "?redirect_to="+redirect_url;
				window.location.href = awd_fcbk.loginUrl+redirect;
			}
		}
	},
	
	connect :function(redirect_url)
	{
		FB.login(
			function(response){
				AWD_facebook.callbackLogin(response,redirect_url);
			},
			{ 
				scope: awd_fcbk.scope
			}
		);
		return false;
	},
	
	logout : function(){
		window.location.href = awd_fcbk.logoutUrl;
	},
	
	isFbConnected : function(){
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				return true;
			}
			return false;
		});
	},
};

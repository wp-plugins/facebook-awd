<?php 
/**
 * 
 *
 * @author Alexandre Hermann
 * @version 1.4
 * @copyright AHWEBDEV, 6 June, 2012
 * @package Facebook AWD
 **/
require_once(dirname(__FILE__).'/facebook.php');

class AWD_facebook_api extends Facebook
{
	
	public function __construct($options)
	{
		self::$CURL_OPTS = array(
			CURLOPT_CONNECTTIMEOUT => 10,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_TIMEOUT        => $options['timeout'],
			CURLOPT_USERAGENT      => 'facebook-php-3.2',
		);
		
		parent::__construct(array(
			'appId'  => $options['app_id'],
			'secret' => $options['app_secret_key'],
			'timeOut' => $options['timeout'],
		));	
		
		$this->setExtendedAccessToken();
	}
}
?>
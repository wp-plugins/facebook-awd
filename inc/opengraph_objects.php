<?php
//****************************************************************************************
//  Objects lib
//****************************************************************************************
$this->og_tags = array(
	'app_id' => array('name'=>__('App IDs',$this->plugin_text_domain), 'type'=> 'string'),
	'admins' => array('name'=>__('Admin ids',$this->plugin_text_domain), 'type'=> 'string'),
	'type'=> array('name'=>__('Type',$this->plugin_text_domain), 'type'=> 'string'),
	'url'=> array('type'=> 'string'),
	'site_name'=> array('name'=>__('Site Name',$this->plugin_text_domain), 'type'=> 'string'),
	'image'=> array('name'=>__('Image url (50x50 is better)',$this->plugin_text_domain), 'type'=> 'image'),
	'title'=> array('name'=>__('Title',$this->plugin_text_domain), 'type'=> 'string'),
	'description'=> array('name'=>__('Description',$this->plugin_text_domain), 'type'=> 'string'),
	'locale'=> array('name'=>__('Locale',$this->plugin_text_domain), 'type'=> 'string')
);
$this->og_tags = apply_filters('AWD_facebook_og_tags', $this->og_tags);

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
     ),
     'custom type'=> array(
		'custom'=>'Custom'
	 )
);
$this->og_types = apply_filters('AWD_facebook_og_types', $this->og_types);

//attachement
$this->og_attachement_field = array(
	'video' => array(
		'video'=> array('name'=> __('Video src (swf only, for Facebook site)',$this->plugin_text_domain), 'type'=> 'video'),
		'video:height'=> array('name'=>__('Height (max: 460px)',$this->plugin_text_domain), 'type'=> 'string'),
		'video:width'=> array('name'=>__('Width (max: 398px)',$this->plugin_text_domain), 'type'=> 'string'),
		'video:type'=> array('name'=>__('Type swf',$this->plugin_text_domain), 'type'=> 'string'),
		'video:secure_url'=> array('name'=>__('Video src HTTPS (swf only, for Facebook site)',$this->plugin_text_domain), 'type'=> 'string'),
		'video:mp4'=> array('name'=>__('Video src (mp4 only, for Iphone/Ipad/Safari) ',$this->plugin_text_domain), 'type'=> 'video'),
		'video:type_mp4'=> array('name'=>__('Type mp4',$this->plugin_text_domain), 'type'=> 'string'),
		'video:html'=> array('name'=>__('Video src (page html only)',$this->plugin_text_domain), 'type'=> 'string'),
		'video:type_html'=> array('name'=>__('Type html',$this->plugin_text_domain), 'type'=> 'string'),
	),
	'audio' => array(
		'audio'=> array('name'=>__('Audio src (mp3 only)',$this->plugin_text_domain), 'type'=> 'audio'),
		'audio:title'=> array('name'=>__('Title',$this->plugin_text_domain), 'type'=> 'string'),
		'audio:artist'=> array('name'=>__('Artist',$this->plugin_text_domain), 'type'=> 'string'),
		'audio:album'=> array('name'=>__('Album',$this->plugin_text_domain), 'type'=> 'string'),
		'audio:type'=> array('name'=>__('Type',$this->plugin_text_domain), 'type'=> 'string')
	),
	'contact' => array(
		'contact_email'=> array('name'=>__('Email',$this->plugin_text_domain), 'type'=> 'string'),
		'contact_phone_number'=> array('name'=>__('Phone number',$this->plugin_text_domain), 'type'=> 'string'),
		'contact_fax_number'=> array('name'=>__('Fax number',$this->plugin_text_domain), 'type'=> 'string'),
	)
	,
	'location' => array(
		'location_latitude'=> array('name'=>__('Latitude',$this->plugin_text_domain), 'type'=> 'string'),
		'location_longitude'=> array('name'=>__('Longitude',$this->plugin_text_domain), 'type'=> 'string'),
		'location_street-address'=> array('name'=>__('Street address',$this->plugin_text_domain), 'type'=> 'string'),
		'location_locality'=> array('name'=>__('Locality',$this->plugin_text_domain), 'type'=> 'string'),
		'location_region'=> array('name'=>__('Region',$this->plugin_text_domain), 'type'=> 'string'),
		'location_postal-code'=> array('name'=>__('Postal code',$this->plugin_text_domain), 'type'=> 'string'),
		'location_country-name'=> array('name'=>__('Country name',$this->plugin_text_domain), 'type'=> 'string'),
	),
	'isbn' => array(
		'isbn'=> array('name'=>__('Isbn',$this->plugin_text_domain), 'type'=> 'string')
	),
	'upc' => array(
		'upc'=> array('name'=>__('Upc',$this->plugin_text_domain), 'type'=> 'string')
	),
	
);
$this->og_attachement_field = apply_filters('AWD_facebook_og_attachement_fields', $this->og_attachement_field);

$this->og_custom_fields = array();
$this->og_custom_fields = apply_filters('AWD_facebook_og_custom_fields', $this->og_custom_fields);

?>
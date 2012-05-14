<?php
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
	'app_id' => __('App IDs',$this->plugin_text_domain),
	'site_name'=> __('Site Name',$this->plugin_text_domain),
	'locale'=> __('Locale',$this->plugin_text_domain)
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
		'video'=>__('Video src (swf only, for Facebook site)',$this->plugin_text_domain),
		'video:height'=>__('Height (max: 460px)',$this->plugin_text_domain),
		'video:width'=>__('Width (max: 398px)',$this->plugin_text_domain),
		'video:type'=>__('Type swf',$this->plugin_text_domain),
		'video:secure_url'=>__('Video src HTTPS (swf only, for Facebook site)',$this->plugin_text_domain),
		'video:mp4'=>__('Video src (mp4 only, for Iphone/Ipad/Safari) ',$this->plugin_text_domain),
		'video:type_mp4'=>__('Type mp4',$this->plugin_text_domain),
		'video:html'=>__('Video src (page html only)',$this->plugin_text_domain),
		'video:type_html'=>__('Type html',$this->plugin_text_domain),
	),
	'audio' => array(
		'audio'=>__('Audio src (mp3 only)',$this->plugin_text_domain),
		'audio:title'=>__('Title',$this->plugin_text_domain),
		'audio:artist'=>__('Artist',$this->plugin_text_domain),
		'audio:album'=>__('Album',$this->plugin_text_domain),
		'audio:type'=>__('Type',$this->plugin_text_domain)
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
$this->og_attachement_field = apply_filters('AWD_facebook_og_attachement_fields', $this->og_attachement_field);
?>
<?php 
/*
* Class AWD_facebook_activity
* (C) 2012 AH WEB DEV
* contact@ahwebdev.fr
* Last modification : 21/01/2012
*/
class AWD_facebook_activity
{
	/**
	 * site 
	 * a comma separated list of domains to show activity for.
	 * The XFBML version defaults to the current domain
	 */
	protected $site;
	
	/**
	 * width 
	 * the width of the plugin in pixels. Default width: 300px
	 */
	protected $width = 300;
	
	/**
	 * height 
	 * the height of the plugin in pixels. Default height: 300px
	 */
	protected $height = 300;
	
	/**
	 * header 
	 * specifies whether to show the Facebook header
	 */
	protected $header;
	
	/**
	 * colorscheme 
	 * the color scheme for the plugin. Options: 'light', 'dark'
	 */
	protected $colorscheme;
	
	/**
	 * font 
	 * the font to display in the plugin. Options: 'arial', 'lucida grande', 'segoe ui', 'tahoma', 'trebuchet ms', 'verdana'
	 */
	protected $font;
	
	/**
	 * border_color 
	 * the border color of the plugin
	 */
	protected $border_color;
	
	/**
	 * recommendations 
	 * specifies whether to always show recommendations in the plugin.
	 * If recommendations is set to true, the plugin will display recommendations in the bottom half
	 */
	protected $recommendations;
	
	/**
	 * filter 
	 * allows you to filter which URLs are shown in the plugin.
	 * The plugin will only include URLs which contain the filter string in the first two path parameters of the URL.
	 * If nothing in the first two path parameters of the URL matches the filter,
	 * the URL will not be included. 
	 * For example, if the 'site' parameter is set to 'www.example.com' and the 'filter' parameter was set to '/section1/section2' 
	 * then only pages which matched 'http://www.example.com/section1/section2/*' would be included in the activity feed section of this plugin.
	 * The filter parameter does not apply to any recommendations which may appear in this plugin (see above); Recommendations are based only on 'site' parameter
	 */
	protected $filter;
	
	/**
	 * linktarget 
	 * This specifies the context in which content links are opened.
	 * By default all links within the plugin will open a new window.
	 * If you want the content links to open in the same window, you can set this parameter to _top or _parent.
	 * Links to Facebook URLs will always open in a new window.
	 */
	protected $linktarget;
	
	/**
	 * ref 
	 * must be a comma separated list, consisting of at most 5 distinct items, each of length at least 1 and at most 15 characters drawn from the set '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_'.
	 * Specifying a value for the ref attribute adds the 'fb_ref' parameter to the any links back to your site which are clicked from within the plugin.
	 * Using different values for the ref parameter for different positions and configurations of this plugin within your pages allows you to track which instances are performing the best.
	 */
	protected $ref;
	
	/**
	 * max_age 
     * the maximum age of a URL to show in the plugin.
     * The default is 0 (we don’t take age into account).
     * Otherwise the valid values are 1-180, which specifies the number of days.
     * For example, if you specify '7' the plugin will only show URLs which were created in the past week.
	 */
	protected $max_age;
	
	/**
	 * template 
	 * template to use, xfbml, html5, or iframe
	 */
	protected $template;

	
	/**
	 * Construct
	 */
 	public function __construct($site,$width,$height,$header,$colorscheme,$font,$border_color,$recommendations,$filter,$linktarget,$ref,$max_age,$template)
 	{
		$this->setSite($site);
		$this->setWidth($width);
		$this->setHeight($height);
		$this->setHeader($header);
		$this->setColorscheme($colorscheme);
		$this->setFont($font);
		$this->setBorderColor($border_color);
		$this->setRecommendations($recommendations);
		$this->setFilter($filter);
		$this->setLinktarget($linktarget);
		$this->setRef($ref);
		$this->setMaxAge($max_age);
		$this->setTemplate($template);
 	}
	
	
	/**
	 * Setter: site
	 * @param String $site
	 * @return void
	 */
	public function setSite( $site )
	{
		if(empty($site))
			throw new Exception('Url for Activity box can not be empty');
		$this->site = $site;
	}
	
	/**
	 * Setter: width
	 * @param String $width
	 * @return void
	 */
	public function setWidth( $width )
	{
		$this->width = $width;
	}
	
	/**
	 * Setter: height
	 * @param String $height
	 * @return void
	 */
	public function setHeight( $height )
	{
		$this->height = $height;
	}
	
	/**
	 * Setter: header
	 * @param String $header
	 * @return void
	 */
	public function setHeader( $header )
	{
		$this->header = $header;
	}
	
	/**
	 * Setter: colorscheme
	 * @param String $colorscheme
	 * @return void
	 */
	public function setColorscheme( $colorscheme )
	{
		$this->colorscheme = $colorscheme;
	}
	
	/**
	 * Setter: font
	 * @param String $font
	 * @return void
	 */
	public function setFont( $font )
	{
		$this->font = $font;
	}
	
	/**
	 * Setter: border_color
	 * @param String $border_color
	 * @return void
	 */
	public function setBorderColor( $border_color )
	{
		$this->border_color = $border_color;
	}
	
	/**
	 * Setter: recommendations
	 * @param String $recommendations
	 * @return void
	 */
	public function setRecommendations( $recommendations )
	{
		$this->recommendations = $recommendations;
	}
	
	/**
	 * Setter: filter
	 * @param String $filter
	 * @return void
	 */
	public function setFilter( $filter )
	{
		$this->filter = $filter;
	}
	
	/**
	 * Setter: linktarget
	 * @param String $linktarget
	 * @return void
	 */
	public function setLinktarget( $linktarget )
	{
		$this->linktarget = $linktarget;
	}
	
	/**
	 * Setter: ref
	 * @param String $ref
	 * @return void
	 */
	public function setRef( $ref )
	{
		$this->ref = $ref;
	}
	
	/**
	 * Setter: max_age
	 * @param String $max_age
	 * @return void
	 */
	public function setMaxAge( $max_age )
	{
		$this->max_age = $max_age;
	}
	
	/**
	 * Setter: template
	 * @param String $template
	 * @return void
	 */
	public function setTemplate( $template )
	{
		$this->template = $template;
	}
	
	/**
	 * Getter: site
	 * @return String
	 */
	public function getSite()
	{
		return $this->site;
	}
	
	/**
	 * Getter: width
	 * @return String
	 */
	public function getWidth()
	{
		return $this->width;
	}
	
	/**
	 * Getter: height
	 * @return String
	 */
	public function getHeight()
	{
		return $this->height;
	}
	
	/**
	 * Getter: header
	 * @return String
	 */
	public function getHeader()
	{
		return $this->header;
	}
	
	/**
	 * Getter: colorscheme
	 * @return String
	 */
	public function getColorscheme()
	{
		return $this->colorscheme;
	}
	
	/**
	 * Getter: font
	 * @return String
	 */
	public function getFont()
	{
		return $this->font;
	}
	
	/**
	 * Getter: border_color
	 * @return String
	 */
	public function getBorderColor()
	{
		return $this->border_color;
	}
	
	/**
	 * Getter: recommendations
	 * @return String
	 */
	public function getRecommendations()
	{
		return $this->recommendations;
	}
	
	/**
	 * Getter: filter
	 * @return String
	 */
	public function getFilter()
	{
		return $this->filter;
	}
	
	/**
	 * Getter: linktarget
	 * @return String
	 */
	public function getLinktarget()
	{
		return $this->linktarget;
	}
	
	/**
	 * Getter: ref
	 * @return String
	 */
	public function getRef()
	{
		return $this->ref;
	}
	
	/**
	 * Getter: max_age
	 * @return String
	 */
	public function getMaxAge()
	{
		return $this->max_age;
	}
	
	/**
	 * Getter: template
	 * @return String
	 */
	public function getTemplate()
	{
		return $this->template;
	}
	
	/**
	 * Getter: activity
	 * @return activity html/xfbml/iframe
	 */
	public function get()
	{	
		if($this->template == 'iframe')
		{
			return $this->activityIframe();
		}
		else if($this->template == 'html5')
		{
			return $this->activityHtml5();
		}
		else if($this->template == 'xfbml')
		{
			return $this->activityXfbml();
		}
		return false;

	}
	

	//******VIEWS******//
	public function activityHtml5()
	{
		return '<div class="fb-activity" data-site="'.$this->site.'" data-width="'.$this->width.'" data-height="'.$this->height.'" data-header="'.$this->header.'" data-colorscheme="'.$this->colorscheme.'" data-linktarget="'.$this->linktarget.'" data-border-color="'.$this->border_color.'" data-font="'.$this->font.'" data-recommendations="'.$this->recommendations.'" data-max_age="'.$this->max_age.'" data-ref="'.$this->ref.'" data-filter="'.$this->filter.'"></div>';
	}
	public function activityXfbml()
	{
		return '<fb:activity site="'.$this->site.'" width="'.$this->width.'" height="'.$this->height.'" header="'.$this->header.'" colorscheme="'.$this->colorscheme.'" linktarget="'.$this->linktarget.'" border-color="'.$this->border_color.'" font="'.$this->font.'" recommendations="'.$this->recommendations.'" max_age="'.$this->max_age.'" ref="'.$this->ref.'" filter="'.$this->filter.'"></fb:activity>';
	}
	public function activityIframe()
	{
		return '<iframe src="http://www.facebook.com/plugins/activity.php?site='.$this->site.'&amp;width='.$this->width.'&amp;height='.$this->height.'&amp;header='.$this->header.'&amp;colorscheme='.$this->colorscheme.'&amp;border_color='.urlencode($this->border_color).'&amp;recommendations='.$this->recommendations.'&amp;linktarget='.$this->linktarget.'&amp;max_age='.$this->max_age.'&amp;ref='.$this->ref.'&amp;filter='.$this->filter.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$this->width.'px; height:'.$this->height.'px;" allowTransparency="true"></iframe>';
	}
}
?>
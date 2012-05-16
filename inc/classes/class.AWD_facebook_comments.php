<?php 
/*
* Class AWD_facebook_activity
* (C) 2012 AH WEB DEV
* contact@ahwebdev.fr
* Last modification : 21/01/2012
*/
class AWD_facebook_comments
{
	/**
	 * href
	 * the URL for this Comments plugin. News feed stories on Facebook will link to this URL
     */
    protected $href;
     /**
	 * width
	 * the width of the plugin in pixels. Minimum recommended width: 400px
     */
    protected $width;
	/**
	 * colorscheme
	 * the color scheme for the plugin. Options: 'light', 'dark'
	 */ 
   	protected $colorscheme;
   	/**
     * num_posts
     * the number of comments to show by default. Default: 10. Minimum: 1
     */
    protected $num_posts;
    /**
     * mobile
     * whether to show the mobile-optimized version. Default: auto-detect
     */
    protected $mobile;
    /**
	 * template 
	 * template to use, xfbml, html5, or iframe
	 */
	protected $template;
	
	/**
	 * construct
	 */     
	 public function __construct($href,$width,$colorscheme,$num_posts,$mobile,$template){
	 	$this->setHref($href);
	 	$this->setWidth($width);
	 	$this->setColorscheme($colorscheme);
	 	$this->setNumPosts($num_posts);
	 	$this->setMobile($mobile);
	 	$this->setTemplate($template);
	 }
	 
	/**
	 * Setter: href
	 * @param String $href
	 * @return void
	 */
	public function setHref( $href )
	{
		if(empty($href))
			throw new Exception('Url for Comments box can not be empty');
		$this->href = $href;
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
	 * Setter: colorscheme
	 * @param String $colorscheme
	 * @return void
	 */
	public function setColorscheme( $colorscheme )
	{
		$this->colorscheme = $colorscheme;
	}
	
	/**
	 * Setter: num_posts
	 * @param String $num_posts
	 * @return void
	 */
	public function setNumPosts( $num_posts )
	{
		$this->num_posts = $num_posts;
	}
	
	/**
	 * Setter: mobile
	 * @param String $mobile
	 * @return void
	 */
	public function setMobile( $mobile )
	{
		$this->mobile = $mobile;
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
	 * Getter: href
	 * @return String
	 */
	public function getHref()
	{
		return $this->href;
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
	 * Getter: colorscheme
	 * @return String
	 */
	public function getColorscheme()
	{
		return $this->colorscheme;
	}
	
	/**
	 * Getter: num_posts
	 * @return String
	 */
	public function getNumPosts()
	{
		return $this->num_posts;
	}
	
	/**
	 * Getter: mobile
	 * @return String
	 */
	public function getMobile()
	{
		return $this->mobile;
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
		if($this->template == 'xfbml')
		{
			return $this->commentsXfbml();
		}
		else if($this->template == 'html5')
		{
			return $this->commentsHtml5();
		}
		return false;
	}
	

	//******VIEWS******//
	public function commentsHtml5()
	{
		return '<div class="fb-comments" data-href="'.$this->href.'" data-num-posts="'.$this->num_posts.'" data-width="'.$this->width.'" data-colorscheme="'.$this->colorscheme.'" data-mobile="'.$this->mobile.'"></div>';
	}
	public function commentsXfbml()
	{
		return '<fb:comments href="'.$this->href.'" num_posts="'.$this->num_posts.'" width="'.$this->width.'" colorscheme="'.$this->colorscheme.'" mobile="'.$this->mobile.'"></fb:comments>';
	}
}
?>
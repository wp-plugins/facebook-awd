<?php
global $screen_layout_columns;
$page = $_GET['page'];
if($page == $this->plugin_slug)
	$page_hook = $this->blog_admin_page_hook;
elseif($page == $this->plugin_slug.'_open_graph')
	$page_hook = $this->blog_admin_opengraph_hook;
elseif($page == $this->plugin_slug.'_plugins')
	$page_hook = $this->blog_admin_plugins_hook;
elseif($page == $this->plugin_slug.'_support')
	$page_hook = $this->blog_admin_support_hook;
	
$current_screen = get_current_screen();


?>
<div class="wrap" id="AWD_facebook_wrap">
	<?php 
	if($this->message){
		echo $this->message;
		unset($this->message); 
	}
	?>
	<div id="poststuff" class="metabox-holder <?php echo 2 == $screen_layout_columns ? ' has-right-sidebar' : ''; ?>">
		<?php wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false ); ?>
		<?php wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false ); ?>
		<div id="side-info-column" class="inner-sidebar">
			<?php do_meta_boxes($page_hook,'side',null); ?>
		</div>
		<div id="post-body" class="has-sidebar">
			<div id="post-body-content" class="has-sidebar-content">
				<?php
				do_meta_boxes($page_hook,'normal',null);
				do_action("AWD_facebook_custom_metabox");
				?>
		   </div>
		</div>
		<br class="clear"/>
		<script type="text/javascript">
			jQuery(document).ready( function($) {
				// close postboxes that should be closed
				$('.if-js-closed').removeClass('if-js-closed').addClass('closed');
				// postboxes setup
				postboxes.add_postbox_toggles('<?php echo $page_hook; ?>');
			});
		</script>
	</div>
</div>
<div class="clear"></div>
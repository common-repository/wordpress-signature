<?php
	/*
	Plugin Name:Wordpress Signature
	Version: 0.1
	Description:Allows you to add signatures at the end of the post .
	Author: Abinav Thakuri
	Author URI: http://dreamsdeveloped.com
	Plugin URI: http://dreamsdeveloped.com
	*/
	
	/* Version check */
	global $wp_version;
	$exit_msg=' This requires WordPress 3.0 or newer.<a href="http://codex.wordpress.org/Upgrading_WordPress">Please
	update!</a>';
	if (version_compare($wp_version,"2.5","<"))
	{
	exit ($exit_msg);
	}
	if (!class_exists("WpSignature")) {
		class WpSignature {
			var $optionsName = "WpSignatureAdmin";
			function WpSignature(){}
			function init() {
				$this->getOptions();
			}
			//Options
			function getOptions() {
				$adminOptionArray = array('add_content' => 'true','content' => '');
				$optionAdmin = get_option($this->optionsName);
				if (!empty($optionAdmin)) {
					foreach ($optionAdmin as $key => $option)
						$adminOptionArray[$key] = $option;
				}				
				update_option($this-> optionsName, $adminOptionArray);
				return $adminOptionArray;
			}			
			function addContent($content = '') {
				$optionAdmin = $this->getOptions();
				if ($optionAdmin['add_content'] == "true") {
					$content .= $optionAdmin['content'];
				}
				return $content;
				?><?php
			}
			//Prints out the admin page
			function adminPage() {
						$optionAdmin = $this-> getOptions();
											
						if (isset($_POST['update_WpSignature'])) { 
							if (isset($_POST['addcontent'])) {
								$optionAdmin['add_content'] = $_POST['addcontent'];
							}		
							if (isset($_POST['theContent'])) {
								$optionAdmin['content'] = apply_filters('content_save_pre', $_POST['theContent']);
							}
							update_option($this->optionsName, $optionAdmin);				
							?>
						
						<div class="updated"><p><strong><?php _e("Updated.", " WpSignature");?></strong></p></div>
						<?php } ?><head>
	<style type="text/css">
	.style2 {
		font-weight: normal;
		font-family: Tahoma;
		font-size: small;
		background-color: #FFFFFF;
	}
	.style3 {
		font-family: Tahoma;
	}
	.style4 {
		font-family: "Bradley Hand ITC";
		font-size: large;
		color: #535353;
		margin-top: 19px;
	}
	</style>
	</head>
	<div class=wrap>
	<form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
	<h2 class="style4" style="width: 97px"><em>WpSignature</em></h2>
	<div>
			<h3 class="style2"><strong>&nbsp; Allow Signature???</strong></h3>
	<p><label for="addcontent_yo">&nbsp;&nbsp;
	<input type="radio" id="addcontent_yo" name="addcontent" value="true" <?php if ($optionAdmin['add_content'] == "true") { _e('checked="checked"', " WpSignature"); }?> />
	<span class="style3"><strong>Yes</strong></span></label>&nbsp;&nbsp;&nbsp;&nbsp;<label for="addcontent_no"><input type="radio" id="addcontent_no" name="addcontent" value="false" <?php if ($optionAdmin['add_content'] == "false") { _e('checked="checked"', " WpSignature"); }?> style="width: 20px"/> 
	<span class="style3"><strong>No</strong></span></label></p>
	
	</div>
	
	<h3 style="background-color: #FFFFFF">&nbsp;Signature to add at the end to the post 
	???</h3>
	&nbsp;<textarea name="theContent" style="width: 63%; height: 103px;"><?php _e(apply_filters('format_to_edit',$optionAdmin['content']), 'WpSignature') ?></textarea>
	
	<div class="submit">
	<input type="submit" name="update_WpSignature" value="<?php _e('Update', 'WpSignature') ?>" /></div>
	</form>
	 						<?php
					}
			}
	}
	if (class_exists("WpSignature")) {
		$obj_WpSignature = new WpSignature();
	}
	if (!function_exists("WpSignature_obj")) {
		function WpSignature_obj() {
			global $obj_WpSignature;
			if (!isset($obj_WpSignature)) {
				return;
			}
			if (function_exists('add_management_page')) {
		add_management_page('WpSignature', 'WpSignature', 8, basename(__FILE__), array(&$obj_WpSignature, 'adminPage'));
			}
		}	
	}
	if (isset($obj_WpSignature)) {
		add_action('admin_menu', 'WpSignature_obj');
		add_action('WpSignature.php',  array(&$obj_WpSignature, 'init'));
		add_filter('the_content', array(&$obj_WpSignature, 'addContent'),1); 
		}
	?>
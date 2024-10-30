<?php
/*
 * 
 * 
 * DEFINE LEFT-SIDE MENUS
 * 
 * 
 */
add_action('admin_menu', 'mlb_menu');
function mlb_menu() 
{
  add_menu_page('Mailing List Builder Administration', 'Mailing List...', 8, __FILE__, 'mlb_admin');
}

/*
 * 
 * 
 * CREATE THE MAIN PAGE
 * 
 * 
 */
function mlb_admin()
{		
	if ($_POST['mlb-submitted'])
	{
		update_option('mlb_default_cta', $_POST['mlb-default-cta']);		
		update_option('mlb_api_key', $_POST['mlb-api-key']);		
		update_option('mlb_default_campaign', $_POST['mlb-default-campaign']);		
		update_option('mlb_tracking_code', $_POST['mlb-tracking-code']);
	}
?>
<div class="wrap">

	<h2>Mailing List Builder</h2>
	<form action="<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>" method="POST">
	
		<?php $massive_error = mlb_valid(get_option('mlb_api_key')); ?>
		<table class="form-table">
			<tr valign="top">
				<th scope="row"><label for="mlb-api-key">Your GetResponse API Key</label></th>
				<td><input type="text" id="mlb-api-key" name="mlb-api-key" value="<?php echo get_option('mlb_api_key'); ?>" size="50" /></td>
			</tr>
			<?php if ($massive_error) : ?>
			<tr valign="top">
				<th scope="row">Default Call to Action</th>
				<td><textarea name="mlb-default-cta" rows="5" cols="40"><?php echo get_option('mlb_default_cta'); ?></textarea></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mlb-default-campaign">Default Campaign</label></th>
				<td><input type="text" id="mlb-default-campaign" name="mlb-default-campaign" value="<?php echo get_option('mlb_default_campaign'); ?>" size="50" /></td>
			</tr>
			<tr valign="top">
				<th scope="row"><label for="mlb-tracking-code">Default Tracking Code <span style="font-size: smaller;">(optional)</span></label></th>
				<td><input type="text" id="mlb-tracking-code" name="mlb-tracking-code" value="<?php echo get_option('mlb_tracking_code'); ?>" size="50" /></td>
			</tr>			
			<tr valign="top">
				<th scope="row">Your Campaigns</th>
				<td><?php grapi::printCampaignList(); ?></td>
			</tr>
			<tr valign="top">
				<th scope="row">Sample Tags</th>
				<td>
					<ul style="list-style-type: disc;">
						<li>[mlb c="<?php echo current(grapi::getCampaignList()); ?>"]Very Targeted and Relevant Call to Action[/mlb]</li>
						<li>[mlb /]
						<li><a target="_blank" href="http://msafi.com/post/wordpress-mailing-list-builder/documentation/#shortcodes">See more tag options here</a></li>
					</ul>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		
		<input type="hidden" name="mlb-submitted" value="true" />
		
		<p class="submit">
			<input type="submit" class="button-primary" value="Save Changes" />
		</p>
		
	</form>
	
</div>
<?php 
}

/*
 * 
 * 
 * VALIDATE ENTRIES
 * 
 * 
 */
function mlb_valid($api_key)
{
	// No API key whatsoever. Probably first time use.
	if (!get_option('mlb_api_key'))
	{
		echo '<div id="message" class="updated fade"><strong>To start using this plugin, you need to enter a valid GetResponse API key (<a target="_blank" href="http://msafi.com/post/wordpress-mailing-list-builder/documentation/#api">Click here for more details</a>)</strong></div>';
		return false;
	}
	
	// API key just entered is invalid
	elseif (!grapi::validate_key($api_key)) 
	{
		echo '<div id="message" class="updated fade"><strong>The API key you entered is not valid (<a href="#">Click here to get a valid GetResponse API key</a>)</strong></div>';
		return false;
	}
	
	// No campaigns in the account. Can't work without at least one.
	elseif (!is_array(grapi::getCampaignList()))
	{
		echo '<div id="message" class="updated fade"><strong>You need to have at least one campaign in your GetResponse account to use this plugin (<a href="#">Click here for more details</a>)</strong></div>';
		return false;
	}
	elseif (!get_option('mlb_default_campaign'))
	{
		update_option('mlb_default_campaign', current(grapi::getCampaignList()));
	}

	return true;
}

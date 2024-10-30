<?php
/*
	Plugin Name: Mailing List Builder
	Plugin URI: http://msafi.com/post/wordpress-mailing-list-builder/
	Description: This plugin helps you rapidly and dynamically build a segmented list of subscribers through WordPress and <a target="_blank" href="http://msafi.com/a/mlb/">GetResponse</a>
	Author: Mohammed al-Safi
	Version: 0.9.11
*/

require_once (dirname(__FILE__) . "/admin.php");
require_once (dirname(__FILE__) . "/grapi.php");

define('MLB_URL',WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)).'/');

/*
 * 
 * 
 * SUBSCRIPTION FORM SHORTCODE
 * 
 * 
 */
add_shortcode('mlb', 'mlb_print');
function mlb_print($atts, $content)
{
	if (!empty($atts['c']))
		$campaign = $atts['c'];		
	else
		$campaign = get_option('mlb_default_campaign');
		
	if (!empty($atts['r']))
		$ref = $atts['r'];
	else
		$ref = '';
	
	if (empty($content))
		$content = get_option('mlb_default_cta');

	global $post;
	$tag_objects = get_the_tags($post->ID);
	
	if ($tag_objects)
	{
		foreach ($tag_objects as $tag_object)
		{
			$interests .= $tag_object->name . ' ';
			
			if (strlen($interests) < 255)
				$tags[] = $tag_object->name;
			else
				break;
		}
		
		$interests = implode(" ", $tags);
	}
	
	ob_start();
	
	require('form.php');
	
	return ob_get_clean();
}

/*
 * 
 * 
 * MARK POST/PAGE FOR INCLUDING [mlb \] TAG
 * 
 * 
 */
add_action('save_post', 'update_mlb_post',10,1);
function update_mlb_post($post_id)
{
	$post_id = wp_is_post_revision($post_id);
	$post = get_post($post_id);
	
	if (preg_match('/(.?)\[(mlb)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $post->post_content))
		update_post_meta($post_id, '_mlb', '1');
	else
		update_post_meta($post_id, '_mlb', '0');
}

/*
 * 
 * 
 * ENQUEUE FILES ONLY WHEN NECESSARY
 * 
 * 
 */
add_action('get_header', 'mlb_enqueue_stuff');
function mlb_enqueue_stuff()
{
	global $post;
	$post_id = $post->ID;
	
	if (get_post_meta($post_id, '_mlb') || is_active_widget(false, false, 'mlb_widget'))
	{
		wp_enqueue_style('mlb', MLB_URL . 'mlb.css');
		wp_enqueue_script('mlb', MLB_URL . 'mlb.js.php', array('jquery'));
	}
}


/*
 * 
 * 
 * PROCESS FORM SUBMISSION
 * 
 * 
 */
if ($_GET["mlb-process"])
{	
	if (isset($_POST['mlb-email']))
	{
		$email = strtolower($_POST['mlb-email']);
		$name = $_POST['mlb-name'];
		
		$interests = $_POST['mlb-interests'];
		$campaign = $_POST['mlb-campaign'];
		$ref = $_POST['mlb-ref'];
	}
	elseif (isset($_POST['mlbs-email']))
	{
		$email = strtolower($_POST['mlbs-email']);
		$name = $_POST['mlbs-name'];
		
		$interests = $_POST['mlbs-interests'];
		$campaign = $_POST['mlbs-campaign'];
		$ref = $_POST['mlbs-ref'];		
	}
	
	# Create first and last names
	if (!empty($name))
	{
		$name = ucwords(strtolower($name));
		list($fname, $lname) = explode(" ", $name, 2);
	}
	
	if (!empty($fname))
		$custom_values[] = array('name' => 'fname', 'value' => $fname);
	if (!empty($lname))
		$custom_values[] = array('name' => 'lname', 'value' => $lname);
	if (!empty($interests))
		$custom_values[] = array('name' => 'interests', 'value' => $interests);
	
	$retval = grapi::addSubscriber($campaign, $email, $name, $ref, $_SERVER['REMOTE_ADDR'], $custom_values);
	
	echo $retval;
	
	exit();
}

/*
 * 
 * 
 * CREATE A SIDEBAR WIDGET
 * 
 * 
 */
add_action('widgets_init', create_function('', 'register_widget("MLB_Widget");'));
class MLB_Widget extends WP_Widget 
{
    function MLB_Widget() {
        parent::WP_Widget(false, $name = 'Mailing List Builder');	
    }

    function widget($args, $instance) 
    {		
		extract($args);
		extract($instance);
		
		if (empty($campaign))
			$campaign = get_option('mlb_default_campaign');
		
		echo	$before_widget . 
				$before_title .
	
				$title .
		
				$after_title;
				
		require('form_sb.php');
		
		echo	$after_widget;
    }

    function update($new_instance, $old_instance) 
    {				
        return $new_instance;
    }
    
    function form($instance) 
    {
    	$title = esc_attr($instance['title']);
    	$cta = esc_attr($instance['cta']);
    	$campaign = esc_attr($instance['campaign']);
    	$ref = esc_attr($instance['ref']);
    	$interests = esc_attr($instance['interests']);
?>
<p>
	<label for="<?php echo $this->get_field_id('title'); ?>">
		<?php _e('Widget Title:'); ?> 
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id('cta'); ?>">
		<?php _e('Call to Action:'); ?> 
		<textarea class="widefat" id="<?php echo $this->get_field_id('cta'); ?>" name="<?php echo $this->get_field_name('cta'); ?>"><?php echo $cta; ?></textarea>
	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id('campaign'); ?>">
		<?php _e('Campaign:'); ?> 
		<input class="widefat" id="<?php echo $this->get_field_id('campaign'); ?>" name="<?php echo $this->get_field_name('campaign'); ?>" type="text" value="<?php echo $campaign; ?>" />
	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id('ref'); ?>">
		<?php _e('Tracking Code:'); ?> 
		<input class="widefat" id="<?php echo $this->get_field_id('ref'); ?>" name="<?php echo $this->get_field_name('ref'); ?>" type="text" value="<?php echo $ref; ?>" />
	</label>
</p>
<p>
	<label for="<?php echo $this->get_field_id('interests'); ?>">
		<?php _e('Interests (Example: boxing photography swimming):'); ?> 
		<input class="widefat" id="<?php echo $this->get_field_id('ref'); ?>" name="<?php echo $this->get_field_name('interests'); ?>" type="text" value="<?php echo $interests; ?>" />
	</label>
</p>
<?php 
	} 
}
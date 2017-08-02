<?php
/*
Plugin Name: ByREV Fast Category Cloud (Widget Version)
Plugin URI: http://byrev.org/bookmarks/wordpress/fast-category-cloud-wordpress-plugin/
Description: Fast Category Cloud WordPress Plugin (Widget Version) - plugin that shows categories as a colored tag cloud with post count. If you want to use "Widget Version", you must activate "Base Version", otherwise the plugin will display categories.
Author: ByREV ( Robert Emilian Vicol)
Version: 1.42
Author URI: http://byrev.org
*/

define('MAX_LIMIT_CAT_WIDGET',100);
define('BYREV_CAT_CLOUD_WIDGET_TITLE','ByREV Category Cloud (Widget)');
define('BYREV_CAT_CLOUD_WIDGET_VER','1.42');

add_action("widgets_init", array('Widget_ByREV_Cat_Cloud', 'register'));
register_activation_hook( __FILE__, array('Widget_ByREV_Cat_Cloud', 'activate'));
register_deactivation_hook( __FILE__, array('Widget_ByREV_Cat_Cloud', 'deactivate'));

class Widget_ByREV_Cat_Cloud {
  function activate(){  	  	  	
  	$data = array('title'=>'Category Cloud','min_scale'=>8,'max_scale'=>18,'mincount'=>1,'limitcat'=>MAX_LIMIT_CAT_WIDGET,'order'=>'rand','color_start'=>'0000FF','color_end'=>'FFAAAA','cache'=>'on','cache_timeout'=>60,'view_count'=>'on','orderby'=>'name', 'exclude'=>''); 
    if ( ! get_option('Widget_ByREV_Cat_Cloud')){
      add_option('Widget_ByREV_Cat_Cloud' , $data);
    } else {
      update_option('Widget_ByREV_Cat_Cloud' , $data);  }
  }
  
  function deactivate(){ delete_option('Widget_ByREV_Cat_Cloud');  }
  
  function control(){ $data = get_option('Widget_ByREV_Cat_Cloud');
	  ?>
	<p><label>Title:&nbsp;<input name="cc_title" type="text" value="<?php echo $data['title']; ?>" /></label></p>
    <p><label>Minim Count Posts:&nbsp;<input name="cc_mincount" type="text" value="<?php echo $data['mincount']; ?>" size="3" /></label></p>    
    <p><label>Number of Categories:&nbsp;<input name="cc_limitcat" type="text" value="<?php echo $data['limitcat']; ?>" size="3" /></label></p>
	<p><label>Exclude Cat.&nbsp;<sup>(comma separated)</sup><br /><input name="cc_exclude" type="text" value="<?php echo $data['exclude']; ?>" size="30" /></label></p>    
    <p><label>View Count&nbsp;<input type="checkbox" name="cc_view_count" value="on" <?php if ($data['view_count'] == "on" ) {echo 'checked';} ?>>&nbsp;(beside category)</label></p>	
	<fieldset style="border: 1px solid #ccc; padding: 5px 0 5px 5px; margin-top: 5px;"><legend><b>Font Size</b></legend>
		<label>Minim:&nbsp;<input name="cc_min_scale" type="text" value="<?php echo $data['min_scale']; ?>" size="3" /></label>,
		<label>Maxim:&nbsp;<input name="cc_max_scale" type="text" value="<?php echo $data['max_scale']; ?>" size="3" /></label>
	</fieldset>
	<fieldset style="border: 1px solid #ccc; padding: 5px 0 5px 5px; margin-top: 5px;"><legend><b>Order/Sorting</b></legend>
		<u>Sorting</u>:&nbsp; 
		<label>Count<input type="radio" value="count" name="cc_orderby" <?if ($data['orderby']=='count') echo 'checked';?>/></label>, 
		<label>Name<input type="radio" value="name" name="cc_orderby" <?if ($data['orderby']=='name') echo 'checked';?>/></label>, 
		<label>Id<input type="radio" value="id" name="cc_orderby" <?if ($data['orderby']=='id') echo 'checked';?>/></label>
		<hr>
		<u>Order&nbsp;&nbsp;</u>:&nbsp;
		<label>Rand<input type="radio" value="rand" name="cc_order" <?if ($data['order']=='rand') echo 'checked';?>/></label>, 
		<label>Desc<input type="radio" value="desc" name="cc_order" <?if ($data['order']=='desc') echo 'checked';?>/></label>, 
		<label>Asc<input type="radio" value="asc" name="cc_order" <?if ($data['order']=='asc') echo 'checked';?>/></label>		
	</fieldset>        
	<fieldset style="border: 1px solid #ccc; padding: 5px 0 5px 5px; margin-top: 5px;"><legend><b>Color (hex value)</b></legend>
		<label>Start:&nbsp;<input name="cc_color_start" type="text" value="<?php echo $data['color_start']; ?>" size="7" /></label>, 
		<label>End:&nbsp;<input name="cc_color_end" type="text" value="<?php echo $data['color_end']; ?>" size="7" /></label>
	</fieldset>            
	<fieldset style="border: 1px solid #ccc; padding: 5px 0 5px 5px; margin-top: 5px;"><legend><b>Cache</b></legend>
		<label>Enable&nbsp;<input type="checkbox" name="cc_cache" value="on" <?php if ($data['cache'] == "on" ) {echo 'checked';} ?>></label>, 
		<label>TimeOut:&nbsp;<input name="cc_cache_timeout" type="text" value="<?php echo $data['cache_timeout']; ?>" size="6" />sec</label>
	</fieldset> 
    <?php    
    if (isset($_POST['cc_min_scale'])){
    	$data['min_scale'] = attribute_escape($_POST['cc_min_scale']);
    	$data['max_scale'] = attribute_escape($_POST['cc_max_scale']);
    	$data['mincount'] = attribute_escape($_POST['cc_mincount']);
    	$data['limitcat'] = attribute_escape($_POST['cc_limitcat']);
    	$data['order'] = attribute_escape($_POST['cc_order']);
    	$data['orderby'] = attribute_escape($_POST['cc_orderby']);
    	$data['color_start'] = attribute_escape($_POST['cc_color_start']);
    	$data['color_end'] = attribute_escape($_POST['cc_color_end']);
    	$data['title'] = attribute_escape($_POST['cc_title']);    	
    	if (isset($_POST['cc_cache'])) { 
    		$data['cache'] = attribute_escape($_POST['cc_cache']); 
    	} else { $data['cache'] = 'off';	}    		    	
    	if (isset($_POST['cc_view_count'])) { 
    		$data['view_count'] = attribute_escape($_POST['cc_view_count']); 
    	} else { $data['view_count'] = 'off';	}    		    	
    	$data['cache_timeout'] = attribute_escape($_POST['cc_cache_timeout']);
    	$data['exclude'] = attribute_escape($_POST['cc_exclude']);
    	update_option('Widget_ByREV_Cat_Cloud', $data);
  	}
  }

  function widget($args){
  	if (!defined('BYREV_CAT_CLOUD_VER')) { echo '<p>Ups! <b>ByREV Fast Category Cloud</b> Plugin Error!</p><p><b>Widget Version</b> does not work without <b>Base Version</b>, so please enable it and the <b>Base Version</b>!</p>'; return; } 
    $widget_args = get_option('Widget_ByREV_Cat_Cloud',array());
    $sargs = '';
    foreach ($widget_args as $key=>$value) {
    	$sargs .= $key.'='.$value.'&'; } 
    echo $args['before_widget'];      	
	echo $args['before_title'] . $widget_args['title'] . $args['after_title'];    	
    byrev_cat_cloud($sargs);
    echo $args['after_widget'];
  }
  
  function register(){
    register_sidebar_widget(BYREV_CAT_CLOUD_WIDGET_TITLE, array('Widget_ByREV_Cat_Cloud', 'widget'));
    register_widget_control(BYREV_CAT_CLOUD_WIDGET_TITLE, array('Widget_ByREV_Cat_Cloud', 'control'));  }
  }
?>
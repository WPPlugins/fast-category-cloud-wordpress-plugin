<?php
/*
Plugin Name: ByREV Fast Category Cloud (Base Version)
Plugin URI: http://byrev.org/bookmarks/wordpress/fast-category-cloud-wordpress-plugin/
Description: Fast Category Cloud WordPress Plugin (Base Version) - plugin that shows categories as a colored tag cloud with post count !!!
Author: ByREV ( Robert Emilian Vicol )
Version: 1.42
Author URI: http://byrev.org/
*/

define('MAX_LIMIT_CAT',100);
define('BYREV_CAT_CLOUD_TITLE','ByREV Fast Category Cloud (Base)');
define('BYREV_CAT_CLOUD_VER','1.42');

function byrev_cat_cloud($arg="") {	
	$args = array('title'=>'Category Cloud','min_scale'=>8, 'max_scale'=>18, 'mincount'=>1, 'limitcat'=>MAX_LIMIT_CAT, 'order'=>'rand', 'color_start'=>'0000FF', 'color_end'=>'FFAAAA','cache'=>'on','cache_timeout'=>60,'view_count'=>'on','orderby'=>'name',
		'format_link'=>'<a rel="tag" href="%link%" title="%description% (%count%)" style="color:%color_link%;font-size:%size%pt">%title%</a>','format_count'=>'<sub style="font-size:%size2%pt; color:%color_link%;">%count%</sub>', 'exclude'=>'');

	if ($arg != "") {
		$fargs = explode('&',$arg); 
		foreach ($fargs as $farg) {
			$kv = explode('=',$farg);
			if ( (count($kv) == 2) and ($kv[1] !="") )
				$args[$kv[0]] = $kv[1]; }
	}
	
	$BYREV_CAT_CLOUD_DB_CACHE = ($args['cache']=='on');
		
	if ($BYREV_CAT_CLOUD_DB_CACHE) {
		$option = 'byrev_cc_cache14_'.md5($arg);
		$this_time = time();
		$cc_cache = get_option($option, array("",0));
		if ($cc_cache[1] > $this_time) {
			echo $cc_cache[0];	return;	}
	}
	
	$html_code = "<div id=\"byrev_cat_cloud\">\n";
	get_cat_cloud_(&$args, &$html_code);
	$html_code .= "</div>\n";
	if ($BYREV_CAT_CLOUD_DB_CACHE) {
		update_option($option, array($html_code,$this_time + $args['cache_timeout']) ); }
	echo $html_code;
}

function zp($num,$len) { return str_pad($num, $len, "0", STR_PAD_LEFT); } #~~ zero pad 
function zp2($num) { if (strlen($num)==2) { return $num; } else { return '0'.$num; } } #~~ zero pad for 2 char only (used for r/g/b)

function get_cat_cloud_(&$args, &$html_code) {

	$min_scale = $args['min_scale']; $max_scale = $args['max_scale']; $mincount = $args['mincount']; $limitcat = $args['limitcat'];
	if (($limitcat < 0) or ($limitcat > MAX_LIMIT_CAT)) { $limitcat = 50; }	
	
	$view_count = ($args['view_count']=='on');
	if ($view_count) {
		$format = $args['format_link'].$args['format_count'];
	} else {
		$format = &$args['format_link']; }
			
	$order = $args['order'];
	if ($order == 'rand') { $args['order'] = 'asc'; }		
	$results  =  get_categories('number='.$limitcat.'&hierarchical=0&orderby='.$args['orderby'].'&order='.$args['order'].'&exclude='.$args['exclude']); 
	if ($order == 'rand') shuffle($results);

	$distinctArr = array();
    foreach( $results as $cat ) { 
    	$distinctArr[$cat->count] = 1; }
	krsort($distinctArr, SORT_NUMERIC);		
	
	list($r1,$g1,$b1) = str_split(zp($args['color_start'],6), 2);
	$r1=hexdec($r1); $g1=hexdec($g1); $b1=hexdec($b1);		#~~ rgb component - start color
	
	list($r2,$g2,$b2) = str_split(zp($args['color_end'],6), 2);
	$r2=hexdec($r2); $g2=hexdec($g2); $b2=hexdec($b2);		#~~ rgb component - final color
		
	$ncat = count($distinctArr)-1;
	$sr = ($r2-$r1)/$ncat;	$sg = ($g2-$g1)/$ncat;	$sb = ($b2-$b1)/$ncat;	#~~ scale color r,g,b
	$scale_f = ($max_scale-$min_scale)/$ncat;	#~~ scale font size
	$size_f = $max_scale;
	
	foreach ($distinctArr as $key=>$value) {
		$color = '#'.zp2(dechex($r1)).zp2(dechex($g1)).zp2(dechex($b1));
		$distinctArr[$key] = array('color'=>$color,'size'=>$size_f);
		$r1 = $r1+$sr; $g1 = $g1+$sg; $b1 = $b1+$sb;
		$size_f = $size_f - $scale_f;
	}
	
	foreach( $results as $cat ) {
		$cat_count = $cat->count;		
		if ($cat_count < $mincount) continue;  #~~ continue with next (post count to low)
		$cat_info = &$distinctArr[$cat_count];
		$final_font = $cat_info['size'];
	    $thiscat = str_replace('./', '',get_category_link($cat->term_id));    
	    $html_code .= str_replace( array('%link%','%title%','%description%','%count%','%size%','%size2%','%color_link%'), array($thiscat,$cat->name,$cat->name,$cat_count,$final_font,$final_font*0.6, $cat_info['color']), $format)."\n";
		}		
	$html_code .= "<!-- ".BYREV_CAT_CLOUD_TITLE." WordPress Plugin, Version:".BYREV_CAT_CLOUD_VER." , http://byrev.net -->\n";
}
?>
=== Fast Category Cloud WordPress Plugin ===
Contributors: byrev
Donate link: http://byrev.org/bookmarks/fast-category-cloud-wordpress-plugin/
Tags: cat, category, cloud, fast, cache, tags, seo
Requires at least: 2.0.2
Tested up to: 3.1
Stable tag: 1.42

== Description ==

Public release of ByREV Fast Category Cloud , a wordpress plugin that shows categories as a tag cloud.

ByREV Fast Category Cloud Features:

*  True Fade Color ~ all the colors change independently, but the correct proportion of each variety of colors: red, green and blue.)
*  Cache Result ~ for fast loading and use less resources (default timeout cache = 60s)
*  Show Count Post ~ number of items is displayed outside the category link, so SEO is not affected.
*  Sort by : ascending order, descending, alphabetical and random.
*  Limit Category ~ Show a fixed number of categories (option)
*  Exclude category with lower number of posts
*  Minimum and maximum font size can be of any value

Highly optimized for speed and memory

- Plugin is divided in two: "Basic Version" which can be used by inserting PHP code in template pages, and a "Widget Version" which can be manipulated in the WordPress configuration page. The fastest is the "Basic Version".
- Cache help to increase speed and conserve CPU resources.
- Both scripts are under 100 lines of code,  each have exactly 97 lines each.
- For most routines have been tested several versions of code and was chosen the fastest of them.

== Installation ==

*  Download Fast Category Cloud WordPress Plugin and Install !
*  Use Widget menu for config (for Widget Version). Basic Version use cofig from function's call.

For more information, please see [plugin home page](http://byrev.org/bookmarks/fast-category-cloud-wordpress-plugin/)

== Frequently Asked Questions ==

How To Use (if using Basic Version. For Widget use WP Config)

<code>
<p>&lt;?php if (function_exists('byrev_cat_cloud')) { ?&gt;<br>
&lt;div&gt;&lt;h3&gt;Categories Cloud&lt;/h3&gt;<br>
&lt;?php 
byrev_cat_cloud('mincount=1&amp;limitcat=41&amp;order=asc&amp;min_scale=10&amp;max_scale=20&amp;color_start=0000FF&amp;color_end=CCCCCC&amp;cache=ON&amp;cahe_timeout=600&amp;orderby=name'); 
?&gt;<br>
&lt;/div&gt;<br>
&lt;?php } else { ?&gt;<br>
&lt;div&gt;&lt;h3&gt;Categories&lt;/h3&gt;<br>
&lt;ul&gt;&lt;?php wp_list_categories('orderby=name&amp;show_count=1'); ?&gt; &lt;/ul&gt;<br>
&lt;/div&gt;<br>
&lt;?php } ?&gt;</p>
</code>

Where:

*  mincount ~ Minimum post count
*  limitcat : Max no. of categories to display (MAX Value: 100)
*  min_scale : Minimum font size
*  max_scale : Maximum font size
*  color_start : Starting Base Color
*  color_end : Ending Fade Color
*  cache : Enable Caching HTML Code. Valid value: on, off
*  cahe_timeout : Time before the cache expires
*  view_count : Enable display number of items in categories. Valid value: on, off
*  orderby : Sort by : name, id or post count.
*  order : Categories order. Valid value: rand, asc or desc

== Screenshots ==

1. Screenshot Widget Config
2. Screenshot Cloud Cat ASC sorted

== Changelog ==

Fast Category Cloud 1.4 is the first public release of ByREV Fast Category Cloud 

== Upgrade Notice ==

No Notice


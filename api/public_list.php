<?php
header('content-type:application/json;charset=utf8');  
require('../wp-load.php');
class Api{
	//获取最新的文章
	public function get_newsbycat($catid,$num){
		global $wpdb;
		$termslug = $wpdb->get_var("select $wpdb->terms.slug from $wpdb->terms where term_id = $catid");
		$request = "select $wpdb->posts.post_title,post_date,guid,ID from $wpdb->posts join $wpdb->term_relationships on $wpdb->posts.ID = $wpdb->term_relationships.object_id where $wpdb->term_relationships.term_taxonomy_id = $catid and $wpdb->posts.post_status = 'publish' order by $wpdb->posts.id DESC limit $num";
		$categroys = $wpdb->get_results($request);
		foreach ($categroys as  $categroy) {
			$categroy->guid = "https://news.c2cx.me/".$termslug."/".$categroy->ID.".html";
		}
		return json_encode($categroys,JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
	} 
}
$api = new Api();
print_r($api->get_newsbycat(2,2));

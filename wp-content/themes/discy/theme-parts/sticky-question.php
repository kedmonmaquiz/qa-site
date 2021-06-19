<?php if (isset($sticky_questions) && is_array($sticky_questions) && !empty($sticky_questions) && $paged == 1) {
	foreach ($sticky_questions as $value) {
		$value = (int)$value;
		if ($value > 0) {
			$get_the_permalink = get_the_permalink($value);
			if ($get_the_permalink != "") {
				$questions_sticky[] = $value;
			}
		}
	}
	update_option('sticky_questions',$questions_sticky);
	if (isset($custom_args) && is_array($custom_args) && !empty($custom_args)) {
		$custom_args = $custom_args;
	}else {
		$custom_args = array();
	}

	$block_users = discy_options("block_users");
	$author__not_in = array();
	if ($block_users == "on") {
		$user_id = get_current_user_id();
		if ($user_id > 0) {
			$get_block_users = get_user_meta($user_id,"wpqa_block_users",true);
			if (is_array($get_block_users) && !empty($get_block_users)) {
				$author__not_in = array("author__not_in" => $get_block_users);
			}
		}
	}
	
	$query_sticky_meta = array("key" => "sticky","compare" => "=","value" => 1);
	$discy_show_sticky = apply_filters('discy_show_sticky',false);
	
	if ((isset($wp_page_template) && $wp_page_template == "template-question.php" && isset($orderby_post) && $orderby_post == "polls") || (isset($_GET["type"]) && $_GET["type"] == "poll") || $discy_show_sticky == true || (isset($first_one) && ($first_one == "polls" || $first_one == "polls-time")) || (isset($_GET["show"]) && $_GET["show"] == "polls")) {
		$args = array_merge($custom_args,$author__not_in,array("nopaging" => true,"post_type" => "question","post__in" => $questions_sticky,"meta_query" => array(array('relation' => 'AND',array("key" => "question_poll","value" => "on","compare" => "LIKE"),$query_sticky_meta))));
		$discy_show_sticky = apply_filters('discy_sticky_args',$args,$custom_args,$questions_sticky,$query_sticky_meta);
	}else {
		$args = array_merge($custom_args,$author__not_in,array("nopaging" => true,"post_type" => "question","post__in" => $questions_sticky,"meta_query" => $query_sticky_meta));
	}
	
	query_posts($args);
	$k_ad_p = isset($GLOBALS['k_ad_p'])?$GLOBALS['k_ad_p']:-1;
	if (have_posts() ) :
		$is_questions_sticky = true;
		while (have_posts() ) : the_post();
			$k_ad_p++;
			include locate_template("theme-parts/content-question.php");
		endwhile;
	endif;
	wp_reset_query();
}

if (isset($sticky_only) && $sticky_only == true && isset($show_custom_error) && $show_custom_error == true && (!isset($is_questions_sticky))) {
	include locate_template("theme-parts/content-none.php");
}?>
<?php if (is_page()) {
	$user_group    = discy_post_meta("user_group");
	$user_sort     = discy_post_meta("user_sort");
	$user_style    = discy_post_meta("user_style");
	$masonry_style = discy_post_meta("masonry_user_style");
	$user_order    = discy_post_meta("user_order");
	$number        = discy_post_meta("users_per_page");
	$number        = (isset($number) && $number > 0?$number:apply_filters('discy_users_per_page',get_option('posts_per_page')));
}else {
	$user_group    = "";
	$user_style    = discy_options("user_style_pages");
	$masonry_style = discy_options("masonry_user_style");
	$user_sort     = (isset($user_sort)?$user_sort:"user_registered");
	$user_sort     = (isset($_GET["user_filter"]) && $_GET["user_filter"] != ""?esc_html($_GET["user_filter"]):$user_sort);
	$user_order    = "DESC";
	$number        = discy_options("users_per_page");
	$number        = (isset($number) && $number > 0?$number:apply_filters('users_per_page',get_option('posts_per_page')));
}
$discy_sidebar = discy_sidebars("sidebar_where");
$active_points = discy_options("active_points");
$paged         = discy_paged();
$offset        = ($paged -1) * $number;
$user_sort     = (isset($_GET["user_filter"]) && $_GET["user_filter"] != ""?esc_html($_GET["user_filter"]):(isset($user_sort) && $user_sort != ""?$user_sort:"user_registered"));
$user_order    = (isset($_GET["user_filter"]) && ($_GET["user_filter"] == "ID" || $_GET["user_filter"] == "display_name" || $_GET["user_filter"] == "user_registered")?"ASC":$user_order);
$search_value  = (has_wpqa()?wpqa_search():"");
$search_value  = apply_filters("wpqa_search_value_filter",$search_value);
$role__in = array('role__in' => (isset($user_group) && is_array($user_group)?$user_group:array()));

if (($user_sort == "points" && $active_points == "on") || $user_sort == "followers" || $user_sort == "the_best_answer" || $user_sort == "post_count" || $user_sort == "question_count" || $user_sort == "answers" || $user_sort == "comments") {
	add_action('pre_user_query','wpqa_custom_search_users');
	$user_key = $user_sort;
	if ($user_sort == "the_best_answer") {
		$user_key = "wpqa_count_best_answers";
	}else if ($user_sort == "post_count") {
		$user_key = "wpqa_posts_count";
	}else if ($user_sort == "question_count") {
		$user_key = "wpqa_questions_count";
	}else if ($user_sort == "answers") {
		$user_key = "wpqa_answers_count";
	}else if ($user_sort == "comments") {
		$user_key = "wpqa_comments_count";
	}else if ($user_sort == "followers") {
		$user_key = "count_following_you";
	}
	$args = array_merge($role__in,array(
		'meta_query' => ($search_value != ""?array("relation" => "AND",$user_sort."_order" => array("key" => $user_key,"value" => 0,"compare" => ">="),array('relation' => 'OR',array("key" => "first_name","value" => $search_value,"compare" => "RLIKE"))):array("relation" => "or",array("key" => $user_key,"compare" => "NOT EXISTS"),array("key" => $user_key,"value" => 0,"compare" => ">="))),
		'orderby'   => 'meta_value_num',
		'order'     => $user_order,
		'offset'    => $offset,
		'search'    => ($search_value != ""?'*'.$search_value.'*':''),
		'number'    => $number,
		'fields'    => 'ID',
	));
	$query = new WP_User_Query($args);
	$total_query = $query->get_total();
	$total_pages = ceil($total_query/$number);
	$get_results = true;
}else {
	add_action('pre_user_query','wpqa_custom_search_users');
	if ($user_sort != "user_registered" && $user_sort != "display_name" && $user_sort != "ID") {
		$user_sort = "user_registered";
	}
	$args = array_merge($role__in,array(
		'meta_query' => ($search_value != ""?array('relation' => 'OR',array("key" => "first_name","value" => $search_value,"compare" => "RLIKE")):array()),
		'orderby'    => $user_sort,
		'order'      => $user_order,
		'offset'     => $offset,
		'search'     => ($search_value != ""?'*'.$search_value.'*':''),
		'number'     => $number,
		'fields'     => 'ID',
	));
	$query = new WP_User_Query($args);
	$total_query = $query->get_total();
	$total_pages = ceil($total_query/$number);
	$get_results = true;
}
$user_col = "col6";
if (($user_style == "columns" && ($discy_sidebar == "sidebar" || $discy_sidebar == "centered" || $discy_sidebar == "menu_left")) || ($user_style == "small_grid" && $discy_sidebar != "full")) {
	$user_col = "col4";
}else if ($discy_sidebar == "full") {
	$user_col = "col3";
}
$query = (isset($get_results)?$query->get_results():$query);
echo "<div class='user-section user-section-".$user_style.($user_style == "small_grid" || $user_style == "grid" || $user_style == "small" || $user_style == "columns"?" row".($masonry_style == "on"?" users-masonry":""):"").($user_style != "normal"?" user-not-normal":"").(isset($query) && !empty($query)?"":" discy_hide")."'>";
	if (isset($query) && !empty($query)) {
		foreach ($query as $user) {
			$user = (isset($user->ID)?$user->ID:$user);
			$owner_user = false;
			if (get_current_user_id() == $user) {
				$owner_user = true;
			}
			echo ($user_style == "small_grid" || $user_style == "grid" || $user_style == "small" || $user_style == "columns"?"<div class='col ".$user_col.($masonry_style == "on"?" user-masonry":"")."'>":"");
				do_action("wpqa_author",array("user_id" => $user,"author_page" => $user_style,"owner" => $owner_user,"type_post" => ($user_sort == "post_count" || $user_sort == "comments"?"post":$user_sort)));
			echo ($user_style == "small_grid" || $user_style == "grid" || $user_style == "small" || $user_style == "columns"?"</div>":"");
		}
	}else {
		$no_user = true;
	}
echo "</div>";

$current_page = max(1,$paged);
if ($total_pages > 1) {
	$pagination_args = array(
		'format'    => (has_wpqa() && wpqa_is_search()?'':'page/%#%/'),
		'current'   => $current_page,
		'total'     => $total_pages,
		'prev_text' => '<i class="icon-left-open"></i>',
		'next_text' => '<i class="icon-right-open"></i>',
	);
	if (!get_option('permalink_structure')) {
		$pagination_args['base'] = esc_url_raw(add_query_arg('paged','%#%'));
	}
	if (has_wpqa() && wpqa_is_search()) {
		$pagination_args['format'] = '?page=%#%';
	}
	echo '<div class="main-pagination"><div class="pagination">'.paginate_links($pagination_args).'</div></div><div class="clearfix"></div>';
}
remove_action('pre_user_query','wpqa_custom_search_users');

if (isset($no_user) && $no_user == true) {
	include locate_template("theme-parts/search-none.php");
}?>
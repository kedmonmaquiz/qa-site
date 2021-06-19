<?php get_header();
	$its_question  = "question";
	$paged         = discy_paged();
	$active_sticky = true;
	$custom_args   = array("post_type" => "question");
	$show_sticky   = true;
	include locate_template("theme-parts/loop.php");
get_footer();?>
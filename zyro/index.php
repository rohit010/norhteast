<?php
error_reporting(E_ALL); ini_set('display_errors', true);
	$pages = array(
		'0'	=> array('id' => '1', 'alias' => 'HOME', 'file' => '1.php'),
		'1'	=> array('id' => '2', 'alias' => 'ABOUT', 'file' => '2.php'),
		'2'	=> array('id' => '6', 'alias' => 'CONTACTS', 'file' => '6.php')
	);
	$forms = array(

	);
	$base_dir = dirname(__FILE__);
	$base_url = '/';
	$show_comments = false;
	include dirname(__FILE__).'/functions.inc.php';
	$home_page = '1';
	$page_id = parse_uri();
	$user_key = "WfU/4VtB9iogoeutfd349r/5aE8WO+cwRltOvoA=";
	$user_hash = "e9ab6ecbb48b2539";
	$comment_callback = "http://us.zyro.com/comment_callback/";
	$preview = false;
	$mod_rewrite = true;
	handleComments($pages[$page_id]['id']);
	if (isset($_POST["wb_form_id"])) handleForms($pages[$page_id]['id']);
	ob_start();
	if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'news')
		include dirname(__FILE__).'/news.php';
	else if (isset($_REQUEST['view']) && $_REQUEST['view'] == 'blog')
		include dirname(__FILE__).'/blog.php';
	else {
		$fl = dirname(__FILE__).'/'.$pages[$page_id]['file'];
		if (is_file($fl)) include $fl; else echo '404 Not found';
	}
	ob_end_flush();

?>
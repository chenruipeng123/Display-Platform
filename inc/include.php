<?php 
	header("Content-Type:text/html;charset=utf-8");
	session_start();
	// error_reporting(E_ALL ^ E_NOTICE);
	date_default_timezone_set("PRC");
	define("ROOT",dirname(__FILE__));
	// echo set_include_path(".".PATH_SEPARATOR.ROOT."/inc".PATH_SEPARATOR.get_include_path());
	require_once 'page.class.php';
	require_once 'mysql.class.php';
	require_once 'upload.class.php';
	require_once 'common.func.php';
	require_once 'admin.func.php';
    $mysqlObj = new mysql('et_show','root','root','127.0.0.1');
    $up = new FileUpload('et_show','root','root','127.0.0.1');

<?php 
	
	function loginCheck(){
		if ($_SESSION['adminId']==""&&$_COOKIE['adminId']=="") {
			skip("login.php");	
		}
	}
	function logout(){
		$_SESSION = array();
		if (isset($_COOKIE['adminId'])&&isset($_COOKIE['adminName'])) {
			setcookie('adminId',"",time()-1);
			setcookie('adminName',"",time()-1);
		}
		session_unset();
		session_destroy();
		echo "<script>window.location='login.php';</script>";
	}
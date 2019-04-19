<?php 
	error_reporting(E_ALL||~E_NOTICE);
	/*function foreloginCheck(){
		if ($_SESSION['u_id']==""&&$_SESSION['name']=="") {
			alertMes('请先登录！。','login.php');	
		}
	}

	function forelogout(){
		$_SESSION = array();
		if (isset($_COOKIE['u_id'])&&isset($_COOKIE['name'])) {
			setcookie('u_id',"",time()-1);
			setcookie('name',"",time()-1);
		}
		session_unset();
		session_destroy();
		echo "<script>window.location='login.php';</script>";
	}*/

/**
* 获取服务器端IP地址
 * @return string
 */
function getIP() { 
    if (isset($_SERVER)) { 
        if($_SERVER['SERVER_ADDR']) {
            $server_ip = $_SERVER['SERVER_ADDR']; 
        } else { 	
            $server_ip = $_SERVER['LOCAL_ADDR']; 
        } 
    } else { 
        $server_ip = getenv('SERVER_ADDR');
    } 
    return $server_ip; 
}
// 或者
// function getServerIP(){    
//     return gethostbyname($_SERVER["SERVER_NAME"]);    
// } 

<?php
	require_once '../inc/include.php';
	$mysqlObj = new mysql();
	$admin_id = $_SESSION['adminId'];
	switch ($_GET['a']) {
		case 'log':
			$username = $_POST['username'];
			$password = ($_POST['password']);
			$captcha = $_POST['captcha'];
			$remember = $_POST['remember'];
			$vcode = $_SESSION['vcode'];
			if ($captcha==$vcode) {
				$sql = "select * from super where username='$username' and password='$password'";
				// echo $sql;
				// exit;
				$rows = $mysqlObj->fetchOne($sql);
				if ($rows) {
					$_SESSION['adminName'] = $rows['username'];
					$_SESSION['adminId'] = $rows['id'];
					//------------------写入日志----------------
					$time = time();
					$ins['user'] = $_SESSION['adminName'];
					$ins['created_at'] = date("Y-m-d H:i:s",$time);
					$ins['ip'] = getIP();
					$ins['action'] = "登录成功";
					$ins['sql_cont'] = $sql;
					$ins['db_level'] = 4;
					$mysqlObj->insert("super_log",$ins);
					//------------------------------------------
					$upd['last_time'] = date("Y-m-d H:i:s",$time);
					$upd['last_ip'] = getIP();
					$cond['id'] = $_SESSION['adminId'];
					$mysqlObj->update("super",$upd,$cond);
					skip("index.php");
				}else{
					alertMes('登录失败!','login.php');
				}
			}else{
				alertMes('验证码错误！','login.php');
			}

			break;

		case 'logout':
			//------------------写入日志----------------
			$time = time();
			$ins['user'] = $_SESSION['adminName'];
			$ins['created_at'] = date("Y-m-d H:i:s",$time);
			$ins['ip'] = getIP();
			$ins['action'] = "注销登录";
			$ins['sql_cont'] = "";
			$ins['db_level'] = 0;
			$mysqlObj->insert("super_log",$ins);
			//------------------------------------------
			logout();
			break;

		case 'change':
			if (!empty($_POST)&&$_GET['a']=="change") {
				$oldpw = ($_POST['oldpw']);
				$newpw = ($_POST['newpw']);
				$renewpw = ($_POST['renewpw']);
				$sql = "select * from super where id = '{$_SESSION['adminId']}'";
				$rows = $mysqlObj->fetchOne($sql);
				if ($rows['password']==$oldpw) {
					if ($oldpw==$newpw&&$newpw==$renewpw) {
						alertMes("新密码与原密码相同！","pwset.php");
					}
					if ($newpw==$renewpw) {
						$arr['password'] = $newpw;
						$con['id'] = $_SESSION['adminId'];
						$aff = $mysqlObj->update("super",$arr,$con);
						if ($aff>0) {
							//------------------写入日志----------------
							$time = time();
							$ins['user'] = $_SESSION['adminName'];
							$ins['created_at'] = date("Y-m-d H:i:s",$time);
							$ins['ip'] = getIP();
							$ins['action'] = "管理员密码修改";
							$ins['sql_cont'] = $mysqlObj->getLastSql();
							$ins['db_level'] = 3;
							$mysqlObj->insert("super_log",$ins);
							//------------------------------------------
							echo "<script>alert('密码修改成功，请重新登录！');</script>";
							logout();
						}else{
							alertMes("修改失败！","pwset.php");
						}
					}else{
						alertMes("新密码与再次新密码不一致！","pwset.php");
					}
				}else{
					alertMes("原密码错误！","pwset.php");
				}
			}
			break;

		default:
			# code...
			break;
	}

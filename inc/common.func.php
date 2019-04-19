<?php 
	 function getIP(){
        if (isset($_ENV["HOSTNAME"])){
            $MachineName = $_ENV["HOSTNAME"];
        } else if(isset($_ENV["COMPUTERNAME"])){
            $MachineName = $_ENV["COMPUTERNAME"];
        }else{
            $MachineName = "";
        }
        return gethostbyname($MachineName);
    }

	function alertMes($mes,$url){
		echo "<script>alert('{$mes}');window.location.href='{$url}';</script>";
	}

	function mes($mes){
		echo "<script>alert('{$mes}');</script>";
	}

	function skip($url){
		echo "<script>window.location.href='{$url}';</script>";
	}

function imageUpdateSize($picname,$maxx,$maxy,$pre="s_"){
	$info = getimageSize($picname); 
	
	$w = $info[0];
	$h = $info[1];
	
	switch($info[2]){
		case 1: //gif
			$im = imagecreatefromgif($picname);
			break;
		case 2: //jpg
			$im = imagecreatefromjpeg($picname);
			break;
		case 3: //png
			$im = imagecreatefrompng($picname);
			break;
		default:
			die("图片类型错误！");
	}
	
	if(($maxx/$w)>($maxy/$h)){
		$b = $maxy/$h;
	}else{
		$b = $maxx/$w;
	}

	$nw = floor($w*$b);
	$nh = floor($h*$b);
	
	$nim = imagecreatetruecolor($nw,$nh);
		
	imagecopyresampled($nim,$im,0,0,0,0,$nw,$nh,$w,$h);
	
	$picinfo = pathinfo($picname);
	$newpicname= $picinfo["dirname"]."/".$pre.$picinfo["basename"];
	switch($info[2]){
		case 1:
			imagegif($nim,$newpicname);
			break;
		case 2:
			imagejpeg($nim,$newpicname);
			break;
		case 3:
			imagepng($nim,$newpicname);
			break;
	}
	imagedestroy($im);
	imagedestroy($nim);
	return $newpicname;
}



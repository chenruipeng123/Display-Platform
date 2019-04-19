<?php 
	$num="";
	for($i=0;$i<4;$i++){
		$num .= rand(0,9);
	}
	ob_clean();
	//4位验证码也可以用rand（1000,9999）直接生成
	//将生成的验证码写入session,备验证页面使用
	session_start();
	$_SESSION["Checknum"] = $num;
	header("Content-type:image/PNG");
	srand((double)microtime()*1000000);
	$im = imagecreate(60,20);
	$black = imagecolorallocate($im, 0, 0, 0);
	$gray = imagecolorallocate($im,200,200,200);
	imagefill($im,0,0,$gray);
	//随机绘制两条虚线，起干扰作用
	$style = array($black,$black,$black,$black,$black,$gray,$gray,$gray,$gray,$gray,$gray);
	imagesetstyle($im, $style);
	$y1 = rand(0,20);
	$y2 = rand(0,20);
	$y3 = rand(0,20);
	$y4 = rand(0,20);
	imageline($im,0,$y1,60,$y3,IMG_COLOR_STYLED);
	imageline($im,0,$y2,60,$y4,IMG_COLOR_STYLED);
	for ($i=0;$i<4;$i++){
	imagesetpixel($im, rand(0,60), rand(0,20), $black);
	}
	$strx=rand(3,8);
		for ($i=0; $i < 4; $i++) { 
			$strops = rand(1,6);
			imagestring($im,5,$strx,$strops,substr($num, $i,1),$black);
			$strx+=rand(8,12);
		}
	imagepng($im);
	imagedestroy($im);
?>
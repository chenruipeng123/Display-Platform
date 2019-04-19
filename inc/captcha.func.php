<?php
   
$w = 80; //设置图片宽和高
$h = 26;
$str = Array(); //用来存储随机码
$string = "abcdefghijklmnopqrstuvwxyz0123456789";//随机挑选其中4个字符，也可以选择更多，注意循环的时候加上，宽度适当调整
$vcode = '';
for($i = 0;$i < 4;$i++){
   $str[$i] = $string[rand(0,33)];
   $vcode.=$str[$i];
}
session_start(); //启用超全局变量session
$_SESSION["vcode"] = $vcode;
$im = imagecreatetruecolor($w,$h);
$white = imagecolorallocate($im,255,255,255); //第一次调用设置背景色
$black = imagecolorallocate($im,0,0,0); //边框颜色
imagefilledrectangle($im,0,0,$w,$h,$white); //画一矩形填充
imagerectangle($im,0,0,$w-1,$h-1,$black); //画一矩形框
//生成雪花背景
for($i = 1;$i < 200;$i++){ 
   $x = mt_rand(1,$w-9);
   $y = mt_rand(1,$h-9);
   $color = imagecolorallocate($im,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255));
   imagechar($im,1,$x,$y,"*",$color);
}
//将验证码写入图案
for($i = 0;$i < count($str);$i++){
   $x = 13 + $i * ($w - 15)/4;
   $y = mt_rand(3,$h / 3);
   $color = imagecolorallocate($im,mt_rand(0,225),mt_rand(0,150),mt_rand(0,225));
   imagechar($im,5,$x,$y,$str[$i],$color);
}
header("Content-type:image/jpeg"); //以jpeg格式输出，注意上面不能输出任何字符，否则出错
imagejpeg($im);
imagedestroy($im);
?>
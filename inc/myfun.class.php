<?php

class myfun{
	
	//友好输出变量，用于调试
	function dump($var, $echo=true, $label=null, $strict=true) 	{
		$label = ($label === null) ? '' : rtrim($label) . ' ';
		if (!$strict) {
			if (ini_get('html_errors')) {
				$output = print_r($var, true);
				$output = "<pre>" . $label . htmlspecialchars($output, ENT_QUOTES) . "</pre>";
			} else {
				$output = $label . print_r($var, true);
			}
		} else {
			ob_start();
			var_dump($var);
			$output = ob_get_clean();
			if (!extension_loaded('xdebug')) {
				$output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
				$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
			}
		}
		if ($echo) {
			echo($output);
			return null;
		}else
			return $output;
	}
	
	//将GET格式化，传至下一参数
	function format_get(){
		$index = 0;
		$url = $_SERVER['PHP_SELF'] . '?';
		foreach($_GET as $k=>$v){
			if($index != 0)
				$url .= '&';
			$url .= $k . '=' . $v;
			$index++;
		}
		return $url;
	}
	
	function msg($msg,$url=''){
		//加上此句防乱码
		echo "<META http-equiv=Content-Type content=\"text/html; charset=utf-8\">";
		
		echo '<script>';
		echo "alert('$msg');";
		if(!empty($url)){
			echo "window.location.href='$url';";
			echo '</script>';
			exit;
		}
		echo '</script>';
	}
	
	function jump($url = ''){
		echo '<script>';
		//如果为空，自动跳转到上一页
		if(empty($url))
			echo "history.go(-1);";
		else
			echo 'window.location.href=\''.$url.'\';';
		echo '</script>';
		exit;
	}
	
	//刷新左侧动态
	function refresh_left_menu($file_name){
		echo '<script language="javascript">';
		echo 'window.open("' . $file_name . '","leftFrame");';
		echo '</script>';
	}
	//判断日期是否合法 格式：年-月-日
	function is_date($str){
		$newArr = array();
		$strArr = explode("-",$str);
		if(count($strArr) != 3){
			return false;
		}else{
			foreach($strArr as $val){
				if(strlen($val) < 2){
					$val = "0".$val;
				}
				$newArr[] = $val;
			}
			$str = implode("-",$newArr);
			$unixTime = strtotime($str);
			$checkDate = date("Y-m-d",$unixTime);
			if($checkDate == $str){
				return true;
			}else{
				return false;
			}
		}
	}
	
	//excel时间转换
	function excelTime2($time){
		$jd = GregorianToJD(1, 1, 1970);
		$gregorian = JDToGregorian($jd+intval($time)-25569);
		$myDate = explode('/',$gregorian);
		$myDateStr = str_pad($myDate[2],4,'0', STR_PAD_LEFT)
		 			."-".str_pad($myDate[0],2,'0', STR_PAD_LEFT)
					."-".str_pad($myDate[1],2,'0', STR_PAD_LEFT);
		return $myDateStr;		
		
	}
	function set_md5($string){
		return md5(md5($string));	
	}
	
	function get_ip(){
		//return $_SERVER['REMOTE_ADDR'];
		
		///王乐平修改2013.8.10\/
		if (isset($_SERVER)){
			if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
				$realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
			} else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
				$realip = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$realip = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if (getenv("HTTP_X_FORWARDED_FOR")){
				$realip = getenv("HTTP_X_FORWARDED_FOR");
			} else if (getenv("HTTP_CLIENT_IP")) {
				$realip = getenv("HTTP_CLIENT_IP");
			} else {
				$realip = getenv("REMOTE_ADDR");
			}
		}
	 
	 
		return $realip;
			
		///^
	}
//_____王乐平添加  2013，9，10____获取ip所对应的城市_
	function getCity($ip)
	{
	$url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
	$ip=json_decode(file_get_contents($url)); 
	if((string)$ip->code=='1'){
	  return false;
	  }
	  $data = (array)$ip->data;
	return $data; 
	}
	
	
	function get_time(){
		return date('Y-m-d H:i:s');
	}
	
	//超级管理员日志写入
	function write_log($action,$bz=''){
		global $aa;
		$data['user_name'] = $_SESSION['manager_name'];
		$data['time'] = $this->get_time();
		$data['ip'] = $this->get_ip();
		$data['action'] = $action;
		$aa->insert('log_info',$data);
	}
	//创建下拉动态
	function create_down_menu($menu_name,$options,$default){
		$ret = '';
		$ret = '<select name="'.$menu_name.'" id="'.$menu_name.'">';
		foreach($options as $key => $val){
			$ret .= '<option value="'.$key.'"';
			if($key == $default){
				$ret .= ' selected="selected"';
			}
			$ret .= ">$val"."</option>";
		}
		$ret .= "</select>";
		return $ret;
	}	
	//sql转换成下拉动态的数组
	function get_menu_array($sql,$col_name1,$col_name2){
		//col_name1:数组的键名
		//col_name2:数组的键值
		global $aa;
		$rst = $aa->execute($sql);
		$top_type = array();
		$top_type[0] = '请选择';
		while($row = mysql_fetch_array($rst)){
			$top_type[$row[$col_name1]] = $row[$col_name2];
		};
	  return $top_type;
	}
	
	//获取表中的下一个show_order
	function get_next_show_order($table,$condition = '',$sort = 'desc'){
		global $aa;
		//判断有无show_order字段
		$col = $aa->getFields($table);
		if($col['show_order'] == ''){
			return 1;
		}
		$sql = "select `show_order` from {$table}";
		if(!empty($condition)){
			$sql .= " where ".$condition;
		}
		$sql .= " order by show_order {$sort} limit 1";
		$rst = $aa->execute($sql);
		$row = mysql_fetch_array($rst);
		$new_show_order = $sort == 'desc' ? (((int)$row['show_order'])+1) : (((int)$row['show_order'])-1);
		return $new_show_order;
	}
	//动态类型
	function get_menu_type_list($default = ''){
		$list = '<select name="type2" id="type2">';
		$list .= '<option value="1"'.($default == '1' ? ' selected="selected"' : '').'>有下级动态</option>';
		$list .= '<option value="2"'.($default == '2' ? ' selected="selected"' : '').'>普通显示</option>';
		$list .= '<option value="3"'.($default == '3' ? ' selected="selected"' : '').'>新闻列表</option>';
		$list .= '<option value="4"'.($default == '4' ? ' selected="selected"' : '').'>图片列表</option>';
		$list .= '<option value="5"'.($default == '5' ? ' selected="selected"' : '').'>直接跳转</option>';
		$list .= '</select>';
		return $list;
	}
	//二级动态类型
	function get_menu_type_list2($default = ''){
		$list = '<select name="type2" id="type2">';
		$list .= '<option value="2"'.($default == '2' ? ' selected="selected"' : '').'>普通显示</option>';
		$list .= '<option value="3"'.($default == '3' ? ' selected="selected"' : '').'>新闻列表</option>';
		$list .= '<option value="4"'.($default == '4' ? ' selected="selected"' : '').'>图片列表</option>';
		$list .= '<option value="5"'.($default == '5' ? ' selected="selected"' : '').'>直接跳转</option>';

		$list .= '</select>';
		return $list;
	}
	//动态类型
	function get_news_type_list($default = ''){
		$list = '<select name="type2" id="type2">';
		$list .= '<option value="1"'.($default == '1' ? ' selected="selected"' : '').'>有子动态</option>';		
		$list .= '<option value="2"'.($default == '2' ? ' selected="selected"' : '').'>文本显示</option>';
		$list .= '<option value="3"'.($default == '3' ? ' selected="selected"' : '').'>图片显示</option>';
		$list .= '</select>';
		return $list;
	}
	//动态类型2
	function get_news_type_list2($default = ''){
		$list = '<select name="type2" id="type2">';
		$list .= '<option value="2"'.($default == '2' ? ' selected="selected"' : '').'>文本显示</option>';
		$list .= '<option value="3"'.($default == '3' ? ' selected="selected"' : '').'>图片显示</option>';
		$list .= '</select>';
		return $list;
	}	
	//显示属性
	function get_show_tag_list($default = ''){
		$list = '<select name="show_tag" id="show_tag">';
		$list .= '<option value="1"'.($default == '1' ? ' selected="selected"' : '').'>显示</option>';
		$list .= '<option value="2"'.($default == '2' ? ' selected="selected"' : '').'>隐藏</option>';
		$list .= '</select>';
		return $list;
	}
	//部门列表
	function get_department_list($default = ''){
		global $aa;
		$list = '<select name="up_id" id="up_id">';
		if( !$default ) 	$list .= '<option value="0">-=请选择=-</option>';
		$sql = 'select * from department_info order by add_time desc';
		$rst = $aa->execute($sql);
		while($row=@mysql_fetch_assoc($rst)){
			$list .= '<option value="'.$row['id'].'"'.($default == $row['id'] ? ' selected="selected"' : '').'>'.$row['name'].'</option>';	
		}		
		$list.='</select>';
		return $list;
	}	
	//图片等比例缩放显示
	function pic_show($pic_addr,$width,$height){
		if(!file_exists($pic_addr)){
			echo $pic_addr.'<br>文件不存在';
			return;
		}
		$pic_size=@getimagesize($pic_addr);   //获得图片信息
		$str1[0]= "width=\"";
		$str1[1]= "\" height=\"";
		$str1[2]= "\"";
		$str2[0]= "";
		$str2[1]= "|";
		$str2[2]= "";
		//$pic_size[3]为"widht="**" height="**"";字符串替换为"**|**"格式；
		$pic_size2=str_replace($str1,$str2,$pic_size[3]);  
		$pic_size3=explode("|",$pic_size2);
		//取得图片的宽和高
		$width_old=$pic_size3[0];
		$height_old=$pic_size3[1];
		if ($width=="" and $height==""){
			$width_show=$width_old;
			$height_show=$height_old;
		}else if ($width!="" and $height==""){
			$width_show=$width;
			$height_show=ceil(($width_show/$width_old)*$height_old);
		}else if($width=="" and $height!=""){
			$height_show=$height;
			$width_show=ceil(($height_show/$height_old)*$width_old);
		}
	  	echo "<img border=\"0\" src=\"".$pic_addr."\" width=\"".$width_show."\" height=\"".$height_show."\">";
	}
	//banner显示
	function banner_show($pic_addr,$width,$height){
		if(!file_exists($pic_addr)){
			echo $pic_addr.'<br>文件不存在';
			return;
		}
		$file_type=substr($pic_addr,strrpos($pic_addr,"."),strlen($pic_addr)-strrpos($pic_addr,"."));
		if($file_type == '.swf'){
			echo '<embed src="'.$pic_addr.'"';
			if($width != ''){
				echo ' width="'.$width.'"';
			}
			if($height != ''){
				echo ' height="'.$height.'"';
			}
			echo '></embed>';
			return;
		}
		$pic_size=@getimagesize($pic_addr);   //获得图片信息
		$str1[0]= "width=\"";
		$str1[1]= "\" height=\"";
		$str1[2]= "\"";
		$str2[0]= "";
		$str2[1]= "|";
		$str2[2]= "";
		//$pic_size[3]为"widht="**" height="**"";字符串替换为"**|**"格式；
		$pic_size2=str_replace($str1,$str2,$pic_size[3]);  
		$pic_size3=explode("|",$pic_size2);
		//取得图片的宽和高
		$width_old=$pic_size3[0];
		$height_old=$pic_size3[1];
		if ($width=="" and $height==""){
			$width_show=$width_old;
			$height_show=$height_old;
		}else if ($width!="" and $height==""){
			$width_show=$width;
			$height_show=ceil(($width_show/$width_old)*$height_old);
		}else if($width=="" and $height!=""){
			$height_show=$height;
			$width_show=ceil(($height_show/$height_old)*$width_old);
		}
	  	echo "<img border=\"0\" src=\"".$pic_addr."\" width=\"".$width_show."\" height=\"".$height_show."\">";
	}
	
}

?>
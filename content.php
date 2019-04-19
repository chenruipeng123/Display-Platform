<?php
	include 'head.php';
	include 'inc/include.php';
	$t_id = $_GET['t_id'];
?>
<body>
<div id="show_area" style="display: none;overflow:hidden;">
	<iframe id="iframe" frameborder="0"></iframe>
</div>
<div class="swiper-container">
	<div class="swiper-wrapper">
		<div class="swiper-slide">
			<div class="return">
				<a href="javascript:history.go(-1)" style="width:auto"><img src="images/return1.png" alt=""></a>
			</div>
			<div class="swiper_content">
				<ul class="ul_list">
				<?php
					$sql = "select * from menu where state=1 and up_id={$_GET['id']} order by show_order desc";
					$num = mysql_num_rows($sql);
					$info = $mysqlObj->fetchAll($sql);
					foreach ($info as $key => $data) {
					$key+=1;
					if ($data['pic'] != "") {
						$tupian = "upFile/pic/{$data['pic']}";
					}else{
						$tupian = "images/def.jpg";
					}
				?>
					<li><a  class="btn" value="<?php echo $data['id'];?>"><img src="<?php echo $tupian;?>" alt="<?php echo $key;?>"><span><?php echo $data['name']?></span></a>
				<?php
					if ($key % 12 == 0) {
				?>
				</ul>
			</div>
		</div>
		<div class="swiper-slide">
			<div class="return">
					<a href="javascript:history.go(-1)" style="width:auto"><img src="images/return1.png" alt=""></a>
				</div>
				<div class="swiper_content">
					<ul class="ul_list">		
				<?php
						}
					};
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="pagination"></div>
</div>
<?php
	include 'foot.php';
?>
<?php 
	include 'head.php';
	include 'inc/include.php';
?>
<div id="show_area" style="display: none;overflow:hidden;">
	<iframe id="iframe" frameborder="0" ></iframe>
</div>
<body>
	<div class="swiper-container">
	  <div class="swiper-wrapper">
	  <?php
			 $sql = "select * from pages where state=1 order by show_order asc"; 
			 $rst = $mysqlObj->fetchAll($sql);
			foreach ($rst as $key => $row) {
			$url = "upFile/pic/". $row['pic'];
	  ?>
	    <div class="swiper-slide" style=" background: url(<?php echo $url; ?>);background-size: 100%;">
	    	<div class="swiper_content">
	    		<ul>
				<?php
					$sql = "select * from menu where state=1 and up_id=0 and page={$row['page']} order by show_order asc";
					$info = $mysqlObj->fetchAll($sql);
					foreach ($info as $data) {
						if ($data['pic'] != "") {
							$tupian = "upFile/pic/{$data['pic']}";
						}else{
							$tupian = "images/def.jpg";
						}
					$url = "content.php?id={$data['id']}";
					if ($data['level']==1) {
				?>
	    			<li><a class="btn" value="<?php echo $data['id'];?>"><img src="<?php echo $tupian?>" alt=""><span><?php echo $data['name']?></span></a></li>
				<?php }else{ ?>
					<li><a href="<?php echo $url; ?>"><img src="<?php echo $tupian?>" alt=""><span><?php echo $data['name'] ?></span></a></li>
				<?php } ?>
				<?php
					 };
				?>
	    		</ul>
	    	</div>
	    </div>
		<?php };?>
	    <!-- <div class="swiper-slide">
	    	<div class="swiper_content">
	    		<ul>
	    			<li><a href=""><img src="images/timg.jpg" alt=""><span>示例文字</span></a></li>
	    		</ul>
	    	</div>
	    </div> -->
	  </div>
	  <div class="pagination"></div>
	</div>
<?php
	include 'foot.php';
?>

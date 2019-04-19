
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>展示</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="css/idangerous.swiper.css">
	<link rel="stylesheet" href="layui/css/layui.css">
	<link rel="stylesheet" href="css/index.css">
	<style>
		.qqq .swiper-slide {
			background: none !important;
			width: 1600px !important;
			height: 900px;
		}
		.qqq .swiper-slide img {
			display: block;
			width: 1600px !important;
			height: 900px;
		}
		.qqq .swiper-slide video {
			display: block;
			width: 1600px !important;
			height: 900px;
		}
	</style>
</head>
<?php
	include 'inc/include.php';
?>
<body>
	<div class="swiper-container qqq" style="width: 1600px;height: 900px;margin-left: 0;">
		<div class="swiper-wrapper">
			<?php 
				$id = $_GET['id'];
				$sql = "select * from menu_cont where menu_id=$id order by show_order asc";
				$info = $mysqlObj->fetchAll($sql);
                foreach ($info as $key => $data) {
                    ?>
			<div class="swiper-slide">
				<?php
					$file = $data['pic'];
					$nfile = substr(strrchr($file, '.'), 1);
					if ($nfile == "jpg" && "png") {
						echo "<img src='upFile/pic/{$data["pic"]}'>";
					} else {
						echo "<video src='upFile/pic/{$data["pic"]}' controls='controls' autoplay='autoplay'></video>";
						// echo "<embed src='upFile/pic/{$data["pic"]}'/>";
					}
				?>
			</div>
			<?php
                };
			?>
		</div>
		<!-- 如果需要分页器 -->
		<div class="swiper-pagination"></div>

		<!-- 如果需要导航按钮 -->
		<div class="swiper-button-prev"></div>
		<div class="swiper-button-next"></div>
	</div>
</body>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="layui/layui.js"></script>
<script src="js/idangerous.swiper.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.0.2/js/swiper.esm.bundle.js"></script> -->
<script type="text/javascript" src="js/show.js"></script>
</html>
<?php
$cdgl = "active open";
$nrgl = "active open";
include '../inc/include.php';
loginCheck();
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
$did = $_GET['did'];
$sql = "select * from menu where id={$_GET['did']}";
$rows = $mysqlObj->fetchOne($sql);
$sql = "select * from menu_cont where menu_id={$_GET['did']}";
$query = mysql_query($sql);
$max = mysql_num_rows($query);

?>

 <div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li>
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href="index.php">首页</a>
				</li>

				<li>
					<a href="#">内容管理</a>
				</li>
				<li class="active"><?php echo $rows['name'] ?>展示添加</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="">
									<?php
									if ($_GET['did'] != "") {
										echo "<a href='pic2.php?id={$_GET['id']}&did={$_GET[did]}'>";
									} else {
										echo "<a href='pic2.php?id={$_GET['id']}'>";
									}
									?>
									<?php echo $rows['name'] ?>展示列表
								</a>
							</li>
							<li class="active">
								<a href="pic2_add.php?id=<?php echo $_GET['id'] ?>" >
									<?php echo $rows['name'] ?>展示添加
								</a>
							</li>
						</ul>
						<?php
					if (isset($_GET['a']) && $_GET['a'] == 'add') {
						$ins = $_POST;
						$up = new FileUpload();
						$upload_url = "../upFile/pic/";
						$up->set("path", $upload_url);
						if ($up->upload("pic")) {
							$pic = $up->getFileName();
						}
						$ins['pic'] = $pic;
						$created_at = date('Y-m-d,H:i:s', time());
						if ($did != "") {
							$ins['menu_id'] = $_GET['did'];
						}else{
							$ins['menu_id'] = $_GET['id'];
						}
						$ins['title'] = $_POST['title'];
						$ins['show_order']= $_POST['show_order'];
						$ins['created_at'] = $created_at;
						$ins['state'] = $_POST['state'];
						$ins['add_user'] = $_SESSION['adminName'];
								// echo "<pre>";
								// var_dump($ins);
								// exit;
						$mes = $mysqlObj->insert("menu_cont", $ins);
								// var_dump($mes);
								// exit;
						if ($mes) {
							alertMes("添加成功！", "pic2.php?id={$_GET['id']}&did={$_GET['did']}");
						} else {
							alertMes("添加失败！", "pic2_add.php?id={$_GET['id']}&did={$_GET['did']}");
							exit;
						}
					}
					?>
						<div class="tab-content">
							<form action="pic2_add.php?id=<?php echo $_GET['id'] ?>&did=<?php echo $_GET['did']?>&a=add" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
								<!-- #section:elements.form -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示序号</label>
									<div class="col-sm-9">
										<input type="number" name="show_order" class="col-xs-10 col-sm-1" value="<?php echo $max+1 ?>">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">标题</label>
									<div class="col-sm-9">
										<input type="text" name="title" placeholder="请输入标题" class="col-xs-10 col-sm-5">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">文件</label>
									<div class="col-sm-9">
										<input type="file" name="pic">
									</div>
								</div>
								<!-- <div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1" >内容</label>
									<div class="col-sm-10">
										<script id="editor" name="cont"  type="text/plain" style="width:500px;height:300px;"></script>
									</div>
								</div> -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示状态</label>
									<div class="col-sm-9">
										<div class="radio">
											<label>
												<input class="ace" checked="" name="state" type="radio" value="1">
												<span class="lbl"> 显示</span>
											</label>
										</div>
										<div class="radio">
											<label>
												<input class="ace" name="state" type="radio" value="0">
												<span class="lbl">隐藏</span>
											</label>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">添加人</label>
									<div class="col-sm-9">
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle"><?php echo $_SESSION['adminName'] ?></span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">添加时间</label>
									<div class="col-sm-9">
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle">系统自动记录</span>
										</span>
									</div>
								</div>
								<div class="form-group">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" type="submit">
											<i class="ace-icon fa fa-check bigger-110"></i>
											提交
										</button>
										&nbsp; &nbsp; &nbsp;
										<button class="btn" type="reset">
											<i class="ace-icon fa fa-undo bigger-110"></i>
											重置
										</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>
 <?php include '../inc/footer.inc.php'; ?>
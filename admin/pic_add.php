<?php
	$cdgl = "active open";
	$nrgl = "active open";
	include '../inc/include.php';
	loginCheck();
	include '../inc/header.inc.php';
	include '../inc/nav.inc.php';
	$sql = "select * from menu where id={$_GET['id']}";
	$info = $mysqlObj->fetchOne($sql);
	$sql = "select * from menu where up_id={$_GET['id']}";
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
				<li class="active"><?php echo $info['name'] ?>添加</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="">
								<a href="pic.php?id=<?php echo $_GET['id'] ?>">
									<?php echo $info['name'] ?>列表
								</a>
							</li>
							<li class="active">
								<a href="pic_add.php?id=<?php echo $_GET['id'] ?>" >
									<?php echo $info['name'] ?>添加
								</a>
							</li>
						</ul>
						<?php
							if (isset($_GET['a'])&&$_GET['a']=='add') {
								$ins = $_POST;
								$up = new FileUpload();
								$upload_url = "../upFile/pic/";
								$up->set("path", $upload_url);
								if ($up->upload("pic")) {
									$pic = $up->getFileName();
									imageUpdateSize($upload_url . $pic, 200, 100, $pre = "s_");
								}
								$ins['pic'] = $pic;
								$created_at=date('Y-m-d,H:i:s',time());
								$ins['up_id']=$_GET['id'];
								$ins['show_order']= $_POST['show_order'];
								$ins['name']= $_POST['name'];
								// $ins['cont']= $_POST['cont'];
								$ins['created_at']=$created_at;
								$ins['state']= $_POST['state'];
								$ins['add_user']=$_SESSION['adminName'];
								// echo "<pre>";
								// var_dump($ins);
								// exit;
								$mes = $mysqlObj->insert("menu",$ins);
								// var_dump($mes);
								// exit;
								if ($mes) {
									alertMes("添加成功！","pic.php?id={$_GET['id']}");
								}else{
									alertMes("添加失败！","pic_add.php?id={$_GET['id']}");
									exit;
								}
							}
						 ?>
						<div class="tab-content">
							<form action="pic_add.php?id=<?php echo $_GET['id'] ?>&a=add" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
								<!-- #section:elements.form -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示序号</label>
									<div class="col-sm-9">
										<input type="number" name="show_order" class="col-xs-10 col-sm-1" value="<?php echo $max+1 ?>">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单名称</label>
									<div class="col-sm-9">
										<input type="text" name="name" placeholder="请输入菜单名称" class="col-xs-10 col-sm-5">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单图标</label>
									<div class="col-sm-9">
										<input type="file" name="pic"><span class="red">不选择则为默认图标</span>
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
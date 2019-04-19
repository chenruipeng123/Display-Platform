<?php 
$cdgl = "active open";
$nrgl = "active open";
include '../inc/include.php';
loginCheck();
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
$did = $_GET['did'];
$sql = "select * from menu where id={$_GET['did']}";
$info = $mysqlObj->fetchOne($sql);
if ($did != "") {
	$sql1 = "select * from menu_cont where menu_id={$_GET['did']} and id={$_GET['mid']}";
}else{
	$sql1 = "select * from menu_cont where menu_id={$_GET['id']} and id={$_GET['mid']}";
}

$rows = $mysqlObj->fetchOne($sql1);
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
				<li class="active"><?php echo $info['name'] ?>展示编辑</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">			
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="">
								<?php
									if ($did != "") {
										echo "<a href='pic2.php?id={$_GET['id']}&did={$did}'>";
									} else {
										echo "<a href='pic2.php?id={$_GET['id']}'>";
									}
								?>
									<?php echo $info['name'] ?>展示列表
								</a>
							</li>
							<li class="">
								<?php
									if ($did != "") {
										echo "<a href='pic2_add.php?id={$_GET['id']}&did={$did}'>";
									} else {
										echo "<a href='pic2_add.php?id={$_GET['id']}'>";
									}
								?>
									<?php echo $info['name'] ?>展示添加
								</a>
							</li>
							<li class="active">
								<a href="pic2_edit.php?id=<?php echo $_GET['id'] ?>"><?php echo $info['name'] ?>展示编辑</a>
							</li>
						</ul>
						<?php 
					if (isset($_GET['a']) && $_GET['a'] == 'edit') {
						// $upd_menu = $_POST;
						$oldfilename = $_FILES['pic']['name'];
						if (!empty($oldfilename)) {
							$upd_menu = $_POST;
							$up = new FileUpload();
							$upload_url = "../upFile/pic/";
							$up->set("path", $upload_url);
							if ($up->upload("pic")) {
								$pic = $up->getFileName();
								// imageUpdateSize($upload_url.$pic, 200, 100, $pre = "s_");
							}
							$upd_menu['pic'] = $pic;
						}
						// $upd_menu['pic'] = $upload_url.$pic;
						$updated_at = date("Y-m-d H:i:s", time());
						$upd_menu['show_order'] = $_POST['show_order'];
						$upd_menu['title'] = $_POST['title'];
						$upd_menu['state'] = $_POST['state'];
						$upd_menu['updated_at'] = $updated_at;
						$cond['id'] = $_GET['mid'];
						// var_dump($upd_menu);
						// exit;
						$mes = $mysqlObj->update("menu_cont", $upd_menu, $cond);
						
						if ($mes) {
							alertMes("修改成功", "pic2.php?id={$_GET['id']}&did={$_GET['did']}");
						} else {
							alertMes("修改失败", "pic2_edit.php?id={$_GET['id']}&did={$_GET['did']}&mid={$_GET['mid']}");
							exit;
						}
					}
					?>
						<div class="tab-content">
							<form action="pic2_edit.php?id=<?php echo $_GET['id'] ?>&did=<?php echo $_GET['did'] ?>&mid=<?php echo $_GET['mid'] ?>&a=edit"
							 class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
								<!-- #section:elements.form -->
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1">显示序号</label>
									<div class="col-sm-10">
										<input type="number" name="show_order" class="col-xs-10 col-sm-1" value="<?php echo $rows['show_order'] ?>">
										
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1">标题</label>
									<div class="col-sm-10">
										<input type="text" name="title" value="<?php echo $rows['title'] ?>" class="col-xs-10 col-sm-5">
									</div>
								</div>	
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1" >文件</label>
									<div class="col-sm-10">
											<input type="file" name="pic" id="name">
											<?php 
										if ($rows['pic'] != "") {
											?>
												<img src="../upFile/pic/<?php echo $rows['pic'] ?>" alt="" width="100;">
											<?php 
										echo $rows['pic'];
									} else {
										echo "未选择文件";
									}
									?>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-field-1">显示状态</label>	
									<div class="col-sm-10">
										<div class="radio">
											<label>
												<input class="ace" <?php if ($rows['state'] == 1) echo 'checked'; ?> name="state" type="radio" value="1">							
												<span class="lbl"> 显示</span>
											</label>
										</div>
										<div class="radio">
											<label>
												<input class="ace" <?php if ($rows['state'] == 0) echo 'checked'; ?> name="state" type="radio" value="0">
												<span class="lbl">隐藏</span>
											</label>
										</div>
									</div>
								</div>	
								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-input-readonly">修改人</label>
									<div class="col-sm-10">	
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle"><?php echo $_SESSION['adminName'] ?></span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-2 control-label no-padding-right" for="form-input-readonly">修改时间</label>
									<div class="col-sm-10">					
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
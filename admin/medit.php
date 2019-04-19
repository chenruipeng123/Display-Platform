<?php 
	include '../inc/include.php';
	loginCheck();
	include '../inc/header.inc.php';
	include '../inc/nav.inc.php';
	if ($_POST['submit']=='提交') {
		$oldfilename = $_FILES['pic']['name'];
		if (!empty($oldfilename)) {
			$upd_menu = $_POST;
			$up = new FileUpload();
			$upload_url = "../upFile/pic/";
			$up->set("path", $upload_url);
			if ($up->upload("pic")) {
				$pic = $up->getFileName();
				imageUpdateSize($upload_url.$pic, 200, 100, $pre = "s_");
			}
			$upd_menu['pic'] = $pic;
		}
		$updated_at = date("Y-m-d H:i:s",time());
		$upd_menu['show_order'] = $_POST['show_order'];
		$upd_menu['name'] = $_POST['name'];
		$upd_menu['state'] = $_POST['state'];
		$upd_menu['level'] = $_POST['level'];
		$upd_menu['page'] = $_POST['page'];
		$cond['id'] = $_GET['mid'];
		$mes = $mysqlObj->update("menu",$upd_menu,$cond);
		if ($mes) {
			alertMes("修改成功","menulist.php");
		}else{
			alertMes("修改失败","medit.php?a=edit&mid={$cond['id']}");
			exit;
		}
	}
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
					<a href="#">菜单管理</a>
				</li>
				<li class="active">菜单编辑</li>
			</ul>
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="">
								<a href="menulist.php">
								 	菜单列表
								</a>
							</li>
							<li class="">
								<a href="menu_add.php">
									菜单添加
								</a>
							</li>
							<li class="active">
								<a href="medit.php">
									菜单编辑
								</a>
							</li>
						</ul>
						<?php 
							$sql = "select * from menu where id={$_GET[mid]}";
							$row = $mysqlObj->fetchOne($sql);
						 ?>
						<div class="tab-content">
							<div class="row">
								<div class="col-xs-12">
									<form action="" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
										<!-- #section:elements.form -->
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示序号</label>
											<div class="col-sm-9">
												<input type="text" name="show_order" class="col-xs-10 col-sm-1" value="<?php echo $row['show_order'] ?>">

											</div>
										</div>	

										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单名称</label>
											<div class="col-sm-9">
												<input type="text" name="name" value="<?php echo $row['name'] ?>" class="col-xs-10 col-sm-5">

											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单图标</label>
											<div class="col-sm-9">
												<input type="file" name="pic" id="name">
												<?php 
													if ($row['pic'] != "") {
												?>
													<img src="../upFile/pic/<?php echo $row['pic'] ?>" alt="" width="100;">
											<?php 
													echo $row['pic'];
													} else {
														echo "<img src='../images/def.jpg' width='100'>";
													}
													?>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">显示状态</label>	
											<div class="col-sm-9">
												<div class="radio">
													<label>
														<input class="ace" <?php if($row['state']==1) echo "checked";?>  name="state" type="radio" value="1">							
														<span class="lbl"> 显示</span>
													</label>
												</div>
												<div class="radio">
													<label>
														<input class="ace" <?php if($row['state']==0) echo "checked";?> name="state" type="radio" value="0">
														<span class="lbl"> 隐藏</span>
													</label>
												</div>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">有无下级</label>
											<div class="col-sm-9">
												<select id="sel" onchange="javascript:doit2();" name="level">
													<option value="0" <?php if($row['level']==0) echo "selected";?>>有</option>
													<option value="1" <?php if($row['level']==1) echo "selected";?>>无</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-field-1">隶属分页</label>
											<div class="col-sm-9">
												<select id="sel" onchange="javascript:doit2();" name="page">
													<?php 
														$sql = "select * from pages where state=1 order by show_order asc";
														$info = $mysqlObj->fetchAll($sql);
														foreach ($info as $data) {
													?>
													<option><?php echo $data['page'] ?></option>
												<?php
													}
												?>
												</select>
											</div>
										</div>	
										<div class="form-group">
											<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">添加人</label>
											<div class="col-sm-9">					
												<span class="help-inline col-xs-12 col-sm-7">
													<span class="middle"><?php echo $_SESSION['adminName']?></span>
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

										<div class="col-md-offset-3 col-md-9">
											<button class="btn btn-info" type="submit" value="提交" name="submit">
												<i class="ace-icon fa fa-check bigger-110"></i>
												提交
											</button>
											&nbsp; &nbsp; &nbsp;
											<button class="btn" type="reset">
												<i class="ace-icon fa fa-undo bigger-110"></i>
												重置
											</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
 <?php include '../inc/footer.inc.php'; ?>
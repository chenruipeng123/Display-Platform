<?php 
	$cdgl="active open";
	$cdlb="active";
	include '../inc/include.php';
	loginCheck();
	include '../inc/header.inc.php';
	include '../inc/nav.inc.php';
	$sql = "select * from menu where up_id=0";
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
					<a href="#">菜单管理</a>
				</li>
				<li class="active">菜单添加</li>
			</ul><!-- /.breadcrumb -->
		</div>
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="">
								<a href="menulist.php">
									菜单列表
								</a>
							</li>
							<li class="active">
								<a href="menu_add.php" >
									菜单添加
								</a>
							</li>
						</ul>
						<?php 
						if (isset($_GET)&&$_GET['a']=='add'&&!empty($_POST['name'])) {
							$up = new FileUpload();
							$upload_url = "../upFile/pic/";
							$up->set("path", $upload_url);
							if ($up->upload("pic")) {
								$pic = $up->getFileName();
								imageUpdateSize($upload_url.$pic, 200, 100, $pre = "s_");
							}
							$ins['pic'] = $pic;
							$add_time = date("Y-m-d H:i:s",time());
							$ins['state'] = $_POST['state'];
							$ins['show_order'] = $_POST['show_order'];
							$ins['name'] = $_POST['name'];
							$ins['type'] = $_POST['type'];
							$ins['level'] = $_POST['level'];
							$ins['page'] = $_POST['page'];
							$ins['add_user'] = $_SESSION['adminName'];
							$ins['created_at'] = $add_time;
							$mes = $mysqlObj->insert("menu",$ins);
							// echo "<pre>";
							// var_dump($ins);
							// exit;
							if ($mes) {
								alertMes("添加成功！","menulist.php");
							}else{
								alertMes("添加失败！","menu_add.php");
								exit;
							}
						}
						 ?>
						<div class="tab-content">
							<form action="menu_add.php?a=add" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
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
										<input type="file" name="pic">
										<span class="red">不选择则为默认图标</span>
									</div>
								</div>	
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">有无下级</label>
									<div class="col-sm-9">
										<select id="sel" onchange="javascript:doit2();" name="level">
											<option value="0">有</option>
											<option value="1">无</option>
										</select>
									</div>
								</div>	
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
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">菜单类型</label>
									<div class="col-sm-9">
										<select id="sel" onchange="javascript:doit2();" name="type">
											<option value="3">图片列表</option>
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
											<option><?php echo $data['page']?></option>
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
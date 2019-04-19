<?php 
	$cdgl = "active open";
	$nrgl = "active open";
	include '../inc/include.php';
	loginCheck();
	include '../inc/header.inc.php';
	include '../inc/nav.inc.php';
	$sql = "select * from menu where id={$_GET['id']}";
	$rows = $mysqlObj->fetchOne($sql);
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
				<li class="active"><?php echo $rows['name'] ?>列表</li>
			</ul>
		</div>

		<div class="page-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a href="#">
								 	<?php echo $rows['name'] ?>列表
								</a>
							</li>
							<li class="#">
								<a href="pic_add.php?id=<?php echo $_GET['id'] ?>">
									<?php echo $rows['name'] ?>添加
								</a>
							</li>
						</ul>

						<div class="tab-content">
							<div id="home" class="tab-pane fade active in">
								<table id="simple-table" class="table  table-bordered table-hover">
									<thead>
										<tr>
											<th>显示序号</th>
											<th>菜单名称</th>
											<th>菜单图标</th>
											<th>显示状态</th>
											<th>创建时间</th>
											<th>添加人</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
									<?php 
										$sql = "select count(*) as num from menu where up_id={$_GET['id']}";
										// echo $sql;
										// exit;
										$row = $mysqlObj->fetchOne($sql);
										// var_dump($row);
										// exit;
										$num = $row['num'];
										$listRows = 6;
										$page = new Page($num,$listRows,$args);
										$page->set('head','条数据');
										$index = $num;
										$sql = "select * from menu where up_id={$_GET['id']} order by show_order desc {$page->limit}";
										$data = $mysqlObj->fetchAll($sql);
										$i = 0;
										foreach ($data as $info) {
											// var_dump($info);
											// exit;
											$i++;
											if ($info['pic'] != "") {
												$tupian = "../upFile/pic/{$info['pic']}";
											}else{
												$tupian = "../images/def.jpg";
											}
									 ?>
										<tr>
											<td><?php echo $info['show_order']; ?></td>
											<td><?php echo $info["name"] ?></td>
											<td><img src="<?php echo $tupian ?>" alt="" width="80"></td>
											<td><?php 
												if ($info['state']==1) {
													echo "<span class='label label-success'>显示</span>";
												}else{
													echo "<span class='label label-danger'>隐藏</span>";
												} 
												?>
											</td>
											<td><?php echo $info["created_at"] ?></td>
											<td><?php echo $info["add_user"] ?></td>
											<td>
												<a href="pic_edit.php?id=<?php echo $_GET['id'] ?>&mid=<?php echo $info['id']?>">编辑</a>
												<a href="pic.php?id=<?php echo $_GET['id'] ?>&cid=<?php echo $info['id']?>&a=del" onclick="del()">删除</a>
												<a href="pic2.php?id=<?php echo $_GET['id'] ?>&did=<?php echo $info['id']?>">管理</a>
											</td>
										</tr>
									<?php }; ?>
									</tbody> 
								</table>
								<div class="row">
									<div class="col-xs-12">
										<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
											<ul class="pagination"> 
												<?php 
											echo $page->fpage(0, 4, 5, 6);
											?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- 删除 -->
						<script>
							function del() {
								var msg = "您真的确定要删除吗？\n\n请确认！";
								if (confirm(msg)==true){
								return true;
								}else{
								return false;
								}
								}
						</script>
						<?php 
							if (isset($_GET['a'])&&$_GET['a']=='del') {
								$cond['id']=$_GET['cid'];
								$mes=$mysqlObj->delete("menu",$cond);
								if ($mes) {
									skip("pic.php?id={$_GET['id']}");
								}else{
									alertMes("删除失败","pic.php?id={$_GET['id']}");
									exit;
								}
							}
						 ?>
						 <!-- 置顶与取消置顶 -->
						 <?php 
						 	if (isset($_GET['a'])&&$_GET['a']=='top') {
						 		$cond['id']=$_GET['zid'];
						 		$sql = "select * from menu_news where id='{$cond['id']}'";
						 		$aa = $mysqlObj->fetchOne($sql);
						 		// echo $aa['top'];
						 		// exit;
						 		// $upd = $_POST;
						 		if ($aa['top']==0) {
						 			$upd['top']=1;
						 			$upd['top_time']=date('Y-m-d,H:i:s');
						 		}else{
						 			$upd['top']=0;
						 			$upd['top_time']="";
						 		} 				
						 		$upd['updated_at']=date('Y-m-d,H:i:s');
						 		$mes = $mysqlObj->update("menu_news",$upd,$cond);
						 		if ($mes) {
						 			skip("list.php?id={$_GET['id']}");
						 		}else{
						 			alertMes("置顶失败！","list.php?id={$_GET['id']}");
						 			exit;
						 			}
						 		}
						  ?>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php include '../inc/footer.inc.php'; ?>
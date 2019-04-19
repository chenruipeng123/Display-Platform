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
				<li class="active"><?php echo $rows['name']?>展示列表</li>
			</ul>
		</div>

		<div class="page-content">
			<div class="row">
				<div class="col-sm-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab"> 
						
							<li class="active">
								<a href="#">
								 	<?php echo $rows['name'] ?>展示列表
								</a>
							</li>
							<li class="#">
							<?php
								if ($did != "") {
									echo "<a href='pic2_add.php?id={$_GET['id']}&did={$did}'>";
								}else{
									echo "<a href='pic2_add.php?id={$_GET['id']}'>";
								}
							?>
									<?php echo $rows['name'] ?>展示添加
								</a>
							</li>
						</ul>

						<div class="tab-content">
							<div id="home" class="tab-pane fade active in">
								<table id="simple-table" class="table  table-bordered table-hover">
									<thead>
										<tr>
											<th>显示序号</th>
											<th>标题</th>
											<th>文件</th>
											<th>显示状态</th>
											<th>创建时间</th>
											<th>添加人</th>
											<th>操作</th>
										</tr>
									</thead>
									<tbody>
									<?php 
									if ($did != "") {
										$sql = "select * from menu_cont where menu_id={$_GET['did']} order by show_order desc";
									}else{
										$sql = "select * from menu_cont where menu_id={$_GET['id']} order by show_order desc";
									}
										// $sql = "select * from menu_cont where menu_id={$_GET['did']} order by created_at desc";
										$data = $mysqlObj->fetchAll($sql);
										$i = 0;
										foreach ($data as $info) {
											// var_dump($info);
											// exit;
											$i++;
									?>
										<tr>
											<td><?php echo $info['show_order']; ?></td>
											<td><?php echo $info["title"] ?></td>
											<td>
												<?php
													$file = $info['pic'];
													$nfile = substr(strrchr($file, '.'), 1);
													if ($nfile=="mp4") {
														echo "<video src='../upFile/pic/{$info["pic"]}' width='80'></video>";

													}else{
														echo "<img src='../upFile/pic/{$info["pic"]}' width='80'>";
													}
												?>
											</td>
											<td><?php 
														if ($info['state'] == 1) {
															echo "<span class='label label-success'>显示</span>";
														} else {
															echo "<span class='label label-danger'>隐藏</span>";
														}
														?>
											</td>
											<td><?php echo $info["created_at"] ?></td>
											<td><?php echo $info["add_user"] ?></td>
											<td>
												<a href="pic2_edit.php?id=<?php echo $_GET['id'] ?>&mid=<?php echo $info['id']?>&did=<?php echo $_GET['did'] ?>">编辑</a>
												<a href="pic2.php?id=<?php echo $_GET['id'] ?>&did=<?php echo $_GET['did']?>&cid=<?php echo $info['id']?>&a=del" onclick="del()">删除</a>
											</td>
										</tr>
									<?php 
							}; ?>
									</tbody> 
								</table>
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
					if (isset($_GET['a']) && $_GET['a'] == 'del') {
						$cond['id'] = $_GET['cid'];
						$mes = $mysqlObj->delete("menu_cont", $cond);
						if ($mes) {
							skip("pic2.php?id={$_GET['id']}&did={$did}");
						} else {
							alertMes("删除失败", "pic2.php?id={$_GET['id']}&did={$did}");
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
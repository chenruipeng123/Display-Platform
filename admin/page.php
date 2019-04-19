<?php 
$ymgl = "active open";
$ymlb = "active";
include '../inc/include.php';
loginCheck();
include '../inc/header.inc.php';
include '../inc/nav.inc.php';
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
					<a href="#">页面管理</a>
				</li>
				<li class="active">页面列表</li>
			</ul><!-- /.breadcrumb -->
		</div>
		
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a href="page.php">
									页面列表
								</a>
							</li>
							<li class="">
								<a href="page_add.php" >
									页面添加
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<table id="simple-table" class="table  table-bordered table-hover">
								<thead>
									<tr>
										<th>显示序号</th>
										<th>页码</th>
										<th>页面背景</th>
										<th>显示状态</th>
										<th>创建时间</th>
										<th>添加人</th>
										<th>操作</th>
									</tr>
								</thead>
				
								<tbody>
								<?php
									$sql = "select * from pages where state=1 order by show_order asc";
									$info = $mysqlObj->fetchAll($sql);
									foreach ($info as $data) {
								?>
								<tr>
									<td><?php echo $data['show_order']?></td>
									<td><?php echo $data['page'] ?></td>
									<td><img src="../upFile/pic/<?php echo $data['pic'] ?>" alt="" width="100"></td>
									<td><?php 
										if ($data['state'] == 1) {
											echo "<span class='label label-success'>显示</span>";
										} else {
											echo "<span class='label label-danger'>隐藏</span>";
										}
										?></td>
									<td><?php echo $data['created_at'] ?></td>
									<td><?php echo $data['add_user'] ?></td>
									<td>
									<a  href="page_edit.php?mid=<?php echo $data['id'] ?>">编辑</a>
									 <a class="red"  href="page.php?a=del&cid=<?php echo $data['id'] ?>" onclick="return del()">删除</a>
									 </td>
									 </tr>
								<?php };?>
								</tbody>
							</table>
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
									// $sql = "select * from menu where id={$_GET['cid']}";
									// $cont_row = $mysqlObj->fetchOne($sql);
							$mes = $mysqlObj->delete("pages", $cond);
							if ($mes) {
								skip("page.php");
							} else {
								alertMes("删除失败", "page.php");
								exit;
							}
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.main-content -->
 <?php include '../inc/footer.inc.php'; ?>
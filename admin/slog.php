<?php 
	$rzgl="active open";
	$rzck="active";
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
					<a href="index.php">主页</a>
				</li>

				<li>
					<a href="#">日志管理</a>
				</li>
				<li class="active">日志查看</li>
			</ul><!-- /.breadcrumb -->
		</div>
		
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a data-toggle="tab" href="#" aria-expanded="true">
									日志管理
								</a>
							</li>
						</ul>
						
						<div class="tab-content">
							<table id="simple-table" class="table  table-bordered table-hover">
								<thead>
									<tr>
										<th>序号</th>
										<th>用户</th>
										<th>动作</th>

										<th>
											日志级别
										</th>
										<th>ip地址</th>
										<th>创建时间</th>
									</tr>
								</thead>

								<tbody>
									<?php
									$sql = "select count(*) as num from super_log";
									$row = $mysqlObj->fetchOne($sql);
									$num = $row['num'];
									$listRows = 10;
									$page = new Page($num,$listRows,$args);
									$page->set('head','条数据');
									$index = $num;
									$sql = "select * from super_log order by id desc {$page->limit}";
									$info = $mysqlObj->fetchAll($sql);
									$i=0;
									 foreach ($info as $data) {
									 	$i++;
								 	?>
									<tr>
										<td><?php echo $i ?></td>
										<td><?php echo $data['user'] ?></td>
										<td><?php echo $data['action'] ?></td>
										<td>
											<?php 
											switch ($data['db_level']) {
												case '1':
												echo "数据插入";
												break;
												case '2':
												echo "数据删除";
												break;
												case '3':
												echo "数据更新";
												break;
												case '4':
												echo "数据检索";
												break;
												default:
												echo "未知操作";
												break;
											} 
											?>
										</td>
										<td><?php echo $data['ip'] ?></td>
										<td><?php echo $data['created_at'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<div class="row">
								<div class="col-xs-12">
									<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
										<ul class="pagination"> 
											<?php 
											echo $page->fpage(4,5,6,0);
											?>
										</ul>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.main-content -->
 <?php include '../inc/footer.inc.php'; ?>
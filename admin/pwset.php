<?php 
	$aqsz="active open";
	$mmxg="active";
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
					<a href="#">主页</a>
				</li>

				<li>
					<a href="#">安全设置</a>
				</li>
				<li class="active">密码修改</li>
			</ul><!-- /.breadcrumb -->
		</div>
		
		<div class="page-content">
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li class="active">
								<a data-toggle="tab" href="#" aria-expanded="true">
									密码修改
								</a>
							</li>
						</ul>
						<div class="tab-content">
							<form action="doAction.php?a=change" class="form-horizontal" role="form" method="post">
								<!-- #section:elements.form -->
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">原密码</label>
									<div class="col-sm-9">
										<input type="text" name="oldpw" class="col-xs-10 col-sm-5" placeholder="原密码">
									</div>
								</div>	

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">新密码</label>
									<div class="col-sm-9">
										<input type="password" name="newpw" placeholder="新密码" class="col-xs-10 col-sm-5">

									</div>
								</div>	
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1">再次新密码</label>
									<div class="col-sm-9">
										<input type="password" name="renewpw" placeholder="再次新密码" class="col-xs-10 col-sm-5">

									</div>
								</div>	
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">修改人</label>
									<div class="col-sm-9">					
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle"><?php echo $_SESSION['adminName'] ?></span>
										</span>
									</div>
								</div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-input-readonly">修改时间</label>
									<div class="col-sm-9">					
										<span class="help-inline col-xs-12 col-sm-7">
											<span class="middle">系统自动记录</span>
										</span>
									</div>
								</div>
								<div class="form-group">
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
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><!-- /.main-content -->
 <?php include '../inc/footer.inc.php'; ?>
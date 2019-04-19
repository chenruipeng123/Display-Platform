			<?php 
				$hyfw = "active";
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
								<a href="#">首页</a>
							</li>
							<li>欢迎访问</li>
						</ul><!-- /.breadcrumb -->
					</div>
					<div class="page-content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="tabbable">
                                
                                <div class="tab-content">
								                                    
								    <div class="page-header">
								    	<h1>
								    		ET工作室后台管理系统<small>
								    			<i class="ace-icon fa fa-angle-double-right"></i>
								    			欢迎界面
								    		</small>
								    	</h1>
								    </div>

									<div class="alert alert-block alert-success">
										<button type="button" class="close" data-dismiss="alert">
											<i class="ace-icon fa fa-times"></i>
										</button>

										<i class="ace-icon fa fa-check green"></i>

										欢迎来到ET工作室后台管理系统<strong class="green">
											<small>(V1.0)</small>
										</strong>,
								        祝您使用愉快！
									</div>

									<div class="row">
										<div class="space-8"></div>

										<div class="col-sm-12 infobox-container">

										</div>
									</div>
								</div>
								<div id="bar" style="width: 960px;height: auto;margin-top: -30px;"></div>
								</div>
                                </div>
                            </div>
                        </div>
				</div>
			</div><!-- /.main-content -->
		<?php 
			include '../inc/footer.inc.php';
		 ?>
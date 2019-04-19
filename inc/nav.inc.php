<div class="main-container ace-save-state" id="main-container">

			<div id="sidebar" class="sidebar                  responsive                    ace-save-state">
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<a href="#" style="color:#fff">后</a>
						</button>

						<button class="btn btn-info">
							<a href="#" style="color:#fff">台</a>
						</button>

						<button class="btn btn-warning">
							<a href="#" style="color:#fff">管</a>
						</button>

						<button class="btn btn-danger">
							<a href="#" style="color:#fff">理</a>
						</button>

					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->

				<ul class="nav nav-list">
				<li class="<?php echo $hyfw;?>">
					<a href="../admin/index.php">
						<i class="menu-icon fa fa-tachometer"></i>
						<span class="menu-text"> 欢迎访问 </span>
					</a>
				</li>
				<li class="<?php echo $ymgl; ?>">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">
								页面管理
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $ymlb; ?>">
								<a href="../admin/page.php">
									<i class="menu-icon fa fa-caret-right"></i>
									页面管理
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="<?php echo $cdgl; ?>">
						<a href="menulist.php" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">
								菜单管理
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $cdlb;?>">
								<a href="menulist.php">
									<i class="menu-icon fa fa-caret-right"></i>
									菜单列表
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php echo $nrgl; ?>">
								<a href="" class="dropdown-toggle">
									<span class="menu-text">
										内容管理
									</span>
									<b class="arrow fa fa-angle-down"></b>
								</a>
								<b class="arrow"></b>
								<ul class="submenu">
									<?php 
										// $menu_type1_1 = "list_add.php?id=";
										// $menu_type1_2 = "list.php?id=";
										$menu_type2_1 = "pic_add.php?id=";
										$menu_type2_2 = "pic.php?id=";
										$menu_type1_1 = "pic2_add.php?id=";
										$menu_type1_2 = "pic2.php?id=";
										$sql = "select * from menu  order by show_order asc";
										$rows = $mysqlObj->fetchAll($sql);
										foreach ($rows as $data) {
                                            if ($data['up_id']==0) {
                                                ?>
										<li class="<?php if ($data['id'] == $_GET['id']) {
                                                    echo "active";
                                                }; ?>">	
										<?php
                                        if ($data['level']==1) {
                                            echo "<a href=".$menu_type1_2.$data['id'].">";
                                        } elseif ($data['level']==0) {
                                            echo "<a href=".$menu_type2_2.$data['id'].">";
                                        }
                                                echo $data["name"]; ?>
										</a>
										<b class="arrow"></b>
									</li>
								<?php
                                     }
									};
									?>
								</ul>
							</li>
						</ul>
					</li>
					<li class="<?php echo $rzgl; ?>">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">
								日志管理
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $rzck; ?>">
								<a href="../admin/slog.php">
									<i class="menu-icon fa fa-caret-right"></i>
									日志查看
								</a>

								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="<?php echo $aqsz; ?>">
						<a href="menulist.php" class="dropdown-toggle">
							<i class="menu-icon fa fa-pencil-square-o"></i>
							<span class="menu-text">
								安全设置
							</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php echo $mmxg; ?>">
								<a href="../admin/pwset.php">
									<i class="menu-icon fa fa-caret-right"></i>
									密码修改
								</a>
							</li>
							<li>
								<a href="../admin/doAction.php?a=logout">
									<i class="menu-icon fa fa-caret-right"></i>
									安全退出
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>
			
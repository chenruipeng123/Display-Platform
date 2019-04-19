
<html lang="en"><head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta charset="utf-8">
		<title>ET工作室展示平台后台管理登录</title>

		<meta name="description" content="User login page">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
		<link rel="icon" type="image/x-icon" href="http://debug.etpt.com.cn/Public/Super/img/et.png" /> 
		<!-- bootstrap & fontawesome -->
		<link rel="stylesheet" href="assets/css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/font-awesome/4.5.0/css/font-awesome.min.css">

		<!-- text fonts -->
		<link rel="stylesheet" href="assets/css/fonts.googleapis.com.css">

		<!-- ace styles -->
		<link rel="stylesheet" href="assets/css/ace.min.css">

		<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
		<link rel="stylesheet" href="assets/css/ace-rtl.min.css">

		<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

		<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

		<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->
	</head>

	<body class="login-layout light-login">
		<div class="main-container">
			<div class="main-content">
				<div class="row">
					<div class="col-sm-10 col-sm-offset-1">
						<div class="login-container">
							<div class="center">
								<h1>
									<span class="red">ET工作室</span>
									<span class="grey" id="id-text2">后台管理系统</span>
								</h1>
								<h4 class="blue" id="id-company-text">©ET工作室</h4>
							</div>

							<div class="space-6"></div>

							<div class="position-relative">
								<div id="login-box" class="login-box visible widget-box no-border">
									<div class="widget-body">
										<div class="widget-main">
											<h4 class="header blue lighter bigger">
												<i class="ace-icon fa fa-coffee green"></i>
												请输入您的账户信息
											</h4>
											<div class="space-6"></div>

											<form action="doAction.php?a=log" method="post">
												<input type="hidden" name="_token" value="">
												<fieldset>
													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="text" autofocus="" name="username" class="form-control" placeholder="帐号" />
															<i class="ace-icon fa fa-user"></i>
														</span>
													</label>

													<label class="block clearfix">
														<span class="block input-icon input-icon-right">
															<input type="password" name="password" class="form-control" placeholder="密码" />
															<i class="ace-icon fa fa-lock"></i>
														</span>
													</label>

													<label class="block clearfix">
														<div class="row">
															<div class="col-xs-7">
																<span class="block input-icon input-icon-right">
																	<input name="captcha" type="text" class="form-control" placeholder="验证码">
																</span>
															</div>
															<div class="col-xs-5">
																<img class="captcha pull-right" src="../inc/captcha.func.php" onclick="this.src='../inc/captcha.func.php?id='+Math.random()" style="height: 30px;" />
															</div>
														</div>
													</label>

													<div class="space"></div>

													<div class="clearfix">
														<button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
															<i class="ace-icon fa fa-key"></i>
															<span class="bigger-110">登录</span>
														</button>
													</div>

													<div class="space-4"></div>
												</fieldset>
											</form>
</body>
</html>
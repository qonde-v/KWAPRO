<!-- <link href="<?php echo $base."css/index.css";?>" rel="stylesheet" type="text/css" id="cssfile" /> -->
<link id="bs-cssq" href="<?php echo $base."css/bootstrap-cerulean.css";?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base."css/bootstrap-responsive.css";?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base."css/charisma-app.css";?>" rel="stylesheet"> 

<!-- jQuery -->
<script src="<?php echo $base."js/jquery-1.7.2.min.js";?>"></script>
<!-- jQuery history -->
<script src="<?php echo $base."js/jquery.history.js";?>"></script>
<!-- library for cookie management -->
<script src="<?php echo $base."js/jquery.cookie.js";?>"></script>
<!-- data table plugin -->
<script src="<?php echo $base."js/jquery.dataTables.min.js";?>"></script>
<!-- application script for Charisma demo -->
<script src="<?php echo $base."js/charisma.js";?>"></script>
<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="" href="#"> <!-- <img alt="Charisma Logo" src="<?php echo $base."images/logo.png";?>" /> 
				<img src="<?php echo $base."images/logo_gzpt.png";?>" align="absmiddle" border="0">--> </a>
				
				

				<!-- user dropdown starts  -->
				<div class="btn-group pull-right"  style="padding-top:25px; padding-right:25px;">
				<?php if(!isset($login)):?> 
					<a href="javascript:regedit()">立即注册</a>
				<?php endif; ?> 
            	<?php if(isset($login)):?> 
            		<span style="color:red; margin-right:100px;"><?php echo ("" == ($this->session->userdata('nickname'))?"":("欢迎您：".$this->session->userdata('nickname')))?></span>
					<a href="<?php echo $base;?>"><span style="color:black;">前台首页</span></a>
					<a href="<?php echo $base."admin/login/logout";?>"><span style="color:black;">退出</span></a>
				<?php endif; ?> 
				</div>
			<!-- user dropdown ends -->
			</div>
		</div>
	</div>

<input type="hidden" value="<?php echo $base;?>" id="header_base" />
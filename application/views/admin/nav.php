<script type="text/javascript">
<!--
function dono(){
	alert("系统正在开发中");
}
//-->
</script>
		<div class="span2 main-menu-span">
				<div class="well nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li class="nav-header hidden-tablet">我的导航</li>
						<li><a class="ajax-link" href="<?php echo $base."admin/user/fixPwd?createid=".$user_id?>"><i class="icon-edit"></i><span class="hidden-tablet"> 修改密码</span></a></li>
						<!-- <li><a class="ajax-link" href="<?php echo $base."user/edit?createid=".$user_id?>"><i class="icon-list-alt"></i><span class="hidden-tablet"> 修改个人信息</span></a></li> -->
						<li class="nav-header hidden-tablet">系统管理</li>
						<li><a class="ajax-link" href="<?php echo $base."admin/news?createid="?>"><i class="icon-align-justify"></i><span class="hidden-tablet">新闻列表</span></a></li>
						<li><a class="ajax-link" href="<?php echo $base."admin/news/edit/-1"?>"><i class="icon-star"></i><span class="hidden-tablet">发布新闻</span></a></li>
 					</ul>
				</div>
			</div>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无权限访问</title>
<!-- <link href="<?php echo $base."css/style_1.css";?>" rel="stylesheet" type="text/css" id="cssfile"/> -->
<link href="<?php echo $base."css/tag.css";?>" rel="stylesheet"
	type="text/css" />
<link href="<?php echo $base."css/jquery/jquery.ui.all.css";?>" rel="stylesheet"
	type="text/css" />

<link href="<?php echo $base."css/jquery/autocomplete.css";?>" rel="stylesheet"
	type="text/css" />
 <link href="<?php echo $base."css/bootstrap.css";?>" rel="stylesheet"
	type="text/css" />

<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/utils_date.js";?>"></script>
<script language="javascript" type="text/javascript" 
	src="<?php echo $base."js/public.js";?>" charset="gb2312"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery-1.7.1.min.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.core.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.widget.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.position.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.autocomplete.js";?>"></script>
<script language="javascript" type="text/javascript"
	src="<?php echo $base."js/jquery/jquery.ui.button.js";?>"></script>
<script src="<?php echo $base."js/bootstrap.js";?>"></script>

</head>
<body>

<?include("page_head.php");?>
<input type="hidden" id="uri" value="<?php echo $base."user/"?>"/>
	<div class="container-fluid">
	<div class="row-fluid">
		<?include(dirname(__FILE__).'/nav.php');?>
		<div id="content" style="padding-left:10px;font-size:24px;width:100%;text-align:center;font-weight:bold;color:#ff0000;">
	无权限访问！
		</div><!--/row-->
		</div>
	</div>
</body>
</html>


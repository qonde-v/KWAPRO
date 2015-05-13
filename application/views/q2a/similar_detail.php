<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TIT系统</title>
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script src="<?php echo $base.'js/jquery.min.js';?>" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$(".tab-btns a").click(function(){
		$(".tab-btns a.black").removeClass("black");
		$(this).addClass("black");
		if($(this).attr("id") == "path1"){
			$("#Comfort").removeClass('hide');
			$("#surfacePlotDiv").addClass('hide');
			$("#surfacePlotDiv1").addClass('hide');
		}
		if($(this).attr("id") == "path2"){
			$("#Comfort").addClass('hide');
			$("#surfacePlotDiv").removeClass('hide');
			$("#surfacePlotDiv1").addClass('hide');
		}
		if($(this).attr("id") == "path3"){
			$("#Comfort").addClass('hide');
			$("#surfacePlotDiv").addClass('hide');
			$("#surfacePlotDiv1").removeClass('hide');
		}
	});
});
</script>

</head>
<div class="container" >
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->

<!------------ 内容开始 -------------> 
<div id="sjlc" class="main flows"> 
<div class="btns tab-btns">
	<a id="path1" href="javascript:;" class="black">舒适度</a>&nbsp;&nbsp;&nbsp;&nbsp;
	<a id="path2" href="javascript:;">皮肤湿度</a>
	<a id="path3" href="javascript:;">温度</a>
</div>
<div id="Comfort" style="text-align:center;">
<img style="width:500px;height:600px;" src="<?echo $base.$shushi?>"/>
</div>
<div id='surfacePlotDiv' class="hide" style="text-align:center;">	
<img style="width:500px;height:500px;" src="<?echo $base.$pifu?>"/>
</div>
<div id='surfacePlotDiv1' class="hide" style="text-align:center;">	
<img style="width:500px;height:700px;" src="<?echo $base.$shidu?>"/>
</div>
</div>

<!----------------------------------->
<!------------ 底部开始 ------------->
<?php include("footer.php");?>
</div>
</body>
</html>

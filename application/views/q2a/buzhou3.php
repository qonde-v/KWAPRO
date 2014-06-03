<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">

<link rel="stylesheet" href="<?php echo $base.'css/jquery-ui.css';?>">
<script src="<?php echo $base.'js/jquery-1.10.2.js';?>"></script>
<script src="<?php echo $base.'js/jquery-ui.js';?>"></script>
<script>
$(function() {
$( "#slider" ).slider({
value:5,
min: 1,
max: 10,
step: 1,
slide: function( event, ui ) {
$( "#proficiency" ).val(ui.value );
}
});
$( "#proficiency" ).val($( "#slider" ).slider( "value" ) );
});
</script>

</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 


<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div><br>
<br>

<div class="xuqiu_bz1"><a href="<?php echo $base.'demand/buzhou';?>" class="White14">1.选择运动类型</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz1"><a href="<?php echo $base.'demand/buzhou2';?>" class="White14">2.选择运动场景</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz1"><a href="<?php echo $base.'demand/buzhou3';?>" class="White14">3.选择着装对象</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz2"><a href="<?php echo $base.'demand/buzhou4';?>" class="White14">4.提交需求</a></div>

<div class="index_l_xwnrx" style="padding-left:100px; margin-top:50px; margin-bottom:100px;">
<div style="float:left; width:550px;">
	<div class="index_l_xqnr">
	<b>对象： </b> 
	<input type="radio" id="target" name="target" value="男人" checked="checked" style="margin-left:10px" /> 男人
	<input type="radio" id="target" name="target" value="女人" style="margin-left:20px" /> 女人
	<input type="radio" id="target" name="target" value="小孩" style="margin-left:20px" /> 小孩
	</div>
	<div class="index_l_xqnr">
	<b>熟练度：</b> 
	<font size="2" color="f6931f">初学者</font>
	<div id="slider" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">运动达人</font>
	<input type="hidden" id="proficiency" name="proficiency" >
	</div>
	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:left"><a href="<?php echo $base.'demand/buzhou2';?>" class="White14">上一步</a></div>
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a href="<?php echo $base.'demand/buzhou4';?>" class="White14">下一步</a></div>
	</div>

</div>	
<div class="xuqiu_zhuyi"><font class="fBlack14">不同运动对服装功能有不同的要求</font><br>
例如：篮球运动就需要突出排汗功能与透气性，<br>
而自行车则需要注重保护性，贴身性和舒服性
</div>		
</div>
	

	
</div>




</div>


</div>
</div>



<div id="main">
<div id="main_bottom">
<div id="main_bottom_top">
&nbsp;
</div><br>
<br>

<div id="main_bottom_l">
<img src="images/lxwm_dot.png" align="absmiddle" border="0"/> 联系我们电话：86-20-84221810
</div>
<div id="main_bottom_r">
地址：广州市海珠区新港中路397号<br>

备案/许可证编号为：粤ICP备11086295号-1<br>

Copyright &copy; 2014 cntit.com.cn All Right Reserved
</div>
</div>


</div>
<!------------ 底部开始 ------------->

</body>
</html>

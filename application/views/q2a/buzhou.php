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
$( "#strength" ).val(ui.value );
}
});
$( "#strength" ).val($( "#slider" ).slider( "value" ) );


$( "#slider1" ).slider({
value:2,
min: 0,
max: 24,
step: 0.5,
slide: function( event, ui ) {
$( "#sporttime" ).val(ui.value );
}
});
$( "#sporttime" ).val($( "#slider1" ).slider( "value" ) );


});
</script>


<script>
function gonext(){
	var url = $('#base').val() + 'demand/buzhou2/';
    var strength = $('#strength').val();
	var sporttime = $('#sporttime').val();
	$.post(url);
    //$.post(url,data,function(msg){

        //....

    //});

}
</script>

</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 

<input type="hidden" id="base" value="<?php echo $base;?>"></input>

<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div><br>
<br>

<div class="xuqiu_bz1"><a href="<?php echo $base.'demand/buzhou';?>" class="White14">1.选择运动类型</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz2"><a href="<?php echo $base.'demand/buzhou2';?>" class="White14">2.选择运动场景</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz2"><a href="<?php echo $base.'demand/buzhou3';?>" class="White14">3.选择着装对象</a></div>
<div class="xuqiu_bz_jt"></div>
<div class="xuqiu_bz2"><a href="<?php echo $base.'demand/buzhou4';?>" class="White14">4.提交需求</a></div>

<div class="index_l_xwnrx" style="padding-left:100px; margin-top:50px; margin-bottom:100px;">
<div style="float:left; width:550px;">
	<div class="index_l_xqnr">
	<b>类型： </b> 
	<select id="type" name="type" > 
		<option selected value='跑步'>跑步</option>
		<option  value='骑车'>骑车</option>
		<option  value='篮球'>篮球</option>
		<option  value='足球'>足球</option>
	</select>
	</div>
	<div class="index_l_xqnr">
	<b>强度：</b> 
	<font size="2" color="f6931f">轻&nbsp;&nbsp;松</font>
	<div id="slider" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">激&nbsp;&nbsp;烈</font>
	<input type="hidden" id="strength" >
	</div>
	<div class="index_l_xqnr">
	<b>时间： </b>  
	<font size="2" color="f6931f">0Hour</font>
	<div id="slider1" style="width:300px;display:inline-block"></div>
	<font size="2" color="f6931f">24Hour</font>
	<input type="hidden" id="sporttime" >
	</div>
	<div class="index_l_xqnr" style="width:150px">
	<div class="red_bt15" style="width:45px;text-align:center;float:right"><a href="#" onclick="javascript:gonext()" class="White14">下一步</a></div>
	</div>
</div>	
<div class="xuqiu_zhuyi" ><font class="fBlack14">不同运动对服装功能有不同的要求</font><br>
例如：篮球运动就需要突出排汗功能与透气性，<br>
而自行车则需要注重保护性，贴身性和舒服性
</div>		
</div>
	
</div>

</div>


</div>


<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>

</body>
</html>


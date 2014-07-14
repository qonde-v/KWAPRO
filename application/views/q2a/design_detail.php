<!DOCTYPE html>

<html>
<head>
<title>TIT系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>

<link rel="stylesheet" href="<?php echo $base.'css/jquery-ui.css';?>">
<script src="<?php echo $base.'js/jquery-1.10.2.js';?>"></script>
<script src="<?php echo $base.'js/jquery-ui.js';?>"></script>
<script>
$(function() {
$( "#slider" ).slider({
value:<?php if(!empty($demand)) echo $demand['strength']; else echo 0;?>,
min: 1,
max: 1.5,
step: 0.1,
slide: function( event, ui ) {
$( "#strength" ).val(ui.value );
}
});
$( "#strength" ).val($( "#slider" ).slider( "value" ) );


$( "#slider1" ).slider({
value:<?php if(!empty($demand)) echo $demand['sporttime']; else echo 0;?>,
min: 0,
max: 2,
step: 0.1,
slide: function( event, ui ) {
$( "#sporttime" ).val(ui.value );
}
});
$( "#sporttime" ).val($( "#slider1" ).slider( "value" ) );

$( "#slider2" ).slider({
value:<?php if(!empty($demand)) echo $demand['temperature']; else echo 0;?>,
min: 0,
max: 50,
step: 1,
slide: function( event, ui ) {
$( "#temperature" ).val(ui.value );
}
});
$( "#temperature" ).val($( "#slider2" ).slider( "value" ) );


$( "#slider3" ).slider({
value:<?php if(!empty($demand)) echo $demand['humidity']; else echo 0;?>,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#humidity" ).val(ui.value );
}
});
$( "#humidity" ).val($( "#slider3" ).slider( "value" ) );

$( "#slider4" ).slider({
value:<?php if(!empty($demand)) echo $demand['proficiency']; else echo 0;?>,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#proficiency" ).val(ui.value );
}
});
$( "#proficiency" ).val($( "#slider4" ).slider( "value" ) );

$( "#slider5" ).slider({
value:<?php if(!empty($demand)) echo $demand['age']; else echo 0;?>,
min: 10,
max: 70,
step: 1,
slide: function( event, ui ) {
$( "#age" ).val(ui.value );
}
});
$( "#age" ).val($( "#slider5" ).slider( "value" ) );

$( "#slider6" ).slider({
value:<?php if(!empty($demand)) echo $demand['weight']; else echo 0;?>,
min: 20,
max: 150,
step: 1,
slide: function( event, ui ) {
$( "#weight" ).val(ui.value );
}
});
$( "#weight" ).val($( "#slider6" ).slider( "value" ) );

});
</script>
</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 


<div id="main">
<div id="main_nr">
<div id="index_lx">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div>
<div class="gray_q_bt14" style="width:825px; height:40px; margin-bottom:10px;">当前设计：<b>555   </b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   需求：<b>5665   </b>        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        设计：<b>9889</b>

</div>

<div class="index_news">
	<div class="index_news_bt">
	<b><?php echo $design['title'];?> </b>
	</div>
	
	<div class="index_news_fbt">
	时间：<?php echo $design['createdate'];?>&nbsp;&nbsp;&nbsp;&nbsp;设计人：<?php echo $design['username'];?>
	</div>
	
	<div class="index_news_zw">
	<div class="index_l_xqnr">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="5"><font class="fDBlack16">样式设计图：</font> </td>
          </tr>
		  <tr> 
		    <?php if(!empty($design_pic)){foreach($design_pic as $item): ?>
            <td width="20%" height="180" valign="top" align="center"><img src="<?php echo $base.$base_photoupload_path.'temp/'.$item['pic_url'];?>" align="absmiddle" border="0" width="140" height="126" class="img_k"/><br><br>
			<!-- <a href="#" class="Red"><?php echo $design_pic['pic_title'];?></a> --></td>
			<?php endforeach; }?>
          </tr>
	</table>

	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
          <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2"><font class="fDBlack16">选择面料：</font></td>
          </tr>
		  
		  <tr>
            <td width="100%" height="200" valign="top" align="left" style="padding:10px 20px 10px 20px;" colspan="2">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="12%" height="180" valign="top" align="center"><img src="<?php echo $base.'img/'.$fabric['pic'];?>" align="absmiddle" border="0" width="106" height="106" class="img_k"/><br><br><font color="Red"><?php echo $fabric['name'];?> </font></td>
          </tr>
			</table>
			</td>
          </tr>
		  <tr>
            <td height="50" valign="middle" align="right"><font class="fDBlack16">功能参数：</font></td>
			<td valign="middle" align="left">
			<div  style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			强度： 
			<font size="2" color="f6931f">1(轻松)</font>
			<div id="slider" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">1.5(激烈)</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			时间： 
			<font size="2" color="f6931f">0Hour</font>
			<div id="slider1" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">2Hour</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			温度： 
			<font size="2" color="f6931f">0</font>
			<div id="slider2" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">50</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			湿度： 
			<font size="2" color="f6931f">0</font>
			<div id="slider3" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">100</font>
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			熟练度：
			<font size="2" color="f6931f">0(初学者)</font>
			<div id="slider4" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">100(运动达人)</font>
			<input type="hidden" id="proficiency" name="proficiency" >
			</div>
			<div style="padding:5px;border-top:1px solid #D9D9D9;border-left:1px solid #D9D9D9;border-right:1px solid #D9D9D9;">
			年龄：
			<font size="2" color="f6931f">10</font>
			<div id="slider5" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">70</font>
			<input type="hidden" id="age" name="age" >
			</div>
			<div style="padding:5px;border:1px solid #D9D9D9;">
			体重：
			<font size="2" color="f6931f">20kg</font>
			<div id="slider6" style="width:200px;display:inline-block"></div>
			<font size="2" color="f6931f">150kg</font>
			<input type="hidden" id="weight" name="weight" >
			</div>

			</td>
          </tr>

	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td width="100%" height="30" align="center" valign="middle">
					<div class="anniu_g" style="width:180px; text-align:center;">
					<?php if($design['status']==0){?><a href="#" class="White14">提交仿真</a><?}?>
					<?php if($design['status']==1){?><a href="#" class="White14">等待仿真</a><?}?>
					<?php if($design['status']==2){?><a href="#" class="White14">查看仿真</a><?}?>
					</div>
				</td>
            </tr>
			</table>
	</div>
	</div>


	

</div>





</div>

<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 发布需求，定制你的专属 </div>

<div class="text_k_black text_sjxq" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_01.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">创建一个需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_02.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">选择你的需求参数</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_03.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">描述你的需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"><img src="<?php echo $base.'img/dot_04.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">发布需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"></td>
			  <td width="85%" align="left" valign="middle">-> 对外发布，让别人为你服务</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0px"></td>
			  <td width="85%" align="left" valign="middle">-> 自己动手设计</td>
            </tr>
</table>
</div>

<div  style="text-align:center; margin-bottom:15px; margin-top:15px;"> 
            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="100%" height="30" align="center" valign="middle">
			  <div class="anniu_h" style="width:220px; text-align:center;">
<a href="<?php echo $base.'demand/publish';?>" class="White14">发布需求</a></div></td>
            </tr>
			</table>

 </div>

<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 最新动态 </div>


<div class="index_r_xwnr_tpx" style="margin-bottom:15px;">
<img src="<?php echo $base.'img/index_r001.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>
<br><br>

<div class="index_r_xwnr_tpx">
<img src="<?php echo $base.'img/index_r002.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_sjxq_bt">参与人：<a href="#" class="Red14">李小小</a>  参与时间：2014-03-25</div>
</div>

</div>
</div>
</div>


<!------------ 底部开始 ------------->
<?php include("footer.php");?>

</body>
</html>

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
value:<?php echo $demand['strength'];?>,
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

$( "#slider2" ).slider({
value:<?php echo $demand['temperature'];?>,
min: 0,
max: 50,
step: 1,
slide: function( event, ui ) {
$( "#temperature" ).val(ui.value );
}
});
$( "#temperature" ).val($( "#slider2" ).slider( "value" ) );


$( "#slider3" ).slider({
value:<?php echo $demand['humidity'];?>,
min: 0,
max: 100,
step: 1,
slide: function( event, ui ) {
$( "#humidity" ).val(ui.value );
}
});
$( "#humidity" ).val($( "#slider3" ).slider( "value" ) );

$( "#slider4" ).slider({
value:<?php echo $demand['proficiency'];?>,
min: 1,
max: 10,
step: 1,
slide: function( event, ui ) {
$( "#proficiency" ).val(ui.value );
}
});
$( "#proficiency" ).val($( "#slider4" ).slider( "value" ) );

});
</script>
</head>
<?php include("header_n.php"); ?>
<!------------ 头部结束 ------------->





<!------------ 内容开始 -------------> 
<input type="hidden" id="base" value="<?php echo $base;?>"></input>


<div id="main">
<div id="main_nr">
<div id="index_lx">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">需 &nbsp;&nbsp; 求</div>
<div class="gray_q_bt14" style="width:825px; height:40px; margin-bottom:10px;">当前设计：<b>555   </b>   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   需求：<b>5665   </b>        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        设计：<b>9889</b>

</div>

<div class="index_news">
	<div class="index_news_bt">
	<b><?php echo $demand['title'];?> </b>
	</div>
	
	<div class="index_news_fbt">
	时间：<?php echo $demand['createdate'];?>&nbsp;&nbsp;&nbsp;&nbsp;发布人：<?php echo $demand['username'];?>
	</div>
	
	<div class="index_news_zw">

	<div id="buzhou1" style="float:left; width:550px;" >
	<input type="hidden" id="type" value="1"/>
	<input type="hidden" id="related_id" value="<?php echo $demand['id'];?>"/>
	<div class="index_l_xqnr">
		<b>类型： </b> <?php echo $demand['type'];?>
		</div>
		<div class="index_l_xqnr">
		<b>强度：</b> 
		<font size="2" color="f6931f">轻&nbsp;&nbsp;松</font>
		<div id="slider" style="width:300px;display:inline-block"></div>
		<font size="2" color="f6931f">激&nbsp;&nbsp;烈</font>
		<input type="hidden" id="strength"  name="sporttime" >
		</div>
		<div class="index_l_xqnr">
		<b>时间： </b>  
		<font size="2" color="f6931f">0Hour</font>
		<div id="slider1" style="width:300px;display:inline-block"></div>
		<font size="2" color="f6931f">24Hour</font>
		<input type="hidden" id="sporttime"  name="sporttime">
		</div>

		<div class="index_l_xqnr">
		<b>天气： </b>  <?php echo $demand['weather'];?>
		</div>
		<div class="index_l_xqnr">
		<b>温度：</b> 
		<font size="2" color="f6931f">0</font>
		<div id="slider2" style="width:300px;display:inline-block"></div>
		<font size="2" color="f6931f">50</font>
		<input type="hidden" id="temperature" name="temperature"  >
		</div>
		<div class="index_l_xqnr">
		<b>湿度： </b>  
		<font size="2" color="f6931f">0</font>
		<div id="slider3" style="width:300px;display:inline-block"></div>
		<font size="2" color="f6931f">100</font>
		<input type="hidden" id="humidity" name="humidity" >
		</div>


		<div class="index_l_xqnr">
		<b>对象： </b> <?php echo $demand['target'];?>
		</div>
		<div class="index_l_xqnr">
		<b>熟练度：</b> 
		<font size="2" color="f6931f">初学者</font>
		<div id="slider4" style="width:300px;display:inline-block"></div>
		<font size="2" color="f6931f">运动达人</font>
		<input type="hidden" id="proficiency" name="proficiency" >
		</div>
	</div>

	</div>
	<input type="hidden" id="title_empty" value="标题不能为空"/>
	<input type="hidden" id="content_empty" value="内容不能为空"/>
	<input type="hidden" id="username_empty" value="收件人不存在"/>
	<div class="index_news_db">
	<?php echo $demand['viewnum'];?> 浏览   <?php echo $demand['messnum'];?> 留言  &nbsp;&nbsp; 分享到： <a href="#"><img src="<?php echo $base.'img/fenx_001.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_002.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_003.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_004.png';?>" align="absmiddle" border="0" /> </a>   <a href="#"><img src="<?php echo $base.'img/fenx_005.png';?>" align="absmiddle" border="0" /> </a><br>
<br>
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="100%" height="30" align="left" valign="middle">
			  <div class="anniu_g" style="width:180px; text-align:center;">
<a href="#" class="White14" onclick="javascript:document.getElementById('new_msg_modal').className='modal';">留&nbsp;&nbsp;&nbsp;言</a></div></td>
            </tr>
			</table>
	</div>
</div>





</div>

<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 发布需求，定制你的专属 </div>

<div class="text_k_black text_sjxq" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_01.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">创建一个需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_02.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">选择你的需求参数</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_03.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">描述你的需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"><img src="<?php echo $base.'img/dot_04.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">发布需求</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"></td>
			  <td width="85%" align="left" valign="middle">-> 对外发布，让别人为你服务</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle"></td>
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


<div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').css('display','none');">确定</button></div>
</div>
<div id="new_msg_modal" class="modal hide" style="width:auto;">
	<div class="modal-header"><a href="#" class="close" onclick="javascript:document.getElementById('new_msg_modal').className='modal hide';">&times;</a><h3>创建新消息</h3></div>
	<div class="modal-body">
		<div class="clearfix">
			<label style="width:70px">收件人</label>
			<input class="span7" type="text" id="msg_username_area"></input>
			<input type="hidden" id="new_msg_uid" value=""/>
			<div id="auto-content" class="span7" style="display:none;margin-left:70px;position:absolute"></div>
		</div>
		<div class="clearfix">
			<label style="width:70px">主题</label>
			<input class="span7" type="text" id="msg_title_area"></input>
		</div>
		<div class="clearfix">
			<label style="width:70px">内容</label>
			<textarea class="span7" rows="4" id="msg_content_area"></textarea>
		</div>
	</div>
	<div class="modal-footer">
		<button class="btn primary" id="msg_send_btn" data-loading-text="请稍后">
			发送
		</button>
	</div>
</div>

<!------------ 底部开始 ------------->
<?php include("footer.php");?>
<script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
<script src="<?php echo $base.'js/message_other.js';?>"></script>
</body>
</html>

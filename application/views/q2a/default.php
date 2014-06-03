<!DOCTYPE html>
<html>
<head>
<title>TIT系统</title>
<meta charset="utf-8">
<meta http-equiv="Content-Type" content="text/html;">
<link href="<?php echo $base.'css/style.css';?>" rel="stylesheet">
<link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
<script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
<script src="<?php echo $base.'js/home.js';?>"></script>
<script src="<?php echo $base.'js/login.js';?>" ></script>
 
</head>
 <?php include("header.php"); ?>
<!------------ 头部结束 ------------->




<!------------ 内容开始 -------------> 
<div id="main">
<div id="main_nr">
<div id="index_l">
<div class="red_bt22" style="width:300px;">休闲运动服装定制平台</div>
<div style="padding-left:15px; font-size:18px; font-weight:bold; line-height:50px;">定制你的专属装备</div>
</div>
<div id="index_r">
<div class="anniu_g" style="text-align:center;">
<a class="White20" href="#"> 开 始 定 制 </a>
</div>
</div>
</div>
</div>

<div id="main">
<div id="main_nr">
<div id="index_l">
<div id="index_l_main_l">
  <div class="red_bt16" style="width:150px; margin-bottom:10px;">服 &nbsp;&nbsp; 装</div>
  <div class="xwtp_k"><a href="#"><img src="<?php echo $base.'img/index_xwtp1.png';?>" align="absmiddle" border="0" width="345" height="260"/></a></div>
  <div class="gray_bt14" style="margin-top:10px;">新闻标题新闻标题新闻标题</div>
</div>
<div id="index_l_main_r">
	<div class="index_l_xwnr">
	<div id="div_pro" class="index_l_xwnr_tp" >
	<a href="#"><img src="<?php echo $base.'img/index_tpx01.png';?>" align="absmiddle" border="0" width="111" height="99"/>
	<div id="float_box" style="display:none;"  class="change_btn_div">
		<a class="W_btn_c" style="background-image:url('<?php echo $base.'img/slider.png';?>')" href="#"><span>收集素材</span></a>
	</div>
	</a>
	</div>
	<div class="index_l_xwnr_wz">
	<a href="#"><font class="fDOrange16">红蓝黄绿基本色 缤纷春夏男装魅力</font></a><br>
	春夏穿衣的关键词，非高彩度的流行单品莫属。<br>
此次红，黄，蓝，绿四大重点。<br>
夏季运动服装更显时尚魅力。
	</div>
	</div>
	
	<div class="index_l_xwnr">
	<div class="index_l_xwnr_tp">
	<a href="#"><img src="<?php echo $base.'img/index_tpx02.png';?>" align="absmiddle" border="0" width="111" height="99"/></a>
	</div>
	<div class="index_l_xwnr_wz">
	<a href="#"><font class="fDOrange16">红蓝黄绿基本色 缤纷春夏男装魅力</font></a><br>
	春夏穿衣的关键词，非高彩度的流行单品莫属。<br>
此次红，黄，蓝，绿四大重点。<br>
夏季运动服装更显时尚魅力。
	</div>
	</div>
	
	<div class="index_l_xwnr">
	<div class="index_l_xwnr_tp">
	<a href="#"><img src="<?php echo $base.'img/index_tpx02.png';?>" align="absmiddle" border="0" width="111" height="99"/></a>
	</div>
	<div class="index_l_xwnr_wz">
	<a href="#"><font class="fDOrange16">红蓝黄绿基本色 缤纷春夏男装魅力</font></a><br>
	春夏穿衣的关键词，非高彩度的流行单品莫属。<br>
此次红，黄，蓝，绿四大重点。<br>
夏季运动服装更显时尚魅力。
	</div>
	</div>
	
	
</div>
</div>
<div id="index_r">
<div class="text_k_black text_yydl" id="denglu">
<?php if(isset($login)):?>
	<?php include("mainright/userinfo.php") ?>
<?php else:?>
<form method="post" action="" class="pull-right" name="login" onsubmit="return false;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="23%" height="44" align="right" valign="middle" class="fBlack14">用户名：</td>
			  <td width="77%" align="center" valign="middle"><INPUT id="login_username" name="username" type=text value="" class="u_text"     ></td>
            </tr>
			<tr>
              <td width="23%" height="44" align="right" valign="middle" class="fBlack14">密&nbsp;&nbsp;&nbsp;码：</td>
			  <td width="77%" align="center" valign="middle"><INPUT id="login_pswd" name="password" type="password" value="" class="u_text"     ></td>
            </tr>
			<tr>
              <td width="100%" height="44" align="center" valign="middle" class="fBlack14" colspan="2"><div class="red_bt14" style="width:220px; text-align:center;"><a id="head_login" href="#" class="White14" onclick="login_process();">登&nbsp;&nbsp;&nbsp;录</a></div></td>
            </tr>
</table>
</form>
<?php endif; ?>
<input type="hidden" value="<?php echo $base; ?>" id="header_base" />
<input type="hidden" value="<?php echo $header_login_wait;?>" id="login_wait"/>
<div id="login_msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#login_msg_modal').hide();"><?php echo $modal_ok;?></button></div>
</div>
</div>
<div class="text_k_black text_yydl" style="margin-top:10px;">
<table width="97%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="100%" height="30" align="center" valign="middle" class="fBlack14" colspan="2"><b>时尚潮流</b></td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0"><img src="<?php echo $base.'img/dot_01.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">红，黄，蓝，绿四大重点</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0"><img src="<?php echo $base.'img/dot_02.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle" >红，黄，蓝，绿四大重点</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0"><img src="<?php echo $base.'img/dot_03.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle" >红，黄，蓝，绿四大重点</td>
            </tr>
			<tr>
              <td width="15%" height="30" align="center" valign="middle" style="padding:0"><img src="<?php echo $base.'img/dot_04.png';?>" align="absmiddle" border="0"/></td>
			  <td width="85%" align="left" valign="middle">红，黄，蓝，绿四大重点</td>
            </tr>
</table>
</div>
</div>
</div>
</div>

<div id="main">
<div id="main_xx">
<img src="<?php echo $base.'img/index_xx.png';?>" align="absmiddle" border="0" width="1150"/>
</div>
</div>


<div id="main">
<div id="main_nr">
<div id="index_lx">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">运 &nbsp;&nbsp; 动</div>
<div class="index_l_xwnrx">
	<div class="index_l_xwnr_tpx"><a href="#"><img src="<?php echo $base.'img/index_l001.png';?>" align="absmiddle" border="0" width="231" height="160"/></a></div>
	<div class="index_l_xwnr_wzx">
	<a href="#" class="Black16"><b>2014CHIC中部大观：展示新型服装商业综合体</b></a><br>
	<div class="index_l_xwnr_zw">
	开馆首日，中部大观国际商贸中心亮相CHIC 展，成为中部地区唯一受邀参展CHIC2014的专业服装市场。中部大观出现在CHIC2014 的舞台上并非偶然，寄予着中国服装业对于中部的高度期待。可以说，中部大观代表了来自蓬勃发展的中部服装业的声音。
	</div>
	<div class="index_l_xwnr_xq">2014-04-03  &nbsp;&nbsp;  <a href="#" class="Red">详情&lt;&lt;</a></div>
	</div>
</div>

<div class="index_l_xwnrx">
	<div class="index_l_xwnr_tpx">
	<a href="#"><img src="<?php echo $base.'img/index_l002.png';?>" align="absmiddle" border="0" width="231" height="160"/></a>
	</div>
	<div class="index_l_xwnr_wzx">
	<a href="#" class="Black16"><b>2014CHIC中部大观：展示新型服装商业综合体</b></a><br>
	<div class="index_l_xwnr_zw">
	开馆首日，中部大观国际商贸中心亮相CHIC 展，成为中部地区唯一受邀参展CHIC2014的专业服装市场。中部大观出现在CHIC2014 的舞台上并非偶然，寄予着中国服装业对于中部的高度期待。可以说，中部大观代表了来自蓬勃发展的中部服装业的声音。
	</div>
	<div class="index_l_xwnr_xq">2014-04-03  &nbsp;&nbsp;  <a href="#" class="Red">详情&lt;&lt;</a></div>
	</div>
</div>

<div class="index_l_xwnrx">
	<div class="index_l_xwnr_tpx">
	<a href="#"><img src="<?php echo $base.'img/index_l003.png';?>" align="absmiddle" border="0" width="231" height="160"/></a>
	</div>
	<div class="index_l_xwnr_wzx">
	<a href="#" class="Black16"><b>2014CHIC中部大观：展示新型服装商业综合体</b></a><br>
	<div class="index_l_xwnr_zw">
	开馆首日，中部大观国际商贸中心亮相CHIC 展，成为中部地区唯一受邀参展CHIC2014的专业服装市场。中部大观出现在CHIC2014 的舞台上并非偶然，寄予着中国服装业对于中部的高度期待。可以说，中部大观代表了来自蓬勃发展的中部服装业的声音。
	</div>
	<div class="index_l_xwnr_xq">2014-04-03  &nbsp;&nbsp;  <a href="#" class="Red">详情&lt;&lt;</a></div>
	</div>
</div>

</div>

<div id="index_rx">
<div class="black_bt22" style="text-align:center; margin-bottom:15px;"> 最 新 动 态 </div>
<div class="index_r_xwnr_tpx" style="margin-bottom:15px;">
<img src="<?php echo $base.'img/index_r001.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_xwnr_bt"><a href="#" class="Black16">运动服装潮流趋势如何看？</a></div>
</div>
<br><br>

<div class="index_r_xwnr_tpx">
<img src="<?php echo $base.'img/index_r002.png';?>" align="absmiddle" border="0" width="294" height="201"/><br>
<div class="index_r_xwnr_bt"><a href="#" class="Black16">以“力行”姿态促强国建设</a></div>
</div>

</div>
</div>
</div>



<div id="main">
<div id="main_xx">
<img src="<?php echo $base.'img/index_xx.png';?>" align="absmiddle" border="0" width="1150"/>
</div>
</div>


<div id="main">
<div id="main_nr" style="text-align:left;">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">明 &nbsp;&nbsp; 星</div>

<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
              <td width="20%" height="466" align="left" valign="top"><img src="<?php echo $base.'img/index_mxtp01.png';?>" align="absmiddle" border="0" width="225" height="477"/></td>
			  <td width="20%" align="left" valign="top"><img src="<?php echo $base.'img/index_mxtp02.png';?>" align="absmiddle" border="0" width="225" height="180"/><br><br>
			  <img src="<?php echo $base.'img/index_mxtp03.png';?>" align="absmiddle" border="0" width="225" height="283"/></td>
			  <td width="40%" align="left" valign="top"><img src="<?php echo $base.'img/index_mxtp04.png';?>" align="absmiddle" border="0" width="455" height="300"/><br><br>
			  <img src="<?php echo $base.'img/index_mxtp05.png';?>" align="absmiddle" border="0" width="455" height="163"/></td>
			  <td width="20%" align="left" valign="top"><img src="<?php echo $base.'img/index_mxtp06.png';?>" align="absmiddle" border="0" width="220" height="160"/><br><br>
			  <img src="<?php echo $base.'img/index_mxtp07.png';?>" align="absmiddle" border="0" width="221" height="302"/></td>
            </tr>
			
</table>



</div>
</div>

<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>
</body>
</html>


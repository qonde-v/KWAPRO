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
<a class="White20" href="<?php echo $base.'demand/publish';?>"> 开 始 定 制 </a>
</div>
</div>
</div>
</div>

<div id="main">
<div id="main_nr">
<div id="index_l">
<div id="index_l_main_l">
  <div class="red_bt16" style="width:150px; margin-bottom:10px;">服 &nbsp;&nbsp; 装</div>
  <div class="xwtp_k"><a href="#"><img src="<?php echo $base.'upload/uploadimages/'.$clothing_f['pricefilename'];?>" align="absmiddle" border="0" width="345" height="260"/></a></div>
  <div class="gray_bt14" style="margin-top:10px;"><?=$clothing_f['title']?></div>
</div>
<div id="index_l_main_r">
	<?php foreach($clothing_list as $item): ?>
	<div class="index_l_xwnr">
	<div id="div_pro" class="index_l_xwnr_tp" >
	<a href="#"><img src="<?php echo $base.'upload/uploadimages/'.$item['pricefilename'];?>" align="absmiddle" border="0" width="111" height="99"/></a>
	</div>
	<div class="index_l_xwnr_wz">
	<a href="#"><font class="fDOrange16"><?=$item['title']?></font></a><br>
	<?=$item['content']?>
	</div>
	</div>
	<?php endforeach; ?>
	
	
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
<?php foreach($sport_list as $item): ?>
<div class="index_l_xwnrx">
	<div class="index_l_xwnr_tpx"><a href="#"><img src="<?php echo $base.'upload/uploadimages/'.$item['pricefilename'];?>" align="absmiddle" border="0" width="231" height="160"/></a></div>
	<div class="index_l_xwnr_wzx">
	<a href="#" class="Black16"><b><?=$item['title']?></b></a><br>
	<div class="index_l_xwnr_zw">
	<?=$item['content']?>
	</div>
	<div class="index_l_xwnr_xq"><?=$item['createTime']?>  &nbsp;&nbsp;  <a href="#" class="Red">详情&lt;&lt;</a></div>
	</div>
</div>
<?php endforeach;?>


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
			  <td width="20%" height="466" align="left" valign="top"><?php if(!empty($star_list[0])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[0];?>" align="absmiddle" border="0" width="225" height="477"/><?php }?></td>
			  <td width="20%" align="left" valign="top"><?php if(!empty($star_list[1])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[1];?>" align="absmiddle" border="0" width="225" height="180"/><?php }?><br><br>
			  <?php if(!empty($star_list[2])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[2];?>" align="absmiddle" border="0" width="225" height="283"/><?php }?></td>
			  <td width="40%" align="left" valign="top"><?php if(!empty($star_list[3])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[3];?>" align="absmiddle" border="0" width="455" height="300"/><?php }?><br><br>
			  <?php if(!empty($star_list[4])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[4];?>" align="absmiddle" border="0" width="455" height="163"/><?php }?></td>
			  <td width="20%" align="left" valign="top"><?php if(!empty($star_list[5])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[5];?>" align="absmiddle" border="0" width="220" height="160"/><?php }?><br><br>
			  <?php if(!empty($star_list[6])){?><img src="<?php echo $base.'upload/uploadimages/'.$star_list[6];?>" align="absmiddle" border="0" width="221" height="302"/><?php }?></td>
            </tr>			
</table>





</div>
</div>

<!------------ 底部开始 ------------->
<?php include("footer.php"); ?>
</body>
</html>


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

</head>
<?php include("header.php"); ?>
<!------------ 头部结束 ------------->

<!------------ 内容开始 -------------> 
<div id="main">
<div id="main_nr">
<div id="index_qp">
<div class="red_bt16" style="width:150px; margin-bottom:10px;">个人空间</div>

<div class="sheji_nr">
<div class="gerenkongjian_l">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center" bgcolor="#f4f4f7" style="padding:10px;">
		  <tr>
            <td width="30%" height="100" valign="middle" align="left"><img src="images/gerentouxiang.png" align="absmiddle" border="0" /></td>
			<td width="70%" height="100" valign="middle" align="left">
<table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
		  <tr>
            <td width="50%" height="33" valign="middle" align="right" class="fGray">用户名：</td>
			<td width="50%" valign="middle" align="left"><?php echo $user_info['username']; ?></td>
          </tr>
		  <tr>
            <td height="33" valign="middle" align="right" class="fGray">性别：</td>
			<td valign="middle" align="left"><?php if($user_info['gender']==0)echo '男'; else echo '女' ?></td>
          </tr>
		  <tr>
            <td height="33" valign="middle" align="right" class="fGray">地点：</td>
			<td valign="middle" align="left">广州</td>
          </tr>
</table>
			</td>
          </tr>
		  <tr>
            <td width="100%" height="30" valign="middle" align="left" colspan="2"><font class="fGray">标签</font></td>
          </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="left" colspan="2">
			<?php foreach($hot_tags as $tag_item): ?>
				<a href="<?php echo $base.'question_pool/question4tag/'.$tag_item['tag_id'];?>"><?php echo $tag_item['tag_name'];?></a>
			<?php endforeach; ?>
			<a href="#" class="Blue">爬山</a>&nbsp;&nbsp;<a href="#" class="Blue">跑步</a>&nbsp;&nbsp;<a href="#" class="Blue">羽毛球</a>&nbsp;&nbsp;<a href="#" class="Blue">跑步</a>&nbsp;&nbsp;<a href="#" class="Blue">羽毛球</a></td>
          </tr>
</table>
<br>

<table width="100%" border="0" cellpadding="0" cellspacing="00" align="center" bgcolor="#f4f4f7">
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'demand/';?>" class="Red16">需&nbsp;&nbsp;求</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'design/';?>" class="Red16">设&nbsp;&nbsp;计</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'material/';?>" class="Red16">素&nbsp;&nbsp;材</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_hui"><a href="<?php echo $base.'consult/';?>" class="Red16">咨&nbsp;&nbsp;询</a></td>
		  </tr>
		  <tr>
            <td width="100%" height="5" valign="middle" align="center" bgcolor="#FFFFFF"><font style="font-size:4px;">&nbsp;</font></td>
		  </tr>
		  <tr>
            <td width="100%" height="40" valign="middle" align="center" class="anniu_h"><a href="<?php echo $base.'messages/';?>" class="Black16">留&nbsp;&nbsp;言</a></td>
		  </tr>
</table>

</div>

 <div class="gerenkongjian_r">
		<!--middle content-->
			 <h6>
			 <?php if($type == 'inbox'):?>
			 <?php echo $messages_in_msg_title1;?><?php echo $msg_user_username;?><?php echo $messages_in_msg_title2;?>
			 <?php else:?>
			 <?php echo $messages_out_msg_title1;?><?php echo $msg_user_username;?><?php echo $messages_out_msg_title2;?>
			 <?php endif;?>
			 <div class="question_content_img"><img id="search_result_avatar" class="search_result_image"  width="100%" src="<?php echo $base.$msg_user_headphoto;?>" /></div></h6>
			  <h6 id="msg_title"><?php echo $message_manage_data['title'];?></h6>
			  <hr />
			  <div id="message_content_area">
				<?php echo $message_view;?>
				</div>
			  <hr />
		<?php if($msg_user_id != 0):?>
		<div class="m_reply"><textarea class="taDetail span10" id="reply_textarea"></textarea>
		<button type="button" id="m_reply_button" class="btn primary" data-loading-text="<?php echo $messages_wait;?>" ><?php echo $messages_reply;?></button>
		&nbsp;<button onclick="window.history.go(-1)" class="btn"><?php echo $messages_back2messageinbox;?></button></div>
		<hr />
		<?php endif;?>
  </div>  
  <input type="hidden" id="base" value="<?php echo $base;?>">
  <input type="hidden" id="message_id" value="<?php echo $message_id;?>"/>
  <input type="hidden" id="content_empty" value="<?php echo $messages_new_body_empty;?>"/>
  <input type="hidden" id="from_uId" value="<?php echo $user_id;?>"/>
  <input type="hidden" id="to_uId" value="<?php echo $msg_user_id;?>"/>
  <input type="hidden" id="is_read" value="<?php echo $message_manage_data['is_read'];?>"/>
  <div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/message_detail.js';?>"></script>
</html>   
    
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
            <td width="30%" height="100" valign="middle" align="left"><img src="<?php echo $base.'img/gerentouxiang.png';?>" align="absmiddle" border="0" /></td>
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
					<input type="hidden" id="base" value="<?php echo $base;?>"></input>
					<div class="row">
						<a href="#" class="btn primary span2" id="new_msg_btn" data-controls-modal="new_msg_modal" data-backdrop='true' data-keyboard='true'><?php echo $messages_new;?></a>
						&nbsp;
						<?php if($inbox_num > 0):?>
							<button class="btn primary" id="msg_del_btn" data-controls-modal="del_msg_modal"><?php echo $messages_delete;?></button>
						<?php endif;?>
					</div>
					<hr />
					
		    		 <h6><?php echo $messages_private_label;print_r($pre_msg_num);?></h6>
					 <?php if($inbox_num > 0):?>
		    	      <table>
				        <thead>
				          <tr>
				            <th class="blue span1">#</th>
				            <th class="blue span2 header" id="sender"><?php echo $messages_private_sender;?></th>
				            <th class="blue span4 header headerSortDown" id="time"><?php echo $messages_private_date;?></th>
				            <th class="blue span5"><?php echo $messages_private_title;?></th>				
				          </tr>
				        </thead>
				        <tbody id="content">
				          <?php echo $view;?>			
				        </tbody>
				      </table>
					  <?php else:?>
					  	<div><?php echo $view;?></div>
						<?php endif;?>
					  
					  <?php if($inbox_page_num > 1):?>	
					  <div class="pagination">
						    <ul id="<?php echo $inbox_page_num;?>">
						    	<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    	<li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
								<li class="active"><a href="#" id="pagination_1">1</a></li>
								<?php if($inbox_page_num > 10):?>
								<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php else:?>
								<?php for($i=2;$i<=$inbox_page_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php endif;?>
								<li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
								<li class="last"><a href="#" id="<?php echo 'pagination_'.$inbox_page_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
					  </div>
					  <?php endif;?>			
		    </div>
            
 
  <input type="hidden" id="check_empty" value="<?php echo $messages_check_empty;?>"/>
   <div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
	<div id="del_msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"><?php echo $messages_delete_confirm;?></div>
	<div class="modal-footer">
		<button class="btn primary" onclick="delete_messages();"><?php echo $modal_ok;?></button>
	</div>
	</div>
  <div id="new_msg_modal" class="modal hide" style="width:auto;">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3><?php echo $messages_new;?></h3></div>
		<div class="modal-body">
			<div class="clearfix">
				<label style="width:70px"><?php echo $messages_new_msg_to;?></label>
				<input class="span7" type="text" id="msg_username_area"></input>
				<input type="hidden" id="new_msg_uid" value=""/>
				<div id="auto-content" class="span7" style="display:none;margin-left:70px;position:absolute"></div>
			</div>
			<div class="clearfix">
				<label style="width:70px"><?php echo $messages_new_subject;?></label>
				<input class="span7" type="text" id="msg_title_area"></input>
			</div>
			<div class="clearfix">
				<label style="width:70px"><?php echo $messages_new_msg_body;?></label>
				<textarea class="span7" rows="4" id="msg_content_area"></textarea>
			</div>
		</div>
		<div class="modal-footer">
			<button class="btn primary" id="msg_send_btn" data-loading-text="<?php echo $messages_wait;?>">
				<?php echo $messages_new_msg_send;?>
			</button>
		</div>
	</div>
	<input type="hidden" id="title_empty" value="<?php echo $messages_new_title_empty;?>"/>
	<input type="hidden" id="content_empty" value="<?php echo $messages_new_body_empty;?>"/>
	<input type="hidden" id="username_empty" value="<?php echo $messages_new_user_not_found;?>"/>
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/message.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
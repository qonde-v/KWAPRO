<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $user_info_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	
    <style type="text/css">
      body {
        padding-top: 50px;
      }
    </style>
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $base.'img/kwapro.ico';?>">
  </head>

  <body>

    <div class="topbar">
      <div class="topbar-inner">
        <div class="container-fluid">
          <a class="brand" href="#">Kwapro</a>
          <?php include("header.php"); ?>
        </div>
      </div>
    </div>

 <div id="main_area" class="container">
     <div class="row">
        <div class="span16">
          <div class="row">
        	<div class="span12">
		    	<!--middle content-->
				
				<input type="hidden" id="base" value="<?php echo $base;?>"></input>
				<div id="profile_info">
					<div class="pull-left" style="margin-top:6px">
						<div class="user_photo"><img class="user_thumb" src="<?php echo $base.$photo;?>"></div>
						<div class="user_name" width="100%"><?php echo $username; ?></div>
						<div style="clear:both"><button class="btn primary" id="send_msg" data-controls-modal="new_msg_modal" data-backdrop='true' data-keyboard='true'><?php echo $user_info_send_message; ?></button></div>
					</div>
					<div class="basic_info span4 pull-left">
						<fieldset class="border_style">
							<legend align="center"><?php echo $user_info_basic_data; ?></legend>
						        <table>
						            <tr>
						                <td class="attr_name"><?php echo $user_info_username; ?></td>
						                <td class="attr_value"><?php echo $username; ?></td>
						            </tr>
						            <tr>
						                <td class="attr_name"><?php echo $user_info_gender; ?></td>
						                <td class="attr_value"><?php echo $gender; ?></td>
						            </tr>
						            <tr>
						                <td class="attr_name"><?php echo $user_info_birthday; ?></td>
						                <td class="attr_value"><?php echo $birthday; ?></td>
						            </tr>
						            <tr>
						                <td class="attr_name"><?php echo $user_info_location; ?></td>
						                <td class="attr_value"><?php echo $location; ?></td>
						            </tr>
						            <tr>
						                <td class="attr_name"><?php echo $user_info_kpc; ?></td>
						                <td class="attr_value"><?php echo $kpc; ?></td>
						            </tr>
						        </table>
						</fieldset>
					</div>
					<div class="account_info pull-left span4">
				        <fieldset class="border_style">
				        <legend align="center"><?php echo $user_info_account; ?></legend>
				        <table>
				            <tr>
				                <td class="attr_name"><?php echo $user_info_email; ?></td>
				                <td class="attr_value"><?php echo $email; ?></td>
				            </tr>
				            <tr>
				                <td class="attr_name">Gtalk：</td>
				                <td class="attr_value"><?php echo $gtalk; ?></td>
				            </tr>
				            <tr>
				                <td class="attr_name">SMS：</td>
				                <td class="attr_value"><?php echo $sms; ?></td>
				            </tr>
				            <tr>
				                <td class="attr_name">QQ：</td>
				                <td class="attr_value"><?php echo $qq; ?></td>
				            </tr>
				            <tr>
				                <td class="attr_name">MSN：</td>
				                <td class="attr_value"><?php echo $msn; ?></td>
				            </tr>
				        </table>
				        </fieldset>
				     </div>
					 <div class="private_tag span11">
				        <h5><?php echo $user_info_private_tag; ?></h5>
				            <div class="q_tags">
				                <?php if(empty($tag)): ?>
				                <?php echo $user_info_empty; ?>
				                <?php else: ?>
								<?php foreach($tag as $tag_data): ?>						
								<a class="label"><?php echo $tag_data['tag_name']; ?></a>
								<?php endforeach; ?>
				                <?php endif;?>
							</div>
				    </div>
				</div>
				<div id="activity_info">
				    <h5><?php echo $user_info_question_data; ?></h5>
				    <p id="content_num"><?php echo $user_info_ask_num; ?><?php echo $ask_num; ?>&nbsp; &nbsp;<?php echo $user_info_answer_num; ?><?php echo $answer_num; ?>&nbsp; &nbsp;<?php echo $user_info_follow_num; ?><?php echo $follow_num; ?></p>
				
				    <strong><?php echo $user_info_latest_ask; ?></strong>
				    <div class="q_area">
				        <?php echo $ask_data; ?>
				    </div>
				
				    <strong><?php echo $user_info_latest_answer; ?></strong>
				    <div class="q_area">
				        <?php echo $answer_data; ?>
				    </div>
				    <strong><?php echo $user_info_latest_follow; ?></strong>
				    <div class="q_area">
				        <?php echo $follow_data; ?>
				    </div>
				</div>
				<hr />
				
		    </div>
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php");?>    
            </div>
          </div>
        </div>
      </div>
   </div>
    <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
	
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
	<div id="new_msg_modal" class="modal hide" style="width:auto;">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3><?php echo $messages_new;?></h3></div>
		<div class="modal-body">
			<div class="clearfix">
				<label style="width:70px"><?php echo $messages_new_msg_to;?></label>
				<input class="span7" disabled="" type="text" id="msg_username_area" value="<?php echo $username; ?>"></input>
				<input  type="hidden" id="msg_uid_area" value="<?php echo $f_uId; ?>"></input>
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
    
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/user_info.js';?>"></script>
</html>   
    

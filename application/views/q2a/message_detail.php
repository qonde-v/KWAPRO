<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $message_detail_page_title;?></title>
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
            <input type="hidden" id="base" value="<?php echo $base;?>">
        	<div class="span10 offset2">
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
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php"); ?>    
            </div>
          </div>
        </div>
      </div>
  </div>  
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
    
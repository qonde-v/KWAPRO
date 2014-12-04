<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $register_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
	<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
    <!-- <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" /> -->
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	
    <style type="text/css">
      div.color {
	  	border-right-width:2px;
	  	border-right-style:solid;
	  	border-right-color:#fffff;
	  }
    </style>
    <!-- Le fav and touch icons -->
  </head>

  <body>
 <div id="" class="container">

 <?php include("header.php"); ?>
  
    				<div style="text-align:center">
    					<h4 ><?php echo $register_title;?></h4>
    					 		<div class="">
							      <form action="<?php echo $base.'register';?>" method="post">
							        <div class="clearfix">
							            <label><?php echo $register_username;?></label>
										<input class="span5" id="username" name="username" type="text" placeholder="<?php echo $register_username_holder;?>" />	
										<div class="suggestion_info" id="username_suggestion" style="display:none"><span class="label notice"><?php echo $register_username_suggestion;?></span></div>
							        </div>									
									<div class="error_msg" style="text-align:center"><?php echo form_error('username'); ?></div>
							        <div class="clearfix">
							            <label><?php echo $register_password;?></label>
										<input class="span5" id="password" name="password" type="password" placeholder="<?php echo $register_password_holder;?>" />
										<div class="suggestion_info" id="pswd_suggestion" style="display:none"><span class="label notice"><?php echo $register_password_suggestion;?></span></div>
							        </div>						
									<div class="error_msg" style="text-align:center"><?php echo form_error('password'); ?></div>
							        <div class="clearfix">
							            <label><?php echo $register_confirm_password;?></label>
										<input class="span5" id="passwordc" name="passwordc" type="password" placeholder="<?php echo $register_confirm_holder;?>" />
							        </div>
									<div class="error_msg" style="text-align:center"><?php echo form_error('passwordc'); ?></div>
							        <div class="clearfix">
							            <label><?php echo $register_email;?></label>
										<input class="span5" id="email" value="<?php echo $email;?>" name="email" type="text" placeholder="<?php echo $register_email_holder;?>" />
							        </div>
									<div class="error_msg" style="text-align:center"><?php echo form_error('email'); ?></div>
							        <div class="clearfix" style="display:none;"> 
							            <label><?php echo $register_invite_code;?></label>
										<input class="span5" id="invite_code" value="<?php echo $invite_code;?>" name="invite_code" type="text" placeholder="<?php echo $register_code_holder;?>" />
							        </div>
									<div class="error_msg" style="text-align:center"><?php echo form_error('invite_code'); ?></div>
									<div class="actions">
	          							<button type="submit" class="btn primary span2"><?php echo $register_register_button;?></button>
	          							&nbsp;<button type="reset" class="btn span2"><?php echo $register_reset_button;?></button>
	        						</div>		
							      </form>
							    </div>
							    
    				</div>
    				 


<?php include("footer.php");?>

  </div>  
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/login.js';?>" ></script>
	<script src="<?php echo $base.'js/register.js';?>"></script>
</html>   
    
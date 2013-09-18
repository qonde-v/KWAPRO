<?php if(isset($login)):?>
  <ul class="nav">
            <li id="header_home"><a href="<?php echo $base;?>"><?php echo $header_home; ?></a></li>
                        
            <li class="dropdown" data-dropdown="dropdown" id="header_messages">
				<a href="#" class="dropdown-toggle"><?php echo $header_messages; ?></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $base."messages/";?>"><?php echo $header_messages_privte; ?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $base."rss_message/";?>"><?php echo $header_messages_subscribe; ?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $base."notes/";?>"><?php echo $header_messages_notes; ?></a></li>
				</ul>
			</li>
			<li id="header_friends"><a href="<?php echo $base."friends/";?>"><?php echo $header_friends; ?></a></li>
            <li class="dropdown" data-dropdown="dropdown" id="header_question">
				<a href="#" class="dropdown-toggle"><?php echo $header_questions; ?></a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo $base."question_pool/";?>"><?php echo $header_question_pool;?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $base."questions/";?>"><?php echo $header_user_related_q;?></a></li>
					<li class="divider"></li>
					<li><a href="<?php echo $base."question_filter/";?>"><?php echo $header_search_question;?></a></li>
				</ul>
			</li>
			<li id="header_setting"><a href="<?php echo $base."profile/";?>"><?php echo $header_profile; ?></a></li>
			<li id="header_document"><a href="<?php echo $base."document/";?>"><?php echo $header_document; ?></a></li>
		  </ul>
          <form class="pull-left">
            <input class="span6" type="text" name="search" id="search" placeholder="<?php echo $header_search_ask;?>" />
          </form>
          
          <p class="pull-right"><a href="<?php echo $base."login/logout";?>"><?php echo $header_logout; ?></a></p>
          
    <?php else:?>
    
         <ul class="nav">
            <li id="header_home"><a href="<?php echo $base;?>"><?php echo $header_home; ?></a></li>
            <li id="header_document"><a href="<?php echo $base."document/";?>"><?php echo $header_document; ?></a></li>
   	      </ul>
          <form class="pull-left" action="">
            <input type="text" name="search" placeholder="<?php echo $header_search;?>" />
          </form>
          
           
           <form method="post" action="" class="pull-right" name="login" onsubmit="return false;">
            <input class="input-small" name="username" id="login_username" type="text" placeholder="<?php echo $header_username;?>">

            <input class="input-small" name="password" id="login_pswd" type="password" placeholder="<?php echo $header_password;?>">
            <a id="head_login" href="#" onclick="login_process();"><?php echo $header_login; ?></a>
			/
			<a id="head_register" href="<?php echo $base.'register/';?>"><?php echo $header_register; ?></a>
          </form>

<?php endif; ?>
<input type="hidden" value="<?php echo $base; ?>" id="header_base" />
<input type="hidden" value="<?php echo $header_login_wait;?>" id="login_wait"/>
<div id="login_msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#login_msg_modal').hide();"><?php echo $modal_ok;?></button></div>
</div>
    

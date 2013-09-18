<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $friends_page_title;?></title>
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
            <div class="span2">&nbsp;
			</div>
        	<div class="span10">
		    	<!--middle content-->
				
				<input type="hidden" id="base" value="<?php echo $base;?>"></input>
				
		    	<ul class="tabs" data-tabs="tabs">
    			        <li><a href="#empty"></a></li>
    			        <li><a href="#empty"></a></li>
    					<li id="all_f_tab"><a href="#all"><?php echo $friends_title_all_friends;?></a></li>
    					<li><a href="#invite"><?php echo $friends_title_invite_friends;?></a></li>
    					<li class="dropdown" data-dropdown="dropdown">
			              <a href="#find" class="dropdown-toggle"><?php echo $friends_title_find_friends;?></a>
			              <ul class="dropdown-menu">
			                <li><a href="#find_location"><?php echo $friends_find_by_location;?></a></li>
			                <li><a href="#find_topic"><?php echo $friends_find_by_topic;?></a></li>
			                <li><a href="#find_name"><?php echo $friends_find_by_name;?></a></li>			                
			              </ul>
			            </li>
    					<li id="request_tab"><a href="#request"><?php echo $friends_title_friends_request;?></a></li>
    				</ul>
     
    				<div class="tab-content">
    					<div class="tab-pane" id="all">
    					    <ul class="media-grid">
							   <?php if(count($my_friends) > 0):?>
								<?php foreach($my_friends as $friend_item): ?>
									<a href="<?php echo $base.'user_information/index/'.$friend_item['user_id'];?>">
							    	  <img class="thumbnail friend_list span1" src="<?php echo $base.$friend_item['headphoto_path'];?>" alt="" 
									  rel='popover' data-html='true' data-original-title="<?php echo $friend_item['username'];?>" 
									  data-content="<?php echo $user_info_location.$friend_item['location'].'<br/>'.$user_info_ask_num.$friend_item['ask_num'].'  '.$user_info_answer_num.$friend_item['answer_num'].'  '.$user_info_kpc.$friend_item['kpc'];?>">
							    	</a>
								<?php endforeach; ?>
								<?php endif; ?>
								
							 </ul> 
    					</div>
    					<div class="tab-pane"  id="invite">
							<?php if($permission == 1):?>
    					  		<h6 style="text-align:center"><?php echo $friends_invite_label;?></h6>
    					 		<div class="">

							       <?php for($i=0; $i<4;$i++): ?>
							        <div class="clearfix">
							            <label><?php echo $friends_invite_email;?></label>
										<input class="span5 invite_email_addr" id="" name="" type="text" placeholder="<?php echo $friends_invite_placeholder;?>" />
							        </div>
							        <?php endfor; ?>
									<div class="actions" style="padding-left:200px">
										<button class="btn primary" id="invite_email_send" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_invite_send_invitation;?></button>
          								&nbsp;<button class="btn" id="invite_email_reset"><?php echo $friends_invite_reset;?></button>
									</div>
							    </div>
							<?php else:?>						
								<h6 style="text-align:center"><?php echo $friends_invite_permission;?></h6>
							<?php endif;?>
    					</div>
    					<div class="tab-pane" id="find_location">
    					   <h6><?php echo $friends_find_location_title;?></h6>
    					   <div>
    					   		<select id="country" class="span2" onchange="show_province();">
									<option value="0" selected="selected">------</option>
	    					   		<option value="1" id="zh">中国</option>
	    					   		<option value="2" id="en">Britain</option>
	    					   		<option value="3" id="de">Germany</option>
	    					   		<option value="4" id="it">Italian</option>
    					   		</select>
    					   		<select id="province" class="span2" onchange="show_city();">
	    					   		<option value="0">------</option>
    					   		</select>
    					   		<select id="city" class="span2" onchange="show_town();">
	    					   		<option value="0">------</option>
    					   		</select>
    					   		<select id="town" class="span2">
	    					   		<option value="0">------</option>
    					   		</select>&nbsp;&nbsp;
								<button class="btn primary" id="location_search_btn" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_find_name_search_button;?></button>
    					   </div>
    					   <div>
    					   		<hr/>
    					   		<h6><?php echo $friends_search_result;?></h6>
    					   		<div id="friend_location">
    					   			<ul class="media-grid">
								 	</ul> 
								 </div>
								 	
								 <div class="actions">								 	 
		          					 <button class="btn primary span4" id="friend_location_confirm" data-loading-text="<?php echo $friends_sending_wait;?>" onclick="add_friend_process('friend_location_confirm','searchBYlocation_check');"><?php echo $friends_add_button;?></button>
		        				 </div>    				   		
    					   </div>
    					</div>
    					<div class="tab-pane" id="find_topic">
							<h6><?php echo $friends_find_topic_title;?></h6>
    					   	  <div>
    					   		<select id="category" class="span2" onchange="show_sub_category();">
									<option value="0" selected="selected">------</option>
									<?php foreach($category_data as $category):?>
										<option class="category_option" value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
									<?php endforeach;?>
    					   		</select>
    					   		<select id="sub_category" class="span2">
									<option value="0">------</option>
    					   		</select>&nbsp;&nbsp;
								<button class="btn primary" id="topic_search_btn" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_find_name_search_button;?></button>
    					      </div>
    					   <div>
    					   		<hr/>
    					   		<h6><?php echo $friends_search_result;?></h6>
    					   		<div id="friend_topic">
    					   			<ul class="media-grid">
								 	</ul> 
								 	</div>
								 	
								 	<div class="actions">
		          					  <button id="friend_topic_confirm" onclick="add_friend_process('friend_topic_confirm','searchBYtopic_check');" class="btn primary span4" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_add_button;?></button>
		        				 	</div>  				   		
    					   </div>
    					</div>
    					<div class="tab-pane" id="find_name">
							<div class="tab-pane" id="find_name">
    					    	<span><h6><?php echo $friends_find_name_input;?></h6></span>
    					    	<input type="text" id="username_search" class="span4"/>
								<button class="btn primary" id="name_search_btn" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_find_name_search_button;?></button>
    					    	<div>
    					    	<hr/>
    					    		<div id="friend_username">
    					    	   	<ul class="media-grid">
										
								 		</ul> 
    					    		</div>
    					    		<div class="actions">
		          					  	<button id="friend_username_confirm" onclick="add_friend_process('friend_username_confirm','searchBYname_check');" class="btn primary span4" data-loading-text="<?php echo $friends_sending_wait;?>"><?php echo $friends_add_button;?></button>
		        				 	</div>
    					    	</div>
    						</div>
						</div>
    					<div class="tab-pane" id="request">
						<?php if(count($my_friend_request) > 0): ?>
    					  	<h6><?php echo $friends_request_label;?></h6>
    					  <ul class="media-grid request_area">
							<?php foreach($my_friend_request as $friend_item): ?>
						       <?php list($user_id,$username,$headphoto,$tag_html) = $friend_item ; ?>
								<li id="<?php echo $user_id; ?>">
							    	<a href="#">
							    	  <img class="thumbnail span1" src="<?php echo $base.$headphoto;?>" alt="" rel='popover' data-html='true' data-original-title="<?php echo $username;?>" data-content="<?php echo $tag_html;?>">
							    	  <input type="checkbox" style="margin-left:10px" name="tobe_friend" value="<?php echo $user_id; ?>"/>
							    	</a>
							    </li>
							<?php endforeach; ?>							
						 </ul> 
						 <div class="actions">
          					  <button data-loading-text="<?php echo $friends_sending_wait;?>" id="friend_process_confirm" class="btn primary span4"><?php echo $friends_request_confirm;?></button>
        				 </div>
						 <?php else:?>
						 	<h6 id="no_request"><?php echo $tips_no_friend_request;?></h6>
						<?php endif;?>
    					</div>
    			  </div>
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
	
	<input type="hidden" id="no_user_select" value="<?php echo $friends_no_user_select;?>"></input>
	<input type="hidden" id="Language" value="<?php echo $language;?>"/>
	<input type="hidden" id="no_request" value="<?php echo $tips_no_friend_request;?>"/>
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
    
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/friends.js';?>"></script>
</html>   
    
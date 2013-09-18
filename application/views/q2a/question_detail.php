<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $question_detail_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base.'css/TextboxList.css'; ?>" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo $base.'css/TextboxList.Autocomplete.css'; ?>" />
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	<!--[if lt IE 9]>
		<script src="<?php echo $base.'js/html5.js';?>"></script>
	<![endif]-->
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

 <div id="main_body" class="container">
     <div class="row">
        <div class="span16">
          <div class="row">
            <!--div class="span4"-->
		<!--?php include('mainleft/question_detail_left.php');?-->                     			    
            <!--/div-->
            
	    <input type="hidden" id="base" value="<?php echo $base;?>"></input>
			
            <div class="span10">
		 		<!--middle-->
		 		
			      <div>
			          <?php echo $question_html_str;?>
				  </div>
	
					<div id="answer4question">
						<?php foreach($reply_html_arr as $reply_item_view): ?>
  						<div class="answer_content"><?php echo $reply_item_view; ?></div>
						<?php endforeach; ?>
					</div>
            </div>
            
            <div class="span6">
                 <!--right-->
                 <div class="Question_operation">
                    <h5><?php echo $question_detail_operation;?></h5>
                    <div class="row">
                     <div class="span5">
                        <button class="btn span2 info" onclick="follow_process('<?php echo $user_id;?>','<?php echo $q_node_id; ?>','<?php echo $collect_type; ?>');"><?php echo $question_detail_followed;?>
	                    </button>
                        <button class="btn span2 success"><?php echo $question_detail_share;?></button>
                       </div>
                   	</div>
                   	<div class="row">
                     <div class="span4">
                     	 <a class="link_text" style="padding-top:15px;" href="#" id="invite_answer_btn" style="cursor:pointer;"><?php echo $question_detail_invite_answer;?>
	                     </a>
                        <form id="invite_answer_form" style="display:none" method="post" action="" onsubmit="return false;">
                                <input id="f_username_input" type="text" value="" class="span2"/>
                                <button id="invite_answer_submit" class="btn" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_invite_button;?></button>
                        </form>
                     </div>
                   </div>     
                </div>

			 
			    <!--question information--> 
                <div class="online_user">
                        <h5><?php echo $question_detail_follower_title;?></h5>
                        <div class="span5"><?php echo $q_data['username'];?>, <?php echo $q_data['sendType'];?>,  <?php echo $q_data['sendPlace'];?>, <?php echo $q_data['time'];?>.</div>
                        <div class="span5"><strong><?php echo $q_data['question_view_num']; ?></strong> <?php echo $question_detail_views; ?>, <strong><?php echo $q_data['question_answer_num']; ?></strong> <?php echo $question_detail_answers; ?>, <strong><?php echo $q_data['question_participant_num']; ?></strong> <?php echo $question_detail_participants; ?>, <strong><?php echo $q_data['question_score']; ?></strong> <?php echo $question_detail_kp_dolors; ?>. </div>
                        <div class="span5"><strong><?php echo $q_data['question_follow_num']; ?></strong> <?php echo $question_detail_follower; ?>:</div>
                        
                        <div class="online_user_content">
                                <?php foreach($follower as $follower_item): ?>
                                <div class="online_image">
                                        <a href="#">
                                                <img class="online_user_image"  width="37" height="39"  src="<?php echo $base.$follower_item['headphoto_path'];?>" id="<?php echo $follower_item['uId']; ?>"/>
                                        </a>
                                </div>
                                <?php endforeach; ?>
                        </div>	    		    
            	</div>
            	
            	<!--note-box--> 			    
			    <div class="online_user">
			    	<div class="span5">
                         <textarea id="drop_box" class="span5" rows="10" placeholder="<?php echo $question_detail_note_tips; ?>" value=""></textarea>
                     </div>
                      <div class="span5" style="padding-top:3px;">
                      	<button id="note_update" class="btn span5 primary"><?php echo $question_detail_note_save;?></button>
                      </div>
			    </div>
            	
            	
            	<!--related content-->
                <div class="online_user">
                    <?php include("mainright/question_related_content.php");?>
                </div> 
				<!--div class="recommendatoin_content">
                                    <h5><?php echo $question_detail_kp_recommend;?></h5>
              			
                                </div-->
			    <!--div class="recommendatoin_content">
			      <h5><?php echo $question_detail_related_ad;?></h5>
			              	<ul>
			            	<li><a href="#">AD one</a></li>
			                <li><a href="#">AD two</a></li>
			                <li><a href="#">AD three</a></li>
			                <li><a href="#">AD four</a></li>
			                <li><a href="#">AD five</a></li>
			                <li><a href="#">AD six</a></li>
			            </ul>
			      </div--> 	
				<!--right-->
            
          </div>
        </div>
      </div>
      </div>
    
    <div class="foot">
    	<?php include("footer.php"); ?>
	</div><!--footer-->
	
	<input type="hidden" id="head_photo_path" value="<?php echo $base.$user_info['headphoto_path']; ?>" />
	<input type="hidden" id="input_prompt" value="<?php echo $question_detail_input_prompt;?>" />
	<input type="hidden" id="input_empty" value="<?php echo $question_detail_input_empty;?>" />
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
</div>
        <input type="hidden" value="" id="select_text_id"/>
        <p id="drag_val" style="display:none;"></p>
        <input type="hidden" value="1" id="note_text_num"/>
        <input type="hidden" value="<?php echo $question_detail_note_save_tips; ?>" id="note_save_tips"/>
		<input type="hidden" value="<?php echo $question_detail_collect_note1.$q_node_id.$question_detail_collect_note2;?>" id="note_subject"/>
  </body>
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
        <script src="<?php echo $base.'js/question_detail.js';?>"></script>
        <script src="<?php echo $base.'js/translate_process.js';?>"></script>
        <script src="<?php echo $base.'js/bing_search.js';?>"></script>
        <script src="<?php echo $base.'js/drag2drop.js';?>"></script>    
	<script type="text/javascript" src="<?php echo $base.'js/GrowingInput.js';?>" ></script>
	<script type="text/javascript" src="<?php echo $base.'js/TextboxList.js';?>" ></script>
	<script type="text/javascript" src="<?php echo $base.'js/TextboxList.Autocomplete.js';?>" ></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script>
            $(function() {
		$(document).ready(function(){
Search("q_text","search_result","<?php echo $question_detail_cant_search;?>","wait_id","<?php echo $base; ?>", "", {search_more_id:"search_more_id"});
		});	
		window.onbeforeunload = note_sync;
            });
        </script>
</html>   
    

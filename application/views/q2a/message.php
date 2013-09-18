<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $messages_page_title;?></title>
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
					<div class="row">
						<a href="#" class="btn primary span2" id="new_msg_btn" data-controls-modal="new_msg_modal" data-backdrop='true' data-keyboard='true'><?php echo $messages_new;?></a>
						&nbsp;
						<?php if($inbox_num > 0):?>
							<button class="btn primary" id="msg_del_btn" data-controls-modal="del_msg_modal"><?php echo $messages_delete;?></button>
						<?php endif;?>
					</div>
					<hr />
					
		    		 <h6><?php echo $messages_private_label;?></h6>
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
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php"); ?>    
            </div>
          </div>
        </div>
      </div>
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
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
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
    
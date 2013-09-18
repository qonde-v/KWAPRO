<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $notes_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base."css/TextboxList.css"; ?>" />
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
				<input type="hidden" id="base" value="<?php echo $base;?>" />
		    	<!--middle content-->
				<button type="button" id="m_add_note_button" class="btn primary" data-controls-modal="new_note_modal" data-backdrop='true' data-keyboard='true'><?php echo $notes_create_new_button;?></button>
				<button class="btn primary" id="delete_notes_button" data-controls-modal="del_note_modal"><?php echo $notes_delete_button;?></button>
		    	      <hr>
					  <table id="sortTableExample">
				        <thead>
				          <tr>
				            <th class=" span1">&nbsp;</th>
				            <th class=" span2 header headerSortDown"><?php echo $notes_date;?></th>
				            <th class=" span4"><?php echo $notes_title;?></th>
				            <th class=" span1"><?php echo $notes_operation;?></th>
				          </tr>
				        </thead>
				        <tbody id="content">
				          <?php echo $view;?>				
				        </tbody>
				      </table>					
					  	<?php if($page_num > 1):?>
	  		             <div class="pagination">
						    <ul id="<?php echo $page_num;?>">
						    	<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    	<li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
								<li class="active"><a href="#" id="pagination_1">1</a></li>
								<?php if($page_num > 10):?>
							    	<?php for($i=2;$i<=10;$i++):?>
										<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
									<?php endfor;?>
								<?php else:?>
									<?php for($i=2;$i<=$page_num;$i++):?>
										<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
									<?php endfor;?>
								<?php endif;?>
								<li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
								<li class="last"><a href="#" id="<?php echo 'pagination_'.$page_num;?>"><?php echo $page_split_last;?></a></li>
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
  <input type="hidden" id="subject_empty" value="<?php echo $notes_create_subject_empty;?>">
  <input type="hidden" id="content_empty" value="<?php echo $notes_create_content_empty;?>"/>
  <input type="hidden" id="check_empty" value="<?php echo $notes_check_empty;?>" />
  <div id="msg_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"></div>
	<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
	<div id="del_note_modal" class="modal hide">
	<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
	<div class="modal-body"><?php echo $notes_delete_confirm_one;?></div>
	<div class="modal-footer">
		<button class="btn primary" onclick="delete_notes();"><?php echo $modal_ok;?></button>
	</div>
	</div>
  <div id="new_note_modal" class="modal hide" style="width:auto;">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3><?php echo $notes_create_title;?></h3></div>
		<div class="modal-body">
			<div class="clearfix">
				<label style="width:70px"><?php echo $notes_create_subject;?></label>
				<input class="span7" type="text" id="note_subject_area"></input>
			</div>
			<div class="clearfix">
				<label style="width:70px"><?php echo $notes_create_tag;?></label>
				<input class="span7" type="text" id="new_note_tags"></input>
			</div>
			<div class="clearfix">
				<label style="width:70px"><?php echo $notes_create_content;?></label>
				<textarea class="span7" rows="4" id="note_content_area"></textarea>
			</div>
		</div>
		<div class="modal-footer"><button class="btn primary" id="new_note_save_btn" data-loading-text="<?php echo $notes_wait;?>"><?php echo $notes_create_ok_button;?></button></div>
	</div>
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/note.js';?>"></script>
	<script src="<?php echo $base."js/TextboxList.js"; ?>" ></script>
	<script src="<?php echo $base."js/GrowingInput.js"; ?>" ></script>
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $note_edit_page_title;?></title>
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
            
        	<div class="span10 offset2">
		    	<!--middle content-->
				<input type="hidden" id="base" value="<?php echo $base;?>"/>
		    		 <p><h6><?php echo $notes_edit_label;?></h6></p>
					<table>
						<tr>
							<th><?php echo $notes_create_subject;?></th>
							<td><input class="span11" type="text" id="note_subject_area" value="<?php echo $subject;?>"></input></td>
						</tr>
						<tr>
							<th><?php echo $notes_create_tag;?></th>
							<td><input class="span11" type="text" id="note_edit_tags" value="<?php echo $tags;?>"></input></td>
						</tr>
						<tr>
							<th><?php echo $notes_create_content;?></th>
							<td><textarea class="span11" rows="15" id="note_content_area"><?php echo $content;?></textarea></td>
						</tr>
					</table>
					<div class="actions row" style="padding-left:230px">
					<button type="button offset4" id="edit_save_btn" class="btn primary"><?php echo $notes_create_ok_button;?></button>
          			&nbsp;<button onclick="window.history.go(-1)" class="btn"><?php echo $notes_return_button;?></button></div>
		    </div>
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php"); ?>    
            </div>
          </div>
        </div>
      </div>
  </div>  
  <input type="hidden" id="note_id" value="<?php echo $noteId;?>"/>
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/note_edit.js';?>"></script>
	<script src="<?php echo $base."js/TextboxList.js"; ?>" ></script>
	<script src="<?php echo $base."js/GrowingInput.js"; ?>" ></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $note_detail_page_title;?></title>
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
		    		 <h6><?php echo $subject;?></h6>
					 <div class="pull-right"><span class="question_view_time"><?php echo $time; ?></span></div>
					 <div class="q_tags" id ="q_tags">
					<?php if($tags!=''):?>
					<?php $tags_arr = explode('|',$tags);?>				
					<?php foreach($tags_arr as $tag):?>
						<a href="#" class="label"><?php echo $tag;?></a>
					<?php endforeach;?>		
					<?php endif;?>
					</div>
				      <div class="note_content">
				          <?php echo $content;?>
					  </div>
			<div class="actions" style="padding-left:280px">
			<a class="btn primary" href="<?php echo $base.'note/note_edit/'.$noteId;?>"><?php echo $notes_edit_button;?></a>
          	&nbsp;<a class="btn" href="<?php echo $base.'notes/';?>"><?php echo $notes_return_button;?></a></div>
		    </div>
            
            <div class="span4">
                <!--right content-->   
              	<?php include("right.php"); ?>    
            </div>
          </div>
        </div>
      </div>
  </div>  
   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script>
		$(function(){
			$('.online_user_image').popover();
		});
	</script>

</html>   
    
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $home_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
    <link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	
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

 <div id="" class="container">
     <div class="row">
        <div class="span16">
          <div class="row">
		  <input type="hidden" id="base" value="<?php echo $base;?>"/>
            <div class="span4">
                <?php echo $left_part_view;?>  			    
            </div>
            
            <div class="span8">
		 		<?php include("mainleft/latest_item.php")?>	    
            </div>
            
            <div class="span4">
                 <?php include("right.php")?>	    
            </div>
            
          </div>
        </div>
      </div>
      </div>
    
    <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  	<script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
        <script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
        <script src="<?php echo $base.'js/home.js';?>"></script>
        <script src="<?php echo $base.'js/translate_process.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/login.js';?>" ></script>
    <!--script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>    
    <script>
	$(function() {
            autocomplete({'id':'search','url':'<?php echo $base."content_search/mashup_data_search/";?>'});
	});
   </script-->
   
</html>   
    
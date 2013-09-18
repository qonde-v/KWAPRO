<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $document_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	
    <style type="text/css">
      body {
        padding-top: 50px;
      }
	  p a{
	  	color:#0069D6;
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
	
	<?php if($lang == 'chinese'):?>
	<?php include("mainleft/document_zh.php")?>
	<?php else:?>
	<?php include("mainleft/document_en.php")?>
	<?php endif;?>


   <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/login.js';?>" ></script>
	<script>
		$(function(){
			$('#header_document').addClass('active');
		});
	</script>
</html>   
    
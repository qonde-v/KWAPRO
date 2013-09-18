<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $question_pool_page_title;?></title>
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
            
        	<div class="span16">
		    	<!--middle content-->
					<input type="hidden" id="base" value="<?php echo $base;?>"></input>
				
		    		 <h6><?php echo $question_pool_head_label;?></h6>
		    	      <table>
				        <thead>
				          <tr>
				            <th class="span1 blue header" id="question_view_num"><?php echo $question_pool_view_num;?></th>
				            <th class="span1 blue header" id="question_answer_num"><?php echo $question_pool_answer_num;?></th>
				            <th class="span1 blue header" id="question_follow_num"><?php echo $question_pool_follow_num;?></th>
				            <th class="span1 blue header" id="question_score"><?php echo $question_pool_kpc_reward;?></th>
				            <th class="span1_5 blue header headerSortDown" id="time"><?php echo $question_pool_submit_time;?></th>
				            <th class="span6 blue"><?php echo $question_pool_q_desc;?></th>
				          </tr>
				        </thead>
				        <tbody id="content">
				          	<?php echo $question_view;?> 
				        </tbody>
				      </table>
				      <div class="pagination">
						    <ul id="<?php echo $total_page;?>">
						    	<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    	<li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
								<li class="active"><a href="#" id="pagination_1">1</a></li>
								<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
								<li class="last"><a href="#" id="<?php echo 'pagination_'.$total_page;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
					  </div>
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
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/question_pool.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
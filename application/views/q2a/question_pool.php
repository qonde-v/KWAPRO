<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $question_pool_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
	<link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link href="<?php echo $base.'css/autocomplete.css';?>" rel="stylesheet">
	
    <style type="text/css">
      body {
        padding-top: 0px;
      }
	  table th, table td {
		  padding: 5px 4px 9px;
		  line-height: 18px;
		  text-align: left;
		}
    </style>
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $base.'img/kwapro.ico';?>">
  </head>

  <body>
  <?php include("header.php"); ?>

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
				        <tbody id="content" >
				          	<?php echo $question_view;?> 
				        </tbody>
				      </table>
					  <?php if($total_page > 1):?>	
				      <div class="pagination">
						    <ul id="<?php echo $total_page;?>">
						    	<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    	<li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
								<li class="active"><a href="#" id="pagination_1">1</a></li>
								<?php if($total_page > 10):?>
								<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php else:?>
								<?php for($i=2;$i<=$total_page;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
								<?php endif;?>
								<li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
								<li class="last"><a href="#" id="<?php echo 'pagination_'.$total_page;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
					  </div>
					  <?php endif;?>
		    </div>
          </div>
        </div>
      </div>
	  <form class="pull-left" action="<?php echo $base.'asking';?>">
         <?php echo $header_search;?><input type="text" name="search" placeholder="<?php echo $header_search;?>" />
      </form>
	  <input type="hidden" value="<?php echo $base; ?>" id="header_base" />
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
    
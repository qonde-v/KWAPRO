<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $question_page_title;?></title>
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
		    	<ul class="tabs" data-tabs="tabs">
    			        <li><a href="#empty"></a></li>
    			        <li><a href="#empty"></a></li>
    					<li class="active"><a href="#asked"><?php echo $question_asked_title;?></a></li>
    					<li><a href="#answered"><?php echo $question_answered_title;?></a></li>
    					<li><a href="#followed"><?php echo $question_following_title;?></a></li>
    					<li><a href="#recommend"><?php echo $question_recommendation_title;?></a></li>
    				</ul>
					
					<input type="hidden" id="base" value="<?php echo $base;?>"></input>
     
    				<div class="tab-content">
    					<div class="active tab-pane" id="asked">
							<div id="asked_q_list">
    					  		<?php echo $my_asked_question; ?>
							</div>
							<?php if($asked_num > 1):?>
	  		             	<div class="pagination">
						    <ul id="<?php echo 'asked_'.$asked_num;?>">
							<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    <li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
							<li class="active"><a href="#" id="pagination_1">1</a></li>
							<?php if($asked_num > 10):?>
						    	<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php else:?>
								<?php for($i=2;$i<=$asked_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php endif;?>
						    <li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
							<li class="last"><a href="#" id="<?php echo 'pagination_'.$asked_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
						  	</div>
							<?php endif;?>
    					</div>
    					
    					<div class="tab-pane"  id="answered">
    					  <div id="answered_q_list">
    					  		<?php echo $my_answered_question; ?>
							</div>
							<?php if($answered_num > 1):?>
	  		             	<div class="pagination">
						    <ul id="<?php echo 'answered_'.$answered_num;?>">
							<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    <li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
							<li class="active"><a href="#" id="pagination_1">1</a></li>
							<?php if($answered_num > 10):?>
						    	<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php else:?>
								<?php for($i=2;$i<=$answered_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php endif;?>
						    <li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
							<li class="last"><a href="#" id="<?php echo 'pagination_'.$answered_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
						  	</div>
							<?php endif;?>
    					</div>
    					<div class="tab-pane" id="followed">
    					   <div id="followed_q_list">
    					  		<?php echo $my_followed_question; ?>
							</div>
							<?php if($followed_num > 1):?>
	  		             	<div class="pagination">
						    <ul id="<?php echo 'followed_'.$followed_num;?>">
							<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    <li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
							<li class="active"><a href="#" id="pagination_1">1</a></li>
							<?php if($followed_num > 10):?>
						    	<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php else:?>
								<?php for($i=2;$i<=$followed_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php endif;?>
						    <li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
							<li class="last"><a href="#" id="<?php echo 'pagination_'.$followed_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
						  	</div>
							<?php endif;?>
    					</div>
    					<div class="tab-pane" id="recommend">
    					   <div id="recommend_q_list">
    					  		<?php echo $my_recommened_question; ?>
							</div>
							<?php if($recommend_num > 1):?>
	  		             	<div class="pagination">
						    <ul id="<?php echo 'recommend_'.$recommend_num;?>">
							<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    <li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
							<li class="active"><a href="#" id="pagination_1">1</a></li>
							<?php if($recommend_num > 10):?>
						    	<?php for($i=2;$i<=10;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php else:?>
								<?php for($i=2;$i<=$recommend_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php endif;?>
						    <li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
							<li class="last"><a href="#" id="<?php echo 'pagination_'.$recommend_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
						  	</div>
							<?php endif;?>
    					</div>
    					</div>
					
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
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/question.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
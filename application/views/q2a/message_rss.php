<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $rss_message_title;?></title>
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
				<input type="hidden" id="base" value="<?php echo $base;?>"/>
		    	<!--middle content-->
                        
                            <h6><?php echo $rss_message_label;?></h6>
							<form action="<?php echo $base.'rss_message/';?>" method="post">
                            <select id="category" class="span2" onchange="show_sub_category();" name="category">
								<option value="0" selected="selected">------</option>
								<?php foreach($category_data as $category):?>
									<option class="category_option" value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
								<?php endforeach;?>
                            </select>
                            <select class="span2" id="sub_category" onchange="show_rss_feed();" name="sub_category">
								<option value="0">------</option>
                            </select>
                            <!--<select class="span4" id="rss_feed">
								<option value="0">------</option>
                            </select>-->
							<button class="btn primary span2" id="filter_rss_msg" data-loading-text="<?php echo $messages_wait;?>"><?php echo $rss_message_filter_btn;?></button>
                            <!--<input type="text" name="rss_search" placeholder="或者直接输入关键词搜索" class="pull-right span4"/>-->
                        	</form>
						
							<?php if($cate_name != ''):?>
							<h6><?php echo $rss_message_cate_label1;?><?php echo $cate_name;?><?php echo $rss_message_cate_label2;?></h6>
							<?php endif;?>
                            <hr/>        
    				<div class="">
						<div id="content">
    					  <?php echo $rss_view;?>
						  </div>
						  <?php if($page_num > 1):?>
	  		             <div class="pagination">
						    <ul id="<?php echo $page_num;?>">
							<li class="first"><a href="#" id="pagination_1"><?php echo $page_split_first;?></a></li>
						    <li class="prev disabled"><a href="#" id="pagination_0">&larr; <?php echo $page_split_previous;?></a></li>
							<li class="active"><a href="#" id="pagination_1">1</a></li>
							<?php if($page_num > 8):?>
						    	<?php for($i=2;$i<=8;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php else:?>
								<?php for($i=2;$i<=$page_num;$i++):?>
									<li><a href="#" id="<?php echo 'pagination_'.$i;?>"><?php echo $i;?></a></li>
								<?php endfor;?>
							<?php endif;?>
						    <li class="next"><a href="#" id="pagination_2"><?php echo $page_split_next;?> &rarr;</a></li>
							<li class="last"><a href="#" id="pagination_<?php echo $page_num;?>"><?php echo $page_split_last;?></a></li>
						    </ul>
						  </div>   
						  <?php endif;?>
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
  <input type="hidden" id="type" value="<?php echo $type;?>"/>
  <input type="hidden" id="code" value="<?php echo $id;?>"/>
  <input type="hidden" id="Language" value="<?php echo $language;?>"/>
   <div class="foot">
	    <?php include("footer.php"); ?>
    </div><!--footer-->
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
	<script src="<?php echo $base.'js/rss_message.js';?>"></script>   
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    
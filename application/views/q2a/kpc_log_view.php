<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $kpc_log_page_title;?></title>
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
				
		    		 <h6><?php echo $kpc_log_title;?></h6>
		    	      <table>
				        <thead>
				          <tr>
				            <th class="span2 blue" id="kpc_log_event"><?php echo $kpc_log_event;?></th>
				            <th class="span2 blue" id="kpc_log_score_change"><?php echo $kpc_log_score_change;?></th>
				            <th class="span2 blue" id="kpc_log_score_left"><?php echo $kpc_log_score_left;?></th>
				            <th class="span2 blue" id="time"><?php echo $kpc_log_time;?></th>
				          </tr>
				        </thead>
				        <tbody id="content">
				          	<?php foreach($kpc_log_data as $item): ?>
				          	<tr>
								<td><?php $prefix="kpc_log_type_";$key=$prefix.$item['event'];echo $$key; ?></td>
								<td><?php echo $item['score_changed']>0 ? '+'.$item['score_changed'] : $item['score_changed']; ?></td>
								<td><?php echo $item['score_left']; ?></td>
								<td><?php echo $item['time']; ?></td>
							</tr>
				          	<?php endforeach; ?>
				        </tbody>
				      </table>
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
	<script src="<?php echo $base.'js/kwapro_event.jquery.js';?>"></script>
	<script src="<?php echo $base.'js/kpc_log.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
</html>   
    

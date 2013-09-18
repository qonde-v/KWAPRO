<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo $question_classify_title ;?></title>
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
            <div class="span2">&nbsp;
			</div>
        	<div class="span12">
		    	<!--middle content-->
			<input type="hidden" id="base" value="<?php echo $base;?>"></input>
                        <!--div class="row">
                            <h6><?php echo "Question filter:";?></h6>
                            
                            <input type="text" name="q_text" value="" id="" class="xxlarge"/>
                            <button class="btn primary" type="submit" id="topic_search_btn" data-loading-text="<?php echo "waiting";?>"><?php echo "GO!";?></button>
                        </div>
                        <div class="row" style="padding-top:5px;">
                            <span><a href="#" class="link_text" id="advance_sw">Advance setting</a></span>
                        </div-->
                        <?php $index = (isset($_GET['index'])) ? $_GET['index']:1;?>
                        <?php $c_id = (isset($_GET['c_id'])) ? $_GET['c_id']:0;?>
                        <?php $sc_id = (isset($_GET['sc_id'])) ? $_GET['sc_id']:0;?>
                        <form method="get" action="">
                        <div class="row"><h6><?php echo $question_classify_title; ?></h6></div>
                        <div class="row" id="advance_set_area" style="padding-top:15px;padding-bottom:5px;">
                                <div>
                                    <span style="padding-right:5px;"><b><?php echo $category_title; ?></b></span>
                                    <select id="category" name="c_id" class="span2" onchange="show_sub_category();">
                                        <option value="0" <?php if($c_id==0){echo 'selected="selected"';}?>>------</option>
                                              <?php foreach($category_data as $category):?>
                                                     <option class="category_option"  <?php if($c_id==$category['category_id']){echo 'selected="selected"';}?> value="<?php echo $category['category_id'];?>"><?php echo $category['category_name'];?></option>
                                              <?php endforeach;?>
                                    </select>
                                    
                                    <span style="padding-right:5px;padding-left:5px;"><b><?php echo $sub_cate_title; ?></b></span>
                                    <select id="sub_category" name="sc_id" class="span2">
                                                    <option value="0" <?php if($sc_id==0){echo 'selected="selected"';}?>>------</option>
                                                    <?php if(isset($subcate_data)):?>
                                                        <?php foreach($subcate_data as $sub_cate):?>
                                                                 <option class="subcate_option"  <?php if($sc_id==$sub_cate['sub_cate_id']){echo 'selected="selected"';}?> value="<?php echo $sub_cate['sub_cate_id'];?>"><?php echo $sub_cate['sub_cate_name'];?></option>
                                                        <?php endforeach;?>
                                                    <?php endif;?>
                                                    
                                                    
                                    </select>&nbsp;&nbsp;
                                    <button class="btn primary span2" type="submit" id="topic_search_btn" data-loading-text="<?php echo $waiting_title; ?>"><?php echo $search_action_title;?></button>
                            
                                </div>
                         </div>
                        </form>
                        
                        <div class="row" style="border-bottom:2px solid #cecece;">
                        </div>
                        <!--question content-->
                        <div class="row">
                            <?php echo $question_data['html']; ?>
                        </div>
                        
                        <div class="pagination">
                            <?php if($question_data['total'] > 1): ?>
                            
                            <?php ?>
                                <ul>
                                            <li class="first"><a href="<?php echo $base.'question_filter/?c_id='.$c_id.'&sc_id='.$sc_id.'&index=1'; ?>"><?php echo $page_split_first;?></a></li>
                                            
                                            <?php $pre_index = ($index == 1) ? 1:($index-1) ; ?>
                                            <li class="prev <?php if($index == 1){echo 'disabled';} ?>"><a href="<?php echo $base.'question_filter/?c_id='.$c_id.'&sc_id='.$sc_id.'&index='.$pre_index; ?>">&larr; <?php echo $page_split_previous;?></a></li>
                                            
                                            <?php $page_start = $question_data['start'];?>
                                            <?php $page_end = $question_data['end'];?>
                                            
                                            <?php $next_index = ($index == $question_data['total']) ? $question_data['total'] : ($index+1) ; ?>
                                            
                                            <?php for($i=$page_start;$i<=$page_end;$i++):?>
                                                <li <?php if($i == $index){echo 'class="active"';} ?> ><a href="<?php echo $base.'question_filter/?c_id='.$c_id.'&sc_id='.$sc_id.'&index='.$i; ?>"><?php echo $i;?></a></li>
                                            <?php endfor;?>
                                            
                                            <li class="<?php if($index == $question_data['total']){echo 'disabled';} ?>"><a href="<?php echo $base.'question_filter/?c_id='.$c_id.'&sc_id='.$sc_id.'&index='.$next_index; ?>"><?php echo $page_split_next;?> &rarr;</a></li>
                                            
                                            <li class="last"><a href="<?php echo $base.'question_filter/?c_id='.$c_id.'&sc_id='.$sc_id.'&index='.$question_data['total']; ?>"><?php echo $page_split_last;?></a></li>
                                </ul>
                            <?php endif; ?>
                       </div>
          </div>
            
          
          </div>
        </div>
      </div>
    <div class="foot">
	    <?php include("footer.php");?>
    </div><!--footer-->
	
	<input type="hidden" id="Language" value="<?php echo $language;?>"/>        
	<div id="msg_modal" class="modal hide">
		<div class="modal-header"><a href="#" class="close">&times;</a><h3>&nbsp;</h3></div>
		<div class="modal-body"></div>
		<div class="modal-footer"><button class="btn primary" onclick="$('#msg_modal').hide();"><?php echo $modal_ok;?></button></div>
	</div>
    
  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-modal.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-tabs.js';?>"></script>
	<script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
	<script src="<?php echo $base.'js/kwapro_search.js';?>" ></script>
	<script src="<?php echo $base.'js/question_filter.js';?>"></script>
</html>   
    
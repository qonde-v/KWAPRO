<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php echo "title" ;?></title>
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

                        <div class="row" style="border-bottom:2px solid #cecece;">
                        </div>
                        <!--question content-->
                        <div class="row">
                            <?php if(($content_data['total'] > 0) && (isset ($content_data['data']))): ?>
                                <?php foreach($content_data['data'] as $item):?>
                                    <?php $url = $base.$content_data['url_prex'].$item['id']; ?>
                                    <div class="question_content">
                                         <div class="row">
                                            <div class="span11">
                                                <a class="link_text" href="<?php echo $url; ?>"><?php echo $item['text']; ?></a>	  
                                            </div>	
                                         </div>

                                         <div class="question_info">
                                              <span class="question_view_time"><?php echo $item['time']; ?></span>
                                         </div>        
                                    </div>
                                <?php endforeach;?>
                            <?php endif; ?>
                        </div>
                        
                        <div class="pagination">
                            <?php if($content_data['total'] > 1): ?>
                            <?php $p_type = isset ($_GET['type']) ? $_GET['type'] : ''; ?>
                            <?php $p_kw = isset ($_GET['kw']) ? $_GET['kw'] : ''; ?>
                            <?php $index = isset ($_GET['index']) ? $_GET['index'] : 1; ?>
                            <?php ?>
                                <ul>
                                            <li class="first"><a href="<?php echo $base.'content_mashup_search/?type='.$p_type.'&kw='.$p_kw.'&index=1'; ?>"><?php echo $page_split_first;?></a></li>
                                            
                                            <?php $pre_index = ($index == 1) ? 1:($index-1) ; ?>
                                            <li class="prev <?php if($index == 1){echo 'disabled';} ?>"><a href="<?php echo $base.'content_mashup_search/?type='.$p_type.'&kw='.$p_kw.'&index='.$pre_index; ?>">&larr; <?php echo $page_split_previous;?></a></li>
                                            
                                            <?php $page_start = $content_data['start'];?>
                                            <?php $page_end = $content_data['end'];?>
                                            
                                            <?php $next_index = ($index == $content_data['total']) ? $content_data['total'] : ($index+1) ; ?>
                                            
                                            <?php for($i=$page_start;$i<=$page_end;$i++):?>
                                                <li <?php if($i == $index){echo 'class="active"';} ?> ><a href="<?php echo $base.'content_mashup_search/?type='.$p_type.'&kw='.$p_kw.'&index='.$i; ?>"><?php echo $i;?></a></li>
                                            <?php endfor;?>
                                            
                                            <li class="<?php if($index == $content_data['total']){echo 'disabled';} ?>"><a href="<?php echo $base.'content_mashup_search/?type='.$p_type.'&kw='.$p_kw.'&index='.$next_index; ?>"><?php echo $page_split_next;?> &rarr;</a></li>
                                            
                                            <li class="last"><a href="<?php echo $base.'content_mashup_search/?type='.$p_type.'&kw='.$p_kw.'&index='.$content_data['total']; ?>"><?php echo $page_split_last;?></a></li>
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
    
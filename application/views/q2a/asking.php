<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $asking_page_title;?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="<?php echo $base.'css/index.css';?>" rel="stylesheet" type="text/css">
    <link href="<?php echo $base.'css/bootstrap.css';?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/style.css';?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo $base.'css/autocomplete.css';?>" />
	
    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="<?php echo $base.'img/kwapro.ico';?>">
  </head>
  
  <body>
    <?php include("header.php"); ?>

 	<div class="container">
 		<div class="row">
 			<div class="span16">
 				<div class="row">
 				  <!--related content area-->
                                  <div class="span9">
                                    <div class="row">
                                    <?php
                                    	$tag_param_str = '';
								        if(!empty($mashup_data) && isset($mashup_data['tags']))
								        {
								        	$encode_arr = array();        	
								        	foreach($mashup_data['tags'] as $item)
								        	{
								        		$encode_arr[] = urlencode($item);
								        	}
								        	$tag_param_str = implode('+',$encode_arr);
								        }
								    ?>

                                    <?php $title_arr = array($asking_related_question,$asking_rss_news,$asking_collect_notes);?>
                                    <?php $type_arr = array('Q','R','N');?>
                                    <?php for($i=0; $i<3; $i++): ?>
                                            <div class="related_content_area span4">
                                            <h4><?php echo $title_arr[$i]; ?></h4>

                                            <?php if(!empty($mashup_data) && isset($mashup_data['data'])): ?>
                                            <?php foreach($mashup_data['data'] as $item): ?>
                                            <?php if($item['type_string'] == $type_arr[$i]): ?>
                                               <p><a onclick="window.open(this.href);return false;" href="<?php echo $item['url']; ?>"><?php echo $item['desc']; ?></a></p>
                                            <?php endif; ?>
                                            <?php endforeach; ?>

                                            <?php if(isset($mashup_data[$type_arr[$i]]) && ($mashup_data[$type_arr[$i]] == 1)):?>
                                                <p><a class="pull-right" onclick="window.open(this.href);return false;" href="<?php echo $base.'content_mashup_search/?type='.$type_arr[$i].'&kw='.$tag_param_str; ?>"><?php echo $asking_view_more;?></a></p>
                                              <?php endif; ?>
                                            <?php endif; ?>   
                                            </div> 
                                     <?php endfor; ?>
                                        
                                        <!--for dynamic search-->
                                        <div class="related_content_area span4">
                                            <h4><?php echo $asking_search_result;?></h4>
                                            <div id="search_result"></div>
                                            <p id="search_more_id" style="display:none;">
				   		<a class="pull-right" href="http://cn.bing.com/search?q=<?php echo $keyword; ?>" onclick="window.open(this.href);return false;"><?php echo $asking_view_more;?></a>
                                            </p>
                                        </div>   
                                    </div>
                                  </div>
			      
			      <!--question ask area-->
			      <div class="span6">
			      		<!--question text area-->
			       		<div class="row">
			       			<div class="span6">
			       				  <p><h4><?php echo $asking_question_label;?></h4></p>	
					              <p><strong><?php echo isset($keyword)?$keyword: ""; ?></strong></p>
                                                      <p><input type="hidden" id="question_text" value="<?php echo isset($keyword)?$keyword: ""; ?>"/></p>
                                                      <p><input type="hidden" id="keyword" value="<?php $tags= isset($mashup_data['tags'])?$mashup_data['tags']:array(); echo implode(',',$tags); ?>" /></p>

                                                </div>
					        <div class="span6" style="padding-top:5px;">
					      		<p><code><?php echo $asking_ask_label;?></code></p>
					      	</div>
					      	<div class="span6" style="padding-top:5px;">
					          	<p>
                                                            <a class="btn primary large span2 pull-right" id="question_submit">
                                                                <?php echo $asking_ask_button_title; ?>
                                                            </a>
                                                        </p>
					        </div>
			       		   </div>
			       		
			       		<!--expert recommandation-->
			       		<div class="row">
			       			  <hr class="span6 ask_block_line"/>
			       			  <div class="span6">
                                                      <h4><?php echo $asking_expert_label;?></h4>
                                                  </div>
                                        </div>
					          <div class="row">
                                                      <?php if(!empty($expert_data)):?>
					          	<?php foreach($expert_data as $sc_id=>$subcate_expert_data): ?>
                                                           <div class="span3">
                                                                <h6><?php echo $subcate_expert_data['subcate_name']; ?><?php echo $asking_area_label;?></h6>
                                                                <ul class="media-grid">
                                                                    <?php foreach($subcate_expert_data['expert_data'] as $item): ?>
                                                                        <li>
                                                                            <a>
                                                                                  <img class="span1" rel='popover' data-html='true'  data-content="<?php echo $item['username']; ?><br/><?php echo $item['expertise']; ?>" src="<?php echo $base.'img/expert_avatar/expert_'.$item['uId'].'.jpg'; ?>" alt=""/>
                                                                                  <input type="checkbox" style="margin-left:10px" name="experts" value="<?php echo 'expert_'.$item['uId']; ?>" checked/>
                                                                            </a>
                                                                        </li>
                                                                     <?php endforeach; ?>
                                                                </ul> 
                                                            </div>
                                                        <?php endforeach; ?>
                                                      
                                                      <?php else:?>
                                                           <?php echo $asking_no_expert_found; ?>  	
                                                      <?php endif; ?>
					          	
					          	
					         </div><!--expert recommendation row-->
					     </div>
			    </div>
 			</div>
 		</div>
 	</div>
 	<input type="hidden" value="<?php echo $base; ?>" id="header_base" />     
    <div class="foot">
    	<?php include("footer.php"); ?>
	</div><!--footer-->


  </body>
  <script type="text/javascript" src="<?php echo $base.'js/jquery-1.7.1.min.js';?>"; ?>" ></script>
    <script src="<?php echo $base.'js/bootstrap-twipsy.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-dropdown.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-buttons.js';?>"></script>
    <script src="<?php echo $base.'js/bing_search.js';?>"></script>
    <script src="<?php echo $base.'js/bootstrap-popover.js';?>"></script>
    <script src="<?php echo $base.'js/question_asking_process.js';?>"></script>    
    <script src="<?php echo $base.'js/kwapro_search.js';?>" ></script> 
   <script>
	$(function() {
		$("img[rel=popover]").popover({
                  offset: 10 
                    }).click(function(e) {
                         e.preventDefault()
                });
                
		$(document).ready(function(){
			if('<?php echo $keyword?>' != '')
			{
	Search("keyword","search_result","<?php echo $asking_cant_search;?>","wait_id","<?php echo $base; ?>", "", {search_more_id:"search_more_id"});
			}
		});
		question_ask_process({submit_id:'question_submit',expert_cname:'experts',text_id:'question_text',tag_id:'keyword', finish_tips:'<?php echo $asking_finish_tip;?>', base:'<?php echo $base; ?>'});
	});
   </script>
</html>   
    
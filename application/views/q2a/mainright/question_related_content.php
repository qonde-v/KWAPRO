<?php $title_arr = array($question_detail_related_question,$question_detail_related_rss,$question_detail_from_note,$question_detail_search_result);?>
<?php $type_arr = array('Q','R','N');?>
<?php $id_arr = array('related_Q','related_R','related_N');?>

<h5><?php echo $question_detail_related_content;?></h5>
 <ul class="tabs" data-tabs="tabs">
     <li class="active"><a href="#related_Q"><?php echo $title_arr[0]; ?></a></li>
     <li><a href="#related_R"><?php echo $title_arr[1]; ?></a></li>
     <li><a href="#related_N"><?php echo $title_arr[2]; ?></a></li>
     <li><a href="#related_WS"><?php echo $title_arr[3]; ?></a></li>
 </ul>
 <div class="tab-content">
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
     <?php for($i=0; $i<3; $i++): ?>
        <div class="<?php echo ($i==0)?'active':''; ?> tab-pane" id="<?php echo $id_arr[$i]; ?>">
            <?php if(!empty($mashup_data) && isset($mashup_data['data'])): ?>
                <?php foreach($mashup_data['data'] as $item): ?>
                    <?php if($item['type_string'] == $type_arr[$i]): ?>
                        <?php $w_open = "onclick=\"window.open(this.href);return false;\""; ?>
                        <a class="link_text" href="<?php echo $item['url']; ?>" <?php echo $w_open; ?> >
                                <div class="Result_content">
                                        <?php echo $item['desc']; ?>
                                </div>
                        </a>    
                    <?php endif;?>
                <?php endforeach; ?>
            
                <?php if(isset($mashup_data[$type_arr[$i]]) && ($mashup_data[$type_arr[$i]] == 1)):?>
                    <p><a class="pull-right link_text" onclick="window.open(this.href);return false;" href="<?php echo $base.'content_mashup_search/?type='.$type_arr[$i].'&kw='.$tag_param_str; ?>"><?php echo $question_detail_view_more;?></a></p>
                <?php endif; ?>
                
            
            <?php endif;?>
        </div>
     <?php endfor;?>
     
     <div class="tab-pane" id="related_WS">
         <div id="search_result">
             <!--search result list-->
         </div>
         <p id="search_more_id" style="display:none;">
            <a class="pull-right link_text" href="http://cn.bing.com/search?q=<?php echo $mashup_data['text']; ?>" onclick="window.open(this.href);return false;">
                <?php echo $question_detail_view_more;?>
            </a>
         </p>
     </div>
 </div>
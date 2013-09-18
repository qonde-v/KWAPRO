<?php $title_arr = array($question_detail_related_question,$question_detail_related_rss,$question_detail_from_note);?>
<?php $type_arr = array('Q','R','N');?>
<?php for($i=0; $i<3; $i++): ?>
<div class="span4">
     <h4><?php echo $title_arr[$i]; ?></h4>
     
     <?php if(!empty($mashup_data) && isset($mashup_data['data'])): ?>
	 <?php foreach($mashup_data['data'] as $item): ?>
	 
	 <?php if($item['type_string'] == $type_arr[$i]): ?>
	<?php $w_open = ($type_arr[$i] == 'R')? "onclick=\"window.open(this.href);return false;\"":""; ?>
  	 <a href="<?php echo $item['url']; ?>" <?php echo $w_open; ?> >
		<div class="Result_content">
			<?php echo $item['desc']; ?>
		</div>
	 </a>
	<?php endif; ?>
	<?php endforeach; ?>
      
	<?php if(isset($mashup_data[$type_arr[$i]]) && ($mashup_data[$type_arr[$i]] == 1)):?>
		<p><a class="pull-right" href="#"><?php echo $question_detail_view_more;?></a></p>
	<?php endif; ?>
	<?php endif; ?>		   			    
</div>
<?php endfor; ?>

<div class="span4">
            <!--searched result-->
             <h4><?php echo $question_detail_search_result;?></h4>
             <div id="search_result">
      
   </div>   
   <p id="search_more_id" style="display:none;">
   <a class="pull-right" href="http://cn.bing.com/search?q=<?php echo $text; ?>" onclick="window.open(this.href);return false;"><?php echo $question_detail_view_more;?></a>
   </p>			    
</div>

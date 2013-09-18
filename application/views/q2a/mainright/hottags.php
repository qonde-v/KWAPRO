<div class="recommendation">
	<h4><?php echo $right_navi_hot_tags ?></h4>
	<?php foreach($hot_tags as $tag_item): ?>
		<a href="<?php echo $base.'question_pool/question4tag/'.$tag_item['tag_id'];?>"><?php echo $tag_item['tag_name'];?></a>
	<?php endforeach; ?>
</div>
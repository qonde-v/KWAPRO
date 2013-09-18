<div class="online_user">
	<h4><?php echo $right_navi_online_friend?></h4>
	<div class="online_user_content">
		<?php foreach($online_friend as $friend_item): ?>
			<div class="online_image">
				<a href="#">
					<img class="online_user_image"  src="<?php echo $base.$friend_item['headphoto_path'];?>" id="<?php echo $friend_item['user_id']; ?>" 
					rel='popover' data-html='true' data-original-title="<?php echo $friend_item['username'];?>" data-content="<?php echo $friend_item['popover_content'];?>" />
				</a>
			</div>
		<?php endforeach; ?>
	</div>
</div>
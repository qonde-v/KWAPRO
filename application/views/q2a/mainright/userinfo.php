<div class="userinfo">
	<h4><?php echo $right_navi_user_info; ?></h4>
	<div class="userinfo_left">
		<img id="userinfo_avatar" class="userinfo_image" src="<?php echo $base.$user_info['headphoto_path']; ?>" />
		<br /><?php echo $user_info['username']; ?>
      	 <!-- <br />广东 -->
	</div>
      <div class="userinfo_right">
        <span class="userinfo_num">
		 <?php echo $user_info['question_num'];?> <?php echo $right_navi_questions; ?><br />
        <?php echo $user_info['answer_num'];?> <?php echo $right_navi_answer; ?><br />
        <?php echo $user_info['follow_num'];?> <?php echo $right_navi_following; ?><br />
        </span> <a href="<?php echo $base.'kpc_log_view/1';?>"><?php echo $user_info['kpc_score'];?> <?php echo $right_navi_kpc; ?></a><br />
		<?php if($unread_msg_num > 0):?>
		<a href="<?php echo $base.'messages/'?>"><?php echo $unread_msg_num;?> <?php echo $right_navi_new_msg;?></a><br />
		<?php endif;?>
		<?php if($friend_request_num > 0):?>
		<a href="<?php echo $base.'friends/'?>"><?php echo $friend_request_num;?> <?php echo $right_navi_friend_request;?></a><br />
		<?php endif;?>
		<input type="hidden" id="f_request_num" value="<?php echo $friend_request_num;?>"/>
      </div>
</div>

<?php if($uId == $from_uId):?>
<div class="message_content align-left">
	<?php echo $username;?>:<br>
	<?php echo $content;?><br>
	<span class="message_content_time"><?php echo $time;?></span>
</div>
<?php else:?>
<div class="message_content align-right">
	<?php echo $content;?><br>
	<span class="message_content_time"><?php echo $time;?></span>
</div>
<?php endif;?>
<br/>
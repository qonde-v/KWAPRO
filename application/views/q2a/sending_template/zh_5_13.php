*<?php echo $username;?>*, 您好，
   <?php echo $r_username;?>发送了一条消息给您：
------------------------
<?php if($text != $text_translated):?>
 _原文_: 
 *<?php echo $text; ?>* 
 _译文_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
 *<?php echo $text_translated; ?>*
 <?php endif; ?>
 -------------------------
（请登录Kwapro查看详情）
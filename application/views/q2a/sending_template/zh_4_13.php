*<?php echo $username;?>*, 您好，
   回复的：
   *<?php echo $o_text; ?>* 
------------------------
*<?php echo $r_username; ?>* 评论如下:
<?php if($text != $text_translated):?>
 _原文_: 
 *<?php echo $text; ?>* 
 _译文_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
 *<?php echo $text_translated; ?>*
 <?php endif; ?>
 -------------------------
(输入 -c#<?php echo $nId; ?> 你的评论,进行回复.)
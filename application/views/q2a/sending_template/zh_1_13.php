*<?php echo $username;?>*, 您好，
   有个问题想请您帮忙回答：
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
 (输入 -r#<?php echo $nId; ?> 你的答案,进行回答.)
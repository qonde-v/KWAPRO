hello *<?php echo $username;?>*,
   <?php echo $r_username;?> has sent a message to you:
------------------------
<?php if($text != $text_translated):?>
 _original text_: 
 *<?php echo $text; ?>* 
 _translated text_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
 *<?php echo $text_translated; ?>*
 <?php endif; ?>
 -------------------------
(Please login to Kwapro to check the details.)
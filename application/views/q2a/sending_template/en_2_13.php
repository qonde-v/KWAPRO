hello *<?php echo $username;?>*,
_you ask_: 
*<?php echo $o_text; ?>* 
------------------------
 *<?php echo $r_username; ?>* answered as following:
 <?php if($text != $text_translated):?>
 _original text_: 
 *<?php echo $text; ?>* 
 _translated text_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
*<?php echo $text_translated; ?>*
<?php endif; ?>
-----------------------
(to comment,just type -c#<?php echo $nId; ?> your comment.)
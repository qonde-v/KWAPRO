hello *<?php echo $username;?>*,
_you reply_: 
*<?php echo $o_text; ?>* 
------------------------
 *<?php echo $r_username; ?>* gives comment as following:
 <?php if($text != $text_translated):?>
 _original text_: 
 *<?php echo $text; ?>* 
 _translated text_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
<p>*<?php echo $text_translated; ?>*<p>
<?php endif; ?>
-----------------------
(to comment,just type -c#<?php echo $nId; ?> your comment.)
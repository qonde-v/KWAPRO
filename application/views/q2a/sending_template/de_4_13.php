hello *<?php echo $username;?>*,
_Sie antworten_: 
*<?php echo $o_text; ?>* 
------------------------
 *<?php echo $r_username; ?>* gibt Kommentar wie folgt:
 <?php if($text != $text_translated):?>
 _Urtext_: 
 *<?php echo $text; ?>* 
 _¨¹bersetzten text_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
<p>*<?php echo $text_translated; ?>*<p>
<?php endif; ?>
-----------------------
(Kommentar,Geben Sie einfach -c#<?php echo $nId; ?> Ihr Kommentar.)
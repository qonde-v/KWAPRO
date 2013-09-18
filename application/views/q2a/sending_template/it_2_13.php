hello *<?php echo $username;?>*,
_si chiede_: 
*<?php echo $o_text; ?>* 
------------------------
 *<?php echo $r_username; ?>* rispose come segue:
 <?php if($text != $text_translated):?>
 _testo originale_: 
 *<?php echo $text; ?>* 
 _il testo tradotto_: 
 *<?php echo $text_translated; ?>*
<?php else: ?>
<p>*<?php echo $text_translated; ?>*<p>
<?php endif; ?>
-----------------------
(un commento,basta digitare -c#<?php echo $nId; ?> il tuo commento.)
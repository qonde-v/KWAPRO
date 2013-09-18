<p>hello *<?php echo $username;?>* ,<p>
<p>&nbsp;&nbsp;mi potete aiutare a rispondere alla seguente domanda:<p>
<p>--------------------------------<p>

<?php if($text != $text_translated):?>
	<p>_testo originale_:</p>
	<p>*<?php echo $text; ?>*<p>
	<p>----------------------------<p>
	<p>_il testo tradotto_:</p>
	<p>*<?php echo $text_translated; ?>*<p>
<?php else: ?>
    <p>*<?php echo $text_translated; ?>*<p>
<?php endif; ?>
<p>--------------------------------<p>
(per rispondere,basta digitare -r#<?php echo $nId; ?> la tua risposta.)

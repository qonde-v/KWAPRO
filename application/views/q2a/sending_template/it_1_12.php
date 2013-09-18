<p>hello <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;mi potete aiutare a rispondere alla seguente domanda:<p>
<p>---------------------------------------------------<p>

<?php if($text != $text_translated):?>
	<p>testo originale:</p>
	<p><?php echo $text; ?><p>
	<p>---------------------------------------------------<p>
	<p>il testo tradotto:</p>
	<p><?php echo $text_translated; ?><p>
<?php else: ?>
    <p><?php echo $text_translated; ?><p>
<?php endif; ?>
<p>---------------------------------------------------<p>


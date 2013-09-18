<p>hello <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;können Sie mir helfen, folgende Frage zu beantworten:<p>
<p>---------------------------------------------------<p>

<?php if($text != $text_translated):?>
	<p>Urtext:</p>
	<p><?php echo $text; ?><p>
	<p>---------------------------------------------------<p>
	<p>übersetzten text:</p>
	<p><?php echo $text_translated; ?><p>
<?php else: ?>
    <p><?php echo $text_translated; ?><p>
<?php endif; ?>
<p>---------------------------------------------------<p>


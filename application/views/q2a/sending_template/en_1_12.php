<p>hello <?php echo $username;?>,<p>
<p>  can you help me to answer the following question:<p>
<p>---------------------------------------------------<p>

<?php if($text != $text_translated):?>
	<p>original text:</p>
	<p><?php echo $text; ?><p>
	<p>---------------------------------------------------<p>
	<p>translated text:</p>
	<p><?php echo $text_translated; ?><p>
<?php else: ?>
    <p><?php echo $text_translated; ?><p>
<?php endif; ?>
<p>---------------------------------------------------<p>


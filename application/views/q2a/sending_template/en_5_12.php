<p>hello <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;<?php echo $r_username;?> has sent a message to you:<p>
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
(Please login to Kwapro to check the details.)
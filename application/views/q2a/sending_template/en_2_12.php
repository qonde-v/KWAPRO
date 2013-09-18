<p>hello <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;you ask:<p>
<p><?php echo $o_text; ?><p>
<p>---------------------------------------------------<p>
<p><?php echo $r_username; ?> answered as following:<p>
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
<p>hello <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;si chiede:<p>
<p><?php echo $o_text; ?><p>
<p>---------------------------------------------------<p>
<p><?php echo $r_username; ?> rispose come segue:<p>
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
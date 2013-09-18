<p>hallo <?php echo $username;?>,<p>
<p>&nbsp;&nbsp;Sie fragen:<p>
<p><?php echo $o_text; ?><p>
<p>---------------------------------------------------<p>
<p><?php echo $r_username; ?> antwortete wie folgt:<p>
<?php if($text != $text_translated):?>
	<p>Urtext:</p>
	<p><?php echo $text; ?><p>
	<p>---------------------------------------------------<p>
	<p>¨¹bersetzten text:</p>
	<p><?php echo $text_translated; ?><p>
<?php else: ?>
    <p><?php echo $text_translated; ?><p>
<?php endif; ?>
<p>---------------------------------------------------<p>
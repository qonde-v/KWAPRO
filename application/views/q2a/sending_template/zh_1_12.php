<p><?php echo $username;?>,您好,<p>
<p>&nbsp;&nbsp;有个问题想请您帮忙：<p>
<p>---------------------------------------------------<p>
<?php if($text != $text_translated):?>
	<p>原文：</p>
	<p><?php echo $text; ?><p>
	<p>---------------------------------------------------<p>
	<p>译文：</p>
	<p><?php echo $text_translated; ?><p>
<?php else: ?>
    <p><?php echo $text_translated; ?><p>
<?php endif; ?>
<p>---------------------------------------------------<p>
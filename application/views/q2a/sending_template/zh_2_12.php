<p><?php echo $username;?> 您好，<p>
<p>&nbsp;&nbsp;您提问的:<p>
<p><?php echo $o_text; ?><p>
<p>---------------------------------------------------<p>
<p>我们找到了如下的答案：</p>
<p><?php echo $r_username; ?>回答：<p>
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
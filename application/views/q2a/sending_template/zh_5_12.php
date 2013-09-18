<p><?php echo $username;?>,您好,<p>
<p>&nbsp;&nbsp;<?php echo $r_username;?>发送了一条消息给您：<p>
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
（请登录Kwapro查看详情）
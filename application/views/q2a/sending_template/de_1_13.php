<p>hello *<?php echo $username;?>* ,<p>
<p>&nbsp;&nbsp;können Sie mir helfen, folgende Frage zu beantworten:<p>
<p>--------------------------------<p>

<?php if($text != $text_translated):?>
	<p>_Urtext_:</p>
	<p>*<?php echo $text; ?>*<p>
	<p>----------------------------<p>
	<p>_übersetzten text_:</p>
	<p>*<?php echo $text_translated; ?>*<p>
<?php else: ?>
    <p>*<?php echo $text_translated; ?>*<p>
<?php endif; ?>
<p>--------------------------------<p>
(zu beantworten,Geben Sie einfach -r#<?php echo $nId; ?> Ihre Antwort.)

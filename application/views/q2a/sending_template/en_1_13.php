hello *<?php echo $username;?>*,
can you help me to answer the following question:
--------------------------------
<?php if($text != $text_translated):?>
    _original text_:
	*<?php echo $text; ?>*
	----------------------------
	_translated text_:
	*<?php echo $text_translated; ?>*
<?php else: ?>
    *<?php echo $text_translated; ?>*
<?php endif; ?>
--------------------------------
(to answer,just type -r#<?php echo $nId; ?> your answer.)

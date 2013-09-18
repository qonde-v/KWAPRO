<div class="question_content">
    <div class="row">
            <?php $text_width_class = (isset($homepage)) ? "span7":"span11"; ?>
            <?php $avatar_width_class = (isset($homepage)) ? "100%":"60%"; ?>
            <div class="<?php echo $text_width_class;?>">
		<a class="link_text" href="<?php echo $base."question/".$nId; ?>" id="q_text_<?php echo $nId;?>"><?php echo $text; ?></a>	  
	    </div>	
                <div class="question_content_img">
			<img id="search_result_avatar" class="search_result_image"  width="<?php echo $avatar_width_class;?>" src="<?php echo $base.$headphoto_path; ?>" />
		</div>
                
     </div>
    
	<div class="q_tags">
		<!--<?php if($tags != ''):?>
                                <?php $tag_arr = explode('|',$tags); ?>
                                <?php foreach($tag_arr as $tag): ?>
                                        <a class="label"><?php echo $tag; ?></a>
                                <?php endforeach; ?>
                <?php endif;?>-->
	</div>
	<div class="q_view">
		<span class="question_view_num"><?php echo $question_view_num; ?></span>
		<?php echo $question_views; ?>&nbsp;|&nbsp;
		<span class="question_view_num"><?php echo $question_answer_num; ?></span>
		<?php echo $question_answers; ?>&nbsp;|&nbsp;
		<span class="question_view_num"><?php echo $question_score; ?></span>
		<?php echo $question_kp_dolors; ?>&nbsp;|&nbsp;
		<span class="question_view_num"><?php echo $question_follow_num; ?></span>
		<?php echo $question_followed; ?>&nbsp;|&nbsp;
		<span class="question_view_num"><?php echo $question_participant_num; ?></span>
		<?php echo $question_participants; ?>
	</div>
        <div class="question_info">
            <span class="question_view_time"><?php echo $username; ?> , </span>
            <span class="question_view_time"><?php echo $time; ?> , </span>
            <span class="question_view_time"><?php echo $sendPlace; ?> , </span>
            <span class="question_view_time"><?php echo $sendType; ?></span>
            <?php if(isset($homepage)): ?>
                <a href="#" class="translate_sw" id="q_translate_<?php echo $nId; ?>"><?php echo $question_translate; ?></a>
            <?php endif; ?>
        </div>
            <div id="q_translate_<?php echo $nId; ?>_area" class="translate_area">
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text_<?php echo $nId;?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text_<?php echo $nId;?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/china.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text_<?php echo $nId;?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text_<?php echo $nId;?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/english.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text_<?php echo $nId;?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text_<?php echo $nId;?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/deutsch.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text_<?php echo $nId;?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text_<?php echo $nId;?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/italian.gif';?>"/>
		</a>
            </div>
</div>
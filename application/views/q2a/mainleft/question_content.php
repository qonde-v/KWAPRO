<!--tags area-->
<div class="question_tag">
	<!--div class="q_tags">
		<?php $tag_arr = explode('|',$tags); ?>
		<span id="q_tag_list">
	    <?php foreach($tag_arr as $tag): ?>
		<?php if(trim($tag)): ?>
			<a href="#" class="label"><?php echo trim($tag); ?></a>
		<?php endif; ?>
		<?php endforeach; ?>
		</span>
		<?php if($uId == $user_id):?>
			<span class="tag_edit"><?php echo $question_detail_edit;?></span>
		<?php endif;?>
	</div-->
</div>
<!--div class="question_tag_edit" style="display:none;text-align:right">
	<input type="text" id="tag_edit_input"/><br />
	<button class="btn primary" id="tag_edit_submit" onclick="tag_edit_submit();" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_edit_submit;?></button>&nbsp;
	<button class="btn" onclick="tag_edit_close();"><?php echo $question_detail_cancel;?></button>
</div-->

<div class="question_content">
	<div class="row">
            <div class="span9">
		<input type="hidden" id="question_id" name="question_id" value="<?php echo $nId; ?>"/>
		<p id="q_text"><?php echo $text; ?></p>
		<?php if($uId == $user_id):?>
			<span class="q_edit"><?php echo $question_detail_edit;?></span>
		<?php endif;?>
            </div>
            
            <div class="question_content_img">
                    <img id="search_result_avatar" class="search_result_image"  width="100%" src="<?php echo $base.$headphoto_path; ?>" />
            </div>
            
	</div>
    
        <div style="display:none;">
            <div class="q_view">
                    <span class="question_view_num"><?php echo $question_view_num; ?></span><?php echo $question_detail_views; ?>&nbsp;|&nbsp;
                    <span class="question_view_num"><?php echo $question_answer_num; ?></span><?php echo $question_detail_answers; ?>&nbsp;|&nbsp;
                    <span class="question_view_num"><?php echo $question_score; ?></span><?php echo $question_detail_kp_dolors; ?>&nbsp;|&nbsp;
                    <span class="question_view_num" id="question_follow_num"><?php echo $question_follow_num; ?></span><?php echo $question_detail_follower; ?>&nbsp;|&nbsp;
                    <span class="question_view_num"><?php echo $question_participant_num; ?></span><?php echo $question_detail_participants; ?>
            </div>	
        </div>

				
	<div class="question_answer">
		<!--span class="question_view_time"><?php echo $time; ?></span-->
		<a href="#" id="q_answer" title="<?php echo $question_detail_answer1 ?>"><?php echo $question_detail_answer1 ?></a>
		<a href="#" id="q_summarize" title="<?php echo $question_detail_summarize; ?>"><?php echo $question_detail_summarize; ?></a>
		<a href="#" class="translate_sw" id="q_translate"><?php echo $question_detail_translate; ?></a>
        </div>
    
        <div id="q_translate_area" class="translate_area">
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text#zh#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text#zh#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/china.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text#en#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text#en#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/english.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text#de#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text#de#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/deutsch.gif';?>"/>
		</a>
		<a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="q_text#it#<?php echo $langCode;?>#<?php echo $nId; ?>" id="q_text#it#<?php echo $langCode;?>#<?php echo $nId; ?>">
			<img class="q_language_image"  src="<?php echo $base.'img/italian.gif';?>"/>
		</a>
	</div>
						
	
				
	<div class="q_answer_textarea" style="display:none">
		<textarea class="taDetail" id="answer_input_area"></textarea>
			
			<button class="btn small" id="answer_btn" onclick="answer_process();" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_answer1; ?></button>
	</div>
	
	<div class="q_summarize_textarea" style="display:none">
		<textarea class="taDetail" id="summary_input_area"><?php echo $summary_content; ?></textarea>
		
		<button class="btn small" id="summarize_btn" onclick="summarize_process();" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_summarize; ?></button>
	</div>
</div>

<div class="question_content_edit" style="display:none">
	<div class='question_textarea'>
		<textarea class='taDetail' id="q_edit_area"></textarea>
		<button class='btn primary' id="q_edit_sumbit" onclick="question_edit_submit();" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_edit_submit;?></button>&nbsp;
		<button onclick='q_close()' class='btn'><?php echo $question_detail_cancel;?></button>
	</div>
</div>
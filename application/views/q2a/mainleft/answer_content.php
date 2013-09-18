<div class="row">
    <div class="span1 q_vot">
        <span class="vote_btn" onclick="vote_update_process({'nId':'<?php echo $nId;?>','type':1})">+</span><br />
        <span class="q_vot_num" id="answer_score_<?php echo $nId;?>"><?php echo $answer_score;?></span><br />
        <span href="#" class="vote_btn" onclick="vote_update_process({'nId':'<?php echo $nId;?>','type':2})">-</span>
    </div>

    <div class="span8">
        <div class="row">
            <p id="answer_<?php echo $nId; ?>"><?php echo $text; ?></p>
        </div>
    </div>
    
    <div> 
         <img id="search_result_avatar" style="width:20px" src="<?php echo $base.$headphoto_path; ?>" />
    </div>
</div>   
        
<div class="row">
            <div class="question_answer">
                    <span class="question_view_time"><?php echo $username; ?></span>
                    <span class="question_view_time"><?php echo $time; ?></span>
                    <span class="question_view_time"><?php echo $sendPlace; ?></span>
                    <span class="question_view_time"><?php echo $sendType; ?></span>
                    <a href="#" class="q_comment" title="<?php echo $question_detail_comment?>"><?php echo $question_detail_comment?></a>
                    <a href="#" class="translate_sw" id="a_translate_<?php echo $nId; ?>"><?php echo $question_detail_translate; ?></a>
            </div>
    
            <div id="a_translate_<?php echo $nId; ?>_area" class="translate_area">
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="answer_<?php echo $nId; ?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>" id="answer_<?php echo $nId; ?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/china.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="answer_<?php echo $nId; ?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>" id="answer_<?php echo $nId; ?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/english.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="answer_<?php echo $nId; ?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>" id="answer_<?php echo $nId; ?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/deutsch.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="answer_<?php echo $nId; ?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>" id="answer_<?php echo $nId; ?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/italian.gif';?>"/>
                    </a>
            </div> 
    
	    <div class="comment_textarea" id="comment_input_<?php echo $nId;?>">
		        <textarea class="taDetail" id="comment_input_area"></textarea>
		        <!--div id="divShowNum" ><span id="changeNum"></span>/140</div-->
		        <a class="btn small" onclick="comment_process('<?php echo $nId;?>');" id="comment_btn" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_comment?></a>
            </div>
</div>

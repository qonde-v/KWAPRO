<div class="comment_content" style="padding-top:3px;">
        <div class="row" style="margin-left:40px;">
                 <div class="span8">
                        <p id="comment_<?php echo $nId; ?>"><small><?php echo $text; ?></small></p>
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
                    <!--a href="#" class="q_comment" title="<?php echo $question_detail_comment?>"><?php echo $question_detail_comment?></a-->
                    <a href="#" class="translate_sw" id="c_translate_<?php echo $nId; ?>"><?php echo $question_detail_translate; ?></a>
            </div>
            
            <div id="c_translate_<?php echo $nId; ?>_area" class="translate_area">
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="comment_<?php echo $nId; ?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>" id="comment_<?php echo $nId; ?>#zh#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/china.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="comment_<?php echo $nId; ?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>" id="comment_<?php echo $nId; ?>#en#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/english.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="comment_<?php echo $nId; ?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>" id="comment_<?php echo $nId; ?>#de#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/deutsch.gif';?>"/>
                    </a>
                    <a href="#" class="lang_translate" data-placement="below" rel='translate' data-content="comment_<?php echo $nId; ?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>" id="comment_<?php echo $nId; ?>#it#<?php echo $langCode;?>#<?php echo $nId; ?>">
                            <img class="q_language_image"  src="<?php echo $base.'img/italian.gif';?>"/>
                    </a>
            </div>
            <!--div class="comment_textarea" id="comment_input_<?php echo $nId;?>">
		        <textarea class="taDetail" id="comment_input_area"></textarea>
		        <a class="btn small" onclick="comment_process('<?php echo $nId;?>');" id="comment_btn" data-loading-text="<?php echo $question_detail_waiting;?>"><?php echo $question_detail_comment?></a>
            </div-->
        </div>
</div>

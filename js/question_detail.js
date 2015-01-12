$(function(){

});

function q_close()
{
	$(".question_content").show();
	$(".question_content_edit").hide();
}

function tag_edit_close()
{
	$('.question_tag').show();
	$('.question_tag_edit').hide();
	$('.question_tag_edit .textboxlist').remove();
}

function edit_tag_show()
{
	var tag_arr = new Array();
	$('.q_tags a').each(function(){
		tag_arr.push($(this).html());
	});
	var tag_str = tag_arr.join(',');
	$('.question_tag').hide();
	$('#tag_edit_input').val(tag_str);
	$('.question_tag_edit').show();	
	tag_textlistbox = new $.TextboxList('#tag_edit_input', {unique:true});
}

function answer_process()
{	
	//$('#answer_btn').button('loading');
	var answer_text = $('#answer_input_area').val();
	var question_nid = $('#question_id').val();
	var url = $('#base').val() + 'content_submit_process/answer_process/';
	var post_str = "answer="+answer_text+"&question_id="+question_nid;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		var respond_arr = html.split("#---#",2);
		if(respond_arr.length == 2)
		{	
			window.location.reload();
			/*$('#answer4question').prepend(respond_arr[1]);
			$('#answer_input_area').val('');
			$('.q_answer_textarea').hide();*/
		}
		else
		{
			var arr = html.split("##");
			if(arr.length == 3)
			{
				$('.modal-body').html(arr[1]);
				$('#msg_modal').removeClass('hide');
				$('#msg_modal').show();
			}
		}
		//$('#answer_btn').button('reset');
                //translate_popout_effect();
	}};
	jQuery.ajax(ajax);
}

function summarize_process()
{
	$('#summarize_btn').button('loading');
	var summary_text = $('#summary_input_area').val();
	var question_nid = $('#question_id').val();
	var url = $('#base').val() + 'content_submit_process/summary_process/';
	var post_str = "text="+summary_text+"&nId="+question_nid;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('.modal-body').html(html);
		$('#msg_modal').modal('show');
		$('#summarize_btn').button('reset');
	}};
	jQuery.ajax(ajax);
}

function comment_process(answer_id)
{
	var div_obj = $('#comment_input_'+answer_id);
	$('#comment_btn',div_obj).button('loading');
	var comment_text = $('#comment_input_area',div_obj).val();
	var url = $('#base').val() + 'content_submit_process/comment_process/';
	var post_str = "comment="+comment_text+"&answer_id="+answer_id;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		var respond_arr = html.split("#---#",2);
		if(respond_arr.length == 2)
		{		   		
			$('#comment4answer_'+answer_id).prepend(respond_arr[1]);
			$('#comment_input_area',div_obj).val('');
			div_obj.hide();
		}
		else
		{
			var arr = html.split("##");
			if(arr.length == 3)
			{
				$('.modal-body').html(arr[1]);
				$('#msg_modal').modal('show');
			}
		}
		$('#comment_btn',div_obj).button('reset');
                translate_popout_effect();
	}};
	jQuery.ajax(ajax);
}

function vote_update_process(options)
{
	var post_str = 'nId='+options['nId']+'&vote_type='+options['type'];
	var url = $('#base').val() + 'user_activity_process/activity_vote_answer/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		if(html !== '')
		{
			var score = parseInt($('#answer_score_'+options['nId']).html());
			score = (options['type'] == 1) ? score+1 : score-1 ;
			score = (score < 0) ? 0 : score;
			$('#answer_score_'+options['nId']).html(score);
		}
	}};
	jQuery.ajax(ajax);
}

function question_edit_submit()
{
	$('#q_edit_sumbit').button('loading');
	var url = $('#base').val() + 'content_submit_process/question_edit/';
	var question_id = $('#question_id').val();
	var text = $('#q_edit_area').val();
	var post_str = 'nId=' + question_id + '&text=' + text;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		var arr = html.split('##');
		if(arr.length == 2)
		{
			$('.modal-body').html(arr[1]);
			$('#msg_modal').modal('show');
		}
		else
		{
			$('.modal-body').html(html);
			$('#msg_modal').modal('show');
			$(".question_content #q_text").html(text);
			$('.question_content_edit').hide();
			$('.question_content').show();
		}		
		$('#q_edit_sumbit').button('reset');		
	}};
	jQuery.ajax(ajax);
}

function tag_edit_submit()
{
	$('#tag_edit_submit').button('loading');
	var url = $('#base').val() + 'content_submit_process/question_tag_edit/';
	var question_id = $('#question_id').val();
	var text = $('#tag_edit_input').val();
	var post_str = 'nId=' + question_id + '&text=' + text;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		var arr = html.split('##');
		if(arr.length == 2)
		{
			$('.modal-body').html(arr[1]);
			$('#msg_modal').modal('show');
		}
		else
		{
			$('.modal-body').html(html);
			$('#msg_modal').modal('show');
			var tag_arr = text.split(',');
			var tags_html = '';
			for(var key in tag_arr)
			{
				tags_html += "<a href='#' class='label'>"+tag_arr[key]+"</a>"
			}
			$('#q_tag_list').html(tags_html);
			$('.question_tag_edit').hide();
			$('.question_tag').show();
			$('.question_tag_edit .textboxlist').remove();
		}		
		$('#tag_edit_submit').button('reset');
	}};
	jQuery.ajax(ajax);
}

function content_translate()
{
	var obj = $(this);
	var arr = obj.attr('id').split('#');
	var text = encodeURIComponent($('#'+arr[0]).html());
	var local_type = arr[1];
	var orignal_type = arr[2];
	var result = '';
	var nId = arr[3];
	var post_str = 'nId='+nId+'&text='+text+'&local_type='+local_type+'&orignal_type='+orignal_type;
	var url = $('#base').val() + 'user_activity_process/activity_translate/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		obj.attr('data-original-title',html);
	}};	
	jQuery.ajax(ajax);
}

function follow_process(user_id,node_id,collect_type)
{
	var post_str = "uId="+user_id+"&nId="+node_id+"&qctId="+collect_type;
	var url = $('#base').val() + 'user_activity_process/activity_follow_question/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		var arr = html.split('##');
		if(arr.length == 1)
		{
			$('.modal-body').html(html);
			$('#msg_modal').modal('show');
			//update follow num
			var follow_num = parseInt($('#question_follow_num').html());
			$('#question_follow_num').html(follow_num + 1);
			//display photo in follower area
			var head_photo_path = $('#head_photo_path').val();
			var html = "<div class='online_image'><a href='#'><img class='online_user_image'  width='37' height='39'  src='"+head_photo_path+"' id='"+user_id+"'/></a>";
			$('.online_user_content').append(html);
		}
		else
		{
			$('.modal-body').html(arr[1]);
			$('#msg_modal').modal('show');
		}
	}};
	jQuery.ajax(ajax);
}

function invite_answer(options)
{
	$('#invite_answer_submit').button('loading');
	var friend_arr = $('#f_username_input').val();
	var url = $('#base').val() + 'question/invite_answer/';
	var post_str = 'friend='+friend_arr+'&nId='+options['nId']+'&q_text='+options['q_text'];
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('.modal-body').html(html);
		$('#msg_modal').modal('show');
		$('#invite_answer_submit').button('reset');
	}};
	jQuery.ajax(ajax);
}



/*********************************Translate area**************************************/
/*function _ajax_translate_process(para_data)
{
	var arr = para_data['content'].split("#");
        
        var o_text = $('#'+arr[0]).html();
        o_text = encodeURIComponent(o_text);
        var local_code = arr[1];
        var orign_code = arr[2];
        var node_id = arr[3];
        
        
	var post_str = 'text='+o_text+'&local_type='+local_code+'&orignal_type='+orign_code+'&nId='+node_id;
	var url =  para_data['url'];
        var ajax_info = {'url':url, 'type':'POST', 'dataType':'text', 'post_str':post_str};
	var options = {'effect_id':para_data['content_id']};
	
	var callback = function(html,option)
	{
		var effect_id = option['effect_id'] ? option['effect_id'] : '';
		
		if(effect_id)
		{
			$('#'+effect_id).html(html);
		}
	};
	
	_ajax_request(ajax_info,callback,options);
};


//
function _ajax_request(ajax_info,callback,options)
{
	    var url_str = ajax_info['url'];
	    var type_str = ajax_info['type'] ? ajax_info['type'] : 'POST';
	    var data_type_str = ajax_info['dataType'] ? ajax_info['dataType'] : 'text';
	    var post_string = ajax_info['post_str'];
	    
	    var ajax = {url: url_str, data:post_string, type: type_str, dataType: data_type_str, timeout: 15000, cache: false, success: function(html) {
               callback(html,options);
            }
        };
        jQuery.ajax(ajax);
};

$(function() {
   translate_popout_effect();
});

function translate_popout_effect()
{
    $("a[rel=translate]").popover({
      offset: 10,type:'ajax', base:$('#base').val(), url:$('#base').val()+"user_activity_process/activity_translate/",_fun:_ajax_translate_process
        }).click(function(e) {
             e.preventDefault()
        }); 
};*/



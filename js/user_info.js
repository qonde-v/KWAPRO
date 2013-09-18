$(function(){	
	$('.question_content').css({'border-bottom':'0px','margin-bottom':'0px','padding':'0px'});
	$('.question_content_img').hide();
	$('.q_view').hide();
	$('.online_user_image').popover();
	$('#msg_send_btn').live('click',send_new_msg);
});

function send_new_msg()
{
	var uId = $('#msg_uid_area').val();
	var username = $('#msg_username_area').val();
	var title = encodeURIComponent($('#msg_title_area').val());
	var content = encodeURIComponent($('#msg_content_area').val());
	if(msg_data_check(username,title,content))
	{
		$('#msg_send_btn').button('loading');
		var url = $('#base').val() + 'messages_request/send_message/';
		var post_str = 'uId='+uId+'&username='+username+'&title='+title+'&content='+content;

var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			$('#msg_modal .modal-body').html(html);
			$('#msg_modal').modal('show');
			$('#msg_send_btn').button('reset');
			$('#new_msg_modal').modal('hide');
			setTimeout("$('#msg_modal').modal('hide')",2000);
		}};
		jQuery.ajax(ajax);
	}





}

function msg_data_check(username,title,content)
{
	if(username.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#username_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	if(title.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#title_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	if(content.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#content_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	return true;
}

$(function(){
	$('#header_messages').addClass('active');
	$('#m_reply_button').live('click',reply_message);
	$('.online_user_image').popover();
	
	var is_read = parseInt($('#is_read').val());
	if(is_read == 0)
	{//update is_read stat
		var url = $('#base').val() + 'messages_request/message_request_read/';
		var post_str = 'id=' + $('#message_id').val();
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		}};
		jQuery.ajax(ajax);
	}
});

function reply_message()
{
	var content = $('#reply_textarea').val();
	if(check_text_valid(content))
	{
		$('#m_reply_button').button('loading');
		var data = retrieve_msg_data();
		data['content'] = encodeURIComponent(content);
		var post_str = generate_query_str(data);
		var url = $('#base').val() + 'messages_request/message_reply_process/';
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			var arr = html.split('##');
			var msg_html = "<div class='message_content align-right'>"+content+"<br><span class='message_content_time'>";
			msg_html += arr[1]+"</span><br/>";
                        $('#reply_textarea').val('');
			$('#message_content_area').append(msg_html);
			$('.modal-body').html(arr[0]);
			$('#msg_modal').modal('show');
			$('#m_reply_button').button('reset');
		}};
		jQuery.ajax(ajax);
	}
}

function check_text_valid(text)
{
	if(text.trim() == '')
	{
		$('.modal-body').html($('#content_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	return true;
}

function retrieve_msg_data()
{
	var data = new Array();
	data['from_uId'] = $('#from_uId').val();
	data['to_uId'] = $('#to_uId').val();
	data['message_id'] = $('#message_id').val();
	data['title'] = encodeURIComponent($('#msg_title').html());
	return data;
}

function generate_query_str(data)
{
   var str = "";
   for(var key in data)
   {
      str += key + "="+ data[key]+"&";
   }
   return str.substring(0,str.length-1);  
}
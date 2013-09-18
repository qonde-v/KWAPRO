$(function(){
	$('#header_messages').addClass('active');
	tag_textlistbox = new $.TextboxList('#note_edit_tags', {unique:true});
	$('.textboxlist-bits').addClass('span11');
	$('.online_user_image').popover();
	$('#edit_save_btn').live('click',edit_note_save);
});

function edit_note_save()
{
	var subject_str = $('#note_subject_area').val();
	var tag_str = $('#note_edit_tags').val();
	var content_str = $('#note_content_area').val();
	var noteId = $('#note_id').val();
	var data = {'subject':encodeURIComponent(subject_str),'tags':encodeURIComponent(tag_str),'content':encodeURIComponent(content_str)};
	if(note_data_check(data))
	{
		var url = $('#base').val() + 'notes/save_edit_note/';
		var post_string = "subject="+data['subject']+"&tags="+data['tags']+"&content="+data['content']+'&noteId='+noteId;
		var ajax = {url: url, data:post_string, type: 'POST', dataType: 'text', cache: false, success: function(html) 
		{			
			var arr = html.split("##");
			if(arr.length > 1)
			{				
				window.location.href = $('#base').val()+'note/'+noteId;
			}
			else
			{
				$('#msg_modal .modal-body').html(html);
				$('#msg_modal').modal('show');
			}
		}};         
        jQuery.ajax(ajax);
	}
}

function note_data_check(save_data)
{
	if(save_data['subject'] === '')
	{
		$('#msg_modal .modal-body').html($('#subject_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	if(save_data['content'] === '')
	{
		$('#msg_modal .modal-body').html($('#content_empty').val());
		$('#msg_modal').modal('show');
		return false;
	}
	return true;
}
$(function(){
	$('#header_messages').addClass('active');
	$('.pagination ul li').live('click',switch_page);
	$('.header').live('click',sort_note);
	$('.online_user_image').popover();
	tag_textlistbox = new $.TextboxList('#new_note_tags', {unique:true});
	$('#new_note_save_btn').live('click',new_note_save);
});

function switch_page()
{
	var index = parseInt($(this).children().attr('id').split('_')[1]);
	var ul_obj = $(this).parent();
	if(index == $('.active',ul_obj).children().attr('id').split('_')[1])
	{
		return;
	}
	var total_page_num = parseInt(ul_obj.attr('id'));
	if($('.header').hasClass('headerSortUp'))
	{
		var sort_type = 1;
	}
	else
	{
		var sort_type = 0;
	}
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var pagena_num = (total_page_num > 10) ? 10 : total_page_num;
	
	var url = $('#base').val() + 'notes/call_notes_load/';
	var post_str = 'index=' + index + '&sort_type=' + sort_type;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

function sort_note()
{
	var sort_type = 0;
	if($(this).hasClass('headerSortDown'))
	{
		sort_type = 1;
	}
	var url = $('#base').val() + 'notes/call_notes_load/';
	var post_data = {'index':1,'sort_type':sort_type};
	var effect_id = $('#content');
	var ul_obj = $('.pagination ul');
	var total_page_num = parseInt(ul_obj.attr('id'));
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var page_update = {'total_page_num':total_page_num,'pagena_num':(total_page_num > 10) ? 10 : total_page_num,'lang':lang};
	table_sort({'url':url,'post_data':post_data,'sort_type':sort_type,'click_id':$(this),'effect_id':effect_id,'ul_obj':ul_obj,'page_update':page_update});
}

function new_note_save()
{
	var subject_str = $('#note_subject_area').val();
	var tag_str = $('#new_note_tags').val();
	var content_str = $('#note_content_area').val();
	var data = {'subject':encodeURIComponent(subject_str),'tags':encodeURIComponent(tag_str),'content':encodeURIComponent(content_str)};
	if(note_data_check(data))
	{
		var url = $('#base').val() + 'notes/save_note/';
		$('#new_note_save_btn').button('loading');
		var post_string = "subject="+data['subject']+"&tags="+data['tags']+"&content="+data['content'];
		var ajax = {url: url, data:post_string, type: 'POST', dataType: 'text', cache: false, success: function(html) 
		{			
			var arr = html.split("##");
			if(arr.length > 1)
			{
				$('#msg_modal .modal-body').html(arr[0]);
				$('#msg_modal').modal('show');
				$('#content').prepend(arr[1]);
			}
			else
			{
				$('#msg_modal .modal-body').html(html);
				$('#msg_modal').modal('show');
			}			
			$('#new_note_save_btn').button('reset');
			$('#new_note_modal').modal('hide');
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

function del_note_confirm(note_id)
{
	$('#del_note_'+note_id).attr('checked',true);
	$('#del_note_modal').modal('show');
}

function delete_notes()
{
	var del_note_arr = get_select_note_id();
	if(del_note_arr.length > 0)
	{
		var post_str = "noteId="+del_note_arr.join('_');
		var base = $('#base').val();
		var url = base + 'notes/delete_notes/';
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			var arr = html.split('##');
			$('#del_note_modal').modal('hide');
			if(arr.length > 1)
			{			
				$('#msg_modal .modal-body').html(arr[1]);
				$('#msg_modal').modal('show');
			}
			else
			{
				window.location.href = base + 'notes/';
			}
		}};
		jQuery.ajax(ajax);
	}
	else
	{
		$('#del_note_modal').modal('hide');
		$('#msg_modal .modal-body').html($('#check_empty').val());
		$('#msg_modal').modal('show');
	}
}

function get_select_note_id()
{
	var select_arr = new Array();
    var checkboxs = document.getElementsByName('note_item');  
    
	for(var i=0; i<checkboxs.length; i++)
	{
	   if(checkboxs[i].checked)
	   {
	      select_arr.push(checkboxs[i].value);
	   }
	}
	return select_arr;
}
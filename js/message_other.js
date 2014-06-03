$(function(){
	$('#msg_send_btn').on('click',send_new_msg);
	$('#msg_username_area').on('keyup',function(event){
		var keywords = $(this).val();
		ajax_get_related_userdata(keywords);
	});
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
		var sort_attr = $('.headerSortUp').attr('id');
		var sort_type = 1;
	}
	else
	{
		var sort_attr = $('.headerSortDown').attr('id');
		var sort_type = 0;
	}
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var pagena_num = (total_page_num > 10) ? 10 : total_page_num;
	
	var url = $('#base').val() + 'messages/sort_message/';
	var post_str = 'index=' + index + '&sort_attr=' + sort_attr + '&sort_type=' + sort_type;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}

function sort_message()
{
	var sort_attr = $(this).attr('id');
	var sort_type = 0;
	if($(this).hasClass('headerSortDown'))
	{
		sort_type = 1;
	}
	var url = $('#base').val() + 'messages/sort_message/';
	var post_data = {'index':1,'sort_attr':sort_attr,'sort_type':sort_type};
	var effect_id = $('#content');
	var ul_obj = $('.pagination ul');
	var total_page_num = parseInt(ul_obj.attr('id'));
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var page_update = {'total_page_num':total_page_num,'pagena_num':(total_page_num > 10) ? 10 : total_page_num,'lang':lang};
	table_sort({'url':url,'post_data':post_data,'sort_type':sort_type,'click_id':$(this),'effect_id':effect_id,'ul_obj':ul_obj,'page_update':page_update});
}

function send_new_msg()
{
	var uId = $('#new_msg_uid').val();
	var username = $('#msg_username_area').val();
	var title = encodeURIComponent($('#msg_title_area').val());
	var content = encodeURIComponent($('#msg_content_area').val());
	var type = $('#type').val();
	var related_id = $('#related_id').val();
	if(msg_data_check(username,title,content))
	{
		$('#msg_send_btn').button('loading');
		var url = $('#base').val() + 'messages_request/send_message/';
		var post_str = 'uId='+uId+'&title='+title+'&content='+content+'&type='+type+'&related_id='+related_id;
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			$('#msg_modal .modal-body').html(html);
			$('#msg_modal').css('display','block');
			$('#msg_send_btn').button('reset');
			$('#new_msg_modal').css('display','none');
			setTimeout("$('#msg_modal').css('display','none')",2000);
		}};
		jQuery.ajax(ajax);
	}
}

function msg_data_check(username,title,content)
{
	if(username.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#username_empty').val());
		$('#msg_modal').css('display','block');
		return false;
	}
	if(title.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#title_empty').val());
		$('#msg_modal').css('display','block');
		return false;
	}
	if(content.trim() == '')
	{
		$('#msg_modal .modal-body').html($('#content_empty').val());
		$('#msg_modal').css('display','block');
		return false;
	}
	return true;
}

function delete_messages()
{
	var del_msg_arr = get_select_msg();
	if(del_msg_arr.length > 0)
	{
		var post_str = "id="+del_msg_arr.join(',');
		var base = $('#base').val();
		var url = base + 'messages_request/message_request_delete/';
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			window.location.href = base + 'messages/';
		}};
		jQuery.ajax(ajax);
	}
	else
	{
		$('#del_msg_modal').modal('hide');
		$('#msg_modal .modal-body').html($('#check_empty').val());
		$('#msg_modal').modal('show');
	}
}

function get_select_msg()
{
	var select_arr = new Array();
    var checkboxs = document.getElementsByName('message_item');  
    
	for(var i=0; i<checkboxs.length; i++)
	{
	   if(checkboxs[i].checked)
	   {
	      select_arr.push(checkboxs[i].value);
	   }
	}
	return select_arr;
}

function ajax_get_related_userdata(keywords)
{
	var url = $('#base').val()+"messages_request/message_username_search/"+keywords;
	var auto_content = $('#auto-content');
   	var ajax = { url: url, type: 'POST', dataType: 'html', cache: false, success: function (html){
      
	  auto_content.html("");
	  $('#new_msg_uid').val("");
	  var respond_data = html.split("##");
	  
	  if(respond_data[0] == 0)
	  {
		 auto_content.css('display','none');
	    return;
	  }
	  
	  var ul = jQuery("<ul>"+respond_data[1]+"</ul>");
	  
	  for(var h=1; h<=respond_data[0]; h++)
	  {
		event_add(h,ul);
	  }
	  
	  $("#auto-content").css({
		'padding': '0px',
		'border': '1px solid #CCCCCC',
		'background-color': 'Window',
		'overflow': 'hidden',
		'border-radius': '3px'
	  });
	  
	  ul.css({
		'width': '100%',
		'list-style-position': 'outside',
		'list-style': 'none',
		'padding': 0,
		'margin': 0
	  });
	  
	  auto_content.append(ul);
	  auto_content.css('display','block');
	}};
	jQuery.ajax(ajax);
}

function event_add(i,ul)
{
  	var li1 = jQuery("#li_"+i,ul);
	var auto_content = $('#auto-content');
	var msg_input = $('#msg_username_area');
	var user_id = $('#new_msg_uid');
  	li1.click(function(){auto_content.css('display','none');msg_input.val(li1[0].innerHTML);user_id.val(li1[0].value);}).hover(function(){
		  li1.css({'background-color': '#34538b'});
	},function(){li1.css({'background-color': '#FFFFFF'});});
}

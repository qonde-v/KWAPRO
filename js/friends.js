$(function(){
	$('.tabs').tabs();
	$('.thumbnail').height($('.thumbnail').width());
	$('#header_friends').addClass('active');
	$('#invite_email_send').live('click',send_invite_email);
	$('.online_user_image').popover();
	$('.friend_list').popover();
	$('.thumbnail').popover({live:true});
	$('#invite_email_reset').live('click',function(){$('.invite_email_addr').val("");});
	$('#location_search_btn').live('click',search_by_location);
	$('#topic_search_btn').live('click',search_by_topic);
	$('#name_search_btn').live('click',search_by_name);
	$('#friend_process_confirm').live('click',friend_request_process);
	
	var f_request_num = $('#f_request_num').val();
	if(f_request_num == 0)
	{
		$('#all').addClass('active');
		$('#all_f_tab').addClass('active');
	}
	else
	{
		$('#request').addClass('active');
		$('#request_tab').addClass('active');
	}
});

function send_invite_email()
{
	var email_arr = get_invite_email_account();
	var email_string = email_arr.join('|');
	var post_str = "email="+email_string;
	var url = $('#base').val() + 'friends_request/invite_friends/';
	$('#invite_email_send').button('loading');
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#invite_email_send').button('reset');
		$('.modal-body').html(html);
		$('#msg_modal').modal('show');
	},error:function(xmlhttp){
	alert('error');
	alert(xmlhttp.status);
	}};
	jQuery.ajax(ajax);
}

function get_invite_email_account()
{
	var email_arr = new Array();
	$('.invite_email_addr').each(function(){	
		if($(this).val().trim())
		{
			email_arr.push($(this).val());
		}
	});
	return email_arr;
}

function show_province()
{
	$('#province').html("<option value='0'>------</option>");
	$('#city').html("<option value='0'>------</option>");
	$('#town').html("<option value='0'>------</option>");
	var code = $('#country option:selected').attr('id');
	var type = 'province';
	var attr = 'country';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#province');
	ajax_location_data(post_str,effect_id);
}

function show_city()
{
	$('#city').html("<option value='0'>------</option>");
	$('#town').html("<option value='0'>------</option>");
	var code = $('#province option:selected').attr('id');
	var type = 'city';
	var attr = 'province';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#city');
	ajax_location_data(post_str,effect_id);
}

function show_town()
{
	$('#town').html("<option value='0'>------</option>");
	var code = $('#city option:selected').attr('id');
	var type = 'town';
	var attr = 'city';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#town');
	ajax_location_data(post_str,effect_id);
}

function ajax_location_data(post_str,effect_id)
{
	var url = $('#base').val() + 'settings_request/get_location_data/';
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		if(html != '')
		{
			var arr = html.split('@');
			for(var key in arr)
			{
				var location_data = arr[key].split('#');
				var option_html = "<option id='"+location_data[0]+"'>"+location_data[1]+"</option>";
				effect_id.append(option_html);
			}
		}
	}};
	jQuery.ajax(ajax);
}

function search_by_location()
{	
	var type,code;
	if($('#town :selected').val() != 0)
	{
		type = 'town';
		code = $('#town :selected').attr('id');
	}
	else if($('#city :selected').val() != 0)
	{
		type = 'city';
		code = $('#city :selected').attr('id');
	}
	else if($('#province :selected').val() != 0)
	{
		type = 'province';
		code = $('#province :selected').attr('id');
	}
	else if($('#country :selected').val() != 0)
	{
		type = 'country';
		code = $('#country :selected').attr('id');
	}
	else
	{
		return;
	}
	$('#location_search_btn').button('loading');
	var url = $('#base').val() + 'friends_request/search_by_location/';
	var post_str = 'key='+type+'_code&value='+code;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#friend_location .media-grid').html(html);
		$('#location_search_btn').button('reset');
	}};
	jQuery.ajax(ajax);
}

function show_sub_category()
{
	var url = $('#base').val()+"settings_request/get_subcate_by_cate_id/";
	$('#sub_category').html("<option value='0'>------</option>");
	var langCode;
	switch($("#Language").val())
	{
		case 'chinese': langCode = 'zh';break;
		default: langCode = 'en';break;
	}
	var post_str = "langCode="+langCode+"&category_id="+$("#category :selected").val();
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
		var option_two_html = '';
		var arr = html.split('@');
		for(var key in arr)
		{
			var subcate = arr[key].split('#');
			option_two_html += "<option class='subcate_option' value='"+ subcate[0] +"'>"+ subcate[1] +"</option>";
		}
		$("#sub_category").append(option_two_html);
	}};
	jQuery.ajax(ajax);
}

function search_by_topic()
{
	var topic_type,topic_id;
	if($('#sub_category :selected').val() != 0)
	{
		topic_type = 2;
		topic_id = $('#sub_category :selected').val();
	}
	else if($('#category :selected').val() != 0)
	{
		topic_type = 1;
		topic_id = $('#category :selected').val();
	}
	else
	{
		return;
	}
	$('#topic_search_btn').button('loading');
	var url = $('#base').val() + 'friends_request/search_by_topic/';
	var post_str = 'topic_type='+topic_type+'&topic_id='+topic_id;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#friend_topic .media-grid').html(html);
		$('#topic_search_btn').button('reset');
	}};
	jQuery.ajax(ajax);
}

function add_friend_process(btn_id,check_name)
{
	$('#'+btn_id).button('loading');
	var friend_arr = get_selected_friend_candidates(check_name);
	if(friend_arr.length > 0)
	{
		var post_str = "friend="+friend_arr.join(',');
		var url = $('#base').val() + 'friends_request/add_as_friend_request/';
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			$('.modal-body').html(html);
			$('#msg_modal').modal('show');
		}};
		jQuery.ajax(ajax);
	}
	else
	{//no users selected
		$('.modal-body').html($('#no_user_select').val());
		$('#msg_modal').modal('show');
	}
	$('#'+btn_id).button('reset');
}

function friend_request_process()
{
	$('#friend_process_confirm').button('loading');
	var friend_arr = get_selected_friend_candidates('tobe_friend');
	if(friend_arr.length > 0)
	{
		var post_str = "friend="+friend_arr.join(',');
		var url = $('#base').val() + 'friends_request/friend_request_process/';
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			$('.modal-body').html(html);
			$('#msg_modal').modal('show');
			for(var key in friend_arr)
			{
				$('.request_area #'+friend_arr[key]).remove();
			}
			var num = $('.request_area li').size();
			if(num == 0)
			{
				$('#request').html('<h6>'+$('#no_request').val()+'</h6>')
			}
		}};
		jQuery.ajax(ajax);
	}
	else
	{//no users selected
		$('.modal-body').html($('#no_user_select').val());
		$('#msg_modal').modal('show');
	}
	$('#friend_process_confirm').button('reset');
}

function get_selected_friend_candidates(cName)
{
    var select_arr = new Array();
    var checkboxs = document.getElementsByName(cName);  
    
	for(var i=0; i<checkboxs.length; i++)
	{
	   if(checkboxs[i].checked)
	   {
	      select_arr.push(checkboxs[i].value);
	   }
	}
	return select_arr;
}

function search_by_name()
{
	var search_text = $('#username_search').val();
	if(search_text.trim() == '')
	{
		return ;
	}
	var post_str = "param="+search_text;
	var url = $('#base').val() + 'friends_request/search_by_name/';
	$('#name_search_btn').button('loading');
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#friend_username .media-grid').html(html);
		$('#name_search_btn').button('reset');
	}};
	jQuery.ajax(ajax);
}

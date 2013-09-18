$(function(){
	$('#header_messages').addClass('active');
	$('.pagination ul li').live('click',switch_page);
	$('.online_user_image').popover();
	//$('#filter_rss_msg').live('click',filter_rss_message);
});

//switch page
function switch_page()
{
	var index = parseInt($(this).children().attr('id').split('_')[1]);
	var type = $('#type').val();
	var code = parseInt($('#code').val());
	var ul_obj = $(this).parent();
	if(index == $('.active',ul_obj).children().attr('id').split('_')[1])
	{
		return;
	}
	var total_page_num = parseInt(ul_obj.attr('id'));
	//var type = ul_obj.attr('id').split('_')[0];
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var pagena_num = (total_page_num > 8) ? 8 : total_page_num;
		
	var url = $('#base').val() + 'rss_message/call_rss_data_load/';
	var post_str = 'index=' + index + '&type=' + type + '&id=' + code;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
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

function show_rss_feed()
{
	var url = $('#base').val()+"rss_message/get_feed_by_subcate/";
	$('#rss_feed').html("<option value='0'>------</option>");
	var langCode;
	switch($("#Language").val())
	{
		case 'chinese': langCode = 'zh';break;
		default: langCode = 'en';break;
	}
	var post_str = "langCode="+langCode+"&subcate_id="+$("#sub_category :selected").val();
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
		if(html != '')
		{
			var option_two_html = '';
			var arr = html.split('@');
			for(var key in arr)
			{
				var feed = arr[key].split('#');
				option_two_html += "<option class='feed_option' value='"+ feed[0] +"'>"+ feed[1] +"</option>";
			}
			$("#rss_feed").append(option_two_html);
		}	
	}};
	jQuery.ajax(ajax);
}
$(function(){
	$('#header_question').addClass('active');
		
	$('.header').bind('click',sort_question);
	
	$('.pagination ul li').live('click',switch_page);
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
	var pagena_num = 10;
	
	var url = $('#base').val() + 'question_pool_request/sorted_question_request/';
	var post_str = 'index=' + index + '&sort_attr=' + sort_attr + '&sort_type=' + sort_type;
	
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}


function sort_question()
{
	var sort_attr = $(this).attr('id');
	var sort_type = 0;
	if($(this).hasClass('headerSortDown'))
	{
		sort_type = 1;
	}
	var url = $('#base').val() + 'question_pool_request/sorted_question_request/';
	var post_data = {'index':1,'sort_attr':sort_attr,'sort_type':sort_type};
	var effect_id = $('#content');
	var ul_obj = $('.pagination ul');
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var page_update = {'total_page_num':parseInt(ul_obj.attr('id')),'pagena_num':10,'lang':lang};
	table_sort({'url':url,'post_data':post_data,'sort_type':sort_type,'click_id':$(this),'effect_id':effect_id,'ul_obj':ul_obj,'page_update':page_update});
}




$(function(){
	$('.online_user_image').popover();
	$('.pagination ul li').live('click',switch_page);
	$('#header_question').addClass('active');
});

//switch page
function switch_page()
{
	var index = parseInt($(this).children().attr('id').split('_')[1]);
	var ul_obj = $(this).parent();
	if(index == $('.active',ul_obj).children().attr('id').split('_')[1])
	{
		return;
	}
	var total_page_num = parseInt(ul_obj.attr('id'));
	var tag_id = $('#tag_id').val();
	var lang = {'lang_first':$('.first a').html(),'lang_previous':$('.prev a').html(),'lang_next':$('.next a').html(),'lang_last':$('.last a').html()};
	var pagena_num = (total_page_num > 8) ? 8 : total_page_num;
	
	
	var url = $('#base').val() + 'question_pool/question4tag_request/';
	var post_str = 'index=' + index + '&tag_id=' + tag_id;
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		$('#content').html(html);
		pagenation_controller_update(ul_obj,{'index':index,'total':total_page_num,'pagena_num':pagena_num,'lang':lang});
	}};
	jQuery.ajax(ajax);
}
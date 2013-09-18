$(function(){
    
});


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
$(function(){
	$('#header_home').addClass('active');
	$('.online_user_image').popover();
	//translate_popout_effect();
        //translate toggle
        $('.translate_sw').live('click',function(){
            var id_name = $(this).attr('id')+"_area";
            $("#"+id_name).slideToggle("normal");
        });
});

/*function _ajax_translate_process(para_data)
{
	var arr = para_data['content'].split("#");
        
        var o_text = $('#'+arr[0]).html();
        var local_code = arr[1];
        var orign_code = arr[2];
        var node_id = arr[3];
        
        
	var post_str = 'text='+o_text+'&local_type='+local_code+'&orignal_type='+orign_code+'&nId='+node_id;
	var url =  para_data['url'];
        var ajax_info = {'url':url, 'type':'POST', 'dataType':'text', 'post_str':post_str};
	var options = {'effect_id':para_data['content_id']};
	
	var callback = function(html,option)
	{
		var effect_id = option['effect_id'] ? option['effect_id'] : '';
		
		if(effect_id)
		{
			$('#'+effect_id).html(html);
		}
	};
	
	_ajax_request(ajax_info,callback,options);
};


//
function _ajax_request(ajax_info,callback,options)
{
	    var url_str = ajax_info['url'];
	    var type_str = ajax_info['type'] ? ajax_info['type'] : 'POST';
	    var data_type_str = ajax_info['dataType'] ? ajax_info['dataType'] : 'text';
	    var post_string = ajax_info['post_str'];
	    
	    var ajax = {url: url_str, data:post_string, type: type_str, dataType: data_type_str, timeout: 15000, cache: false, success: function(html) {
               callback(html,options);
            }
        };
        jQuery.ajax(ajax);
};

function translate_popout_effect()
{
	$("a[rel=translate]").popover({
	  offset: 10,type:'ajax', base:$('#base').val(), url:$('#base').val()+"user_activity_process/activity_translate/",_fun:_ajax_translate_process
	    }).click(function(e) {
	         e.preventDefault()
	    }); 
}*/

function question_ask_process(options)
{
	$('#'+options['submit_id']).click(function(){
            //$('#'+options['submit_id']).button('loading');
            var text = $('#'+options['text_id']).val();
            var tags = $('#'+options['tag_id']).val();
            var expert_id_str = get_select_expert_id_str(options['expert_cname']);
            var url = options['base'];

            //send ajax request to finish the question asking event
            para_data = {'text':text,'tags':tags,'expert_id':expert_id_str,'submit_id':options['submit_id'],'finish_tips':options['finish_tips'],'url':url};
            _ajax_submit_question(para_data);
        });
};

//
function _ajax_submit_question(para_data)
{
	var post_str = 'text='+para_data['text']+'&tags='+para_data['tags']+'&expert_id='+para_data['expert_id'];
	var url = para_data['url'] + 'content_submit_process/question_send/';
        var ajax_info = {'url':url, 'type':'POST', 'dataType':'text', 'post_str':post_str};
	var options = {'effect_id':para_data['submit_id'],'finish_tips':para_data['finish_tips'],'base_url':para_data['url']};
	
	var callback = function(html,option)
	{
		var effect_id = option['effect_id'] ? option['effect_id'] : '';
		
		if(effect_id)
		{
		    effect_id = '#'+effect_id;	
                    //$(effect_id).button('reset');
                    if(!isNaN(html))
                    {
                        var node_id = parseInt(html);
                        alert(options['finish_tips']);
                        window.location.href = option['base_url'] + "question/" + node_id;
                    }
                    else
                    {
                        alert(html);
                    }
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

//
function get_select_expert_id_str(check_name)
{
        var ret_arr = new Array();
        $("input[name="+check_name+"]").each(function(){
                if($(this).attr("checked"))
                { 
                        ret_arr.push($(this).val().split('_')[1]);
                }
        });
        return ret_arr.join(',');

}
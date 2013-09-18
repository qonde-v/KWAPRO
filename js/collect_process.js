window.onload = content_collect({'content_id':"main_body",'collect_contrl_id':"collect_contrl"});

function content_collect(options)
{
		    var content_id = options['content_id'];
		    var collect_contrl_id = options['collect_contrl_id'];
			
		    var content = document.getElementById(content_id);
		    var collect = document.getElementById(collect_contrl_id);
		    
		    select(content, function(txt, tar, mouseP){
		        collect.style.left = mouseP.x + 1 + "px";
		        collect.style.top = mouseP.y + "px";
		        collect.style.display = "block";
		        share(collect, {title: txt,contrl_id:collect_contrl_id});
		    }, function(){
		        collect.style.display = "none";
		    });
}

function select(o, fn1, fn2){
    o.onmouseup = function(e){
        var event = window.event || e;
        var target = event.srcElement ? event.srcElement : event.target;
        if (/input|textarea/i.test(target.tagName) && /firefox/i.test(navigator.userAgent)) {
            var staIndex = target.selectionStart;
            var endIndex = target.selectionEnd;
            if (staIndex != endIndex) {
                var sText = target.value.substring(staIndex, endIndex);
                var mouseP = {
                    x: event.clientX,
                    y: event.clientY + window.pageYOffset
                };
                fn1(sText, target, mouseP);
            }
            else {
                fn2 == undefined ? "" : fn2();
            }
        }
        else {
            var sText = document.selection == undefined ? document.getSelection().toString() : document.selection.createRange().text;
            if (sText != "") {
                var mouseP = {
                    x: event.clientX,
                    y: event.clientY + (window.pageYOffset ? window.pageYOffset : document.documentElement.scrollTop)
                };
                fn1(sText, target, mouseP);
            }
            else {
                fn2 == undefined ? "" : fn2();
            }
        }
        return false;
    }
}

function share(o, opt, fea){
	var title =  opt.title ? opt.title : document.title;
        var collect_contrl_id = opt.contrl_id ? opt.contrl_id : "main_body";
        o.onclick = function(e)
        {            
            var base_url = $('#base').val();
            var subject = $('#note_subject').val();
            content_collect_process({'text':title, 'contrl_id':collect_contrl_id , 'base_url':base_url,'subject':subject});
            return false;
        }
}

function content_collect_process(para_data)
{
    var content = para_data['text'] + '('+para_data['base_url']+ 'question/' + para_data['subject'].split('_')[1]+')';
    content = encodeURI(content);
    var post_str = 'content='+content+'&tags=&subject='+para_data['subject'];
	var url = para_data['base_url'] + 'notes/note_store/';
        var ajax_info = {'url':url, 'type':'POST', 'dataType':'text', 'post_str':post_str};
	var options = {'contrl_id':para_data['contrl_id']};
	
	var callback = function(html,option)
	{
             $('#'+option['contrl_id']).css('display','none');
             if(html != "")
             {
                 //alert(html.split('##')[0]);
				 $('#msg_modal .modal-body').html(html.split('##')[0]);
				 $('#msg_modal').show();
             }
	};
	
	_ajax_request(ajax_info,callback,options);
}

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

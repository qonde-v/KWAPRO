window.onload = drag_effect_init({text_val_id:'select_text_id',main_id:'main_body'});

$(function(){
    $('#note_update').click(function(){
       note_update_process(); 
    });
});


function drag_effect_init(options)
{
		
         var main_id = options['main_id'];//content
         var text_val_id = options['text_val_id'];//select_text_id
		  	
       	 var obj = document.getElementById(main_id);
       	 select(obj,text_val_id);
       	        	 		 
         function drag_over(ev)
         {
                    if (!ev) ev = window.event;
                    ev.returnValue = false;
                    $("#drop_box").css('fontSize','1.5em');
                    $('#drag_val').html('over');
                    return false;
         }


         function drag_leave(ev)
         {
               if (!ev) ev = window.event;
            	//$("#drop_box").animate({fontSize:"1em"},"fast");
            	ev.returnValue = false;
            	$("#drop_box").css('fontSize','1em');
            	$('#drag_val').html('leave');
            	return false;
        }
		 
         function move2end(obj)    
         {    
                        var length = obj.value.length ;  //   

                    if(obj.createTextRange)          //IE下    
                    {    
                        var r = obj.createTextRange();      
                        r.moveStart("character",length);    
                        r.collapse(true);      
                        r.select();      
                    }    
                    else                                    //火狐下    
                    {    
                        obj.focus();    
                        obj.setSelectionRange(length,length);    
                    }    
         } 
			  		  
         function drag_end(ev)
         {
                        //alert("end");
                        var val = $("#select_text_id").val();
                        var event_type = $('#drag_val').html();
                        ev.returnValue = false;
                if(val && (event_type == 'over'))
                {
                        $("#drop_box").animate({fontSize:"1.5em"},"fast",'',function(){
                                var note_text_num = parseInt($('#note_text_num').val());
                                var note_text = $('#drop_box').val();
                                var new_text = '('+note_text_num+') '+val+'\n';
                                
                                $('#drop_box').val(note_text+new_text);
                                $('#note_text_num').val(note_text_num+1);
                                $("#drop_box").animate({fontSize:"1em"},"fast");
                                $("#select_text_id").val('');
                                move2end(document.getElementById("drop_box"));
                        });
                }
                else
                {
                        $("#drop_box").animate({fontSize:"1em"},"fast");
                }
                $('#drag_val').html('leave');
                return false;
         }
		 		 
         var p_obj = document.getElementById("drop_box");
         p_obj.ondragleave = drag_leave;
         p_obj.ondragover = drag_over;		 
         obj.ondragend = drag_end;
}

function select(o,text_val_id){
    o.onmouseup = function(e){
        var event = window.event || e;
        var target = event.srcElement ? event.srcElement : event.target;
        if (/input|textarea/i.test(target.tagName) && /firefox/i.test(navigator.userAgent)) 
        {
            //Firefox在文本框内选择文字
            var staIndex = target.selectionStart;
            var endIndex = target.selectionEnd;
            
            if (staIndex != endIndex) 
            {
                var sText = target.value.substring(staIndex, endIndex);
                document.getElementById(text_val_id).value = sText;
            }
            
        }
        else 
        {
            //获取选中文字
            var sText = document.selection == undefined ? document.getSelection().toString() : document.selection.createRange().text;
            if (sText != "") 
            {
                document.getElementById(text_val_id).value = sText;
            }
            
        }
        return false;
    }
}


/*********************************************************Note text process*******************************************************************/
String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");};

function note_sync(ev)
{
	if($('#drop_box').val().trim())
	{
        return $('#note_save_tips').val();
	}
}

function note_update_process()
{
    if($('#drop_box').val().trim())
	{
         var text = $('#drop_box').val();
         var base_url = $('#base').val();
         var subject = $('#note_subject').val();
         content_collect_process({'text':text, 'base_url':base_url,'subject':subject});
	}
}


function content_collect_process(para_data)
{
    var content = para_data['text']; //+ '('+para_data['base_url']+ 'question/' + para_data['subject'].split('_')[1]+')';
    content = encodeURI(content);
    var post_str = 'content='+content+'&tags=&subject='+para_data['subject'];
	var url = para_data['base_url'] + 'notes/note_store/';
    var ajax_info = {'url':url, 'type':'POST', 'dataType':'text', 'post_str':post_str};
	var options = {};
	
	var callback = function(html,option)
	{
             if(html != "")
             {
                 //alert(html.split('##')[0]);
				 $('#msg_modal .modal-body').html(html.split('##')[0]);
				 $('#msg_modal').show();
                 $('#drop_box').val('');
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
















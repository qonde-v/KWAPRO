$(function(){
        String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");};
	$('#header_setting').addClass('active');
	$('#place_setting_modal').width('auto');
	$('.tabs').tabs();
	$('.online_user_image').popover();

	var day_name_str = $('#day_name_str').val();
	var day_name = day_name_str.split(",");
	var month_name_str = $('#month_name_str').val();
	var month_name = month_name_str.split(",");
	//$("#birthday").datepicker({changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd',dayNamesMin:day_name,monthNamesShort:month_name,prevText:'',nextText:''});
	$('#birthday').live('focus',function(){
		$("#birthday").datepicker({changeMonth:true, changeYear:true, dateFormat:'yy-mm-dd',dayNamesMin:day_name,monthNamesShort:month_name,prevText:'',nextText:''});
	});
	
	$('#country').click(show_province);
	$('#province').click(show_city);
	$('#city').click(show_town);
	
	$("#place_setting").click(function() {
		$('#place_setting_modal').removeClass('hide');
	});

	$('#province').dblclick(function(){
		$('#place_setting').val($('#province option:selected').html());
		$('#place_setting_modal').modal('hide');
		$('#location_code').val($('#country option:selected').attr('id')+'|'+$('#province option:selected').attr('id'));
	});
	$('#city').dblclick(function(){
		$('#place_setting').val($('#city option:selected').html());
		$('#place_setting_modal').modal('hide');
		$('#location_code').val($('#country option:selected').attr('id')+'|'+$('#province option:selected').attr('id')+'|'+$('#city option:selected').attr('id'));
	});
	$('#town').dblclick(function(){
		$('#place_setting').val($('#town option:selected').html());
		$('#place_setting_modal').modal('hide');
		$('#location_code').val($('#country option:selected').attr('id')+'|'+$('#province option:selected').attr('id')+'|'+$('#city option:selected').attr('id')+'|'+$('#town option:selected').attr('id'));
	});
	
	$("#user_photo").change(function(){
         ajaxUpload(this.form,$('#base').val()+'settings_request/photo_upload/', 'original_photo',$('#upload_wait').val(),upload_succ);
		 $('#upload_avatar_modal').removeClass('hide');		 
     });
	 
	 $("#crop_photo").click(function() {  
        var x1 = $("#x1").val();  
        var y1 = $("#y1").val();  
        var x2 = $("#x2").val();  
        var y2 = $("#y2").val();  
        var w = $("#w").val();  
        var h = $("#h").val();  
        if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h==""){  
            alert("You must make a selection first");  
            return false;  
        }else{  
            return true;  
        }  
    }); 
	 
	 //$("#original_photo").imgAreaSelect({ aspectRatio: "1:1", onSelectChange: preview });
	 
	$('#tag_area span').live({
	 	mouseenter:function(){$(this).children(1).attr('src',$('#base').val()+'img/delete1.png');},
		mouseleave:function(){$(this).children(1).attr('src',$('#base').val()+'img/delete0.png');}});
	$('#tag_area span').live('click',function(){$(this).remove();});
		
	$("#tags_one").click(show_subcate);
	$('#tags_two').click(show_tags);
	$("#tags_three").dblclick(dbclick_add_tag);
});

$(window).load(function () {  
    $("#original_photo").imgAreaSelect({ aspectRatio: "1:1", onSelectChange: preview });  
}); 

function basic_info_save()
{
	var save_btn_id = $('#basic_save_btn');
	save_btn_id.button('loading');
	var data = basic_info_retrieve();
	var url = $('#base').val() + 'settings_request/basic/';
	var send_str = generate_query_str(data);
        var callback = function(){
            window.location.reload();
        };
        
	ajax_profile_save(url,send_str,save_btn_id,callback);
}

function basic_info_retrieve()
{
	var data = new Array();
	data['gender'] = $('#gender').attr('checked') ? 1 : 0;
	data['birthday'] = $('#birthday').val();
	data['language_code'] = $('#Language').val();
	data['location'] = $('#location_code').val();
	data['old_password'] = $('#old_password').val();
  	data['new_password'] = $('#new_password').val();
  	data['new_passwordc'] = $('#new_passwordc').val();
  	return data;
}

function tag_info_save()
{
	var save_btn_id = $('#tag_save_btn');
	save_btn_id.button('loading');
	var data = tag_info_retrieve();
	var url = $('#base').val() + 'settings_request/advance/';
	var send_str = generate_query_str(data);
	ajax_profile_save(url,send_str,save_btn_id);
}

function tag_info_retrieve()
{
	var data = new Array();
	data['language_code'] = $('#Language').val();
	data['tags'] = generate_tag_setting_str($('.select_tag_name'));
	return data;
}

function interact_data_save()
{
	var save_btn_id = $('#interact_save_btn');
	save_btn_id.button('loading');
	var data = interact_data_retrieve();
	var url = $('#base').val()+"settings_request/interact";
	var send_str = generate_query_str(data);
	ajax_profile_save(url,send_str,save_btn_id);
}

function interact_data_retrieve()
{
	var data = new Array();
	var method_text_arr = ['email','gtalk','msn','sms','qq'];
	var method_obj = document.getElementsByName("interact_method");
	
	for(var key in method_text_arr)
	{
		var method_text = method_text_arr[key];
		
		if(document.getElementById(method_text))
		{
			data[method_text] = $('#'+method_text).val();
		}
		
		if(method_obj[key] && method_obj[key].checked)
		{
			data['selected_method_id'] = method_obj[key].value;
		}
	}
	return data;
}

function privacy_data_save()
{
	var save_btn_id = $('#privacy_save_btn');
	save_btn_id.button('loading');
	var data = privacy_data_retrieve();
	var url = $('#base').val()+"settings_request/privacy";
	var send_str = generate_query_str(data);
	ajax_profile_save(url,send_str,save_btn_id);
}

function privacy_data_retrieve()
{
   var data = new Array();
   var method_text_arr = ['gender','birthday','location','Email','Gtalk','SMS','QQ','MSN'];
   
   for(var key in method_text_arr)
   {
      var method_text = method_text_arr[key];
	  var method_visible  = method_text + "_visible";
	  
	  if(document.getElementById(method_visible))
	  {
	    data[method_visible] = document.getElementById(method_visible).checked ? 1:0;
	  }
   }
   return data;
}

function generate_tag_setting_str(obj)
{
	if(obj.length == 0)
	{
	  	return "";
	}
	
	var str = "";
	for(var i=0; i<obj.length-1; i++)
	{
	  	str += obj[i].id + "_" + obj[i].innerHTML + "|";
	}
	str += obj[obj.length-1].id + "_" + obj[obj.length-1].innerHTML;
	
	return str;
}

function show_province()
{
	$('#province').empty();
	$('#city').empty();
	$('#town').empty();
	var code = $('#country option:selected').attr('id');
	var type = 'province';
	var attr = 'country';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#province');
	ajax_location_data(post_str,effect_id);
}

function show_city()
{
	$('#city').empty();
	$('#town').empty();
	var code = $('#province option:selected').attr('id');
	var type = 'city';
	var attr = 'province';
	var post_str = 'code='+code+'&type='+type+'&attr='+attr;
	var effect_id = $('#city');
	ajax_location_data(post_str,effect_id);
}

function show_town()
{
	$('#town').empty();
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
		if(html.trim() != '')
		{
			var arr = html.split('@');
			for(var key in arr)
			{
				var location_data = arr[key].split('#');
				var option_html = "<option id='"+location_data[0]+"'>"+location_data[1]+"</option>";
				effect_id.prepend(option_html);
			}
		}
	}};
	jQuery.ajax(ajax);
}

function ajax_profile_save(url,post_str,btn_id,callback)
{
	var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		btn_id.button('reset');
                $('#msg_modal .modal-body').html(html);
		$('#msg_modal').modal('show');
                
                if(typeof(callback) == 'function')
                {
                    callback();
                }
		
	}};
	jQuery.ajax(ajax);
}

function show_subcate()
{
	$("#tags_three").empty();
	$('#tag_input').hide();
	$('#search_subcate').val("");
	$('#search_tag').val("");
	var category_name = $('#tags_one option:selected').text();
	$('#cate_name').html(category_name);
	var url = $('#base').val()+"settings_request/get_subcate_by_cate_id/";
	var post_str = "langCode="+$("#Language").val()+"&category_id="+$("#tags_one").val();
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
		var option_two_html = '';
		var arr = html.split('@');
		for(var key in arr)
		{
			var subcate = arr[key].split('#');
			option_two_html += "<option class='tag_add_list_two' value='"+ subcate[2] +"_" + subcate[0] +"'>"+ subcate[1] +"</option>";
		}
		$("#tags_two").html(option_two_html);
	}};
	jQuery.ajax(ajax);
}

function show_tags()
{
	$('#search_tag').val("");
	var url = $('#base').val()+"settings_request/get_tag_by_sub_cate/";
	var arr = $("#tags_two option:selected").val().split("_");
	var category_id = arr[0];
	var sub_cate_id = arr[1];
	var sub_cate_name = $("#tags_two option:selected").text();
	$('#tag_name').html(sub_cate_name);
	var post_str = "langCode="+$("#Language").val()+"&subcate_id="+sub_cate_id;	   		
		
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
		var option_three_html = '';
		if(html != '')
		{
			var tag_arr = html.split('@');
			for(var key in tag_arr)
			{
				var tag_data = tag_arr[key].split('#');
				option_three_html += "<option class='tag_add_list_three' value='" + category_id + "_" + sub_cate_id + "_" + tag_data[0] +"'>"+ tag_data[1] +"</option>";
			}
		}	
		$("#tags_three").html(option_three_html);
	}};
	jQuery.ajax(ajax);
}

function dbclick_add_tag()
{
	var id_str = $("#tags_three option:selected").val();
	var tag_name = $("#tags_three option:selected").text();
	if(check_tag_exist(id_str))
	{
		$('#msg_modal .modal-body').html($('#tag_add_prompt').val());
		$('#msg_modal').modal('show');
	}
	else
	{
		$('#tag_area').append("<span><span class='select_tag_name' id='" + id_str + "' >" + tag_name + "</span><img class='tag_delete' src='"+$('#base').val()+'img/delete0.png'+"' /></span>");
	}
}

function check_tag_exist(id_str)
{
	if(document.getElementById(id_str) != null)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function search_category()
{
	$("#tags_two").empty();
	$("#tags_three").empty();
	var search_text = $('#search_cate').val();
	var url = $('#base').val()+"settings_request/search_category/";
	var post_str = "langCode="+$("#Language").val()+"&text="+search_text;	   		
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html)
	{
		var option_html = '';
		if(html != '')
		{	
			var arr = html.split('@');
			for(var key in arr)
			{
				var category = arr[key].split('#');
				option_html += "<option class='tag_add_list_one' value='" + category[0] +"'>"+ category[1] +"</option>";
			}	
		}
		$("#tags_one").html(option_html);
	}};
	jQuery.ajax(ajax);
}

function search_sub_cate()
{
	$("#tags_three").empty();
	var category_id = $("#tags_one option:selected").val();
	var search_text = $('#search_subcate').val();
	var url = $('#base').val()+"settings_request/search_sub_cate/";
	var post_str = "langCode="+$("#Language").val()+"&text="+search_text+"&category_id="+category_id;	   		
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html)
	{
		var option_html = '';
		if(html != '')
		{
			var arr = html.split('@');
			for(var key in arr)
			{
				var subcate = arr[key].split('#');
				option_html += "<option class='tag_add_list_two' value='"+ category_id+"_" + subcate[0] +"'>"+ subcate[1] +"</option>"
			}
		}
		$("#tags_two").html(option_html);
	}};
	jQuery.ajax(ajax);
}

function search_tags()
{
	var url = $('#base').val()+"settings_request/search_tag/";
	var search_text = $('#search_tag').val();
	var category_id = $("#tags_two option:selected").val().split("_")[0];
	var sub_cate_id = $("#tags_two option:selected").val().split("_")[1];
	var post_str = "langCode="+$("#Language").val()+"&text="+search_text+"&subcate_id="+sub_cate_id;	
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html)
	{
		var option_html = '';
		if(html != '')
		{
			var arr = html.split('@');
			for(var key in arr)
			{
				var tag = arr[key].split('#');
		   		option_html += "<option class='tag_add_list_three' value='" + category_id + "_" + sub_cate_id + "_" + tag[0] +"'>"+ tag[1] +"</option>";
         	}
		}
		$("#tags_three").html(option_html);
	}};
	jQuery.ajax(ajax);
}

function add_sub_cate()
{
	if($("#tags_one option:selected").length == 0)
	{
		$('#msg_modal .modal-body').html($('#select_cate').val());
		$('#msg_modal').modal('show');
	}
	else
    {
		$("#sub_cate_input").toggle();
      	$("#sub_cate_input_area").keydown(function(event)
		{
			if(event.keyCode == 13)
			{
				var sub_cate_name = $("#sub_cate_input_area").val();
				$("#sub_cate_input_area").val("");	
				if(tag_valid_check(sub_cate_name))
				{ 						 						
					var url = $('#base').val()+"settings_request/subcate_add_process/";
					var post_str = "langCode="+$("#Language").val()+"&value="+sub_cate_name+"&category_id="+$("#tags_one option:selected").val();
					var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html)
					{
						var html_arr = html.split('##');
						if(html_arr.length > 1)
						{
							$('#msg_modal .modal-body').html(html_arr[1]);
							$('#msg_modal').modal('show');
						}
						else
						{
							$('#tags_two').prepend("<option class='tag_add_list_two' id='" + html.split('_')[1] + "' value='"+ html +"'>"+ sub_cate_name +"</option>");
						}
					}};
					jQuery.ajax(ajax);     						
				}
				else
				{
					$('#msg_modal .modal-body').html($('#name_unvalid').val());
					$('#msg_modal').modal('show');
				}
				return false;
			}
		});
	}
}

function addtag()
{
 	if($("#tags_one option:selected").length == 0 || $("#tags_two option:selected").length == 0)
 	{
 		$('#msg_modal .modal-body').html($('#select_subcate').val());
		$('#msg_modal').modal('show');
	}
	else
	{
 		$("#tag_input").toggle();
 		$("#tag_input_area").keydown(function(event)
 		{
			if(event.keyCode == 13)
			{
				var tag_name = $("#tag_input_area").val();
				$("#tag_input_area").val("");	
				if(tag_valid_check(tag_name))
				{ 						 						
					$('#tag_area').append("<span><span class='select_tag_name' id='" + $("#tags_two option:selected").val() + "_0" + "'>" + tag_name + "</span><img class='tag_delete' src='"+$('#base').val()+'img/delete0.png'+"' /></span>");
					$('#tags_three').prepend("<option class='tag_add_list_three' value='" + $("#tags_two option:selected").val() + "_0" + "'>"+ tag_name +"</option>");
				}
				else
				{
					$('#msg_modal .modal-body').html($('#name_unvalid').val());
					$('#msg_modal').modal('show');
				}
				return false;
			}
		});
 	}
}

function generate_query_str(data)
{
   	var str = "";
   	for(var key in data)
   	{
      	str += key + "="+ data[key]+"&";
   	}
   	return str.substring(0,str.length-1);  
}

function tag_valid_check(tag)
{
	var bool_en = en_tag_check(tag);
	var bool_zh = chinese_tag_check(tag);
	return bool_en || bool_zh;
};
	   
function en_tag_check(value)
{
	var spefic_token_arr = ['C++','C#','A+','F#','J#','PL/I','TCP/IP','Tcl/Tk']; 
	var tag_pattern = RegExp("^[A-Za-z0-9]+$");  
	if(value.match(tag_pattern))
	{
		return true;
	}
	else
	{
		if(!duplicate_check(value,spefic_token_arr))
		{
			return true;
		}
		else
		{  
			return false;
		}
	}
}
	   
function chinese_tag_check(tag)
{
	if(tag.match(/^[\w\u4E00-\u9FFF]+$/))
	{
		return true;
	}
	else
	{
		return false;
	}
}
	   
function duplicate_check(tag,data_arr)
{
	tag = tag.toUpperCase(); 
	var count_arr = new Array();
			  
	for(var i=0; i<data_arr.length; i++)
	{
		if(data_arr[i].toUpperCase() == tag)
		{
			return false;
		}
	}
	return true;
}

function preview(img, selection) 
{  
    var scaleX = 100 / selection.width;  
    var scaleY = 100 / selection.height;   
  
    $("#crop_photo").css({  
        width: Math.round(scaleX * $('#original_img').width()) + "px",  
        height: Math.round(scaleY * $('#original_img').height()) + "px",  
        marginLeft: "-" + Math.round(scaleX * selection.x1) + "px",  
        marginTop: "-" + Math.round(scaleY * selection.y1) + "px"  
    });  
	$('.imgareaselect-outer').css('z-index',11001);
	$('.imgareaselect-selection').css('z-index',11001);
	$('.imgareaselect-border1').css('z-index',11001);
	$('.imgareaselect-border2').css('z-index',11001);
    $("#x1").val(selection.x1);  
    $("#y1").val(selection.y1);  
    $("#x2").val(selection.x2);  
    $("#y2").val(selection.y2);  
    $("#w").val(selection.width);  
    $("#h").val(selection.height);  
} 

function upload_succ()
{
	var src = document.getElementById("original_img").src;
	//var src = $('#original_img').attr('src');
	$('#crop_photo').attr('src',src);
	$("#original_img").imgAreaSelect({ aspectRatio: "1:1", onSelectChange: preview });
}

function crop_img_close()
{
	$('#upload_avatar_modal').hide();
	$('.imgareaselect-outer').hide();
	$('.imgareaselect-selection').hide();
	$('.imgareaselect-border1').hide();
	$('.imgareaselect-border2').hide();
	var src = $('#crop_photo').attr('src');
	var filename = src.substr(src.lastIndexOf("/")+1);
	delete_temp_img(filename);
}

function delete_temp_img(filename)
{
	$('#crop_photo').removeAttr('src');
	var post_str = 'filename='+filename;
	var url = $('#base').val() + 'settings_request/temp_photo_delete';
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){}};
	jQuery.ajax(ajax);
}

function save_thumb()
{
	var x1 = $("#x1").val(); 
    var y1 = $("#y1").val();  
    var x2 = $("#x2").val();  
    var y2 = $("#y2").val();  
    var w = $("#w").val();  
    var h = $("#h").val(); 
	if(x1=="" || y1=="" || x2=="" || y2=="" || w=="" || h=="")
	{  
		alert($('#select_first').val());
		return false;  
	}
	else
	{
		$('#save_thumb').button('loading');
		var src = $('#crop_photo').attr('src');
		var filename = src.substr(src.lastIndexOf("/")+1);
		var post_str = 'w='+w+'&h='+h+'&x1='+x1+'&y1='+y1+'&filename='+filename;
		var url = $('#base').val() + 'settings_request/save_thumb';
		var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
			var arr = html.split('##');
			$('#save_thumb').button('reset');
			$('#user_img').attr('src',arr[0]);
			$('#userinfo_avatar').attr('src',arr[0]);
			crop_img_close();
			$('#msg_modal .modal-body').html(arr[1]);
			$('#msg_modal').modal('show');
		}};
		jQuery.ajax(ajax);
	} 
}


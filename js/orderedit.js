$(function(){
	$('#policyTime').datepicker();
	$('#signTime').datepicker();
	$('#policyTime').datepicker().on('changeDate',function(e){
		$('#policyTime').datepicker('hide');
	});
	$('#signTime').datepicker().on('changeDate',function(e){
		$('#signTime').datepicker('hide');
	});
	$('#car_addtime').datepicker().on('changeDate',function(e){
		$('#car_addtime').datepicker('hide');
	});
			$('#EnrollDate').datepicker();
			$('#EnrollDate').datepicker().on('changeDate',function(e){
				$('#EnrollDate').datepicker('hide');
			});
});
function delete_picture(key,id){
	url = $('#header_base').val() + 'admin/news/delete_picture?key=' + key+'&id=' + id;
	var ajax = { url: url,  type: 'POST', dataType: 'html', cache: false, success: function (html){
        $("#related_picture").html(html);
        var file = document.getElementById("picture_file");
		if (file.outerHTML) { // for IE, Opera, Safari, Chrome
			file.outerHTML = file.outerHTML;
		}
		$("#picture_file").val("");
		uploading = false;
		},error:function(){
		        //alert("网站页面错误!");
		}};
		jQuery.ajax(ajax);
}
var uploading = false;

function upload_picture(){
	if(uploading)return false;
	if($("#picture_file").val()==""){
		alert('请先选择要上传的文件!');
		return false;
	}
/*
	if($("#picture_num").val()>2){
		alert("一个订单最多上传3张图片!");
		return false;
	}
*/	

	$('#upload_tips').show();
	uploading = true;
	$('#upload_picture_form').ajaxForm(function() { 
		$('#upload_tips').hide();
	        //alert("Thank you for your comment!"); 
		var post_str = "id=" + $("#id").val();
		var url = $('#header_base').val() + 'admin/news/get_picture';
		var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html){
		        $("#related_picture").html(html);
		        var file = document.getElementById("picture_file");
				if (file.outerHTML) { // for IE, Opera, Safari, Chrome
					file.outerHTML = file.outerHTML;
				}
				$("#picture_file").val("");
				uploading = false;
		},error:function(){
		        //alert("网站页面错误!");
		}};
		jQuery.ajax(ajax);
	
	}); 
}



var fileSize = 0;

function fileChange(target) {
	if ($("#picture_file").val() == "")
		return false;
	
	var file=$("#picture_file").val();
	var filename=file.replace(/.*(\/|\\)/, "");
	var extension=(/[.]/.exec(filename)) ? /[^.]+$/.exec(filename.toLowerCase()) : '';
	if(!(extension=="jpg" || extension=="png" || extension=="gif" || extension=="jpeg")){
		alert("仅支持jpg,png,gif格式的图片!");
		var file = document.getElementById("picture_file");
		if (file.outerHTML) { // for IE, Opera, Safari, Chrome
			file.outerHTML = file.outerHTML;
		}
		$("#picture_file").val("");
		return false;
	}
	
	var isIE = /msie/i.test(navigator.userAgent) && !window.opera;

	if (isIE && !target.files) {
		var img = new Image();
		img.onload = checkSize;
		img.src = $("#picture_file").val();
	} else {
		fileSize = target.files[0].size;
		checkSize();
	}

}
function checkSize() {
	var isIE = /msie/i.test(navigator.userAgent) && !window.opera;
	if (isIE) {
		fileSize = this.fileSize;
	}

	var size = fileSize / 1024;
	if (size > 2000) {
		alert("上传的图片不能大于2M!");
		var file = document.getElementById("picture_file");
		if (file.outerHTML) { // for IE, Opera, Safari, Chrome
			file.outerHTML = file.outerHTML;
		}
		$("#picture_file").val("");
	}
}


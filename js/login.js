$(function(){
	$('#login_username').keydown(function(event){
		if(event.keyCode == 13)
		{
			login_process();
		}
	});
	$('#login_pswd').keydown(function(event){
		if(event.keyCode == 13)
		{
			login_process();
		}
	});
});

function login_process()
{
	$('#login_msg_modal .modal-body').html('<img width="40px" height="40px" style="vertical-align:middle;" src="'+$('#header_base').val()+'img/jindu.gif">'+$('#login_wait').val());
	$('#login_msg_modal').removeClass("hide");
	$('#login_modal_bg').removeClass("hide");
	$('.modal-header').hide();
	$('.modal-footer').hide();
	hideLoginModal();
	var username = $('#login_username').val();
	var password = $('#login_pswd').val();
	var url = $('#header_base').val() + 'login/';
	var post_str = 'username=' + username + '&password=' + password;
	var ajax = { url: url, data: post_str, type: 'POST', dataType: 'html', cache: false, success: function (html)
	{
		if(html == 'login_success')
		{
			window.location.href = $('#header_base').val() + "home/";
		}
		else
		{
			$('#login_msg_modal .modal-body').html(html);
			$('.modal-header').show();
			$('.modal-footer').show();
		}
	}};
	jQuery.ajax(ajax);
}
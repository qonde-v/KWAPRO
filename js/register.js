$(function(){
	$('#username').live('focus',function(){$('#username_suggestion').show();});
	$('#username').live('blur',function(){$('#username_suggestion').hide();});
	
	$('#password').live('focus',function(){$('#pswd_suggestion').show();});
	$('#password').live('blur',function(){$('#pswd_suggestion').hide();});

	$('#passwordc').live('blur',function(){
		if($('#password').val()!=$('#passwordc').val())$('#pswdc_suggestion').show();
		else $('#pswdc_suggestion').hide();
	});
});
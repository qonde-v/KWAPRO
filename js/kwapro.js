$(function(){	
	
	
	$(".question_content_img").bind('mouseover',function(){
	var pos = $(this).offset();
	var t = pos.top -  120; // 弹出框的上边位置
	var l = pos.left  + 10;  // 弹出框的左边位置
	$("#search_details_img").attr("src",$(this).children($("img")).attr("src"));
	$(".result_item_right").html($(this).parents().find($(".question_content_hidden")).html());
	$("#details").css({ "top": t, "left": l }).show();
	});
	
	//$(".search_result_image").css("height",$(".search_result_image").width());
	$(".search_result_image").height($(".search_result_image").width());
	$(".userinfo_image").height($(".userinfo_image").width());
	$(".question_content_more").bind('mouseover',function(){
	$(this).css("background-color","#ffffff");
	}).bind('mouseleave',function(){
	$(this).css("background-color","#f3f3f3");
	});
	
	$(".q_tags").add($(".question_content_middle")).add($(".hot_question")).add($(".q_view")).add($(".form_right")).bind('mouseover',function(){
	$("#details").hide();
	});

	$(".question_content_href").bind('mouseover',function(){
	$(this).css("background-color","#e2e2e2");
	}).bind('mouseleave',function(){
	$(this).css("background-color","#f2f2f2");
	});

	$("#question_answer").toggle(function(){
	$("#answer_form").hide();
	},function(){
	$("#answer_form").show();
	});

    $("#headnav>ul>li").bind('mouseover',function() // 顶级菜单项的鼠标移入操作 
    { 
      var ulNode = $(this).next("ul"); 
      $(this).children('a').css("border-top","1px solid #cecece").css("border-left","1px solid #cecece").css("border-right","1px solid #cecece").css("background-color","#f1f1f1");
      $(this).children('ul').slideDown();

    }).bind('mouseleave',function() // 顶级菜单项的鼠标移出操作 
    { 
    	
      $(this).children('ul').slideUp();
      $(this).children('a').css("border-top","1px solid #fff").css("border-left","1px solid #fff").css("border-right","1px solid #fff").css("background-color","#ffffff");
    });


});
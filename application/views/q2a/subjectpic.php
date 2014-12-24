	<script>
	$(document).ready(function() {
		$(".theme-pic li a").click(function(){
			//var li = $(this).parent();
			if(!$(this).hasClass("active")){
				$(".theme-pic li a.active").removeClass("active");
				$(this).addClass("active");
				$('#viewer').attr('src',$(this).find('img').attr('src'));
				$('#picid').val($(this).parent().index()+1);
			}
		});
	});
	function savepic(tt){
		var url = $('#base').val() + 'profile/savepic/';
		var post_str = 'subpic='+tt;
		var ajax = {url:url, data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
			//setTimeout("window.location.reload()",100);
			$('#picview').hide();
			window.location.reload();
		}};
		jQuery.ajax(ajax);
	}
	</script>
  	<div class="modal hide" id="picview">
    	<div class="modal-dialog">
        	<div class="modal-head">修改个人主题插图</div>
            <div class="modal-body">
            	<div class="modal-content">
                	<div class="col-6">
                    	<h5>选择个人主题插图</h5>
                        <ul class="theme-pic">
                        	<li><a><img src="<?php echo $base.'img/xiugai_x_01.png';?>" /></a><span>攀峰</span></li>
                            <li><a><img src="<?php echo $base.'img/xiugai_x_02.png';?>" /></a><span>挑战</span></li>
                            <li><a><img src="<?php echo $base.'img/xiugai_x_03.png';?>" /></a><span>滑板</span></li>
                            <li><a><img src="<?php echo $base.'img/xiugai_x_04.png';?>" /></a><span>温馨</span></li>
                        </ul>
                    </div>
                    <div class="col-6">
                    	<div class="pic-view">
                            <p>选择你喜欢的个人插图，彰显自己的个性</p>
                            <p>预览窗口</p>
                            <img src="<?php echo $base.'img/grkj_p_top.png';?>" id="viewer" />
                            <div class="btns">
								<input type="hidden" id="picid" value="<?php echo $user_info['subpic']; ?>">
                            	<a href="javascript:;" onclick="javascript:savepic($('#picid').val());" class="black">保存</a>
                            	<a href="javascript:;" onclick="$('#picview').addClass('hide');">取消</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="info">
    	<div class="left">
        	<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td rowspan="3" align="right"><img class="user-head" width="133px" height="133px" src="<?php echo $base.$user_info['headphoto_path'];?>"/></td>
                <td width="143px"><span class="user-name <?php if($user_info['gender']==1)echo 'male';else echo 'female';?>"><?php echo $user_info['username']; ?></span></td>
              </tr>
              <tr>
                <td><span class="user-edit"><a href="<?php echo $base.'profile/';?>">修改资料</a></span></td>
              </tr>
              <tr>
                <td><span class="user-edit-head"><a href="<?php echo $base.'profile/avatar';?>">修改头像</a></span></td>
              </tr>
              <tr>
                <td colspan="2">
                	<label class="tags">标签</label>
                    <ul class="tags-list">
						<!-- <?php foreach($hot_tags as $tag_item): ?>
						<li><a href="<?php echo $base.'question_pool/question4tag/'.$tag_item['tag_id'];?>"><?php echo $tag_item['tag_name'];?></a></li>
						<?php endforeach; ?> -->
						<?php $tagarr = explode(' ',trim($user_info['tag']));foreach($tagarr as $tag_item): ?>
                    	<li><a href="#"><?php echo $tag_item;?></a></li>
						<?php endforeach; ?>
                    </ul>
                </td>
              </tr>
              <tr>
                <td colspan="2"><label class="point">地点：<a href="#"><?php echo $user_info['location']['town_name']; ?></a></label></td>
              </tr>
              <tr>
                <td colspan="2"><label class="image"><a href="javascript:;" onclick="$('#picview').removeClass('hide');">修改个人主题插图</a></label></td>
              </tr>
              <tr>
                <td style="border-bottom-width:0; padding-top:5px; padding-right:5px;" align="right" colspan="2"><img src="<?php echo $base.'img/xtb_006.png';?>" /></td>
              </tr>
            </table>
        </div>
      <div class="right"><img src="<?php echo $base.'img/xiugai_d_0'.$user_info['subpic'].'.png';?>" /></div>
    </div>
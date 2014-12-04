 <div class="footer">
    <div class="pull-left">
      <p>地址：广州市海珠区新港中路397号</p>
      <p>备案/许可证编号为：粤ICP备11086295号-1</p>
      <p>Copyright © 2014 cntit.com.cn All Right Reserved</p>
    </div>
    <div class="pull-right">
        <ul class="share-list">
            <li>关注分享：</li>
            <li class="share share-xinlang active"></li>
            <li class="share share-facebook"></li>
            <li class="share share-weixin"></li>
            <li class="share share-qqweibo"></li>
            <li class="share share-twitter"></li>
        </ul>
        <p class="text-right">联系我们电话：86-20-84221810</p>
    </div>
  </div>

<input type="hidden" value="<?php echo $base;?>" id="header_base" />

<script type="text/javascript">
	function collection(id){
		var post_str = "material=" + id ;
		var url = $('#header_base').val() + 'material/col_material';
		var ajax = { url: url, data: post_str, type: 'POST', dataType: 'text', cache: false, async: false, success: function (data){
			alert(data);
		},error:function(){
			alert("收集失败!");
		}};
		jQuery.ajax(ajax);
	}
</script>
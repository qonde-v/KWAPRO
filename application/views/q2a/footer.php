<div id="main">
<div id="main_bottom">
<div id="main_bottom_top">
&nbsp;
</div><br>
<br>

<div id="main_bottom_l">
<img src="<?php echo $base.'img/lxwm_dot.png';?>" align="absmiddle" border="0"/> 联系我们电话：86-20-84221810
</div>
<div id="main_bottom_r">
地址：广州市海珠区新港中路397号<br>

备案/许可证编号为：粤ICP备11086295号-1<br>

Copyright &copy; 2014 cntit.com.cn All Right Reserved
</div>
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
/*{index,total,pagena_num, lang:{lang_previous,lang_next}}*/
function pagenation_controller_update(ul_obj, options)
{
	//var index = parseInt(object.attr('id').split('_')[1]);
	var base = options['base'];
	var index = options['index'];
	if((index < 1) || (index > total))
	{
		return;
	}
	
	var total = options['total'];
	var pagena_num = options['pagena_num'];
	//var ul_obj = jQuery("ul", parent_object);
	ul_obj.html("");
	
	var start = index-2;
	var end = index+pagena_num-2;
	if(start<=0){start=1;end=start+pagena_num;}
	if(index+pagena_num-1 > total)
	{
		start = total-pagena_num+1;
		end = total+1;
	}

	//add li:'previous'
	//ul_obj.append("<li class='first'><a id='pagination_1' href='#'>"+options['lang']['lang_first']+"</a></li>");
	
	var previous_li = "<li class='unactive'><a id=pagination_"+(index-1)+" href='#'><img src='"+base+"/img/dot_dj.png' align='absmiddle' border='0'/></a></li>";
	if(index == 1)
	{
	    previous_li = "<li class='unactive disabled'><a id=pagination_"+(index-1)+" href='#'><img src='"+base+"/img/dot_dj.png' align='absmiddle' border='0'/></a></li>";
	} 
	ul_obj.append(previous_li);
	
	//add middle li	
	for(var i=start; i<end; i++)
	{
		if(index != i)
		{
			ul_obj.append("<li class='unactive'><a id=pagination_"+i+" href='#'>"+i+"</a></li>");
		}
		else
		{
			ul_obj.append("<li class='active'><a id=pagination_"+i+" href='#'>"+i+"</a></li>");			
		}
	}	
		
	var next_li = "<li class='unactive'><a id=pagination_"+(index+1)+" href='#'><img src='"+base+"/img/dot_dz.png' align='absmiddle' border='0'/></a></li>";		
	if(index == total)
	{
		 next_li = "<li class='unactive disabled'><a id=pagination_"+(index)+" href='#'><img src='"+base+"/img/dot_dz.png' align='absmiddle' border='0'/></a></li>";		
	}
	ul_obj.append(next_li);
	//ul_obj.append("<li class='last'><a id=pagination_"+total+" href='#'>"+options['lang']['lang_last']+"</a></li>");
};

//options:{'url','post_data','sort_type','click_id','effect_id','ul_obj','page_update'}
//data: post data array
//sort_type:  0:descend(default), 1:ascend
//ul_obj: page split ul tag
//page_update:{'total_page_num','pagena_num','lang'}
function table_sort(options)
{
	var post_str = generate_query_str(options['post_data']);
	var ajax = {url:options['url'], data:post_str, type: 'POST', dataType: 'text', cache: false,success: function(html){
		options['effect_id'].html(html);
		$('.headerSortDown').removeClass('headerSortDown');
		$('.headerSortUp').removeClass('headerSortUp');
		options['sort_type'] == 0 ? options['click_id'].addClass('headerSortDown') : options['click_id'].addClass('headerSortUp');
		//jump to the first page
		var page_update_data = options['page_update'];
		page_update_data['index'] = 1;
		pagenation_controller_update(options['ul_obj'],page_update_data);
	}};
	jQuery.ajax(ajax);
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


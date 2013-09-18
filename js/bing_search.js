var AppId = "AppId=F0DE0CCB37335B16E7EB0BD3FA2A3C9FD3543DE5";
var Query = "Query="
var Sources = "Sources=Web";
var Version = "Version=2.0";
var Market = "Market=zh-cn"; 
var Options = "Options=EnableHighlighting";
var WebCount = 5;
var WebOffset = 0;


function _ajax_request(ajax_info,callback,options)
{
	    var url_str = ajax_info['url'];
	    var type_str = ajax_info['type'] ? ajax_info['type'] : 'POST';
	    var data_type_str = ajax_info['dataType'] ? ajax_info['dataType'] : 'text';
	    var post_string = ajax_info['post_str'];
	    
	    var ajax = {url: url_str, data:post_string, type: type_str, dataType: data_type_str, timeout: 15000, cache: false, success: function(html) {
               callback(html,options);
            },error:function(html,error){jAlert(error);}
        };
        jQuery.ajax(ajax);
};

function Search(kw_id,result_id,error_msg,wait_id,url,node_id,options) 
{
     $('#'+result_id).html(""); 
     var searchTerms = $('#' + kw_id).val().replace(",", "+");
     
     if(searchTerms == '')
     {
         searchTerms = $('#' + kw_id).html().replace(",", "+");
     }

     searchTerms = encodeURI(searchTerms);   

     var arr = [AppId, Query + searchTerms, Sources, Version, Market, Options, "Web.Count=" + WebCount, "Web.Offset=" + WebOffset, "JsonType=callback", "JsonCallback=?"];

     var requestStr = "http://api.search.live.net/json.aspx?" + arr.join("&");
     $('#'+wait_id).css('display','inline');
     $('#'+options['search_more_id']).css('display','none');
    _ajax_request({url:requestStr,type:'GET',dataType:'jsonp',post_str:''},SearchCompleted,{search_more_id:options['search_more_id'],result_id:result_id,error_msg:error_msg,wait_id:wait_id,url:url,node_id:node_id,qa_msg:options['qa_msg'],button_val:options['button'],save_succ:options['save_succ']});
};
 
 
 
 
  function SearchCompleted(response,options)
   {
   	$('#'+options['wait_id']).css('display','none');
        var errors = response.SearchResponse.Errors;
        //var total = response.SearchResponse.Web.Total;  
        
        var total = 0;
        if(typeof(response.SearchResponse.Web) != "undefined" )
        {
                //total = response.SearchResponse.Web.Total;
                if(typeof(response.SearchResponse.Web.Total) != "undefined" )
                {

                        total = response.SearchResponse.Web.Total;
                }
        }

        if ((errors == null)&&(total > 0))
        {
            DisplayResults(response,options);
            $('#'+options['search_more_id']).css('display','inline');
        }
        else
        {
            $("#"+options['result_id']).html(options['error_msg']);
        }
    };
 
 
 
  function DisplayResults(response,options) 
  {
        var results = response.SearchResponse.Web.Results;  
        var link = [];  
        var regexBegin = new RegExp("\uE000", "g");    
        var regexEnd = new RegExp("\uE001", "g"); 
        var len = results.length;
        var url = options['url']; 
        var node_id = options['node_id']; 
        
        link[0] = "";
        
        for (var i = 0; i < len; i++) 
        {
            //link[i+1] =  results[i].Description url 
            link[i+1] = '<a  class="link_text" href="'+results[i].Url+'" onclick="window.open(this.href);return false;"><div class="Result_content">'+results[i].Title+'</div></a>';            
            link[i+1] = link[i+1].replace(regexBegin, "<strong>").replace(regexEnd, "</strong>");
        }    
        $("#"+options['result_id']).html(link.join('')); 
   }
   

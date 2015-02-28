document.write('<script src="'+$('#header_base').val()+'js/jquery.ui.widget.min.js" ></script>');
document.write('<script src="'+$('#header_base').val()+'js/jquery.marcopolo.min.js" ></script>');

$(function() {
    autocomplete({'id':'search','url':$('#header_base').val()+"content_search/mashup_data_search/"});
});

String.prototype.trim=function(){return this.replace(/(^\s*)|(\s*$)/g,"");};

function autocomplete(options)
{
    var sid = '#'+options['id'];
    $(sid).marcoPolo({
                  url: options['url'],
                  formatItem: function (data, $item) 
                  {
                  
                     	var last_str = data.desc.length>20 ? '......' : '';
                        return '<strong>'+data.type_string+'</strong>'+data.desc.substr(0,20)+last_str;
                  },
                  
                  onSelect: function (data, $item) {
                    window.location = data.url;
                  }
                  /*onSelect: function (data, $item)
                  {
                    this.val(data.url);
                    //alert(data.url);
                  }*/
    });
    $(sid).keydown(function(event)
    {
         if(event.keyCode == 13)
         {
			 if($('#logins').val()==''){showLoginModal();return;}
             var text = $(sid).val().trim();
             if(text !='')
             {
				 url=$('#header_base').val() + "asking/?search="+encodeURI(text);
                window.location.href = url;
             }
             else
             {
                 //todo:
                 //nothing to do or msg pop out
                 //alert('nothing to search.');
             }
         }
    });
}
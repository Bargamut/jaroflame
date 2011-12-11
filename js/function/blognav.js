// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nhistory:'+$.address.history()+
		'\npath:'+$.address.path()+
		'\npathNames:'+$.address.pathNames()+
		'\nqueryString:'+$.address.queryString()+
		'\nstate:'+$.address.state()+
		'\ntitle:'+$.address.title()+
		'\ntracker:'+$.address.tracker()+
		'\nvalue:'+$.address.value()+
		'\nparameterNames:'+$.address.parameterNames()
	);
	
	
	get_blog($.address.queryString(),'blog_box','blog_container');
});

function set_hash(address){
	$.address.value('?'+address);
}

function get_blog(query,boxID,containerID){
	box = $("#"+boxID), container = $("#"+containerID);
	if ($.address.queryString()!=''){
		$.ajax({
			type: "POST",
			url: '/get_blog.php',
			data: query,
			cache: false,
			success: function(html){
				if(html != 'null'){
					data = eval("("+html+")");
					$(".middle").html('');
					
					page = data.address.split('.');
					console.error('Загрузка контента:\n'+data)
					$(".middle").html(
					'<div class="blog_content">'+
						'<img src="/images/'+page[0]+'/'+data.address+'" width="1050" height="480px" alt="'+data.caption+'" />'+
					'</div>'+
					'<div class="blog_text_header"><h1 class="blog_text_header">'+data.caption+'</h1></div>'+
					
					'<div class="blog_text_subheader"><h2 class="blog_text_subheader">'+data.title+'</h2></div>'+
					'<div class="blog_text">'+
						data.content+
					'</div>'+
					'<div class="blog_date">'+
						data.date_visible+
					'</div>'+
					'<div class="blog_address">'+data.address+'</div>');
					
					box.css("height", $(".middle").height());
					container.css("height", $(".middle").height());
				}else{
					$(".middle").html('');
				}
				console.log(data);
				return html;
			}
		});
	}
}
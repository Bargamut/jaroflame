<script language="javascript" type="text/javascript">
var way = '';

$(".arrow_left").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($(this).attr('alt'));
	way = 'left';	
});
$(".arrow_right").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($(this).attr('alt'));
	way = 'right';
});

$("#post_img").livequery('mousedown',function(){
	$(".slider_points").each(function(i){
		if($(this).attr("alt") == 'active'){
			switch(i){
				case 0:k = i+1;break;
				case $(".slider_points").length-1:k = 0;break;
				default:k = i+1;break;
			}
			$($(".slider_points")[k]).trigger("click");
			return false;
		}
	});
});

function change_img(img){
	console.warn('Изменение картинки');
	page = img.attr("id").split(".");
	$("#post_img").attr("src",'/images/'+page[0]+'/'+img.attr("id"));
	$(".slider_points").each(function(){$(this).attr({src:"/images/default/point1.png",alt:""});});
	img.attr({src:"/images/default/point2.png",alt:"active"});
	
	var img2 = new Image();
	img2.onload = function(){
		this.width > 900 ? $("#post_img").css("width",'900px') : $("#post_img").css("height",this.height+'px');
		
		console.log('Высота картинки(load): '+$("#post_img").height());
		$(".blog_content").css("height", $("#post_img").height());
		$(".middle").css("height",($("#post_img").height()+$(".bt").height())+'px');
		$("#blog_box").css("height", $(".middle").height());
		$("#blog_container").css("height", $(".middle").height());
	};
	img2.src = '/images/'+page[0]+'/'+img.attr("id");
}

// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nqueryString:'+$.address.queryString()
	);
	
	post = $.address.queryString();
	query = 'a='+post;
	
	console.log(post);
	get_blog(query,'blog_box','blog_container');
});

function set_hash(address){
	$.address.value('?'+address);
}

function get_blog(query,boxID,containerID){
	box = $("#"+boxID), container = $("#"+containerID);
	$.ajax({
		type: "POST",
		url: '/get_blog.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				//$(".middle").html('');
				
				page = data['middle'].address.split('.');
				switch(way){
					case 'left':round_roll('blog_box','blog_container',this.id,'arrow_right','right');break;
					case 'right':round_roll('blog_box','blog_container','arrow_left',this.id,'left');break;
					default:break;
				}
				
				var imgs = '';
				if(!data['middle_imgs'].length){
					imgs = '<img onclick="change_img($(this));$(\'.title\').html(\''+data['middle'].title+'\');" class="slider_points" id="'+data['middle'].address+'" src="/images/default/point2.png" alt="active" />';
					for (key in data['middle_imgs']){
						imgs +=
							'<img onclick="change_img($(this));$(\'.title\').html(\''+data['middle_imgs'][key]+'\');" class="slider_points" id="'+key+'" src="/images/default/point1.png" />';
					}
				}
				var title = '<div class="title" align="left" style="font-style:italic; padding:0 55px 0 50%;">'+data['middle'].title+'</div>';
				
				// Если есть предыдущий (более новый) элемент
				data['prev'] ? (
					$(".arrow_left").show().attr("alt",data['prev'].address),
					date_prev = 
						'<div class="blog_date_prev">'+
							data['prev'].date_visible+
						'</div>'
				) : (
					$(".arrow_left").hide(), date_prev ='');
				
				// Если есть следующий (более старый) элемент
				data['next'] ? (
					$(".arrow_right").show().attr("alt",data['next'].address),
					date_next = 
						'<div class="blog_date_next">'+
							data['next'].date_visible+
						'</div>'
				) : (
					$(".arrow_right").hide(), date_next = '');
				
				var title_dayfrog = '',	title_blog = '';
				page[0] == 'dayfrog' ?
					title_dayfrog = '<div class="blog_text_header" style="padding:0 0 35px 0;"><h1 class="blog_text_header">'+data['middle'].caption+'</h1></div>'	:
					title_blog = '<div class="blog_text_header"><h1 class="blog_text_header">'+data['middle'].caption+'</h1></div>' ;
				
				$(".middle").html(
					title_dayfrog+
					'<div class="blog_content">'+
						'<img id="post_img" src="/images/'+page[0]+'/'+data['middle'].address+'" alt="'+data['middle'].caption+'" style="max-width:900px;" />'+
					'</div>'+
					'<div class="bt">'+
					title+
					'<div class="nav" align="right">'+imgs+'</div>'+
					title_blog+
					
					/*'<div class="blog_text_subheader"><h2 class="blog_text_subheader">'+data['middle'].title+'</h2></div>'+*/
					'<div class="blog_text">'+
						data['middle'].content+
					'</div>'+
					date_prev+
					date_next+
					'<div class="blog_address">'+data['middle'].address+'</div>'+
					'</div>');
					
					var img = new Image();
					img.onload = function(){
						this.width > 900 ? $("#post_img").css("width",'900px') : $("#post_img").css("height",this.height+'px');						
						
						console.log('Высота картинки(load): '+$("#post_img").height());
						$(".blog_content").css("height", $("#post_img").height());
						$(".middle").css("height",($("#post_img").height()+$(".bt").height())+'px');
						$("#blog_box").css("height", $(".middle").height());
						$("#blog_container").css("height", $(".middle").height());
					};
					img.src = '/images/'+page[0]+'/'+data['middle'].address;
					
					
					$('title').html(data['middle'].caption);
			}else{
				$(".middle").html('');
			}
			console.log(data);
		}
	});
}
</script>
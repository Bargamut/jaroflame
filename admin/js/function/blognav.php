<script language="javascript" type="text/javascript">
var way = '';

$(".arrow_left").livequery('mousedown',function(){
	set_hash($(this).attr('alt'),$(".blog_date_prev").html());
	way = 'left';	
});
$(".arrow_right").livequery('mousedown',function(){
	set_hash($(this).attr('alt'),$(".blog_date_next").html());
	way = 'right';
});

function change_img(img){
	console.warn('Изменение картинки');
	page = img.attr("id").split(".");
	$("#post_img").attr("src",'/images/'+page[0]+'/'+img.attr("id"));
	$(".slider_points").each(function(){$(this).attr("src","/images/default/point1.png");});
	img.attr("src","/images/default/point2.png");
}

// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nqueryString:'+$.address.queryString()
	);
	
	post = $.address.queryString().split('&');
	query = 'p='+post[0]+'&a='+post[1]+'&d='+post[2];
	
	console.log(post[0]+'\n'+post[1]+'\n'+post[2]);
	get_blog(query,'blog_box','blog_container');
});

function set_hash(address,date){
	page=address.split('.');
	$.address.value('?'+page[0]+'&'+address+'&'+date);
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
				
				var imgs = '<img onclick="change_img($(this));" class="slider_points" id="'+data['middle'].address+'" src="/images/default/point2.png" />';
				if(data['middle_imgs']){
					for (key in data['middle_imgs']){
						imgs +=
							'<img onclick="change_img($(this));" class="slider_points" id="'+data['middle_imgs'][key].content+'" src="/images/default/point1.png" />';
					}
				}
				
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
				
				$(".middle").html(
					'<div class="blog_content">'+
						'<img id="post_img" src="/images/'+page[0]+'/'+data['middle'].address+'" width="1050" height="480px" alt="'+data['middle'].caption+'" />'+
					'</div>'+
					'<div class="nav" align="right">'+imgs+'</div>'+
					'<div class="blog_text_header"><h1 class="blog_text_header">'+data['middle'].caption+'</h1></div>'+
					
					'<div class="blog_text_subheader"><h2 class="blog_text_subheader">'+data['middle'].title+'</h2></div>'+
					'<div class="blog_text">'+
						data['middle'].content+
					'</div>'+
					date_prev+
					date_next+
					'<div class="blog_address">'+data['middle'].address+'</div>');
				
				box.css("height", $(".middle").height());
				container.css("height", $(".middle").height());
			}else{
				$(".middle").html('');
			}
			console.log(data);
		}
	});
}
</script>
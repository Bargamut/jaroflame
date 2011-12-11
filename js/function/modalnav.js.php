<script language="javascript" type="text/javascript">
var way = '', opened = 0;

$(".arrow_left_modal").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($('.album').html(),$('.img_prev').html());
	way = 'left';	
});
$(".arrow_right_modal").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($('.album').html(),$('.img_next').html());
	way = 'right';
});

$(".all_albums").livequery('mousedown', function(){
	if ($(".albums").css("display") != 'none'){
		$(".albums").fadeOut();
	}else{
		$(".albums").css({top:'-'+($(".albums").height()+22)+'px'});
		$(".albums").fadeIn();
	}
});

// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nqueryString:'+$.address.queryString()
	);
	
	post = $.address.queryString().split('&');
	query = 'a='+post[0]+'&p='+post[1];
	
	if(post[0] != ''){
		opened == 0 ? (
			show_album(query)
		) : get_album(query,'photo_box_modal','photo_container_modal');
	}
	console.log('Альбом: '+post[0]+'\nИзображение: '+post[1]+'\nОткрыт: '+opened);
});

function open_album(id){
	var photo = id.split('/');
	photo[photo.length-1] == 'none' ? photo[photo.length-1] = '01.jpg' : null ;
	set_hash(photo[0],photo[photo.length-1]);
}

// Изменеие хэша
function set_hash(album,img){
	$.address.value('?'+album+'&'+img);
}

// Очистка хэша
function clear_hash(){
	$.address.value('');
}

function close_album(docPos){
	$('body').removeClass();
	$(".modal_content").unblock({
		onUnblock: function(){
			$(".modal_content").css({width:'0px',height:'0px'});
			$(".modal_content").css("z-index",-2);
			clear_hash();opened = 0;console.log('Открыт: '+opened);
		},
		fadeOut: 0,
		fadeIn: 0
	});
	$(document).scrollTop(docPos);
	$(".r_header").html() != 'Карта сайта' ?
		$('title').html('Рекламное агентство с секретным оружием')
	:
		$('title').html('Карта сайта');
}

function close_open_album(){
	
}

function get_album(query,boxID,containerID){
	box = $("#"+boxID), container = $("#"+containerID);
	$.ajax({
		type: "POST",
		url: '/get_album.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				//$(".middle").html('');
				
				switch(way){
					case 'left':round_roll('photo_box_modal','photo_container_modal',this.id,'arrow_right_modal','right','modal_text','cont');break;
					case 'right':round_roll('photo_box_modal','photo_container_modal','arrow_left_modal',this.id,'left','modal_text','cont');break;
					default:break;
				}
				
				// Если есть предыдущий (более новый) элемент
				data['prev'] ? (
					$(".arrow_left_modal").show().attr("alt",data['prev'].fname),
					$(".img_prev").html(data['prev'].fname)
				) : (
					$(".arrow_left_modal").hide(),
					$(".img_prev").html('')
				);
				
				// Если есть следующий (более старый) элемент
				data['next'] ? (
					$(".arrow_right_modal").show().attr("alt",data['next'].fname),
					$(".img_next").html(data['next'].fname)
				) : (
					$(".arrow_right_modal").hide(),
					$(".img_next").html('')
				);
				
				album = data['middle'].falbum;
				img = data['middle'].fname;
				caption = data['middle'].fcaption;
				desc = data['middle'].fdesc;
				
				$(".modal_header").html(
					data['middle'].fcaption+'\n'+
					'<img id="but_close" class="but_close" src="/images/default/close_but.png" title="Закрыть" />');
				
				$(".modal_text").html(desc);
				
				$(".middle").html(
					'<img src="/images/foto/'+album+'/'+img+'" alt="'+caption+'" cont="'+desc+'" />');
				
				$(".album").html(data['middle'].falbum);
				box.css("height", $(".middle").height());
				container.css("height", $(".middle").height());
				
				var albums = '<li class="close_albums"><img src="/images/default/close_albums.png" align="right" /></li>\n';
				for(i in data['albums']){
					//albums += '<li id="'+i+'/'+data['albums'][i].fname+'" onmousedown="open_album(this.id);">'+data['albums'][i].fcaption+'</li>\n';  // Для перехода на альбом с прокруткой до Main-photo
					albums += '<li id="'+i+'/none" onmousedown="open_album(this.id);">'+data['albums'][i].fcaption+'</li>\n';
				}
				$(".albums").html(albums);
				
				var q = query.split('&');
				var img_addr = '';
				for(i in q){
					addr = q[i].split('=');
					img_addr += addr[1];
					i != (q.length-1) ? img_addr += '&' : null ;
				}
				set_social('http://frch.ru/#/?'+img_addr,caption,desc,'http://frch.ru/images/foto/'+album+'/'+img);
			}else{
				$(".middle").html('');
			}
			console.log(data);
		}
	});
}

// Показать весь альбом при клике на элементе
function show_album(img_query){
	var docPos = $(document).scrollTop();
	$.ajax({
		type: "POST",
		url: "album.php",
		cache: false,
		success: function(html){
			//$(".modal_content").css({width:$(window).width()+18+'px',height:$(window).height()+18+'px'});
			console.log(
				$(window).height()+' | '+
				$(document).height()+' | '+
				$(".modal_content").height()+' | '+
				($(".modal_content").height()*0.1)/2
			);
			$(".modal_content").css("z-index","1002");
			$(".modal_content").block({
				message: html,
				css: {
					width: '1100px',
					//height: '90%',
					top: ($(".modal_content").height()*0.1)/2 + 'px',
                	left: ($(".modal_content").width()-1100)/2 + 'px',
					position:'absolute',
					border: 'none',
					padding: '0px',
					backgroundColor: '#fff',
					cursor: 'default',
					'-webkit-border-radius': '10px',
					'-moz-border-radius': '10px',
					'-khtml-border-radius': '10px',
					color: '#000'
            	},
				overlayCSS: {
					cursor: 'default',
					opacity: 0.0,
					background: ''
				},
				onBlock: function(){
					var bgColor = $.cookie('bgColor');
					bgColor !== null ? null : bgColor = '#0c2465';
					$(".modal_content").css({
						width:$(window).width()+18+'px',
						height:$(window).height()+'px',
						backgroundImage:'url("/images/default/bg_gradient.png")',
						backgroundColor: bgColor,
						backgroundPosition: 'top left',
						backgroundRepeat: 'repeat-x'
					});
					$(".blockMsg").css({
						top: ($(".modal_content").height()*0.1)/2 + 'px',
						left: ($(".modal_content").width()-1100)/2 + 'px',
						marginBottom: ($(".modal_content").height()*0.1)/2 + 'px'
					});
					$(".blockOverlay").css({
						height: ($(".blockMsg").height()+$(".blockMsg").position().top)*1.1 + 'px'
					});
					get_album(img_query,'photo_box_modal','photo_container_modal');
					if(!WH_init('photo_box_modal','photo_navigation_modal','width',0,0.4,'photo_container_modal','modal_text','alt')){
						$('body').addClass('modal');
					}
					//slider_init('photo_box_modal','photo_container_modal','arrow_left_modal','arrow_right_modal',null,null,'horizontal');
				},
				fadeOut: 0,
				fadeIn: 0
			});
			$('#but_close').livequery("click",function(){close_album(docPos);});
		}
	});
	opened = 1;
}

function set_social(url,title,text,img){
	$(".twt").attr("href","http://twitter.com/share?text="+text+"&url="+encodeURIComponent(url));
	$(".fcb").attr("href","http://www.facebook.com/sharer.php?u="+encodeURIComponent(url)+"&i="+encodeURIComponent(img)+"&t="+text);
	$(".vkn").attr("href","http://vkontakte.ru/share.php?url="+encodeURIComponent(url)+"&title="+title+"&description="+text+"&image="+img);
	$(".ljn").attr("href","http://www.livejournal.com/update.bml?mode=full&subject="+title+"&event="+encodeURIComponent(url)+"<br>"+text);
	$(".blg").attr("href","http://www.blogger.com/blog_this.pyra?u="+encodeURIComponent(url)+"&n="+text);
	$(".mml").attr("href","http://connect.mail.ru/share?url="+encodeURIComponent(url)+"&title="+title+"&description="+text+"&imageurl="+encodeURIComponent(img));
}
</script>
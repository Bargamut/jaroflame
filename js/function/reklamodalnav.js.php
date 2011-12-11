<script language="javascript" type="text/javascript">
var way = '', opened = 0, img_clicked = '';

$(".arrow_left_modal").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	way = 'left';	
});
$(".arrow_right_modal").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	way = 'right';
});

$(".blok").livequery('mousedown',function(){
	var cls = $(this).attr("class").split(' ')[1].replace("b","i");
	switch(typeof($(this).attr("src"))){
		case 'undefined':
			console.log('Undef');
			show_album(cls);
			img_clicked = $("."+cls+":first").attr("src");
			break;
		default:
			show_album(cls);
			img_clicked = $(this).attr("src");
			break;
	}
});

function close_album(docPos){
	$('body').removeClass();
	$(".modal_content").unblock({
		onUnblock: function(){
			$(".modal_content").css({width:'0px',height:'0px'});
			$(".modal_content").css("z-index",-2);
		},
		fadeOut: 0,
		fadeIn: 0
	});
	$(document).scrollTop(docPos);
}

function get_album(classname){
	console.log('classname: '+classname);
	box = $("#rek_box_modal"), container = $("#rek_container_modal"),
	img = '<?=$_GET['address']?>', caption = $(".blog_text_header").html(), li = '' ,desc = '';
	
	$("."+classname).each(function(i){
		li += '<li><img id="img.'+(i+1)+'/'+$("."+classname).length+'" class="img'+i+'" src="'+$(this).attr("src")+'" alt="'+$(this).attr("alt")+'" title="'+$(this).attr("title")+'" /></li>\n';
	});
	box.append(li);
	$("#modal_count").html($("#rek_box_modal li:first").find("img").attr("id").split(".")[1]);
	$(".modal_header").html(
		$("#rek_box_modal li:first").find("img").attr('title')+'\n'+
		'<img id="but_close" class="but_close" src="/images/default/close_but.png" title="Закрыть" />'
	);
	
	set_social('http://frch.ru/reklamovedenie.php?address='+img,caption,desc,'http://frch.ru/images/reklamovedenie/'+img);
	return true;
}

// Прокрутка на определённую позицию
function roll_pos(boxID,containerID,src){
	console.log("Автопрокрутка\n"+src+'\n'+img_clicked);
	var box = $("."+boxID), container = $("."+containerID);
		container_center = container.width()/2;
	$("."+boxID+"> li").each(function(){
		if($(this).find('img').attr("src") == src){
			var li_center = $(this).width()/2 + $(this).position().left;
			
			console.log('Высота картинки(autoroll): '+$(this).find('img').height());
			$(this).css("height",($(this).find('img').height()+30)+'px');
			$("#rek_box_modal").css("height", $(this).height());
			$("#rek_container_modal").css("height", $(this).height());
			if(container_center != li_center){
				var pos = container_center - li_center;
				pos > 0 ? way = 'right' : way = 'left';
			}else{				
				var pos = 0;
				way = '';
			}
			roll_content(boxID,containerID,'arrow_right_modal','arrow_left_modal',way,'modal_text','alt',null,Math.abs(pos));
		}
	});
}

// Показать весь альбом при клике на элементе
function show_album(classname){
	var docPos = $(document).scrollTop();
	$.ajax({
		type: "POST",
		url: "album.reklamovedenie.php",
		data: "classname="+classname,
		cache: false,
		success: function(html){
			//$(".modal_content").css({width:$(window).width()+18+'px',height:$(window).height()+18+'px'});
			console.log(
				'HEIGHT:\n'+
				'   window: '+$(window).height()+'\n'+
				'   document: '+$(document).height()+'\n'+
				'   .modal_content: '+$(".modal_content").height()+'\n'+
				'   .modal_content*0.1)/2: '+($(".modal_content").height()*0.1)/2
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
					get_album(classname);
					if(!WH_init('rek_box_modal','rek_navigation_modal','width',0,0.4,'rek_container_modal','modal_text','alt')){
						$('body').addClass('modal');
						console.warn('INIT');
						roll_pos('rek_box_modal','rek_container_modal',img_clicked);
					}
					//slider_init('rek_box_modal','rek_container_modal','arrow_left_modal','arrow_right_modal',null,null,'horizontal');
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
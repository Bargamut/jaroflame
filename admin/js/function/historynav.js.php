<script language="javascript" type="text/javascript">
var way = '';

// Отображение активного блока
function active_fade(set){
	set == 1 ?
		$('.active_block').css("display",'block'):
		$('.active_block').css("display",'none');
}

// Изменение адресной строки
$.address.change(function(){
	var post = $.address.queryString();
	post ? (
		m = (post.split("."))[0],
		query = 'm='+m+'&p='+post,
		$(".photo_box >li").length == 0 ? (
			get_historyslider(query,'photo_box',post),
			nav_path('.p_header',m)
		) : null,
		roll_pos('photo_box','photo_container',post),
		get_history(query,'photo_box','photo_container')
	) : (
		m = '<?=$_POST['m']?>',
		query = 'm='+m,
		get_historyslider(query,'photo_box','photo_container'),
		nav_path('.p_header',m)
	);
});

// Прокрутка на определённую позицию
function roll_pos(boxID,containerID,post){
	var box = $("."+boxID), container = $("."+containerID);
		container_center = container.width()/2;
	$("."+boxID+"> li").each(function(){
		if($(this).find('img').attr("id") == post){
			var li_center = $(this).width()/2+$(this).position().left;
			if(container_center != li_center){
				var pos = container_center - li_center;
				pos > 0 ? way = 'right' : way = 'left';
				roll_content(boxID,containerID,'arrow_right','arrow_left',way,null,null,null,Math.abs(pos));
			}
		}
	});
}

function nav_path(ident,cont){
	switch (cont){
		case 'graphic': cont = '<a href="/history.categories.php">'+$(ident).html()+'</a> <span style="font-family:Georgia, Times New Roman, Times, serif;">&rarr;</span> Графический дизайн и реклама';break;
		case 'sites': cont = '<a href="/history.categories.php">'+$(ident).html()+'</a> <span style="font-family:Georgia, Times New Roman, Times, serif;">&rarr;</span> Сайты';break;
		case 'concept': cont = '<a href="/history.categories.php">'+$(ident).html()+'</a> <span style="font-family:Georgia, Times New Roman, Times, serif;">&rarr;</span> Концепты';break;
		case 'illustration': cont = '<a href="/history.categories.php">'+$(ident).html()+'</a> <span style="font-family:Georgia, Times New Roman, Times, serif;">&rarr;</span> Иллюстрации';break;
		default:return false;break;		
	}
	$(ident).html(cont);
}

// Изменеие хэша
function set_hash(img){$.address.value('?'+img);}

// Очистка хэша
function clear_hash(){$.address.value('');}

function get_history(query,boxID,containerID){
	box = $("#"+boxID), container = $("#"+containerID);
	$.ajax({
		type: "POST",
		url: '/get_history.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				data.tags != '' ? (
					favic_site = '<h2 class="r_sub_header">'+'\n'+
								 '<img align="left" src="http://'+
								 data.tags+
								 '/favicon.ico" style="margin:3px 0 0 0; width:16px; height:16px;" />'+'\n'+
								 '<a class="r_sub_header" href="http://'+data.tags+'" target="_new">'+
									 data.tags+
								 '</a></h2>') : favic_site = '';
				
				$(".history_content").html(
					'<div>\n'+
					'<h1 class="r_header_first">'+data.caption+'</h1>\n'+
					favic_site+'\n'+
					'<div class="rubriki_text">\n'+
					data.content+'\n'+
					'</div>\n'+
					'</div>');
					
					$('title').html(data.caption);
			}else{
				$(".middle").html('');
			}
		}
	});
}

function get_historyslider(query,boxID,post_roll){
	box = $("#"+boxID);
	$.ajax({
		type: "POST",
		url: '/get_historyslider.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				//console.log(data);
				box.html(data);
				box.ready(function(){
					//console.log('Загружен бокс!');
					WH_init('photo_box','photo_navigation','width',-0.005,0.25);
					slider_init('photo_box','photo_container','arrow_left','arrow_right',null,null,'horizontal');
					post_roll != '' ? (
						roll_pos('photo_box','photo_container',post_roll),
						get_history(query,'photo_box','photo_container')
					) : null;
					var m = ((query.split("&"))[0].split("="))[1];
					m == 'sites' ? (
						console.log('m=sites'),
						$(".table_box").css("height","230px"),
						$(".photo_box").css("height","230px !important"),
						$(".photo_box > li").css("height","230px"),
						$(".photo_container").css("height","230px")
					) : null;
				});
			}else{
				$(".middle").html('');
			}
		}
	});
}
</script>
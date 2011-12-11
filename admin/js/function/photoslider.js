// JavaScript Document
/** Построение блоков в боксе и начальный сдвиг в % (0...0.5...1)
oID - ID бокса с блоками
navID - ID навигационной панели
wh - ориентировка (width/height)
pos - позиция бокса по оси X(width) или Y(height)
navpos - позиция навигационной панели по оси Y
containerID - ID контейнера
contentID - ID элемента с описанием
attribut - атрибут, из которого берётся описание/html-код с описанием
*/
function WH_init(oID,navID,wh,pos,navpos,containerID,contentID,attribut){
	console.log('Построение блоков в боксе '+oID+' и начальный сдвиг в % (0...0.5...1)');
	var container = $("#"+containerID), content = $("#"+contentID);
	switch (wh){
		case 'width':$("#"+oID).css("width",'0px');break;
		case 'height':$("#"+oID).css("height",'0px');break;
	}
	$("#"+oID+"> li").each(function(){
		switch (wh){
			case 'width':
				$("#"+oID).css("width",($("#"+oID).width() + $(this).width())+"px");
				if($("#"+oID).height() < $(this).height()){
					$("#"+oID).css("height",$(this).height()+"px");
					$("#"+containerID).css("height",$(this).height()+"px");
				}
				if(pos){$(this).animate({left: "-="+$(this).width()*pos+"px"},0);}
				var center_this = $(this).position().left + $(this).width()/2;
				if(center_this == container.width()/2 && content.length){
					switch (attribut){
						case 'html':content.html($(this).html());break;
						default:content.html($(this).find("img").attr(attribut));break;
					}
				}
				break;
			case 'height':
				$("#"+oID).css("height",($("#"+oID).height() + $(this).height())+"px");
				if($("#"+oID).width() < $(this).width()){
					$("#"+oID).css("width",$(this).width()+"px");
					$("#"+containerID).css("width",$(this).width()+"px");
				}
				if(pos){$(this).animate({top: "-="+$(this).height()*pos+"px"},0);}
				var middle_this = $(this).position().top + $(this).height()/2;
				if(middle_this == container.height()/2 && content.length){
					switch (attribut){
						case 'html':content.html($(this).html());break;
						default:content.html($(this).attr(attribut));break;
					}
				}
				break;
		}
	});
	$("."+navID).css("top",($("#"+oID).parent().height()*navpos)+"px");
	console.log('Построение блоков в боксе '+oID+' завершено.');
}

// Инициализация бокса прокрутки
function slider_init(boxID,containerID,leftID,rightID,downID,upID,xy){
	/*console.log('Инициализация бокса прокрутки '+boxID);*/
	var box = $("#"+boxID),
		container = $("#"+containerID),
		li_first = $("#"+boxID+"> li:first"),
		li_last = $("#"+boxID+"> li:last"),
		l_arr = $("#"+leftID),
		r_arr = $("#"+rightID),
		d_arr = $("#"+downID),
		u_arr = $("#"+upID),
		result = 'none';
	
	var center_first = li_first.position().left + li_first.width()/2,
		center_last = li_last.position().left + li_last.width()/2,
		middle_first = li_first.position().top+li_first.height()/2,
		middle_last = li_last.position().top + li_last.height()/2;
	
	switch(xy){
		case 'horizontal':
			if(center_first == container.width()*0.5){
				result = 'Крайнее левое положение';
				l_arr.css("display","block");
				r_arr.css("display","none");
			}else if(center_last == container.width()*0.5){
				result = 'Крайнее правое положение';
				l_arr.css("display","none");
				r_arr.css("display","block");
			}else{
				result = 'Вне блока';
				l_arr.css("display","block");
				r_arr.css("display","block");
			}
			break;
		case 'vertical':
			if(middle_first == container.height()*0.5){
				result = 'Крайнее верхнее положение';
				u_arr.css("display","block");
				d_arr.css("display","none");
			}else if(middle_last == container.width()*0.5){
				result = 'Крайнее нижнее положение';
				u_arr.css("display","none");
				d_arr.css("display","block");
			}else{
				result = 'Вне блока';
				u_arr.css("display","block");
				d_arr.css("display","block");
			}
			break;
		case 'both':break;
		default:
			result = 'Параметр направления не определён - Всегда показывать навигацию';
			l_arr.css("display","block");
			r_arr.css("display","block");
			u_arr.css("display","block");
			d_arr.css("display","block");
		break;
	}
	console.log(
		'Блок: '+boxID+'\n'+
		'Центр 1-го элемента: '+center_first+'\n'+
		'Контрольная точка контейнера: '+container.width()*0.5+'\n'+
		'Центр последнего элемента: '+center_last+'\n'+
		'Результат: '+result
	);
	console.log('Инициализация бокса прокрутки '+boxID+' завершено.');
}

// Прокрутка фотографий
/**
	boxID - ID бокса с элементами
	containerID - ID контейнера
	lID, rID - ID стрелок
	way - направление движения
	contentID - ID контейнера для сброса содержимого центральной картинки
	attribut - атрибут, из которого берётся содержимое/текст html
*/
function roll_content(boxID,containerID,lID,rID,way,contentID,attr,obj,pos){
	var box_li = $("#"+boxID+"> li"), container = $("#"+containerID), content = $("#"+contentID);
	var koeff, h=0, v=0;
	/*console.log('Прокрутка фотографий START\n'+
				'Направление: '+way+'\n'+
				'ID контетна: '+contentID+'\n'+
				'Содержание: '+attribut);
	console.log(typeof(contentID)+typeof(attribut));*/
	
	/*container.block({
		message: '',
		css: {
			border: 'none',
			padding: '0px',
			backgroundColor: '',
			cursor: 'pointer'
		},
		overlayCSS: {
			cursor: 'pointer',
			opacity: 0.0,
			backgroundColor: ''
		}
	});*/
	
	$(".active_block") ? $(".active_block").toggle() : null;
	switch (way){
		case 'left': koeff='-';h=1;break;
		case 'right': koeff='+';h=1;break;
		case 'up': koeff='-';v=1;break;
		case 'down': koeff='+';v=1;break;
	}
	console.log(way);
	box_li.each(function(i){
		pos ? null : (h == 1 ? pos = $(this).width() : $(this).height());
		$(this).animate(
			{left: koeff+"="+pos*h+"px",top: koeff+"="+pos*v+"px"},
			{duration: 100,queue: true,easing: "linear",
				complete:function(){
					//container.unblock();		
					switch (h){// Определение центрального блока
						case 1:// горизонтального
							is_active($(this),$("#boxID"),container,content,attr,h);
							switch(i){
								case 0:break; // первый элемент
								case (box_li.length-1):
									$(".active_block") ? $(".active_block").toggle() : null;
									if(obj){ // если существует объект для удаления (первый/последний)
										slider_init(boxID,containerID,lID,rID,lID,rID);
										obj.detach();console.log('Удаление элемента');
									}else{
										!obj ? move_to(way,boxID,containerID,contentID,attr) : null;
										boxID.split("_")[0] != 'rek' ?
											slider_init(boxID,containerID,lID,rID,lID,rID,'horizontal')
										:   slider_init(boxID,containerID,lID,rID,lID,rID);
									}
									break;
								default:break; // промежуточные элементы
							}
							break;
						case 0:// вертикального
							is_active($(this),$("#"+boxID),container,content,attr,h);
							switch(i){
								case 0:break; // первый элемент
								case (box_li.length-1):
									$(".active_block") ? $(".active_block").toggle() : null;
									if(obj){ // если существует объект для удаления (первый/последний)
										slider_init(boxID,containerID,lID,rID,lID,rID);
										obj.detach();console.log('Удаление элемента');
									}else{
										!obj ? move_to(way,boxID,containerID,contentID,attr) : null;
										boxID.split("_")[0] != 'rek' ?
											slider_init(boxID,containerID,lID,rID,lID,rID,'vertical')
										:   slider_init(boxID,containerID,lID,rID,lID,rID);
									}
									break;
								default:break; // промежуточные элементы
							}
							break;
						default:break;
					}
				}
			}
		);
	});
	console.warn(box_li.length);
	/*console.log('Прокрутка фотографий STOP');*/
	return false;
}

function is_active(li,box,container,content,attr,h){
	var center_li = li.position().left+li.width()/2,
		middle_li = li.position().top+li.height()/2,
		center_container = container.width()/2,
		middle_container = container.height()/2,
		a = 0;
		
	switch (h){
		case 1: center_li == center_container ? a = 1 : a = 0;break;
		case 0: middle_li == middle_container ? a = 1 : a = 0;break;
		default: a = 0;break;
	}
		
	if(a && content.length){
		switch (attr){
			case 'html':content.html(li.html());break;
			default:content.html(li.find("img").attr(attr));break;
		}
			li.css("height", li.find('img').height()+20+'px');
			box.css("height", li.height()+'px');
			container.css("height", li.height()+'px');
	}
	var mt = $("#modal_count");
	if(a && mt.length){
		mt.html(li.find("img").attr("id").split(".")[1]);
		$(".modal_header").html(
			li.find("img").attr('title')+'\n'+
			'<img id="but_close" class="but_close" src="/images/default/close_but.png" title="Закрыть" />'
		);
	}
	return true;
}

// Перемещение первого/последнего элемента списка в конец/начало
function move_to(way,boxID,containerID,contentID,attr){
	$("#"+boxID+"> li").stop();
	var liLast = $('#'+boxID+' li:last'),
		liFirst = $('#'+boxID+' li:first'),
		fL = $('#'+boxID+' li:first').position().left,
		lL = $('#'+boxID+' li:last').position().left;
		console.log(
			'liFirst.pos = '+liFirst.position().left+'\n'+
			'liLast.pos = '+liLast.position().left);
	switch (way){
		case 'right':
			liLast.prependTo('#'+boxID).css({left:(fL-$(this).width())+'px'});
			$('#'+boxID+'> li').each(function(){$(this).css("left",(fL-liFirst.width())+'px');});
			is_active($('#'+boxID+' li:first'),$('#'+boxID),$('#'+containerID),$('#'+contentID),attr,1);
			break;
		case 'left':
			$('#'+boxID+'> li').each(function(){$(this).css("left",(fL+liLast.width())+'px');});
			liFirst.appendTo('#'+boxID).css({left:(fL+liFirst.width())+'px'});
			is_active($('#'+boxID+' li:last'),$('#'+boxID),$('#'+containerID),$('#'+contentID),attr,1);
			break;
		case 'down':break;
		case 'up':break;
		default:break;
	}
	console.log(
		'liFirst.pos = '+liFirst.position().left+'\n'+
		'liLast.pos = '+liLast.position().left);
}

// Мышь на стрелке навигации
function mouse_on(rID, step){
	var img = $("#"+rID).attr('src').split("."), ext = img[img.length-1], src ='';
	switch(step){
		case 'down':src = img[0]+'.'+img[1]+'.click.'+ext;break;
		case 'out':src = img[0]+'.'+img[1]+'.'+ext;break;
		case 'over':src = img[0]+'.'+img[1]+'.mover.'+ext;break;
		case 'up':src = img[0]+'.'+img[1]+'.mover.'+ext;break;
		default:break;
	}
	$("#"+rID).attr("src", src);
	return false;
}

// Мышь на контейнере
function fade_nav(nID,step){
	switch (step){
		case 0: $("#"+nID).css("opacity", "0");return false;break;
		case 1: $("#"+nID).css("opacity", "1");return false;break;
	}
}

// Перемещение блока из начала в конец и наоборот
function round_roll(boxID,containerID,lID,rID,way,contentID,attribut){
	/*console.warn('Перемещение блока из начала в конец и наоборот: '+xy);*/
	var box = $("#"+boxID), container = $("#"+containerID);
	
	switch(way){
		case 'left':
			box.css("height",$("#"+boxID+"> li:last").height());
			container.css("height",$("#"+boxID+"> li:last").height());
			$(".middle").removeClass();
			box.append('<li></li>');
			$("#"+boxID+"> li:last").addClass("middle");
			$("#"+boxID+"> li:last").css("left",$("#"+boxID+"> li:first").width());
			roll_content(boxID,containerID,lID,rID,way,contentID,attribut,$("#"+boxID+"> li:first"));
			break;
		case 'right':
			box.css("height",$("#"+boxID+"> li:first").height());
			container.css("height",$("#"+boxID+"> li:first").height());
			$(".middle").removeClass();
			box.prepend('<li></li>');
			$("#"+boxID+"> li:first").addClass("middle");
			$("#"+boxID+"> li:first").css("left",0-$("#"+boxID+"> li:first").width());
			roll_content(boxID,containerID,lID,rID,way,contentID,attribut,$("#"+boxID+"> li:last"));
			break;
		default:break;
	}
}
// JavaScript Document

/*$(document).ready(function(){
//easein,easeinout,easeout,expoin,expoout,expoinout,bouncein,bounceout,bounceinout,elasin,elasout,elasinout,backin,backout,backinout,linear
	$("#lavaLampMenu").lavaLamp({
		fx: "backinout",
		speed: 700,
		click: function(event, menuItem){
			return false;
		}
	});
});*/

$("#red_button").livequery("mousedown", function(){
	$("#red_button").attr("src","/images/default/red_button_p.png");
	change_background();
});
$("#red_button").livequery("mouseup", function(){$("#red_button").attr('src','/images/default/red_button_up.png');});
$(".searchbutton").livequery("mouseup", function(){
	openUrl('http://frch.ru/search.php', {s:$(".searchfield").val()}, 'parent');
});

$(document).ready(function(){
	var bgColor = $.cookie('bgColor');
	console.log(bgColor);
	bgColor !== null ? (
		$('body').css("backgroundColor", bgColor),
		console.log('getCookie')
	) : (console.log('getCookie_null'),null);
});

// Смена бэеграунда
function change_background(){
	var chars = ['0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f']; color = "#";
	for(i=0;i<=5;i++){color += chars[getrandom()];}
	$('body').css("backgroundColor",color);
	$.cookie("backgroundColor", null);
	console.log('color: '+color);
	$.cookie('bgColor', color, {expires: 1});
}

// Удаление cookie
// $.cookie("the_cookie", null);

// Случайное число
function getrandom(){
	var min_random = 0, max_random = 15;
	max_random++;
	var range = max_random - min_random;
	var n = Math.floor(Math.random()*range) + min_random;
	return n;
}

// Функция открытия с POST-запросом
// openUrl('http://google.com/zog/login.php', {login:'admin',password:'admin'}, 'parent');
function openUrl(url,post,target){
	if(!target){target = 'parent'}
	if(post){
		var form = $('<form/>',{
			action: url,
			method: 'POST',
			target: '_'+target,
			style:{
			   display: 'none'
			}
		});

		for(var key in post){
			form.append($('<input/>',{
				type: 'hidden',
				name: key,
				value: post[key]
			}));
		}

		form.appendTo(document.body); // Необходимо для некоторых браузеров
		form.submit();

	}else{
		window.open(url,'_'+target);
	}
}

// Установка cookies
// setCookie("foo", "bar", "Mon, 01-Jan-2001 00:00:00 GMT", "/");
function setCookie (name, value, expires, path, domain, secure) {
      document.cookie = name + "=" + escape(value) +
        ((expires) ? "; expires=" + expires : "") +
        ((path) ? "; path=" + path : "") +
        ((domain) ? "; domain=" + domain : "") +
        ((secure) ? "; secure" : "");
}

// Получение cookies
// myVar = GetCookie("foo");
function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}

function locked_page(){
	$.ajax({
		type: "POST",
		url: '/get_con.php',
		cache: false,
		success: function(html){
			if(html != 'null'){
				$.blockUI({
					message: html,
					css: {
						width: '320px',
						//height: '90%',
						/*top: ($(".modal_content").height()*0.1)/2 + 'px',
						left: ($(".modal_content").width()-1100)/2 + 'px',*/
						position:'absolute',
						border: '2px #999999 solid',
						padding: '15px 10px 10px 10px',
						backgroundColor: '#fff',
						cursor: 'default',
						'-webkit-border-radius': '10px',
						'-moz-border-radius': '10px',
						'-khtml-border-radius': '10px',
						color: '#000'
					},
					overlayCSS: {
						cursor: 'default',
						opacity: 0.4,
						background: '#000000'
					},
					onBlock: function(){
						$(".close_lock> img").livequery("mousedown", function(){$.unblockUI({fadeOut: 0,fadeIn: 0});});
					},
					fadeOut: 0,
					fadeIn: 0
				});
			}
		}
	});
}

// Выделение уникальных значений массива
function arrayUnique(ar){
	var a = [], l = ar.length;
	for(var i = 0; i < l; i++){
		for(var j = i+1; j < l; j++){
			if (ar[i] === ar[j]) j = ++i;
		}
		a.push(ar[i]);
	}
	return a;
}

function set_blog_title(t){
	switch(t){
		case 'design':return 'Дизайн и реклама';break;
		case 'sociality':return 'Социальщина';break;
		case 'dayfrog':return 'На жабу дня';break;
		case 'company':return 'Компания';break;
		case 'reklamovedenie':return 'Рекламоведение';break;
		case 'contacts':return 'Котнактная информация';break;
		case 'vacancy':return 'Вакансии';break;
		case 'partners':return 'Партнёры и поставщики';break;
		default:return 'Рекламное агентство с секретным оружием';break;
	}
}
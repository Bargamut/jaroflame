// JavaScript Document

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
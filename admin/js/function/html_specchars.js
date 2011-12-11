// JavaScript Document
// Замена всех символов HTML
/*function htmlspecialchars_decode(html){
	html = html.toString();
	
	// Таблица П6.1. Символы латиницы
	html = html.replace('/&/g', '&amp;'); // неразрывный пробел
	html = html.replace('/&sect;/g', '§'); // параграф
	html = html.replace('/&copy;/g', '©'); // знак авторского права
	html = html.replace('/&laquo;/g', '«'); // открывающая двойная угловая кавычка
	html = html.replace('/&reg;/g', '®'); // охраняемый знак
	html = html.replace('/&deg;/g', '°'); // градус
	html = html.replace('/&raquo;/g', '»'); // закрывающая двойная угловая кавычка
		
		// Таблица П6.2. Специальные символы
	html = html.replace('/&quot;/g', '"'); // кавычка
	html = html.replace('/&amp;/g', '&'); // амперсант
	html = html.replace('/&lt;/g', '<'); // левая угловая скобка	
	html = html.replace('/&gt;/g', '>'); // правая угловая скобка
	html = html.replace('/&tilde;/g', '˜'); // малая тильда
	html = html.replace('/&ensp;/g', ' '); // короткий пробел
	html = html.replace('/&emsp;/g', ' '); // длинный пробел
	html = html.replace('/&thinsp;/g', ' '); // узкий пробел
	html = html.replace('/&ndash;/g', '-'); // короткое тире
	html = html.replace('/&mdash;/g', '-'); // длинное тире
	html = html.replace('/&lsquo;/g', '\''); // открывающая одинарная кавычка
	html = html.replace('/&rsquo;/g', '\''); // закрывающая одинарная кавычка
	html = html.replace('/&lsaquo;/g', '<'); // открывающая угловая кавычка
	html = html.replace('/&rsaquo;/g', '>'); // закрывающая угловая кавычка
		
	// Таблица П6.3. Математические символы и греческие буквы
	html = html.replace('/&hellip;/g', '...'); // многоточие
	html = html.replace('/&trade;/g', '™'); // торговая марка
	return html;
}*/

function htmlspecialchars(r){
	r = r.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/'/g,'&#039;').replace(/"/g,'&quot;');
	return r;
}

function htmlspecialchars_decode(r){
	r = r.replace(/&amp;/g,'&').replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&#039;/g,'\'').replace(/&quot;/g,'"');
	return r;
}
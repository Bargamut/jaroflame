// JavaScript Document

function ajaxFileUpload(){
	$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
	
	/*
	Подготовка Ajax загрузки файлов
	url: Адрес файла сценария обработки загруженных файлов
	fileElementId: тип файла входного ID элемента, и это будет индекс $_FILES Array()
	dataType: поддержка JSON, XML
	secureuri: использовать безопасный протокол
	success: Функция обратного вызова, когда Ajax завершён
	error: функция обратного вызова, если возникла ошибка Ajax
	*/
	alert('тест');
	$.ajaxFileUpload({
		url:'../functions/doajaxfileupload.php',
		secureuri:false,
		fileElementId:'fileToUpload',
		dataType: 'json',
		success: function (data, status){
			if(typeof(data.error) != 'undefined'){
				if(data.error != ''){alert(data.error);
				}else{alert(data.msg);}
			}
		},
		error: function (data, status, e){alert(e);}
	})
	return false;
}
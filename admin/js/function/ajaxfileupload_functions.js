// JavaScript Document

function ajaxFileUpload(){
	$("#loading")
		.ajaxStart(function(){
			$(this).show();
		})
		.ajaxComplete(function(){
			$(this).hide();
		});
	
	/**
     * @desc Подготовка Ajax загрузки файлов
     * #param $url Адрес файла сценария обработки загруженных файлов
     * #param $fileElementId тип файла входного ID элемента, и это будет индекс $_FILES Array()
     * #param $dataType поддержка JSON, XML
     * #param $secureuri использовать безопасный протокол
     * #param $success Функция обратного вызова, когда Ajax завершён
     * #param $error функция обратного вызова, если возникла ошибка Ajax
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
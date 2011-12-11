function send_mail(attach){
	/*console.log('table=callback&name='+$("#user_name").val()+
	'&phone_email='+$("#user_phone_email").val()+'&message='+$("#user_message").val());*/
	var banderol = '';
	attach ? banderol = '&attach='+attach : null;
	$.ajax({
		type: "POST",
		url: "/includes/modules/callback.php",
		data: 'table=callback'+
			  '&subject='+$("#user_subject").val()+
			  '&name='+$("#user_name").val()+
			  '&phone='+$("#user_phone").val()+
			  '&email='+$("#user_email").val()+
			  '&message='+$("#user_message").val()+
			  banderol,
		cache: false,
		success: function(html){
			console.log(html);
			if(html != 'null'){
				data = eval("("+html+")");
				(data['error'] == 0)&&(data['success'] != 0) ?
				$(".send_result").show().html('Ваша заявка отправлена') :
				$(".send_result").show().html('Ошибка. Проверьте введённые данные').delay(2000).fadeOut('slow');
			}
		}
	});
	console.log('send_mail');
}

function check(){
	var empty = 0, callback_txt = $(".callback_textarea");
	$(".input").each(function(){
		$(this).val() == '' ? empty++ : null;
	});	
	if(callback_txt.val() == 'Текст сообщения' || callback_txt.val() == ''){
		empty++;
	}
	
	empty == 1 ? (
		$(".input").livequery("keydown",function(){check();}),
		callback_txt.livequery("keydown",function(){check();})
	) : (
		$(".input").expire("keydown"),
		callback_txt.expire("keydown")
	);
	
	empty == 0 ?
		$("#subm_button").css("color","#061A8D") :
		$("#subm_button").css("color","#8c8c8c");
	return empty;
}

// Загрузка файла на сервер
function ajaxFileUpload(){
	if (check() == 0){
		if($("#fileToUpload").val() != '' && check_file($('#fileToUpload'))){
			$("#loading")
				.ajaxStart(function(){$(this).show();})
				//.ajaxSend(function(e, xhr, settings){})
				.ajaxComplete(function(){$(this).hide();});
			
			/*
			Подготовка Ajax загрузки файлов
			url: Адрес файла сценария обработки загруженных файлов
			fileElementId: тип файла входного ID элемента, и это будет индекс $_FILES Array()
			dataType: поддержка JSON, XML
			secureuri: использовать безопасный протокол
			success: Функция обратного вызова, когда Ajax завершён
			error: функция обратного вызова, если возникла ошибка Ajax
			*/
			$.ajaxFileUpload({
				url:'../js/ajax.file.upload/doajaxfileupload.php?path=/uploads&name='+GeDate()+'.'+$('.filename').html()+'&fileElementName=fileToUpload',
				secureuri:false,
				fileElementId:'fileToUpload',
				dataType:'json',
				success:function (data, status){
					if(typeof(data.error) != 'undefined'){
						if(data.error != ''){console.log('ajaxFileUpload SUCCESS ERROR:\n'+data.error);
						}else{
							console.log('ajaxFileUpload: '+data.msg+
										'\nname = '+data.name+
										'\nfsize = '+data.fsize+
										'\nfaddr = '+data.faddr+
										'\nfaddr_small = '+data.faddr_small);
							send_mail(data.faddr);
						}
					}
				},
				error:function(data, status, e){console.log('ajaxFileUpload ERROR:\n'+e);}
			});
		} else {
			send_mail('');
		}
	}else{
		$(".send_result").show().html('Пожалуйста, заполните все поля').delay(2000).fadeOut('slow');
	}
	return false;
}

// Проверка, тот ли файл загружаем?
function check_file(obj){
	console.log('Проверка валидности файла');
	var fname = obj.val();
	var types = "gif|jpeg|jpg|png".split('|');
	var name = fname.split('\\');
	ext = fname.substring(fname.length-3,fname.length).toLowerCase();
	$.each(types, function(){
		if(ext != this){
			$('.filename').html('');
			result = 'false';}
		else{
			$('.filename').html(name[name.length-1]);
			result = 'true';
			return false;
		}
	});
	console.log(result);
	return result;
}

function GeDate(){
	var d = new Date();
	var date_path = d.getFullYear()+''+
					addZero(d.getMonth())+''+
					addZero(d.getDate())+''+
					addZero(d.getHours())+''+
					addZero(d.getMinutes())+''+
					addZero(d.getSeconds());
	return date_path;
}

// Добавление нуля к дате < 10
function addZero(i){
	return (i < 10) ? "0" + i : i;
}
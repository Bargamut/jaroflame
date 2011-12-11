<script type="text/javascript" language="javascript">
$(".add").livequery('mousedown', function(){
	text = '<b>Новый участник</b><br />\n'+
		   '<hr />\n'+
		   'Изображение: <br /><input type="text" class="avatar" value="" /><br />\n'+
		   'Имя: <input type="text" class="name" value="" /> \n'+
		   'Фамилия: <input type="text" class="lname" value="" /> \n'+
		   'Ник: <input type="text" class="nick" value="" /><br />\n'+
		   'Звание: <input type="text" class="rank" value="" /> \n'+
		   'Учёба/работа: <input type="text" class="learnwork" value="" /> \n'+
		   'Телефон: <input type="text" class="phone" value="" /><br />\n'+
		   'Дата рождения: <input type="text" class="bdate" value="" /> \n'+
		   'Дата вступления: <input type="text" class="sdate" value="" /><br />\n'+
		   '<input type="hidden" class="editor" value="insert" />\n'+
		   'Подопечные: <br /><textarea id="ppl" class="ppl" rows="5" cols="40"></textarea><br />\n'+
		   'Мероприятия: <br /><textarea id="fests" class="fests" rows="10" cols="40"></textarea><br />\n'+
		   '<img class="submit" src="img/default/ok.png" align="right" alt="" title="Применить" />';
	modal(text);
});

$(".del").livequery('mousedown', function(){
	id = $(this).parent().attr("id");
	confirm('Удалить запись "'+$(this).parent().find('span').html()+'"?') ? (
		$("#members"+id).detach(),
		$.ajax({
			type: "POST",
			url: 'set.php',
			data: "table=members&edit=delete&id="+id,
			cache: false,
			success: function(html){
				html != 'null' ? (
					data = eval("("+html+")"),
					modal(data.del),
					setTimeout($.unblockUI(),3000)
				) : null;
			}
		})
	) : null;
});

$(".edit").livequery('mousedown', function(){
	id = $(this).parent().attr("id");
	$.ajax({
		type: "POST",
		url: "get.php",
		data: "table=members&id="+id,
		cache: false,
		success: function(html){
			html != 'null' ? (
				data = eval("("+html+")"),
				text = '<b>Редактировать пасспорт</b><br />\n'+
					   '<hr />\n'+
					   'Изображение: <br /><input type="text" class="avatar" value="'+data.avatar+'" /><br />\n'+
					   'Имя: <input type="text" class="name" value="'+data.name+'" /> \n'+
					   'Фамилия: <input type="text" class="lname" value="'+data.lname+'" /> \n'+
					   'Ник: <input type="text" class="nick" value="'+data.nick+'" /><br />\n'+
					   'Звание: <input type="text" class="rank" value="'+data.rank+'" /> \n'+
					   'Учёба/работа: <input type="text" class="learnwork" value="'+data.learnwork+'" /> \n'+
					   'Телефон: <input type="text" class="phone" value="'+data.phone+'" /><br />\n'+
					   'Дата рождения: <input type="text" class="bdate" value="'+data.birthday+'" /> \n'+
					   'Дата вступления: <input type="text" class="sdate" value="'+data.succdate+'" /><br />\n'+
					   '<input type="hidden" class="editor" value="update" />\n'+
					   'Подопечные: <br /><textarea id="ppl" class="ppl" rows="5" cols="40">'+data.people+'</textarea><br />\n'+
					   'Мероприятия: <br /><textarea id="fests" class="fests" rows="10" cols="40">'+data.fests+'</textarea><br />\n'+
					   '<img class="submit" src="img/default/ok.png" align="right" alt="'+id+'" title="Применить" />',
				modal(text)
			) : null;
		}
	});
});

function modal(msg){
	tinyMCE.execCommand('mceRemoveControl', false, 'fests');
	tinyMCE.execCommand('mceRemoveControl', false, 'ppl');
	$.blockUI({
		message: msg,
		css: {
			width: '1000px',
			textAlign: 'left',
			border: '1px #000 solid',
			padding: '15px',
			backgroundColor: '#fff',
			cursor: 'default',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			'-khtml-border-radius': '10px',
			color: '#000'
		},
		overlayCSS: {
			cursor: 'default',
			opacity: 0.6,
			background: '#aaaaaa'
		},
		onBlock: function(){
			tinyMCE.execCommand('mceAddControl', false, 'fests');
			tinyMCE.execCommand('mceAddControl', false, 'ppl');
			
			$('.blockMsg').css({
				left:($(window).width()-$(this).width())/2,
				top:($(window).height()-$(this).height())/2,
			});
			$(".blockOverlay")
				.attr({title: 'Закрыть'})
				.livequery('mousedown',function(){
					$.unblockUI();
				});
			$(".submit").livequery("mousedown", function(){
				tinyMCE.triggerSave();
				id = $(this).attr("alt");
				query = 'table=members&'+
						'edit='+$(".editor").val()+'&'+
						'id='+id+'&'+
						'nam='+encodeURIComponent($(".name").val())+'&'+
						'lnam='+encodeURIComponent($(".lname").val())+'&'+
						'nick='+encodeURIComponent($(".nick").val())+'&'+
						'ava='+encodeURIComponent($(".avatar").val())+'&'+
						'phn='+encodeURIComponent($(".phone").val())+'&'+
						'fst='+encodeURIComponent($(".fests").val())+'&'+
						'lrn='+encodeURIComponent($(".learnwork").val())+'&'+
						'bdate='+encodeURIComponent($(".bdate").val())+'&'+
						'sdate='+encodeURIComponent($(".sdate").val())+'&'+
						'rnk='+encodeURIComponent($(".rank").val())+'&'+
						'ppl='+encodeURIComponent($(".ppl").val());
				$.ajax({
					type: "POST",
					url: "set.php",
					data: query,
					cache: false,
					success: function(resp){
						resp != 'null' ? (
							data2 = eval("("+resp+")"),
							$.ajax({
								type: "POST",
								url: "get.php",
								data: 'table=members&id='+data2.id,
								cache: false,
								success: function(html2){
									html2 != 'null' ? (
										data3 = eval("("+html2+")"),
										$(".editor").val() == 'insert' ?
										$(".members").prepend(
											'<li id="members'+data2.id+'">\n'+
											'<img class="ava" src="'+data3.avatar+'" align="left">\n'+
											'<div id="'+data2.id+'" class="mcaption">\n'+
												'<span></span>\n'+
                        '<img class="del" src="img/default/del.png" align="right" title="Удалить" />\n'+
                        '<img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />\n'+
											'</div>\n'+
											'</li>\n')
										: null,
										$("#members"+data2.id+"> .mcaption > span").html(
											data3.lname+' "'+
											data3.nick+'" '+
											data3.name
										),
										
										$(".blockMsg").html(data2.resp),
										setTimeout($.unblockUI,1500)
									) : null;
								}
							})
						) : null;
					}
				});
			});
		}
	});
}
</script>
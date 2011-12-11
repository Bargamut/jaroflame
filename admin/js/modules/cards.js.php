<script type="text/javascript" language="javascript">
$(".add").livequery('mousedown', function(){
	text = '<b>Новый пасспорт</b><br />\n'+
		   '<hr />\n'+
		   'Название: <br /><input type="text" class="capt" value="" /><br />\n'+
		   'Имя: <br /><input type="text" class="name" value="" /><br />\n'+
		   'Фамилия: <br /><input type="text" class="lname" value="" /><br />\n'+
		   'Ник: <br /><input type="text" class="nick" value="" /><br />\n'+
		   'Изображение: <br /><input type="text" class="avatar" value="" /><br />\n'+
		   '<input type="hidden" class="editor" value="insert" />\n'+
		   'Содержание: <br /><textarea id="cont" class="cont"></textarea><br />\n'+
		   '<img class="submit" src="img/default/ok.png" align="right" alt="" title="Применить" />';
	modal(text);
});

$(".del").livequery('mousedown', function(){
	id = $(this).parent().attr("id");
	confirm('Удалить запись "'+$(this).parent().find('span').html()+'"?') ? (
		$("#cards"+id).detach(),
		$.ajax({
			type: "POST",
			url: 'set.php',
			data: "table=cards&edit=delete&id="+id,
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
		data: "table=cards&id="+id,
		cache: false,
		success: function(html){
			html != 'null' ? (
				data = eval("("+html+")"),
				text = '<b>Редактировать пасспорт</b><br />\n'+
					   '<hr />\n'+
					   'Название: <br /><input type="text" class="capt" value="'+data.caption+'" /><br />\n'+
					   'Имя: <br /><input type="text" class="name" value="'+data.name+'" /><br />\n'+
					   'Фамилия: <br /><input type="text" class="lname" value="'+data.lname+'" /><br />\n'+
					   'Ник: <br /><input type="text" class="nick" value="'+data.nick+'" /><br />\n'+
					   'Изображение: <br /><input type="text" class="avatar" value="'+data.avatar+'" /><br />\n'+
					   '<input type="hidden" class="editor" value="update" />\n'+
					   'Содержание: <br /><textarea id="cont" class="cont">'+data.content+'</textarea><br />\n'+
					   '<img class="submit" src="img/default/ok.png" align="right" alt="'+id+'" title="Применить" />',
				modal(text)
			) : null;
		}
	});
});

function modal(msg){
	tinyMCE.execCommand('mceRemoveControl', false, 'cont');
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
			tinyMCE.execCommand('mceAddControl', false, 'cont');
			
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
				query = 'table=cards&'+
						'edit='+$(".editor").val()+'&'+
						'id='+id+'&'+
						'pg=&'+
						'cpt='+encodeURIComponent($(".capt").val())+'&'+
						'nam='+encodeURIComponent($(".name").val())+'&'+
						'lnam='+encodeURIComponent($(".lname").val())+'&'+
						'nick='+encodeURIComponent($(".nick").val())+'&'+
						'ava='+encodeURIComponent($(".avatar").val())+'&'+
						'cnt='+encodeURIComponent($(".cont").val());
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
								data: 'table=cards&id='+data2.id,
								cache: false,
								success: function(html2){
									html2 != 'null' ? (
										data3 = eval("("+html2+")"),
										$(".editor").val() == 'insert' ?
										$(".cards").prepend(
											'<li id="cards'+data2.id+'">\n'+
											'<img class="ava" src="/img/cards/test/thumb/'+data3.avatar+'" align="left">\n'+
											'<div id="'+data2.id+'" class="ccaption">\n'+
												'<span></span>\n'+
                        '<img class="del" src="img/default/del.png" align="right" title="Удалить" />\n'+
                        '<img class="edit" src="img/default/edit.png" align="right" title="Редактировать" />\n'+
											'</div>\n'+
											'<div class="ccontent"></div>\n'+
											'</li>\n')
										: null,
										$("#cards"+data2.id+"> .ccaption > span").html(
											data3.lname+' "'+
											data3.nick+'" '+
											data3.name
										),
										$("#cards"+data2.id+"> .ccontent").html(htmlspecialchars_decode(data3.caption)),
										
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
<?php
$text = file_get_contents('./patterns/member.editor.html');
$text = implode('\n'."'+\n'", explode("\r\n", $text));
?>
<script type="text/javascript" language="javascript">
$(".add").expire().livequery('mousedown', function(){
	text = '<b>Добавить участника</b><br />\n'+
           '<hr />\n'+
           '<?=$text?>'+
           '<input type="hidden" class="editor" value="insert" />\n'+
           '<img class="submit" src="img/default/ok.png" align="right" alt="" title="Применить" />';
	modal(text) ? createUploader() : null;
});

$(".del").expire().livequery('mousedown', function(){
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
					modal(data.resp),
					setTimeout($.unblockUI(),3000)
				) : null;
			}
		})
	) : null;
});

$(".edit").expire().livequery('mousedown', function(){
	id = $(this).parent().attr("id");
	$.ajax({
		type: "POST",
		url: "get.php",
		data: "table=members&id="+id,
		cache: false,
		success: function(html){
			html != 'null' ? (
				data = eval("("+html+")"),
				text = '<b>Редактировать участника</b><br />\n'+
					   '<hr />\n'+
					   '<?=$text?>'+
                       '<input type="hidden" class="editor" value="update" />\n'+
					   '<img class="submit" src="img/default/ok.png" align="right" alt="'+id+'" title="Применить" />',
				modal(text) ? (
                    $('#ava').attr({src: data.avatar}),
                    $('#ava_prev > img').attr({src: data.avatar}),
                    $('.avatar').val(data.avatar),
                    $('.name').val(data.name),
                    $('.lname').val(data.lname),
                    $('.nick').val(data.nick),
                    $('.rank').val(data.rank),
                    $('.learnwork').val(data.learnwork),
                    $('.phone').val(data.phone),
                    $('.bdate').val(data.birthday),
                    $('.sdate').val(data.succdate),
                    $('.ppl').val(data.people),
                    $('.fests').val(data.fests),
                    createUploader()
                ) : null
			) : null;
		}
	});
});

$('#ava').expire().livequery("mousedown", function(){
    createCrop($(this), 147, 186);
});
$('#ava_subm').expire().livequery("mousedown", function(){
    $.ajax({
        type: "POST",
        url: "images.php",
        data: 'm=crop'+
              '&src='+$('.avatar').val()+
              '&dest='+$('.avatar').val()+
              '&t='+$('.ava_t').val()+
              '&l='+$('.ava_l').val()+
              '&w='+$('.ava_w').val()+
              '&h='+$('.ava_h').val(),
        cache: false
    });
    $(this).parent().fadeOut('fast');
    $('#ava').attr({src:$('.avatar').val()});
});

function modal(msg){
    tinyMCE.execCommand('mceRemoveControl', false, 'fests');
    tinyMCE.execCommand('mceRemoveControl', false, 'ppl');
	$('body').block({
		message: msg,
		css: {
			width: '1100px',
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
				top:($(window).height()-$(this).height())/2
			});
			$(".blockOverlay")
				.attr({title: 'Закрыть'})
				.livequery('mousedown',function(){
					$.unblockUI();
				});
			$(".submit").expire().livequery("mousedown", function(){
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

    return true;
}

/**
 * Функция создания мультизагрузки
 */
function createUploader(){
    var uploader = new qq.FileUploader({
        element: $('.multiupload')[0],
        action: 'upload.php',
        params: {
            path: '/img/members'
        },
        multiple: false,
        allowedExtensions: ['jpg', 'jpeg', 'png', 'gif'],
        sizeLimit: 0, // max size
        minSizeLimit: 0, // min size

// set to true to output server response to console
        debug: false,

// events
// you can return false to abort submit
        onSubmit: function(id, fileName){},
        onProgress: function(id, fileName, loaded, total){},
        onComplete: function(id, fileName, responseJSON){
            $('.avatar').val(responseJSON.faddr);
            $('#ava').attr({src : responseJSON.faddr});
            createCrop($('#ava'), 147, 186);
            $('#ava_subm').show();
            $('.qq-upload-success').fadeOut('fast').remove();
        },
        onCancel: function(id, fileName){},

        messages: {
            // error messages, see qq.FileUploaderBasic for content
        },
        showMessage: function(message){
            alert(message);
        }
    });
}

function createCrop($obj, w, h){
    $obj.Jcrop({
        onSelect: showPreview,
        onChange: showPreview,
        onRelease: hidePreview,
        bgColor: 'black',
        bgOpacity: .4,
        minSize: [w, h],
        aspectRatio: w / h
    });
}

/** Превью для Jcrop
 * @param coords
 */
function showPreview(coords){
    if (parseInt(coords.w) > 0){
        var rx = $('#ava_prev').width() / coords.w,
            ry = $('#ava_prev').height() / coords.h;

        $('#ava_prev > img').css({
            width: Math.round(rx * $('#ava').width()) + 'px',
            height: Math.round(ry * $('#ava').height()) + 'px',
            marginLeft: '-' + Math.round(rx * coords.x) + 'px',
            marginTop: '-' + Math.round(ry * coords.y) + 'px'
        });

        $('.ava_t').val(coords.y);
        $('.ava_l').val(coords.x);
        $('.ava_w').val(coords.w);
        $('.ava_h').val(coords.h);

        $('#ava_thumb').fadeIn('fast');
    }
}

/** Показать превью Jcrop
 */
function hidePreview(){
    $('#ava_thumb').fadeOut('fast');
}
</script>
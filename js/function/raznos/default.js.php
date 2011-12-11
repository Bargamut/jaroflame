<script type="text/javascript" language="javascript">
// Загрузка контента
function put_content(table,id,address,person,caption,nick,text){
	i=0,i_arrow=0;
	console.log('put_content!');
	//$("#Caption").val(htmlspecialchars_decode(decodeURIComponent(caption)));
	$(".user_nickname").html('<span>Прислал:</span> '+htmlspecialchars_decode(decodeURIComponent(nick)));
	$(".user_text").html('<span>Сообщение:</span> '+htmlspecialchars_decode(decodeURIComponent(text)));
	
	select_user(person);
	$("#container").html('<img id="resource" src="" alt="" />');
	
	$.ajax({
		type: "POST",
		url: "get_raznos.php",
		data: "table="+table+"&address="+address,
		cache: false,
		success: function(html){
			console.log(html);
			if(html != 'null'){
				var data = eval("("+html+")");
				console.log(data);
				var key = 0;
				for(key in data){
					var obj_type = data[key].element_id.split('_');
					switch(obj_type[0]){
						case 'none':
							console.log('NONE: '+data[key].element_id+'\n');
							$("#resource").attr("src",data[key].fpath);
							break;
						case 'arrow':
							console.log('ARROW: '+data[key].element_id+'\n');
							add_arrow(
								'no',
								data[key].element_id,
								data[key].fpath,
								data[key].style,
								data[key].parentstyle,
								data[key].id);
							break;
						default:
							console.log('DEFAULT(element): '+data[key].element_id+'\n');
							add_element(
								data[key].element_id,
								data[key].content,
								data[key].style,
								data[key].parentstyle,
								data[key].id);
							break;
					}
				}
			}else{
				$("#Content").text('');
			}
		}
	});
	return false;
}

// добавление элемента
function add_element(element_id,content,style,parentstyle,bd_id){
	var dID = 'draggable'+i;
	if(element_id){console.warn('ID элемента = '+element_id);dID=element_id;}
	if(!content){console.warn('CONTENT = FALSE');content = '';}
	if(!parentstyle){console.warn('PARENTSTYLE = FALSE');parentstyle = '';element_style='';}else{element_style='style="'+parentstyle+'"';}
	if(!bd_id){console.warn('ID в БД = FALSE');bd_id = '';}
	
	// код самого блока
	var element =
	'<div id="'+dID+'" class="draggable" '+element_style+'>'+'\n'+
		'<div id="text_'+dID+'" class="text_draggable">'+content+'</div>'+'\n'+
    '</div>'+'\n';
	// добавление в контейнеры
	$("#container").append(element);
	i++;
}

// добавление стрелки
function add_arrow(arID,element_id,fpath,style,parentstyle,bd_id){
	var adID = 'arrow_draggable'+i_arrow;
	var option = arID.split("_");
	if(element_id){
		console.log('ID стрелки: '+element_id);
		adID=element_id;}
	if(!fpath){fpath = $("#"+arID).attr("src");}
	if(!parentstyle){
		parentstyle='';
		element_style = 'style="width:'+option[1]+'px; height:'+option[2]+'px;"';}
	else{element_style = 'style="'+parentstyle+'"';}
	if(!bd_id){bd_id='';}
	// код самого блока
	var arrow =
	'<div id="'+adID+'" class="draggable_arrow" '+element_style+'>'+'\n'+
		'<img src="'+fpath+'" />'+
    '</div>';
	// добавление в контейнеры
	$("#container").append(arrow);
	i_arrow++;
}
</script>
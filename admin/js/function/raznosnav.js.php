<script type="text/javascript" language="javascript">
var way = '';

$(".arrow_left").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($(this).attr('alt'));
	way = 'left';	
});
$(".arrow_right").livequery('mousedown',function(){
	mouse_on(this.id,'down');
	set_hash($(this).attr('alt'));
	way = 'right';
});
$(".show_hide_blocks> span").livequery('mousedown',function(){
	$(".draggable").toggle();
	$(".draggable_arrow").toggle();
	if($(".draggable").css("display") == "block"){
		$(".show_hide_blocks> span").html("скрыть комментарии");
	}else{
		$(".show_hide_blocks> span").html("показать комментарии");
	}
});

$(".draggable").livequery('mouseover',function(){console.log('Навёл!');$(this).css("z-index","1050");});

// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nqueryString:'+$.address.queryString()
	);
	
	post = $.address.queryString();
	query = 'a='+post;
	
	console.log(query);
	get_raznos(query,'photo_box','photo_container');
});

function set_hash(address){
	$.address.value('?'+address);
}

// Загрузка контента
function get_raznos(query,boxID,containerID){
	var box = $("#"+boxID), container = $("#"+containerID);
	i=0,i_arrow=0;
	console.log('put_content!');
	
	//$(".middle").html('<img id="resource" src="" alt="" />');
	
	$.ajax({
		type: "POST",
		url: "get_raznos.php",
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				var data = eval("("+html+")");
				console.warn(data);
				
				switch(way){
					case 'left':round_roll('photo_box','photo_container',this.id,'arrow_right','right');break;
					case 'right':round_roll('photo_box','photo_container','arrow_left',this.id,'left');break;
					default:break;
				}
				
				// Если есть предыдущий (более новый) элемент
				data['prev'] ? (
					$(".arrow_left").show().attr("alt",data['prev'].address),
					$(".address_prev").html(data['prev'].address)
				) : (
					$(".arrow_left").hide(), $(".address_prev").html(''));
				
				// Если есть следующий (более старый) элемент
				data['next'] ? (
					$(".arrow_right").show().attr("alt",data['next'].address),
					$(".address_next").html(data['next'].address)
				) : (
					$(".arrow_right").hide(), $(".address_next").html(''));
				
				for(key in data['middle_content']){
					var obj_type = data['middle_content'][key].element_id.split('_');
					switch(obj_type[0]){
						case 'none':
							console.log('NONE: '+data['middle_content'][key].fpath+'\n');
							//$("#Caption").val(decodeURIComponent(data['middle_content'][key].caption));
							$(".user_nickname").html('<span>Прислал:</span> '+decodeURIComponent(data['middle_content'][key].sender));
							$(".user_text").html('<span>Сообщение:</span> '+decodeURIComponent(data['middle_content'][key].text));
							$(".middle").append(
								'<div>\n'+
									'<img id="resource" class="img_prew" src="'+data['middle_content'][key].fpath+'" alt="" title="" onmousedown="return false;" />\n'+
								'</div>'
							);
							select_user(data['middle_content'][key].person,data['middle_users']);
							//$("#resource").attr("src",data['middle_content'][key].fpath);
							$('title').html(data['middle_content'][key].caption);
							break;
						case 'arrow':
							console.log('ARROW: '+data['middle_content'][key].element_id+'\n');
							add_arrow(
								'no',
								data['middle_content'][key].element_id,
								data['middle_content'][key].fpath,
								data['middle_content'][key].style,
								data['middle_content'][key].parentstyle,
								data['middle_content'][key].id);
							break;
						default:
							console.log('DEFAULT(element): '+data['middle_content'][key].element_id+'\n');
							add_element(
								data['middle_content'][key].element_id,
								htmlspecialchars_decode(data['middle_content'][key].content),
								data['middle_content'][key].style,
								data['middle_content'][key].parentstyle,
								data['middle_content'][key].id);
							break;
					}
				}
				
				console.warn($(".middle").height());
				box.css("height", $(".middle").height());
				container.css("height", $(".middle").height());
				$(".draggable").css({display:"none"});
				$(".draggable_arrow").css({display:"none"});
				$(".show_hide_blocks> span").html("показать комментарии");
				
			}else{
				$(".middle").text('');
			}
		}
	});
				console.warn($(".middle").height());
	return false;
}

// Выбор разносящего
function select_user(id,obj){
	console.warn('select_user: '+id);
	$("#avatar").attr("src","/images/avatars/"+obj[id].avatar);
	$(".avatar_name").html('Рецензировал<br>'+obj[id].name+' '+obj[id].lastname);
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
	$(".middle").append(element);
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
	$(".middle").append(arrow);
	i_arrow++;
}
</script>
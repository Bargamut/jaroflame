<script language="javascript" type="text/javascript">
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
$(".pay_but").livequery("mousedown", function(){get_pay();});
$(".close_pay> img").livequery("mousedown", function(){close_pay();});
$(".all_assortiment").livequery("mousedown", function(){
	var all_cont = $.address.queryString().split('.');
	set_hash_all(all_cont[0]);
});

function change_img(img){
	console.warn('Изменение картинки');
	page = img.attr("id").split(".");
	$("#post_img").attr("src",'/images/shop/'+page[0]+'/'+img.attr("id"));
	$(".slider_points").each(function(){$(this).attr({src:"/images/default/point1.png",alt:""});});
	img.attr({src:"/images/default/point2.png",alt:"active"});
	
	var img2 = new Image();
	img2.onload = function(){
		this.width > 440 ? $("#post_img").css("width",'440px') : $("#post_img").css("height",this.height+'px');
		
		console.log('Высота картинки(load): '+$("#post_img").height());
		$(".shop_content").css("height", $("#post_img").height());
		$(".middle").css("height",($("#post_img").height()+$(".bt").height())+'px');
		$("#shop_box").css("height", $(".middle").height());
		$("#shop_container").css("height", $(".middle").height());
	};
	img2.src = '/images/'+page[0]+'/'+img.attr("id");
}

// Изменение адресной строки
$.address.change(function(){
	console.warn(
		'Изменение адреса HASH!'+
		'\nqueryString:'+$.address.queryString()
	);
	
	post = $.address.queryString().split('&');
	query = 'a='+post[0];
	
	console.log(post);
	post[1] == 'all' ?
		get_shop_all('p='+post[0]) :
		get_shop(query,'shop_box','shop_container');
});

function set_hash(address){
	$.address.value('?'+address);
}

function set_hash_all(address){
	$.address.value('?'+address+'&all');
}

function reload_shop(address){
	$.ajax({
		type: "POST",
		url: '/includes/modules/shopslider.php',
		cache: false,
		success: function(html){
				$(".shop_cont").html(html);
				set_hash(address);
				WH_init('shop_box','shop_navigation','width',0,0.33);
		}
	});
}

function get_shop(query,boxID,containerID){
	box = $("#"+boxID), container = $("#"+containerID);
	$.ajax({
		type: "POST",
		url: '/get_shop.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				//$(".middle").html('');
				
				page = data['middle'].address.split('.');
				switch(way){
					case 'left':round_roll('shop_box','shop_container',this.id,'arrow_right','right');break;
					case 'right':round_roll('shop_box','shop_container','arrow_left',this.id,'left');break;
					default:break;
				}
				
				var imgs = '';
				/*if(!data['middle_imgs'].length){
					imgs = '<img onclick="change_img($(this));" class="slider_points" id="'+data['middle'].address+'" src="/images/default/point2.png" alt="active" />';
					for (key in data['middle_imgs']){
						imgs +=
							'<img onclick="change_img($(this));" class="slider_points" id="'+data['middle_imgs'][key].content+'" src="/images/default/point1.png" />';
					}
				}*/
				
				// Если есть предыдущий (более новый) элемент
				data['prev'] ? (
					$(".arrow_left").show().attr("alt",data['prev'].address),
					date_prev = 
						'<div class="shop_date_prev">'+
							data['prev'].date_visible+
						'</div>'
				) : (
					$(".arrow_left").hide(), date_prev ='');
				
				// Если есть следующий (более старый) элемент
				data['next'] ? (
					$(".arrow_right").show().attr("alt",data['next'].address),
					date_next = 
						'<div class="shop_date_next">'+
							data['next'].date_visible+
						'</div>'
				) : (
					$(".arrow_right").hide(), date_next = '');
					
				var properties = data['middle'].title.split(','),
					block_properties = '<div class="pay_but">заказать</div>';
				for (i in properties){
					//console.log(properties[i]);
					var property = properties[i].split(':');
					switch(property[0]){
						case 'Цена': prop_id = 'cost'; rub_simbol = ' <span class="rur">p<span>уб.</span></span>';break;
						case 'Высота': prop_id = 'height'; rub_simbol = '';break;
						default: prop_id = 'default'; rub_simbol = '';break;
					} 
						block_properties += '<div class="shop_'+prop_id+'">'+property[0]+': <span>'+property[1]+'</span>'+rub_simbol+'</div>';
				}
				
				$(".middle").html(
					'<div class="shop_content">'+
						'<img id="post_img" src="/images/shop/'+page[0]+'/'+data['middle'].address+'" alt="'+data['middle'].caption+'" style="max-width:440px;" />'+
						'<div class="nav" align="center">'+imgs+'</div>'+
						'<div class="shop_text_block">'+
							'<div class="shop_text_header"><span>'+data['middle'].caption+'</span></div>'+
							'<div class="shop_text">'+data['middle'].content+'</div>'+
							block_properties+
							'<div class="all_assortiment">показать все</div>'+
						'</div>'+
					'</div>'+
					date_prev+
					date_next+
					'<div class="shop_address">'+data['middle'].address+'</div>');
					
				/*var img = new Image();
				img.onload = function(){
					this.width > 440 ? $("#post_img").css("width",'440px') : $("#post_img").css("height",this.height+'px');
					
					console.log('Высота картинки(load): '+$("#post_img").height());
					$(".shop_content").css("height", $("#post_img").height());
					$(".middle").css("height",($("#post_img").height()+50)+'px');
					$("#shop_box").css("height", $(".middle").height());
					$("#shop_container").css("height", $(".middle").height());
				};
				img.src = '/images/shop/'+page[0]+'/'+data['middle'].address;*/
				
				$('title').html(data['middle'].caption);
			}else{
				$(".middle").html('');
			}
			//console.log(data);
		}
	});
}

// Показать все игрушки
function get_shop_all(query){
	var images = '';
	$.ajax({
		type: "POST",
		url: '/get_shop_all.php',
		data: query,
		cache: false,
		success: function(html){
			if(html != 'null'){
				data = eval("("+html+")");
				var count = 0;
				for(i in data){
					images += '<img class="shop_all_img" src="/images/shop/'+data[i].mode+'/thumb/small_'+i+'" border="0" onmousedown="reload_shop(\''+i+'\',\''+data[i].date_visible+'\');" />\n';
					count++;
					count == 4 ? (images += '<br />', count = 0) : null;
				}
				$('title').html('Магазин');
			}else{
				$(".middle").html('');
			}
			$(".shop_cont").html(images);
			//console.log(data);
		}
	});
}

function get_pay(){
	$.ajax({
		type: "POST",
		url: '/get_pay.php',
		data: query,
		cache: false,
		success: function(html){
			$.blockUI({
				message:html,
				css: {
					width: '500px',
					height: '350px',
					top: ($(window).height()-350)/2 + 'px',
					left: ($(window).width()-500)/2 + 'px',
					//position:'absolute',
					border: 'none',
					padding: '10px 10px 20px 30px',
					backgroundColor: '#fff',
					cursor: 'default',
					'-webkit-border-radius': '10px',
					'-moz-border-radius': '10px',
					'-khtml-border-radius': '10px',
					color: '#000'
				},
				overlayCSS: {
					cursor: 'default',
					opacity: 0.7,
					background: '#000000'
				},
				onBlock: function(){
					$('body').css({overflow:'hidden'});
					$("#user_subject").val('Магазин, Заказ, '+$(".shop_text_header> span").html());
					$(".shop_choise> span").html($(".shop_text_header> span").html());
				},
				fadeOut: 0,
				fadeIn: 0
			});
		}
	});
}

function close_pay(){
	$.unblockUI({
		onUnblock: function(){
			$('body').css({overflow:''});
		},
		fadeOut: 0,
		fadeIn: 0
	});
}
</script>
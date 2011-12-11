// JavaScript Document

// Прокрутка фотографий
function modal_roll_photos(way){
	switch (way){
		case 'left': $("#photo_box_modal").animate({left: "-=560px"}, {duration: 400, queue: true}, function(){return false;});
			return false;
			break;
		case 'right': $("#photo_box_modal").animate({left: "+=560px"}, {duration: 400, queue: true}, function(){return false;});
			return false;
			break;
	}
}

// Мышь на стрелке навигации
function modal_mouse_on(rID, step, row_name){
	//alert(step+"\n"+row_name);
	if (step == 'in'){row_name += '_mover';}
	if (row_name == 'left'){
		$("#"+rID).attr("src", "images/default/photo_slider/nav_arrow_"+row_name+".png");
		return false;
	}else{
		$("#"+rID).attr("src", "images/default/photo_slider/nav_arrow_"+row_name+".png");
		return false;
	}
}

// Мышь на контейнере
function modal_fade_nav(step){
	switch (step){
		case 0: $("#photo_nav_panel_modal").css("opacity", "0");
			return false;
			break;
		case 1: $("#photo_nav_panel_modal").css("opacity", "1");
			return false;
			break;
	}
}

function modal_show_album(pID){
	$.ajax({
		type: "POST",
		url: "get_album.php",
		data: "table=images&album="+pID,
		cache: false,
		success: function(html){
			$.blockUI({
				message: html,
				css: {
					top:  ($(window).height() - $(window).height()*0.9) /2 + 'px', 
                	left: ($(window).width() - $(window).width()*0.9) /2 + 'px',
					width: '90%',
					height: '90%',
					border: 'none',
					padding: '5px',
					backgroundColor: '#fff',
					cursor: 'default',
					'-webkit-border-radius': '10px',
					'-moz-border-radius': '10px',
					'-khtml-border-radius': '10px',
					'behavior':'url("../../PIE.htc")',
					'border-radius':'10px',
					color: '#000'
            } 
			});
			$('.blockOverlay').css('cursor', 'default');
			$('.blockOverlay').attr('title','Выйти').click($.unblockUI);
		}
	});
}
// JavaScript Document

// Прокрутка фотографий
function modal_roll_photos(lID,rID,way,roll_size){
	var left_nav = lID, right_nav = rID, koeff;
	switch (way){
		case 'left': koeff = '-';break;
		case 'right': koeff = '+';break;
	}
	$("#photo_box_modal").animate(
		{left: koeff+"="+roll_size+"px"},
		{duration: 400, queue: true, easing: "linear",
		complete:function(){
			var left_box = $("#photo_box_modal").offset().left;
			var right_box = $("#photo_box_modal").offset().left + $("#photo_box_modal").width();
			var con_width = $("#photo_container_modal").width();
			// Крайне правое положение
			if(left_box<0&&right_box<=con_width){
				$("#"+left_nav).css("display", "none");
				$("#"+right_nav).css("display", "block");
			}
			// Крайне левое положение
			if(left_box>=0&&right_box>con_width){
				$("#"+left_nav).css("display", "block");
				$("#"+right_nav).css("display", "none");
			}
			// Где-то между левым и правым краем
			if(left_box<0&&right_box > con_width){
				$("#"+left_nav).css("display", "block");
				$("#"+right_nav).css("display", "block");
			}
		}
	});
	return false;
}

// Мышь на стрелке навигации
function modal_mouse_on(rID, step, row_name){
	//alert(step+"\n"+row_name);
	if (step == 'in'){row_name += '_mover';}
	$("#"+rID).attr("src", "images/default/photo_slider/nav_arrow_"+row_name+".png");
	return false;
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
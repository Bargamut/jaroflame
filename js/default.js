// JavaScript Document

$(".topmenu li").livequery("mouseover mouseout", function(){
	$(this).find(".submenu").css("display") == "block" ?
	$(this).find(".submenu").hide()	: $(this).find(".submenu").show();
});
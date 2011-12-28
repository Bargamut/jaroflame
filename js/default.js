// JavaScript Document

$(".topmenu li").expire().livequery("mouseover mouseout", function(){
	$(this).find(".submenu").css("display") == "block" ?
	$(this).find(".submenu").hide()	: $(this).find(".submenu").show();
});

$('.spoil_head').livequery("mousedown", function(){
    $(this).parent().find(".spoil_cont").stop(true,true).slideToggle("slow");
})
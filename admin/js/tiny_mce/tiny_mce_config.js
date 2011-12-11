$(document).ready(function(){	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		language:"ru",
		//editor_selector:"mceSimple",
		editor_deselector : "mceNoEditor",
		plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
		
		//file_browser_callback : "tinyBrowser",
		
		// Theme options
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect,slice,red_line",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,media,cleanup,help,code,|,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "",
		//theme_advanced_buttons5 : "insertfile,insertimage",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		theme_advanced_fonts : "Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Calibri=calibri,book antiqua,century gothic;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats",
		
		setup : function(ed){
			// Display an alert onclick
			ed.onClick.add(function(ed){//ed.windowManager.alert('User clicked the editor.');
			});
	
			/*// Add a custom button
			ed.addButton('slice',{
				title: 'Разделить',
				image: '/js/tiny_mce/themes/advanced/img/slice.gif',
				onclick: function() {ed.selection.setContent('\n<p>[slice]</p>\n');}
			});*/
		},
		// Example content CSS (should be your site CSS)
		//content_css : "/style/default/tinymce.css, /style/default/tinymce_site.css",
	
		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",
		
		file_browser_callback : "tinyBrowser",
	
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'},
			{title : 'Text Style'}
		],
		
		// отключение относительных путей
		relative_urls : true,
		// отключение обрезки хоста
		remove_script_host : true,
		//force_br_newlines : true,
		//force_p_newlines : false,
	
		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
});
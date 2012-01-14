// JavaScript Document

$(".topmenu li").expire().livequery("mouseover mouseout", function(){
    $(this).find(".submenu").css("display") == "block" ?
        $(this).find(".submenu").hide()	: $(this).find(".submenu").show();
});

$('.spoil_capt').livequery("mousedown", function(){
    $(this).parent().find(".spoil_cont").stop(true,true).slideToggle("slow");
});

/**
 * Функция создания мультизагрузки
 * @param $obj
 * @param ext
 * @param multi
 */
function createUploader($obj, ext, multi){
    var u = new qq.FileUploader({
        element: $obj,
        action: 'upload.php',
        multiple: multi,
        allowedExtensions: ext,
        sizeLimit: 0, // max size
        minSizeLimit: 0, // min size

// set to true to output server response to console
        debug: false,

// events
// you can return false to abort submit
        onSubmit: function(id, fileName){},
        onProgress: function(id, fileName, loaded, total){},
        onComplete: function(id, fileName, responseJSON){
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

    // Вызов функции присвоения параметров загрузчику
    setUplParams(u);
}

/** Инициализация Jcrop
 * @param $obj
 * @param w
 * @param h
 */
function createCrop($obj, w, h){
    $obj.Jcrop({
        setSelect:[0, 0, w, h],
        onSelect: showPreview,
        onChange: showPreview,
        onRelease: hidePreview,
        bgColor: 'black',
        bgOpacity: .4,
        minSize: [w, h],
        aspectRatio: w / h
    },function(){
        jcrop_api = this;
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
/**
 * Created with JetBrains PhpStorm.
 * User: Bargamut
 * Date: 14.07.12
 * Time: 4:08
 */
$(function() {
    // Для страницы авторизации
    $('#auth_email, #auth_pass', '#auth_form').focus(function() {
        if ($(this).val() == 'E-Mail' || $(this).val() == 'Пароль') { $(this).val(''); }
    });
    $('#auth_email', '#auth_form').blur(function() {
        if ($(this).val() == '') { $(this).val('E-Mail'); }
    });
    $('#auth_pass', '#auth_form').blur(function() {
        if ($(this).val() == '') { $(this).val('Пароль'); }
    });

    // Для миниавторизации
    $('#auth_email, #auth_pass', '#auth_form_mini').focus(function() {
        if ($(this).val() == 'E-Mail' || $(this).val() == 'Пароль') { $(this).val(''); }

        deform($(this), '+');
    });
    $('#auth_email', '#auth_form_mini').blur(function() {
        if ($(this).val() == '') { $(this).val('E-Mail'); }

        deform($(this), '-');
    });
    $('#auth_pass', '#auth_form_mini').blur(function() {
        if ($(this).val() == '') { $(this).val('Пароль'); }

        deform($(this), '-');
    });
});

/**
 * Деформация ширины объектов
 * @param o - объект
 * @param k - увеличить / уменьшить
 */
function deform(o, k){ o.stop().animate({ width: k + "=100px" }, 300); }
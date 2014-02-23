/**
 * Created with JetBrains PhpStorm.
 * User: Bargamut
 * Date: 14.07.12
 * Time: 4:08
 */
$(function() {
    // Для страницы авторизации
    $('#aEmail, #aPass').focus(function() { $(this).val() == 'E-Mail' || $(this).val() == 'Пароль' ? $(this).val('') : null; });
    $('#aEmail').blur(function() { $(this).val() == '' ? $(this).val('E-Mail') : null; });
    $('#aPass').blur(function() { $(this).val() == '' ? $(this).val('Пароль') : null; });

    // Для миниавторизации
    $('#maEmail, #maPass').focus(function() {
        $(this).val() == 'E-Mail' || $(this).val() == 'Пароль' ? $(this).val('') : null;
        deform($(this), '+');
    });
    $('#maEmail').blur(function() {
        $(this).val() == '' ? $(this).val('E-Mail') : null;
        deform($(this), '-');
    });
    $('#maPass').blur(function() {
        $(this).val() == '' ? $(this).val('Пароль') : null;
        deform($(this), '-');
    });
});

/**
 * Деформация ширины объектов
 * @param o - объект
 * @param k - увеличить / уменьшить
 */
function deform(o, k){ o.stop().animate({ width: k + "=100px" }, 300); }
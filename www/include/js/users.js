/**
 * User: Bargamut
 * Date: 14.07.12
 * Time: 4:08
 */
$(function() {
    // Для страницы регистрации
    $('#reg_nickname, #reg_email, #reg_pass', '#reg_form')
        .focus(function() {
            if ($(this).val() == 'Логин' ||
                $(this).val() == 'Email' ||
                $(this).val() == 'Пароль') { $(this).val(''); }
        })
        .blur(function() {
            if ($(this).val() == '') {
                if ($(this).attr('id') == 'reg_nickname') { $(this).val('Логин'); }
                if ($(this).attr('id') == 'reg_email') { $(this).val('Email'); }
                if ($(this).attr('id') == 'reg_pass') { $(this).val('Пароль'); }
            }
        });

    // Для миниавторизации
    $('#auth_email, #auth_pass', '#auth_form_mini')
        .focus(function() {
            if ($(this).val() == 'Email' ||
                $(this).val() == 'Пароль') { $(this).val(''); } deform($(this), '+');
        })
        .blur(function() {
            if ($(this).val() == '') {
                if ($(this).attr('id') == 'auth_email') { $(this).val('Email'); }
                if ($(this).attr('id') == 'auth_pass') { $(this).val('Пароль'); }
            }

            deform($(this), '-');
        });

    $('#reg_showpass').on('click', showPass);
});

/**
 * Деформация ширины объектов
 * @param o - объект
 * @param k - увеличить / уменьшить
 */
function deform(o, k){ o.stop().animate({ width: k + "=100px" }, 300); }

/**
 * Показать / скрыть пароль
 */
function showPass() {
    var pass_field = $(this).siblings('#reg_pass');

    if (pass_field.attr('type') == 'text') {
        pass_field.attr({ type : 'password' });
        $(this).removeClass('showed');
    } else {
        pass_field.attr({ type : 'text' });
        $(this).addClass('showed');
    }
}
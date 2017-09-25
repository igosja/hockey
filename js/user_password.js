jQuery(document).ready(function () {
    $('#password-old').on('change', function () {
        check_old($(this).val());
    });

    $('#password-new').on('change', function () {
        check_new($(this).val());
    });

    $('#password-confirm').on('change', function () {
        check_confirm($(this).val());
    });

    $('#password-form').on('submit', function () {
        check_old($('#password-old').val());
        check_new($('#password-new').val());
        check_confirm($('#password-confirm').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    });
});

function check_old(password)
{
    var password_input = $('#password-old');
    var password_error = $('.password-old-error');

    if ('' !== password)
    {
        $.ajax({
            data: {password_old: password},
            dataType: 'json',
            method: 'POST',
            url: '/json/user_password.php',
            success: function (data) {
                if (data)
                {
                    password_error.html('');

                    if (password_input.hasClass('has-error'))
                    {
                        password_input.removeClass('has-error');
                    }
                }
                else
                {
                    password_input.addClass('has-error');
                    password_error.html('Пароль указан неверно.');
                }
            }
        });
    }
    else
    {
        password_input.addClass('has-error');
        password_error.html('Введите пароль.');
    }
}

function check_new(password)
{
    var password_input = $('#password-new');
    var password_error = $('.password-new-error');

    if ('' === password)
    {
        password_input.addClass('has-error');
        password_error.html('Введите пароль.');
    }
    else
    {
        password_error.html('');

        if (password_input.hasClass('has-error'))
        {
            password_input.removeClass('has-error');
        }
    }
}

function check_confirm(password)
{
    var password_input = $('#password-confirm');
    var password_error = $('.password-confirm-error');

    if ('' === password)
    {
        password_input.addClass('has-error');
        password_error.html('Введите пароль.');
    }
    else if (password !== $('#password-new').val())
    {
        password_input.addClass('has-error');
        password_error.html('Пароли не совпадают.');
    }
    else
    {
        password_error.html('');

        if (password_input.hasClass('has-error'))
        {
            password_input.removeClass('has-error');
        }
    }
}
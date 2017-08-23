jQuery(document).ready(function () {
    $('#password-password').on('blur', function () {
        check_password($(this).val());
    });

    $('#password-form').on('submit', function () {
        check_password($('#password-password').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    })
});

function check_password(password)
{
    var password_input = $('#password-password');
    var password_error = $('.password-error');

    if ('' !== password)
    {
        password_error.html('');
        password_input.html('');

        if (password_input.hasClass('has-error'))
        {
            password_input.removeClass('has-error');
        }
    }
    else
    {
        password_input.addClass('has-error');
        password_error.html('Введите пароль.');
    }
}
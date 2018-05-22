jQuery(document).ready(function () {
    $('#password-login').on('blur', function () {
        check_login_email();
    });

    $('#password-email').on('blur', function () {
        check_login_email();
    });

    $('#password-form').on('submit', function () {
        check_login_email();

        if ($('input.has-error').length)
        {
            return false;
        }
    })
});

function check_login_email()
{
    var login_input = $('#password-login');
    var email_input = $('#password-email');
    var password_error = $('.password-error');
    var email_error = $('.password-email-error');

    if ('' !== login_input.val() || '' !== email_input.val())
    {
        if ('' === email_input.val() || ('' !== email_input.val() && email_pattern.test(email_input.val())))
        {
            password_error.html('');
            email_error.html('');

            if (login_input.hasClass('has-error'))
            {
                login_input.removeClass('has-error');
            }

            if (email_input.hasClass('has-error'))
            {
                email_input.removeClass('has-error');
            }
        }
        else
        {
            email_input.addClass('has-error');
            email_error.html('Введите корректный email.');
        }
    }
    else
    {
        login_input.addClass('has-error');
        password_error.html('Введите логин/email.');
    }
}
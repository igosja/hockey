jQuery(document).ready(function () {
    $('#signup-login').on('blur', function () {
        check_login($(this).val());
    });

    $('#signup-password').on('blur', function () {
        check_password($(this).val());
    });

    $('#signup-email').on('blur', function () {
        check_email($(this).val());
    });

    $('#signup-form').on('submit', function () {
        check_login($('#signup-login').val());
        check_password($('#signup-password').val());
        check_email($('#signup-email').val());

        if ($('input.has-error').length)
        {
            return false;
        }
    })
});

function check_login(login)
{
    if ('' !== login)
    {
        $.ajax({
            data: {signup_login: login},
            dataType: 'json',
            method: 'POST',
            url: '/json/signup.php',
            success: function (data) {
                var login_input = $('#signup-login');
                var login_error = $('.signup-login-error');

                if (data)
                {
                    login_error.html('');

                    if (login_input.hasClass('has-error'))
                    {
                        login_input.removeClass('has-error');
                    }
                }
                else
                {
                    login_input.addClass('has-error');
                    login_error.html('Такой логин уже занят.');
                }
            }
        });
    }
    else
    {
        $('#signup-login').addClass('has-error');
        $('.signup-login-error').html('Введите логин.');
    }
}

function check_password(password)
{
    var password_input = $('#signup-password');
    var password_error = $('.signup-password-error');

    if ('' !== password)
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
        password_error.html('Введите пароль.');
    }
}

function check_email(email)
{
    if ('' !== email)
    {
        $.ajax({
            data: {signup_email: email},
            dataType: 'json',
            method: 'POST',
            url: '/json/signup.php',
            success: function (data) {
                var email_input = $('#signup-email');
                var email_error = $('.signup-email-error');

                if (data)
                {
                    email_error.html('');

                    if (email_input.hasClass('has-error'))
                    {
                        email_input.removeClass('has-error');
                    }
                }
                else
                {
                    email_input.addClass('has-error');
                    email_error.html('Такой email уже занят.');
                }
            }
        });
    }
    else
    {
        $('#signup-email').addClass('has-error');
        $('.signup-email-error').html('Введите email.');
    }
}
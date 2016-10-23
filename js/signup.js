jQuery(document).ready(function () {
    $('#signup-login').on('change', function () {
        var login = $(this).val();

        if ('' != login)
        {
            $.ajax({
                data: {signup_login: login},
                dataType: 'json',
                method: 'POST',
                url: '/json.php',
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
    });

    $('#signup-password').on('change', function () {
        var password = $(this).val();
        var password_error = $('.signup-password-error');

        if ('' != password)
        {
            password_error.html('');

            if ($(this).hasClass('has-error'))
            {
                $(this).removeClass('has-error');
            }
        }
        else
        {
            $(this).addClass('has-error');
            password_error.html('Введите пароль.');
        }
    });

    $('#signup-email').on('change', function () {
        var email = $(this).val();

        if ('' != email)
        {
            $.ajax({
                data: {signup_email: email},
                dataType: 'json',
                method: 'POST',
                url: '/json.php',
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
    });
});
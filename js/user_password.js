jQuery(document).ready(function () {
    $('#password-old').on('change', function () {
        var password = $(this).val();

        if ('' != password)
        {
            $.ajax({
                data: {password_old: password},
                dataType: 'json',
                method: 'POST',
                url: '/json.php',
                success: function (data) {
                    var password_input = $('#password-old');
                    var password_error = $('.password-old-error');

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
            $(this).addClass('has-error');
            $('.password-old-error').html('Введите пароль.');
        }
    });

    $('#password-new, #password-confirm').on('change', function () {
        var password_new = $('#password-new').val();
        var password_confirm = $('#password-confirm').val();
        var password_error = $('.password-new-error');

        if ('' != password_new && '' != password_confirm && password_confirm != password_new)
        {
            $('#password-new, #password-confirm').addClass('has-error');
            password_error.html('Пароли не совпадают.');
        }
        else
        {
            password_error.html('');

            if ($('#password-new, #password-confirm').hasClass('has-error'))
            {
                $('#password-new, #password-confirm').removeClass('has-error');
            }
        }
    });
});